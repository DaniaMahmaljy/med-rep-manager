<?php

namespace App\Services;

use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class PasswordService extends Service
{
    public function generateTemporaryPassword()
    {
        return Str::password(
            length: 10,
            symbols: false,
            numbers: true
        );
    }
     public function changePassword( $data)
    {
        $user = $data['user'];
        $newPassword = $data['password'];
        $user->password = Hash::make($newPassword);
        $user->password_changed_at = now();
        $user->save();
    }

    public function sendOTPEmail($data)
    {
        $user = User::where('email', $data['email'])->first();
        $code = rand(111111, 999999);
        Cache::put($data['email'], $code, now()->addMinutes(5));
        Mail::to($data['email'])->send(new SendOtpMail($user));
    }

    public function resetPasswordOTP($data)
    {
       $user = User::where('email', $data['email'])->first();
       $newPassword = $data['password'];
       $newPassword = $data['password'];
       $user->password = Hash::make($newPassword);
       $user->password_changed_at = now();
       Cache::forget($user->email);
       $user->save();
    }

}
