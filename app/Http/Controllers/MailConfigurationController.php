<?php

namespace App\Http\Controllers;

use App\Models\MailConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MailConfigurationController extends Controller
{
    /**
     * Display a listing of the user's mail configurations.
     */
    public function index()
    {
        $configurations = Auth::user()->mailConfigurations()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'configurations' => $configurations->map(function ($config) {
                return [
                    'id' => $config->id,
                    'name' => $config->name,
                    'mailer' => $config->mailer,
                    'host' => $config->host,
                    'port' => $config->port,
                    'username' => $config->username,
                    'encryption' => $config->encryption,
                    'from_address' => $config->from_address,
                    'from_name' => $config->from_name,
                    'is_active' => $config->is_active,
                    'is_default' => $config->is_default,
                    'notes' => $config->notes,
                    'created_at' => $config->created_at,
                    'updated_at' => $config->updated_at,
                    'tokens_count' => $config->apiTokens()->count(),
                ];
            }),
        ]);
    }

    /**
     * Store a newly created mail configuration.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mailer' => 'required|string|in:smtp,sendmail,mailgun,postmark,ses',
            'host' => 'required_if:mailer,smtp|string|max:255',
            'port' => 'required_if:mailer,smtp|integer|min:1|max:65535',
            'username' => 'required_if:mailer,smtp|string|max:255',
            'password' => 'required_if:mailer,smtp|string|max:255',
            'encryption' => 'nullable|string|in:tls,ssl',
            'from_address' => 'required|email|max:255',
            'from_name' => 'required|string|max:255',
            'is_default' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données de validation échouées',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $configuration = Auth::user()->mailConfigurations()->create([
                'name' => $request->name,
                'mailer' => $request->mailer,
                'host' => $request->host,
                'port' => $request->port,
                'username' => $request->username,
                'password' => $request->password,
                'encryption' => $request->encryption,
                'from_address' => $request->from_address,
                'from_name' => $request->from_name,
                'is_active' => true,
                'is_default' => $request->boolean('is_default', false),
                'notes' => $request->notes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Configuration mail créée avec succès',
                'configuration' => $configuration->fresh(),
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la configuration',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified mail configuration.
     */
    public function show($id)
    {
        $configuration = Auth::user()->mailConfigurations()->find($id);

        if (!$configuration) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration non trouvée',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'configuration' => $configuration,
        ]);
    }

    /**
     * Update the specified mail configuration.
     */
    public function update(Request $request, $id)
    {
        $configuration = Auth::user()->mailConfigurations()->find($id);

        if (!$configuration) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration non trouvée',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'mailer' => 'string|in:smtp,sendmail,mailgun,postmark,ses',
            'host' => 'required_if:mailer,smtp|string|max:255',
            'port' => 'required_if:mailer,smtp|integer|min:1|max:65535',
            'username' => 'required_if:mailer,smtp|string|max:255',
            'password' => 'string|max:255',
            'encryption' => 'nullable|string|in:tls,ssl',
            'from_address' => 'email|max:255',
            'from_name' => 'string|max:255',
            'is_active' => 'boolean',
            'is_default' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Données de validation échouées',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $configuration->update($request->only([
                'name',
                'mailer',
                'host',
                'port',
                'username',
                'password',
                'encryption',
                'from_address',
                'from_name',
                'is_active',
                'is_default',
                'notes'
            ]));

            return response()->json([
                'success' => true,
                'message' => 'Configuration mise à jour avec succès',
                'configuration' => $configuration->fresh(),
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
     * Remove the specified mail configuration.
     */
    public function destroy($id)
    {
        $configuration = Auth::user()->mailConfigurations()->find($id);

        if (!$configuration) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration non trouvée',
            ], 404);
        }

        // Check if configuration is being used by tokens
        $tokensCount = $configuration->apiTokens()->count();
        if ($tokensCount > 0) {
            return response()->json([
                'success' => false,
                'message' => "Impossible de supprimer cette configuration car elle est utilisée par {$tokensCount} token(s)",
            ], 400);
        }

        try {
            $configuration->delete();

            return response()->json([
                'success' => true,
                'message' => 'Configuration supprimée avec succès',
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
     * Test the mail configuration.
     */
    public function test(Request $request, $id)
    {
        $configuration = Auth::user()->mailConfigurations()->find($id);

        if (!$configuration) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration non trouvée',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'test_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Email de test requis',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $success = $configuration->test($request->test_email);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email de test envoyé avec succès',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Échec de l\'envoi de l\'email de test',
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors du test de la configuration',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Set a configuration as default.
     */
    public function setDefault($id)
    {
        $configuration = Auth::user()->mailConfigurations()->find($id);

        if (!$configuration) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration non trouvée',
            ], 404);
        }

        try {
            $configuration->update(['is_default' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Configuration définie comme par défaut',
                'configuration' => $configuration->fresh(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
