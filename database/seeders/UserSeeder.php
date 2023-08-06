<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;

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
            'name' => 'Guru 1',
            'email' => 'guru_satu@gmail.com',
            'password' => Hash::make('q1w2e3r4'),
            'avatar' => 'default.png',
            'role' => 'guru',
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
