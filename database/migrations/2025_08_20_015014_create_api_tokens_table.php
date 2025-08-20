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
        Schema::create('api_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nom du token pour l'identifier
            $table->string('token', 255)->unique(); // Le token unique
            $table->text('permissions')->nullable(); // Permissions JSON
            $table->timestamp('last_used_at')->nullable(); // Dernière utilisation
            $table->timestamp('expires_at')->nullable(); // Date d'expiration
            $table->boolean('is_active')->default(true); // Token actif ou non
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_tokens');
    }
};
