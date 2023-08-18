<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'id' => '1',
            'title' => 'Master Data',
            'parent_id' => '0',
            'url' => '#',
            'scope' => 'master*',
            'icon' => 'fa fa-database',
            'ord' => '3',
        ]);
        Menu::create([
            'id' => '2',
            'title' => 'Jadwal Pelajaran',
            'parent_id' => '0',
            'url' => 'admin/jadwal-pelajaran',
            'scope' => 'jadwal*',
            'icon' => 'fa fa-calendar',
            'ord' => '4',
        ]);
        Menu::create([
            'title' => 'Home',
            'parent_id' => '0',
            'url' => '/',
            'scope' => '',
            'icon' => 'fa fa-home',
            'ord' => '1',
        ]);
        Menu::create([
            'title' => 'Component',
            'parent_id' => '0',
            'url' => 'livewire',
            'scope' => 'livewire.index',
            'icon' => 'fa fa-cube',
            'ord' => '2',
        ]);

        Menu::create([
            'title' => 'Siswa',
            'parent_id' => '1',
            'url' => 'admin/siswa',
        ]);
        Menu::create([
            'title' => 'Guru',
            'parent_id' => '1',
            'url' => 'admin/guru',
        ]);
        Menu::create([
            'title' => 'Tahun Pelajaran',
            'parent_id' => '1',
            'url' => 'admin/tahun-pelajaran',
        ]);
        Menu::create([
            'title' => 'Program Studi',
            'parent_id' => '1',
            'url' => 'admin/program-studi',
        ]);
        Menu::create([
            'title' => 'Mata Pelajaran',
            'parent_id' => '1',
            'url' => 'admin/mata-pelajaran',
        ]);
        Menu::create([
            'title' => 'Jabatan',
            'parent_id' => '1',
            'url' => 'admin/jabatan',
        ]);
        Menu::create([
            'title' => 'Ruangan',
            'parent_id' => '1',
            'url' => 'admin/ruangan',
        ]);
        Menu::create([
            'title' => 'Kelas',
            'parent_id' => '1',
            'url' => 'admin/kelas',
        ]);
    }
}
