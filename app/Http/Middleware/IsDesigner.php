<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsDesigner
{
    public function handle($request, Closure $next)
    {
        if(auth()->user()->isDesigner()) {
            return $next($request);
        }
        return redirect('home');

    }
}
