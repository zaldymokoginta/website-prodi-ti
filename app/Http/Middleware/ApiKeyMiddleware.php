<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = config('services.prodi.api_key');

        if (! $key || ! hash_equals($key, (string) $request->header('X-API-Key'))) {
            return response()->json(['message' => 'API key tidak valid.'], 401);
        }

        return $next($request);
    }

    
}