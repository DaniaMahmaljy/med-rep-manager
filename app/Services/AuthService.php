<?php
namespace App\Services;

use Illuminate\Support\Facades\Auth;


class AuthService extends Service {

    public function attemptLogin($credentials)
    {
        $remember = $credentials['remember'] ?? false;

        return Auth::attempt(
            [
                'username' => $credentials['username'],
                'password' => $credentials['password']
            ],
            $remember
        );
    }

    public function destroy()
    {
        Auth::logout();
    }

}
