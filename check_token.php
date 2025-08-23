<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== Vérification et génération de Token API ===\n\n";

// Chercher l'utilisateur avec l'email fimbo.isso@gmail.com
$user = \App\Models\User::where('email', 'fimbo.isso@gmail.com')->first();

if (!$user) {
    echo "❌ Utilisateur avec l'email 'fimbo.isso@gmail.com' non trouvé.\n";
    echo "Utilisateurs disponibles:\n";
    $users = \App\Models\User::all(['id', 'name', 'email', 'api_token']);
    foreach ($users as $u) {
        echo "- ID: {$u->id}, Email: {$u->email}, Token: " . ($u->api_token ? 'Oui' : 'Non') . "\n";
    }
    exit;
}

echo "✅ Utilisateur trouvé: {$user->name} ({$user->email})\n";

// Vérifier le token actuel
if ($user->api_token) {
    echo "🔑 Token actuel: {$user->api_token}\n";
    echo "🔍 Token fourni: b94137bdcf0cce65e7923310ec839e4ab69b07de95503a467f2cf7c89be47e2e\n";

    if ($user->api_token === 'b94137bdcf0cce65e7923310ec839e4ab69b07de95503a467f2cf7c89be47e2e') {
        echo "✅ Le token correspond !\n";
    } else {
        echo "❌ Le token ne correspond pas.\n";
        echo "🔄 Génération d'un nouveau token...\n";
        $newToken = $user->generateApiToken();
        echo "✅ Nouveau token généré: {$newToken}\n";
    }
} else {
    echo "❌ Aucun token trouvé pour cet utilisateur.\n";
    echo "🔄 Génération d'un nouveau token...\n";
    $newToken = $user->generateApiToken();
    echo "✅ Nouveau token généré: {$newToken}\n";
}

// Afficher la configuration mail de l'utilisateur
echo "\n=== Configuration Mail ===\n";
echo "Mailer: " . ($user->mail_mailer ?: 'Non configuré') . "\n";
echo "Host: " . ($user->mail_host ?: 'Non configuré') . "\n";
echo "Port: " . ($user->mail_port ?: 'Non configuré') . "\n";
echo "From Address: " . ($user->mail_from_address ?: 'Non configuré') . "\n";
echo "From Name: " . ($user->mail_from_name ?: 'Non configuré') . "\n";

echo "\n=== Test de configuration ===\n";
$config = $user->getMailConfig();
echo "Configuration retournée:\n";
print_r($config);

echo "\n=== Fin ===\n";
