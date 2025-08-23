<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class EmailLog extends Model
{
    protected $fillable = [
        'user_id',
        'api_token_id',
        'mail_configuration_id',
        'to',
        'cc',
        'bcc',
        'subject',
        'message',
        'from_address',
        'from_name',
        'application_name',
        'mailer_used',
        'smtp_host',
        'smtp_port',
        'status',
        'error_message',
        'sent_at',
        'delivered_at',
        'bounced_at',
        'ip_address',
        'user_agent',
        'headers',
        'metadata'
    ];

    protected $casts = [
        'cc' => 'array',
        'bcc' => 'array',
        'headers' => 'array',
        'metadata' => 'array',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'bounced_at' => 'datetime',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function apiToken(): BelongsTo
    {
        return $this->belongsTo(ApiToken::class);
    }

    public function mailConfiguration(): BelongsTo
    {
        return $this->belongsTo(MailConfiguration::class);
    }

    // Scopes pour les statistiques
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByToken($query, $tokenId)
    {
        return $query->where('api_token_id', $tokenId);
    }

    public function scopeByApplication($query, $appName)
    {
        return $query->where('application_name', $appName);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeInDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    public function scopeSentEmails($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailedEmails($query)
    {
        return $query->where('status', 'failed');
    }

    // Méthodes utilitaires
    public function markAsSent()
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now()
        ]);
    }

    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage
        ]);
    }

    public function markAsDelivered()
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);
    }

    public function markAsBounced()
    {
        $this->update([
            'status' => 'bounced',
            'bounced_at' => now()
        ]);
    }
}
