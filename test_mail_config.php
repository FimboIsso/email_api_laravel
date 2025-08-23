<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Test de Configuration Mail ===\n\n";

// Test configuration par défaut
echo "Configuration par défaut du système:\n";
echo "mail.from.address: " . config('mail.from.address') . "\n";
echo "mail.from.name: " . config('mail.from.name') . "\n";
echo "mail.default: " . config('mail.default') . "\n\n";

// Test avec un utilisateur qui a une config personnalisée
echo "Test avec utilisateur ayant une configuration personnalisée:\n";
$user = \App\Models\User::first();

if ($user && $user->mail_from_address) {
    echo "Utilisateur: " . $user->email . "\n";
    echo "Config utilisateur - mail_from_address: " . $user->mail_from_address . "\n";
    echo "Config utilisateur - mail_from_name: " . $user->mail_from_name . "\n";

    // Appliquer la config utilisateur
    \App\Services\MailService::applyUserMailConfig($user);

    echo "Après application config utilisateur:\n";
    echo "mail.from.address: " . config('mail.from.address') . "\n";
    echo "mail.from.name: " . config('mail.from.name') . "\n";
} else {
    echo "Aucun utilisateur avec configuration personnalisée trouvé.\n";
}

echo "\n=== Test terminé ===\n";
