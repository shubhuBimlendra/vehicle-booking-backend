<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SeatGenerationService;
use App\Models\Vehicle;
use App\Models\Seat;
use App\Http\Requests\GenerateSeatsRequest;
use App\Helpers\ApiResponse;

class SeatController extends Controller
{
    protected $seatGenerationService;

    public function __construct(SeatGenerationService $seatGenerationService)
    {
        $this->seatGenerationService = $seatGenerationService;
    }

    public function generateAndStoreSeats(GenerateSeatsRequest $request, $vehicleId)
    {
        try {
            $vehicle = Vehicle::findOrFail($vehicleId);

            $seatLayout = $this->seatGenerationService->generateSeats($vehicle->type);

            foreach ($seatLayout as $row => $seatsInRow) {
                foreach ($seatsInRow as $seatData) {
                    Seat::create([
                        'vehicle_id' => $vehicle->id,
                        'row' => $row + 1,
                        'column' => $seatData['column'],
                        'type' => $seatData['type'],
                        'status' => 'available',
                    ]);
                }
            }
            return ApiResponse::success('Seats generated and stored successfully');
        } catch (\Exception $e) {
            return ApiResponse::success('An error occurred while generating and storing seats');
        }
    }
}
