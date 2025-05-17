@extends('layouts.app')

@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>{{__('local.My Notifications')}}</h3>
                <p class="text-subtitle text-muted">{{__('local.All your notification history')}}</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{__('local.Dashboard')}}</a></li>
                        <li class="breadcrumb-item active">{{__('local.Notifications')}}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title m-0">
                    {{__('local.Notifications')}}
                    @if($unreadCount > 0)
                    <span class="badge bg-danger ms-2">{{ $unreadCount }} {{__('local.unread')}}</span>
                    @endif
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($notifications as $notification)
                    <a href="{{ route('notifications.read', $notification->id) }}"
                       class="list-group-item list-group-item-action {{ $notification->unread() ? 'bg-light-primary' : '' }} p-3 border-bottom">
                        <div class="d-flex align-items-start">
                            <div class="flex-shrink-0 me-3 pt-1">
                                <div class="avatar bg-light-{{ $notification->data['color'] ?? 'primary' }} p-2 rounded">
                                    <i class="bi bi-{{ $notification->data['icon'] ?? 'bell' }} fs-4"></i>
                                </div>
                            </div>

                            <div class="flex-grow-1">
                                @if(isset($notification->data['type']))
                                <div class="mb-1">
                                    <span class="badge bg-light-{{ $notification->data['color'] ?? 'primary' }} text-{{ $notification->data['color'] ?? 'primary' }}">
                                        <i class="bi bi-{{ $notification->data['icon'] ?? 'bell' }} me-1"></i>
                                        {{ ucfirst($notification->data['type']) }}
                                    </span>
                                </div>
                                @endif

                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="mb-1 fw-semibold">
                                        {{ $notification->data['title'] ?? 'Notification' }}
                                        @if($notification->unread())
                                        <span class="badge bg-danger ms-2">{{__('local.New')}}</span>
                                        @endif
                                    </h5>
                                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                                </div>

                                <p class="mb-0 text-muted">{{ $notification->data['message'] ?? '' }}</p>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-5">
                        <div class="avatar bg-light-info p-3 rounded-circle mb-3">
                            <i class="bi bi-bell-slash fs-1 text-info"></i>
                        </div>
                        <h5 class="text-muted">{{__('local.No notifications yet')}}</h5>
                        <p class="text-muted small">{{__('local.You\'ll see notifications here when you receive them')}}</p>
                    </div>
                    @endforelse
                </div>

                @if($notifications->hasPages())
                <div class="card-footer bg-white">
                    {{ $notifications->links() }}
                </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection
