<?php

// Test simple pour vérifier la nouvelle fonctionnalité
require_once 'vendor/autoload.php';

$testData = [
    'to' => 'test@example.com',
    'subject' => 'Test Simple Template',
    'message' => 'Message de fallback',
    'template_content' => '<h1>Hello {{ $name }}!</h1><p>Welcome to {{ $company }}.</p>',
    'template_data' => [
        'name' => 'John Doe',
        'company' => 'My Company'
    ]
];

echo "Test de template simple:\n";
echo json_encode($testData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
echo "\n\nUtilisez cette requête pour tester l'API:\n";
echo "curl -X POST http://localhost:8585/api/send-email \\\n";
echo "  -H 'Content-Type: application/json' \\\n";
echo "  -H 'Authorization: Bearer YOUR_API_TOKEN' \\\n";
echo "  -d '" . json_encode($testData) . "'\n";
