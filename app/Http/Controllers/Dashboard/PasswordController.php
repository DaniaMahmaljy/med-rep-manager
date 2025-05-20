<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\SendOTPRequest;
use App\Http\Requests\VerifyOTPRequest;
use App\Services\PasswordService;
use Illuminate\Http\Request;

class PasswordController extends Controller
{

    public function __construct(protected PasswordService $passwordService)
    {

    }

    public function showChangeForm()
    {
        return view('auth.passwords-change');
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->afterValidation();

      $this->passwordService->changePassword($data);

        return redirect()->route('dashboard')->with('success', __('local.Password changed successfully!'));
    }

    public function showForgetPasswordForm()
    {
        return view('auth.forget-password');
    }

    public function sendOTPEmail(SendOTPRequest $request)
    {
        $data = $request->validated();
        $this->passwordService->sendOTPEmail($data);
        return redirect()->route('password.reset.form')
        ->with('success',  __('local.Your verification code has been sent to your email'));
    }

    public function showResetPasswordForm()
    {
        return view('auth.password-reset-otp');
    }

    public function resetPasswordOTP(VerifyOTPRequest $request)
    {
        $data = $request->validated();
        $this->passwordService->resetPasswordOTP($data);
         return redirect()->route('login')
        ->with('success',  __('local.Password changed successfully!'));
    }

}
