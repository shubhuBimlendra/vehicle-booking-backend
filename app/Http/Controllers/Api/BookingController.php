<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Vehicle;
use App\Models\Seat;
use App\Models\Book;


class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vehicle_id' => 'required|integer',
            'seat_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error($validator->errors(), 422);
        }

        try {
            $seat = Seat::with('vehicle')->findOrFail($request->seat_id);

            if ($seat->status === 'booked') {
                return ApiResponse::error('Seat is already booked', 400);
            }

            DB::transaction(function () use ($seat, $request) {
                $seat->status = 'booked';
                $seat->save();

                $booking = new Book([
                    'vehicle_id' => $seat->vehicle->id,
                    'user_id' => $request->user_id,
                    'seat_id' => $seat->id,
                    'status' => 'confirmed',
                ]);
                $booking->save();
            });

            return ApiResponse::success('Booking successful');
        } catch (\Exception $e) {
            return ApiResponse::error('Booking failed. Please try again.', 500);
        }
    }
}
