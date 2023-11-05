<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        //Validate input
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed',
        ]);

        //Create user and encrypt password
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        //Create token
        $token = $user->createToken('testapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        //Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        //Find user
        $user = User::where('email', $request->input('email'))->first();

        //Problem handling
        if (!$user) {
            return response(['message' => 'User not find with this email'], 422);
        } elseif (!Hash::check($request->input('password'), $user->password)) {
            return response(['message' => 'Incorrect password'], 422);
        }

        //Create token
        $token = $user->createToken('testapptoken')->plainTextToken;

        return response([
            'token' => $token,
        ], 201);
    }

    //We need logout also for security reason
    public function logout(Request $request)
    {
        //Delete all token for this user
        $request->user()->tokens()->delete();

        return response([
            'message' => 'You successfully logged out',
        ], 200);
    }
}
