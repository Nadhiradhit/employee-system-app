<?php

namespace App\Http\Services;

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

        $user = User::where('email', $credentials['email'])->first();

        \OwenIt\Auditing\Models\Audit::create([
            'event'          => 'login',
            'auditable_type' => User::class,
            'auditable_id'   => $user->id,
            'user_type'      => $user->is_admin ? 'admin' : 'user',
            'user_id'        => $user->id,
            'url'            => request()->fullUrl(),
            'ip_address'     => request()->ip(),
            'user_agent'     => request()->userAgent(),
            'old_values'     => [],
            'new_values'     => [],
        ]);

        return $user;
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
