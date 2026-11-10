@extends('layouts.app')

@section('title', 'Statistik Desa')

@section('content')
    <header class="page-header">
        <div class="container">
            <span class="eyebrow eyebrow--mint">Kependudukan</span>
            <h1 class="page-title">Statistik<br><em>{{ $desa->nama_desa }}</em></h1>
            <p class="page-lede">Potret kependudukan {{ $desa->nama_desa }} dari tahun ke tahun — jujur, ringkas, dan terbuka.</p>
        </div>
    </header>

    <section class="section">
        <div class="container">
            @if ($statistik->isEmpty())
                <p class="empty-state">Data statistik desa belum tersedia.</p>
            @else
                @php($terbaru = $statistik->sortByDesc('tahun')->first())
                <div class="statistik-highlight">
                    <div class="statistik-highlight-head">
                        <span class="eyebrow eyebrow--mint">Tahun Terakhir · {{ $terbaru->tahun }}</span>
                        <h2 class="statistik-highlight-title">{{ number_format($terbaru->jumlah_penduduk, 0, ',', '.') }} <span>jiwa</span></h2>
                    </div>
                    <dl class="highlight-grid">
                        <div><dt>Laki-laki</dt><dd>{{ number_format($terbaru->laki_laki, 0, ',', '.') }}</dd></div>
                        <div><dt>Perempuan</dt><dd>{{ number_format($terbaru->perempuan, 0, ',', '.') }}</dd></div>
                        <div><dt>Kepala Keluarga</dt><dd>{{ number_format($terbaru->jumlah_kk, 0, ',', '.') }}</dd></div>
                        <div><dt>Dusun</dt><dd>{{ number_format($terbaru->jumlah_dusun, 0, ',', '.') }}</dd></div>
                    </dl>
                </div>

                <div class="card card-body chart-card">
                    <div class="chart-card-head">
                        <h3>Pertumbuhan Penduduk</h3>
                        <span class="chart-note">{{ $statistik->count() }} tahun tercatat</span>
                    </div>
                    @php($maksPenduduk = $statistik->max('jumlah_penduduk'))
                    @foreach ($statistik->sortBy('tahun') as $baris)
                        @php($lebar = $maksPenduduk > 0 ? (int) round($baris->jumlah_penduduk / $maksPenduduk * 100) : 0)
                        <div class="bar-row">
                            <strong>{{ $baris->tahun }}</strong>
                            <div class="bar-track"><div class="bar-fill" style="width: {{ $lebar }}%;"></div></div>
                            <span class="bar-value">{{ number_format($baris->jumlah_penduduk, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="table-wrap" style="margin-top: 28px;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tahun</th>
                                <th>Jumlah Penduduk</th>
                                <th>Laki-laki</th>
                                <th>Perempuan</th>
                                <th>Kepala Keluarga</th>
                                <th>Dusun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($statistik as $baris)
                                <tr>
                                    <td><strong>{{ $baris->tahun }}</strong></td>
                                    <td>{{ number_format($baris->jumlah_penduduk, 0, ',', '.') }}</td>
                                    <td>{{ number_format($baris->laki_laki, 0, ',', '.') }}</td>
                                    <td>{{ number_format($baris->perempuan, 0, ',', '.') }}</td>
                                    <td>{{ number_format($baris->jumlah_kk, 0, ',', '.') }}</td>
                                    <td>{{ number_format($baris->jumlah_dusun, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </section>
@endsection
