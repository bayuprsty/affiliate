<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Hash;

use App\Helpers\ApiResponse;

use Closure;
use App\Models\Lead;
use App\Models\Vendor;

class ApiAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $secret_id = $request->header('SECRET-ID');
        $token = $request->header('X-TOKEN-ID');
        
        if (is_null($token)) {
            return ApiResponse::send("Unauthorized. Please Login First", [], 500);
        }

        $dataVendor = Vendor::where('secret_id', $secret_id)->first();

        if (is_null($dataVendor)) {
            return ApiResponse::send('Not Allowed.', [], 401);
        }

        if (is_null($dataVendor->api_token)) {
            return ApiResponse::send("Token Invalid.", [], 500);
        }

        if (!is_null($dataVendor->api_token) && Hash::check($token, $dataVendor->api_token)) {
            if (time() - strtotime($dataVendor->token_expired_at) > 0) {
                return ApiResponse::send("Token Expired.", [], 500);
            }

            return $next($request);
        } else {
            return ApiResponse::send("Token Invalid.", [], 500);
        }
    }
}
