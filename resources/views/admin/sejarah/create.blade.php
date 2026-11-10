@extends('layouts.admin')

@section('title', 'Tambah Sejarah — ' . $desa->nama_desa)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Tambah Sejarah</h1>
            <p>Tambahkan entri sejarah baru untuk {{ $desa->nama_desa }}.</p>
        </div>
        <a href="{{ route('admin.sejarah.index') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Daftar</a>
    </div>

    @include('admin.partials.errors')

    <div class="admin-form-section">
        <h2 class="admin-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/></svg>
            Data Entri Sejarah
        </h2>

        <form method="POST" action="{{ route('admin.sejarah.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label class="admin-form-label" for="judul">Judul Bagian Sejarah</label>
                    <input class="admin-form-control" type="text" id="judul" name="judul"
                           value="{{ old('judul') }}" placeholder="Contoh: Asal-usul Nama Desa" required maxlength="255">
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="isi">Konten Sejarah</label>
                    <textarea class="admin-form-control" id="isi" name="isi" rows="6"
                              placeholder="Tulis narasi sejarah bagian ini…" required>{{ old('isi') }}</textarea>
                </div>

                <div class="admin-form-row-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="urutan">Urutan Tampil</label>
                        <input class="admin-form-control" type="number" id="urutan" name="urutan"
                               value="{{ old('urutan', 0) }}" min="0" placeholder="0">
                        <p class="admin-form-hint">Angka lebih kecil tampil di awal.</p>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="foto">Foto Dokumentasi (Opsional)</label>
                        <input class="admin-form-control" type="file" id="foto" name="foto" accept="image/*">
                        <p class="admin-form-hint">PNG/JPG maksimal 2 MB.</p>
                    </div>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="btn-admin-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;margin-right:6px;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    Simpan Entri
                </button>
                <a href="{{ route('admin.sejarah.index') }}" class="btn-admin-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection
