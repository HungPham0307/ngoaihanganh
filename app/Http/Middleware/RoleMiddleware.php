<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next ,$role)
    {
        $name = Auth::user()->username;
        
        if(strpos($role,$name)===false){
            return redirect('permission');
        }
        return $next($request);
    }
}
