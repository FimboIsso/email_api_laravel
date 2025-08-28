<?php

require_once 'vendor/autoload.php';

// Base URL de l'API
$baseUrl = 'http://127.0.0.1:8587';
$apiToken = 'cc7d47a02f7698c0ba53a60362bb767a749f8712d420c7eb8597e3aa7a62a388';

/**
 * Effectue une requête HTTP
 */
function makeRequest($url, $method = 'GET', $data = null, $headers = [])
{
    $ch = curl_init();

    $defaultHeaders = [
        'Content-Type: application/json',
        'Accept: application/json'
    ];

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => array_merge($defaultHeaders, $headers),
        CURLOPT_TIMEOUT => 30,
    ]);

    if ($data && in_array($method, ['POST', 'PUT', 'PATCH'])) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return [
        'status' => $httpCode,
        'data' => json_decode($response, true)
    ];
}

/**
 * Génère un OTP de test
 */
function generateTestOtp($email, $type = 'email_verification', $identifier = null)
{
    global $baseUrl, $apiToken;

    $data = [
        'email' => $email,
        'type' => $type,
        'validity_minutes' => 15
    ];

    if ($identifier) {
        $data['identifier'] = $identifier;
    }

    $headers = ["Authorization: Bearer $apiToken"];

    return makeRequest("$baseUrl/api/otp/generate", 'POST', $data, $headers);
}

echo "=== Test de génération d'OTP pour le dashboard ===\n\n";

// Générer différents types d'OTP pour tester le dashboard
$testCases = [
    [
        'email' => 'admin@uzashop.com',
        'type' => 'email_verification',
        'identifier' => 'registration_demo'
    ],
    [
        'email' => 'user1@example.com',
        'type' => 'password_reset',
        'identifier' => 'reset_demo'
    ],
    [
        'email' => 'user2@example.com',
        'type' => 'login_verification',
        'identifier' => 'login_demo'
    ],
    [
        'email' => 'user3@example.com',
        'type' => 'two_factor',
        'identifier' => '2fa_demo'
    ],
    [
        'email' => 'test@example.com',
        'type' => 'email_verification',
        'identifier' => 'test_demo'
    ]
];

$success = 0;
$total = count($testCases);

foreach ($testCases as $i => $test) {
    echo ($i + 1) . ". Génération OTP pour {$test['email']} ({$test['type']})...\n";

    $result = generateTestOtp($test['email'], $test['type'], $test['identifier']);

    if ($result['status'] == 200 && $result['data']['success']) {
        echo "   ✅ Succès - Code: {$result['data']['data']['code']}\n";
        $success++;

        // Attendre un peu pour éviter le rate limiting
        sleep(1);
    } else {
        echo "   ❌ Erreur - Status: {$result['status']}\n";
        if (isset($result['data']['message'])) {
            echo "      Message: {$result['data']['message']}\n";
        }
    }
    echo "\n";
}

echo "=== Résumé ===\n";
echo "OTP générés avec succès: $success/$total\n";
echo "\n";

echo "🎯 Vous pouvez maintenant aller sur le dashboard pour voir les authentifications OTP :\n";
echo "   URL: http://127.0.0.1:8587/dashboard/otp-authentications\n";
echo "\n";

echo "📖 Pour voir la documentation complète :\n";
echo "   URL: http://127.0.0.1:8587/otp-api-docs\n";
echo "\n";

echo "🔗 Menu ajouté dans la sidebar du dashboard :\n";
echo "   - Section 'Authentifications OTP' avec compteur d'activité\n";
echo "   - Filtres par email, statut et type\n";
echo "   - Statistiques en temps réel\n";
echo "\n";

// Afficher quelques exemples de vérification
if ($success > 0) {
    echo "=== Exemple de vérification d'OTP ===\n";
    echo "Vous pouvez maintenant tester la vérification avec :\n";
    echo "\n";
    echo "curl -X POST $baseUrl/api/otp/verify \\\n";
    echo "  -H \"Authorization: Bearer $apiToken\" \\\n";
    echo "  -H \"Content-Type: application/json\" \\\n";
    echo "  -d '{\n";
    echo "    \"email\": \"admin@uzashop.com\",\n";
    echo "    \"code\": \"VOTRE_CODE_ICI\",\n";
    echo "    \"type\": \"email_verification\"\n";
    echo "  }'\n";
    echo "\n";
}
