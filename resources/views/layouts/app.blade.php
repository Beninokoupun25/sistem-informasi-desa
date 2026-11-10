<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Sistem Informasi {{ $desa->nama_desa ?? 'Desa' }}">
    <title>@yield('title', 'Beranda') — {{ $desa->nama_desa ?? 'Sistem Informasi Desa' }}</title>
    @if (! empty($desa?->profil?->logo_path))
        <link rel="icon" href="{{ Storage::url($desa->profil->logo_path) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..900;1,9..144,300..900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <a class="skip-link" href="#main">Lewati ke konten utama</a>

    <div class="topbar" aria-hidden="true">
        <div class="container topbar-inner">
            <span class="topbar-kiri">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 21s7-5.4 7-11a7 7 0 1 0-14 0c0 5.6 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                {{ $desa->kecamatan ?? 'Desa' }}, {{ $desa->kabupaten ?? '' }}{{ $desa->provinsi ? ' — ' . $desa->provinsi : '' }}
            </span>
            <span class="topbar-kanan">
                @if (! empty($desa?->profil?->telepon))
                    <a href="tel:{{ $desa->profil->telepon }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a12 12 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A17 17 0 0 1 3 6a2 2 0 0 1 2-2Z"/></svg>
                        {{ $desa->profil->telepon }}
                    </a>
                @endif
                @if (! empty($desa?->profil?->email))
                    <a href="mailto:{{ $desa->profil->email }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 6h16v12H4z"/><path d="m4 7 8 6 8-6"/></svg>
                        {{ $desa->profil->email }}
                    </a>
                @endif
            </span>
        </div>
    </div>

    <header class="site-header" id="siteHeader">
        <div class="container header-inner">
            <a class="brand" href="{{ route('beranda') }}" aria-label="{{ $desa->nama_desa ?? 'Beranda' }} — Beranda">
                @if (! empty($desa?->profil?->logo_path))
                    <img class="brand__mark" src="{{ Storage::url($desa->profil->logo_path) }}" alt="" aria-hidden="true">
                @else
                    <span class="brand__mark brand__mark--text" aria-hidden="true">{{ Str::substr($desa->nama_desa ?? 'D', 0, 1) }}</span>
                @endif
                <span class="brand__text">
                    <strong>{{ $desa->nama_desa ?? 'Sistem Informasi Desa' }}</strong>
                    <small>Sistem Informasi Desa Digital</small>
                </span>
            </a>

            <nav id="menu-utama" class="site-nav" aria-label="Menu utama">
                <a href="{{ route('beranda') }}" class="{{ request()->routeIs('beranda') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 10.5 12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M9.5 21v-6h5v6"/></svg>Beranda</a>
                <a href="{{ route('sejarah') }}" class="{{ request()->routeIs('sejarah') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/></svg>Sejarah</a>
                <a href="{{ route('visi-misi') }}" class="{{ request()->routeIs('visi-misi') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="5"/><circle cx="12" cy="12" r="1.2" fill="currentColor" stroke="none"/></svg>Visi &amp; Misi</a>
                <a href="{{ route('wilayah') }}" class="{{ request()->routeIs('wilayah') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 21s7-5.4 7-11a7 7 0 1 0-14 0c0 5.6 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>Wilayah</a>
                <a href="{{ route('perangkat') }}" class="{{ request()->routeIs('perangkat') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="9" cy="8" r="3.5"/><path d="M3.5 20a5.5 5.5 0 0 1 11 0"/><circle cx="17.5" cy="9.5" r="2.5"/><path d="M16 14.6a4.5 4.5 0 0 1 4.5 4.4"/></svg>Perangkat</a>
                <a href="{{ route('statistik') }}" class="{{ request()->routeIs('statistik') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 20V10"/><path d="M10 20V4"/><path d="M16 20v-7"/><path d="M22 20H2"/></svg>Statistik</a>
                <a href="{{ route('fasilitas') }}" class="{{ request()->routeIs('fasilitas') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 21h18"/><path d="M5 21V7l7-4 7 4v14"/><path d="M9.5 21v-4h5v4"/><path d="M10 11h.01M14 11h.01M10 14.5h.01M14 14.5h.01"/></svg>Fasilitas</a>
                <a href="{{ route('media') }}" class="{{ request()->routeIs('media') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="3"/><circle cx="9" cy="10" r="1.6"/><path d="m5 17 5-4.5 4 3.5 3.5-3L21 17"/></svg>Galeri</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="nav-login"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="7.5" height="7.5" rx="1.5"/><rect x="13.5" y="3" width="7.5" height="7.5" rx="1.5"/><rect x="3" y="13.5" width="7.5" height="7.5" rx="1.5"/><rect x="13.5" y="13.5" width="7.5" height="7.5" rx="1.5"/></svg>Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="nav-login"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 4H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h7"/><path d="M11 12h10"/><path d="m17 8 4 4-4 4"/></svg>Masuk</a>
                @endauth
            </nav>

            <div class="header-actions">
                @if ($semuaDesa->count() > 1)
                    <form method="POST" action="{{ route('pilih-desa') }}" class="desa-switcher">
                        @csrf
                        <input type="hidden" name="kembali" value="{{ url()->current() }}">
                        <label class="sr-only" for="pilih-desa">Pilih desa</label>
                        <select id="pilih-desa" name="slug" onchange="this.form.submit()">
                            @foreach ($semuaDesa as $item)
                                <option value="{{ $item->slug }}" @selected($item->slug === ($desa->slug ?? null))>{{ $item->nama_desa }}</option>
                            @endforeach
                        </select>
                    </form>
                @endif
                <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="menu-utama" aria-label="Buka menu navigasi">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

        </div>
    </header>

    <main id="main">
        @yield('content')
    </main>

    <footer class="site-footer" id="kontak">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a class="brand brand--footer" href="{{ route('beranda') }}">
                        @if (! empty($desa?->profil?->logo_path))
                            <img class="brand__mark" src="{{ Storage::url($desa->profil->logo_path) }}" alt="" aria-hidden="true">
                        @else
                            <span class="brand__mark brand__mark--text" aria-hidden="true">{{ Str::substr($desa->nama_desa ?? 'D', 0, 1) }}</span>
                        @endif
                        <span class="brand__text">
                            <strong>{{ $desa->nama_desa ?? 'Sistem Informasi Desa' }}</strong>
                            <small>Sistem Informasi Desa Digital</small>
                        </span>
                    </a>
                    <p class="footer-desc">
                        @if (! empty($desa?->profil?->deskripsi))
                            {{ Str::limit($desa->profil->deskripsi, 160) }}
                        @else
                            Portal resmi pemerintahan desa — profil, sejarah, visi &amp; misi, wilayah, perangkat, statistik, fasilitas, dan galeri dalam satu tempat.
                        @endif
                    </p>
                    <div class="footer-social">
                        <a href="#" aria-label="Instagram">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                        </a>
                        <a href="#" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M15 3h-3a4 4 0 0 0-4 4v3H5v4h3v7h4v-7h3l1-4h-4V7a1 1 0 0 1 1-1h3Z"/></svg>
                        </a>
                        <a href="#" aria-label="YouTube">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="2.5" y="5.5" width="19" height="13" rx="4"/><path d="m10 9 5 3-5 3V9Z" fill="currentColor" stroke="none"/></svg>
                        </a>
                    </div>
                </div>

                <nav class="footer-col" aria-label="Tautan cepat">
                    <h4>Tautan Cepat</h4>
                    <ul>
                        <li><a href="{{ route('beranda') }}">Beranda</a></li>
                        <li><a href="{{ route('sejarah') }}">Sejarah Desa</a></li>
                        <li><a href="{{ route('visi-misi') }}">Visi &amp; Misi</a></li>
                        <li><a href="{{ route('wilayah') }}">Wilayah</a></li>
                        <li><a href="{{ route('perangkat') }}">Perangkat Desa</a></li>
                    </ul>
                </nav>

                <nav class="footer-col" aria-label="Informasi">
                    <h4>Informasi</h4>
                    <ul>
                        <li><a href="{{ route('statistik') }}">Statistik Desa</a></li>
                        <li><a href="{{ route('fasilitas') }}">Fasilitas</a></li>
                        <li><a href="{{ route('media') }}">Galeri &amp; Media</a></li>
                        <li><a href="{{ route('login') }}">Login Admin</a></li>
                        <li><a href="{{ route('selamat-datang') }}">Halaman Selamat Datang</a></li>
                        <li><a href="#kontak">Hubungi Kami</a></li>
                    </ul>
                </nav>

                <div class="footer-col">
                    <h4>Kontak</h4>
                    <ul class="footer-contact">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 21s7-5.4 7-11a7 7 0 1 0-14 0c0 5.6 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg>
                            <span>{{ $desa->profil?->alamat ?: ($desa->kecamatan . ', ' . $desa->kabupaten . ', ' . $desa->provinsi) }}</span>
                        </li>
                        @if (! empty($desa?->profil?->telepon))
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a12 12 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A17 17 0 0 1 3 6a2 2 0 0 1 2-2Z"/></svg>
                                <span>{{ $desa->profil->telepon }}</span>
                            </li>
                        @endif
                        @if (! empty($desa?->profil?->email))
                            <li>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 6h16v12H4z"/><path d="m4 7 8 6 8-6"/></svg>
                                <span>{{ $desa->profil->email }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; {{ now()->year }} Pemerintah {{ $desa->nama_desa ?? 'Desa' }}. Sistem Informasi Desa Digital.</span>
                <span>Developer by Inoi. K, Arnol. N, Nisix. T &amp; Inda W</span>
            </div>

            <p class="footer-wordmark" aria-hidden="true">{{ $desa?->nama_desa ?? 'Desa' }}</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
