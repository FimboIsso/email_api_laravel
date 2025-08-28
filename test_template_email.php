<?php

// Test script pour vérifier la nouvelle fonctionnalité de template
require_once 'vendor/autoload.php';

// Exemple de requête JSON avec template Blade
$testData = [
    'to' => 'test@example.com',
    'subject' => 'Test Email avec Template Blade',
    'message' => 'Message de fallback si le template échoue',
    'template_content' => '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome Email</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { background: #007bff; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; background: #f8f9fa; }
        .button {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
        .footer { text-align: center; margin-top: 30px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bienvenue {{ $user_name }}!</h1>
    </div>

    <div class="content">
        <p>Nous sommes ravis de vous accueillir chez <strong>{{ $company_name }}</strong>.</p>

        <p>Voici quelques informations importantes :</p>
        <ul>
            <li>Votre compte a été créé le {{ $created_date }}</li>
            <li>Votre niveau d\'accès : {{ $access_level }}</li>
            <li>Support technique disponible 24/7</li>
        </ul>

        <p>Pour commencer, cliquez sur le bouton ci-dessous :</p>
        <a href="{{ $activation_link }}" class="button">Activer mon compte</a>

        @if(isset($special_offer))
            <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; margin: 20px 0; border-radius: 5px;">
                <h3>🎉 Offre spéciale !</h3>
                <p>{{ $special_offer }}</p>
            </div>
        @endif
    </div>

    <div class="footer">
        <p>Merci de nous faire confiance,<br>
        L\'équipe {{ $company_name }}</p>

        <p><small>Si vous avez des questions, contactez-nous à support@{{ strtolower($company_name) }}.com</small></p>
    </div>
</body>
</html>
    ',
    'template_data' => [
        'user_name' => 'Jean Dupont',
        'company_name' => 'MonEntreprise',
        'created_date' => '28 août 2025',
        'access_level' => 'Premium',
        'activation_link' => 'https://monentreprise.com/activate?token=abc123',
        'special_offer' => 'Profitez de 30% de réduction sur tous nos services pendant votre premier mois !'
    ],
    'application_name' => 'Système d\'authentification'
];

echo "Données de test préparées pour l'API d'envoi d'email avec template Blade:\n\n";
echo json_encode($testData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

echo "\n\nPour tester, envoyez ces données via POST à votre endpoint /api/send-email\n";
echo "Exemple avec curl:\n";
echo "curl -X POST http://localhost:8585/api/send-email \\\n";
echo "  -H 'Content-Type: application/json' \\\n";
echo "  -H 'Authorization: Bearer YOUR_API_TOKEN' \\\n";
echo "  -d '" . json_encode($testData) . "'\n";
