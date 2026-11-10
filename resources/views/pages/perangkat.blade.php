@extends('layouts.app')

@section('title', 'Perangkat Desa')

@section('content')
    <header class="page-header">
        <div class="container">
            <span class="eyebrow eyebrow--mint">Aparatur Pemerintahan</span>
            <h1 class="page-title">Perangkat<br><em>Desa</em></h1>
            <p class="page-lede">Orang-orang di balik pelayanan {{ $desa->nama_desa }} — dari kepala desa hingga staf pelaksananya.</p>
        </div>
    </header>

    <section class="section">
        <div class="container">
            @if ($perangkat->isEmpty())
                <p class="empty-state">Data perangkat desa belum tersedia.</p>
            @else
                <div class="perangkat-grid">
                    @foreach ($perangkat as $orang)
                        <article class="perangkat-card card">
                            @if ($orang->foto_path)
                                <img src="{{ Storage::url($orang->foto_path) }}" alt="{{ $orang->nama }}" class="perangkat-foto" loading="lazy">
                            @else
                                <div class="perangkat-avatar" aria-hidden="true">{{ strtoupper(Str::substr($orang->nama, 0, 1)) }}</div>
                            @endif
                            <div class="perangkat-body">
                                <h2>{{ $orang->nama }}</h2>
                                <p class="perangkat-jabatan">{{ $orang->jabatan }}</p>
                                @if ($orang->kontak)
                                    <p class="perangkat-kontak">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4h4l2 5-2.5 1.5a12 12 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A17 17 0 0 1 3 6a2 2 0 0 1 2-2Z"/></svg>
                                        {{ $orang->kontak }}
                                    </p>
                                @endif
                                <span class="badge {{ $orang->status === 'aktif' ? '' : 'badge-abu' }}">{{ $orang->status }}</span>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection
