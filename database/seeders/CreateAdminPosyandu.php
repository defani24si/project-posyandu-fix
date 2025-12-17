<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CreateAdminPosyandu extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cek apakah user admin sudah ada
        $existingAdmin = User::where('email', 'admin@posyandu.id')->first();
        
        if (!$existingAdmin) {
            User::create([
                'name' => 'Admin Posyandu',
                'email' => 'admin@posyandu.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'foto_profil' => null,
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Admin Posyandu berhasil dibuat!');
        } else {
            $this->command->info('Admin Posyandu sudah ada.');
        }
        
        // Buat beberapa user kader contoh
        $kaders = [
            [
                'name' => 'Kader 1',
                'email' => 'kader1@posyandu.id',
                'password' => Hash::make('kader123'),
                'role' => 'kader',
            ],
            [
                'name' => 'Kader 2',
                'email' => 'kader2@posyandu.id',
                'password' => Hash::make('kader123'),
                'role' => 'kader',
            ],
        ];
        
        foreach ($kaders as $kader) {
            $existingKader = User::where('email', $kader['email'])->first();
            
            if (!$existingKader) {
                User::create($kader);
                $this->command->info('Kader ' . $kader['name'] . ' berhasil dibuat!');
            }
        }
    }
}