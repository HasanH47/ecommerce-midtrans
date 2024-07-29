@extends('layouts.public.app')

@section('title', 'Menunggu Pembayaran')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Menunggu Pembayaran</h2>
        <div class="card">
            <div class="card-body">
                <h5>Pesanan ID: {{ $order->order_id }}</h5>
                <ul class="list-group mb-3">
                    @foreach ($order->items as $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <a href="{{ route('product.show', $item->product->slug) }}">{{ $item->product->name }}</a>
                                <span class="badge bg-primary rounded-pill ms-2">{{ $item->quantity }}</span>
                            </div>
                            <span>Rp. {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                </ul>
                <h5>Status Pembayaran: <span class="badge bg-warning rounded-pill">{{ $order->status == 'pending' ? 'Menunggu pembayaran' : 'Selesai' }}</span></h5>
                <h5>Total: Rp. {{ number_format($order->total_price, 0, ',', '.') }}</h5>
                <button id="pay-button" class="btn btn-primary mt-3">Bayar Sekarang</button>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script>
        $(document).ready(function() {
            $('#pay-button').click(function() {
                snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) {
                        // console.log('Payment Success:', result);
                        window.location.href =
                            "{{ route('checkout.detail', ['order' => $order->id]) }}";
                    },
                    onPending: function(result) {
                        // console.log('Payment Pending:', result);
                        location.reload();
                    },
                    onError: function(result) {
                        // console.log('Payment Error:', result);
                        location.reload();
                    }
                });
            });
        });
    </script>
@endsection
