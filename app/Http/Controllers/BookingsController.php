<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $booking = Bookings::paginate(5);
        return response()->json([
            'statusCode' => 200,
            'data' => $booking
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bookings $bookings)
    {
        $bookings->delete();

        return response()->json([
            'statusCode' => 201,
            'message' =>  'Data Booking berhasil di hapus!'
        ], 201);
    }
}
