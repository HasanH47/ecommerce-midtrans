@extends('layouts.public.app')

@section('title', $product->name)

@section('content')
    <section id="product-detail" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded shadow-sm"
                        alt="{{ $product->name }}">
                </div>
                <div class="col-md-6">
                    <h1 class="display-4">{{ $product->name }}</h1>
                    <h2 class="text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                    <p class="lead">{{ $product->description }}</p>
                    <p class="text-muted">Stok: {{ $product->stock }}</p>
                    @auth
                        @if (auth()->user()->role == 'admin')
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning"><i
                                    class="bi bi-pencil"></i> Edit</a>
                        @else
                            <form action="{{ route('carts.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="mb-3 d-flex align-items-center">
                                    <label for="quantity" class="form-label me-2">Jumlah</label>
                                    <input type="number" name="quantity" id="quantity"
                                        class="form-control form-control-sm me-2 @error('quantity') is-invalid @enderror"
                                        value="{{ old('quantity', 1) }}" min="1" max="{{ $product->stock }}"
                                        style="width: 80px;">
                                    @error('quantity')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary"><i class="bi bi-cart"></i> Tambahkan ke
                                    keranjang</button>
                            </form>
                        @endif
                    @else
                        <div class="alert alert-info" role="alert">
                            <a href="{{ route('login') }}">Masuk</a> untuk menambahkan produk ke keranjang
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </section>
@endsection
