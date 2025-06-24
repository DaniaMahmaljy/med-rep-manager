@extends('layouts.app')

@section('styles')
<style>
    #replies-container {
    max-height: 400px;
    overflow-y: auto;
}

</style>
@endsection

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

     @php
    $replyCount = $ticket->replies->count();
    $visibleReplies = $ticket->replies->slice(-5);
    $hasMoreReplies = $replyCount > $visibleReplies->count();
    @endphp

    <div class="card mt-4">
        <div class="card-header">
            <h5>{{ __('local.Replies') }}</h5>
        </div>
        <div id="replies-container" class="card-body">
            @if ($hasMoreReplies)
                <div class="d-flex align-items-center justify-content-center">
                    <button id="load-older-replies" class="btn btn-link">{{ __('local.Show earlier replies') }}</button>
                </div>

                <div id="older-replies" class="d-none">
                    @foreach ($ticket->replies->slice(0, $replyCount - 5) as $reply)
                        <div class="mb-3 border-bottom pb-2">
                            <strong>{{ $reply->user->full_name }}</strong>
                            <p>{{ $reply->reply }}</p>
                            <p class="text-muted small">{{ $reply->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            <div id="new-replies">
                @if ($visibleReplies->isEmpty())
                    <p id="no-replies-message" class="text-muted">{{ __('local.No replies yet.') }}</p>
                @else
                    @foreach ($visibleReplies as $reply)
                        <div class="mb-3 border-bottom pb-2">
                            <strong>{{ $reply->user->full_name }}</strong>
                            <p>{{ $reply->reply }}</p>
                            <p class="text-muted small">{{ $reply->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>


        @role('supervisor')
        @can('addReply', $ticket)
            <div class="card mt-4">
                <div class="card-header">
                    <h5>{{ __('local.Add Reply') }}</h5>
                </div>
                <div class="card-body">
                    <form id="reply-form" action="{{ route('tickets.replies.store', $ticket) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="reply" class="form-control" id="reply-text" rows="4" required></textarea>
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

@section('js')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const ticketId = {{ $ticket->id }};
        const form = document.getElementById('reply-form');
        const textarea = document.getElementById('reply-text');
        const repliesContainer = document.getElementById('replies-container');

        setInterval(() => {
            fetch(`/tickets/${ticketId}/active`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ user_id: {{ auth()->id() }} })
            });
        }, 10000);

         const playSound = () => {
            const audio = new Audio(`${window.APP_BASE_URL}/sounds/message.mp3`);
            audio.play();
        };



        window.Echo.private(`ticketreplies.${ticketId}`)
            .listen('.ticket.reply.created', (e) => {
                const replyHtml = `
                    <div class="mb-3 border-bottom pb-2">
                        <strong>${e.user}</strong>
                        <p>${e.reply}</p>
                        <p class="text-muted small">${e.created_at}</p>
                    </div>
                `;

                const noReplyMessage = document.getElementById('no-replies-message');
                if (noReplyMessage) {
                    noReplyMessage.remove();
                }

                playSound();
                repliesContainer.insertAdjacentHTML('beforeend', replyHtml);
                repliesContainer.scrollTo({ top: repliesContainer.scrollHeight, behavior: 'smooth' });
            });

        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const reply = textarea.value.trim();
            if (!reply) return;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ reply })
            })
            .then(res => {
                if (!res.ok) throw new Error('Reply failed');
                textarea.value = '';
            })
            .catch(err => {
                alert('Failed to submit reply.');
                console.error(err);
            });
        });
        const loadOlderBtn = document.getElementById('load-older-replies');
        const olderReplies = document.getElementById('older-replies');

        if (loadOlderBtn) {
            loadOlderBtn.addEventListener('click', () => {
                olderReplies.classList.remove('d-none');
                loadOlderBtn.remove();
            });
        }
    });
    </script>
@endsection
