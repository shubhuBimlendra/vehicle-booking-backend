<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Helpers\ApiResponse;
use App\Enums\VehicleType;
use App\Models\Vehicle;

class VehicleTypeController extends Controller
{
    public function index()
    {
        return ApiResponse::success(['vehicle_types' => [VehicleType::BUS, VehicleType::MICRO]]);
    }

    public function show(Request $request)
    {
        try {
            $vehicles = Vehicle::paginate(5);

            return ApiResponse::success(['vehicles' => $vehicles]);
        } catch (\Exception $e) {
            return ApiResponse::error('Failed to retrieve vehicles', 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string',
                'type' => 'required|string|in:' . implode(',', [VehicleType::BUS, VehicleType::MICRO]),
            ]);

            $vehicle = new Vehicle([
                'name' => $request->name,
                'type' => $request->type,
            ]);
            $vehicle->save();

            return ApiResponse::success('Vehicle created successfully');
        } catch (ValidationException $e) {
            return ApiResponse::error($e->getMessage(), 422);
        } catch (\Exception $e) {
            return ApiResponse::error('Vehicle creation failed', 500);
        }
    }
}
