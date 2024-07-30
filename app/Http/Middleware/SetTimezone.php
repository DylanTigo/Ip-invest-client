<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;

class SetTimezone
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();
        $timezone = $user ? $user->getTimezone() : config('app.timezone');

        Config::set('app.timezone', $timezone);
        date_default_timezone_set($timezone);

        return $next($request);
    }
}
