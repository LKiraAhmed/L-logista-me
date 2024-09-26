<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Token;
use Illuminate\Support\Facades\Log;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');
        $tokenValue = $request->input('token');
    
        if ($authHeader && strpos($authHeader, 'Bearer ') === 0) {
            $tokenValue = substr($authHeader, 7); 
        }
        
        if (!$tokenValue) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        Log::info('Token Received: ' . $tokenValue);
    
        if (!Token::where('token', hash('sha256', $tokenValue))->exists()) {
            return response()->json(['error' => 'Invalid token'], 403);
        }
    
        return $next($request);
    }
}    
