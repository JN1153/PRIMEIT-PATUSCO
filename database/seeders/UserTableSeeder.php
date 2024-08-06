<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Recepcionista',
            'email' => 'recepcionista@example.com',
            'password' => Hash::make('password'),
            'role' => 'receptionist',
        ]);

        // Criar médicos
        $doctorNames = ['Dr. João', 'Dra. Maria', 'Dr. Pedro'];

        foreach ($doctorNames as $name) {
            User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '', $name)) . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'doctor',
            ]);
        }
    }
}
