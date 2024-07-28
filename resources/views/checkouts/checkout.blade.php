@extends('layouts.public.app')

@section('title', 'Checkout')

@section('content')
    <div class="container my-5">
        <h2 class="mb-4">Checkout</h2>
        <form method="POST" action="{{ route('checkout.process') }}">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="phone">Nomor Telepon</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                            name="phone" value="{{ old('phone') }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="address">Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                            required>{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Lanjutkan</button>
                </div>
                <div class="col-md-6">
                    <h4>Ringkasan Pesanan</h4>
                    <ul class="list-group mb-3">
                        @foreach ($cartItems as $item)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="me-2">{{ $item->product->name }}</span>
                                    <span class="badge bg-primary rounded-pill">{{ $item->quantity }}</span>
                                </div>
                                <span>Rp. {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <h5>Total: Rp. {{ number_format($totalPrice, 0, ',', '.') }}</h5>
                </div>
            </div>
        </form>
    </div>
@endsection
