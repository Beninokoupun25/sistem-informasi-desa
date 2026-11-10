<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin {{ $desa->nama_desa ?? 'Desa' }}</title>
    @if (! empty($desa?->profil?->logo_path))
        <link rel="icon" href="{{ Storage::url($desa->profil->logo_path) }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="admin-body">
    <header class="admin-topbar">
        <div class="container admin-topbar-inner">
            <button class="nav-toggle admin-nav-toggle" aria-label="Buka menu" aria-expanded="false" aria-controls="admin-nav">
                <span></span><span></span><span></span>
            </button>

            <a class="admin-brand" href="{{ route('admin.dashboard') }}">
                @if (! empty($desa?->profil?->logo_path))
                    <img class="admin-brand-mark" src="{{ Storage::url($desa->profil->logo_path) }}" alt="" aria-hidden="true">
                @else
                    <span class="admin-brand-mark admin-brand-mark--text" aria-hidden="true">{{ Str::substr($desa->nama_desa ?? 'D', 0, 1) }}</span>
                @endif
                <span class="admin-brand-text">
                    <small>Admin Desa</small>
                    <strong>{{ $desa->nama_desa ?? 'Desa' }}</strong>
                </span>
            </a>

            <nav class="admin-nav" id="admin-nav" aria-label="Menu admin">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.profil.edit') }}" class="{{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">Profil</a>
                <a href="{{ route('admin.sejarah.index') }}" class="{{ request()->routeIs('admin.sejarah.*') ? 'active' : '' }}">Sejarah</a>
                <a href="{{ route('admin.visi-misi.index') }}" class="{{ request()->routeIs('admin.visi-misi.*') ? 'active' : '' }}">Visi &amp; Misi</a>
                <a href="{{ route('admin.statistik.index') }}" class="{{ request()->routeIs('admin.statistik.*') ? 'active' : '' }}">Statistik</a>
                <a href="{{ route('admin.fasilitas.index') }}" class="{{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">Fasilitas</a>
                <a href="{{ route('admin.media.index') }}" class="{{ request()->routeIs('admin.media.*') ? 'active' : '' }}">Media</a>
            </nav>

            <div class="admin-user">
                <a href="{{ route('beranda') }}" class="admin-situs-link" target="_blank" rel="noopener">Lihat Situs</a>
                <a href="{{ route('profile.edit') }}" class="admin-user-name" title="Pengaturan akun">{{ auth()->user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="admin-logout">Keluar</button>
                </form>
            </div>
        </div>
    </header>

    <main class="container admin-main">
        @if (session('status'))
            <div class="flash flash-success" role="status">{{ session('status') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="admin-footer">
        <div class="container">
            <span>Admin {{ $desa->nama_desa ?? 'Desa' }} — Sistem Informasi Desa Digital</span>
        </div>
    </footer>

    @stack('scripts')

    <script>
        (function () {
            var toggle = document.querySelector('.admin-nav-toggle');
            var nav = document.getElementById('admin-nav');

            if (! toggle || ! nav) return;

            toggle.addEventListener('click', function () {
                var open = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', String(! open));
                nav.classList.toggle('open', ! open);
            });

            nav.querySelectorAll('a').forEach(function (link) {
                link.addEventListener('click', function () {
                    toggle.setAttribute('aria-expanded', 'false');
                    nav.classList.remove('open');
                });
            });
        })();
    </script>
</body>
</html>
