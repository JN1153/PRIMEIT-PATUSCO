<?php

namespace Database\Factories;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $doctors = User::where('role', 'doctor')->get();
        $doctorCount = $doctors->count();
        $animalTypes = ['cão', 'gato', 'tartaruga', 'pato', 'galinha'];
        $timeOfDayOptions = ['manhã', 'tarde'];

        return [
            'client_name' => $this->faker->name,
            'client_email' => $this->faker->unique()->safeEmail,
            'animal_name' => $this->faker->word,
            'animal_type' => $animalTypes[array_rand($animalTypes)],
            'age' => $this->faker->numberBetween(1, 15),
            'symptoms' => $this->faker->sentence,
            'appointment_date' => Carbon::now()->addDays($this->faker->numberBetween(1, 30))->toDateString(),
            'time_of_day' => $this->faker->randomElement($timeOfDayOptions), // Corrigir valores
            'doctor_id' => $doctors->random()->id, // Associar marcações a médicos
        ];
    }
}
