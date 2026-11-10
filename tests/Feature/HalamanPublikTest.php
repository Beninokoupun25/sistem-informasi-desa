<?php

namespace Tests\Feature;

use App\Models\Desa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HalamanPublikTest extends TestCase
{
    use RefreshDatabase;

    private Desa $desa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->desa = Desa::factory()->create(['nama_desa' => 'Desa Contoh']);
        $this->desa->profil()->create([
            'alamat' => 'Jl. Contoh No. 1',
            'deskripsi' => 'Deskripsi desa contoh.',
        ]);
        $this->desa->sejarah()->create(['judul' => 'Asal-usul', 'isi' => 'Narasi sejarah.', 'urutan' => 1]);
        $this->desa->visiMisi()->create(['jenis' => 'visi', 'isi' => 'Visi desa contoh.', 'urutan' => 1]);
        $this->desa->wilayah()->create([
            'luas_wilayah' => '250 Ha',
            'latitude' => -6.7110,
            'longitude' => 107.4850,
            'batas_utara' => 'Desa Sukarame',
            'batas_selatan' => 'Desa Mekarsari',
            'batas_timur' => 'Kecamatan Lembang',
            'batas_barat' => 'Hutan Lindung',
        ]);
        $this->desa->statistik()->create([
            'tahun' => 2025,
            'jumlah_penduduk' => 1000,
            'laki_laki' => 500,
            'perempuan' => 500,
            'jumlah_kk' => 300,
            'jumlah_dusun' => 2,
        ]);
    }

    public function test_semua_halaman_publik_merender_data_desa(): void
    {
        $halaman = [
            ['uri' => '/', 'lihat' => 'Desa Contoh'],
            ['uri' => '/sejarah', 'lihat' => 'Asal-usul'],
            ['uri' => '/visi-misi', 'lihat' => 'Visi desa contoh.'],
            ['uri' => '/wilayah', 'lihat' => 'Kartu Wilayah'],
            ['uri' => '/perangkat', 'lihat' => 'belum tersedia'],
            ['uri' => '/statistik', 'lihat' => '1.000'],
            ['uri' => '/fasilitas', 'lihat' => 'belum tersedia'],
            ['uri' => '/media', 'lihat' => 'belum tersedia'],
        ];

        foreach ($halaman as $item) {
            $this->get($item['uri'])
                ->assertOk()
                ->assertSee($item['lihat'], false);
        }
    }

    public function test_halaman_404_bila_belum_ada_desa_aktif(): void
    {
        $this->desa->update(['status' => 'nonaktif']);

        $this->get('/')->assertNotFound();
    }

    public function test_pengunjung_bisa_berpindah_desa_per_sesi(): void
    {
        $kedua = Desa::factory()->create(['nama_desa' => 'Desa Kedua']);
        $kedua->profil()->create(['alamat' => 'Jl. Kedua No. 2']);
        $kedua->sejarah()->create(['judul' => 'Sejarah desa kedua', 'isi' => 'Narasi desa kedua.', 'urutan' => 1]);

        $this->get('/')->assertSee('Desa Contoh', false);

        $this->post('/pilih-desa', ['slug' => $kedua->slug, 'kembali' => url('/')])
            ->assertRedirect('/');

        $this->get('/')->assertSee('Desa Kedua', false);
        $this->get('/sejarah')
            ->assertOk()
            ->assertSee('Sejarah desa kedua', false)
            ->assertDontSee('Narasi sejarah.', false);
    }

    public function test_sesi_tetap_valid_bila_desa_terpilih_di_nonaktifkan(): void
    {
        session(['desa_slug' => $this->desa->slug]);
        $this->desa->update(['status' => 'nonaktif']);

        $cadangan = Desa::factory()->create(['nama_desa' => 'Desa Cadangan', 'status' => 'nonaktif']);

        // tidak ada desa aktif sama sekali -> 404
        $this->get('/')->assertNotFound();

        // desa aktif lain tersedia -> fallback ke desa aktif itu
        $cadangan->update(['status' => 'aktif']);
        $this->get('/')->assertSee('Desa Cadangan', false);
    }

    public function test_pilih_desa_nonaktif_atau_tidak_ada_menghasilkan_404(): void
    {
        $nonaktif = Desa::factory()->create(['status' => 'nonaktif']);

        $this->post('/pilih-desa', ['slug' => $nonaktif->slug])->assertNotFound();
        $this->post('/pilih-desa', ['slug' => 'tidak-ada'])->assertNotFound();
    }

    public function test_redirect_kembali_hanya_untuk_url_lokal(): void
    {
        $kedua = Desa::factory()->create(['nama_desa' => 'Desa Kedua']);

        $this->post('/pilih-desa', ['slug' => $kedua->slug, 'kembali' => 'http://jahat.example.com'])
            ->assertRedirect(route('beranda'));
    }
}
