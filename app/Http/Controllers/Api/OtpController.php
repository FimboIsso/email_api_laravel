<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class OtpController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Generate and send OTP to user's email.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function generateOtp(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'type' => 'sometimes|string|in:email_verification,password_reset,login_verification,two_factor',
                'identifier' => 'sometimes|string|max:255',
                'validity_minutes' => 'sometimes|integer|min:1|max:60',
                'metadata' => 'sometimes|array'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Données de validation invalides',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Utiliser l'utilisateur authentifié (propriétaire du token) comme user_id
            $authenticatedUser = $request->user();

            $result = $this->otpService->generateAndSendOtp(
                user: $authenticatedUser, // Utilisateur authentifié comme propriétaire
                type: $request->input('type', 'email_verification'),
                identifier: $request->input('identifier'),
                validityMinutes: $request->input('validity_minutes', 15),
                metadata: $request->input('metadata', []),
                targetEmail: $request->email // Email cible pour l'envoi
            );

            if ($result['success']) {
                return response()->json([
                    'status' => 'success',
                    'message' => $result['message'],
                    'data' => [
                        'otp_id' => $result['otp_id'],
                        'expires_at' => $result['expires_at'],
                        'type' => $result['type'],
                        'identifier' => $result['identifier']
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $result['message'],
                    'error' => $result['error'] ?? null
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la génération de l\'OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify OTP code.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function verifyOtp(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'code' => 'required|string|size:6',
                'type' => 'sometimes|string|in:email_verification,password_reset,login_verification,two_factor',
                'identifier' => 'sometimes|string|max:255'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Données de validation invalides',
                    'errors' => $validator->errors()
                ], 422);
            }

            $result = $this->otpService->verifyOtp(
                email: $request->email,
                code: $request->code,
                type: $request->input('type', 'email_verification'),
                identifier: $request->input('identifier')
            );

            if ($result['success']) {
                return response()->json([
                    'status' => 'success',
                    'message' => $result['message'],
                    'data' => [
                        'otp_id' => $result['otp_id'],
                        'user_id' => $result['user_id'],
                        'verified_at' => $result['verified_at'],
                        'metadata' => $result['metadata'] ?? null
                    ]
                ], 200);
            } else {
                // Incrémenter le compteur de tentatives pour les codes invalides
                if (in_array($result['error_code'] ?? '', ['INVALID_CODE'])) {
                    $this->otpService->incrementFailedAttempt(
                        $request->email,
                        $request->code,
                        $request->input('type', 'email_verification')
                    );
                }

                return response()->json([
                    'status' => 'error',
                    'message' => $result['message'],
                    'error_code' => $result['error_code'] ?? null
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la vérification de l\'OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get OTP status for a user.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getOtpStatus(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'type' => 'sometimes|string|in:email_verification,password_reset,login_verification,two_factor'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Données de validation invalides',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Utiliser l'utilisateur authentifié
            $authenticatedUser = $request->user();

            $status = $this->otpService->getOtpStatus(
                user: $authenticatedUser,
                type: $request->input('type', 'email_verification')
            );

            return response()->json([
                'status' => 'success',
                'data' => $status
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors de la récupération du statut OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Resend OTP (regenerate and send new code).
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function resendOtp(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'type' => 'sometimes|string|in:email_verification,password_reset,login_verification,two_factor',
                'identifier' => 'sometimes|string|max:255',
                'validity_minutes' => 'sometimes|integer|min:1|max:60'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Données de validation invalides',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Utiliser l'utilisateur authentifié
            $authenticatedUser = $request->user();

            // Vérifier s'il y a un délai de cooldown (optionnel)
            $lastOtp = \App\Models\Otp::where('user_id', $authenticatedUser->id)
                ->where('type', $request->input('type', 'email_verification'))
                ->orderBy('created_at', 'desc')
                ->first();

            if ($lastOtp && $lastOtp->created_at->diffInMinutes(now()) < 1) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Veuillez attendre avant de renvoyer un nouveau code',
                    'cooldown_remaining' => 60 - $lastOtp->created_at->diffInSeconds(now())
                ], 429);
            }

            $result = $this->otpService->generateAndSendOtp(
                user: $authenticatedUser,
                type: $request->input('type', 'email_verification'),
                identifier: $request->input('identifier'),
                validityMinutes: $request->input('validity_minutes', 15),
                metadata: ['resent' => true],
                targetEmail: $request->email // Email cible pour l'envoi
            );

            if ($result['success']) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Nouveau code OTP envoyé avec succès',
                    'data' => [
                        'otp_id' => $result['otp_id'],
                        'expires_at' => $result['expires_at'],
                        'type' => $result['type'],
                        'identifier' => $result['identifier']
                    ]
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => $result['message'],
                    'error' => $result['error'] ?? null
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors du renvoi de l\'OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clean up expired OTPs (admin endpoint).
     *
     * @return JsonResponse
     */
    public function cleanupExpired(): JsonResponse
    {
        try {
            $deletedCount = $this->otpService->cleanupExpiredOtps();

            return response()->json([
                'status' => 'success',
                'message' => "Nettoyage terminé: {$deletedCount} OTP expirés supprimés",
                'deleted_count' => $deletedCount
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors du nettoyage des OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
