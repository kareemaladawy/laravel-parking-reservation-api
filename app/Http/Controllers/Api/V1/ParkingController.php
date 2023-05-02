<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ParkingResource;
use App\Models\Parking;
use App\Services\ParkingPriceService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @group Parkings
 */
class ParkingController extends Controller
{
    /**
     * Start/Reserve parking
     *
     * This endpoint allows you to start/reserve parking.
     */
    public function start(Request $request)
    {
        $parkingData = $request->validate([
            'vehicle_id' => [
                'required',
                'integer',
                'exists:vehicles,id,deleted_at,NULL,user_id,'.auth()->id(),
            ],
            'zone_id'    => ['required', 'integer', 'exists:zones,id'],
        ]);

        if(Parking::active()->where('vehicle_id', $request->vehicle_id)->exists()){
            return response()->json([
                'errors' => ['general' => ['Can\'t start parking twice using same vehicle. Please stop currently active parking.']],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking = Parking::create($parkingData);
        $parking->load('zone', 'vehicle');

        return ParkingResource::make($parking);
    }

    /**
     * View parking details
     *
     * This endpoint allows you to view the details of a parking that's currently in service.
     */
    public function show(Parking $parking)
    {
        return ParkingResource::make($parking);
    }

    /**
     * Stop parking
     *
     * This endpoint allows you to stop parking.
     */
    public function stop(Parking $parking)
    {
        if($parking->stop_time){
            return response()->json([
                'errors' => ['general' => ['Parking already stopped.']],
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $parking->update([
            'stop_time' => now(),
            'total_price' => ParkingPriceService::calculatePrice($parking->zone_id, $parking->start_time),
        ]);

        return ParkingResource::make($parking);
    }
}
