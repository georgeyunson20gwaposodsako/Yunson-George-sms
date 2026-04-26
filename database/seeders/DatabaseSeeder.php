<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Secretary User',
            'email' => 'Secretary@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Secretary123'),
            'role' => 'secretary',
        ]);

        // Optional: student sample
        \App\Models\User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@gmail.com',
            'password' => \Illuminate\Support\Facades\Hash::make('Student123'),
            'role' => 'student',
        ]);
    }
}

