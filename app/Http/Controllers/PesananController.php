<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesanan = Pesanan::paginate(4);
        return response()->json([
            'statusCode' => 200,
            'data' => $pesanan
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_aksesoris' => 'required|exists:accesories,id_aksesoris',
            'quantity' => 'required|integer',
            'jumlah_pembayaran' => 'required|integer',
            'snap_token' => 'nullable|string|max:30',
            'status' => 'required'
        ]);

        $pesanan = Pesanan::create([
            'user_id' => Auth::id(),
            'id_aksesoris' => $request->id_aksesoris,
            'quantity' => $request->quantity,
            'jumlah_pembayaran' => $request->jumlah_pembayaran,
            'status' => $request->status
        ]);

        return response()->json([
            'statusCode' => 200,
            'message' => 'Berhasil membuat pesanan!',
            'data' => $pesanan
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Pesanan $pesanan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pesanan $pesanan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pesanan $pesanan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pesanan $pesanan)
    {
        //
    }
}
