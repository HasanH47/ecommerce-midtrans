@extends('layouts.admin.app')

@section('title', 'Kelola Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Produk</h1>
        <a href="{{ route('product.create') }}" class="btn btn-primary">Tambah Produk Baru</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($products->isNotEmpty())
                @foreach ($products as $index => $product)
                    <tr>
                        <td>{{ $products->firstItem() + $index }}</td>
                        <td><img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="img-fluid rounded" width="100" height="100"></td>
                        <td>{{ $product->name }}</td>
                        <td>Rp. {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>
                            <a href="{{ route('product.show', $product->slug) }}" class="btn btn-primary btn-sm">Detail</a>
                            <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                class="d-inline-block"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">Belum terdapat produk yang ditambahkan, silahkan tambahkan produk
                        di menu "Tambah Produk Baru". Terima kasih :)</td>
                </tr>
            @endif
        </tbody>
    </table>
    {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
@endsection
