@extends('layouts.admin')

@section('title', 'Akun Saya')

@section('content')
    <div class="admin-page-head">
        <div>
            <h1>Akun Saya</h1>
            <p>Perbarui data diri dan kata sandi akun admin.</p>
        </div>
    </div>

    @include('admin.partials.errors')

    <form method="POST" action="{{ route('profile.update') }}" class="admin-form card card-body" style="margin-bottom: 24px;">
        @csrf
        @method('PATCH')
        <h2 class="admin-section-title" style="margin-top:0;">Data Diri</h2>
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label" for="name">Nama</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-admin-primary">Simpan Data Diri</button>
            @if (session('status') === 'profile-updated')
                <span class="form-saved">Tersimpan.</span>
            @endif
        </div>
    </form>

    <form method="POST" action="{{ route('password.update') }}" class="admin-form card card-body">
        @csrf
        @method('PUT')
        <h2 class="admin-section-title" style="margin-top:0;">Kata Sandi</h2>
        @error('current_password', 'updatePassword')
            <div class="flash flash-error">{{ $message }}</div>
        @enderror
        <div class="form-row-2">
            <div class="form-group">
                <label class="form-label" for="current_password">Kata Sandi Saat Ini</label>
                <input class="form-control" type="password" id="current_password" name="current_password" autocomplete="current-password" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi Baru</label>
                <input class="form-control" type="password" id="password" name="password" autocomplete="new-password" required>
            </div>
        </div>
        <div class="form-group">
            <label class="form-label" for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
            <input class="form-control" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-admin-primary">Perbarui Kata Sandi</button>
            @if (session('status') === 'password-updated')
                <span class="form-saved">Kata sandi diperbarui.</span>
            @endif
        </div>
    </form>
@endsection
