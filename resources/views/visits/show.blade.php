@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ __('local.Visit') }}</h3>
                <p class="text-subtitle text-muted">{{ __('local.Visit Details') }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('local.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('visits.index') }}">{{ __('local.Visits') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('local.Visit Details') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('local.Visit Details') }}</h4>
                <span class="badge bg-{{ $visitData->status->color() }}">{{ $visitData->status->label() }}</span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h4 class="fw-bold">{{ $visitData->doctor->name }}</h4>
                            <p class="text-muted">{{ $visitData->doctor->specialization }}</p>
                        </div>

                        <div class="visit-meta">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted small">{{ __('local.Scheduled At') }}</h6>
                                        <p class="fw-bold">{{ $visitData->scheduled_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted small">{{ __('local.Actual Visit Time') }}</h6>
                                        <p class="fw-bold">{{ $visitData->actual_visit_time ? $visitData->actual_visit_time->format('M d, Y H:i') : '--' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted small">{{ __('local.Representative') }}</h6>
                                        <p class="fw-bold">
                                            {{ $visitData->representative->user->full_name }}
                                            <span class="text-muted small d-block">{{ $visitData->representative->user->email }}</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted small">{{ __('local.Last Updated') }}</h6>
                                        <p class="fw-bold">{{ $visitData->updated_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h5>{{ __('local.Samples') }}</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>{{ __('local.Name') }}</th>
                                            <th>{{ __('local.Brand') }}</th>
                                            <th>{{ __('local.Assigned') }}</th>
                                            <th>{{ __('local.Used') }}</th>
                                            <th>{{ __('local.Status') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($visitData->samples as $sample)
                                        <tr>
                                            <td>{{ $sample->name }}</td>
                                            <td>{{ $sample->brand->name }}</td>
                                            <td>{{ $sample->pivot->quantity_assigned }}</td>
                                            <td>{{ $sample->pivot->quantity_used ?? '--' }}</td>
                                            <td><span class="badge bg-light-secondary">{{ \App\Enums\SampleVisitStatus::from($sample->pivot->status)->label() }}</span></td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#sampleDetailsModal-{{ $sample->id }}">
                                                    {{ __('local.Details') }}
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @role('supervisor')
                            <button class="btn btn-outline-success mt-3" data-bs-toggle="modal" data-bs-target="#changeStatusModal">
                                {{ __('local.Change Status') }}
                            </button>
                        @endrole
                    </div>
                </div>
            </div>
        </div>

        @if ($visitData->notes->isNotEmpty())
            <div class="card mt-4">
                <div class="card-header">
                    <h5>{{ __('local.Notes') }}</h5>
                </div>
                <div class="card-body">
                    @foreach ($visitData->notes as $note)
                        <div class="mb-3 border-bottom pb-2">
                            <strong>{{ $note->user->full_name }}</strong>
                            <span class="badge bg-light-secondary float-end">{{ $note->type->label() }}</span>
                            <p>{{ $note->content }}</p>
                            <p class="text-muted small">{{ $note->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @can('addNote', $visitData)
            <div class="card mt-4">
                <div class="card-header">
                    <h5>{{ __('local.Add Note') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('visits.notes.store', $visitData) }}" method="POST">
                        @csrf
                        <div class="mb-3">

                            <textarea name="content" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('local.Send') }}</button>
                    </form>
                </div>
            </div>
        @endcan

        <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('visits.updateStatus', $visitData) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="changeStatusLabel">{{ __('local.Change Status') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('local.Close') }}"></button>
                        </div>
                        <div class="modal-body">
                            <label for="status" class="form-label">{{ __('local.Status') }}</label>
                            <select name="status" id="status" class="form-select">
                                @foreach (\App\Enums\VisitStatusEnum::cases() as $status)
                                    <option value="{{ $status->value }}" @selected($visitData->status === $status)>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">{{ __('local.Update') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @foreach($visitData->samples as $sample)
        <div class="modal fade" id="sampleDetailsModal-{{ $sample->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $sample->brand->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('local.Close') }}"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <h6 class="text-muted small">{{ __('local.Class') }}</h6>
                            <p>{{ $sample->sampleClass?->name ?? '--' }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">{{ __('local.Quantity Available') }}</h6>
                            <p>{{ $sample->quantity_available }}

                                {{ \App\Enums\SampleUnitEnum::from($sample->unit)->label() }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">{{ __('local.Expiration Date') }}</h6>
                            <p>{{ \App\Enums\SampleUnitEnum::from($sample->unit)->label()}} </p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">{{ __('local.Assigned Quantity') }}</h6>
                            <p>{{ $sample->pivot->quantity_assigned }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">{{ __('local.Used Quantity') }}</h6>
                            <p>{{ $sample->pivot->quantity_used ?? '--' }}</p>
                        </div>
                        <div class="mb-3">
                            <h6 class="text-muted small">{{ __('local.Status') }}</h6>
                            <p class="badge bg-light-secondary">{{ \App\Enums\SampleVisitStatus::from($sample->pivot->status)->label() }}
</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('local.Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </section>
</div>
@endsection
