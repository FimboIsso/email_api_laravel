<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Test Logique Mail Séparée ===\n\n";

echo "1. Configuration système (pour codes d'authentification):\n";
\App\Services\MailService::applySystemMailConfig();
echo "mail.from.address: " . config('mail.from.address') . "\n";
echo "mail.from.name: " . config('mail.from.name') . "\n";
echo "mail.default: " . config('mail.default') . "\n\n";

echo "2. Configuration utilisateur (pour API):\n";
$user = \App\Models\User::first();
if ($user) {
    \App\Services\MailService::applyUserMailConfig($user);
    echo "mail.from.address: " . config('mail.from.address') . "\n";
    echo "mail.from.name: " . config('mail.from.name') . "\n";
    echo "mail.default: " . config('mail.default') . "\n\n";
} else {
    echo "Aucun utilisateur trouvé.\n\n";
}

echo "3. Test VerificationCodeMail (utilise env() directement):\n";
echo "env('MAIL_FROM_ADDRESS'): " . env('MAIL_FROM_ADDRESS') . "\n";
echo "env('MAIL_FROM_NAME'): " . env('MAIL_FROM_NAME') . "\n\n";

echo "=== Test terminé ===\n";
