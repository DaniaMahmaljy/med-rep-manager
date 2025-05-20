@extends('layouts.auth')
@section('title', 'Reset Password')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm p-4 border-0" style="width: 100%; max-width: 420px; border-radius: 12px;">
        <div class="text-center mb-4">
            <h3 class="mt-2 mb-3 fw-bold text-primary">MedRep</h3>
            <p class="text-muted">{{ __('local.Please reset your password') }}</p>
        </div>

        <form method="POST" action="{{ route('password.reset') }}" class="needs-validation" novalidate>
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label fw-medium">{{ __('local.Email') }}</label>
                <div class="input-group">
                    <input id="email" name="email" type="email"
                           class="form-control py-2 @error('email') is-invalid @enderror"
                           placeholder="{{ __('local.Enter your email') }}" required>
                    @error('email')
                    <div class="invalid-feedback d-block">
                        <i class="bx bx-radio-circle"></i> {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="otp" class="form-label fw-medium">{{ __('local.Verification Code') }}</label>
                <div class="input-group">
                    <input id="otp" name="otp" type="text"
                           class="form-control py-2 @error('otp') is-invalid @enderror"
                           placeholder="{{ __('local.Enter verification code') }}" required>
                    @error('otp')
                    <div class="invalid-feedback d-block">
                        <i class="bx bx-radio-circle"></i> {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-medium">{{ __('local.New Password') }}</label>
                <div class="input-group">
                    <input id="password" name="password" type="password"
                           class="form-control py-2 @error('password') is-invalid @enderror"
                           placeholder="{{ __('local.Enter new password') }}" required autocomplete="new-password">
                    @error('password')
                    <div class="invalid-feedback d-block">
                        <i class="bx bx-radio-circle"></i> {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-medium">{{ __('local.Confirm Password') }}</label>
                <div class="input-group">
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           class="form-control py-2"
                           placeholder="{{ __('local.Confirm your new password') }}" required autocomplete="new-password">
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-medium rounded-pill">
                {{ __('local.Change Password') }} <i class="bx bx-chevron-right ms-1"></i>
            </button>
        </form>
    </div>
</div>
@endsection
