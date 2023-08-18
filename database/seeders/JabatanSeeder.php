<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jabatan;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jabatan::create([
            'id' => '1',
            'name' => 'Kepala Sekolah',
        ]);
        Jabatan::create([
            'id' => '2',
            'name' => 'Wakil Kepala Sekolah Bidang Kurikulum',
        ]);
        Jabatan::create([
            'id' => '3',
            'name' => 'Wakil Kepala Sekolah Bidang Kesiswaan',
        ]);
        Jabatan::create([
            'id' => '4',
            'name' => 'Wali Kelas',
        ]);
        Jabatan::create([
            'id' => '5',
            'name' => 'Guru',
        ]);
        Jabatan::create([
            'id' => '6',
            'name' => 'Kepala Kompetensi Keahlian Multimedia',
        ]);
        Jabatan::create([
            'id' => '7',
            'name' => 'Kepala Kompetensi Keahlian Teknik Komputer & Jaringan',
        ]);
        Jabatan::create([
            'id' => '8',
            'name' => 'Kepala Kompetensi Keahlian Rekayasa Perangkat Lunak',
        ]);
        Jabatan::create([
            'id' => '10',
            'name' => 'Wakil Kepala Sekolah Bidang DuDi & HuMas',
        ]);
        Jabatan::create([
            'id' => '11',
            'name' => 'Guru Bimbingan Konseling',
        ]);
        Jabatan::create([
            'id' => '12',
            'name' => 'Kepala Tata Usaha',
        ]);
        Jabatan::create([
            'id' => '13',
            'name' => 'Ketua Manajemen Mutu',
        ]);
        Jabatan::create([
            'id' => '14',
            'name' => 'Pembina OSIS',
        ]);
        Jabatan::create([
            'id' => '16',
            'name' => 'Kepala Lab Information & Communication Technology',
        ]);
        Jabatan::create([
            'id' => '17',
            'name' => 'Kepala Kompetensi Keahlian Produksi & Siaran Program Televisi',
        ]);
    }
}
