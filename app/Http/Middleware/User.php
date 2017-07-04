<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class User
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
        if(Auth::check()) {
          if (Auth::user()->is_active == 1) {
            if(Auth::user()->isUser()) {
              return $next($request);
            }
          }
          else if (Auth::user()->is_active != 1) {
            Auth::logout();
            return redirect('/')->withErrors(["warning"=>"Account is suspended"]);
          }
        }
        return redirect('/');
    }
}
