<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(protected AuthService $authService)
    {

    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if ($this->authService->attemptLogin($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()
        ->withErrors(['password' => 'The provided credentials do not match our records.']);

    }

    public function destroy()
    {
        $this->authService->destroy();
        return redirect()->route('login');
    }
}
