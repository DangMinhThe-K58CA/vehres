<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CustomAuthMiddleware extends Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            if (Gate::denies('join-system')) {
                Auth::logout();
                return redirect('login')->with('error', trans('auth.unactivated_account'));
            }
        }

        return parent::handle($request, $next, ...$guards);
    }
}
