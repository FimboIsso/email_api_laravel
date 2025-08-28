<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Otp;

class CleanupExpiredOtps extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'otp:cleanup
                            {--force : Force deletion without confirmation}
                            {--older-than=24 : Delete OTPs older than X hours (default: 24)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired OTPs from the database';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $olderThanHours = (int) $this->option('older-than');
        $force = $this->option('force');

        // Compter les OTP à supprimer
        $expiredCount = Otp::where('expires_at', '<', now()->subHours($olderThanHours))->count();

        if ($expiredCount === 0) {
            $this->info('Aucun OTP expiré trouvé.');
            return self::SUCCESS;
        }

        $this->info("Trouvé {$expiredCount} OTP(s) expiré(s) depuis plus de {$olderThanHours}h.");

        if (!$force && !$this->confirm('Voulez-vous procéder à la suppression ?')) {
            $this->info('Opération annulée.');
            return self::SUCCESS;
        }

        // Supprimer les OTP expirés
        $deletedCount = Otp::where('expires_at', '<', now()->subHours($olderThanHours))->delete();

        $this->info("✅ {$deletedCount} OTP(s) expiré(s) supprimé(s) avec succès.");

        return self::SUCCESS;
    }
}
