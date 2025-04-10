<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté et a le rôle d'administrateur
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }
        
        // Si l'utilisateur n'est pas admin, retourner une erreur 403
        return response()->json(['message' => 'Unauthorized. Admin access required.'], 403);
    }
}
