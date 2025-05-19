@extends('layouts.app')
@section('title','Representative Profile')

@section('content')

<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{__('local.Representative Profile')}}</h3>
                <p class="text-subtitle text-muted">{{ __('local.Representative profile overview and visit history')}}.</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('local.Dashboard')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('representatives.index') }}">{{__('local.Representatives')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('local.Representative Profile')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center">
               <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ urlencode($representative->user->full_name) }}&backgroundColor=D8B4F8,CDB4DB,B5BFE2,E4C1F9,F7D1CD,F2F2F2,B2F7EF,DECDF5,D0BCFF&fontWeight=700" alt="avatar" class="rounded-circle mb-3 avatar-hover" width="120" height="120"/>

            <h4>{{ $representative->user->full_name }}</h4>
            <p>{{ $representative->user->email }}</p>
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
        <button class="nav-link" id="today-visits-tab" data-bs-toggle="tab" data-bs-target="#today-visits" type="button" role="tab" aria-controls="today-visits" aria-selected="false">{{__('local.Visits')}}</button>
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
            <span class="fw-bold">{{__('local.Username')}}:</span>
            <span class="ms-2">{{ $representative->user->username ?? 'N/A' }}</span>
          </div>
          <div class="mb-3">
            <span class="fw-bold">{{__('local.Residing Municipal')}}:</span>
            <span class="ms-2">
                {{ $representative->residingMunicipal->name ?? 'N/A' }}
                {{ $representative->residingMunicipal->city ? '('.$representative->residingMunicipal->city->name.')' : '' }}
            </span>          </div>
          <div class="mb-3">
            <span class="fw-bold">{{__('local.Address')}}:</span>
            <span class="ms-2">{{ $representative->address ?? 'N/A' }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">{{__('local.Working Municipals')}}:</h5>
          @if($representative->workingMunicipals->count() > 0)
           <div class="d-flex flex-wrap gap-2">
                @foreach($representative->workingMunicipals as $municipal)
                    <span class="badge bg-{{ $badgeColors[$municipal->id % 5] }}">
                        {{ $municipal->name }}
                    </span>
                @endforeach
            </div>
          @else
            <span class="text-muted">{{__('local.No working municipals assigned')}}</span>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location-tab">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">{{ __('local.Representative Location') }}</h5>
                @if($representative->latitude && $representative->longitude)
                    <a href="https://www.google.com/maps?q={{ $representative->latitude }},{{ $representative->longitude }}"
                       class="btn btn-sm btn-outline-primary">
                       <i class="bi bi-google me-1"></i> {{ __('local.Open in Google Maps') }}
                    </a>
                @endif
            </div>

            <div id="representativeMap"
                 data-lat="{{ $representative->latitude }}"
                 data-lng="{{ $representative->longitude }}"
                 data-address="{{ $representative->address ?? __('local.Representative Location') }}"
                 style="height: 400px; border-radius: 0.5rem; overflow: hidden;">
            </div>
        </div>
    </div>
</div>

  <div class="tab-pane fade" id="today-visits" role="tabpanel" aria-labelledby="today-visits-tab">

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div>
                    <h5 class="card-title mb-0">{{__('local.Todays Visits')}}</h5>
                    <p class="text-muted mb-0">{{__('local.Scheduled for')}} {{$current_locale == 'ar'? now()->isoFormat('dddd, MMMM D, YYYY'): now()->isoFormat('dddd, MMMM D, YYYY') }}</p>
                </div>
                <div class="pt-1">
                    <a href="{{ route('representatives.visits', $representative->id) }}" target="_blank"
                       class="btn btn-primary btn-sm">
                        {{__('local.View All Visits')}}
                    </a>
                </div>
            </div>

                @include('representatives.partials.visits-table', [
                    'visits' => $representative->visits
                        ->whereBetween('scheduled_at', [now()->startOfDay(), now()->endOfDay()])
                        ->sortBy('scheduled_at')
                ])
        </div>
    </div>
</div>
        <div class="tab-pane fade" id="stats" role="tabpanel" aria-labelledby="stats-tab">
             @include('representatives.partials.statistics')
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
    window.representativeId = {{ $representative->id }};
      window.translations = {
        'local.status.scheduled': @json(__('local.status.scheduled')),
        'local.status.completed': @json(__('local.status.completed')),
        'local.status.canceled':  @json(__('local.status.canceled')),
        'local.status.missed':    @json(__('local.status.missed')),
        'local.visit_completion_overview': @json(__('local.visit_completion_overview')),
      };
</script>
@vite(['resources/static/js/pages/viewRepMap.js','resources/static/js/pages/repStatistics.js'])
@endsection
