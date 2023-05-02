<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehicleTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanGetTheirOwnVehicles()
    {
        $kareem = User::factory()->create();
        $vehicleForKareem = Vehicle::factory()->create([
            'user_id' => $kareem->id
        ]);

        $john = User::factory()->create();
        $vehicleForJohn = Vehicle::factory()->create([
            'user_id' => $john->id
        ]);

        $response = $this->actingAs($kareem)->get('/api/v1/vehicles');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.plate_number', $vehicleForKareem->plate_number)
            ->assertJsonMissing($vehicleForJohn->toArray())
            ->assertJsonStructure(['data' => [
                ['*' => 'id', '*' => 'plate_number']
            ]]);
    }

    public function testUserCanCreateAVehicle()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/v1/vehicles', [
            'plate_number' => '99BN'
        ]);

        $response->assertStatus(201)
            ->assertJsonCount(1)
            ->assertJsonCount(2, 'data')
            ->assertJsonStructure([
                'data' => ['*' => 'id', '*' => 'plate_number']
            ])
            ->assertJsonPath('data.plate_number', '99BN');

        $this->assertDatabaseHas('vehicles', [
            'plate_number' => '99BN'
        ]);
    }

    public function testUserCanUpdateTheirVehicle()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->putJson('/api/v1/vehicles/' . $vehicle->id, [
            'plate_number' => 'BDDF8'
        ]);

        $response->assertStatus(202)
            ->assertJsonCount(2)
            ->assertJsonStructure(['id','plate_number'])
            ->assertJsonPath('plate_number', 'BDDF8');

        $this->assertDatabaseHas('vehicles', [
            'plate_number' => 'BDDF8'
        ]);
    }

    public function testUserCanDeleteTheirVehicle()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->DeleteJson('/api/v1/vehicles/' . $vehicle->id);

        $response->assertNoContent();

        $this->assertDatabaseMissing('vehicles', [
            'id' => $vehicle->id,
            'deleted_at' => null
        ])->assertDatabaseCount('vehicles', 1);
    }


}
