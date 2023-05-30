<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'email' => 'email|required',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $accessToken = Auth::user()->createToken('accessToken')->accessToken;

        return response()->json([
            'user' => Auth::user(),
            'token' => $accessToken,
        ]);
    }

    public function me()
    {
        try {
            $user = Auth::parseToken()->authenticate();
            return response()->json(compact('user'));
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not get user'], 500);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'email|required|unique:users',
            'password' => 'required|string|confirmed',
        ]);

        $user = User::create($request->all());

        return response()->json(compact('user'), 201);
    }

    public function refreshToken(Request $request)
    {
        try {
            $token = Auth::parseToken()->refresh();
            return response()->json(compact('token'));
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not refresh token'], 500);
        }
    }



    public function logout(Request $request)
    {
        try {
            Auth::parseToken()->invalidate();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not logout'], 500);
        }
    }
}
