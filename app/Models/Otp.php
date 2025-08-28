<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email',
        'code',
        'type',
        'identifier',
        'expires_at',
        'is_used',
        'used_at',
        'attempts',
        'metadata',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'is_used' => 'boolean',
        'metadata' => 'array',
    ];

    /**
     * Get the user that owns the OTP.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the OTP is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if the OTP is valid (not used and not expired).
     */
    public function isValid(): bool
    {
        return !$this->is_used && !$this->isExpired();
    }

    /**
     * Mark the OTP as used.
     */
    public function markAsUsed(): void
    {
        $this->update([
            'is_used' => true,
            'used_at' => now(),
        ]);
    }

    /**
     * Increment the attempts counter.
     */
    public function incrementAttempts(): void
    {
        $this->increment('attempts');
    }

    /**
     * Check if maximum attempts reached.
     */
    public function hasReachedMaxAttempts(int $maxAttempts = 5): bool
    {
        return $this->attempts >= $maxAttempts;
    }

    /**
     * Generate a new OTP code.
     */
    public static function generateCode(int $length = 6): string
    {
        return str_pad(mt_rand(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new OTP for a user.
     */
    public static function createForUser(
        User $user,
        string $type = 'email_verification',
        string $identifier = null,
        int $validityMinutes = 15,
        array $metadata = []
    ): self {
        // Invalider les anciens OTP non utilisés du même type
        self::where('user_id', $user->id)
            ->where('type', $type)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        return self::create([
            'user_id' => $user->id,
            'email' => $user->email,
            'code' => self::generateCode(),
            'type' => $type,
            'identifier' => $identifier,
            'expires_at' => now()->addMinutes($validityMinutes),
            'metadata' => $metadata,
        ]);
    }

    /**
     * Find valid OTP by email and code.
     */
    public static function findValidByEmailAndCode(
        string $email,
        string $code,
        string $type = 'email_verification'
    ): ?self {
        return self::where('email', $email)
            ->where('code', $code)
            ->where('type', $type)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();
    }

    /**
     * Clean up expired OTPs.
     */
    public static function cleanupExpired(): int
    {
        return self::where('expires_at', '<', now()->subHours(24))->delete();
    }
}
