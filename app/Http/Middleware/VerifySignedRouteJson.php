<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySignedRouteJson
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $request->hasValidSignature()) {
            return response()->json([
                'status' => 403,
                'message' => 'Hết thời gian truy cập URL này, vui lòng gửi lại mail.',
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
