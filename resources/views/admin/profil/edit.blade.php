@extends('layouts.admin')

@section('title', 'Profil Desa — ' . $desa->nama_desa)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Profil Desa</h1>
            <p>Identitas resmi {{ $desa->nama_desa }} yang tampil di situs publik.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Dashboard</a>
    </div>

    @include('admin.partials.errors')

    <div class="admin-form-section">
        <h2 class="admin-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Ubah Identitas Desa
        </h2>

        <form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label class="admin-form-label" for="alamat">Alamat Kantor Desa</label>
                    <input class="admin-form-control" type="text" id="alamat" name="alamat"
                           value="{{ old('alamat', $profil?->alamat) }}" placeholder="Contoh: Jl. Raya Desa Sukamaju" required>
                </div>

                <div class="admin-form-row-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="telepon">Telepon</label>
                        <input class="admin-form-control" type="text" id="telepon" name="telepon"
                               value="{{ old('telepon', $profil?->telepon) }}" placeholder="Contoh: 08123456789">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="email">Email</label>
                        <input class="admin-form-control" type="email" id="email" name="email"
                               value="{{ old('email', $profil?->email) }}" placeholder="Contoh: desa@sukamaju.id">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="deskripsi">Deskripsi Singkat Desa</label>
                    <textarea class="admin-form-control" id="deskripsi" name="deskripsi" rows="4"
                              placeholder="Ceritakan sekilas tentang desa ini…">{{ old('deskripsi', $profil?->deskripsi) }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="logo">Logo Desa (Opsional)</label>

                    <div style="margin-bottom: 10px;">
                        @if ($profil?->logo_path)
                            <img src="{{ Storage::url($profil->logo_path) }}" alt="Logo saat ini" class="admin-form-preview">
                        @else
                            <div class="admin-form-preview admin-media-placeholder" style="width:140px;height:100px;">
                                <span style="font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:1px;">Belum ada logo</span>
                            </div>
                        @endif
                    </div>

                    <input class="admin-form-control" type="file" id="logo" name="logo" accept="image/*">
                    <p class="admin-form-hint">PNG/JPG maksimal 2 MB. Kosongkan jika tidak ingin mengganti logo.</p>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="btn-admin-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;margin-right:6px;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    Simpan Profil
                </button>
                <a href="{{ route('admin.dashboard') }}" class="btn-admin-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection
