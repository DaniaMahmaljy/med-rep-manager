<nav class="navbar navbar-expand navbar-light navbar-top">
    <div class="container-fluid">
        <a href="#" class="burger-btn d-block">
            <i class="bi bi-justify fs-3"></i>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-lg-0">
                <li class="nav-item dropdown me-1">
                    <a class="nav-link dropdown-toggle text-gray-600" href="#" id="langDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <i class='bi bi-translate bi-sub fs-4'></i> {{ strtoupper($current_locale) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="langDropdown">
                        @foreach($available_locales as $localeCode => $locale)
                            <li>
                                <a class="dropdown-item" href="{{ route('swap', ['locale' => $localeCode]) }}">
                                    <h6> {{ strtoupper($localeCode) }} </h6>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
                <li class="nav-item dropdown me-3">
                    <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                        <i class='bi bi-bell bi-sub fs-4'></i>
                        <span class="badge badge-notification bg-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-center dropdown-menu-sm-end notification-dropdown">
                        <li class="dropdown-header">
                            <h6>{{__('local.Notifications')}}</h6>
                        </li>
                        @foreach(auth()->user()->unreadNotifications as $notification)
                            <li class="dropdown-item notification-item">
                                <a href="{{ route('notifications.read', $notification->id) }}">
                                    <div class="notification-text ms-4">
                                        <p class="notification-title font-bold">
                                            {{ ucfirst($notification->data['type'] ?? '') }}: {{ $notification->data['title'] ?? 'Notification' }}
                                        </p>
                                        <span class="text-xs text-muted">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <p class="text-center py-2 mb-0"><a href="{{ route('notifications.index') }}">{{__('local.See all notifications')}}</a></p>
                        </li>
                    </ul>
                </li>


            </ul>

            <div class="dropdown">
                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="user-menu d-flex">
                        <div class="user-name text-end me-3">
                            <h6 class="mb-0 text-gray-600">{{ auth()->user()->full_name }}</h6>
                            @role('superadmin')
                                <p class="mb-0 text-sm text-gray-600">{{ __('local.Super Admin') }}</p>
                            @endrole
                            @role('admin')
                                <p class="mb-0 text-sm text-gray-600">{{ __('local.Admin') }}</p>
                            @endrole
                            @role('supervisor')
                                <p class="mb-0 text-sm text-gray-600">{{ __('local.Supervisor') }}</p>
                            @endrole
                        </div>
                        <div class="user-img d-flex align-items-center">
                            <div class="avatar avatar-md">
                                <img src="https://api.dicebear.com/7.x/initials/svg?seed={{ urlencode(auth()->user()->full_name) }}&backgroundColor=D8B4F8,CDB4DB,B5BFE2,E4C1F9,F7D1CD,F2F2F2,B2F7EF,DECDF5,D0BCFF&fontWeight=700" alt="avatar" />
                            </div>
                        </div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">
                    <li>
                        <h6 class="dropdown-header">Hello, {{ auth()->user()->first_name }}</h6>
                    </li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="icon-mid bi bi-power me-2"></i> {{__('local.Logout')}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
