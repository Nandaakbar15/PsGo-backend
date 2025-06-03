<?php

namespace App\Http\Controllers;

use App\Models\Console;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ConsoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $console = Console::paginate(5);

        return response()->json([
            'statusCode' => 200,
            'data' => $console
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'hourly_rate' => 'required|numeric',
            'is_active'   => 'required|boolean',
            'image'      => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Simpan file
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);

            $validateData['image'] = $filename;
        }

        $console = Console::create($validateData);

        return response()->json([
            'statusCode' => 200,
            'message' => 'Konsol berhasil ditambahkan!',
            'console' => $console
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Console $console)
    {
        return response()->json([
            'statusCode' => 200,
            'console' => $console
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Console $console)
    {
        $validateData = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'hourly_rate' => 'required|numeric',
            'is_active'   => 'required|in:1,0',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle upload jika ada file
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($console->image && file_exists(public_path('images/' . $console->image))) {
                unlink(public_path('images/' . $console->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images'), $filename);
            $validateData['image'] = $filename;
        }

        $console->update($validateData);

        Log::info($request->all());

        return response()->json([
            'statusCode' => 200,
            'message' => "Konsol berhasil diupdate!",
            'console' => $console
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Console $console)
    {
        $console->delete();
        return response()->json([
            'statusCode' => 201,
            'message' => 'Konsol berhasil di hapus!'
        ], 201);
    }
}
