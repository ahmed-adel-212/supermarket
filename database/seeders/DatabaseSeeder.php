<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'email' => 'admintest@gmail.com',
            'type' => 'admin',
            'password' => Hash::make('admin123'),
        ]);

        User::factory()->create([
            'email' => 'ahmed2@gmail.com',
            'type' => 'cashier',
            'password' => Hash::make('admin123'),
        ]);

        User::factory()->create([
            'email' => 'md.sallam@gmail.com',
            'password' => Hash::make('123456789'),
        ]);
    }
}
