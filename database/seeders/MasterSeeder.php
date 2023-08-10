<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tapel;
use App\Models\Prodi;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tapel::create([
            'tapel' => '2022/2023 Ganjil',
        ]);
        Tapel::create([
            'tapel' => '2022/2023 Genap',
        ]);

        Prodi::create([
            'code' => 'RPL',
            'name' => 'Rekayasa Perangkat Lunak',
        ]);
        Prodi::create([
            'code' => 'TKJ',
            'name' => 'Teknik Komputer Jaringan',
        ]);
        Prodi::create([
            'code' => 'DKV',
            'name' => 'Desain Komunikasi Visual',
        ]);
    }
}
