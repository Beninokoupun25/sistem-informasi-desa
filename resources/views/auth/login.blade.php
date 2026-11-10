@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="auth-form">
        @csrf

        <h1 class="auth-title">Masuk</h1>
        <p class="auth-sub">Portal pengelola konten desa.</p>

        <div class="form-group">
            <label class="form-label" for="email">Email</label>
            <input class="form-control" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            @error('email')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Kata Sandi</label>
            <input class="form-control" id="password" type="password" name="password" required autocomplete="current-password">
            @error('password')<div class="form-error">{{ $message }}</div>@enderror
        </div>

        <label class="auth-remember" for="remember_me">
            <input id="remember_me" type="checkbox" name="remember">
            <span>Ingat saya</span>
        </label>

        <button type="submit" class="btn-admin-primary btn-admin-block">Masuk</button>

        <a class="auth-link" href="{{ route('password.request') }}">Lupa kata sandi?</a>
    </form>
@endsection
