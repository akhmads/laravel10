<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\Menu;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'admin',
        ]);
        User::create([
            'name' => 'Akhmad Shaleh',
            'email' => 'akhmadshaleh@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'guru',
        ]);
        User::create([
            'name' => 'Munajat Wisnugroho',
            'email' => 'mwisnugroho@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'siswa',
        ]);
        User::create([
            'name' => 'Teddo Tandiyono',
            'email' => 'teddo@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'guru',
        ]);
        User::create([
            'name' => 'Carolus Subroto',
            'email' => 'carolus@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'siswa',
        ]);
        User::create([
            'name' => 'Calvin Chan',
            'email' => 'calvin@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'siswa',
        ]);
        User::create([
            'name' => 'Miftahul Ulumuddin',
            'email' => 'udin@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'siswa',
        ]);
        User::create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'siswa',
        ]);
        User::create([
            'name' => 'Jane Doe',
            'email' => 'jane@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'siswa',
        ]);
        User::create([
            'name' => 'Taylor Otwell',
            'email' => 'taylor@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'siswa',
        ]);
        User::create([
            'name' => 'Caleb Porzio',
            'email' => 'caleb@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'siswa',
        ]);
        User::create([
            'name' => 'Popilas Korov',
            'email' => 'popilas@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'siswa',
        ]);

        Role::create(['name' => 'user.index']);
        Role::create(['name' => 'user.create']);
        Role::create(['name' => 'user.update']);
        Role::create(['name' => 'user.delete']);

        RoleUser::create(['user_id' => '1','role_id' => '1']);
        RoleUser::create(['user_id' => '1','role_id' => '2']);
        RoleUser::create(['user_id' => '1','role_id' => '3']);
    }
}
