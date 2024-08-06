<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Appointment;
use App\Models\User; // Make sure to import User model
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_appointment()
    {
        // Create a doctor user
        $doctor = User::create([
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
            'password' => bcrypt('password'),
            'role' => 'doctor'
        ]);

        // Create an appointment
        $appointment = Appointment::create([
            'client_name' => 'John Doe',
            'client_email' => 'john.doe@example.com',
            'animal_name' => 'Buddy',
            'animal_type' => 'cão',
            'age' => '5',
            'symptoms' => 'Coughing',
            'appointment_date' => '2024-08-14',
            'time_of_day' => 'manhã',
            'doctor_id' => $doctor->id
        ]);

        $this->assertDatabaseHas('appointments', [
            'client_name' => 'John Doe',
            'animal_name' => 'Buddy',
            'animal_type' => 'cão',
            'appointment_date' => '2024-08-14',
            'time_of_day' => 'manhã',
            'doctor_id' => $doctor->id
        ]);
    }

    /** @test */
    public function it_can_update_an_appointment()
    {
        // Create a doctor user
        $doctor = User::create([
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
            'password' => bcrypt('password'),
            'role' => 'doctor'
        ]);

        // Create an appointment
        $appointment = Appointment::create([
            'client_name' => 'John Doe',
            'client_email' => 'john.doe@example.com',
            'animal_name' => 'Buddy',
            'animal_type' => 'cão',
            'age' => '5',
            'symptoms' => 'Coughing',
            'appointment_date' => '2024-08-14',
            'time_of_day' => 'manhã',
            'doctor_id' => $doctor->id
        ]);

        // Update the appointment
        $appointment->update(['client_name' => 'Jane Doe']);

        $this->assertDatabaseHas('appointments', [
            'client_name' => 'Jane Doe'
        ]);
    }

    /** @test */
    public function it_can_delete_an_appointment()
    {
        // Create a doctor user
        $doctor = User::create([
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
            'password' => bcrypt('password'),
            'role' => 'doctor'
        ]);

        // Create an appointment
        $appointment = Appointment::create([
            'client_name' => 'John Doe',
            'client_email' => 'john.doe@example.com',
            'animal_name' => 'Buddy',
            'animal_type' => 'cão',
            'age' => '5',
            'symptoms' => 'Coughing',
            'appointment_date' => '2024-08-14',
            'time_of_day' => 'manhã',
            'doctor_id' => $doctor->id
        ]);

        $appointment->delete();

        $this->assertDatabaseMissing('appointments', [
            'client_name' => 'John Doe'
        ]);
    }
}
