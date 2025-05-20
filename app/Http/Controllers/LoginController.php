<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email'    => 'required',
            'password' => 'required'
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        // Periksa user dan password
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah.'
            ], 401);
        }

        // Buat token dengan nama 'auth_token'
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil.',
            'token'   => $token,
            'user'    => $user
        ]);
    }

    public function logout(Request $request)
    {
        // Revoke semua token milik user
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout berhasil.'
        ]);
    }
}
