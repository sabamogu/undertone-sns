<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiErrorLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if($response->status() >= 400) {
            Log::error('--- API Error Log Start ---');
            Log::error('URL: ' . $request->fullUrl());
            Log::error('Method: ' . $request->method());
            Log::error('Input: ', $request->except(['password', 'password_confirmation']));
            Log::error('Response: ' . $response->getContent());
            Log::error('--- API Error Log End ---');
        }
        return $response;
    }
}
