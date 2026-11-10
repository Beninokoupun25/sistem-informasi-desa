@extends('layouts.admin')

@section('title', 'Edit Sejarah — ' . $sejarah->judul)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Edit Sejarah</h1>
            <p>Mengubah entri "{{ $sejarah->judul }}" pada {{ $desa->nama_desa }}.</p>
        </div>
        <a href="{{ route('admin.sejarah.index') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Daftar</a>
    </div>

    @include('admin.partials.errors')

    <div class="admin-form-section">
        <h2 class="admin-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/></svg>
            Perbarui Entri Sejarah
        </h2>

        <form method="POST" action="{{ route('admin.sejarah.update', $sejarah) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label class="admin-form-label" for="judul">Judul Bagian Sejarah</label>
                    <input class="admin-form-control" type="text" id="judul" name="judul"
                           value="{{ old('judul', $sejarah->judul) }}" required maxlength="255">
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="isi">Konten Sejarah</label>
                    <textarea class="admin-form-control" id="isi" name="isi" rows="6"
                              required>{{ old('isi', $sejarah->isi) }}</textarea>
                </div>

                <div class="admin-form-row-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="urutan">Urutan Tampil</label>
                        <input class="admin-form-control" type="number" id="urutan" name="urutan"
                               value="{{ old('urutan', $sejarah->urutan) }}" min="0">
                        <p class="admin-form-hint">Angka lebih kecil tampil di awal.</p>
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="foto">Ganti Foto Dokumentasi (Opsional)</label>

                        <div style="margin-bottom: 10px;">
                            @if ($sejarah->foto_path)
                                <img src="{{ Storage::url($sejarah->foto_path) }}" alt="Foto saat ini" class="admin-form-preview">
                            @else
                                <div class="admin-form-preview admin-media-placeholder" style="width:140px;height:100px;">
                                    <span style="font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:1px;">Belum ada foto</span>
                                </div>
                            @endif
                        </div>

                        <input class="admin-form-control" type="file" id="foto" name="foto" accept="image/*">
                        <p class="admin-form-hint">PNG/JPG maksimal 2 MB. Kosongkan jika tidak ingin mengganti.</p>
                    </div>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="btn-admin-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;margin-right:6px;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.sejarah.index') }}" class="btn-admin-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection
