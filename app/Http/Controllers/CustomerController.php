<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Console;
use App\Models\Accesories;
use App\Models\Bookings;

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

    public function bookingps()
    {

    }
}
