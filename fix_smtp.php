<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Correction de la configuration SMTP ===\n\n";

$user = \App\Models\User::where('email', 'fimbo.isso@gmail.com')->first();

if ($user) {
    echo "✅ Utilisateur trouvé: {$user->name}\n";
    echo "🔍 Configuration SMTP actuelle: {$user->mail_host}\n";

    if ($user->mail_host === 'smt.gmail.com') {
        $user->update(['mail_host' => 'smtp.gmail.com']);
        echo "✅ Configuration corrigée: smtp.gmail.com\n";
    } else {
        echo "ℹ️ Configuration déjà correcte\n";
    }

    echo "\n=== Configuration finale ===\n";
    $user->refresh();
    echo "Host: {$user->mail_host}\n";
    echo "Port: {$user->mail_port}\n";
    echo "Encryption: {$user->mail_encryption}\n";
    echo "Username: {$user->mail_username}\n";
    echo "From Address: {$user->mail_from_address}\n";
    echo "From Name: {$user->mail_from_name}\n";
    echo "Token: {$user->api_token}\n";
} else {
    echo "❌ Utilisateur non trouvé\n";
}

echo "\n=== Fin ===\n";
