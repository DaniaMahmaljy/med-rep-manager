<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Doctor;
use App\Models\Representative;
use App\Models\User;
use App\Models\Visit;
use App\Policies\DoctorPolicy;
use App\Policies\RepresentativePolicy;
use App\Policies\UserPolicy;
use App\Policies\VisitPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Representative::class => RepresentativePolicy::class,
        Doctor::class => DoctorPolicy::class,
        Visit::class => VisitPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
