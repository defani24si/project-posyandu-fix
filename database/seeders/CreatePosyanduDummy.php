<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class CreatePosyanduDummy extends Seeder
{
    public function run()
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 100) as $index) {
            DB::table('posyandu')->insert([
                'nama'    => 'Posyandu ' . $faker->city . ' ' . $index,
                'alamat'  => $faker->address,
                'rt'      => str_pad($faker->numberBetween(1, 20), 3, '0', STR_PAD_LEFT),
                'rw'      => str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'kontak'  => $faker->phoneNumber,
                'foto'    => null,
                'files'   => null,
            ]);
        }
    }
}