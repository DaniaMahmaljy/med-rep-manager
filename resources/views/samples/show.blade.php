@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ __('local.Sample Details') }}</h3>
                <p class="text-subtitle text-muted">{{ __('local.View detailed information about this sample') }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('local.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('samples.index') }}">{{ __('local.Samples') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('local.Sample Details') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ $sample->brand->name }}</h4>

                @role('admin')
                <a href="{{ route('samples.edit', $sample) }}" class="btn btn-sm btn-outline-primary">
                    {{ __('local.Edit Sample') }}
                </a>
                @endrole
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">{{ __('local.Brand') }}</h6>
                        <p class="fw-bold">{{ $sample->brand->name }}</p>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-muted">{{ __('local.Class') }}</h6>
                        <p class="fw-bold">{{ $sample->sampleClass->name ?? __('local.Not Specified') }}</p>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-muted">{{ __('local.Quantity Available') }}</h6>
                        <p class="fw-bold">{{ $sample->quantity_available }}</p>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-muted">{{ __('local.Unit') }}</h6>
                        <p class="fw-bold">{{ \App\Enums\SampleUnitEnum::from($sample->unit)->label() }}</p>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-muted">{{ __('local.Expiration Date') }}</h6>
                        <p class="fw-bold">
                             {{ $sample->expiration_date ? \Illuminate\Support\Carbon::parse($sample->expiration_date)->format('M d, Y') : __('local.Not Specified') }}
                        </p>

                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">{{ __('local.Description') }}</h6>
                        <p class="fw-bold">{{$sample->description ?? '_' }}</p>
                    </div>
                </div>

                @if($sample->specialties->isNotEmpty())
                    <h6 class="text-muted">{{ __('local.Related Specialties') }}</h6>
                    <ul class="list-group">
                        @foreach($sample->specialties as $specialty)
                            <li class="list-group-item">{{ $specialty->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">{{ __('local.No specialties assigned to this sample.') }}</p>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
