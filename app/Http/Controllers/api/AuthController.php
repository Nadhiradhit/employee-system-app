<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Http\Services\AuthServices;
use App\Trait\ApiResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    use ApiResponse;

    protected AuthServices $authServices;

    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authServices->registerService($request->validated());

        $token = $this->authServices->generateToken($user);

        $data = [
            'user' => $user,
            'access_token' => $token,
        ];

        return $this->createdResponse('User registered successfully', [
            'user' => $data['user'],
            'access_token' => $data['access_token'],
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = $this->authServices->loginService($request->validated());

        $token = $this->authServices->generateToken($user);

        Auth::setUser($user);

        $data = [
            'user' => new UserResource($user),
            'access_token' => $token
        ];

        return $this->successResponse('Login successful', [
            'user' => $data['user'],
            'access_token' => $data['access_token'],
        ]);
    }

    public function logout(Request $request)
    {
        $this->authServices->logoutServiceAPI($request->user());

        return $this->successResponse('Logout successful');
    }
}
