@extends('layouts.app')

@section('title', 'Documentation API')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Documentation API</h1>
                <p class="mt-2 text-sm text-gray-700">Guide complet pour utiliser l'API UZASHOP Email</p>
            </div>
            <div class="flex gap-3">
                <button onclick="copyToClipboard('{{ auth()->user()->api_token ?: 'Générez d\'abord un token' }}')"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    Copier le Token
                </button>
            </div>
        </div>

        <!-- Quick Start -->
        <div class="bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-xl p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">🚀 Démarrage Rapide</h2>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <div class="text-indigo-600 font-semibold mb-2">1. Générer un Token</div>
                    <p class="text-sm text-gray-600">Créez un token API depuis votre dashboard</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <div class="text-indigo-600 font-semibold mb-2">2. Configurer SMTP</div>
                    <p class="text-sm text-gray-600">Configurez vos paramètres d'envoi d'emails</p>
                </div>
                <div class="bg-white rounded-lg p-4 shadow-sm">
                    <div class="text-indigo-600 font-semibold mb-2">3. Envoyer des Emails</div>
                    <p class="text-sm text-gray-600">Utilisez l'API pour envoyer vos emails</p>
                </div>
            </div>
        </div>

        <!-- API Endpoints -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">📡 Endpoints API</h2>
            </div>
            <div class="p-6 space-y-8">

                <!-- Send Email Endpoint -->
                <div class="border rounded-lg overflow-hidden">
                    <div class="bg-green-50 px-4 py-3 border-b">
                        <div class="flex items-center gap-3">
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-mono">POST</span>
                            <code class="text-gray-900 font-mono">/api/send-email</code>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <h3 class="font-semibold text-gray-900">Envoyer un Email</h3>
                        <p class="text-sm text-gray-600">Envoie un email via votre configuration SMTP.</p>

                        <div class="space-y-3">
                            <h4 class="font-medium text-gray-900">Headers</h4>
                            <div class="bg-gray-50 rounded p-3 font-mono text-sm">
                                <div>Authorization: Bearer YOUR_API_TOKEN</div>
                                <div>Content-Type: application/json</div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h4 class="font-medium text-gray-900">Paramètres</h4>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="text-left p-2 font-medium text-gray-900">Paramètre</th>
                                            <th class="text-left p-2 font-medium text-gray-900">Type</th>
                                            <th class="text-left p-2 font-medium text-gray-900">Requis</th>
                                            <th class="text-left p-2 font-medium text-gray-900">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        <tr>
                                            <td class="p-2 font-mono text-blue-600">to</td>
                                            <td class="p-2 text-gray-600">string</td>
                                            <td class="p-2"><span
                                                    class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Oui</span>
                                            </td>
                                            <td class="p-2 text-gray-600">Adresse email du destinataire</td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 font-mono text-blue-600">subject</td>
                                            <td class="p-2 text-gray-600">string</td>
                                            <td class="p-2"><span
                                                    class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Oui</span>
                                            </td>
                                            <td class="p-2 text-gray-600">Sujet de l'email</td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 font-mono text-blue-600">message</td>
                                            <td class="p-2 text-gray-600">string</td>
                                            <td class="p-2"><span
                                                    class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Oui</span>
                                            </td>
                                            <td class="p-2 text-gray-600">Contenu de l'email (HTML supporté)</td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 font-mono text-blue-600">from_name</td>
                                            <td class="p-2 text-gray-600">string</td>
                                            <td class="p-2"><span
                                                    class="bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">Non</span>
                                            </td>
                                            <td class="p-2 text-gray-600">Nom de l'expéditeur (optionnel)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h4 class="font-medium text-gray-900">Exemple de Requête</h4>
                            <div class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto">
                                <pre><code>curl -X POST {{ url('/api/send-email') }} \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "to": "destinataire@example.com",
    "subject": "Test Email",
    "message": "Bonjour, ceci est un email de test!",
    "from_name": "Mon App"
  }'</code></pre>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <h4 class="font-medium text-gray-900">Réponse</h4>
                            <div class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto">
                                <pre><code>{
  "success": true,
  "message": "Email envoyé avec succès!"
}</code></pre>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Send Verification Code Endpoint -->
                <div class="border rounded-lg overflow-hidden">
                    <div class="bg-blue-50 px-4 py-3 border-b">
                        <div class="flex items-center gap-3">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-mono">POST</span>
                            <code class="text-gray-900 font-mono">/api/send-verification-code</code>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <h3 class="font-semibold text-gray-900">Envoyer un Code de Vérification</h3>
                        <p class="text-sm text-gray-600">Génère et envoie un code de vérification à 6 chiffres.</p>

                        <div class="space-y-3">
                            <h4 class="font-medium text-gray-900">Paramètres</h4>
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="text-left p-2 font-medium text-gray-900">Paramètre</th>
                                            <th class="text-left p-2 font-medium text-gray-900">Type</th>
                                            <th class="text-left p-2 font-medium text-gray-900">Requis</th>
                                            <th class="text-left p-2 font-medium text-gray-900">Description</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y">
                                        <tr>
                                            <td class="p-2 font-mono text-blue-600">email</td>
                                            <td class="p-2 text-gray-600">string</td>
                                            <td class="p-2"><span
                                                    class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs">Oui</span>
                                            </td>
                                            <td class="p-2 text-gray-600">Email pour lequel générer le code</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="space-y-3">
                                <h4 class="font-medium text-gray-900">Exemple de Requête</h4>
                                <div class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto">
                                    <pre><code>curl -X POST {{ url('/api/send-verification-code') }} \
  -H "Authorization: Bearer YOUR_API_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com"
  }'</code></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Error Codes -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">⚠️ Codes d'Erreur</h2>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="text-left p-3 font-medium text-gray-900">Code</th>
                                <th class="text-left p-3 font-medium text-gray-900">Description</th>
                                <th class="text-left p-3 font-medium text-gray-900">Solution</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr>
                                <td class="p-3 font-mono text-red-600">401</td>
                                <td class="p-3 text-gray-600">Token API invalide ou manquant</td>
                                <td class="p-3 text-gray-600">Vérifiez votre token d'authentification</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-mono text-red-600">422</td>
                                <td class="p-3 text-gray-600">Paramètres de requête invalides</td>
                                <td class="p-3 text-gray-600">Vérifiez les paramètres requis</td>
                            </tr>
                            <tr>
                                <td class="p-3 font-mono text-red-600">500</td>
                                <td class="p-3 text-gray-600">Erreur serveur SMTP</td>
                                <td class="p-3 text-gray-600">Vérifiez votre configuration email</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SDK Examples -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">💻 Exemples SDK</h2>
            </div>
            <div class="p-6">
                <div class="space-y-6">

                    <!-- JavaScript Example -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">JavaScript</h3>
                        <div class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto">
                            <pre><code>// Envoyer un email
const response = await fetch('{{ url('/api/send-email') }}', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer YOUR_API_TOKEN',
    'Content-Type': 'application/json'
  },
  body: JSON.stringify({
    to: 'destinataire@example.com',
    subject: 'Mon Sujet',
    message: 'Mon message HTML ou texte',
    from_name: 'Mon App'
  })
});

const result = await response.json();
console.log(result);</code></pre>
                        </div>
                    </div>

                    <!-- PHP Example -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">PHP</h3>
                        <div class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto">
                            <pre><code>&lt;?php

$data = [
    'to' =&gt; 'destinataire@example.com',
    'subject' =&gt; 'Mon Sujet',
    'message' =&gt; 'Mon message HTML ou texte',
    'from_name' =&gt; 'Mon App'
];

$ch = curl_init('https://votre-domaine.com/api/send-email');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer YOUR_API_TOKEN',
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
print_r($result);</code></pre>
                        </div>
                    </div>

                    <!-- Python Example -->
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Python</h3>
                        <div class="bg-gray-900 text-gray-100 rounded-lg p-4 overflow-x-auto">
                            <pre><code>import requests

url = 'https://votre-domaine.com/api/send-email'
headers = {
    'Authorization': 'Bearer YOUR_API_TOKEN',
    'Content-Type': 'application/json'
}
data = {
    'to': 'destinataire@example.com',
    'subject': 'Mon Sujet',
    'message': 'Mon message HTML ou texte',
    'from_name': 'Mon App'
}

response = requests.post(url, json=data, headers=headers)
result = response.json()
print(result)</code></pre>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showNotification('Token copié dans le presse-papiers!', 'success');
            }).catch(function() {
                showNotification('Erreur lors de la copie', 'error');
            });
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
        type === 'success'
            ? 'bg-green-50 border border-green-200 text-green-800'
            : 'bg-red-50 border border-red-200 text-red-800'
    }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
@endsection
