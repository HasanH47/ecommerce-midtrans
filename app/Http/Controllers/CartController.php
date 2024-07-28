<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Rules\MaxQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->with('product')->get();

        $total = $carts->reduce(function ($carry, $cart) {
            return $carry + ($cart->product->price * $cart->quantity);
        }, 0);

        return view('cart.index', compact('carts', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => ['required', 'integer', 'min:1', new MaxQuantity($request->product_id)],
        ]);

        Cart::create([
            'user_id' => Auth::user()->id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('carts.index')->with('success', 'Produk ditambahkan ke keranjang.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();

        $request->validate([
            'quantity' => ['required', 'integer', 'min:1', new MaxQuantity($cart->product_id)],
        ]);

        $quantity = $request->input('quantity');

        if ($quantity <= 0) {
            return redirect()->route('carts.index')->with('error', 'Jumlah tidak valid.');
        }

        $cart->quantity = $quantity;

        if ($cart->quantity <= 0) {
            $cart->delete();
        } else {
            $cart->save();
        }

        return redirect()->route('carts.index')->with('success', 'Keranjang diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart = Cart::where('user_id', Auth::id())->where('id', $id)->firstOrFail();
        $cart->delete();

        return redirect()->route('carts.index')->with('success', 'Produk dihapus dari keranjang.');
    }
}
