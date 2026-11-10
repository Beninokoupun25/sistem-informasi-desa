@extends('layouts.app')

@section('title', 'Galeri Media')

@section('content')
    <header class="page-header">
        <div class="container">
            <span class="eyebrow eyebrow--mint">Dokumentasi</span>
            <h1 class="page-title">Galeri<br><em>{{ $desa->nama_desa }}</em></h1>
            <p class="page-lede">Jejak kegiatan, kabar, dan berkas publik — direkam untuk dikenang dan dibagi.</p>
        </div>
    </header>

    <section class="section">
        <div class="container">
            @if ($media->isEmpty())
                <p class="empty-state">Galeri media desa belum tersedia.</p>
            @else
                <div class="masonry">
                    @foreach ($media as $berkas)
                        <figure class="masonry-item">
                            @if ($berkas->jenis === 'foto')
                                <a href="{{ Storage::url($berkas->file_path) }}" target="_blank" rel="noopener" class="masonry-link">
                                    <img src="{{ Storage::url($berkas->file_path) }}" alt="{{ $berkas->judul }}" loading="lazy">
                                </a>
                            @else
                                <div class="media-placeholder">
                                    <strong>{{ strtoupper($berkas->jenis) }}</strong>
                                    <small>Berkas {{ $berkas->jenis }} desa</small>
                                </div>
                            @endif
                            <figcaption class="masonry-caption">
                                <span class="badge {{ $berkas->jenis === 'foto' ? '' : ($berkas->jenis === 'video' ? 'badge-emerald' : 'badge-abu') }}">{{ $berkas->jenis }}</span>
                                <h2>{{ $berkas->judul }}</h2>
                                @if ($berkas->keterangan)
                                    <p>{{ $berkas->keterangan }}</p>
                                @endif
                                <a href="{{ Storage::url($berkas->file_path) }}" target="_blank" rel="noopener" class="link-arrow">Buka berkas <span aria-hidden="true">→</span></a>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
