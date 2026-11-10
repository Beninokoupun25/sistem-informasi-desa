@extends('layouts.admin')

@section('title', 'Dashboard — ' . $desa->nama_desa)
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Ringkasan aktivitas dan data terbaru dari Sistem Informasi Desa Digital.')

@push('styles')
<style>
    .welcome-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 16px 20px;
        border-radius: 12px;
        background: #f3f4f6;
    }
    .welcome-text { flex: 1; }
    .welcome-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 0.85rem;
        color: #6b7280;
        margin-bottom: 8px;
    }
    .welcome-tag svg { width: 16px; height: 16px; flex-shrink: 0; }
    .welcome-text h2 { margin: 0 0 6px 0; font-size: 1.25rem; }
    .welcome-text p { margin: 0; font-size: 0.9rem; color: #4b5563; }
    .page-actions { display: flex; gap: 8px; flex-shrink: 0; }
    .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
    .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 14px; }
    .stat-card {
        padding: 16px;
        border-radius: 10px;
        background: #fff;
        border: 1px solid #e5e7eb;
    }
    .stat-icon { width: 40px; height: 40px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 10px; }
    .stat-icon svg { width: 20px; height: 20px; }
    .stat-card.blue .stat-icon { background: #dbeafe; color: #2563eb; }
    .stat-card.violet .stat-icon { background: #ede9fe; color: #7c3aed; }
    .stat-card.amber .stat-icon { background: #fef3c7; color: #d97706; }
    .stat-card.green .stat-icon { background: #dcfce7; color: #15803d; }
    .stat-card strong { display: block; font-size: 1.5rem; line-height: 1; }
    .stat-label { font-size: 0.85rem; color: #6b7280; margin-top: 4px; }
    .stat-hint { font-size: 0.8rem; color: #9ca3af; margin-top: 2px; }
    .dash-main { display: grid; grid-template-columns: 2fr 1fr; gap: 18px; margin-top: 18px; }
    .card {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fff;
        overflow: hidden;
    }
    .card-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .card-head div h3 { margin: 0 0 2px 0; font-size: 1rem; }
    .card-head div p { margin: 0; font-size: 0.8rem; color: #6b7280; }
    .card-head a { font-size: 0.85rem; color: #2563eb; text-decoration: none; }
    .card-body { padding: 14px 16px; }
    .dash-chart { display: flex; gap: 8px; align-items: flex-end; height: 120px; padding: 8px 0; }
    .dash-chart__col { display: flex; flex-direction: column; align-items: center; gap: 6px; width: 40px; }
    .dash-chart__value { font-size: 0.75rem; font-weight: 700; color: #374151; }
    .dash-chart__track { width: 24px; height: 80px; background: #e5e7eb; border-radius: 6px; overflow: hidden; }
    .dash-chart__bar { width: 100%; background: #2563eb; border-radius: 6px 6px 0 0; }
    .dash-chart__label { font-size: 0.65rem; color: #6b7280; text-align: center; line-height: 1.2; }
    .list { display: flex; flex-direction: column; gap: 8px; }
    .list-row {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        text-decoration: none;
        color: inherit;
        background: #fff;
    }
    .list-row .icon {
        width: 32px; height: 32px; border-radius: 8px; background: #f3f4f6;
        display: inline-flex; align-items: center; justify-content: center; color: #4b5563;
        flex-shrink: 0;
    }
    .list-row .icon svg { width: 16px; height: 16px; }
    .list-row .info { flex: 1; min-width: 0; }
    .list-row .info strong { display: block; font-size: 0.9rem; }
    .list-row .info small { font-size: 0.75rem; color: #6b7280; }
    .list-row .chevron { width: 16px; height: 16px; color: #9ca3af; flex-shrink: 0; }
    .empty {
        text-align: center; padding: 24px; color: #6b7280;
    }
    .empty strong { display: block; margin-bottom: 4px; color: #374151; }
    .empty .icon {
        width: 40px; height: 40px; border-radius: 10px; background: #f3f4f6;
        margin: 0 auto 10px auto; display: inline-flex; align-items: center; justify-content: center; color: #9ca3af;
    }
    .empty .icon svg { width: 20px; height: 20px; }
    .table-wrap { overflow-x: auto; }
    .data-table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
    .data-table th { text-align: left; padding: 8px 10px; border-bottom: 1px solid #e5e7eb; color: #6b7280; font-weight: 600; }
    .data-table td { padding: 8px 10px; border-bottom: 1px solid #f3f4f6; }
    .badge-status { display: inline-block; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600; }
    .badge-success { background: #dcfce7; color: #15803d; }
    .badge-warning { background: #fef3c7; color: #d97706; }
    .badge-info { background: #dbeafe; color: #2563eb; }
    .dash-date-chip {
        display: flex; flex-direction: column; align-items: center; gap: 2px;
        min-width: 44px; padding: 6px 4px; border-radius: 8px; background: #f3f4f6;
    }
    .dash-date-chip strong { font-size: 1rem; }
    .dash-date-chip span { font-size: 0.7rem; color: #6b7280; }
    .dash-unread-dot { width: 8px; height: 8px; border-radius: 50%; background: #ef4444; display: inline-block; margin-left: 6px; }
    @media (max-width: 900px) {
        .dash-main { grid-template-columns: 1fr; }
        .grid-4 { grid-template-columns: repeat(2, 1fr); }
        .welcome-card { flex-direction: column; align-items: flex-start; gap: 12px; }
        .page-actions { width: 100%; justify-content: flex-end; }
    }
</style>
@endpush

@section('content')
    <div class="welcome-card">
        <div class="welcome-text">
            <span class="welcome-tag welcome-calendar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                {{ now()->locale('id')->translatedFormat('l, d F Y') }}
            </span>
            <h2>{{ $greeting ?? 'Selamat datang' }}, {{ auth()->user()->name }}</h2>
            <p>Berikut ringkasan data dan aktivitas terbaru sistem informasi desa {{ $desa->nama_desa }}. Semua yang perlu Anda kelola ada di satu tempat.</p>
        </div>
        <div class="page-actions">
            <a class="btn btn-primary" href="{{ route('admin.profil.edit') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                Kelola Profil
            </a>
            <a class="btn btn-outline" href="{{ route('beranda') }}" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                Lihat Situs
            </a>
        </div>
    </div>

    <div class="grid grid-4" style="margin-top: 18px;">
        @if ($statistikTerbaru)
            <article class="stat-card blue">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <strong>{{ number_format($statistikTerbaru->jumlah_penduduk, 0, ',', '.') }}</strong>
                <span class="stat-label">Penduduk ({{ $statistikTerbaru->tahun }})</span>
                <span class="stat-hint">Data statistik terbaru</span>
            </article>
        @else
            <article class="stat-card blue">
                <div class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <strong>0</strong>
                <span class="stat-label">Penduduk</span>
                <span class="stat-hint">Belum ada statistik</span>
            </article>
        @endif

        <article class="stat-card violet">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            </div>
            <strong>{{ $jumlahSejarah }}</strong>
            <span class="stat-label">Entri Sejarah</span>
            <span class="stat-hint">Riwayat dan linimasa desa</span>
        </article>

        <article class="stat-card amber">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <strong>{{ $jumlahMedia }}</strong>
            <span class="stat-label">Berkas Media</span>
            <span class="stat-hint">Foto dan dokumen publik</span>
        </article>

        <article class="stat-card green">
            <div class="stat-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <strong>{{ $jumlahFasilitas }}</strong>
            <span class="stat-label">Fasilitas</span>
            <span class="stat-hint">Bangunan dan layanan umum</span>
        </article>
    </div>

    <div class="dash-main">
        <section class="card">
            <div class="card-head">
                <div>
                    <h3>Statistik Kependudukan</h3>
                    <p>Data penduduk per tahun dari terbaru</p>
                </div>
                @if ($statistikTerbaru)
                    <span class="badge-status badge-info">{{ $jumlahStatistik }} total</span>
                @else
                    <span class="badge-status badge-warning">Kosong</span>
                @endif
            </div>
            <div class="card-body">
                @if ($statistikTerbaru)
                    @php
                        $riwayat = $desa->statistik()->orderByDesc('tahun')->take(6)->get();
                        $maxPenduduk = $riwayat->isNotEmpty() ? $riwayat->max('jumlah_penduduk') : 1;
                    @endphp
                    <div class="dash-chart" role="img" aria-label="Grafik penduduk per tahun">
                        @foreach ($riwayat->reverse() as $row)
                            <div class="dash-chart__col">
                                <span class="dash-chart__value">{{ number_format($row->jumlah_penduduk, 0, ',', '.') }}</span>
                                <div class="dash-chart__track">
                                    <div class="dash-chart__bar" style="height: {{ max(4, round(($row->jumlah_penduduk / $maxPenduduk) * 100)) }}%"></div>
                                </div>
                                <span class="dash-chart__label">{{ $row->tahun }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty">
                        <span class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></span>
                        <strong>Belum ada statistik</strong>
                        <p>Mulai dengan menambahkan data kependudukan pertama.</p>
                    </div>
                @endif
            </div>
        </section>

        <section class="card">
            <div class="card-head">
                <div>
                    <h3>Aksi Cepat</h3>
                    <p>Pintasan pengelolaan konten desa</p>
                </div>
            </div>
            <div class="card-body">
                <div class="list">
                    <a class="list-row" href="{{ route('admin.profil.edit') }}">
                        <span class="icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </span>
                        <span class="info">
                            <strong>Kelola Profil</strong>
                            <small>Alamat, logo, dan deskripsi desa</small>
                        </span>
                        <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                    <a class="list-row" href="{{ route('admin.sejarah.index') }}">
                        <span class="icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/></svg>
                        </span>
                        <span class="info">
                            <strong>Sejarah Desa</strong>
                            <small>{{ $jumlahSejarah }} entri riwayat</small>
                        </span>
                        <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                    <a class="list-row" href="{{ route('admin.visi-misi.index') }}">
                        <span class="icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                        </span>
                        <span class="info">
                            <strong>Visi &amp; Misi</strong>
                            <small>{{ $jumlahVisiMisi }} butir visi dan misi</small>
                        </span>
                        <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                    <a class="list-row" href="{{ route('admin.statistik.create') }}">
                        <span class="icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        </span>
                        <span class="info">
                            <strong>Tambah Statistik</strong>
                            <small>Data kependudukan tahunan</small>
                        </span>
                        <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                    <a class="list-row" href="{{ route('admin.fasilitas.index') }}">
                        <span class="icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                        </span>
                        <span class="info">
                            <strong>Kelola Fasilitas</strong>
                            <small>{{ $jumlahFasilitas }} fasilitas umum</small>
                        </span>
                        <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                    <a class="list-row" href="{{ route('admin.media.index') }}">
                        <span class="icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </span>
                        <span class="info">
                            <strong>Kelola Media</strong>
                            <small>{{ $jumlahMedia }} berkas publik</small>
                        </span>
                        <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
                    </a>
                </div>
            </div>
        </section>
    </div>

    <section class="card" style="margin-top: 18px;">
        <div class="card-head">
            <div>
                <h3>Statistik Terbaru</h3>
                <p>Data kependudukan yang paling baru ditambahkan</p>
            </div>
            @if ($statistikTerbaru)
                <a href="{{ route('admin.statistik.index') }}">Lihat semua</a>
            @endif
        </div>

        @if (!$statistikTerbaru)
            <div class="empty">
                <span class="icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></span>
                <strong>Belum ada statistik</strong>
                <p>Mulai dengan menambahkan data kependudukan pertama.</p>
            </div>
        @else
            <div class="table-wrap">
                <table class="data-table table-responsive">
                    <thead>
                        <tr>
                            <th>Tahun</th>
                            <th>Penduduk</th>
                            <th>Laki-laki</th>
                            <th>Perempuan</th>
                            <th>KK</th>
                            <th>Dusun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $terbaru = $desa->statistik()->orderByDesc('tahun')->take(5)->get();
                        @endphp
                        @foreach ($terbaru as $row)
                            <tr>
                                <td data-label="Tahun"><strong>{{ $row->tahun }}</strong></td>
                                <td data-label="Penduduk">{{ number_format($row->jumlah_penduduk, 0, ',', '.') }}</td>
                                <td data-label="Laki-laki">{{ number_format($row->laki_laki, 0, ',', '.') }}</td>
                                <td data-label="Perempuan">{{ number_format($row->perempuan, 0, ',', '.') }}</td>
                                <td data-label="KK">{{ number_format($row->jumlah_kk, 0, ',', '.') }}</td>
                                <td data-label="Dusun">{{ number_format($row->jumlah_dusun, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

    <div class="grid grid-3" style="margin-top: 18px;">
        <section class="card">
            <div class="card-head">
                <div>
                    <h3>Ringkasan Konten</h3>
                    <p>Jumlah entri per modul</p>
                </div>
            </div>
            <div class="card-body">
                <div class="list">
                    <a class="list-row" href="{{ route('admin.sejarah.index') }}">
                        <span class="icon">{{ $jumlahSejarah }}</span>
                        <span class="info"><strong>Sejarah</strong><small>{{ $jumlahSejarah }} entri</small></span>
                    </a>
                    <a class="list-row" href="{{ route('admin.visi-misi.index') }}">
                        <span class="icon">{{ $jumlahVisiMisi }}</span>
                        <span class="info"><strong>Visi &amp; Misi</strong><small>{{ $jumlahVisiMisi }} butir</small></span>
                    </a>
                    <a class="list-row" href="{{ route('admin.fasilitas.index') }}">
                        <span class="icon">{{ $jumlahFasilitas }}</span>
                        <span class="info"><strong>Fasilitas</strong><small>{{ $jumlahFasilitas }} fasilitas</small></span>
                    </a>
                </div>
            </div>
        </section>

        <section class="card">
            <div class="card-head">
                <div>
                    <h3>Media &amp; Perangkat</h3>
                    <p>Berkas publik dan aparatur</p>
                </div>
            </div>
            <div class="card-body">
                <div class="list">
                    <a class="list-row" href="{{ route('admin.media.index') }}">
                        <span class="icon">{{ $jumlahMedia }}</span>
                        <span class="info"><strong>Media</strong><small>{{ $jumlahMedia }} berkas</small></span>
                    </a>
                    <a class="list-row" href="#">
                        <span class="icon">{{ $jumlahPerangkat }}</span>
                        <span class="info"><strong>Perangkat</strong><small>{{ $jumlahPerangkat }} aparatur (kelola via API)</small></span>
                    </a>
                </div>
            </div>
        </section>

        <section class="card">
            <div class="card-head">
                <div>
                    <h3>Wilayah</h3>
                    <p>Data batas wilayah desa</p>
                </div>
            </div>
            <div class="card-body">
                <div class="list">
                    <a class="list-row" href="#">
                        <span class="icon">{{ $jumlahWilayah }}</span>
                        <span class="info"><strong>Wilayah</strong><small>{{ $jumlahWilayah }} catatan</small></span>
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
