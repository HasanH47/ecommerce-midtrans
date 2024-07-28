@extends('layouts.admin.app')

@section('title', 'Tambah Produk')
@section('style')
    <style>
        .price::-webkit-outer-spin-button,
        .price::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .price {
            -moz-appearance: textfield;
        }
    </style>
@endsection
@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Tambah Produk Baru</h2>
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Produk</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                    value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="priceDisplay" class="form-label">Harga</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" class="price form-control @error('price') is-invalid @enderror" id="priceDisplay"
                        value="{{ old('price') }}" aria-label="Harga" required>
                    <input type="hidden" id="price" name="price" value="{{ old('price') }}">
                    <span class="input-group-text">.00</span>
                    @error('price')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="mb-3">
                <label for="quantity" class="form-label">Kuantitas</label>
                <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity"
                    name="quantity" value="{{ old('quantity') }}" required>
                @error('quantity')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi Produk</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                    rows="3" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Gambar Produk</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                    name="image" required>
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Tambah Produk</button>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#priceDisplay').on('input', function() {
                let value = $(this).val().replace(/[^0-9]/g, '');
                let formattedValue = new Intl.NumberFormat('id-ID').format(value);
                $(this).val(formattedValue);
                $('#price').val(value);
            });
        });
    </script>
@endsection
