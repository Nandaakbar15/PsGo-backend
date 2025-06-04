<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validateData = $request->validate([
            'username'         => 'required|string|max:255',
            'email'        => 'required|email|unique:users,email',
            'password'     => ['required', Password::min(6)],
            'phone_number' => 'nullable|string|max:20',
            'role'         => 'in:admin,customer' // atau set default saja
        ]);

        $validateData['password'] = Hash::make($validateData['password']);

        // Default role jika tidak dikirim
        if (!isset($validateData['role'])) {
            $validateData['role'] = 'customer';
        }

        $user = User::create($validateData);

        return response()->json([
            'statusCode' => 201,
            'message'    => "Register Berhasil!",
            'user'       => $user
        ], 201);
    }
}
