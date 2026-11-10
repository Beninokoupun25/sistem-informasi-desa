<?php

namespace Database\Seeders;

use App\Models\Desa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DesaSeeder extends Seeder
{
    public function run(): void
    {
        $desa = Desa::updateOrCreate(
            ['slug' => 'desa-sukamaju'],
            [
                'nama_desa' => 'Desa Sukamaju',
                'kecamatan' => 'Kecamatan Cisarua',
                'kabupaten' => 'Kabupaten Bandung Barat',
                'provinsi' => 'Jawa Barat',
                'status' => 'aktif',
            ]
        );

        $this->seedProfil($desa);
        $this->seedSejarah($desa);
        $this->seedVisiMisi($desa);
        $this->seedWilayah($desa);
        $this->seedPerangkat($desa);
        $this->seedStatistik($desa);
        $this->seedFasilitas($desa);
        $this->seedMedia($desa);

        $mekarsari = Desa::updateOrCreate(
            ['slug' => 'desa-mekarsari'],
            [
                'nama_desa' => 'Desa Mekarsari',
                'kecamatan' => 'Kecamatan Cilengkrang',
                'kabupaten' => 'Kabupaten Bandung Barat',
                'provinsi' => 'Jawa Barat',
                'status' => 'aktif',
            ]
        );

        $this->seedMekarsari($mekarsari);
    }

    private function seedMekarsari(Desa $desa): void
    {
        $logoPath = 'logo-desa/logo-mekarsari.svg';
        Storage::disk('public')->put($logoPath, $this->placeholderSvg('MR', 96));

        $desa->profil()->delete();
        $desa->profil()->create([
            'alamat' => 'Jl. Mekarsari No. 10, Kecamatan Cilengkrang, Kabupaten Bandung Barat',
            'telepon' => '022-5556789',
            'email' => 'info@desamekarsari.id',
            'logo_path' => $logoPath,
            'deskripsi' => 'Desa Mekarsari merupakan desa agraris di tepi hutan kota dengan udara sejuk. Desa ini mengembangkan wisata kebun dan produk olahan hasil bumi.',
        ]);

        $desa->sejarah()->delete();
        $desa->sejarah()->create([
            'judul' => 'Pembukaan Hutan menjadi Kampung',
            'isi' => 'Pada akhir abad ke-19, sekelompok pembuka lahan menetap di tepi hutan dan menamai pemukiman baru mereka Mekarsari yang berarti "bunga yang mekar".',
            'foto_path' => null,
            'urutan' => 1,
        ]);

        $desa->visiMisi()->delete();
        $desa->visiMisi()->createMany([
            ['jenis' => 'visi', 'isi' => 'Terwujudnya Desa Mekarsari yang asri, mandiri, dan berbasis wisata kebun.', 'urutan' => 1],
            ['jenis' => 'misi', 'isi' => 'Mengembangkan desa wisata kebun yang berkelanjutan.', 'urutan' => 1],
            ['jenis' => 'misi', 'isi' => 'Meningkatkan nilai tambah produk olahan hasil bumi warga.', 'urutan' => 2],
        ]);

        $desa->wilayah()->delete();
        $desa->wilayah()->create([
            'luas_wilayah' => '310,25 Ha',
            'latitude' => -6.8450,
            'longitude' => 107.6780,
            'batas_utara' => 'Desa Sukamaju',
            'batas_selatan' => 'Kecamatan Cimenyan',
            'batas_timur' => 'Kota Bandung',
            'batas_barat' => 'Kawasan Hutan',
            'geojson_path' => null,
        ]);

        $desa->perangkat()->delete();
        $desa->perangkat()->createMany([
            ['nama' => 'H. Endang Saputra', 'jabatan' => 'Kepala Desa', 'foto_path' => null, 'kontak' => '0812-8888-7777', 'urutan' => 1, 'status' => 'aktif'],
            ['nama' => 'Rina Kartini, S.E.', 'jabatan' => 'Sekretaris Desa', 'foto_path' => null, 'kontak' => '0813-7777-8888', 'urutan' => 2, 'status' => 'aktif'],
        ]);

        $desa->statistik()->delete();
        $desa->statistik()->create([
            'tahun' => 2025,
            'jumlah_penduduk' => 3286,
            'laki_laki' => 1641,
            'perempuan' => 1645,
            'jumlah_kk' => 984,
            'jumlah_dusun' => 2,
        ]);

        $desa->fasilitas()->delete();
        $desa->fasilitas()->createMany([
            ['nama' => 'Balai Desa Mekarsari', 'kategori' => 'Pemerintahan', 'alamat' => 'Jl. Mekarsari No. 10', 'latitude' => -6.8450, 'longitude' => 107.6780, 'deskripsi' => 'Kantor pemerintahan Desa Mekarsari.', 'foto_path' => null],
            ['nama' => 'Wisata Kebun Mekarsari', 'kategori' => 'Wisata', 'alamat' => 'Jl. Kebun No. 1', 'latitude' => -6.8480, 'longitude' => 107.6740, 'deskripsi' => 'Kebun wisata edukasi keluarga.', 'foto_path' => null],
        ]);
    }

    private function seedProfil(Desa $desa): void
    {
        $logoPath = 'logo-desa/logo-sukamaju.svg';
        Storage::disk('public')->put($logoPath, $this->placeholderSvg('SD', 96));

        $desa->profil()->delete();
        $desa->profil()->create([
            'alamat' => 'Jl. Raya Sukamaju No. 1, Kecamatan Cisarua, Kabupaten Bandung Barat',
            'telepon' => '022-5551234',
            'email' => 'info@desasukamaju.id',
            'logo_path' => $logoPath,
            'deskripsi' => 'Desa Sukamaju adalah desa yang terletak di kaki bukit dengan udara sejuk dan masyarakat yang gotong royong. Desa ini dikenal dengan hasil pertanian sayurannya serta kerajinan tangan masyarakatnya.',
        ]);
    }

    private function seedSejarah(Desa $desa): void
    {
        $fotoPath = 'sejarah-desa/asal-usul.svg';
        Storage::disk('public')->put($fotoPath, $this->placeholderSvg('Dokumentasi Sejarah'));

        $desa->sejarah()->delete();
        $desa->sejarah()->createMany([
            [
                'judul' => 'Asal-usul Nama Desa',
                'isi' => "Pada abad ke-18, kawasan ini dibuka oleh sekelompok petani yang bermukim di dekat mata air. Karena tanahnya subur dan panen selalu berhasil, masyarakat menamai daerah ini Sukamaju.\n\nNama tersebut kemudian resmi digunakan saat pembentukan pemerintahan desa pertama kali.",
                'foto_path' => $fotoPath,
                'urutan' => 1,
            ],
            [
                'judul' => 'Desa pada Era Kemerdekaan',
                'isi' => 'Setelah kemerdekaan, Desa Sukamaju menjadi salah satu pemasok pangan utama di Kecamatan Cisarua. Irigasi sederhana dibangun secara gotong royong pada tahun 1950-an untuk mengairi sawah di tiga dusun.',
                'foto_path' => null,
                'urutan' => 2,
            ],
            [
                'judul' => 'Desa di Era Digital',
                'isi' => 'Memasuki abad ke-21, Desa Sukamaju terus berkembang. Infrastruktur jalan, listrik, dan internet mulai menjangkau seluruh dusun. Kini desa berupaya mewujudkan tata kelola pemerintahan yang transparan melalui sistem informasi desa digital.',
                'foto_path' => null,
                'urutan' => 3,
            ],
        ]);
    }

    private function seedVisiMisi(Desa $desa): void
    {
        $desa->visiMisi()->delete();
        $desa->visiMisi()->createMany([
            ['jenis' => 'visi', 'isi' => 'Terwujudnya Desa Sukamaju yang mandiri, sejahtera, berbudaya, dan berdaya saing berbasis pertanian serta pariwisata desa.', 'urutan' => 1],
            ['jenis' => 'misi', 'isi' => 'Meningkatkan kualitas sumber daya manusia yang beriman, bertakwa, dan berakhlak mulia.', 'urutan' => 1],
            ['jenis' => 'misi', 'isi' => 'Mengembangkan ekonomi masyarakat melalui pertanian organik dan UMKM kerajinan lokal.', 'urutan' => 2],
            ['jenis' => 'misi', 'isi' => 'Membangun infrastruktur desa yang layak, aman, dan berwawasan lingkungan.', 'urutan' => 3],
            ['jenis' => 'misi', 'isi' => 'Meningkatkan tata kelola pemerintahan desa yang bersih, transparan, dan akuntabel.', 'urutan' => 4],
        ]);
    }

    private function seedWilayah(Desa $desa): void
    {
        $geojsonPath = 'wilayah-desa/batas-sukamaju.geojson';
        Storage::disk('public')->put($geojsonPath, $this->boundaryGeojson());

        $desa->wilayah()->delete();
        $desa->wilayah()->create([
            'luas_wilayah' => '425,60 Ha',
            'latitude' => -6.7110,
            'longitude' => 107.4850,
            'batas_utara' => 'Desa Sukarame',
            'batas_selatan' => 'Desa Mekarsari',
            'batas_timur' => 'Kecamatan Lembang',
            'batas_barat' => 'Hutan Lindung Gunung Manglayang',
            'geojson_path' => $geojsonPath,
        ]);
    }

    private function seedPerangkat(Desa $desa): void
    {
        $perangkat = [
            ['nama' => 'H. Ahmad Suryana', 'jabatan' => 'Kepala Desa', 'kontak' => '0812-3456-7890', 'urutan' => 1],
            ['nama' => 'Dewi Lestari, S.E.', 'jabatan' => 'Sekretaris Desa', 'kontak' => '0813-2345-6789', 'urutan' => 2],
            ['nama' => 'Bambang Wijaya', 'jabatan' => 'Kaur Keuangan', 'kontak' => '0857-1234-5678', 'urutan' => 3],
            ['nama' => 'Siti Rahmawati', 'jabatan' => 'Kasi Pelayanan', 'kontak' => '0821-8765-4321', 'urutan' => 4],
        ];

        $desa->perangkat()->delete();
        foreach ($perangkat as $index => $orang) {
            $fotoPath = "perangkat-desa/perangkat-{$index}.svg";
            Storage::disk('public')->put($fotoPath, $this->placeholderSvg($orang['jabatan'], 240));

            $desa->perangkat()->create($orang + ['foto_path' => $fotoPath, 'status' => 'aktif']);
        }
    }

    private function seedStatistik(Desa $desa): void
    {
        $desa->statistik()->delete();
        $desa->statistik()->createMany([
            ['tahun' => 2023, 'jumlah_penduduk' => 4820, 'laki_laki' => 2405, 'perempuan' => 2415, 'jumlah_kk' => 1420, 'jumlah_dusun' => 3],
            ['tahun' => 2024, 'jumlah_penduduk' => 4953, 'laki_laki' => 2460, 'perempuan' => 2493, 'jumlah_kk' => 1478, 'jumlah_dusun' => 3],
            ['tahun' => 2025, 'jumlah_penduduk' => 5104, 'laki_laki' => 2530, 'perempuan' => 2574, 'jumlah_kk' => 1521, 'jumlah_dusun' => 3],
        ]);
    }

    private function seedFasilitas(Desa $desa): void
    {
        $fasilitas = [
            ['nama' => 'Balai Desa Sukamaju', 'kategori' => 'Pemerintahan', 'alamat' => 'Jl. Raya Sukamaju No. 1', 'latitude' => -6.7110, 'longitude' => 107.4850, 'deskripsi' => 'Kantor pusat pemerintahan Desa Sukamaju.'],
            ['nama' => 'Puskesmas Sukamaju', 'kategori' => 'Kesehatan', 'alamat' => 'Jl. Kesehatan No. 12', 'latitude' => -6.7095, 'longitude' => 107.4875, 'deskripsi' => 'Layanan kesehatan utama bagi warga desa.'],
            ['nama' => 'SD Negeri 1 Sukamaju', 'kategori' => 'Pendidikan', 'alamat' => 'Jl. Pendidikan No. 5', 'latitude' => -6.7130, 'longitude' => 107.4820, 'deskripsi' => 'Sekolah dasar negeri dengan 12 ruang kelas.'],
            ['nama' => 'Masjid Al-Ikhlas', 'kategori' => 'Ibadah', 'alamat' => 'Jl. Mesjid No. 2', 'latitude' => -6.7120, 'longitude' => 107.4890, 'deskripsi' => 'Masjid utama desa, pusat kegiatan keagamaan.'],
            ['nama' => 'Pasar Desa Sukamaju', 'kategori' => 'Perekonomian', 'alamat' => 'Jl. Pasar No. 8', 'latitude' => -6.7050, 'longitude' => 107.4860, 'deskripsi' => 'Pasar tradisional buka setiap pagi.'],
        ];

        $desa->fasilitas()->delete();
        foreach ($fasilitas as $index => $item) {
            $fotoPath = "fasilitas-desa/fasilitas-{$index}.svg";
            Storage::disk('public')->put($fotoPath, $this->placeholderSvg($item['nama']));

            $desa->fasilitas()->create($item + ['foto_path' => $fotoPath]);
        }
    }

    private function seedMedia(Desa $desa): void
    {
        $media = [
            ['judul' => 'Balai Desa dari Depan', 'jenis' => 'foto', 'keterangan' => 'Tampak depan balai desa setelah renovasi.'],
            ['judul' => 'Panen Raya Sayur', 'jenis' => 'foto', 'keterangan' => 'Hasil panen sayuran warga dusun timur.'],
            ['judul' => 'Gotong Royong Warga', 'jenis' => 'foto', 'keterangan' => 'Kerja bakti membersihkan saluran irigasi.'],
            ['judul' => 'Peraturan Desa 2025', 'jenis' => 'dokumen', 'keterangan' => 'Salinan peraturan desa hasil musyawarah.'],
        ];

        $desa->media()->delete();
        foreach ($media as $index => $berkas) {
            $filePath = 'media-desa/media-'.$index.($berkas['jenis'] === 'dokumen' ? '.txt' : '.svg');
            Storage::disk('public')->put($filePath, $berkas['jenis'] === 'dokumen'
                ? 'Salinan peraturan desa contoh.'
                : $this->placeholderSvg($berkas['judul'], 480));

            $desa->media()->create($berkas + ['file_path' => $filePath]);
        }
    }

    private function placeholderSvg(string $label, int $width = 480): string
    {
        $label = htmlspecialchars($label, ENT_QUOTES);
        $fontSize = (int) max(14, $width / 22);

        return <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="{$width}" height="320" viewBox="0 0 {$width} 320">
  <rect width="{$width}" height="320" fill="#15803d"/>
  <rect width="{$width}" height="320" fill="url(#g)" opacity="0.35"/>
  <defs>
    <linearGradient id="g" x1="0" y1="0" x2="1" y2="1">
      <stop offset="0" stop-color="#22c55e"/>
      <stop offset="1" stop-color="#14532d"/>
    </linearGradient>
  </defs>
  <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="{$fontSize}" fill="#ffffff" text-anchor="middle" dominant-baseline="middle">{$label}</text>
</svg>
SVG;
    }

    private function boundaryGeojson(): string
    {
        return json_encode([
            'type' => 'FeatureCollection',
            'features' => [
                [
                    'type' => 'Feature',
                    'properties' => (object) ['name' => 'Batas Desa Sukamaju'],
                    'geometry' => [
                        'type' => 'Polygon',
                        'coordinates' => [
                            [
                                [107.4785, -6.7165],
                                [107.4915, -6.7150],
                                [107.4930, -6.7050],
                                [107.4875, -6.6990],
                                [107.4770, -6.7020],
                                [107.4750, -6.7110],
                                [107.4785, -6.7165],
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
