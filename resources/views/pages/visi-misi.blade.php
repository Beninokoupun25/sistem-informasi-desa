@extends('layouts.app')

@section('title', 'Visi & Misi')

@section('content')
    <header class="page-header">
        <div class="container">
            <span class="eyebrow eyebrow--mint">Arah Pembangunan</span>
            <h1 class="page-title">Visi &amp; Misi<br><em>{{ $desa->nama_desa }}</em></h1>
            <p class="page-lede">Kompas jangka panjang: ke mana desa melangkah, dan ikhtiar apa yang ditempuh setiap hari.</p>
        </div>
    </header>

    <section class="section">
        <div class="container">
            @if ($visi->isEmpty() && $misi->isEmpty())
                <p class="empty-state">Visi dan misi desa belum tersedia.</p>
            @else
                @foreach ($visi as $butir)
                    <figure class="visi-besar">
                        <span class="eyebrow eyebrow--mint">Visi</span>
                        <blockquote>“{{ $butir->isi }}”</blockquote>
                        <figcaption>— Visi Pemerintah {{ $desa->nama_desa }}</figcaption>
                    </figure>
                @endforeach

                @if ($misi->isNotEmpty())
                    <div class="misi-section-head">
                        <span class="eyebrow">Misi</span>
                        <h2 class="section-title section-title--lg" style="margin:0;">Ikhtiar bersama,<br>satu tujuan.</h2>
                    </div>
                    <div class="misi-grid">
                        @foreach ($misi as $i => $butir)
                            <div class="misi-card card">
                                <span class="misi-card-index">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <p>{{ $butir->isi }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </section>
@endsection
