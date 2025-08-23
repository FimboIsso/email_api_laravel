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
        Schema::create('email_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Utilisateur qui a envoyé l'email
            $table->foreignId('api_token_id')->nullable()->constrained()->onDelete('set null'); // Token utilisé
            $table->foreignId('mail_configuration_id')->nullable()->constrained()->onDelete('set null'); // Configuration mail utilisée

            // Informations sur l'email
            $table->string('to'); // Destinataire principal
            $table->text('cc')->nullable(); // Destinataires en copie (JSON)
            $table->text('bcc')->nullable(); // Destinataires en copie cachée (JSON)
            $table->string('subject'); // Sujet de l'email
            $table->text('message'); // Contenu du message
            $table->string('from_address'); // Adresse d'expédition utilisée
            $table->string('from_name'); // Nom d'expédition utilisé

            // Informations techniques
            $table->string('application_name')->nullable(); // Nom de l'application qui a envoyé l'email
            $table->string('mailer_used'); // Type de mailer utilisé (smtp, sendmail, etc.)
            $table->string('smtp_host')->nullable(); // Serveur SMTP utilisé
            $table->integer('smtp_port')->nullable(); // Port SMTP utilisé

            // Status et tracking
            $table->enum('status', ['pending', 'sent', 'failed', 'bounced', 'delivered'])->default('pending');
            $table->text('error_message')->nullable(); // Message d'erreur si échec
            $table->timestamp('sent_at')->nullable(); // Date d'envoi réel
            $table->timestamp('delivered_at')->nullable(); // Date de livraison (si tracking disponible)
            $table->timestamp('bounced_at')->nullable(); // Date de bounce (si applicable)

            // Métadonnées pour statistiques
            $table->string('ip_address')->nullable(); // IP de l'expéditeur
            $table->string('user_agent')->nullable(); // User agent de la requête
            $table->json('headers')->nullable(); // Headers supplémentaires
            $table->json('metadata')->nullable(); // Métadonnées supplémentaires

            $table->timestamps();

            // Index pour optimiser les requêtes de statistiques
            $table->index(['user_id', 'status', 'created_at']);
            $table->index(['api_token_id', 'status', 'created_at']);
            $table->index(['application_name', 'status', 'created_at']);
            $table->index(['status', 'created_at']);
            $table->index(['sent_at']);
            $table->index(['to']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_logs');
    }
};
