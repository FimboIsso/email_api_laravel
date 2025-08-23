<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class MailConfiguration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'port' => 'integer',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Ensure only one default configuration per user
        static::saving(function ($mailConfig) {
            if ($mailConfig->is_default) {
                static::where('user_id', $mailConfig->user_id)
                    ->where('id', '!=', $mailConfig->id)
                    ->update(['is_default' => false]);
            }
        });
    }

    /**
     * Get the user that owns the mail configuration.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the API tokens that use this configuration.
     */
    public function apiTokens(): HasMany
    {
        return $this->hasMany(ApiToken::class);
    }

    /**
     * Set the password attribute (encrypt it).
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Crypt::encryptString($value);
        }
    }

    /**
     * Get the password attribute (decrypt it).
     */
    public function getPasswordAttribute($value)
    {
        if ($value) {
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
    }

    /**
     * Get the mail configuration as array for Laravel Mail.
     */
    public function toMailConfig(): array
    {
        $config = [
            'mail.default' => $this->mailer,
            'mail.from' => [
                'address' => $this->from_address,
                'name' => $this->from_name,
            ],
        ];

        if ($this->mailer === 'smtp') {
            $config['mail.mailers.smtp'] = [
                'transport' => 'smtp',
                'host' => $this->host,
                'port' => $this->port ?: 587,
                'encryption' => $this->encryption,
                'username' => $this->username,
                'password' => $this->password,
            ];
        }

        return $config;
    }

    /**
     * Test the mail configuration.
     */
    public function test(string $toEmail): bool
    {
        try {
            // Apply the configuration temporarily
            $originalConfig = config('mail');
            config($this->toMailConfig());

            // Send a test email
            Mail::raw('Test de configuration d\'envoi d\'emails.', function ($message) use ($toEmail) {
                $message->to($toEmail)
                    ->subject('Test de configuration email');
            });

            // Restore original configuration
            config(['mail' => $originalConfig]);

            return true;
        } catch (\Exception $e) {
            // Restore original configuration in case of error
            if (isset($originalConfig)) {
                config(['mail' => $originalConfig]);
            }
            return false;
        }
    }

    /**
     * Scope to get only active configurations.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get the default configuration for a user.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get the masked password for display.
     */
    public function getMaskedPasswordAttribute(): string
    {
        if (!$this->password) {
            return '';
        }
        return str_repeat('*', 8);
    }
}
