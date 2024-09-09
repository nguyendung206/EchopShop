<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (Route::is('admin.*')) {
                return route('admin.login');
            }
            if (Route::is('partners.*')) {
                return route('partners.login');
            }
        }
    }

    public function handle($request, Closure $next, ...$guards)
    {
        if (! $request->user() && $request->header('platform') == 'web') {
            return $next($request);
        }
        $this->authenticate($request, $guards);

        return $next($request);
    }
}
