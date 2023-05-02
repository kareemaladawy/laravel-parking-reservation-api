<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Vehicle;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Resources\VehicleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Vehicles
 */
class VehicleController extends Controller
{
    /**
     * View your vehicles
     *
     * This endpoint allows you to view all of your vehicles.
     */
    public function index()
    {
        return VehicleResource::collection(Vehicle::all());
    }

   /**
     * Add a new vehicle
     *
     * This endpoint allows you to add a new vehicle.
     */
    public function store(StoreVehicleRequest $request)
    {
        $vehicle = Vehicle::create($request->validated());

        return VehicleResource::make($vehicle);
    }

    /**
     * View a specific vehicle
     *
     * This endpoint allows you to view the details of a specific vehicle.
     */
    public function show(Vehicle $vehicle)
    {
        return VehicleResource::make($vehicle);
    }

    /**
     * Update a vehicle
     *
     * This endpoint allows you to update the details of a specific vehicle.
     */
    public function update(StoreVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return response()->json(VehicleResource::make($vehicle), Response::HTTP_ACCEPTED);
    }

    /**
     * Remove a vehicle
     *
     * This endpoint allows you to remove a specific vehicle from your vehicles.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->noContent();
    }
}
