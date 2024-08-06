<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;

class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = User::where('role', 'doctor')->get();
        $doctorCount = $doctors->count();
        $animalTypes = ['cão', 'gato', 'tartaruga', 'pato', 'galinha'];
        $timeOfDayOptions = ['manhã', 'tarde'];

        for ($i = 0; $i < 20; $i++) {
            Appointment::create([
                'client_name' => fake()->name,
                'client_email' => fake()->unique()->safeEmail,
                'animal_name' => fake()->word,
                'animal_type' => $animalTypes[array_rand($animalTypes)],
                'age' => fake()->numberBetween(1, 15),
                'symptoms' => fake()->sentence,
                'appointment_date' => Carbon::now()->addDays(fake()->numberBetween(1, 30))->toDateString(),
                'time_of_day' => fake()->randomElement($timeOfDayOptions), // Corrigir valores
                'doctor_id' => $doctors->random()->id, // Associar marcações a médicos
            ]);
        }
    }
}
