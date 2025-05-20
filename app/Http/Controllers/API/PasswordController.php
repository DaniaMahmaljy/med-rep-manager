<?php

namespace App\Http\Controllers\API;

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


    public function changePassword(ChangePasswordRequest $request)
    {
      $data = $request->afterValidation();
      $this->passwordService->changePassword($data);
      return $this->answer(message: 'Password changed successfully!');
    }

     public function sendOTPEmail(SendOTPRequest $request)
    {
        $data = $request->validated();
        $this->passwordService->sendOTPEmail($data);
        return $this->answer(message: 'Your verification code has been sent to your email');
    }

    public function resetPasswordOTP(VerifyOTPRequest $request)
    {
        $data = $request->validated();
        $this->passwordService->resetPasswordOTP($data);
        return $this->answer(message: 'Password changed successfully!');
    }
}
