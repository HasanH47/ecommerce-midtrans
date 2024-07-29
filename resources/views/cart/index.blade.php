@extends('layouts.public.app')

@section('title', 'Keranjang')

@section('content')
    <section id="cart" class="py-5">
        <div class="container">
            <h1 class="display-4 mb-4">Keranjang Belanja</h1>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($carts->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($carts as $cart)
                                <tr>
                                    <td class="text-center">
                                        <img src="{{ asset('storage/' . $cart->product->image) }}" class="img-fluid"
                                            style="max-height: 100px;" alt="{{ $cart->product->name }}">
                                    </td>
                                    <td><a
                                            href="{{ route('product.show', $cart->product->slug) }}">{{ $cart->product->name }}</a>
                                    </td>
                                    <td>Rp {{ number_format($cart->product->price, 0, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('carts.update', $cart->id) }}" method="POST"
                                            class="d-flex flex-column align-items-start">
                                            @csrf
                                            @method('PATCH')
                                            <div class="d-flex">
                                                <input type="number" name="quantity"
                                                    class="form-control form-control-sm me-2 @error('quantity') is-invalid @enderror"
                                                    value="{{ $cart->quantity }}" min="1" style="width: 80px;">
                                                <button type="submit" class="btn btn-primary btn-sm">Ubah</button>
                                            </div>
                                            @error('quantity')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </form>
                                    </td>
                                    <td>Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('carts.destroy', $cart->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" class="text-right">Total</th>
                                <th colspan="2">Rp {{ number_format($total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="text-right">
                    <a href="{{ route('checkout.show') }}" class="btn btn-primary">Checkout</a>
                </div>
            @else
                <div class="alert alert-info" role="alert">
                    Keranjang belanja Anda kosong, silahkan <a href="{{ url('/#product') }}">belanja</a> terlebih dahulu.
                    Terima kasih :)
                </div>
            @endif
        </div>
    </section>
@endsection
