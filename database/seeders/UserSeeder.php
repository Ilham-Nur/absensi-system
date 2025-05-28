<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $OwnerRole = Role::where('name', 'Owner')->first();
        $userRole = Role::where('name', 'User')->first();

        // Menambahkan user admin
        User::create([
            'name' => 'Owner User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $OwnerRole->id,
        ]);

        // Menambahkan user biasa
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $userRole->id,
        ]);

        // Menambahkan user Tyo
        User::create([
            'name' => 'Tyo',
            'email' => 'tyo@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $userRole->id,
        ]);

        // Menambahkan user Riyan
        User::create([
            'name' => 'Riyan',
            'email' => 'riyan@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $userRole->id,
        ]);

        // Menambahkan user Ilham
        User::create([
            'name' => 'Ilham',
            'email' => 'ilham@example.com',
            'password' => Hash::make('password123'),
            'role_id' => $userRole->id,
        ]);
    }
}

