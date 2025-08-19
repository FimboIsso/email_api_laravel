<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
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

        // Set the user's mail configuration dynamically
        if ($user->mail_host) {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.host' => $user->mail_host,
                'mail.mailers.smtp.port' => $user->mail_port,
                'mail.mailers.smtp.encryption' => $user->mail_encryption,
                'mail.mailers.smtp.username' => $user->mail_username,
                'mail.mailers.smtp.password' => $user->mail_password,
                'mail.from.address' => $user->mail_from_address,
                'mail.from.name' => $user->mail_from_name,
            ]);
        }

        // Set the authenticated user for the request
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
