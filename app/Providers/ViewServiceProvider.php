<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['*'], function ($view) {

            $available_locales = config('local.available_locales');
            $current_locale = app()->getLocale();
            $view->with('current_locale', $current_locale);
            $view->with('available_locales', $available_locales);
        });
    }
}
