<?php
// app/Http/Middleware/ApiResponse.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Tambahkan header CORS jika diperlukan
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        
        return $response;
    }
}