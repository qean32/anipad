<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$role): Response
    {
        $rolename = Role::where('id', Auth::user()->role)->get()->name;
        if ( Auth::check() && in_array( $rolename, $role )  ) {
            return $next($request);
        }
        return response()->json('403');
    }
}
