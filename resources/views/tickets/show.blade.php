@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{ __('local.Ticket') }}</h3>
                <p class="text-subtitle text-muted">{{ __('local.Ticket Details') }}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('local.Dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('tickets.index') }}">{{ __('local.Tickets') }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ __('local.Ticket Details') }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">{{ __('local.Ticket Details') }}</h4>
                <span class="badge bg-{{ $ticket->status->color() }}">{{ $ticket->status->label() }}</span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <h4 class="fw-bold">{{ $ticket->title }}</h4>
                            <p class="text-muted">{{ $ticket->description }}</p>
                        </div>

                        <div class="ticket-meta">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted small">{{ __('local.Priority') }}</h6>
                                        <p class="badge bg-{{ $ticket->priority->color() }}">
                                            {{ $ticket->priority->label() }}
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted small">{{ __('local.Created At') }}</h6>
                                        <p class="fw-bold">{{ $ticket->created_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted small">{{ __('local.Created By') }}</h6>
                                        <p class="fw-bold">
                                            {{ $ticket->user->full_name }}
                                            <span class="text-muted small d-block">{{ $ticket->user->email }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted small">{{ __('local.Created For') }}</h6>
                                        <p class="fw-bold">{{ class_basename($ticket->ticketable_type) }}</p>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <h6 class="text-muted small">{{ __('local.Last Updated') }}</h6>
                                        <p class="fw-bold">{{ $ticket->updated_at->format('M d, Y H:i') }}</p>
                                    </div>
                                </div>
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

        @if ($ticket->replies->isNotEmpty())
            <div class="card mt-4">
                <div class="card-header">
                    <h5>{{ __('local.Replies') }}</h5>
                </div>
                <div class="card-body">
                    @foreach ($ticket->replies as $reply)
                        <div class="mb-3 border-bottom pb-2">
                            <strong>{{ $reply->user->full_name }}</strong>
                            <p>{{ $reply->reply }}</p>
                            <p class="text-muted small">{{ $reply->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @role('supervisor')
        @can('addReply', $ticket)
            <div class="card mt-4">
                <div class="card-header">
                    <h5>{{ __('local.Add Reply') }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tickets.replies.store', $ticket) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="reply" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('local.Send') }}</button>
                    </form>
                </div>
            </div>
        @endcan


        <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('tickets.updateStatus', $ticket) }}" method="POST">
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
                                @foreach (\App\Enums\TicketStatusEnum::cases() as $status)
                                    <option value="{{ $status->value }}" @selected($ticket->status === $status)>
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
        @endrole
    </section>
</div>
@endsection
