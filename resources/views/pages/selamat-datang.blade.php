<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="Selamat datang di {{ $desa->nama_desa }} — Sistem Informasi Desa Digital, {{ $desa->kecamatan }}, {{ $desa->kabupaten }}, {{ $desa->provinsi }}">
    <title>Selamat Datang — {{ $desa->nama_desa }}</title>
    @if (! empty($desa?->profil?->logo_path))
        <link rel="icon" href="{{ Storage::url($desa->profil->logo_path) }}">
    @else
        <link rel="icon" href="{{ asset('favicon.ico') }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300..900;1,9..144,300..900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            box-sizing: border-box;
            padding-top: env(safe-area-inset-top, 0px);
            padding-bottom: env(safe-area-inset-bottom, 0px);
            --primary: #10a35f;
            --primary-tua: #0b7a45;
            --primary-gelap: #084f2d;
            --primary-lembut: #e9f9ef;
            --primary-lembut-2: #d3f2e0;
            --teks: #10241a;
            --teks-lembut: #5c6f64;
            --garis: #e3e9e4;
        }
        *, *::before, *::after { box-sizing: inherit; margin: 0; padding: 0; }
        html, body { height: 100%; width: 100%; overflow-x: hidden; }

        body {
            font-family: 'Plus Jakarta Sans', 'Segoe UI', sans-serif;
            background: #ffffff;
            color: var(--teks);
            -webkit-font-smoothing: antialiased;
        }

        .hero {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
            background:
                radial-gradient(1000px 520px at 18% -10%, rgba(18, 183, 106, 0.2), transparent 55%),
                radial-gradient(820px 480px at 88% -2%, rgba(242, 179, 61, 0.18), transparent 55%),
                #ffffff;
        }

        .atmosphere {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        /* ─── Navigation ─── */
        nav {
            position: relative;
            z-index: 30;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 26px;
            padding: 26px 40px;
            flex-wrap: wrap;
        }

        .nav-pill {
            border: 1px solid var(--primary-lembut-2);
            border-radius: 999px;
            padding: 9px 26px;
            background: var(--primary-lembut);
            color: var(--primary-gelap);
            text-decoration: none;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: background .2s, border-color .2s;
        }
        .nav-pill:hover {
            background: var(--primary-lembut-2);
            border-color: var(--primary);
        }

        nav a:not(.nav-pill) {
            color: var(--teks-lembut);
            text-decoration: none;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: color .2s;
        }
        nav a:not(.nav-pill):hover { color: var(--primary-gelap); }

        /* ─── Sky content ─── */
        .sky-content {
            position: relative;
            z-index: 20;
            height: calc(56vh - 90px);
            min-height: 260px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 24px;
        }

        .logo {
            width: 88px;
            height: 88px;
            object-fit: contain;
            border-radius: 22px;
            background: #ffffff;
            border: 1px solid var(--garis);
            box-shadow: 0 14px 40px rgba(16, 36, 26, 0.12);
            padding: 8px;
            margin-bottom: 18px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--primary-lembut-2);
            background: var(--primary-lembut);
            color: var(--primary-gelap);
            border-radius: 999px;
            padding: 6px 18px;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #12b76a;
        }

        h1 {
            font-family: 'Fraunces', serif;
            font-weight: 480;
            font-size: clamp(2.6rem, 7.5vw, 5rem);
            color: var(--primary-gelap);
            letter-spacing: -2px;
            line-height: 1.04;
            margin-bottom: 22px;
        }

        h1 .accent {
            font-style: italic;
            font-weight: 560;
            background: linear-gradient(135deg, #17a15f, #0b7a45);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .tagline {
            font-size: 14px;
            font-weight: 400;
            color: var(--teks-lembut);
            max-width: 460px;
            line-height: 1.9;
            margin-bottom: 36px;
        }

        .tagline strong { color: var(--primary-gelap); font-weight: 700; }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border: 0;
            color: #ffffff;
            background: linear-gradient(135deg, #12b76a, #0b7a45);
            padding: 15px 40px;
            font-family: inherit;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            border-radius: 999px;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 12px 32px rgba(18, 183, 106, 0.38);
            transition: transform .18s, box-shadow .18s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 40px rgba(18, 183, 106, 0.48);
        }
        .btn:active { transform: translateY(0); }

        /* ─── Mountains ─── */
        .mountains {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 38vh;
            pointer-events: none;
        }
        .mountains svg { width: 100%; height: 100%; }

        .credit {
            position: absolute;
            z-index: 20;
            bottom: 14px;
            left: 0;
            right: 0;
            text-align: center;
            color: #8a9b91;
            font-size: 10px;
            letter-spacing: 1.6px;
            text-transform: uppercase;
            pointer-events: none;
        }

        @media (max-width: 640px) {
            nav {
                gap: 12px;
                padding: 18px 16px;
            }
            .sky-content { height: auto; padding: 30px 22px; min-height: 50vw; }
            .mountains { height: 38vw; }
            h1 { font-size: clamp(2rem, 11vw, 3.2rem); letter-spacing: -1px; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; animation: none !important; }
        }
    </style>
</head>
<body>
<div class="hero">

    @include('partials.atmosphere', ['id' => 'sd'])

    <!-- Navigation -->
    <nav aria-label="Navigasi selamat datang">
        <a href="{{ route('beranda') }}" class="nav-pill">Beranda</a>
        <a href="{{ route('sejarah') }}">Sejarah</a>
        <a href="{{ route('visi-misi') }}">Visi &amp; Misi</a>
        <a href="{{ route('wilayah') }}">Wilayah</a>
        <a href="{{ route('media') }}">Galeri</a>
    </nav>

    <!-- Hero text -->
    <div class="sky-content">
        @if ($desa->profil?->logo_path)
            <img src="{{ Storage::url($desa->profil->logo_path) }}" alt="Logo {{ $desa->nama_desa }}" class="logo">
        @endif
        <span class="badge"><span class="badge-dot" aria-hidden="true"></span>Sistem Informasi Desa Digital</span>
        <h1>Selamat Datang<br>di <span class="accent">{{ $desa->nama_desa }}</span></h1>
        <p class="tagline">
            <strong>{{ $desa->kecamatan }} · {{ $desa->kabupaten }} · {{ $desa->provinsi }}</strong><br>
            @if ($desa->profil?->deskripsi)
                {{ Str::limit($desa->profil->deskripsi, 150) }}
            @else
                Portal resmi pemerintahan desa — profil, wilayah, perangkat, statistik, fasilitas, dan galeri dalam satu tempat.
            @endif
        </p>
        <a href="{{ route('beranda') }}" class="btn">Jelajahi Desa <span aria-hidden="true">→</span></a>
    </div>

    <!-- Layered mountains -->
    <div class="mountains" aria-hidden="true">
        @include('partials.mountains')
    </div>

    <p class="credit">Pemerintah {{ $desa->nama_desa }}</p>

</div>
</body>
</html>
