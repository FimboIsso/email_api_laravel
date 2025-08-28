<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SiteVisit;
use Illuminate\Support\Facades\DB;

class CleanupOldVisits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'visits:cleanup {--days=365 : Number of days to keep}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old site visits to optimize database performance';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        
        $this->info("Cleaning up visits older than {$days} days...");
        
        $deleted = SiteVisit::cleanupOldVisits();
        
        $this->info("✅ Cleaned up {$deleted} old visit records.");
        
        // Optional: optimize database tables
        if ($this->confirm('Do you want to optimize the database tables?')) {
            $this->info('Optimizing database tables...');
            DB::statement('OPTIMIZE TABLE site_visits');
            $this->info('✅ Database tables optimized.');
        }
        
        return 0;
    }
}
