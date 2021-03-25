<?php

namespace App\Http\Middleware;

use Closure;

// Laravel
use App;
use Cookie;
use Crypt;

class Localize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Cookie::has('locale')) {
            App::setLocale(Crypt::decrypt(Cookie::get('locale'), false));
        } else {
            Cookie::queue(Cookie::forever('locale', config('app.locale')));
        }

        return $next($request);
    }
}
