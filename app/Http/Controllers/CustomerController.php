<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Console;
use App\Models\Bookings;

class CustomerController extends Controller
{
    public function listconsole()
    {
        $console = Console::all();

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

    public function bookingps()
    {

    }
}
