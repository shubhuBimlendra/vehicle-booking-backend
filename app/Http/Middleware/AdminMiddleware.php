<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check()){
            if(Auth::user()->role == 1) // 1 for admin and 0 for user
            {
                return $next($request);
            }
            else
            {
                return redirect('/')->with('status','Access Denied! As you are not admin');
            }
        }
        else
        {
            return redirect('/login')->with('status','Please Login!');
        }
    }
}
