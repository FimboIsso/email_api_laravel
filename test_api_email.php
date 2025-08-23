<?php

$url = 'http://127.0.0.1:8585/api/send-email';
$token = '492d8288e10bd6ae1c741ce7e914a7905777c54246700b131466bc3187f9ca55';

$data = [
    'to' => 'fimbo.isso@gmail.com',
    'subject' => 'Test Email API UZASHOP - Fonctionnement Confirmé',
    'message' => 'Félicitations ! Ceci est un email de test envoyé via votre API UZASHOP. L\'authentification par token fonctionne parfaitement et votre configuration mail personnalisée est appliquée. Votre API est prête à être utilisée en production !'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);

echo "Envoi de l'email de test...\n";
echo "URL: $url\n";
echo "Destinataire: fimbo.isso@gmail.com\n";
echo "Token: " . substr($token, 0, 10) . "...\n\n";

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if (curl_errno($ch)) {
    echo 'Erreur cURL: ' . curl_error($ch) . "\n";
} else {
    echo "Code de réponse HTTP: $httpCode\n";
    echo "Réponse: " . $response . "\n";
}

curl_close($ch);
