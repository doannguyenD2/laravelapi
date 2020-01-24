<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        return response(['request'=>$request->all()]);
        if(!isset($request->user()->email_verified)) return response(['Token mismatch'],403);
        if($request->user()->email_verified == 1)
        return $next($request);
        else 
        return redirect()->route('login');
    }
}
