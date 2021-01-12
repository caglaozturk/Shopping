<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
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
        //admin guard'ını kullanarak bir giriş işlemi gerçekleştirildiyse ve bu kullanıcı yetkili ise giriş yap
        if(Auth::guard('admin')->check() && Auth::guard('admin')->user()->is_admin){
            return $next($request);
        }
        return redirect()->route('admin.login');
    }
}
