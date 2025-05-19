@extends('layouts.app')
@section('title','Add New Doctor')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ __('local.Add New Doctor') }}</h3>
                <p class="text-subtitle text-muted">
                </p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('local.Dashboard') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> {{ __('local.Add New Doctor') }}</li>
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
        <h4 class="card-title">{{ __('local.Doctor Information') }}</h4>
    </div>
    <div class="card-body">

        <form action="{{ route('doctors.store') }}" method="POST" class="form" id="create-doctor" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label" for="first_name">{{ __('local.First Name') }}</label>
                <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" id ="first_name" required placeholder="{{ __('local.First Name') }}">
                @error('first_name')
                <div class="invalid-feedback">
                    <i class="bx bx-radio-circle"></i> {{ $message }}
                </div>
            @enderror
            </div>
            <div class="form-group">
                <label class = "form-label" for="last_name">{{ __('local.Last Name') }}</label>
                <input type="text" class="form-control  @error('last_name') is-invalid @enderror"  name="last_name" value="{{ old('last_name') }}" id ="last_name" required  placeholder="{{ __('local.Last Name') }}">
                @error('last_name')
                <div class="invalid-feedback">
                    <i class="bx bx-radio-circle"></i> {{ $message }}
                </div>
            @enderror
            </div>

            <div class="form-group mt-3">
                <label for="description">{{ __('local.Description') }}</label>
                <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror" placeholder="{{ __('local.Description') }}">{{ old('description') }}</textarea>
                @error('description')
                    <div class="invalid-feedback">
                        <i class="bx bx-radio-circle"></i> {{ $message }}
                    </div>
                    @enderror
            </div>

            <div class="form-group mt-3">
                <label for="specialty_id">{{ __('local.Specialty') }}</label>
                <select name="specialty_id" id="specialty_id" class="form-select @error('specialty_id') is-invalid @enderror" required>
                    <option value="" disabled selected hidden>{{ __('local.Select Specialty') }}</option>
                    @foreach ($specialties as $specialty)
                        <option value="{{ $specialty->id }}" @selected(old('specialty_id') == $specialty->id)>{{ $specialty->name }}</option>
                    @endforeach
                </select>
                @error('specialty_id')
                    <div class="invalid-feedback">
                        <i class="bx bx-radio-circle"></i> {{ $message }}
                    </div>
                @enderror
            </div>

                <div class="form-group mt-3">
                    <label for="phone">{{ __('local.Phone') }}</label>
                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" required placeholder="{{ __('local.Phone') }}">
                    @error('phone')
            <div class="invalid-feedback">
                <i class="bx bx-radio-circle"></i> {{ $message }}
        </div>
        @enderror
         </div>

                        <label for="municipal_id">{{ __('local.Municipal') }}</label>
                        <select name="municipal_id" class="form-select" @error('municipal_id') is-invalid @enderror id = "municipal_id">
                            <option value="" disabled selected hidden>{{ __('local.Select Municipal') }}</option>
                            @foreach ($municipals as $municipal)
                            <option value="{{ $municipal->id }}" @selected(old('municipal_id') == $municipal->id)> {{ $municipal->name }}</option>
                            @endforeach
                        </select>
                    </fieldset>
                    <div class="form-group">
                        <div id="municipal-info" style="margin-top: 10px;"></div>
                        <div id="map" style="width: 100%; height: 400px;"></div>
                        <input type="hidden" id="latitude" name="latitude"  value="{{ old('latitude') }}">
                        @error('latitude')
                            <div class="text-danger mt-1">
                                <i class="bx bx-radio-circle"></i> {{ $message }}
                            </div>
                        @enderror

                        <input type="hidden" id="longitude" name="longitude"  value="{{ old('longitude') }}">
                        @error('longitude')
                            <div class="text-danger mt-1">
                                <i class="bx bx-radio-circle"></i> {{ $message }}
                            </div>
                        @enderror

                        <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="{{ __('local.Address') }}"  value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">
                                <i class="bx bx-radio-circle"></i> {{ $message }}
                            </div>
                        @enderror
                    </div>
                 </div>
                 <div class="row">
                 <div class="col-12 d-flex justify-content-end">
                  <button type="submit" class="btn btn-primary me-1 mb-1">{{ __('local.Submit') }} </button>
                  <button type="reset" class="btn btn-light-secondary me-1 mb-1"> {{ __('local.Reset') }} </button>
                </div>
                </form>

</div>
</div>
</div>
</section>
@endsection

@section('js')
@vite(['resources/static/js/pages/ui-map-leaflet.js'])
@endsection
