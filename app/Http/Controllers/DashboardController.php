<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\ApiToken;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        return view('dashboard', compact('user'));
    }

    /**
     * Generate a new API token.
     */
    public function generateToken()
    {
        $user = Auth::user();
        $token = $user->generateApiToken();

        return back()->with('success', 'Token API généré avec succès!')->with('token', $token);
    }

    /**
     * Update mail configuration.
     */
    public function updateMailConfig(Request $request)
    {
        $request->validate([
            'mail_mailer' => 'required|string|in:smtp,log',
            'mail_host' => 'required_if:mail_mailer,smtp|nullable|string',
            'mail_port' => 'required_if:mail_mailer,smtp|nullable|integer',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => 'nullable|string|in:tls,ssl',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string',
        ]);

        $user = Auth::user();

        $data = $request->only([
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name'
        ]);

        // Only update password if provided
        if ($request->filled('mail_password')) {
            $data['mail_password'] = $request->mail_password;
        }

        $user->update($data);

        return back()->with('success', 'Configuration email mise à jour avec succès!');
    }

    /**
     * Test mail configuration.
     */
    public function testMailConfig()
    {
        $user = Auth::user();

        // Configure mail settings dynamically
        config($user->getMailConfig());

        try {
            Mail::raw('Ceci est un email de test depuis votre API UZASHOP.', function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Test de configuration email - UZASHOP API');
            });

            return back()->with('success', 'Email de test envoyé avec succès!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi: ' . $e->getMessage());
        }
    }

    /**
     * Display the tokens management page.
     */
    public function tokens()
    {
        $user = Auth::user();
        $tokens = $user->apiTokens()->orderBy('created_at', 'desc')->get();

        return view('dashboard.tokens', compact('tokens'));
    }

    /**
     * Create a new token.
     */
    public function createToken(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $token = Auth::user()->apiTokens()->create([
            'name' => $request->name,
            'token' => ApiToken::generateToken(),
            'permissions' => $request->permissions ?? [],
            'expires_at' => $request->expires_at,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Token créé avec succès!',
            'token' => $token->token,
            'token_id' => $token->id
        ]);
    }

    /**
     * Update an existing token.
     */
    public function updateToken(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array',
            'expires_at' => 'nullable|date|after:now',
            'is_active' => 'boolean'
        ]);

        $token = Auth::user()->apiTokens()->findOrFail($id);

        $token->update([
            'name' => $request->name,
            'permissions' => $request->permissions ?? [],
            'expires_at' => $request->expires_at,
            'is_active' => $request->is_active ?? true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Token mis à jour avec succès!'
        ]);
    }

    /**
     * Delete a token.
     */
    public function deleteToken($id)
    {
        $token = Auth::user()->apiTokens()->findOrFail($id);
        $tokenName = $token->name;
        $token->delete();

        return response()->json([
            'success' => true,
            'message' => "Token '{$tokenName}' supprimé avec succès!"
        ]);
    }

    /**
     * Toggle token status.
     */
    public function toggleToken($id)
    {
        $token = Auth::user()->apiTokens()->findOrFail($id);
        $token->is_active = !$token->is_active;
        $token->save();

        $status = $token->is_active ? 'activé' : 'désactivé';

        return response()->json([
            'success' => true,
            'message' => "Token {$status} avec succès!",
            'is_active' => $token->is_active
        ]);
    }

    /**
     * Show mail configuration page.
     */
    public function mailConfig()
    {
        return view('dashboard.mail-config');
    }

    /**
     * Show API documentation.
     */
    public function apiDocs()
    {
        return view('dashboard.api-docs');
    }

    /**
     * Show analytics page.
     */
    public function analytics()
    {
        $user = Auth::user();
        $totalTokens = $user->apiTokens()->count();
        $activeTokens = $user->apiTokens()->active()->count();

        // Mock analytics data - you can implement real analytics later
        $analyticsData = [
            'total_emails_sent' => rand(100, 1000),
            'emails_this_month' => rand(50, 200),
            'success_rate' => rand(95, 100),
            'total_tokens' => $totalTokens,
            'active_tokens' => $activeTokens,
        ];

        return view('dashboard.analytics', compact('analyticsData'));
    }

    /**
     * Show support page.
     */
    public function support()
    {
        return view('dashboard.support');
    }
}
