<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $availLocales = config("local.available_locales");

        if ($request->header('Accept-Language') && array_key_exists($request->header('Accept-Language'), $availLocales)) {
            app()->setLocale($request->header('Accept-Language'));
        }

        elseif (session()->has('locale') && array_key_exists(session()->get('locale'), $availLocales)) {
            app()->setLocale(session()->get('locale'));
        }

        else {
            app()->setLocale('en');
            session()->put('locale', 'en');
        }

        return $next($request);
    }
}
