<?php

namespace Tests\Feature;

use App\Models\Desa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ModulProfilDesaTest extends TestCase
{
    use RefreshDatabase;

    private Desa $desa;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->desa = Desa::factory()->create();
        $this->admin = User::factory()->create(['desa_id' => $this->desa->id]);
    }

    public function test_public_can_view_desa_and_content(): void
    {
        $this->desa->sejarah()->create([
            'judul' => 'Asal-usul desa',
            'isi' => 'Dahulu kala...',
            'urutan' => 1,
        ]);

        $this->getJson('/api/desa')
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment(['nama_desa' => $this->desa->nama_desa]);

        $this->getJson("/api/desa/{$this->desa->slug}")
            ->assertOk()
            ->assertJsonFragment(['nama_desa' => $this->desa->nama_desa]);

        $this->getJson("/api/desa/{$this->desa->slug}/sejarah")
            ->assertOk()
            ->assertJsonFragment(['judul' => 'Asal-usul desa']);
    }

    public function test_guest_cannot_create_desa(): void
    {
        $this->postJson('/api/desa', [])->assertUnauthorized();
    }

    public function test_super_admin_can_create_desa_even_when_bound_to_a_desa(): void
    {
        $this->actingAs($this->admin, 'sanctum')
            ->postJson('/api/desa', [
                'nama_desa' => 'Desa Sukamaju',
                'kecamatan' => 'Cisarua',
                'kabupaten' => 'Bandung',
                'provinsi' => 'Jawa Barat',
            ])
            ->assertCreated();
    }

    public function test_super_admin_can_create_desa_with_auto_slug(): void
    {
        $admin = User::factory()->create(['desa_id' => null]);

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/desa', [
                'nama_desa' => 'Desa Sukamaju',
                'kecamatan' => 'Cisarua',
                'kabupaten' => 'Bandung Barat',
                'provinsi' => 'Jawa Barat',
            ])
            ->assertCreated()
            ->assertJsonFragment(['slug' => 'desa-sukamaju', 'status' => 'aktif']);
    }

    public function test_admin_can_manage_own_desa(): void
    {
        $this->actingAs($this->admin, 'sanctum')
            ->putJson("/api/desa/{$this->desa->slug}", ['nama_desa' => 'Desa Sejahtera'])
            ->assertOk()
            ->assertJsonFragment(['nama_desa' => 'Desa Sejahtera']);
    }

    public function test_super_admin_can_manage_other_desa(): void
    {
        $desaLain = Desa::factory()->create();

        $this->actingAs($this->admin, 'sanctum')
            ->putJson("/api/desa/{$desaLain->slug}", ['nama_desa' => 'Direbut'])
            ->assertOk()
            ->assertJsonFragment(['nama_desa' => 'Direbut']);
    }

    public function test_nonaktif_user_cannot_manage_desa(): void
    {
        $user = User::factory()->create(['desa_id' => $this->desa->id, 'status' => 'nonaktif']);

        $this->actingAs($user, 'sanctum')
            ->putJson("/api/desa/{$this->desa->slug}", ['nama_desa' => 'Boleh?'])
            ->assertForbidden();
    }

    public function test_profil_is_upserted_per_desa(): void
    {
        $this->actingAs($this->admin, 'sanctum')
            ->putJson("/api/desa/{$this->desa->slug}/profil", [
                'alamat' => 'Jl. Raya Desa No. 1',
                'telepon' => '08123456789',
            ])
            ->assertOk()
            ->assertJsonFragment(['alamat' => 'Jl. Raya Desa No. 1']);

        $this->assertSame(1, $this->desa->profil()->count());

        $this->actingAs($this->admin, 'sanctum')
            ->putJson("/api/desa/{$this->desa->slug}/profil", [
                'alamat' => 'Jl. Raya Desa No. 2',
            ])
            ->assertOk();

        $this->assertSame(1, $this->desa->profil()->count());
        $this->assertSame('Jl. Raya Desa No. 2', $this->desa->profil()->first()->alamat);
    }

    public function test_sejarah_is_scoped_to_desa(): void
    {
        $desaLain = Desa::factory()->create();
        $sejarah = $this->desa->sejarah()->create([
            'judul' => 'Sejarah kami',
            'isi' => 'Sejarah desa ini',
            'urutan' => 1,
        ]);
        $desaLain->sejarah()->create([
            'judul' => 'Sejarah mereka',
            'isi' => 'Sejarah desa lain',
            'urutan' => 1,
        ]);

        $this->getJson("/api/desa/{$desaLain->slug}/sejarah")
            ->assertOk()
            ->assertJsonCount(1)
            ->assertJsonFragment(['judul' => 'Sejarah mereka']);

        $this->getJson("/api/desa/{$desaLain->slug}/sejarah/{$sejarah->id}")
            ->assertNotFound();
    }

    public function test_statistik_tahun_is_unique_per_desa(): void
    {
        $payload = [
            'tahun' => 2025,
            'jumlah_penduduk' => 5000,
            'laki_laki' => 2500,
            'perempuan' => 2500,
            'jumlah_kk' => 1500,
            'jumlah_dusun' => 4,
        ];

        $this->actingAs($this->admin, 'sanctum')
            ->postJson("/api/desa/{$this->desa->slug}/statistik", $payload)
            ->assertCreated();

        $this->actingAs($this->admin, 'sanctum')
            ->postJson("/api/desa/{$this->desa->slug}/statistik", $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors('tahun');

        $desaLain = Desa::factory()->create();
        $this->actingAs($this->admin, 'sanctum')
            ->postJson("/api/desa/{$desaLain->slug}/statistik", $payload)
            ->assertCreated();
    }

    public function test_media_upload_stores_file_on_public_disk(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin, 'sanctum')
            ->post("/api/desa/{$this->desa->slug}/media", [
                'judul' => 'Foto kantor desa',
                'jenis' => 'foto',
                'keterangan' => 'Kantor desa',
                'file' => UploadedFile::fake()->image('kantor.jpg'),
            ])
            ->assertCreated()
            ->assertJsonFragment(['judul' => 'Foto kantor desa']);

        $media = $this->desa->media()->first();

        $this->assertNotNull($media);
        Storage::disk('public')->assertExists($media->file_path);
    }

    public function test_guest_cannot_delete_desa(): void
    {
        $this->deleteJson("/api/desa/{$this->desa->slug}")->assertUnauthorized();

        $this->assertDatabaseHas('desa', ['id' => $this->desa->id]);
    }
}
