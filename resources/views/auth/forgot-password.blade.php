@extends('layouts.guest')

@section('title', 'Lupa Kata Sandi')

@section('content')
    <form method="POST" action="{{ route('password.email') }}" class="auth-form">
        @csrf

        <h1 class="auth-title">Lupa Kata Sandi?</h1>
        <p class="auth-sub">Masukkan email akun Anda; kami kirimkan tautan untuk mengatur kata sandi baru.</p>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <button type="submit" class="btn-admin-primary btn-admin-block">Kirim Tautan Reset</button>

        <a class="auth-link" href="{{ route('login') }}">← Kembali ke halaman masuk</a>
    </form>
@endsection
