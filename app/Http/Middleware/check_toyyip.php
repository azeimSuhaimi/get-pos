<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Crypt;
use App\Models\toyyibpay;

class check_toyyip
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $toyyibpay = toyyibpay::where('user_id',auth()->user()->id)->first();

        if (!$toyyibpay) {
            abort(404, 'ToyyibPay record not found for this user.');
        }

        if(Crypt::decryptString($toyyibpay->toyyip_key) == null || Crypt::decryptString($toyyibpay->toyyip_category) == null)
        {
            abort(403,'Unauthorized You must setting Toyyip pay key and category.');
        }
        return $next($request);
    }
}
