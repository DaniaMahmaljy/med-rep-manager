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

<div class="page-heading mb-4">
    <div class="d-flex align-items-center justify-content-between">
        <h3 class="mb-0">{{ __('local.System_Statistics') }}</h3>
        <small class="text-muted">{{ now()->format('F j, Y') }}</small>
    </div>
</div>

<div class="page-content">
    <section class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="card-body px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon purple me-3">
                                    <i class="bi bi-people-fill"></i>
                                </div>
                                <div>
                                    <p class="stat-label mb-1">{{ __('local.Total_Representatives') }}</p>
                                    <h3 class="stat-value mb-0">{{ $stats['total_representatives'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="card-body px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon blue me-3">
                                    <i class="bi bi-person-badge-fill"></i>
                                </div>
                                <div>
                                    <p class="stat-label mb-1">{{ __('local.Total_Doctors') }}</p>
                                    <h3 class="stat-value mb-0">{{ $stats['total_doctors'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="card-body px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon green me-3">
                                    <i class="bi bi-calendar-month-fill"></i>
                                </div>
                                <div>
                                    <p class="stat-label mb-1">{{ __('local.Last_Month_Visits') }}</p>
                                    <h3 class="stat-value mb-0">{{ $stats['last_month_visits'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-6 col-lg-3 col-md-6 mb-4">
                    <div class="card stats-card h-100">
                        <div class="card-body px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="stats-icon red me-3">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                                <div>
                                    <p class="stat-label mb-1">{{ __('local.Completed_This_Month') }}</p>
                                    <h3 class="stat-value mb-0">{{ $stats['completed_visits'] ?? 0 }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card mt-2">
                        <div class="card-header">
                            <h4 class="mb-0">{{ __('local.Monthly_Overview') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="position: relative; height: 300px;">
                                <canvas id="visitsChart"></canvas>
                            </div>
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
