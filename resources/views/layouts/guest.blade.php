<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Masuk') — Sistem Informasi Desa</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="auth-body">
    <main class="auth-shell">
        <a href="{{ route('beranda') }}" class="auth-brand" aria-label="Kembali ke beranda">
            <span class="auth-brand-mark" aria-hidden="true">SI</span>
            <span class="auth-brand-text">
                <small>Sistem Informasi Desa Digital</small>
                <strong>Portal Admin</strong>
            </span>
        </a>

        <div class="auth-card">
            @if (session('status'))
                <div class="flash flash-success" role="status">{{ session('status') }}</div>
            @endif

            @yield('content')
        </div>

        <p class="auth-foot"><a href="{{ route('beranda') }}">← Kembali ke situs desa</a></p>
    </main>
</body>
</html>
