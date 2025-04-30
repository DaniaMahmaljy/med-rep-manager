@extends('layouts.app')
@section('title','Representatives Management')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{__('local.Representative Overview')}}</h3>
                <p class="text-subtitle text-muted">{{__('local.Manage and track all Representatives')}}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('local.Dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('local.Representatives')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                    <h5 class="card-title mb-0">{{__('local.Representative List')}}</h5>
            </div>
            <div class="card-body">
            <div id="validationErrors" class=" text-danger mb-3"></div>
                    <table class="table table-sm" id="representative_table">
                        <tbody></tbody>
                    </table>
                </div>
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

     window.currentUser = {
        isSupervisor: {{ auth()->user()->hasRole('supervisor') ? 'true' : 'false' }}
    };
    </script>
    @vite('resources/static/js/pages/representativesTable.js')
@endsection
