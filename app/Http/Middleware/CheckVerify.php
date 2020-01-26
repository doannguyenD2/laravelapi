<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // return response(['request'=>Auth::user()->email_verified]);
        if(!isset(Auth::user()->email_verified)) return response(['Token mismatch'],403);
        if(Auth::user()->email_verified == 1)
        return $next($request);
        // return response(['verified'],200);
        else 
        return response(['not verified'],403);
    }
}
