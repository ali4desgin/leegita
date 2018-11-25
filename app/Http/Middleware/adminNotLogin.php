<?php

namespace App\Http\Middleware;

use Closure;

class adminNotLogin
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

        if( $request->session()->get("admin_logged") == 1){
            return redirect('admin/dashboard');

        }
        
        return $next($request);
    }
}
