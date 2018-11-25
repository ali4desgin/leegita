<?php

namespace App\Http\Middleware;
use Closure;
use Session;

class CheckAdminAuth
{
   public function handle($request, Closure $next){
        // echo "1"; die;
        if(!Session::has('adminSession')) {
            return redirect('admin/login');
        }
        return $next($request);
   }
}