@extends('layouts.app')

@section('title', 'Fasilitas Desa')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@section('content')
    <header class="page-header">
        <div class="container">
            <span class="eyebrow eyebrow--mint">Ruang Publik</span>
            <h1 class="page-title">Fasilitas<br><em>{{ $desa->nama_desa }}</em></h1>
            <p class="page-lede">Gedung, lapangan, dan layanan yang bisa dinikmati warga — beserta titik lokasinya.</p>
        </div>
    </header>

    <section class="section">
        <div class="container">
            @if ($fasilitas->isEmpty())
                <p class="empty-state">Data fasilitas desa belum tersedia.</p>
            @else
                @if ($fasilitas->filter(fn ($f) => $f->latitude && $f->longitude)->isNotEmpty())
                    <div class="map-frame card" style="margin-bottom: 32px;">
                        <div id="peta" class="map map--flat"></div>
                        <p class="map-caption">Semua fasilitas dengan koordinat terdaftar.</p>
                    </div>
                @endif

                <div class="fasilitas-overlay-grid fasilitas-overlay-grid--3">
                    @foreach ($fasilitas as $item)
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
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        (function () {
            const fasilitas = @json($fasilitas->filter(fn ($item) => $item->latitude && $item->longitude)->values());
            const petaEl = document.getElementById('peta');

            if (!petaEl || fasilitas.length === 0) {
                return;
            }

            const peta = L.map(petaEl).setView([fasilitas[0].latitude, fasilitas[0].longitude], 14);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            }).addTo(peta);

            const titik = [];
            fasilitas.forEach((item) => {
                titik.push([item.latitude, item.longitude]);
                L.marker([item.latitude, item.longitude]).addTo(peta)
                    .bindPopup('<strong>' + item.nama + '</strong><br>' + item.kategori);
            });

            if (titik.length > 1) {
                peta.fitBounds(titik, { padding: [40, 40] });
            }
        })();
    </script>
@endpush
