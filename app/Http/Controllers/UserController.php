<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function registration(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        return response()->json([
            'status' => 'success',
            'message' => 'User registered successfully',
            'user' => $user,
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials',
            ], 401);
        } else {
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully',
                'token' => $token,
            ]);
        }
    }

    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'user' => $request->user(),
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete(); // current token deleted and user logged out
        // $request->user()->tokens()->delete();   //all token deleted 

        return response()->json([
            'status' => 'success',
            'message' => 'User logged out successfully',
        ]);
    }
}
