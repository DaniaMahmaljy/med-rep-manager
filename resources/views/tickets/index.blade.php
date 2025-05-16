@extends('layouts.app')
@section('title', __('local.Tickets Management'))

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ __('local.Tickets') }}</h3>
                <p class="text-subtitle text-muted">{{ __('local.Manage and track all support tickets') }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('local.Dashboard') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('local.Tickets') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">{{ __('local.Tickets List') }}</h5>
                    <button class="btn btn-outline-secondary btn-sm d-flex" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#filterCollapse"
                            aria-expanded="true"
                            aria-controls="filterCollapse">
                        <i class="bi bi-funnel me-1"></i>{{ __('local.Filters') }}
                    </button>
                </div>

                <div class="collapse show" id="filterCollapse">
                    <div class="ps-md-2">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-3 col-6">
                                <label for="dateFrom" class="form-label small mb-1">{{ __('local.From') }}</label>
                                <input type="date" id="dateFrom" class="form-control form-control-sm" placeholder="{{ __('local.Select date') }}">
                            </div>
                            <div class="col-md-3 col-6">
                                <label for="dateTo" class="form-label small mb-1">{{ __('local.To') }}</label>
                                <input type="date" id="dateTo" class="form-control form-control-sm" placeholder="{{ __('local.Select date') }}">
                            </div>
                             <div class="col-md-2 col-6">
                                <button id="applyFilter" class="btn btn-primary btn-sm w-100 py-1">
                                    <i class="bi bi-funnel-fill me-1"></i> {{__('local.Filter')}}
                                </button>
                            </div>
                            <div class="col-md-2 col-6">
                                <button id="resetFilter" class="btn btn-outline-secondary btn-sm w-100 py-1">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>{{ __('local.Reset') }}
                                </button>
                            </div>
                            <div id="validationErrors" class="text-danger mb-3"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-sm" id="ticket_table">
                    <thead>
                        <tr>

                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
@section('styles')
    @vite('resources/scss/pages/datatables.scss')
@endsection

@section('js')
<script>
    window.dataTableTranslations = @json([
        'headers' => __('datatables.headers'),
        'ui' => __('datatables.ui')
    ]);
    </script>
    @vite('resources/static/js/pages/ticketsTable.js')
@endsection
