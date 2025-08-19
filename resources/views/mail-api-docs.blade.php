<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail API – Documentation | UZASHOP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .code-block {
            background: #1a202c;
            border-radius: 8px;
            overflow-x: auto;
        }

        .hero-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">

    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">Mail API</h1>
                            <span class="text-xs text-gray-500">by UZASHOP</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-2 text-sm text-gray-600">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <a href="{{ route('dashboard') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                            <i class="fas fa-tachometer-alt mr-2"></i>Tableau de Bord
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                                <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                            <i class="fas fa-sign-in-alt mr-1"></i>Connexion
                        </a>
                        <a href="{{ route('register') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                            <i class="fas fa-user-plus mr-2"></i>S'inscrire
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-10"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center text-white">
                <div class="hero-animation mb-8">
                    <i class="fas fa-paper-plane text-8xl opacity-20"></i>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    Mail API Documentation
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto opacity-90">
                    API REST puissante et sécurisée pour l'envoi d'emails.
                    Authentification par token, configuration personnalisée, et intégration simple.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        @if (Auth::user()->api_token)
                            <a href="#test-api"
                                class="bg-white text-blue-600 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg">
                                <i class="fas fa-play mr-2"></i>Tester l'API
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                                class="bg-white text-blue-600 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg">
                                <i class="fas fa-key mr-2"></i>Obtenir un Token
                            </a>
                        @endif
                    @else
                        <a href="{{ route('register') }}"
                            class="bg-white text-blue-600 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg">
                            <i class="fas fa-rocket mr-2"></i>Commencer Gratuitement
                        </a>
                    @endauth
                    <a href="#documentation"
                        class="border-2 border-white text-white font-bold py-3 px-8 rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300">
                        <i class="fas fa-book mr-2"></i>Documentation
                    </a>
                </div>
            </div>
        </div>

        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 text-white opacity-10">
            <i class="fas fa-envelope text-4xl"></i>
        </div>
        <div class="absolute bottom-20 right-10 text-white opacity-10">
            <i class="fas fa-server text-4xl"></i>
        </div>
    </section>

    <!-- Status Section -->
    <section class="py-12">
        <div class="container mx-auto px-4">
            @auth
                <div class="bg-gradient-to-r from-green-400 to-green-600 text-white p-6 rounded-xl shadow-lg mb-8">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-3xl mr-4"></i>
                        <div>
                            <h3 class="text-xl font-bold">Bienvenue, {{ Auth::user()->name }} !</h3>
                            <p class="opacity-90">Vous êtes connecté et prêt à utiliser l'API.
                                @if (Auth::user()->api_token)
                                    Votre token API est configuré.
                                @else
                                    <a href="{{ route('dashboard') }}" class="underline font-semibold">Générez votre token
                                        API</a> pour commencer.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white p-6 rounded-xl shadow-lg mb-8">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-3xl mr-4"></i>
                        <div>
                            <h3 class="text-xl font-bold">Authentification Requise</h3>
                            <p class="opacity-90">
                                <a href="{{ route('register') }}" class="underline font-semibold">Créez un compte
                                    gratuit</a>
                                pour obtenir votre token API et commencer à envoyer des emails via notre plateforme
                                sécurisée.
                            </p>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white" id="features">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Fonctionnalités Avancées</h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Découvrez toutes les fonctionnalités qui font de notre API la solution parfaite pour vos besoins
                    d'envoi d'emails.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="card-hover bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-xl border border-blue-200">
                    <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Authentification Sécurisée</h3>
                    <p class="text-gray-600">
                        Système de tokens API sécurisés pour protéger vos envois d'emails. Chaque utilisateur dispose de
                        son propre token unique.
                    </p>
                </div>

                <div
                    class="card-hover bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-xl border border-green-200">
                    <div class="w-16 h-16 bg-green-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-cogs text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Configuration Personnalisée</h3>
                    <p class="text-gray-600">
                        Configurez vos propres paramètres SMTP : serveur, port, authentification. Chaque utilisateur
                        contrôle ses envois.
                    </p>
                </div>

                <div
                    class="card-hover bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-xl border border-purple-200">
                    <div class="w-16 h-16 bg-purple-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-code text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">API REST Simple</h3>
                    <p class="text-gray-600">
                        Interface REST intuitive avec documentation complète. Intégration facile dans tous vos projets
                        web et mobiles.
                    </p>
                </div>

                <div class="card-hover bg-gradient-to-br from-red-50 to-red-100 p-8 rounded-xl border border-red-200">
                    <div class="w-16 h-16 bg-red-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-paperclip text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Pièces Jointes</h3>
                    <p class="text-gray-600">
                        Support complet des pièces jointes. Envoyez des fichiers jusqu'à 10MB par pièce jointe avec
                        validation automatique.
                    </p>
                </div>

                <div
                    class="card-hover bg-gradient-to-br from-yellow-50 to-yellow-100 p-8 rounded-xl border border-yellow-200">
                    <div class="w-16 h-16 bg-yellow-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">CC & BCC</h3>
                    <p class="text-gray-600">
                        Support natif des copies carbone et copies cachées. Envoyez à plusieurs destinataires en une
                        seule requête.
                    </p>
                </div>

                <div
                    class="card-hover bg-gradient-to-br from-indigo-50 to-indigo-100 p-8 rounded-xl border border-indigo-200">
                    <div class="w-16 h-16 bg-indigo-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-palette text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">HTML & Texte</h3>
                    <p class="text-gray-600">
                        Envoyez des emails riches en HTML ou en texte simple. Support complet du formatting et des
                        styles CSS inline.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- API Documentation Section -->
    <section class="py-16 bg-gray-50" id="documentation">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Documentation API</h2>
                <p class="text-xl text-gray-600">Guide complet pour intégrer notre API dans vos applications</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <!-- Endpoints -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-link text-blue-600 mr-3"></i>Endpoints Disponibles
                    </h3>

                    <div class="space-y-4">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <code class="bg-gray-100 px-3 py-1 rounded text-sm font-mono">/api/send-email</code>
                                <span
                                    class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">POST</span>
                            </div>
                            <p class="text-gray-600 text-sm">Envoyer un email avec support CC, BCC et pièces jointes
                            </p>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <code class="bg-gray-100 px-3 py-1 rounded text-sm font-mono">/api/user-info</code>
                                <span
                                    class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">GET</span>
                            </div>
                            <p class="text-gray-600 text-sm">Récupérer les informations de l'utilisateur authentifié
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Authentication -->
                <div class="bg-white rounded-xl shadow-lg p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-key text-green-600 mr-3"></i>Authentification
                    </h3>

                    <div class="space-y-4">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Token API requis</h4>
                            <p class="text-gray-600 text-sm mb-3">
                                Toutes les requêtes API nécessitent un token d'authentification valide.
                                @auth
                                    Gérez vos tokens depuis votre <a href="{{ route('dashboard') }}"
                                        class="text-blue-600 underline">tableau de bord</a>.
                                @else
                                    <a href="{{ route('register') }}" class="text-blue-600 underline">Créez un compte</a>
                                    pour obtenir vos tokens.
                                @endauth
                            </p>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Headers d'authentification :</h4>
                            <div class="code-block p-3 text-white text-sm">
                                <div class="text-green-400">// Option 1 (Recommandée)</div>
                                <div>Authorization: Bearer YOUR_API_TOKEN</div>
                                <br>
                                <div class="text-green-400">// Option 2</div>
                                <div>X-API-Token: YOUR_API_TOKEN</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Code Examples Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Exemples de Code</h2>
                <p class="text-xl text-gray-600">Intégrez facilement notre API dans vos applications</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <!-- cURL Example -->
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-terminal text-gray-600 mr-2"></i>Requête cURL
                    </h3>
                    <div class="code-block p-6 text-white text-sm overflow-x-auto">
                        <pre><code><span class="text-yellow-400">curl</span> <span class="text-blue-400">-X POST</span> {{ url('/api/send-email') }} \
  <span class="text-blue-400">-H</span> <span class="text-green-400">"Content-Type: application/json"</span> \
  <span class="text-blue-400">-H</span> <span class="text-green-400">"Authorization: Bearer YOUR_API_TOKEN"</span> \
  <span class="text-blue-400">-d</span> <span class="text-green-400">'{
    "to": "destinataire@example.com",
    "subject": "Test depuis UZASHOP API",
    "message": "&lt;h1&gt;Bonjour!&lt;/h1&gt;&lt;p&gt;Email via UZASHOP&lt;/p&gt;",
    "cc": ["cc@example.com"],
    "bcc": ["bcc@example.com"]
  }'</span></code></pre>
                    </div>
                </div>

                <!-- Response Example -->
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-code text-gray-600 mr-2"></i>Réponse JSON
                    </h3>
                    <div class="bg-gray-50 p-6 rounded-lg text-sm overflow-x-auto">
                        <pre><code><span class="text-green-600">// Succès</span>
{
  <span class="text-blue-600">"status"</span>: <span class="text-green-600">"success"</span>,
  <span class="text-blue-600">"message"</span>: <span class="text-green-600">"Email sent successfully"</span>,
  <span class="text-blue-600">"data"</span>: {
    <span class="text-blue-600">"to"</span>: <span class="text-green-600">"destinataire@example.com"</span>,
    <span class="text-blue-600">"subject"</span>: <span class="text-green-600">"Test depuis UZASHOP API"</span>,
    <span class="text-blue-600">"sent_at"</span>: <span class="text-green-600">"2025-08-19T06:30:45.000000Z"</span>,
    <span class="text-blue-600">"sent_by"</span>: <span class="text-green-600">"Nom utilisateur"</span>
  }
}

<span class="text-red-600">// Erreur</span>
{
  <span class="text-blue-600">"status"</span>: <span class="text-red-600">"error"</span>,
  <span class="text-blue-600">"message"</span>: <span class="text-red-600">"Token API invalide"</span>
}</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @auth
        @if (Auth::user()->api_token)
            <!-- Test API Section -->
            <section class="py-16 bg-gradient-to-r from-blue-50 to-indigo-100" id="test-api">
                <div class="container mx-auto px-4">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-gray-800 mb-4">Testeur API Interactif</h2>
                        <p class="text-xl text-gray-600">Testez votre API en temps réel directement depuis cette page</p>
                    </div>

                    <div class="bg-white rounded-xl shadow-2xl p-8">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                            <!-- Test Form -->
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                    <i class="fas fa-paper-plane text-blue-600 mr-2"></i>Formulaire de Test
                                </h3>

                                <form id="testForm" class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-at mr-1"></i>Email destinataire *
                                        </label>
                                        <input type="email" id="testTo" required
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-heading mr-1"></i>Sujet *
                                        </label>
                                        <input type="text" id="testSubject" required value="Test depuis UZASHOP API"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                                            <i class="fas fa-edit mr-1"></i>Message *
                                        </label>
                                        <textarea id="testMessage" required rows="6"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"><h1 style="color: #4F46E5;">Test Email UZASHOP</h1>
<p>Ceci est un email de test envoyé depuis l'<strong>API UZASHOP Mail</strong>.</p>
<p>✅ Votre configuration fonctionne parfaitement !</p>
<hr>
<p style="font-size: 12px; color: #666;">Envoyé via UZASHOP Mail API - <a href="https://uzashop.co">uzashop.co</a></p></textarea>
                                    </div>

                                    <button type="submit" id="sendBtn"
                                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-paper-plane mr-2"></i>
                                        <span id="btnText">Envoyer l'Email de Test</span>
                                    </button>
                                </form>
                            </div>

                            <!-- Response Display -->
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                                    <i class="fas fa-terminal text-green-600 mr-2"></i>Réponse de l'API
                                </h3>
                                <div id="apiResponse"
                                    class="bg-gray-900 text-white p-6 rounded-lg min-h-64 border font-mono text-sm overflow-auto">
                                    <div class="text-gray-400 flex items-center">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        En attente de votre test...
                                    </div>
                                </div>

                                <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                                    <h4 class="font-semibold text-blue-800 mb-2 flex items-center">
                                        <i class="fas fa-lightbulb mr-2"></i>Informations
                                    </h4>
                                    <ul class="text-sm text-blue-700 space-y-1">
                                        <li>• Token utilisé : <code
                                                class="bg-blue-200 px-1 rounded">{{ substr(Auth::user()->api_token, 0, 10) }}...</code>
                                        </li>
                                        <li>• Configuration : {{ Auth::user()->mail_mailer ?? 'log' }}</li>
                                        <li>• Expéditeur : {{ Auth::user()->mail_from_address ?? 'Non configuré' }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endauth

    <!-- About Section -->
    <section class="py-16 bg-gray-900 text-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-4xl font-bold mb-6">À propos de UZASHOP Mail API</h2>
                    <p class="text-gray-300 text-lg mb-6">
                        Cette API de mail a été développée par <strong class="text-blue-400">UZASHOP Sarlu</strong>,
                        une entreprise spécialisée dans les solutions technologiques innovantes et fiables.
                    </p>
                    <p class="text-gray-300 mb-6">
                        Notre mission est de fournir des outils simples mais puissants pour aider les développeurs
                        et les entreprises à intégrer facilement l'envoi d'emails dans leurs applications.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://uzashop.co" target="_blank"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-globe mr-2"></i>Visiter UZASHOP.co
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-gray-800 p-6 rounded-lg text-center">
                        <i class="fas fa-shield-alt text-3xl text-blue-400 mb-4"></i>
                        <h3 class="font-bold mb-2">Sécurisé</h3>
                        <p class="text-gray-400 text-sm">Authentification par token et chiffrement SSL</p>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-lg text-center">
                        <i class="fas fa-bolt text-3xl text-yellow-400 mb-4"></i>
                        <h3 class="font-bold mb-2">Rapide</h3>
                        <p class="text-gray-400 text-sm">API optimisée pour des performances maximales</p>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-lg text-center">
                        <i class="fas fa-cog text-3xl text-green-400 mb-4"></i>
                        <h3 class="font-bold mb-2">Flexible</h3>
                        <p class="text-gray-400 text-sm">Configuration SMTP personnalisée</p>
                    </div>
                    <div class="bg-gray-800 p-6 rounded-lg text-center">
                        <i class="fas fa-headset text-3xl text-purple-400 mb-4"></i>
                        <h3 class="font-bold mb-2">Support</h3>
                        <p class="text-gray-400 text-sm">Documentation complète et support technique</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center">
                            <i class="fas fa-envelope text-white text-xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">UZASHOP Mail API</h3>
                            <p class="text-gray-400 text-sm">Solution professionnelle d'envoi d'emails</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-6">
                        API REST moderne et sécurisée pour l'envoi d'emails.
                        Développée avec Laravel et conçue pour une intégration simple et efficace.
                    </p>
                    <div class="flex space-x-4">
                        <a href="https://uzashop.co" target="_blank"
                            class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-globe text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-github text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Liens Rapides</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="#documentation" class="hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">Fonctionnalités</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Tableau de
                                    Bord</a></li>
                        @else
                            <li><a href="{{ route('register') }}"
                                    class="hover:text-white transition-colors">S'inscrire</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Connexion</a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-bold mb-4">Support</h4>
                    <ul class="space-y-2 text-gray-300">
                        <li><a href="https://uzashop.co" target="_blank"
                                class="hover:text-white transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Guide d'intégration</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Statut du service</a></li>
                    </ul>
                </div>
            </div>

            <hr class="border-gray-700 my-8">

            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400 text-sm">
                    &copy; 2025 UZASHOP Sarlu. Tous droits réservés.
                </p>
                <p class="text-gray-400 text-sm mt-4 md:mt-0">
                    Propulsé par <span class="text-red-500">❤</span> Laravel & TailwindCSS
                </p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @auth
        @if (Auth::user()->api_token)
            <script>
                document.getElementById('testForm').addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const sendBtn = document.getElementById('sendBtn');
                    const btnText = document.getElementById('btnText');
                    const responseDiv = document.getElementById('apiResponse');

                    // Loading state
                    sendBtn.disabled = true;
                    btnText.textContent = 'Envoi en cours...';
                    sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>' + btnText.textContent;

                    responseDiv.innerHTML = `
                <div class="text-yellow-400 flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    <span>Envoi de la requête...</span>
                </div>
                <div class="text-gray-500 mt-2 text-xs">Timestamp: ${new Date().toLocaleString()}</div>
            `;

                    const data = {
                        to: document.getElementById('testTo').value,
                        subject: document.getElementById('testSubject').value,
                        message: document.getElementById('testMessage').value
                    };

                    try {
                        const startTime = Date.now();

                        const response = await fetch('/api/send-email', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Authorization': 'Bearer {{ Auth::user()->api_token }}',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: JSON.stringify(data)
                        });

                        const endTime = Date.now();
                        const duration = endTime - startTime;
                        const result = await response.json();

                        if (response.ok) {
                            responseDiv.innerHTML = `
                        <div class="text-green-400 font-bold flex items-center mb-3">
                            <i class="fas fa-check-circle mr-2"></i>
                            <span>✅ SUCCÈS (${response.status})</span>
                        </div>
                        <div class="text-gray-300 text-xs mb-3">Temps de réponse: ${duration}ms | ${new Date().toLocaleString()}</div>
                        <div class="bg-green-900 bg-opacity-20 p-3 rounded border border-green-400">
                            <pre class="text-green-300 text-xs overflow-auto">${JSON.stringify(result, null, 2)}</pre>
                        </div>
                    `;
                        } else {
                            responseDiv.innerHTML = `
                        <div class="text-red-400 font-bold flex items-center mb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span>❌ ERREUR (${response.status})</span>
                        </div>
                        <div class="text-gray-300 text-xs mb-3">Temps de réponse: ${duration}ms | ${new Date().toLocaleString()}</div>
                        <div class="bg-red-900 bg-opacity-20 p-3 rounded border border-red-400">
                            <pre class="text-red-300 text-xs overflow-auto">${JSON.stringify(result, null, 2)}</pre>
                        </div>
                    `;
                        }
                    } catch (error) {
                        responseDiv.innerHTML = `
                    <div class="text-red-400 font-bold flex items-center mb-3">
                        <i class="fas fa-times-circle mr-2"></i>
                        <span>❌ ERREUR DE CONNEXION</span>
                    </div>
                    <div class="text-gray-300 text-xs mb-3">${new Date().toLocaleString()}</div>
                    <div class="bg-red-900 bg-opacity-20 p-3 rounded border border-red-400">
                        <div class="text-red-300">${error.message}</div>
                        <div class="text-gray-400 text-xs mt-2">Vérifiez votre connexion internet et réessayez.</div>
                    </div>
                `;
                    } finally {
                        // Reset button
                        sendBtn.disabled = false;
                        btnText.textContent = 'Envoyer l\'Email de Test';
                        sendBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>' + btnText.textContent;
                    }
                });
            </script>
        @endif
    @endauth

    <!-- Smooth scrolling -->
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>

</html>
