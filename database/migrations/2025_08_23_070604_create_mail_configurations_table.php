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
        Schema::create('mail_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nom de la configuration
            $table->string('mailer')->default('smtp'); // smtp, sendmail, mailgun, etc.
            $table->string('host')->nullable(); // Serveur SMTP
            $table->integer('port')->nullable(); // Port SMTP
            $table->string('username')->nullable(); // Utilisateur SMTP
            $table->string('password')->nullable(); // Mot de passe SMTP (crypté)
            $table->string('encryption')->nullable(); // tls, ssl, null
            $table->string('from_address'); // Adresse d'expédition
            $table->string('from_name'); // Nom d'expédition
            $table->boolean('is_active')->default(true); // Configuration active
            $table->boolean('is_default')->default(false); // Configuration par défaut pour l'utilisateur
            $table->text('notes')->nullable(); // Notes sur la configuration
            $table->timestamps();

            // Index pour performance
            $table->index(['user_id', 'is_active']);
            $table->index(['user_id', 'is_default']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mail_configurations');
    }
};
