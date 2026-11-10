@extends('layouts.admin')

@section('title', 'Tambah Fasilitas — ' . $desa->nama_desa)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Tambah Fasilitas</h1>
            <p>Masukkan data fasilitas publik di {{ $desa->nama_desa }}.</p>
        </div>
        <a href="{{ route('admin.fasilitas.index') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Daftar</a>
    </div>

    @include('admin.partials.errors')

    <div class="admin-form-section">
        <h2 class="admin-section-title">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            Data Fasilitas
        </h2>

        <form method="POST" action="{{ route('admin.fasilitas.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="admin-form-grid">
                <div class="admin-form-row-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="nama">Nama Fasilitas</label>
                        <input class="admin-form-control" type="text" id="nama" name="nama"
                               value="{{ old('nama') }}" placeholder="Contoh: SD Negeri Sukamaju" required maxlength="255">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="kategori">Kategori</label>
                        <input class="admin-form-control" type="text" id="kategori" name="kategori" list="kategori-list"
                               value="{{ old('kategori') }}" placeholder="Contoh: Pendidikan" required maxlength="255">
                        <datalist id="kategori-list">
                            <option value="Pendidikan"></option>
                            <option value="Kesehatan"></option>
                            <option value="Peribadatan"></option>
                            <option value="Pemerintahan"></option>
                            <option value="Ekonomi"></option>
                            <option value="Olahraga"></option>
                            <option value="Sosial Budaya"></option>
                        </datalist>
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="alamat">Alamat (Opsional)</label>
                    <input class="admin-form-control" type="text" id="alamat" name="alamat"
                           value="{{ old('alamat') }}" placeholder="Contoh: Jl. Raya Desa Sukamaju" maxlength="255">
                </div>

                <div class="admin-form-row-2">
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="latitude">Latitude (Opsional)</label>
                        <input class="admin-form-control" type="number" step="any" id="latitude" name="latitude"
                               value="{{ old('latitude') }}" min="-90" max="90" placeholder="-6.123456">
                    </div>
                    <div class="admin-form-group">
                        <label class="admin-form-label" for="longitude">Longitude (Opsional)</label>
                        <input class="admin-form-control" type="number" step="any" id="longitude" name="longitude"
                               value="{{ old('longitude') }}" min="-180" max="180" placeholder="106.123456">
                    </div>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="deskripsi">Deskripsi (Opsional)</label>
                    <textarea class="admin-form-control" id="deskripsi" name="deskripsi" rows="3"
                              placeholder="Keterangan tambahan tentang fasilitas ini…">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="admin-form-group">
                    <label class="admin-form-label" for="foto">Foto Fasilitas (Opsional)</label>

                    <div style="margin-bottom: 10px;">
                        @if (! empty(old('foto_path', $item->foto_path ?? null)))
                            <img src="{{ Storage::url(old('foto_path', $item->foto_path ?? null)) }}" alt="Foto saat ini" class="admin-form-preview form-preview--wide">
                        @else
                            <div class="admin-form-preview admin-media-placeholder" style="width:100%;height:150px;">
                                <span style="font-size:10px; font-weight:600; text-transform:uppercase; letter-spacing:1px;">Belum ada foto</span>
                            </div>
                        @endif
                    </div>

                    <input class="admin-form-control" type="file" id="foto" name="foto" accept="image/*">
                    <p class="admin-form-hint">PNG/JPG maksimal 2 MB.</p>
                </div>
            </div>

            <div class="admin-form-actions">
                <button type="submit" class="btn-admin-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;margin-right:6px;"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
                    Simpan Fasilitas
                </button>
                <a href="{{ route('admin.fasilitas.index') }}" class="btn-admin-ghost">Batal</a>
            </div>
        </form>
    </div>
@endsection
