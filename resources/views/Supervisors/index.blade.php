@extends('layouts.app')
@section('title','Supervisors Management')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{__('local.Supervisors Overview')}}</h3>
                <p class="text-subtitle text-muted">{{__('local.Manage and track all Supervisors')}}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('local.Dashboard')}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{__('local.Supervisors')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header">
                    <h5 class="card-title mb-0">{{__('local.Supervisors List')}}</h5>
            </div>
            <div class="card-body">
            <div id="validationErrors" class=" text-danger mb-3"></div>
                    <table class="table table-sm" id="supervisor_table">
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
    </script>
    @vite('resources/static/js/pages/supervisorTable.js')
@endsection
