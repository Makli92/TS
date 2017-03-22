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
    public function handle($request, Closure $next, $controller, ...$roles)
    {
        $controller = new $controller();

        print_r($roles);

        $hasRole = false;

        foreach ($roles as $role) {
            if ($controller->hasRole($role)) {
                $hasRole = true;
            }
        }

        if (!$hasRole) {
            return $controller->error("You aren't allowed to perform the requested action", 403);
        }

        return $next($request);
    }
}
