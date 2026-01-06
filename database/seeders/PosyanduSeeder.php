<?php
namespace Database\Seeders;

use App\Models\Posyandu;
use Illuminate\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    public function run()
    {
        $posyandus = [
            [
                'nama' => 'Posyandu Melati',
                'alamat' => 'Jl. Melati No. 1, Kelurahan Sari',
                'rt' => '01',
                'rw' => '01',
                'kontak' => '081234567890',
            ],
            [
                'nama' => 'Posyandu Mawar',
                'alamat' => 'Jl. Mawar No. 15, Kelurahan Indah',
                'rt' => '02',
                'rw' => '01',
                'kontak' => '081234567891',
            ],
            [
                'nama' => 'Posyandu Anggrek',
                'alamat' => 'Jl. Anggrek No. 8, Kelurahan Sejahtera',
                'rt' => '03',
                'rw' => '01',
                'kontak' => '081234567892',
            ],
            [
                'nama' => 'Posyandu Kamboja',
                'alamat' => 'Jl. Kamboja No. 12, Kelurahan Damai',
                'rt' => '04',
                'rw' => '01',
                'kontak' => '081234567893',
            ],
            [
                'nama' => 'Posyandu Tulip',
                'alamat' => 'Jl. Tulip No. 5, Kelurahan Bahagia',
                'rt' => '01',
                'rw' => '02',
                'kontak' => '081234567894',
            ],
            [
                'nama' => 'Posyandu Dahlia',
                'alamat' => 'Jl. Dahlia No. 20, Kelurahan Maju',
                'rt' => '02',
                'rw' => '02',
                'kontak' => '081234567895',
            ],
            [
                'nama' => 'Posyandu Kenanga',
                'alamat' => 'Jl. Kenanga No. 7, Kelurahan Tentram',
                'rt' => '03',
                'rw' => '02',
                'kontak' => '081234567896',
            ],
            [
                'nama' => 'Posyandu Cempaka',
                'alamat' => 'Jl. Cempaka No. 18, Kelurahan Rukun',
                'rt' => '04',
                'rw' => '02',
                'kontak' => '081234567897',
            ],
            [
                'nama' => 'Posyandu Flamboyan',
                'alamat' => 'Jl. Flamboyan No. 3, Kelurahan Harmoni',
                'rt' => '01',
                'rw' => '03',
                'kontak' => '081234567898',
            ],
            [
                'nama' => 'Posyandu Bougenville',
                'alamat' => 'Jl. Bougenville No. 25, Kelurahan Asri',
                'rt' => '02',
                'rw' => '03',
                'kontak' => '081234567899',
            ],
            [
                'nama' => 'Posyandu Teratai',
                'alamat' => 'Jl. Teratai No. 11, Kelurahan Bersih',
                'rt' => '03',
                'rw' => '03',
                'kontak' => '081234567800',
            ],
            [
                'nama' => 'Posyandu Seroja',
                'alamat' => 'Jl. Seroja No. 14, Kelurahan Sehat',
                'rt' => '04',
                'rw' => '03',
                'kontak' => '081234567801',
            ],
            [
                'nama' => 'Posyandu Sakura',
                'alamat' => 'Jl. Sakura No. 9, Kelurahan Cantik',
                'rt' => '01',
                'rw' => '04',
                'kontak' => '081234567802',
            ],
            [
                'nama' => 'Posyandu Lavender',
                'alamat' => 'Jl. Lavender No. 22, Kelurahan Wangi',
                'rt' => '02',
                'rw' => '04',
                'kontak' => '081234567803',
            ],
            [
                'nama' => 'Posyandu Jasmine',
                'alamat' => 'Jl. Jasmine No. 6, Kelurahan Harum',
                'rt' => '03',
                'rw' => '04',
                'kontak' => '081234567804',
            ],
        ];

        foreach ($posyandus as $posyandu) {
            // Cek apakah posyandu sudah ada berdasarkan nama
            $existing = Posyandu::where('nama', $posyandu['nama'])->first();
            
            if (!$existing) {
                Posyandu::create($posyandu);
                $this->command->info('Posyandu ' . $posyandu['nama'] . ' berhasil dibuat!');
            } else {
                $this->command->info('Posyandu ' . $posyandu['nama'] . ' sudah ada.');
            }
        }
    }
}
