<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

class ChangeLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $language = $request->header('accept-language');

        if ($language) {
            App::setLocale($language);
        }

        return $next($request);
    }
}
