<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')->where('role', '!=', 'super_admin')->update(['role' => 'super_admin']);

        DB::statement("ALTER TABLE users ALTER role SET DEFAULT 'super_admin'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users ALTER role SET DEFAULT 'admin'");
    }
};
