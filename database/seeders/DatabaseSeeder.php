<?php

namespace Database\Seeders;

use Hash;
use App\Models\Storekeeper;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Storekeeper::create([
            'password' => Hash::make("123456789"),
            'username' => 'Ma3rof',
        ]);
    }
}
