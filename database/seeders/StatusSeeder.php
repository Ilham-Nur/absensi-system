<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status')->insert([
            ['name' => 'Masuk', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Terlambat', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
