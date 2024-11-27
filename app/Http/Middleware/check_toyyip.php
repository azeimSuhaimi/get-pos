<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt;

class check_toyyip
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Crypt::decryptString(auth()->user()->toyyip_key) == null && Crypt::decryptString(auth()->user()->toyyip_category) == null)
        {
            abort(403,'Unauthorized You must setting Toyyip pay key and category.');
        }
        return $next($request);
    }
}
