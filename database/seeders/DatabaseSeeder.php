<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user (idempotent)
        User::firstOrCreate(
            ['email' => 'admin@formularium.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Jl. Rumah Sakit No. 1, Jakarta',
            ]
        );

        // Create apoteker user (idempotent)
        User::firstOrCreate(
            ['email' => 'apoteker@formularium.com'],
            [
                'name' => 'Apoteker',
                'password' => Hash::make('password'),
                'role' => 'apoteker',
                'phone' => '081234567891',
                'address' => 'Jl. Rumah Sakit No. 2, Jakarta',
            ]
        );

        // Call MedicineSeeder
        $this->call([
            MedicineSeeder::class,
        ]);
    }
}
