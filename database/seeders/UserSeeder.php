<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Rizal Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'administrator',
                'status' => 'aktif'
            ],
            [
                'name' => 'Rizal Petugas',
                'email' => 'petugas@gmail.com',
                'password' => Hash::make('petugas123'),
                'role' => 'petugas',
                'status' => 'aktif'
            ]
        ];

        foreach ($data as $d) {
            User::create($d);
        }
    }
}
