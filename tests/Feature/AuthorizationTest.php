<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function receptionist_can_access_appointments()
    {
        $user = User::factory()->create(['role' => 'receptionist']);
        $this->actingAs($user);

        $response = $this->get(route('appointments.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function doctor_can_access_appointments()
    {
        $user = User::factory()->create(['role' => 'doctor']);
        $this->actingAs($user);

        $response = $this->get(route('appointments.index'));

        $response->assertStatus(200);
    }
}
