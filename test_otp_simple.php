<?php

/**
 * Test simple de l'API OTP
 */

$apiToken = 'b94137bdcf0cce65e7923310ec839e4ab69b07de95503a467f2cf7c89be47e2e';
$baseUrl = 'http://127.0.0.1:8587/api';
$email = 'fimbo.isso@gmail.com';

echo "🚀 Test simple de l'API OTP\n";
echo "==========================\n\n";

// Test 1: Générer un OTP
echo "1️⃣ Test de génération d'OTP...\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $baseUrl . '/otp/generate');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $apiToken,
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'email' => $email,
    'type' => 'email_verification',
    'validity_minutes' => 15
]));

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "Status HTTP: $httpCode\n";
echo "Réponse: $response\n\n";

if ($httpCode === 200) {
    $data = json_decode($response, true);
    echo "✅ OTP généré avec succès!\n";
    echo "   OTP ID: " . $data['data']['otp_id'] . "\n";
    echo "   Expire: " . $data['data']['expires_at'] . "\n\n";

    // Test 2: Vérifier le statut
    echo "2️⃣ Test du statut de l'OTP...\n";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl . '/otp/status?' . http_build_query([
        'email' => $email,
        'type' => 'email_verification'
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiToken,
        'Accept: application/json'
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "Status HTTP: $httpCode\n";
    echo "Réponse: $response\n\n";

    if ($httpCode === 200) {
        echo "✅ Statut récupéré avec succès!\n\n";
    }

    // Test 3: Tenter de vérifier avec un code invalide
    echo "3️⃣ Test de vérification avec code invalide...\n";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl . '/otp/verify');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiToken,
        'Content-Type: application/json',
        'Accept: application/json'
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'email' => $email,
        'code' => '000000',
        'type' => 'email_verification'
    ]));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo "Status HTTP: $httpCode\n";
    echo "Réponse: $response\n\n";

    if ($httpCode === 400) {
        echo "✅ Code invalide correctement rejeté!\n\n";
    }
} else {
    echo "❌ Erreur lors de la génération de l'OTP\n";
    echo "Vérifiez que le serveur est en cours d'exécution sur http://127.0.0.1:8587\n\n";
}

echo "✨ Tests terminés!\n";
echo "=================\n\n";
echo "💡 Pour tester un code valide:\n";
echo "   1. Consultez l'email envoyé à: $email\n";
echo "   2. Utilisez le code reçu avec cURL:\n\n";
echo "curl -X POST http://127.0.0.1:8587/api/otp/verify \\\n";
echo "  -H \"Authorization: Bearer $apiToken\" \\\n";
echo "  -H \"Content-Type: application/json\" \\\n";
echo "  -d '{\"email\":\"$email\",\"code\":\"123456\",\"type\":\"email_verification\"}'\n\n";
