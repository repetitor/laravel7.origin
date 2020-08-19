<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
//    public function handle($request, Closure $next)
//    {
//        return $next($request);
//    }

    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if(!Auth::attempt($login)){
            return response(['message' => 'Invalid login credentials.']);
        }

        $user = Auth::user();

        $a = ! $user;
        $b = $user instanceof MustVerifyEmail;
        $c = ! $user->hasVerifiedEmail();

        if (! $user ||
            ($user instanceof MustVerifyEmail &&
                ! $user->hasVerifiedEmail())) {
//            return $request->expectsJson()
//                ? abort(403, 'Your email address is not verified.')
//                : Redirect::route($redirectToRoute ?: 'verification.notice');
            return response(['message'=>'Your email address is not verified.']);
        }

        return $next($request);
    }
}
