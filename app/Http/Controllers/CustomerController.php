<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Console;
use App\Models\Accesories;
use App\Models\Bookings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Pesanan;

class CustomerController extends Controller
{
    public function listconsole()
    {
        $console = Console::paginate(5);

        return response()->json([
            'statusCode' => 200,
            'data' => $console
        ], 200);
    }

    public function detailConsole(Console $id_konsol)
    {
        return response()->json([
            'statusCode' => 200,
            'console' => $id_konsol
        ], 200);
    }

    public function accessories()
    {
        $accesories = Accesories::paginate(5);

        return response()->json([
            'statusCode' => 200,
            'data' => $accesories
        ], 200);
    }

    public function detailAccesories(Accesories $id_aksesoris)
    {
        return response()->json([
            'statusCode' => 200,
            'accesories' => $id_aksesoris
        ], 200);
    }

    public function bookingPlaystation(Request $request)
    {
        $request->validate([
            'id_konsol' => 'required|exists:consoles,id_konsol',
            'start_time' => 'required|date_format:Y-m-d H:i:s',
            'duration_in_hours' => 'required|integer|min:1'
        ]);

        // hitung waktu selesainya booking
        $startTime = Carbon::parse($request->start_time);
        $endTime = $startTime->copy()->addHours((int) $request->duration_in_hours);

        // Mengecek konflik waktu booking
        $conflict = Bookings::where('id_konsol', $request->id_konsol)
        ->where(function ($query) use ($startTime, $endTime) {
            $query->whereBetween('start_time', [$startTime, $endTime])
                  ->orWhereBetween('end_time', [$startTime, $endTime])
                  ->orWhere(function ($q) use ($startTime, $endTime) {
                      $q->where('start_time', '<=', $startTime)
                        ->where('end_time', '>=', $endTime);
                  });
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'statusCode' => 409,
                'message' => 'Konsol sudah dibooking pada waktu tersebut.'
            ], 409);
        }

        // Simpan booking
        $booking = Bookings::create([
            'user_id' => Auth::id(), // pastikan user sudah terlogin
            'id_konsol' => $request->id_konsol,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'booked',
        ]);

        return response()->json([
            'statusCode' => 201,
            'message' => 'Booking berhasil!.',
            'data' => $booking
        ], 201);
    }

    public function getBooking(Request $request)
    {
        $userId = $request->user()->id; // atau Auth::id()

        $bookings = Bookings::with('console')
            ->where('user_id', $userId) // <== PENTING!
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'statusCode' => 200,
            'data' => $bookings
        ]);
    }

    public function cancelBooking($id)
    {
        $booking = Bookings::where('id_booking', $id)
        ->where('user_id', Auth::id())
        ->where('status', 'booked')
        ->first();

        if (!$booking) {
            return response()->json([
                'statusCode' => 404,
                'message' => 'Booking tidak ditemukan atau tidak bisa dibatalkan.'
            ], 404);
        }

        $booking->status = 'cancelled';
        $booking->save();

        return response()->json([
            'statusCode' => 200,
            'message' => 'Booking berhasil dibatalkan.'
        ]);
    }

    public function getOrder(Request $request)
    {
        $userId = $request->user()->id;

        $pesanan = Pesanan::with('pesanan')
                   ->where('user_id', $userId)
                   ->orderBy('created_at', 'desc')
                   ->get();

        if(!$pesanan) {
            return response()->json([
                'statusCode' => 400,
                'message' => 'Pesanan tidak ditemukan!'
            ], 400);
        }

        return response()->json([
            'statusCode' => 200,
            'data' => $pesanan
        ], 200);
    }
}
