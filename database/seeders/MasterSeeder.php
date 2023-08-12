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
            'code' => '2022-2023',
        ]);

        Prodi::create([
            'code' => 'TKJ',
            'name' => 'Teknik Komputer & Jaringan',
            'guru_code' => '20191019920617',
        ]);
        Prodi::create([
            'code' => 'RPL',
            'name' => 'Rekayasa Perangkat Lunak',
            'guru_code' => '20170719941015',
        ]);
        Prodi::create([
            'code' => 'PSPT',
            'name' => 'Produksi & Siaran Program Televisi',
            'guru_code' => '20190719860620',
        ]);
        Prodi::create([
            'code' => 'MM',
            'name' => 'Multimedia',
            'guru_code' => '20080719810623',
        ]);
    }
}
