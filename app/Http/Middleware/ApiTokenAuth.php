<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\MailService;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken() ?? $request->header('X-API-Token');

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token API manquant. Veuillez fournir votre token dans l\'en-tête Authorization: Bearer {token} ou X-API-Token'
            ], 401);
        }

        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token API invalide'
            ], 401);
        }

        // Apply user mail configuration using our service
        MailService::applyUserMailConfig($user);

        // Set the authenticated user for the request
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
