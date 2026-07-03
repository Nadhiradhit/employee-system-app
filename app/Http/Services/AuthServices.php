<?php

namespace App\Http\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthServices
{

    public function registerService(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|string|email|max:150|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        $token = $user->createToken(
            name: 'auth_token',
            abilities: ['*'],
            expiresAt: now()->addMinutes(270)
        )->plainTextToken;

        $data = [
            'user' => $user,
            'access_token' => $token,
        ];

        return $data;
    }

    public function loginService(Request $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            throw new AuthenticationException('Invalid email or password.');
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken(
            name: 'auth_token',
            abilities: ['*'],
            expiresAt: now()->addMinutes(270)
        )->plainTextToken;

        $data = [
            'user' => new UserResource($user),
            'access_token' => $token
        ];

        return $data;
    }

    public function logoutService(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
