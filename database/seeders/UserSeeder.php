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
    }
}

