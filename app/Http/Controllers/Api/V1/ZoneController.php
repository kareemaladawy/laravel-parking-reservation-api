<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneResource;
use App\Models\Zone;

/**
 * @group Zones
 */
class ZoneController extends Controller
{
    /**
     * View zones
     *
     * This endpoint allows you to view available zones to use for parking
     */
    public function index()
    {
        return ZoneResource::collection(Zone::all());
    }
}
