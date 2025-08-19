<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            \Mail::raw('Ceci est un email de test depuis votre API UZASHOP.', function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Test de configuration email - UZASHOP API');
            });

            return back()->with('success', 'Email de test envoyé avec succès!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi: ' . $e->getMessage());
        }
    }
}
