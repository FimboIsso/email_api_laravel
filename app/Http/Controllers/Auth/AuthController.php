<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCodeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Show the login/register form
     */
    public function showAuth()
    {
        return view('auth.email-auth');
    }

    /**
     * Handle email submission for login/register
     */
    public function submitEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();

        if (!$user) {
            // Create new user with email only
            $user = User::create([
                'email' => $email,
                'name' => '', // Temporary empty name
                'password' => Hash::make('temporary'), // Temporary password
            ]);
        }

        // Generate verification code
        $code = $user->generateVerificationCode();

        // Send verification code via email
        try {
            Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name ?: 'Utilisateur'));
            
            session(['auth_email' => $email]);
            
            return redirect()->route('auth.verify')->with('success', 'Un code de vérification a été envoyé à votre adresse email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de l\'envoi du code. Veuillez réessayer.');
        }
    }

    /**
     * Show verification code form
     */
    public function showVerify()
    {
        if (!session('auth_email')) {
            return redirect()->route('auth.login');
        }

        return view('auth.verify-code');
    }

    /**
     * Handle verification code submission
     */
    public function verifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|size:6'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator);
        }

        $email = session('auth_email');
        if (!$email) {
            return redirect()->route('auth.login');
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('auth.login')->with('error', 'Utilisateur non trouvé.');
        }

        if (!$user->verifyCode($request->code)) {
            return back()->with('error', 'Code de vérification invalide ou expiré.');
        }

        // Clear verification code
        $user->clearVerificationCode();

        // Login user
        Auth::login($user);
        session()->forget('auth_email');

        // Check if user profile is complete
        if (!$user->is_completed) {
            return redirect()->route('auth.complete-profile');
        }

        return redirect()->route('dashboard');
    }

    /**
     * Show complete profile form
     */
    public function showCompleteProfile()
    {
        return view('auth.complete-profile');
    }

    /**
     * Handle profile completion
     */
    public function completeProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'is_completed' => true,
        ]);

        return redirect()->route('dashboard')->with('success', 'Profil complété avec succès !');
    }

    /**
     * Resend verification code
     */
    public function resendCode(Request $request)
    {
        $email = session('auth_email');
        if (!$email) {
            return response()->json(['success' => false, 'message' => 'Session expirée']);
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Utilisateur non trouvé']);
        }

        $code = $user->generateVerificationCode();

        try {
            Mail::to($user->email)->send(new VerificationCodeMail($code, $user->name ?: 'Utilisateur'));
            return response()->json(['success' => true, 'message' => 'Code renvoyé avec succès !']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur lors de l\'envoi du code.']);
        }
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'Déconnexion réussie.');
    }
}
