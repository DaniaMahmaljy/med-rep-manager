<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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


    public function representativeLogin($data){
        $user = User::where('username', $data['username'])->first();
        if (!Hash::check($data['password'], $user->password)) {
            return
            [
                'success' => false,
                'message' => 'The provided credentials are incorrect.',
                'code' => 401,
            ];        }
        $user->token = $user->createToken('auth_token')->plainTextToken;
        return    [
            'success' => true,
            'user' => $user
            ];
    }

    public function RepresentativeLogout($request)
    {
        $request->user()->currentAccessToken()->delete();
        return    [
            'message' => 'Logged out successfully'
            ];
    }
}
