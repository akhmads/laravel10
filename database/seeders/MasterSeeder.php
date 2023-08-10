<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tapel;
use App\Models\Prodi;
use App\Models\Guru;

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

        Guru::create([
            'name' => 'Akhmad Shaleh, S.Kom',
            'nip' => '91077654321',
            'gender' => 'L',
        ]);
        Guru::create([
            'name' => 'Raisa Andriana, S.T',
            'nip' => '80076543212',
            'gender' => 'P',
        ]);
    }
}
