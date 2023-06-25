<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFilemanagerAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $user = backpack_user();
        if ($user->hasRole('Super Admin') || $user->hasRole('Direction Admin') || $user->hasRole('Direction Consultant')) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
