@extends('layouts.guest')

@section('title', 'Atur Kata Sandi Baru')

@section('content')
    <form method="POST" action="{{ route('password.store') }}" class="auth-form">
        @csrf

        <h1 class="auth-title">Kata Sandi Baru</h1>
        <p class="auth-sub">Masukkan email dan kata sandi baru Anda.</p>

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input class="form-control" id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Kata Sandi Baru</label>
            <input class="form-control" id="password" type="password" name="password" required autocomplete="new-password">
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi</label>
            <input class="form-control" id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn-admin-primary btn-admin-block">Simpan Kata Sandi</button>
    </form>
@endsection
