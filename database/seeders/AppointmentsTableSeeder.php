<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker;

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
                'client_name' => $faker->name,
                'client_email' => $faker->unique()->safeEmail,
                'animal_name' => $faker->word,
                'animal_type' => $animalTypes[array_rand($animalTypes)],
                'age' => $faker->numberBetween(1, 15),
                'symptoms' => $faker->sentence,
                'appointment_date' => Carbon::now()->addDays($faker->numberBetween(1, 30))->toDateString(),
                'time_of_day' => $faker->randomElement($timeOfDayOptions), // Corrigir valores
                'doctor_id' => $doctors->random()->id, // Associar marcações a médicos
            ]);
        }
    }
}
