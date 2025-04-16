@extends('layouts.app')
@section('title','Register New User')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Add New User</h3>
                <p class="text-subtitle text-muted">
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add New User</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section id="multiple-column-form">
    <div class="row match-height">
    <div class="col-12">
    <div class="card">
    <div class="card-header">
        <h4 class="card-title">User Information</h4>
    </div>
    <div class="card-body">

        <form action="{{ route('user.store') }}" method="POST" class="form" id="create-user" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <div class="btn-group" role="group" aria-label="User Type Selection">
                    <input type="radio" class="btn-check" name="user_type" id="admin" autocomplete="off" value="{{ App\Enums\UserTypeEnum::ADMIN->value }}"{{ old('user_type') == App\Enums\UserTypeEnum::ADMIN->value ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary" for="admin">Admin</label>

                    <input type="radio" class="btn-check" name="user_type" id="supervisor" autocomplete="off" value="{{ App\Enums\UserTypeEnum::SUPERVISOR->value }}"{{ old('user_type') == App\Enums\UserTypeEnum::SUPERVISOR->value ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary" for="supervisor">Supervisor</label>

                    <input type="radio" class="btn-check" name="user_type" id="representative" autocomplete="off" value="{{ App\Enums\UserTypeEnum::REPRESENTATIVE->value }}"{{ old('user_type') == App\Enums\UserTypeEnum::REPRESENTATIVE->value ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary" for="representative">Representative</label>
                </div>
                @error('user_type')
                    <div class="text-danger mt-1">
                        <i class="bx bx-radio-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="first_name">{{ __('First Name') }}</label>
                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" id ="first_name" required placeholder="{{ __('First Name') }}">
                @error('first_name')
                <div class="invalid-feedback">
                    <i class="bx bx-radio-circle"></i> {{ $message }}
                </div>
            @enderror
            </div>
            <div class="form-group">
                <label class = "form-label" for="last_name">{{ __('Last Name') }}</label>
                <input type="text" class="form-control  @error('last_name') is-invalid @enderror"  name="last_name" value="{{ old('last_name') }}" id ="last_name" required  placeholder="{{ __('Last Name') }}">
                @error('last_name')
                <div class="invalid-feedback">
                    <i class="bx bx-radio-circle"></i> {{ $message }}
                </div>
            @enderror
            </div>
            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id = "email" required placeholder="{{ __('Email') }}">
                @error('email')
                <div class="invalid-feedback">
                    <i class="bx bx-radio-circle"></i> {{ $message }}
                </div>
            @enderror
            </div>

            <div class="tab-content mt-3">


                <div id="supervisor-section" class="user-section @if(old('user_type') != App\Enums\UserTypeEnum::SUPERVISOR->value) d-none @endif">                    <label for="city_id">{{ __('City') }}</label>
                    <fieldset class="form-group">
                        <select name="city_id" class="form-select @error('city_id') is-invalid @enderror" id="city_id" @if(old('user_type') == App\Enums\UserTypeEnum::SUPERVISOR->value) required @endif>
                            <option disabled selected hidden>{{ __('Select City') }}</option>
                            @foreach ($cities as $city)
                            <option value="{{ $city->id }}" @selected(old('city_id') == $city->id)>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                        <div class="invalid-feedback">
                            <i class="bx bx-radio-circle"></i> {{ $message }}
                        </div>
                        @enderror
                    </fieldset>
                </div>

                <div id="representative-section" class="user-section @if(old('user_type') != App\Enums\UserTypeEnum::REPRESENTATIVE->value) d-none @endif">                    <fieldset class="form-group">
                        <label for="municipal_id">{{ __('Municipal') }}</label>
                        <select name="municipal_id" class="form-select" @error('municipal_id') is-invalid @enderror id = "municipal_id">
                            <option value="" disabled selected hidden>{{ __('Select Municipal') }}</option>
                            @foreach ($municipals as $municipal)
                            <option value="{{ $municipal->id }}" @selected(old('municipal_id') == $municipal->id)> {{ $municipal->name }}</option>
                            @endforeach
                        </select>
                    </fieldset>

                    <div class="form-group">
                        <div id="municipal-info" style="margin-top: 10px;"></div>
                        <div id="map" style="width: 100%; height: 400px;"></div>
                        <input type="hidden" id="latitude" name="latitude">
                        @error('latitude')
                            <div class="text-danger mt-1">
                                <i class="bx bx-radio-circle"></i> {{ $message }}
                            </div>
                        @enderror

                        <input type="hidden" id="longitude" name="longitude">
                        @error('longitude')
                            <div class="text-danger mt-1">
                                <i class="bx bx-radio-circle"></i> {{ $message }}
                            </div>
                        @enderror

                        <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="{{ __('Address') }}">
                        @error('address')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                 </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary me-1 mb-1">{{ __('Submit') }} </button>
                  <button type="reset" class="btn btn-light-secondary me-1 mb-1"> {{ __('Reset') }} </button>
                </div>
                </div>
        </form>

    </div>
</div>

</div>
</div>
</div>
</section>
@endsection

@section('js')
@vite(['resources/static/js/pages/user-form.js','resources/static/js/pages/ui-map-leaflet.js'])
@endsection
