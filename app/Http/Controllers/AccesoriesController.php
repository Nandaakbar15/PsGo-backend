<?php

namespace App\Http\Controllers;

use App\Models\Accesories;
use Illuminate\Http\Request;

class AccesoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accesories = Accesories::paginate(5);

        return response()->json([
            'statusCode' => 200,
            'data' => $accesories
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'nama_aksesoris' => 'required|string',
            'deskripsi' => 'required|string',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        // Simpan gambar
        if($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            $validateData['gambar'] = $filename;
        }

        $accesories = Accesories::create($validateData);

        return response()->json([
            'statusCode' => 200,
            'message' => 'Aksesories berhasil di tambahkan!',
            'accesories' => $accesories
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Accesories $accesories)
    {
        return response()->json([
            'statusCode' => 200,
            'accesories' => $accesories
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Accesories $accesories)
    {
        $validateData = $request->validate([
            'nama_aksesoris' => 'required|string',
            'deskripsi' => 'required|string',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if($request->hasFile('gambar')) {
            if ($accesories->gambar && file_exists(public_path('images/' . $accesories->gambar))) {
                unlink(public_path('images/' . $accesories->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validateData['gambar'] = $filename;
        }

        $accesories->update($validateData);

        return response()->json([
            'statusCode' => 200,
            'message' => 'Data Aksesoris berhasil diubah!',
            'accesories' => $accesories
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Accesories $accesories)
    {
        $accesories->delete();

        return response()->json([
            'statusCode' => 200,
            'message' => 'Data Aksesoris berhasil dihapus!'
        ], 200);
    }
}
