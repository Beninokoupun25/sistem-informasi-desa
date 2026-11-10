@extends('layouts.app')

@section('title', 'Sejarah Desa')

@section('content')
    <header class="page-header">
        <div class="container">
            <span class="eyebrow eyebrow--mint">Warisan &amp; Asal-usul</span>
            <h1 class="page-title">Sejarah<br><em>{{ $desa->nama_desa }}</em></h1>
            <p class="page-lede">Dari mana desa ini berdiri, siapa yang membangunnya, dan bagaimana ia tumbuh hingga hari ini.</p>
        </div>
    </header>

    <section class="section">
        <div class="container sejarah-layout">
            <aside class="sejarah-rail">
                <span class="eyebrow">Linimasa</span>
                <p class="rail-note">Bab demi bab perjalanan {{ $desa->nama_desa }}, dari yang paling awal hingga yang terbaru.</p>
                <a href="{{ route('beranda') }}" class="link-arrow">Kembali ke beranda <span aria-hidden="true">→</span></a>
            </aside>

            <div>
                @if ($sejarah->isEmpty())
                    <p class="empty-state">Konten sejarah desa belum tersedia.</p>
                @else
                    <div class="timeline">
                        @foreach ($sejarah as $i => $bagian)
                            <article class="timeline-item">
                                <span class="timeline-index">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <div class="timeline-body card">
                                    <h2>{{ $bagian->judul }}</h2>
                                    <p style="white-space: pre-line;">{{ $bagian->isi }}</p>
                                    @if ($bagian->foto_path)
                                        <img src="{{ Storage::url($bagian->foto_path) }}" alt="{{ $bagian->judul }}" class="timeline-foto" loading="lazy">
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
