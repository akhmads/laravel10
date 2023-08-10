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
            'title' => 'Component',
            'parent_id' => '0',
            'url' => 'livewire',
            'scope' => 'livewire.index',
            'icon' => 'fa fa-cube',
        ]);
    }
}
