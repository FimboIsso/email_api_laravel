<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

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
            'password' => 'hashed',
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
        return [
            'mail.mailers.smtp' => [
                'transport' => 'smtp',
                'host' => $this->mail_host,
                'port' => $this->mail_port,
                'encryption' => $this->mail_encryption,
                'username' => $this->mail_username,
                'password' => $this->mail_password,
            ],
            'mail.from' => [
                'address' => $this->mail_from_address,
                'name' => $this->mail_from_name,
            ],
        ];
    }
}
