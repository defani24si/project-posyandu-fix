<?php
namespace Database\Seeders;

use App\Models\Posyandu;
use Illuminate\Database\Seeder;

class PosyanduSeeder extends Seeder
{
    public function run()
    {
        $this->call(PosyanduSeeder::class);
        $posyandus = [
            [
                'posyandu_id' => 'POS001',
                'nama'        => 'Posyandu Melati',
                'alamat'      => 'Jl. Melati No. 1',
            ],
            [
                'posyandu_id' => 'POS002',
                'nama'        => 'Posyandu Mawar',
                'alamat'      => 'Jl. Mawar No. 2',
            ],
            [
                'posyandu_id' => 'POS003',
                'nama'        => 'Posyandu Anggrek',
                'alamat'      => 'Jl. Anggrek No. 3',
            ],
            [
                'posyandu_id' => 'POS004',
                'nama'        => 'Posyandu Kambo
                
                ja',
                'alamat'      => 'Jl. Kamboja No. 4',
            ],
        ];

        foreach ($posyandus as $posyandu) {
            Posyandu::create($posyandu);
        }
    }
}
