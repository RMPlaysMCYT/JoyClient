<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthenticateApi
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('=== AUTH API MIDDLEWARE ===');
        Log::info('Request URL: ' . $request->fullUrl());
        Log::info('Has API Token: ' . (session()->has('api_token') ? 'Yes' : 'No'));
        Log::info('Has User: ' . (session()->has('user') ? 'Yes' : 'No'));
        
        // Check session data
        if (session()->has('api_token') && session()->has('user')) {
            $user = session('user');
            Log::info('User in session:', $user);
            Log::info('Token length: ' . strlen(session('api_token')));
            
            // Let the request through - API will validate token
            Log::info('Allowing request through middleware');
            return $next($request);
        }
        
        Log::warning('Blocking request - no session data');
        
        // Clear any invalid session
        session()->forget(['api_token', 'user']);
        
        return redirect()->route('login')
            ->with('error', 'Please login to continue.');
    }
}