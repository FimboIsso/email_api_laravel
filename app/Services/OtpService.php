<?php

namespace App\Services;

use App\Models\Otp;
use App\Models\User;
use App\Mail\CustomMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class OtpService
{
    /**
     * Generate and send OTP to user's email.
     */
    public function generateAndSendOtp(
        User $user,
        string $type = 'email_verification',
        string $identifier = null,
        int $validityMinutes = 15,
        array $metadata = [],
        string $targetEmail = null
    ): array {
        try {
            // Utiliser l'email cible ou l'email de l'utilisateur par défaut
            $emailToSend = $targetEmail ?: $user->email;

            // Créer l'OTP avec l'email cible
            $otp = Otp::createForUser($user, $type, $identifier, $validityMinutes, array_merge($metadata, ['target_email' => $emailToSend]));

            // Mettre à jour l'email dans l'OTP si différent
            if ($targetEmail) {
                $otp->email = $targetEmail;
                $otp->save();
            }

            // Préparer le template d'email
            $emailTemplate = $this->getOtpEmailTemplate($otp, $type);

            // Configurer l'email avec la configuration de l'utilisateur
            $mailConfig = $user->getMailConfig();

            foreach ($mailConfig as $key => $value) {
                config([$key => $value]);
            }

            // Envoyer l'email à l'adresse cible
            Mail::to($emailToSend)->send(new CustomMail(
                to: $emailToSend,
                subject: $emailTemplate['subject'],
                message: $emailTemplate['body'],
                userName: $user->name ?: 'Utilisateur'
            ));

            return [
                'success' => true,
                'message' => 'Code OTP envoyé avec succès',
                'otp_id' => $otp->id,
                'expires_at' => $otp->expires_at->toISOString(),
                'type' => $type,
                'identifier' => $identifier
            ];
        } catch (Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'OTP: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Erreur lors de l\'envoi du code OTP',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Verify OTP code.
     */
    public function verifyOtp(
        string $email,
        string $code,
        string $type = 'email_verification',
        string $identifier = null
    ): array {
        try {
            // Rechercher l'OTP
            $query = Otp::where('email', $email)
                ->where('code', $code)
                ->where('type', $type)
                ->where('is_used', false);

            if ($identifier) {
                $query->where('identifier', $identifier);
            }

            $otp = $query->first();

            if (!$otp) {
                return [
                    'success' => false,
                    'message' => 'Code OTP invalide ou non trouvé',
                    'error_code' => 'INVALID_CODE'
                ];
            }

            // Vérifier si le code a expiré
            if ($otp->isExpired()) {
                return [
                    'success' => false,
                    'message' => 'Code OTP expiré',
                    'error_code' => 'EXPIRED_CODE'
                ];
            }

            // Vérifier le nombre de tentatives
            if ($otp->hasReachedMaxAttempts()) {
                return [
                    'success' => false,
                    'message' => 'Nombre maximum de tentatives atteint',
                    'error_code' => 'MAX_ATTEMPTS_REACHED'
                ];
            }

            // Marquer l'OTP comme utilisé
            $otp->markAsUsed();

            // Si c'est une vérification d'email, marquer l'email comme vérifié
            if ($type === 'email_verification') {
                $user = $otp->user;
                $user->clearVerificationCode();
            }

            return [
                'success' => true,
                'message' => 'Code OTP vérifié avec succès',
                'otp_id' => $otp->id,
                'user_id' => $otp->user_id,
                'verified_at' => $otp->used_at->toISOString(),
                'metadata' => $otp->metadata
            ];
        } catch (Exception $e) {
            Log::error('Erreur lors de la vérification de l\'OTP: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => 'Erreur lors de la vérification du code OTP',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Increment attempt counter for failed verification.
     */
    public function incrementFailedAttempt(string $email, string $code, string $type = 'email_verification'): void
    {
        $otp = Otp::where('email', $email)
            ->where('code', $code)
            ->where('type', $type)
            ->where('is_used', false)
            ->first();

        if ($otp) {
            $otp->incrementAttempts();
        }
    }

    /**
     * Get OTP status for a user.
     */
    public function getOtpStatus(User $user, string $type = 'email_verification'): array
    {
        $otp = Otp::where('user_id', $user->id)
            ->where('type', $type)
            ->where('is_used', false)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$otp) {
            return [
                'has_active_otp' => false,
                'message' => 'Aucun code OTP actif'
            ];
        }

        return [
            'has_active_otp' => true,
            'otp_id' => $otp->id,
            'expires_at' => $otp->expires_at->toISOString(),
            'attempts' => $otp->attempts,
            'max_attempts' => 5,
            'is_expired' => $otp->isExpired(),
            'created_at' => $otp->created_at->toISOString()
        ];
    }

    /**
     * Clean up expired OTPs.
     */
    public function cleanupExpiredOtps(): int
    {
        return Otp::cleanupExpired();
    }

    /**
     * Get email template for OTP.
     */
    private function getOtpEmailTemplate(Otp $otp, string $type): array
    {
        $templates = [
            'email_verification' => [
                'subject' => 'Code de vérification de votre email',
                'body' => $this->getEmailVerificationTemplate($otp)
            ],
            'password_reset' => [
                'subject' => 'Code de réinitialisation de mot de passe',
                'body' => $this->getPasswordResetTemplate($otp)
            ],
            'login_verification' => [
                'subject' => 'Code de vérification de connexion',
                'body' => $this->getLoginVerificationTemplate($otp)
            ],
            'two_factor' => [
                'subject' => 'Code d\'authentification à deux facteurs',
                'body' => $this->getTwoFactorTemplate($otp)
            ]
        ];

        return $templates[$type] ?? $templates['email_verification'];
    }

    private function getEmailVerificationTemplate(Otp $otp): string
    {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <h2 style='color: #333;'>Vérification de votre adresse email</h2>
            <p>Bonjour,</p>
            <p>Voici votre code de vérification :</p>
            <div style='background-color: #f8f9fa; padding: 20px; text-align: center; margin: 20px 0; border-radius: 5px;'>
                <h1 style='color: #007bff; font-size: 32px; margin: 0; letter-spacing: 5px;'>{$otp->code}</h1>
            </div>
            <p>Ce code expire le <strong>{$otp->expires_at->format('d/m/Y à H:i')}</strong>.</p>
            <p>Si vous n'avez pas demandé ce code, veuillez ignorer cet email.</p>
            <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>
            <p style='color: #666; font-size: 12px;'>
                Ceci est un email automatique, merci de ne pas y répondre.
            </p>
        </div>";
    }

    private function getPasswordResetTemplate(Otp $otp): string
    {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <h2 style='color: #dc3545;'>Réinitialisation de votre mot de passe</h2>
            <p>Bonjour,</p>
            <p>Vous avez demandé la réinitialisation de votre mot de passe. Voici votre code de vérification :</p>
            <div style='background-color: #f8f9fa; padding: 20px; text-align: center; margin: 20px 0; border-radius: 5px;'>
                <h1 style='color: #dc3545; font-size: 32px; margin: 0; letter-spacing: 5px;'>{$otp->code}</h1>
            </div>
            <p>Ce code expire le <strong>{$otp->expires_at->format('d/m/Y à H:i')}</strong>.</p>
            <p><strong>⚠️ Important :</strong> Si vous n'avez pas demandé cette réinitialisation, veuillez ignorer cet email et sécuriser votre compte.</p>
            <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>
            <p style='color: #666; font-size: 12px;'>
                Ceci est un email automatique, merci de ne pas y répondre.
            </p>
        </div>";
    }

    private function getLoginVerificationTemplate(Otp $otp): string
    {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <h2 style='color: #28a745;'>Code de vérification de connexion</h2>
            <p>Bonjour,</p>
            <p>Une tentative de connexion a été détectée sur votre compte. Voici votre code de vérification :</p>
            <div style='background-color: #f8f9fa; padding: 20px; text-align: center; margin: 20px 0; border-radius: 5px;'>
                <h1 style='color: #28a745; font-size: 32px; margin: 0; letter-spacing: 5px;'>{$otp->code}</h1>
            </div>
            <p>Ce code expire le <strong>{$otp->expires_at->format('d/m/Y à H:i')}</strong>.</p>
            <p>Si ce n'est pas vous qui tentez de vous connecter, veuillez sécuriser votre compte immédiatement.</p>
            <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>
            <p style='color: #666; font-size: 12px;'>
                Ceci est un email automatique, merci de ne pas y répondre.
            </p>
        </div>";
    }

    private function getTwoFactorTemplate(Otp $otp): string
    {
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <h2 style='color: #6f42c1;'>Authentification à deux facteurs</h2>
            <p>Bonjour,</p>
            <p>Voici votre code d'authentification à deux facteurs :</p>
            <div style='background-color: #f8f9fa; padding: 20px; text-align: center; margin: 20px 0; border-radius: 5px;'>
                <h1 style='color: #6f42c1; font-size: 32px; margin: 0; letter-spacing: 5px;'>{$otp->code}</h1>
            </div>
            <p>Ce code expire le <strong>{$otp->expires_at->format('d/m/Y à H:i')}</strong>.</p>
            <p>Utilisez ce code pour compléter votre authentification.</p>
            <hr style='border: none; border-top: 1px solid #eee; margin: 30px 0;'>
            <p style='color: #666; font-size: 12px;'>
                Ceci est un email automatique, merci de ne pas y répondre.
            </p>
        </div>";
    }
}
