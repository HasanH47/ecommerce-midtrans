@extends('layouts.public.app')

@section('title', 'Detail Pembayaran')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Detail Pembayaran</h2>
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
                <h5>Nama: {{ $order->customerDetails->name }}</h5>
                <h5>Total: Rp. {{ number_format($order->total_price, 0, ',', '.') }}</h5>
                <h5>Status Pembayaran:
                    <span
                        class="badge @if ($order->status == 'completed') bg-success
                        @else
                        bg-danger @endif rounded-pill">{{ $order->status == 'completed' ? 'Selesai' : 'Dibatalkan' }}
                    </span>
                </h5>
                @if ($order->status == 'completed')
                    <h5>Tanggal Pembayaran: {{ $order->updated_at->format('d M Y, H:i') }}</h5>
                @else
                    <h5>Tanggal Pembatalan: {{ $order->updated_at->format('d M Y, H:i') }}</h5>
                @endif
            </div>
        </div>
    </div>
@endsection
