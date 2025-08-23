<?php

namespace App\Services;

use App\Models\User;
use App\Models\EmailLog;
use App\Models\ApiToken;
use App\Models\MailConfiguration;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailService
{
    /**
     * Apply system mail configuration (for platform authentication emails)
     * Uses .env configuration for system emails like verification codes
     *
     * @return void
     */
    public static function applySystemMailConfig(): void
    {
        // Use system defaults from .env
        Config::set('mail.default', env('MAIL_MAILER', 'log'));
        Config::set('mail.from.address', env('MAIL_FROM_ADDRESS', 'hello@example.com'));
        Config::set('mail.from.name', env('MAIL_FROM_NAME', env('APP_NAME')));
    }

    /**
     * Apply user mail configuration (for API emails)
     * Uses user's custom configuration for API email sending
     *
     * @param User|null $user
     * @return void
     */
    public static function applyUserMailConfig(?User $user = null): void
    {
        if (!$user) {
            self::applySystemMailConfig();
            return;
        }

        $config = $user->getMailConfig();

        // Apply the user configuration
        foreach ($config as $key => $value) {
            Config::set($key, $value);
        }
    }

    /**
     * Send email and log it
     *
     * @param array $emailData
     * @param User $user
     * @param ApiToken|null $token
     * @param MailConfiguration|null $mailConfig
     * @param Request|null $request
     * @return bool
     */
    public static function sendAndLogEmail(
        array $emailData,
        User $user,
        ?ApiToken $token = null,
        ?MailConfiguration $mailConfig = null,
        ?Request $request = null
    ): bool {
        // Create email log entry first
        $emailLog = EmailLog::create([
            'user_id' => $user->id,
            'api_token_id' => $token?->id,
            'mail_configuration_id' => $mailConfig?->id,
            'to' => $emailData['to'],
            'cc' => $emailData['cc'] ?? null,
            'bcc' => $emailData['bcc'] ?? null,
            'subject' => $emailData['subject'],
            'message' => $emailData['message'],
            'from_address' => $emailData['from_address'] ?? Config::get('mail.from.address'),
            'from_name' => $emailData['from_name'] ?? Config::get('mail.from.name'),
            'application_name' => $emailData['application_name'] ?? $token?->name ?? 'API',
            'mailer_used' => Config::get('mail.default'),
            'smtp_host' => Config::get('mail.mailers.smtp.host'),
            'smtp_port' => Config::get('mail.mailers.smtp.port'),
            'status' => 'pending',
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'metadata' => $emailData['metadata'] ?? null,
        ]);

        try {
            // Send the email
            Mail::raw($emailData['message'], function ($message) use ($emailData) {
                $message->to($emailData['to'])
                    ->subject($emailData['subject']);

                if (isset($emailData['cc'])) {
                    $message->cc($emailData['cc']);
                }

                if (isset($emailData['bcc'])) {
                    $message->bcc($emailData['bcc']);
                }

                if (isset($emailData['from_address']) && isset($emailData['from_name'])) {
                    $message->from($emailData['from_address'], $emailData['from_name']);
                }
            });

            // Mark as sent
            $emailLog->markAsSent();

            // Update token last used
            if ($token) {
                $token->markAsUsed();
            }

            return true;
        } catch (\Exception $e) {
            // Mark as failed with error message
            $emailLog->markAsFailed($e->getMessage());
            return false;
        }
    }

    /**
     * Get mail configuration for logging
     *
     * @param User $user
     * @param ApiToken|null $token
     * @return MailConfiguration|null
     */
    public static function getMailConfigurationForUser(User $user, ?ApiToken $token = null): ?MailConfiguration
    {
        // If token has a specific mail configuration, use it
        if ($token && $token->mail_configuration_id) {
            return $token->mailConfiguration;
        }

        // Otherwise, use user's default mail configuration
        return $user->mailConfigurations()->default()->active()->first();
    }
}
