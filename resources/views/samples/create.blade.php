@extends('layouts.app')

@section('title', __('local.Create New Sample'))

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>{{ __('local.Create New Sample') }}</h3>
                <p class="text-muted">{{ __('local.Complete the form to add a new sample') }}</p>
            </div>

            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('local.Dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('samples.index') }}">{{__('local.Samples')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('local.New Sample')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section mt-3">
        <div class="card">
            <div class="card-header"><h4>{{ __('local.Sample Information') }}</h4></div>
            <div class="card-body">
                <form id="sample-form" action="{{ route('samples.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name_en" class="form-label">{{ __('local.Name (English)') }}</label>
                            <input type="text" name="name[en]" id="name_en"
                                class="form-control"
                                value="{{ old('name.en', $sample->name['en'] ?? '') }}"
                                required>
                            @error('name.en')
                                <div class="text-danger small"><i class="bx bx-radio-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="name_ar" class="form-label">{{ __('local.Name (Arabic)') }}</label>
                            <input type="text" name="name[ar]" id="name_ar"
                                class="form-control text-end"
                                value="{{ old('name.ar', $sample->name['ar'] ?? '') }}"
                                required
                                dir="rtl">
                            @error('name.ar')
                                <div class="text-danger small"><i class="bx bx-radio-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="brand_id" class="form-label">{{ __('local.Brand') }}</label>
                            <select name="brand_id" id="brand_id" class="form-select" required>
                                <option value="">{{ __('local.Select Brand') }}</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" @selected(old('brand_id') == $brand->id)>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <div class="text-danger small"><i class="bx bx-radio-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="sample_class_id" class="form-label">{{ __('local.Sample Class') }}</label>
                            <select name="sample_class_id" id="sample_class_id" class="form-select" required>
                                <option value="">{{ __('local.Select Class') }}</option>
                                @foreach($sampleClasses as $class)
                                    <option value="{{ $class->id }}" @selected(old('sample_class_id') == $class->id)>
                                        {{ $class->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sample_class_id')
                                <div class="text-danger small"><i class="bx bx-radio-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="unit" class="form-label">{{ __('local.Unit') }}</label>
                            <select name="unit" id="unit" class="form-select">
                                <option value="">{{ __('local.Select Unit') }}</option>
                                @foreach(App\Enums\SampleUnitEnum::cases() as $unit)
                                    <option value="{{ $unit->value }}" @selected(old('unit') == $unit->value)>
                                      {{$unit->label()}}
                                    </option>
                                @endforeach
                            </select>
                            @error('unit')
                                <div class="text-danger small"><i class="bx bx-radio-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="quantity_available" class="form-label">{{ __('local.Quantity Available') }}</label>
                            <input type="number" name="quantity_available" id="quantity_available"
                                   class="form-control"
                                   value="{{ old('quantity_available', 0) }}"
                                   min="0">
                            @error('quantity_available')
                                <div class="text-danger small"><i class="bx bx-radio-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="expiration_date" class="form-label">{{ __('local.Expiration Date') }}</label>
                            <input type="date" name="expiration_date" id="expiration_date"
                                   class="form-control"
                                   value="{{ old('expiration_date') }}"
                                   min="{{ now()->format('Y-m-d') }}">
                            @error('expiration_date')
                                <div class="text-danger small"><i class="bx bx-radio-circle"></i> {{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">{{ __('local.Specialties') }}</label>
                        <p class="text-muted">{{ __('local.Select specialties this sample is relevant for') }}</p>
                        <div class="row g-3">
                            @foreach($specialties as $specialty)
                                <div class="col-md-3 col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                               name="specialty_ids[]"
                                               value="{{ $specialty->id }}"
                                               id="specialty-{{ $specialty->id }}"
                                               @checked(in_array($specialty->id, old('specialty_ids', [])))>
                                        <label class="form-check-label" for="specialty-{{ $specialty->id }}">
                                            {{ $specialty->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('specialty_ids')
                            <div class="text-danger small"><i class="bx bx-radio-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>


                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">
                            {{ __('local.Create Sample') }}
                        </button>
                        <button type="reset" class="btn btn-light-secondary me-2">
                            {{ __('local.Reset') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
