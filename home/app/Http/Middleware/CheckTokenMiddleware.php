<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class CheckTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $data = Http::send('GET', config('app.auth_url') . "/auth/verify-token", [
            'headers' => [
                'authorization' => 'Bearer '. $request->bearerToken(),
            ]
        ]);
        if ($data->json()['data'] === Response::HTTP_OK) {
            return $next($request);
        }
        return response()->json([
            'data' => null,
            'status' => Response::HTTP_UNAUTHORIZED,
        ], Response::HTTP_UNAUTHORIZED);
    }
}
