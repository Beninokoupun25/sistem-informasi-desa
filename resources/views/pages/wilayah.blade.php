@extends('layouts.app')

@section('title', 'Wilayah Desa')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
@endpush

@section('content')
    <header class="page-header">
        <div class="container">
            <span class="eyebrow eyebrow--mint">Geografis &amp; Batas</span>
            <h1 class="page-title">Wilayah<br><em>{{ $desa->nama_desa }}</em></h1>
            <p class="page-lede">Landskap administratif: luas, titik koordinat, dan batas-batas {{ $desa->kecamatan }}, {{ $desa->kabupaten }}.</p>
        </div>
    </header>

    <section class="section">
        <div class="container">
            @if ($wilayah->isEmpty())
                <p class="empty-state">Data wilayah desa belum tersedia.</p>
            @else
                @foreach ($wilayah as $data)
                    <div class="wilayah-grid" style="margin-bottom: 36px;">
                        <div class="map-frame card">
                            <div id="peta" class="map map--flat"></div>
                            <p class="map-caption">Peta interaktif — geser untuk menjelajah, klik penanda untuk detail.</p>
                        </div>

                        <aside class="wilayah-panel">
                            <span class="eyebrow">Kartu Wilayah</span>
                            <div class="wilayah-luas">
                                <dt>Luas Wilayah</dt>
                                <dd>{{ $data->luas_wilayah ?? '-' }}</dd>
                            </div>
                            <ul class="detail-list detail-list--bordered">
                                <li><span class="label">Latitude</span><span class="value">{{ $data->latitude ?? '-' }}</span></li>
                                <li><span class="label">Longitude</span><span class="value">{{ $data->longitude ?? '-' }}</span></li>
                            </ul>
                            <ul class="compass">
                                <li><span class="compass-dir compass-u">U</span><span class="compass-val">{{ $data->batas_utara ?? '-' }}</span></li>
                                <li><span class="compass-dir compass-t">T</span><span class="compass-val">{{ $data->batas_timur ?? '-' }}</span></li>
                                <li><span class="compass-dir compass-s">S</span><span class="compass-val">{{ $data->batas_selatan ?? '-' }}</span></li>
                                <li><span class="compass-dir compass-b">B</span><span class="compass-val">{{ $data->batas_barat ?? '-' }}</span></li>
                            </ul>
                        </aside>
                    </div>
                @endforeach
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        (function () {
            const wilayah = @json($wilayah);
            const berkas = wilayah.filter((w) => w.latitude && w.longitude);

            if (!document.getElementById('peta') || berkas.length === 0 && !wilayah.some((w) => w.geojson_data)) {
                return;
            }

            const pusat = berkas.length > 0
                ? [berkas[0].latitude, berkas[0].longitude]
                : [-2.5489, 118.0149];
            const zoom = berkas.length > 0 ? 14 : 5;

            const peta = L.map('peta').setView(pusat, zoom);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
            }).addTo(peta);

            berkas.forEach((w) => {
                L.marker([w.latitude, w.longitude]).addTo(peta)
                    .bindPopup('<strong>{{ addslashes($desa->nama_desa) }}</strong><br>Kantor desa');
            });

            wilayah.filter((w) => w.geojson_data).forEach((w) => {
                const lapisan = L.geoJSON(w.geojson_data, { style: { color: '#10a35f', weight: 2.5, fillOpacity: 0.18 } }).addTo(peta);

                if (berkas.length === 0) {
                    peta.fitBounds(lapisan.getBounds());
                }
            });
        })();
    </script>
@endpush
