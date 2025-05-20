@extends('layouts.app')

@section('title', __('local.Dashboard'))

@section('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    @vite('resources/scss/iconly.scss')
@endsection

@section('content')

<div id="translations" style="display:none;">
    {!! json_encode([
        'completed' => __('local.Completed'),
        'missed' => __('local.MISSED'),
        'scheduled' => __('local.Scheduled'),
        'cancelled' => __('local.Cancelled'),
        'visits' => __('local.Visits'),
        'monthly_overview' => __('local.Monthly_Overview'),
    ]) !!}
</div>

<div id="stats-data" style="display:none;">
    {!! json_encode($stats) !!}
</div>

<div class="page-heading">
    <h3>{{ __('local.System_Statistics') }}</h3>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stats-icon purple d-flex align-items-center justify-content-center me-3">
                                <i class="bi bi-people-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-muted font-semibold">{{ __('local.Total_Representatives') }}</h6>
                                <h6 class="font-extrabold mb-0">{{ $stats['total_representatives'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stats-icon blue d-flex align-items-center justify-content-center me-3">
                                <i class="bi bi-person-badge-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-muted font-semibold">{{ __('local.Total_Doctors') }}</h6>
                                <h6 class="font-extrabold mb-0">{{ $stats['total_doctors'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stats-icon green d-flex align-items-center justify-content-center me-3">
                                <i class="bi bi-calendar-month-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-muted font-semibold">{{ __('local.Last_Month_Visits') }}</h6>
                                <h6 class="font-extrabold mb-0">{{ $stats['last_month_visits'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stats-icon red d-flex align-items-center justify-content-center me-3">
                                <i class="bi bi-check-circle-fill fs-4"></i>
                            </div>
                            <div>
                                <h6 class="text-muted font-semibold">{{ __('local.Completed_This_Month') }}</h6>
                                <h6 class="font-extrabold mb-0">{{ $stats['completed_visits'] ?? 0 }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('local.Monthly_Overview') }}</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="visitsChart" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('js')
    @vite('resources/js/dashboard.js')
@endsection
