<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRegistration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->category_id){
            return redirect(route('step_2'));
        }
        if (!Auth::user()->country){
            return redirect(route('step_3'));
        }
        if (!Auth::user()->contacts){
            return redirect(route('step_4'));
        }
        if (Auth::user()->languages->isEmpty()){
            return redirect(route('step_5'));
        }
        return $next($request);
    }
}
