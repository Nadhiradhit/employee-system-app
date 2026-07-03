<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\AuthServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    protected AuthServices $authServices;

    public function __construct(AuthServices $authServices)
    {
        $this->authServices = $authServices;
    }

    public function index()
    {
        return view('auth.login');
    }

    public function register(RegisterRequest $request)
    {
        $user = $this->authServices->registerService($request->validated());

        return view('auth.register', compact('user'));
    }

    public function login(LoginRequest $request)
    {

        $user = $this->authServices->loginService($request->validated());

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email or password are incorrect',
            ])->onlyInput('email');
        }

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    }

    public function logout(Request $request)
    {
        $this->authServices->logoutServiceWeb($request);

        return redirect()->route('login');
    }
}
