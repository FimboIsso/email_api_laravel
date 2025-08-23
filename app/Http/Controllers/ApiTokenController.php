<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApiTokenController extends Controller
{
    /**
     * Display a listing of the user's API tokens.
     */
    public function index()
    {
        $tokens = Auth::user()->apiTokens()
            ->with('mailConfiguration')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'tokens' => $tokens->map(function ($token) {
                return [
                    'id' => $token->id,
                    'name' => $token->name,
                    'masked_token' => $token->masked_token,
                    'permissions' => $token->permissions,
                    'is_active' => $token->is_active,
                    'last_used_at' => $token->last_used_at,
                    'expires_at' => $token->expires_at,
                    'created_at' => $token->created_at,
                    'updated_at' => $token->updated_at,
                    'mail_configuration' => $token->mailConfiguration ? [
                        'id' => $token->mailConfiguration->id,
                        'name' => $token->mailConfiguration->name,
                        'from_address' => $token->mailConfiguration->from_address,
                        'from_name' => $token->mailConfiguration->from_name,
                        'is_active' => $token->mailConfiguration->is_active,
                    ] : null,
                ];
            }),
        ]);
    }

    /**
     * Store a newly created API token.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mail_configuration_id' => 'nullable|exists:mail_configurations,id',
            'permissions' => 'nullable|array',
            'expires_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données de validation échouées',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if mail_configuration belongs to the user
        if ($request->mail_configuration_id) {
            $mailConfig = Auth::user()->mailConfigurations()
                ->where('id', $request->mail_configuration_id)
                ->active()
                ->first();

            if (!$mailConfig) {
                return response()->json([
                    'success' => false,
                    'message' => 'Configuration mail invalide ou inactive',
                ], 422);
            }
        }

        try {
            $token = Auth::user()->apiTokens()->create([
                'name' => $request->name,
                'token' => ApiToken::generateToken(),
                'mail_configuration_id' => $request->mail_configuration_id,
                'permissions' => $request->permissions ?? [],
                'expires_at' => $request->expires_at,
                'is_active' => true,
            ]);

            // Load the mail configuration relationship
            $token->load('mailConfiguration');

            return response()->json([
                'success' => true,
                'message' => 'Token API créé avec succès',
                'token' => [
                    'id' => $token->id,
                    'name' => $token->name,
                    'token' => $token->token, // Show full token only on creation
                    'masked_token' => $token->masked_token,
                    'permissions' => $token->permissions,
                    'is_active' => $token->is_active,
                    'expires_at' => $token->expires_at,
                    'created_at' => $token->created_at,
                    'mail_configuration' => $token->mailConfiguration ? [
                        'id' => $token->mailConfiguration->id,
                        'name' => $token->mailConfiguration->name,
                        'from_address' => $token->mailConfiguration->from_address,
                        'from_name' => $token->mailConfiguration->from_name,
                    ] : null,
                ],
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du token',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified API token.
     */
    public function show($id)
    {
        $token = Auth::user()->apiTokens()->with('mailConfiguration')->find($id);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token non trouvé',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'token' => [
                'id' => $token->id,
                'name' => $token->name,
                'masked_token' => $token->masked_token,
                'permissions' => $token->permissions,
                'is_active' => $token->is_active,
                'last_used_at' => $token->last_used_at,
                'expires_at' => $token->expires_at,
                'created_at' => $token->created_at,
                'updated_at' => $token->updated_at,
                'mail_configuration' => $token->mailConfiguration ? [
                    'id' => $token->mailConfiguration->id,
                    'name' => $token->mailConfiguration->name,
                    'mailer' => $token->mailConfiguration->mailer,
                    'host' => $token->mailConfiguration->host,
                    'port' => $token->mailConfiguration->port,
                    'from_address' => $token->mailConfiguration->from_address,
                    'from_name' => $token->mailConfiguration->from_name,
                    'is_active' => $token->mailConfiguration->is_active,
                ] : null,
            ],
        ]);
    }

    /**
     * Update the specified API token.
     */
    public function update(Request $request, $id)
    {
        $token = Auth::user()->apiTokens()->find($id);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token non trouvé',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'mail_configuration_id' => 'nullable|exists:mail_configurations,id',
            'permissions' => 'array',
            'is_active' => 'boolean',
            'expires_at' => 'nullable|date|after:now',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données de validation échouées',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Check if mail_configuration belongs to the user
        if ($request->has('mail_configuration_id') && $request->mail_configuration_id) {
            $mailConfig = Auth::user()->mailConfigurations()
                ->where('id', $request->mail_configuration_id)
                ->active()
                ->first();

            if (!$mailConfig) {
                return response()->json([
                    'success' => false,
                    'message' => 'Configuration mail invalide ou inactive',
                ], 422);
            }
        }

        try {
            $token->update($request->only([
                'name',
                'mail_configuration_id',
                'permissions',
                'is_active',
                'expires_at'
            ]));

            $token->load('mailConfiguration');

            return response()->json([
                'success' => true,
                'message' => 'Token mis à jour avec succès',
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified API token.
     */
    public function destroy($id)
    {
        $token = Auth::user()->apiTokens()->find($id);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token non trouvé',
            ], 404);
        }

        try {
            $token->delete();

            return response()->json([
                'success' => true,
                'message' => 'Token supprimé avec succès',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Regenerate the token.
     */
    public function regenerate($id)
    {
        $token = Auth::user()->apiTokens()->find($id);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token non trouvé',
            ], 404);
        }

        try {
            $newToken = ApiToken::generateToken();
            $token->update(['token' => $newToken]);

            return response()->json([
                'success' => true,
                'message' => 'Token régénéré avec succès',
                'token' => $newToken, // Show full token only on regeneration
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la régénération',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Toggle token active status.
     */
    public function toggle($id)
    {
        $token = Auth::user()->apiTokens()->find($id);

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token non trouvé',
            ], 404);
        }

        try {
            $token->update(['is_active' => !$token->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Statut du token modifié avec succès',
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
