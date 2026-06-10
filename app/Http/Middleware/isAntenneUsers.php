<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isAntenneUsers
{
    public function handle(Request $request, Closure $next)
    {
        if (in_array((int) auth()->guard('web')->user()->profile, [6, 7], true)) {
            return $next($request);
        }

        return redirect()->route('home');
    }
}
