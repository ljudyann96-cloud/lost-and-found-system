<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Account
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // Palitan ang password kunggusto mo
            'role' => 'admin', // O kung anuman ang tawag sa role column mo
        ]);

        // Faculty Account
        User::create([
            'name' => 'Faculty Member',
            'email' => 'faculty@example.com',
            'password' => Hash::make('password'),
            'role' => 'faculty',
        ]);

        // Student Account
        User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);
    }
}