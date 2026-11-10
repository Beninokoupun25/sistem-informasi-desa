@extends('layouts.admin')

@section('title', 'Media & Galeri — ' . $desa->nama_desa)

@section('content')
    <div class="admin-page-header">
        <div>
            <h1>Media &amp; Galeri</h1>
            <p>Foto, video, dan dokumen publik {{ $desa->nama_desa }}.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-admin-ghost btn-admin-sm">← Kembali ke Dashboard</a>
    </div>

    @include('admin.partials.errors')

    <div class="admin-card">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-section-title" style="margin:0;">Unggah Media Baru</h2>
                <p style="margin:4px 0 0; font-size:12.5px; color:var(--teks-lembut);">Maksimal 10 MB per berkas.</p>
            </div>
        </div>
        <div class="admin-card-body">
            <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="admin-form-row-2">
                    <div class="admin-form-group" style="flex:1;">
                        <label class="admin-form-label" for="judul">Judul</label>
                        <input class="admin-form-control" type="text" id="judul" name="judul"
                               value="{{ old('judul') }}" placeholder="Contoh: Kegiatan Gotong Royong" required maxlength="255">
                    </div>
                    <div class="admin-form-group" style="max-width:170px;">
                        <label class="admin-form-label" for="jenis">Jenis</label>
                        <select class="admin-form-control" id="jenis" name="jenis" required>
                            <option value="foto" @selected(old('jenis') === 'foto')>Foto</option>
                            <option value="video" @selected(old('jenis') === 'video')>Video</option>
                            <option value="dokumen" @selected(old('jenis') === 'dokumen')>Dokumen</option>
                        </select>
                    </div>
                </div>

                <div class="admin-form-row-2">
                    <div class="admin-form-group" style="flex:1;">
                        <label class="admin-form-label" for="keterangan">Keterangan (Opsional)</label>
                        <input class="admin-form-control" type="text" id="keterangan" name="keterangan"
                               value="{{ old('keterangan') }}" placeholder="Deskripsi singkat tentang media ini">
                    </div>
                    <div class="admin-form-group" style="max-width:220px;">
                        <label class="admin-form-label" for="file">Pilih Berkas</label>
                        <input class="admin-form-control" type="file" id="file" name="file" required>
                        <p class="admin-form-hint">Maks 10 MB.</p>
                    </div>
                </div>

                <div class="admin-form-actions">
                    <button type="submit" class="btn-admin-primary">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" style="width:16px;height:16px;margin-right:6px;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/></svg>
                        Unggah Berkas
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Daftar media --}}
    <div class="admin-card" style="margin-top: 18px;">
        <div class="admin-card-header">
            <div>
                <h2 class="admin-section-title" style="margin:0;">Koleksi Media</h2>
                <p style="margin:4px 0 0; font-size:12.5px; color:var(--teks-lembut);">{{ $items->count() }} berkas tersimpan.</p>
            </div>
        </div>
        <div class="admin-card-body">
            <div class="admin-media-grid">
                @forelse ($items as $item)
                    <div class="admin-media-card">
                        @if ($item->jenis === 'foto' && $item->file_path)
                            <img src="{{ Storage::url($item->file_path) }}" alt="{{ $item->judul }}" class="admin-media-thumb">
                        @else
                            <div class="admin-media-placeholder">
                                <strong>{{ strtoupper(substr($item->jenis, 0, 1)) }}</strong>
                                <small>{{ $item->jenis }}</small>
                            </div>
                        @endif
                        <div class="admin-media-body">
                            <h3>{{ $item->judul }}</h3>
                            @if ($item->keterangan)
                                <p>{{ $item->keterangan }}</p>
                            @endif
                            <div class="admin-media-actions">
                                <a href="{{ Storage::url($item->file_path) }}" target="_blank" rel="noopener" class="btn-admin-ghost btn-admin-sm">Buka</a>
                                <form method="POST" action="{{ route('admin.media.destroy', $item) }}" onsubmit="return confirm('Yakin ingin menghapus media ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-danger btn-admin-sm">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="admin-empty" style="grid-column: 1 / -1;">
                        <div class="icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                        <strong>Belum ada media diunggah</strong>
                        <p class="admin-form-hint" style="margin-top:8px;">Mulai dengan mengunggah foto, video, atau dokumen publik desa.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
