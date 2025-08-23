<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ApiToken;
use App\Services\MailService;
use Symfony\Component\HttpFoundation\Response;

class ApiTokenAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tokenString = $request->bearerToken() ?? $request->header('X-API-Token');

        if (!$tokenString) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token API manquant. Veuillez fournir votre token dans l\'en-tête Authorization: Bearer {token} ou X-API-Token'
            ], 401);
        }

        // First, try to find the token in the new api_tokens table
        $apiToken = ApiToken::where('token', $tokenString)
            ->with(['user', 'mailConfiguration'])
            ->first();

        if ($apiToken) {
            // Check if token is valid (active and not expired)
            if (!$apiToken->isValid()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token API expiré ou inactif'
                ], 401);
            }

            $user = $apiToken->user;

            // Mark token as used
            $apiToken->markAsUsed();

            // Store the token in request attributes for later use
            $request->attributes->set('api_token', $apiToken);
        } else {
            // Fallback to old token system for backward compatibility
            $user = User::where('api_token', $tokenString)->first();

            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Token API invalide'
                ], 401);
            }

            // No api token object for old system
            $request->attributes->set('api_token', null);
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
