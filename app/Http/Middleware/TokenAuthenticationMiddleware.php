<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;
use Illuminate\Http\Request;

class TokenAuthenticationMiddleware
{
    public function handle(Request $request, Closure $next)
    {

        // Verificar si el token de usuario está presente en la sesión
        if (!$request->hasCookie('user_info')) {
            return response()->json(['error' => 'Usuario no autenticado'], 401);
        }

        
        
        return $next($request);
    }
 
}
