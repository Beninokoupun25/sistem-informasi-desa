<?php

namespace Database\Factories;

use App\Models\Desa;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Desa>
 */
class DesaFactory extends Factory
{
    protected $model = Desa::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = 'Desa '.fake()->unique()->city();

        return [
            'nama_desa' => $nama,
            'slug' => Str::slug($nama),
            'kecamatan' => 'Kecamatan '.fake()->city(),
            'kabupaten' => 'Kabupaten '.fake()->city(),
            'provinsi' => fake()->state(),
            'status' => 'aktif',
        ];
    }
}
