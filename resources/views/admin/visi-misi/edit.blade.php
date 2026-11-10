@extends('layouts.admin')

@section('title', 'Edit ' . strtoupper($visiMisi->jenis) — ' . $desa->nama_desa)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Edit {{ ucfirst($visiMisi->jenis) }}</h1>
            <p>Mengubah {{ $visiMisi->jenis }} pada {{ $desa->nama_desa }}.</p>
        </div>
        <a href="{{ route('admin.visi-misi.index') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Daftar</a>
    </div>

    @include('admin.partials.errors')

    <div class="admin-form-section">
        <h2 class="admin-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/></svg>
            Perbarui {{ strtoupper($visiMisi->jenis) }}
        </h2>

        <form method="POST" action="{{ route('admin.visi-misi.update', $visiMisi) }}">
            @csrf
            @method('PUT')

            <div class="admin-form-grid">
                <div class="admin-form-group">
                    <label class="admin-form-label" for="jenis">Jenis</label>
                    <select class="admin-form-control" id="jenis" name="jenis" required>
                        <option value="visi" {{ old('jenis', $visiMisi->jenis) === 'visi' ? 'selected' : '' }}>Visi</option>
                        <option value="misi" {{ old('jenis', $visiMisi->jenis) === 'misi' ? 'selected' : '' }}>Misi</option>
                    </select>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="isi">Isi {{ strtoupper($visiMisi->jenis) }}</label>
                    <textarea class="admin-form-control" id="isi" name="isi" rows="5"
                              required>{{ old('isi', $visiMisi->isi) }}</textarea>
                </div>

                <div class="admin-form-group" style="max-width:180px;">
                    <label class="admin-form-label" for="urutan">Urutan</label>
                    <input class="admin-form-control" type="number" id="urutan" name="urutan"
                           value="{{ old('urutan', $visiMisi->urutan) }}" min="0">
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="btn-admin-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;margin-right:6px;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.visi-misi.index') }}" class="btn-admin-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection
