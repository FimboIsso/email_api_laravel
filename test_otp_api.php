<?php

/**
 * Script de test pour l'API OTP
 *
 * Ce script teste les fonctionnalités principales de l'API OTP
 * Usage: php test_otp_api.php
 */

require_once 'vendor/autoload.php';

// Configuration
$baseUrl = 'http://127.0.0.1:8587/api';
$testEmail = 'fimbo.isso@gmail.com';

// Token API fourni par l'utilisateur
$apiToken = 'b94137bdcf0cce65e7923310ec839e4ab69b07de95503a467f2cf7c89be47e2e';

class OtpApiTester
{
    private $baseUrl;
    private $apiToken;
    private $testEmail;

    public function __construct($baseUrl, $apiToken, $testEmail)
    {
        $this->baseUrl = $baseUrl;
        $this->apiToken = $apiToken;
        $this->testEmail = $testEmail;
    }

    private function makeRequest($endpoint, $method = 'GET', $data = null)
    {
        $url = $this->baseUrl . $endpoint;

        $headers = [
            'Authorization: Bearer ' . $this->apiToken,
            'Content-Type: application/json',
            'Accept: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            if ($data) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            }
        } elseif ($method === 'DELETE') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [
            'http_code' => $httpCode,
            'response' => json_decode($response, true)
        ];
    }

    public function testGenerateOtp()
    {
        echo "🧪 Test: Génération d'OTP...\n";

        $result = $this->makeRequest('/otp/generate', 'POST', [
            'email' => $this->testEmail,
            'type' => 'email_verification',
            'identifier' => 'test_suite',
            'validity_minutes' => 15
        ]);

        if ($result['http_code'] === 200) {
            echo "✅ OTP généré avec succès\n";
            echo "   OTP ID: " . $result['response']['data']['otp_id'] . "\n";
            echo "   Expire: " . $result['response']['data']['expires_at'] . "\n\n";
            return $result['response']['data']['otp_id'];
        } else {
            echo "❌ Erreur lors de la génération: " . $result['response']['message'] . "\n\n";
            return null;
        }
    }

    public function testOtpStatus()
    {
        echo "🧪 Test: Statut de l'OTP...\n";

        $result = $this->makeRequest('/otp/status?' . http_build_query([
            'email' => $this->testEmail,
            'type' => 'email_verification'
        ]));

        if ($result['http_code'] === 200) {
            echo "✅ Statut récupéré avec succès\n";
            if ($result['response']['data']['has_active_otp']) {
                echo "   OTP actif trouvé\n";
                echo "   Tentatives: " . $result['response']['data']['attempts'] . "/" . $result['response']['data']['max_attempts'] . "\n";
                echo "   Expiré: " . ($result['response']['data']['is_expired'] ? 'Oui' : 'Non') . "\n\n";
            } else {
                echo "   Aucun OTP actif\n\n";
            }
        } else {
            echo "❌ Erreur lors de la récupération du statut: " . $result['response']['message'] . "\n\n";
        }
    }

    public function testVerifyInvalidOtp()
    {
        echo "🧪 Test: Vérification OTP invalide...\n";

        $result = $this->makeRequest('/otp/verify', 'POST', [
            'email' => $this->testEmail,
            'code' => '000000', // Code invalide
            'type' => 'email_verification'
        ]);

        if ($result['http_code'] === 400) {
            echo "✅ Code invalide correctement rejeté\n";
            echo "   Message: " . $result['response']['message'] . "\n\n";
        } else {
            echo "❌ Comportement inattendu pour code invalide\n\n";
        }
    }

    public function testResendOtp()
    {
        echo "🧪 Test: Renvoi d'OTP...\n";

        $result = $this->makeRequest('/otp/resend', 'POST', [
            'email' => $this->testEmail,
            'type' => 'email_verification',
            'identifier' => 'test_suite_resend'
        ]);

        if ($result['http_code'] === 200) {
            echo "✅ OTP renvoyé avec succès\n";
            echo "   Nouveau OTP ID: " . $result['response']['data']['otp_id'] . "\n\n";
        } elseif ($result['http_code'] === 429) {
            echo "⏳ Rate limiting activé (normal)\n";
            echo "   Cooldown: " . $result['response']['cooldown_remaining'] . " secondes\n\n";
        } else {
            echo "❌ Erreur lors du renvoi: " . $result['response']['message'] . "\n\n";
        }
    }

    public function testDifferentOtpTypes()
    {
        echo "🧪 Test: Différents types d'OTP...\n";

        $types = ['password_reset', 'login_verification', 'two_factor'];

        foreach ($types as $type) {
            echo "   Testing type: $type...\n";

            $result = $this->makeRequest('/otp/generate', 'POST', [
                'email' => $this->testEmail,
                'type' => $type,
                'validity_minutes' => 10
            ]);

            if ($result['http_code'] === 200) {
                echo "   ✅ Type $type généré avec succès\n";
            } else {
                echo "   ❌ Erreur pour type $type: " . $result['response']['message'] . "\n";
            }
        }
        echo "\n";
    }

    public function testCleanup()
    {
        echo "🧪 Test: Nettoyage des OTP expirés...\n";

        $result = $this->makeRequest('/otp/cleanup', 'DELETE');

        if ($result['http_code'] === 200) {
            echo "✅ Nettoyage effectué\n";
            echo "   OTP supprimés: " . $result['response']['deleted_count'] . "\n\n";
        } else {
            echo "❌ Erreur lors du nettoyage: " . $result['response']['message'] . "\n\n";
        }
    }

    public function runAllTests()
    {
        echo "🚀 Début des tests de l'API OTP\n";
        echo "=================================\n\n";

        // Vérifier que l'utilisateur existe
        echo "📧 Email de test: " . $this->testEmail . "\n";
        echo "🔑 Token API: " . substr($this->apiToken, 0, 10) . "...\n\n";

        // Tests principaux
        $otpId = $this->testGenerateOtp();
        $this->testOtpStatus();
        $this->testVerifyInvalidOtp();
        $this->testResendOtp();
        $this->testDifferentOtpTypes();
        $this->testCleanup();

        echo "✨ Tests terminés!\n";
        echo "=================\n\n";

        if ($otpId) {
            echo "💡 Pour tester la vérification d'un code valide:\n";
            echo "   1. Consultez l'email envoyé à: " . $this->testEmail . "\n";
            echo "   2. Utilisez le code reçu avec l'endpoint /otp/verify\n\n";
        }

        echo "📖 Documentation complète disponible dans: OTP_API_DOCUMENTATION.md\n";
    }
}

// Vérification des paramètres
if (empty($apiToken)) {
    echo "❌ ERREUR: Aucun API token configuré\n";
    exit(1);
}

// Exécution des tests
$tester = new OtpApiTester($baseUrl, $apiToken, $testEmail);
$tester->runAllTests();
