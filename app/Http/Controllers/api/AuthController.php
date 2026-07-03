<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
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

    public function register(Request $request)
    {
        $user = $this->authServices->registerService($request);

        return $this->createdResponse('User registered successfully', [
            'user' => $user['user'],
            'access_token' => $user['access_token'],
        ]);
    }

    public function login(Request $request)
    {
        $user = $this->authServices->loginService($request);

        return $this->successResponse('Login successful', [
            'user' => $user['user'],
            'access_token' => $user['access_token'],
        ]);
    }

    public function logout(Request $request)
    {
        $this->authServices->logoutService($request->user());

        return $this->successResponse('Logout successful');
    }
}
