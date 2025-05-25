<?php


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Pemilik User',
            'email' => 'pemilik@example.com',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
        ]);

        User::create([
            'name' => 'Peminjam User',
            'email' => 'peminjam@example.com',
            'password' => Hash::make('password'),
            'role' => 'peminjam',
        ]);
    }
}
