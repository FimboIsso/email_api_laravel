<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('site_visits', function (Blueprint $table) {
            $table->string('visitor_id', 64)->after('id')->index();
            $table->string('country', 2)->nullable()->after('referer');
            $table->string('city')->nullable()->after('country');
            $table->string('device_type', 20)->default('Desktop')->after('city');
            $table->string('browser', 50)->default('Unknown')->after('device_type');
            $table->string('platform', 50)->default('Unknown')->after('browser');
            $table->boolean('is_bot')->default(false)->after('platform');
            $table->string('session_id')->nullable()->after('is_bot');
            
            // Nouveaux index pour optimiser les requêtes
            $table->index(['visitor_id', 'visited_at']);
            $table->index(['is_bot', 'visited_at']);
            $table->index('device_type');
            $table->index('browser');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_visits', function (Blueprint $table) {
            $table->dropIndex(['visitor_id', 'visited_at']);
            $table->dropIndex(['is_bot', 'visited_at']);
            $table->dropIndex(['device_type']);
            $table->dropIndex(['browser']);
            
            $table->dropColumn([
                'visitor_id', 
                'country', 
                'city', 
                'device_type', 
                'browser', 
                'platform', 
                'is_bot', 
                'session_id'
            ]);
        });
    }
};
