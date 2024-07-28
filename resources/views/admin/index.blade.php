@extends('layouts.admin.app')

@section('title', 'Dasbor')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Selamat Datang di Dasbor Admin</h1>

        <div class="row">
            <div class="col-md-3">
                <div class="card mb-3">
                    <div class="card-header">Jumlah Produk</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $productCount }}</h5>
                        <p class="card-text">Total produk yang tersedia di toko.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
