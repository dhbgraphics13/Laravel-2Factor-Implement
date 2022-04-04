<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsPrintMan
{
    public function handle($request, Closure $next)
    {
        if(auth()->user()->isPrintMan()) {
            return $next($request);
        }
        return redirect('home');

    }
}
