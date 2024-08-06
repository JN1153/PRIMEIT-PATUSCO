<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash; // Import the Hash facade

class AppointmentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function receptionist_can_create_an_appointment()
    {
        // Create a receptionist user
        $user = User::create([
            'name' => 'Receptionist',
            'email' => 'receptionist@example.com',
            'password' => Hash::make('password'), // Use Hash facade
            'role' => 'receptionist'
        ]);

        // Acting as the receptionist
        $this->actingAs($user);

        // Create a doctor user
        $doctor = User::create([
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
            'password' => Hash::make('password'), // Use Hash facade
            'role' => 'doctor'
        ]);

        // Send request to create an appointment
        $response = $this->post(route('appointments.store'), [
            'client_name' => 'John Doe',
            'client_email' => 'john.doe@example.com',
            'animal_name' => 'Buddy',
            'animal_type' => 'cão', // Valid enum value
            'age' => '5',
            'symptoms' => 'Coughing',
            'appointment_date' => '2024-08-14',
            'time_of_day' => 'manhã', // Valid enum value
            'doctor_id' => $doctor->id
        ]);

        $response->assertRedirect(route('appointments.index'));
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
    public function receptionist_can_update_any_appointment()
    {
        // Create a receptionist user
        $user = User::create([
            'name' => 'Receptionist',
            'email' => 'receptionist@example.com',
            'password' => Hash::make('password'), // Use Hash facade
            'role' => 'receptionist'
        ]);

        // Acting as the receptionist
        $this->actingAs($user);

        // Create a doctor user
        $doctor = User::create([
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
            'password' => Hash::make('password'), // Use Hash facade
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
        $response = $this->post(route('appointments.store', $appointment->id), [
            'client_name' => 'Jane Doe',
            'client_email' => 'john.doe@example.com',
            'animal_name' => 'Buddy',
            'animal_type' => 'cão',
            'age' => '5',
            'symptoms' => 'Coughing',
            'appointment_date' => '2024-08-14',
            'time_of_day' => 'manhã',
            'doctor_id' => $doctor->id
        ]);
        $response->assertRedirect(route('appointments.index'));
        $this->assertDatabaseHas('appointments', [
            'client_name' => 'Jane Doe'
        ]);
    }

    /** @test */
    public function receptionist_can_delete_any_appointment()
    {
        // Create a receptionist user
        $user = User::create([
            'name' => 'Receptionist',
            'email' => 'receptionist@example.com',
            'password' => Hash::make('password'), // Use Hash facade
            'role' => 'receptionist'
        ]);

        // Acting as the receptionist
        $this->actingAs($user);

        // Create a doctor user
        $doctor = User::create([
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
            'password' => Hash::make('password'), // Use Hash facade
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

        // Send request to delete the appointment
        $response = $this->delete(route('appointments.destroy', $appointment->id));

        $response->assertRedirect(route('appointments.index'));
        $this->assertDatabaseMissing('appointments', [
            'client_name' => 'John Doe'
        ]);
    }

    /** @test */
    public function doctor_cannot_delete_appointments()
    {
        // Create a doctor user
        $doctor = User::create([
            'name' => 'Dr. Smith',
            'email' => 'dr.smith@example.com',
            'password' => Hash::make('password'), // Use Hash facade
            'role' => 'doctor'
        ]);

        // Create a receptionist user
        $receptionist = User::create([
            'name' => 'Receptionist',
            'email' => 'receptionist@example.com',
            'password' => Hash::make('password'), // Use Hash facade
            'role' => 'receptionist'
        ]);

        // Acting as the receptionist
        $this->actingAs($receptionist);

        // Create an appointment assigned to the doctor
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

        // Acting as the doctor
        $this->actingAs($doctor);

        // Attempt to delete the appointment
        $response = $this->delete(route('appointments.destroy', $appointment->id));

        $response->assertStatus(403); // Expecting forbidden status
        $this->assertDatabaseHas('appointments', [
            'client_name' => 'John Doe'
        ]);
    }
}
