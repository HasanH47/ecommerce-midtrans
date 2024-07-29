@extends('layouts.public.app')

@section('title', 'Daftar Transaksi')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Daftar Transaksi</h2>
        @if ($orders->isNotEmpty())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Pesanan</th>
                        <th>Nama</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->customerDetails->name }}</td>
                            <td>Rp. {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td><span
                                    class="badge 
                                @if ($order->status == 'pending') bg-warning 
                                @elseif ($order->status == 'completed') 
                                    bg-success 
                                @else 
                                    bg-danger @endif 
                                rounded-pill">
                                    {{ $order->status == 'completed' ? 'Selesai' : ($order->status == 'pending' ? 'Menunggu' : 'Dibatalkan') }}
                                </span>
                            </td>
                            <td>
                                @if ($order->status == 'pending')
                                    <a href="{{ route('checkout.waiting', ['order' => $order->id]) }}"
                                        class="btn btn-info">Bayar
                                        Sekarang</a>
                                @elseif ($order->status == 'completed' || $order->status == 'cancelled')
                                    <a href="{{ route('checkout.detail', ['order' => $order->id]) }}"
                                        class="btn btn-secondary">Detail</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info" role="alert">
                Anda belum melakukan transaksi, silahkan <a href="{{ url('/#product') }}">belanja</a> terlebih dahulu.
                Terima kasih :)
            </div>
        @endif
    </div>
@endsection
