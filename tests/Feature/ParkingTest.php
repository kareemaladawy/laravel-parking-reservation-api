<?php

namespace Tests\Feature;

use App\Models\Parking;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParkingTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanStartParking()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        $zone = Zone::first();

        $response = $this->actingAs($user)->postJson('/api/v1/parkings/start', [
            'vehicle_id' => $vehicle->id,
            'zone_id' => $zone->id,
        ]);

        $response->assertCreated()
            ->assertJsonStructure(['data'])
            ->assertJson([
                'data' => [
                    'start_time' => now()->toDateTimeString(),
                    'stop_time' => null,
                    'total_price' => 0
                ]
            ]);

        $this->assertDatabaseCount('parkings', 1);
    }

    public function testUserCanViewCurrentParkingWithCorrectPrice()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        $zone = Zone::first();

        $this->actingAs($user)->postJson('/api/v1/parkings/start', [
            'vehicle_id' => $vehicle->id,
            'zone_id' => $zone->id,
        ]);

        $time = 2;
        $this->travel($time)->hours();

        $parking = Parking::first();

        $response = $this->actingAs($user)->getJson('/api/v1/parkings/' . $parking->id);

        $updated_parking = Parking::find($parking->id);

        $response->assertOk()
            ->assertJsonStructure(['data'])
            ->assertJson([
                'data' => [
                    'start_time' => $updated_parking->start_time,
                    'stop_time' => null,
                    'total_price' => $zone->price_per_hour * $time
                ]
            ]);

        $this->assertDatabaseCount('parkings', 1);
    }

    public function testUserCanStopParking()
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create(['user_id' => $user->id]);
        $zone = Zone::first();

        $this->actingAs($user)->postJson('/api/v1/parkings/start', [
            'vehicle_id' => $vehicle->id,
            'zone_id' => $zone->id,
        ]);

        $time = 2;
        $this->travel($time)->hours();

        $parking = Parking::first();

        $response = $this->actingAs($user)->putJson('/api/v1/parkings/' . $parking->id);

        $updated_parking = Parking::find($parking->id);

        $response->assertOk()
            ->assertJsonStructure(['data'])
            ->assertJson([
                'data' => [
                    'start_time' => $updated_parking->start_time,
                    'stop_time' => $updated_parking->stop_time,
                    'total_price' => $zone->price_per_hour * $time
                ]
            ]);

        $this->assertDatabaseCount('parkings', 1);
    }
}
