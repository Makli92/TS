<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizeRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $controller, $role = 0){

        $controller = new $controller();

        if(!$controller->hasRole($role)){
            return $controller->error("You aren't allowed to perform the requested action", 403);
        }

        return $next($request);
    }
}
