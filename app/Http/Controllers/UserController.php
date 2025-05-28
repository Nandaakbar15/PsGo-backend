<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function users()
    {
        $users = User::all();

        return response()->json([
            'statusCode' => 200,
            'data' => $users
        ], 200);
    }

    public function deleteUsers(User $user)
    {
        $user->delete();

        return response()->json([
            'statusCode' => 200,
            'message' => 'User berhasil dihapus!'
        ], 200);
    }
}
