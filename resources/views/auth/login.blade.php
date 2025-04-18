@extends('layouts.auth')
@section('title','Login')

@section('content')
<div class="container d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm p-4 border-0" style="width: 100%; max-width: 420px; border-radius: 12px;">
        <div class="text-center mb-4">
            <img src="/logo.svg" alt="Logo" height="48" class="mb-3">
            <h3 class="mt-2 mb-3 fw-bold text-primary">MedRep</h3>
            <p class="text-muted">{{__ ('local.Please sign in to your account') }}</p>
        </div>

        <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
                <label for="username" class="form-label fw-medium">{{ __('local.Username') }}</label>
                <div class="input-group">
                    <input id="username" name="username" value="{{ old('username') }}"
                           type="text" class="form-control py-2 @error('username') is-invalid @enderror"
                           placeholder="{{__('local.Enter your username')}}" required autofocus autocomplete="username">
                           @error('username')
                           <div class="invalid-feedback">
                               <i class="bx bx-radio-circle"></i> {{ $errors->first('username') }}
                           </div>
                           @enderror
                </div>
            <div class="mb-3 mt-3">
                <label for="password" class="form-label fw-medium">{{ __('local.Password') }}</label>
                <div class="input-group">
                    <input id="password" name="password" type="password"
                           class="form-control py-2 @error('password') is-invalid @enderror"
                           placeholder="••••••••" required autocomplete="current-password">
                           @error('password')
                           <div class="invalid-feedback d-block">
                               <i class="bx bx-radio-circle"></i> {{ $message }}
                           </div>
                           @enderror
              </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label text-muted" for="remember">{{ __('local.Remember me') }}</label>
                </div>
                <a href= "" class="text-decoration-none text-primary">{{ __('local.Forgot password?') }}</a>
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 fw-medium rounded-pill">
                {{ __('local.Login') }} <i class="bx bx-chevron-right ms-1"></i>
            </button>
        </form>
    </div>
</div>

@endsection
