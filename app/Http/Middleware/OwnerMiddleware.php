<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class OwnerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!isOwner()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}