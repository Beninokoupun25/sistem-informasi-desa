@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
    <section class="hero-welcome">

        <div class="hero-sky">
            @if ($desa->profil?->logo_path)
                <img src="{{ Storage::url($desa->profil->logo_path) }}" alt="Logo {{ $desa->nama_desa }}" class="hero-logo">
            @endif
            <span class="hero-badge"><span class="pulse-dot" aria-hidden="true"></span>Sistem Informasi Desa Digital</span>
            <h1 class="hero-title">Selamat Datang<br>di <span class="hero-accent"><em>{{ $desa->nama_desa }}</em></span></h1>
            <p class="hero-tagline">
                <strong>{{ $desa->kecamatan }} · {{ $desa->kabupaten }} · {{ $desa->provinsi }}</strong><br>
                @if ($desa->profil?->deskripsi)
                    {{ Str::limit($desa->profil->deskripsi, 140) }}
                @endif
            </p>
            <div class="hero-cta">
                <a href="#tentang" class="btn-welcome">Jelajahi Desa <span aria-hidden="true">→</span></a>
                <a href="{{ route('visi-misi') }}" class="btn-welcome btn-ghost">Visi &amp; Misi Kami</a>
            </div>
            @if ($statistikTerbaru)
                <dl class="hero-meta">
                    <div><dt>Penduduk</dt><dd>{{ number_format($statistikTerbaru->jumlah_penduduk, 0, ',', '.') }}</dd></div>
                    <div><dt>Kepala Keluarga</dt><dd>{{ number_format($statistikTerbaru->jumlah_kk, 0, ',', '.') }}</dd></div>
                    <div><dt>Dusun</dt><dd>{{ number_format($statistikTerbaru->jumlah_dusun, 0, ',', '.') }}</dd></div>
                </dl>
            @endif
        </div>

        <a href="#tentang" class="hero-scroll">Gulir<span aria-hidden="true">&#8595;</span></a>
    </section>

    {{-- 01 · Tentang --}}
    <section class="section section-about" id="tentang">
        <div class="container editorial">
            <div class="editorial-head">
                <span class="eyebrow">01 — Tentang Desa</span>
                <h2 class="editorial-title">Kenali <em>{{ $desa->nama_desa }}</em> lebih dekat.</h2>
                <p class="editorial-lede">
                    @if ($desa->profil?->deskripsi)
                        {{ $desa->profil->deskripsi }}
                    @else
                        Portal resmi pemerintahan desa — profil, sejarah, visi &amp; misi, wilayah, perangkat, statistik, fasilitas, dan galeri dalam satu tempat.
                    @endif
                </p>
                <a href="{{ route('sejarah') }}" class="link-arrow">Baca sejarahnya <span aria-hidden="true">→</span></a>
            </div>
            <aside class="editorial-panel card">
                <h3 class="panel-title">Identitas</h3>
                <ul class="profil-list profil-list--lg">
                    <li><span class="label">Alamat</span><span>{{ $desa->profil?->alamat ?? '-' }}</span></li>
                    <li><span class="label">Telepon</span><span>{{ $desa->profil?->telepon ?? '-' }}</span></li>
                    <li><span class="label">Email</span><span>{{ $desa->profil?->email ?? '-' }}</span></li>
                    <li><span class="label">Kecamatan</span><span>{{ $desa->kecamatan }}</span></li>
                    <li><span class="label">Kabupaten</span><span>{{ $desa->kabupaten }}</span></li>
                    <li><span class="label">Status</span><span class="badge">{{ $desa->status }}</span></li>
                </ul>
            </aside>
        </div>
    </section>

    {{-- 02 · Statistik (dark band) --}}
    @if ($statistikTerbaru)
        <section class="band-dark">
            <div class="container">
                <div class="band-dark-head">
                    <span class="eyebrow eyebrow--mint">02 — Statistik Desa</span>
                    <h2>{{ $statistikTerbaru->tahun }} <span class="ff-serif">dalam angka.</span></h2>
                    <a href="{{ route('statistik') }}" class="link-arrow link-arrow--mint">Statistik lengkap <span aria-hidden="true">→</span></a>
                </div>
                <dl class="big-stats">
                    <div class="big-stat"><dt>Penduduk</dt><dd>{{ number_format($statistikTerbaru->jumlah_penduduk, 0, ',', '.') }}</dd></div>
                    <div class="big-stat"><dt>Laki-laki</dt><dd>{{ number_format($statistikTerbaru->laki_laki, 0, ',', '.') }}</dd></div>
                    <div class="big-stat"><dt>Perempuan</dt><dd>{{ number_format($statistikTerbaru->perempuan, 0, ',', '.') }}</dd></div>
                    <div class="big-stat"><dt>Kepala Keluarga</dt><dd>{{ number_format($statistikTerbaru->jumlah_kk, 0, ',', '.') }}</dd></div>
                    <div class="big-stat"><dt>Dusun</dt><dd>{{ number_format($statistikTerbaru->jumlah_dusun, 0, ',', '.') }}</dd></div>
                </dl>
            </div>
        </section>
    @endif

    {{-- 03 · Visi & Misi --}}
    <section class="section">
        <div class="container">
            <span class="eyebrow">03 — Arah Desa</span>
            <h2 class="section-title section-title--lg">Visi &amp; Misi</h2>
            <div class="visi-misi-grid">
                <div class="visi-panel">
                    <span class="visi-quote" aria-hidden="true">&ldquo;</span>
                    @if ($visi)
                        <p class="visi-quote-text">{{ $visi->isi }}</p>
                    @else
                        <p class="visi-quote-text">Visi desa belum tersedia.</p>
                    @endif
                    <span class="visi-panel-foot">Visi {{ $desa->nama_desa }}</span>
                </div>
                <ol class="misi-list">
                    @forelse ($misi as $i => $butir)
                        <li class="misi-item">
                            <span class="misi-index">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <span>{{ $butir->isi }}</span>
                        </li>
                    @empty
                        <li class="misi-item"><span class="misi-index">—</span><span>Misi belum tersedia.</span></li>
                    @endforelse
                    <li class="misi-more"><a href="{{ route('visi-misi') }}" class="link-arrow">Selengkapnya <span aria-hidden="true">→</span></a></li>
                </ol>
            </div>
        </div>
    </section>

    {{-- 04 · Fasilitas unggulan --}}
    @if ($fasilitasUnggulan->isNotEmpty())
        <section class="section section-tint">
            <div class="container">
                <span class="eyebrow">04 — Fasilitas Desa</span>
                <div class="section-split">
                    <h2 class="section-title section-title--lg" style="margin:0;">Ruang publik<br>yang dibanggakan.</h2>
                    <a href="{{ route('fasilitas') }}" class="link-arrow">Lihat semua fasilitas <span aria-hidden="true">→</span></a>
                </div>
                <div class="fasilitas-overlay-grid">
                    @foreach ($fasilitasUnggulan as $item)
                        <article class="overlay-card {{ ! $item->foto_path ? 'overlay-card--plain' : '' }}">
                            @if ($item->foto_path)
                                <img src="{{ Storage::url($item->foto_path) }}" alt="{{ $item->nama }}" loading="lazy">
                            @else
                                <div class="overlay-card-fallback" aria-hidden="true">{{ Str::substr($item->nama, 0, 1) }}</div>
                            @endif
                            <div class="overlay-card-body">
                                <span class="badge badge-terang">{{ $item->kategori }}</span>
                                <h3>{{ $item->nama }}</h3>
                                @if ($item->alamat)<p>{{ $item->alamat }}</p>@endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="cta-band">
        <div class="container cta-inner">
            <h2 class="cta-title">Pintu <em>{{ $desa->nama_desa }}</em> selalu terbuka.</h2>
            <p>Temui kami di kantor desa — atau jelajahi seluruh informasi, statistik, dan galeri melalui portal ini.</p>
            <div class="hero-cta">
                <a href="{{ route('perangkat') }}" class="btn-welcome">Kenali Perangkat Desa</a>
                <a href="{{ route('media') }}" class="btn-welcome btn-ghost">Lihat Galeri</a>
            </div>
        </div>
    </section>
@endsection
