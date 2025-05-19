@extends('layouts.app')
@section('title','Doctor Profile')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{__('local.Doctor Profile')}}</h3>
                <p class="text-subtitle text-muted">{{ __('local.Doctor profile overview and visit history')}}.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('local.Dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('doctors.index') }}">{{__('local.Doctors')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('local.Doctor Profile')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center">
               <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ urlencode($doctor->full_name) }}&backgroundColor=D8B4F8,CDB4DB,B5BFE2,E4C1F9,F7D1CD,F2F2F2,B2F7EF,DECDF5,D0BCFF&fontWeight=700" alt="avatar" class="rounded-circle mb-3 avatar-hover" width="120" height="120"/>

            <h4>{{ $doctor->full_name }}</h4>
            <p>{{ $doctor->phone }}</p>
             <a href="{{ route('doctors.visits', $doctor->id) }}"
                       class="btn btn-primary btn-sm">
                        {{__('local.View All Visits')}}
                    </a>
            </div>

        </div>
        </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
      <ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#informations" type="button" role="tab" aria-controls="overview" aria-selected="true">{{__('local.Informations')}}</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="location-tab" data-bs-toggle="tab" data-bs-target="#location" type="button" role="tab" aria-controls="location" aria-selected="false">{{__('local.Location')}}</button>
        </li>

        <li class="nav-item" role="presentation">
          <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button" role="tab" aria-controls="stats" aria-selected="false">{{__('local.Statistics')}}</button>
        </li>
      </ul>

      <div class="tab-content" id="profileTabsContent">
        <div class="tab-pane fade show active" id="informations" role="tabpanel" aria-labelledby="informations-tab">
  <div class="row">
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{__('local.Personal Info')}}</h5>
          <div class="mb-3">
            <span class="fw-bold">{{__('local.Municipal')}}:</span>
            <span class="ms-2">
                {{ $doctor->municipal->name ?? 'N/A' }}
                {{ $doctor->municipal->city ? '('.$doctor->municipal->city->name.')' : '' }}
            </span>          </div>
          <div class="mb-3">
            <span class="fw-bold">{{__('local.Address')}}:</span>
            <span class="ms-2">{{ $doctor->address ?? 'N/A' }}</span>
          </div>
          <div class="mb-3">
            <span class="fw-bold">{{__('local.Description')}}:</span>
            <span class="ms-2">{{ $doctor->description ?? 'N/A' }}</span>
          </div>

        </div>
      </div>
    </div>

    <div class="col-md-6 mt-4">
      <div class="card">
        <div class="card-body">
          @if($doctor->specialty)
           <div class="mb-3">
                  <span class="fw-bold">{{__('local.Specialty')}}:</span>
            <span class="ms-2">{{$doctor->specialty->name}}</span>
            </div>
          @else
            <span class="text-muted">{{__('local.No specialty assigned')}}</span>
          @endif

        @hasrole(['superadmin', 'admin'])
        <div class="mb-3">
            <span class="fw-bold">{{ __('local.Supervisors') }}:</span>

            @if($doctor->supervisors && $doctor->supervisors->count())
                @foreach ($doctor->supervisors as $supervisor)
                    <span class="ms-2">{{ $supervisor->user->full_name }},</span>
                @endforeach
            @else
                <span class="text-muted">{{ __('local.No supervisors assigned') }}</span>
            @endif
        </div>
        @endhasrole
        <div class="mb-3">
            <span class="fw-bold">{{__('local.Last visit')}}:</span>
            <span class="ms-2">{{ $doctor->visits->max('scheduled_at')?->format('Y-m-d H:i') ??'N/A' }}</span>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{ __('local.Doctor Location') }}</h5>
                @if($doctor->latitude && $doctor->longitude)
                    <a href="https://www.google.com/maps?q={{ $doctor->latitude }},{{ $doctor->longitude }}"
                       target="_blank"
                       class="btn btn-sm btn-outline-primary">
                       <i class="bi bi-google me-1"></i> {{ __('local.Open in Google Maps') }}
                    </a>
                @endif
            </div>

            <div id="representativeMap"
                 data-lat="{{ $doctor->latitude }}"
                 data-lng="{{ $doctor->longitude }}"
                 data-address="{{ $doctor->address ?? __('local.Doctor Location') }}"
                 style="height: 400px; border-radius: 0.5rem; overflow: hidden;">
            </div>
        </div>
    </div>
</div>


        <div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats-tab">
             @include('doctors.partials.statistics')
        </div>
    </div>
    </div>
    </div>
    </div>
</div>
</div>
@endsection

@section('js')
<script>
    window.doctorId = {{ $doctor->id }};
      window.translations = {
        'local.status.scheduled': @json(__('local.Upcoming Visits')),
        'local.status.completed': @json(__('local.Completed Visits')),
        'local.status.canceled':  @json(__('local.Cancelled Visits')),
        'local.visit_completion_overview': @json(__('local.visit_completion_overview')),
      };
</script>
@vite(['resources/static/js/pages/viewRepMap.js','resources/static/js/pages/doctorStatistics.js'])
@endsection
