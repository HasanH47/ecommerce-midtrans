<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CustomerDetails;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');
    }

    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->get();
        return view('checkouts.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->status == 'pending') {
            return redirect()->route('checkout.waiting', ['order' => $order->id]);
        }

        return view('checkouts.show', compact('order'));
    }

    public function showCheckout()
    {
        $cartItems = Cart::where('user_id', Auth::user()->id)->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('home');
        } else {
            $totalPrice = $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            });
        }

        return view('checkouts.checkout', compact('cartItems', 'totalPrice'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        $order_id = 'ORD-' . date('Ymd') . '-' . Str::upper(Str::random(8));

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        $totalPrice = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'order_id' => $order_id,
            'status' => 'pending',
            'total_price' => $totalPrice,
        ]);

        CustomerDetails::create([
            'order_id' => $order->id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $cartItems = Cart::where('user_id', Auth::user()->id)->with('product')->get();
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        Cart::where('user_id', Auth::user()->id)->delete();

        return redirect()->route('checkout.waiting', ['order' => $order->id]);
    }

    public function showWaiting(Order $order)
    {
        if ($order->status == 'completed' || $order->status == 'cancelled') {
            return redirect()->route('checkout.detail', ['order' => $order->id]);
        } else {
            $order = $order->load('items.product', 'customerDetails');

            if (!$order->snap_token) {
                $itemDetails = $order->items->map(function ($item) {
                    return [
                        'id' => 'PRD-' . $item->id,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'name' => $item->product->name,
                    ];
                });

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_id,
                        'gross_amount' => $order->total_price,
                    ],
                    'customer_details' => [
                        'first_name' => $order->customerDetails->name,
                        'email' => $order->customerDetails->email,
                        'phone' => $order->customerDetails->phone,
                        // 'billing_address' => $order->customerDetails->address,
                    ],
                    'item_details' => $itemDetails->toArray(),
                    // 'shipping_address' => [
                    //     'first_name' => $order->customerDetails->name,
                    //     'email' => $order->customerDetails->email,
                    //     'address' => $order->customerDetails->address,
                    //     'phone' => $order->customerDetails->phone,
                    // ],
                    'payment_type' => 'bank_transfer',
                    'enabled_payments' => [
                        'bca_va',
                        'bni_va',
                        'bri_va',
                    ],
                ];

                $snapToken = Snap::getSnapToken($params);

                $order->snap_token = $snapToken;
                $order->save();
            } else {
                $snapToken = $order->snap_token;
            }
        }

        return view('checkouts.waiting', compact('order', 'snapToken'));
    }

    public function handleNotification(Request $request)
    {
        $notif = new Notification();

        $transaction = $notif->transaction_status;
        $order_id = $notif->order_id;

        $order = Order::where('order_id', $order_id)->first();

        if ($transaction == 'capture' || $transaction == 'settlement') {
            $order->update(['status' => 'completed']);

            foreach ($order->items as $item) {
                $product = $item->product;
                $product->stock -= $item->quantity;
                $product->save();
            }
        } else if ($transaction == 'pending') {
            $order->update(['status' => 'pending']);
        } else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
            $order->update(['status' => 'cancelled']);
        }

        return response()->json(['status' => 'ok']);
    }
}
