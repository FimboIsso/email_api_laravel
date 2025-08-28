<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'api_token',
        'mail_mailer',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        'verification_code',
        'verification_code_expires_at',
        'is_completed',
        'phone',
        'company',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token',
        'mail_password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'verification_code_expires_at' => 'datetime',
            'password' => 'hashed',
            'is_completed' => 'boolean',
        ];
    }

    /**
     * Generate a new API token for the user.
     *
     * @return string
     */
    public function generateApiToken(): string
    {
        $token = hash('sha256', 'uzashop_api_' . $this->id . '_' . uniqid() . '_' . time());
        $this->update(['api_token' => $token]);
        return $token;
    }

    /**
     * Get the mail configuration for this user.
     *
     * @return array
     */
    public function getMailConfig(): array
    {
        // If user has custom mail configuration, use it
        if ($this->mail_host && $this->mail_from_address) {
            $config = [
                'mail.mailers.smtp' => [
                    'transport' => 'smtp',
                    'host' => $this->mail_host,
                    'port' => $this->mail_port ?: 587,
                    'encryption' => $this->mail_encryption ?: 'tls',
                    'username' => $this->mail_username,
                    'password' => $this->mail_password,
                ],
                'mail.from' => [
                    'address' => $this->mail_from_address,
                    'name' => $this->mail_from_name ?: env('APP_NAME', 'UZASHOP'),
                ],
                'mail.default' => $this->mail_mailer ?: 'smtp',
            ];
        } else {
            // Use system default configuration
            $config = [
                'mail.from' => [
                    'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
                    'name' => env('MAIL_FROM_NAME', env('APP_NAME', 'UZASHOP')),
                ],
                'mail.default' => env('MAIL_MAILER', 'log'),
            ];
        }

        return $config;
    }

    /**
     * Generate and set verification code for the user.
     *
     * @return string
     */
    public function generateVerificationCode(): string
    {
        $code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->update([
            'verification_code' => $code,
            'verification_code_expires_at' => now()->addMinutes(15)
        ]);
        return $code;
    }

    /**
     * Verify the provided code.
     *
     * @param string $code
     * @return bool
     */
    public function verifyCode(string $code): bool
    {
        return $this->verification_code === $code &&
            $this->verification_code_expires_at &&
            $this->verification_code_expires_at->isFuture();
    }

    /**
     * Clear verification code after successful verification.
     */
    public function clearVerificationCode(): void
    {
        $this->update([
            'verification_code' => null,
            'verification_code_expires_at' => null,
            'email_verified_at' => now()
        ]);
    }

    /**
     * Get the API tokens for the user.
     */
    public function apiTokens(): HasMany
    {
        return $this->hasMany(ApiToken::class);
    }

    /**
     * Get the email logs for the user.
     */
    public function emailLogs(): HasMany
    {
        return $this->hasMany(EmailLog::class);
    }

    /**
     * Get the mail configurations for the user.
     */
    public function mailConfigurations(): HasMany
    {
        return $this->hasMany(MailConfiguration::class);
    }

    /**
     * Get the OTPs for the user.
     */
    public function otps(): HasMany
    {
        return $this->hasMany(Otp::class);
    }

    /**
     * Get the latest active OTP of a specific type.
     */
    public function getActiveOtp(string $type = 'email_verification'): ?Otp
    {
        return $this->otps()
            ->where('type', $type)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
