<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use App\Helpers\ApiResponse;

use Closure;
use App\Models\OAuth;

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
        $accessToken = $request->bearerToken();
        $token = $request->header('X-TOKEN-ID');

        if (is_null($accessToken)) {
            return ApiResponse::send("Unauthorized. Please Login first", [], 401);
        }
        
        if (is_null($token)) {
            return ApiResponse::send("No Token Found", [], 400);
        }

        $dataToken = OAuth::findOrfail($token);

        if (is_null($dataToken)) {
            return ApiResponse::send("Token Invalid. Please re-login", [], 500);
        }

        if ((!is_null($dataToken) && (time() - strtotime($dataToken->expires_at) > 0)) || $dataToken->revoked == 1) {
            $dataToken->update(['revoked' => 1]);
            return ApiResponse::send("Token Invalid. Please re-login", [], 500);
        }

        return $next($request);
    }
}
