<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class PreventDuplicateRequests
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'duplicate:' . md5($request->fullUrl() . json_encode($request->all()));

        if (Cache::has($key)) {
            return response()->json(Cache::get($key));
        }

        $response = $next($request);

        // Только для успешных запросов кешируем
        if ($response->isSuccessful()) {
            Cache::put($key, json_decode($response->getContent(), true), now()->addSeconds(10));
        }

        return $response;
    }
}
