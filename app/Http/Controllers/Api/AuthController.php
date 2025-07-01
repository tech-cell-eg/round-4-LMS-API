<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $modelClass = $validated['type'] === 'instructor' ? config('auth.providers.instructors.model') : config('auth.providers.users.model');

        $user = $modelClass::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        if(!$user) {
            return response()->json([
                'message' => 'User registration failed',
            ], 500);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'user' => $user->username,
            'token' => $token,
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'type' => 'required|in:user,instructor',
        ]);

        $guard = $request->type === 'instructor' ? 'instructor' : 'web';

        if (Auth::guard($guard)->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $user = Auth::guard($guard)->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Logged in successfully',
                'user' => $user->username,
                'token' => $token,
            ]);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json([
                'message' => 'Logged out successfully',
            ]);
        }

        return response()->json([
            'message' => 'No user is logged in',
        ], 401);
    }

}
