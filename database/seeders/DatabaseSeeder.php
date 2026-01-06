<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Jalankan seeder untuk membuat admin dan kader
        $this->call([
            CreateAdminPosyandu::class,
            PosyanduSeeder::class,
            JadwalPosyanduSeeder::class,
        ]);
    }
}
