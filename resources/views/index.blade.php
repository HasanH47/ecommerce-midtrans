@extends('layouts.public.app')

@section('title', 'E-commerce')
@section('style')
    <style>
        .home {
            position: relative;
            height: 60vh;
            background-image: url('{{ asset('assets/img/hero/banner.png') }}');
            background-size: cover;
            background-position: center;
        }

        .box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 10px;
        }

        .card-footer {
            background-color: transparent !important;
        }
    </style>
@endsection
@section('content')
    <section id="home" class="home text-center">
        <div class="box">
            <h1 class="display-4">Selamat Datang di E-commerce</h1>
            <p class="lead">Toko serba ada untuk produk terbaik Anda</p>
        </div>
    </section>

    <section id="product" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Produk Kami</h2>
            <div class="row">
                @if ($products->isNotEmpty())
                    @foreach ($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                    alt="{{ $product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-price">Rp. {{ number_format($product->price, 0, '', '.') }}</p>
                                    <div class="card-footer d-flex align-items-end pt-3 px-0 pb-0 mt-auto ">
                                        <a href="{{ route('product.show', $product->slug) }}"
                                            class="btn btn-primary shadow-0 me-1">Detail</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">Mohon maaf belum ada produk yang tersedia, silahkan cek kembali secara berkala. Terima kasih :)
                    </p>
                @endif
            </div>
            {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
        </div>
    </section>

    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Hubungi Kami</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form>
                        <div class="form-group my-2">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name" placeholder="Masukkan nama anda">
                        </div>
                        <div class="form-group my-2">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Masukkan email anda">
                        </div>
                        <div class="form-group my-2">
                            <label for="message">Pesan</label>
                            <textarea class="form-control" id="message" rows="4" placeholder="Masukkan pesan anda"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" disabled>Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
