<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
   
    protected function redirectTo(Request $request): ?string
    {
        if (!auth()->check()) {
            return route('login');
        }
    }
}
