@extends('layouts.app')

@section('title', __('local.Create New Visit'))

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6">
                <h3>{{ __('local.Schedule New Visit') }}</h3>
                <p class="text-muted">{{ __('local.Complete the form to schedule a doctor visit') }}</p>
            </div>

     <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('local.Dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('local.New Visit')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section mt-3">
        <div class="card">
            <div class="card-header"><h4>{{ __('local.Visit Information') }}</h4></div>
            <div class="card-body">
                <form id="visit-form" action="{{ route('visits.store') }}" method="POST">
                    @csrf
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="doctor_id" class="form-label">{{ __('local.Doctor') }}</label>
                        <select name="doctor_id" id="doctor_id" class="form-select" required>
                            <option value="">{{ __('local.Select Doctor') }}</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>
                                    {{ $doctor->full_name }} ({{ $doctor->municipal->name }})
                                </option>
                            @endforeach
                        </select>
                        @error('doctor_id')
                            <div class="text-danger small"><i class="bx bx-radio-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <label for="representative_id" class="form-label mb-0">{{ __('local.Representative') }}</label>
                            <div id="rep-visits-button" style="visibility: hidden;">
                                <a href="#" class="btn  btn-sm btn-outline-primary" id="view-rep-visits-btn" target="_blank">
                                    {{ __('local.View Visits') }}
                                </a>
                            </div>
                        </div>
                        <select name="representative_id" id="representative_id" class="form-select" required>
                            <option value="">{{ __('local.Select Representative') }}</option>
                            @foreach($representatives as $rep)
                                <option value="{{ $rep->id }}" @selected(old('representative_id') == $rep->id)>
                                    {{ $rep->user->full_name }}
                                    @foreach($rep->workingMunicipals as $mun)
                                        ({{ $mun->name }})
                                    @endforeach
                                </option>
                            @endforeach
                        </select>
                        @error('representative_id')
                            <div class="text-danger small"><i class="bx bx-radio-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>


                    <div class="mb-4">
                        <label for="scheduled_at" class="form-label">{{ __('local.Date & Time') }}</label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at"
                               class="form-control" min="{{ now()->format('Y-m-d\TH:i') }}"
                               value="{{ old('scheduled_at') }}" required>
                    </div>
                    @error('scheduled_at')
                        <div class="text-danger small">
                             <i class="bx bx-radio-circle"></i>{{ $message }}</div>
                    @enderror


                    <div class="mb-4">
                        <label class="form-label">{{ __('local.Sample Assignment') }}</label>
                        <p class="text-muted">{{ __('local.Only samples matching doctor specialty are shown') }}</p>
                        <div id="samples-container" class="row g-3"></div>
                    </div>
                        @error('samples')
                        <div class="text-danger small">
                             <i class="bx bx-radio-circle"></i>{{ $message }}</div>
                    @enderror


                    <div class="mb-4">
                        <label for="notes" class="form-label">{{ __('local.Notes') }}</label>
                        <textarea class="form-control" id="notes" rows="3" name="notes">{{ old('notes') }}</textarea>
                    </div>
                    @error('notes')
                        <div class="text-danger small">
                             <i class="bx bx-radio-circle"></i>{{ $message }}</div>
                    @enderror

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">
                            {{ __('local.Schedule') }}
                        </button>
                       <button type="reset" class="btn btn-light-secondary me-2"> {{ __('local.Reset') }} </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
    @vite('resources/static/js/pages/doctorSamples.js')
@endsection
