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
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->string('code', 6);
            $table->string('type')->default('email_verification'); // email_verification, password_reset, login, etc.
            $table->string('identifier')->nullable(); // pour identifier le contexte (app_name, session_id, etc.)
            $table->timestamp('expires_at');
            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();
            $table->integer('attempts')->default(0);
            $table->json('metadata')->nullable(); // pour stocker des données additionnelles
            $table->timestamps();

            $table->index(['email', 'code', 'type']);
            $table->index(['user_id', 'type']);
            $table->index('expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
