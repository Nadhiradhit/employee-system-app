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

    public function registerService(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function loginService(array $credentials): User
    {
        if (! Auth::validate($credentials)) {
            throw new AuthenticationException('Invalid email or password.');
        }

        return User::where('email', $credentials['email'])->first();
    }

    public function generateToken(User $user): string
    {
        return $user->createToken(
            name: 'auth_token',
            abilities: ['*'],
            expiresAt: now()->addMinutes(270)
        )->plainTextToken;
    }

    public function logoutServiceAPI(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function logoutServiceWeb(Request $request): void
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
