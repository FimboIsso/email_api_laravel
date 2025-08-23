<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Config;

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
}
