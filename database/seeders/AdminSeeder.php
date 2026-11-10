<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Role tunggal: super_admin (akses lintas desa).
        User::updateOrCreate(
            ['email' => 'admin@desa.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'desa_id' => null,
                'role' => 'super_admin',
                'status' => 'aktif',
            ]
        );

        User::where('email', 'superadmin@desa.id')->delete();
    }
}
