<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP API – Documentation | UZASHOP Open Source</title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Documentation complète de l'API OTP UZASHOP - Solution open source et gratuite d'authentification par OTP avec Laravel et PHP.">
    <meta name="keywords"
        content="otp api documentation, authentication api, laravel, open source, api rest, otp verification, php, gratuit, uzashop">
    <meta name="author" content="UZASHOP Sarlu">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Documentation OTP API UZASHOP - Open Source">
    <meta property="og:description" content="Guide complet pour utiliser l'API OTP open source de UZASHOP">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="UZASHOP OTP API">

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
                            <i class="fas fa-shield-alt text-white text-xl"></i>
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h1 class="text-xl font-bold text-gray-800">OTP API</h1>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2 py-1 rounded-full">
                                    Open Source
                                </span>
                            </div>
                            <span class="text-xs text-gray-500">by UZASHOP • Gratuit & MIT License</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- GitHub Link -->
                    <a href="https://github.com/FimboIsso/email_api_laravel" target="_blank"
                        class="flex items-center space-x-2 text-gray-600 hover:text-gray-800 transition-colors">
                        <i class="fab fa-github text-lg"></i>
                        <span class="text-sm font-medium">GitHub</span>
                    </a>

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
                        <a href="{{ route('auth.login') }}"
                            class="text-gray-600 hover:text-blue-600 font-medium transition-colors">
                            <i class="fas fa-sign-in-alt mr-1"></i>Connexion
                        </a>
                        <a href="{{ route('auth.login') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-all duration-300">
                            <i class="fas fa-user-plus mr-2"></i>Commencer
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
                    <i class="fas fa-shield-alt text-8xl opacity-20"></i>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold mb-6">
                    OTP API Documentation
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto opacity-90">
                    API REST sécurisée pour l'authentification par OTP.
                    Génération, envoi et vérification de codes à usage unique pour vos applications.
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
                        <a href="{{ route('auth.login') }}"
                            class="bg-white text-blue-600 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg">
                            <i class="fas fa-rocket mr-2"></i>Commencer Gratuitement
                        </a>
                    @endauth
                    <a href="#examples"
                        class="border-2 border-white text-white font-bold py-3 px-8 rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300">
                        <i class="fas fa-code mr-2"></i>Exemples
                    </a>
                    <a href="#security"
                        class="border-2 border-white text-white font-bold py-3 px-8 rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300">
                        <i class="fas fa-lock mr-2"></i>Sécurité
                    </a>
                </div>
            </div>
        </div>

        <!-- Floating Elements -->
        <div class="absolute top-20 left-10 text-white opacity-10">
            <i class="fas fa-shield-alt text-4xl"></i>
        </div>
        <div class="absolute bottom-20 right-10 text-white opacity-10">
            <i class="fas fa-mobile-alt text-4xl"></i>
        </div>
    </section>

    <!-- Open Source Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-heart text-red-500 mr-3"></i>
                        Projet Open Source
                    </h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Cette API OTP est entièrement <strong>gratuite et open source</strong>.
                        Le code source est disponible sur GitHub sous licence MIT.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                    <div class="text-center p-6 bg-green-50 rounded-xl border border-green-200">
                        <i class="fas fa-code-branch text-3xl text-green-600 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">100% Gratuite</h3>
                        <p class="text-gray-600">Aucun coût caché, pas d'abonnement. Utilisez-la librement pour vos
                            projets personnels ou commerciaux.</p>
                    </div>

                    <div class="text-center p-6 bg-blue-50 rounded-xl border border-blue-200">
                        <i class="fab fa-github text-3xl text-blue-600 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Code Source Ouvert</h3>
                        <p class="text-gray-600">Consultez, modifiez et contribuez au code source disponible
                            publiquement sur GitHub.</p>
                    </div>

                    <div class="text-center p-6 bg-purple-50 rounded-xl border border-purple-200">
                        <i class="fas fa-server text-3xl text-purple-600 mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Self-Hosted</h3>
                        <p class="text-gray-600">Hébergez l'API sur vos propres serveurs. Gardez le contrôle total de
                            vos données.</p>
                    </div>
                </div>

                <div class="text-center bg-gray-50 p-8 rounded-xl border border-gray-200">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Contribuez au Projet</h3>
                    <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                        Rejoignez notre communauté de développeurs ! Signalez des bugs, proposez des améliorations,
                        ou contribuez directement au code source.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="https://github.com/FimboIsso/email_api_laravel" target="_blank"
                            class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-3 px-6 rounded-lg transition-all duration-300 inline-flex items-center">
                            <i class="fab fa-github mr-2"></i>
                            Voir sur GitHub
                        </a>
                        <a href="https://github.com/FimboIsso/email_api_laravel/issues" target="_blank"
                            class="border border-gray-300 hover:border-gray-400 text-gray-700 hover:text-gray-800 font-medium py-3 px-6 rounded-lg transition-all duration-300 inline-flex items-center">
                            <i class="fas fa-bug mr-2"></i>
                            Signaler un Bug
                        </a>
                        <a href="https://github.com/FimboIsso/email_api_laravel/fork" target="_blank"
                            class="border border-blue-300 hover:border-blue-400 text-blue-700 hover:text-blue-800 font-medium py-3 px-6 rounded-lg transition-all duration-300 inline-flex items-center">
                            <i class="fas fa-code-branch mr-2"></i>
                            Fork le Projet
                        </a>
                    </div>

                    <!-- GitHub Stats -->
                    <div class="mt-8 flex flex-wrap justify-center gap-4">
                        <img src="https://img.shields.io/github/stars/FimboIsso/email_api_laravel?style=social"
                            alt="GitHub stars" class="h-6">
                        <img src="https://img.shields.io/github/forks/FimboIsso/email_api_laravel?style=social"
                            alt="GitHub forks" class="h-6">
                        <img src="https://img.shields.io/github/issues/FimboIsso/email_api_laravel?style=social&logo=github"
                            alt="GitHub issues" class="h-6">
                    </div>
                </div>
            </div>
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
                            <p class="opacity-90">Vous êtes connecté et prêt à utiliser l'API OTP.
                                @if (Auth::user()->api_token)
                                    Votre token API est configuré.
                                @else
                                    <a href="{{ route('dashboard') }}" class="underline font-semibold">Générez votre
                                        token
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
                                <a href="{{ route('auth.login') }}" class="underline font-semibold">Créez un compte
                                    gratuit</a>
                                pour obtenir votre token API et commencer à utiliser l'authentification OTP sécurisée.
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
                    Découvrez toutes les fonctionnalités qui font de notre API OTP la solution parfaite pour
                    sécuriser vos authentifications.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div
                    class="card-hover bg-gradient-to-br from-blue-50 to-blue-100 p-8 rounded-xl border border-blue-200">
                    <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Sécurité Renforcée</h3>
                    <p class="text-gray-600">
                        Codes à usage unique avec expiration automatique, limitation des tentatives et invalidation
                        après vérification.
                    </p>
                </div>

                <div
                    class="card-hover bg-gradient-to-br from-green-50 to-green-100 p-8 rounded-xl border border-green-200">
                    <div class="w-16 h-16 bg-green-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-clock text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Expiration Flexible</h3>
                    <p class="text-gray-600">
                        Configurez la durée de validité des codes OTP de 1 à 60 minutes selon vos besoins de sécurité.
                    </p>
                </div>

                <div
                    class="card-hover bg-gradient-to-br from-purple-50 to-purple-100 p-8 rounded-xl border border-purple-200">
                    <div class="w-16 h-16 bg-purple-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-list-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Types Multiples</h3>
                    <p class="text-gray-600">
                        Support de 4 types d'OTP : vérification email, reset mot de passe, connexion et authentification
                        à deux facteurs.
                    </p>
                </div>

                <div class="card-hover bg-gradient-to-br from-red-50 to-red-100 p-8 rounded-xl border border-red-200">
                    <div class="w-16 h-16 bg-red-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-ban text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Rate Limiting</h3>
                    <p class="text-gray-600">
                        Protection contre les abus avec limitation automatique : 3 générations par minute, 2 renvois par
                        5 minutes.
                    </p>
                </div>

                <div
                    class="card-hover bg-gradient-to-br from-yellow-50 to-yellow-100 p-8 rounded-xl border border-yellow-200">
                    <div class="w-16 h-16 bg-yellow-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-envelope text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Email Personnalisé</h3>
                    <p class="text-gray-600">
                        Templates d'email adaptés au type d'OTP avec configuration SMTP personnalisée par utilisateur.
                    </p>
                </div>

                <div
                    class="card-hover bg-gradient-to-br from-indigo-50 to-indigo-100 p-8 rounded-xl border border-indigo-200">
                    <div class="w-16 h-16 bg-indigo-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Suivi & Analytics</h3>
                    <p class="text-gray-600">
                        Dashboard intégré pour suivre les tentatives d'authentification et analyser les statistiques
                        d'utilisation.
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
                <p class="text-xl text-gray-600">Guide complet pour intégrer notre API OTP dans vos applications</p>
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
                                <code class="bg-gray-100 px-3 py-1 rounded text-sm font-mono">/api/otp/generate</code>
                                <span
                                    class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">POST</span>
                            </div>
                            <p class="text-gray-600 text-sm">Génère et envoie un code OTP à l'adresse email spécifiée
                            </p>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <code class="bg-gray-100 px-3 py-1 rounded text-sm font-mono">/api/otp/verify</code>
                                <span
                                    class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">POST</span>
                            </div>
                            <p class="text-gray-600 text-sm">Vérifie la validité d'un code OTP
                            </p>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <code class="bg-gray-100 px-3 py-1 rounded text-sm font-mono">/api/otp/resend</code>
                                <span
                                    class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">POST</span>
                            </div>
                            <p class="text-gray-600 text-sm">Génère et envoie un nouveau code OTP
                            </p>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <code class="bg-gray-100 px-3 py-1 rounded text-sm font-mono">/api/otp/status</code>
                                <span
                                    class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">GET</span>
                            </div>
                            <p class="text-gray-600 text-sm">Récupère le statut de l'OTP actif pour un utilisateur
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
                                    <a href="{{ route('auth.login') }}" class="text-blue-600 underline">Créez un
                                        compte</a>
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
    <section class="py-16 bg-white" id="examples">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">Exemples de Code</h2>
                <p class="text-xl text-gray-600">Intégrez facilement notre API OTP dans vos applications</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

                <!-- cURL Example -->
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-terminal text-gray-600 mr-2"></i>Générer un OTP (cURL)
                    </h3>
                    <div class="code-block p-6 text-white text-sm overflow-x-auto">
                        <pre><code><span class="text-yellow-400">curl</span> <span class="text-blue-400">-X POST</span> {{ url('/api/otp/generate') }} \
  <span class="text-blue-400">-H</span> <span class="text-green-400">"Content-Type: application/json"</span> \
  <span class="text-blue-400">-H</span> <span class="text-green-400">"Authorization: Bearer YOUR_API_TOKEN"</span> \
  <span class="text-blue-400">-d</span> <span class="text-green-400">'{
    "email": "user@example.com",
    "type": "email_verification",
    "validity_minutes": 15,
    "identifier": "registration_step_1"
  }'</span></code></pre>
                    </div>
                </div>

                <!-- Verify Example -->
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-check-circle text-gray-600 mr-2"></i>Vérifier un OTP (cURL)
                    </h3>
                    <div class="code-block p-6 text-white text-sm overflow-x-auto">
                        <pre><code><span class="text-yellow-400">curl</span> <span class="text-blue-400">-X POST</span> {{ url('/api/otp/verify') }} \
  <span class="text-blue-400">-H</span> <span class="text-green-400">"Content-Type: application/json"</span> \
  <span class="text-blue-400">-H</span> <span class="text-green-400">"Authorization: Bearer YOUR_API_TOKEN"</span> \
  <span class="text-blue-400">-d</span> <span class="text-green-400">'{
    "email": "user@example.com",
    "code": "123456",
    "type": "email_verification"
  }'</span></code></pre>
                    </div>
                </div>

                <!-- PHP Example -->
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fab fa-php text-purple-600 mr-2"></i>Exemple PHP
                    </h3>
                    <div class="code-block p-6 text-white text-sm overflow-x-auto">
                        <pre><code><span class="text-purple-400">&lt;?php</span>

<span class="text-blue-400">$apiToken</span> = <span class="text-yellow-400">'YOUR_API_TOKEN'</span>;
<span class="text-blue-400">$apiUrl</span> = <span class="text-yellow-400">'{{ url('/api/otp/generate') }}'</span>;

<span class="text-blue-400">$data</span> = [
    <span class="text-yellow-400">'email'</span> => <span class="text-yellow-400">'user@example.com'</span>,
    <span class="text-yellow-400">'type'</span> => <span class="text-yellow-400">'password_reset'</span>,
    <span class="text-yellow-400">'validity_minutes'</span> => <span class="text-purple-400">10</span>
];

<span class="text-blue-400">$response</span> = <span class="text-blue-400">file_get_contents</span>(<span class="text-blue-400">$apiUrl</span>, <span class="text-red-400">false</span>, <span class="text-blue-400">stream_context_create</span>([
    <span class="text-yellow-400">'http'</span> => [
        <span class="text-yellow-400">'method'</span> => <span class="text-yellow-400">'POST'</span>,
        <span class="text-yellow-400">'header'</span> => [
            <span class="text-yellow-400">'Content-Type: application/json'</span>,
            <span class="text-yellow-400">'Authorization: Bearer '</span> . <span class="text-blue-400">$apiToken</span>
        ],
        <span class="text-yellow-400">'content'</span> => <span class="text-blue-400">json_encode</span>(<span class="text-blue-400">$data</span>)
    ]
]));

<span class="text-blue-400">$result</span> = <span class="text-blue-400">json_decode</span>(<span class="text-blue-400">$response</span>, <span class="text-red-400">true</span>);
<span class="text-blue-400">echo</span> <span class="text-blue-400">$result</span>[<span class="text-yellow-400">'data'</span>][<span class="text-yellow-400">'code'</span>]; <span class="text-green-400">// Code OTP généré</span></code></pre>
                    </div>
                </div>

                <!-- JavaScript Example -->
                <div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fab fa-js-square text-yellow-500 mr-2"></i>Exemple JavaScript
                    </h3>
                    <div class="code-block p-6 text-white text-sm overflow-x-auto">
                        <pre><code><span class="text-red-400">const</span> <span class="text-blue-400">apiToken</span> = <span class="text-yellow-400">'YOUR_API_TOKEN'</span>;

<span class="text-red-400">async function</span> <span class="text-blue-400">generateOtp</span>(<span class="text-blue-400">email</span>, <span class="text-blue-400">type</span> = <span class="text-yellow-400">'email_verification'</span>) {
  <span class="text-red-400">try</span> {
    <span class="text-red-400">const</span> <span class="text-blue-400">response</span> = <span class="text-red-400">await</span> <span class="text-blue-400">fetch</span>(<span class="text-yellow-400">'{{ url('/api/otp/generate') }}'</span>, {
      <span class="text-blue-400">method</span>: <span class="text-yellow-400">'POST'</span>,
      <span class="text-blue-400">headers</span>: {
        <span class="text-yellow-400">'Content-Type'</span>: <span class="text-yellow-400">'application/json'</span>,
        <span class="text-yellow-400">'Authorization'</span>: <span class="text-yellow-400">`Bearer \${apiToken}`</span>
      },
      <span class="text-blue-400">body</span>: <span class="text-blue-400">JSON</span>.<span class="text-blue-400">stringify</span>({
        <span class="text-blue-400">email</span>: <span class="text-blue-400">email</span>,
        <span class="text-blue-400">type</span>: <span class="text-blue-400">type</span>,
        <span class="text-blue-400">validity_minutes</span>: <span class="text-purple-400">15</span>
      })
    });

    <span class="text-red-400">const</span> <span class="text-blue-400">data</span> = <span class="text-red-400">await</span> <span class="text-blue-400">response</span>.<span class="text-blue-400">json</span>();
    <span class="text-blue-400">console</span>.<span class="text-blue-400">log</span>(<span class="text-yellow-400">'OTP généré:'</span>, <span class="text-blue-400">data</span>);
    <span class="text-red-400">return</span> <span class="text-blue-400">data</span>;
  } <span class="text-red-400">catch</span> (<span class="text-blue-400">error</span>) {
    <span class="text-blue-400">console</span>.<span class="text-blue-400">error</span>(<span class="text-yellow-400">'Erreur:'</span>, <span class="text-blue-400">error</span>);
  }
}

<span class="text-green-400">// Utilisation</span>
<span class="text-blue-400">generateOtp</span>(<span class="text-yellow-400">'user@example.com'</span>, <span class="text-yellow-400">'login_verification'</span>);</code></pre>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-gray-900 to-black text-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-6 flex items-center">
                        <i class="fas fa-shield-alt text-indigo-400 mr-2"></i>OTP API
                    </h3>
                    <p class="text-gray-400 mb-4">
                        Service d'authentification OTP sécurisé et fiable pour vos applications.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-github text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition-colors">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">API</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#documentation" class="hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#examples" class="hover:text-white transition-colors">Exemples</a></li>
                        <li><a href="#security" class="hover:text-white transition-colors">Sécurité</a></li>
                        <li><a href="{{ route('otp.docs') }}" class="hover:text-white transition-colors">Guide
                                complet</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Ressources</h4>
                    <ul class="space-y-2 text-gray-400">
                        @auth
                            <li><a href="{{ route('dashboard') }}"
                                    class="hover:text-white transition-colors">Dashboard</a></li>
                            <li><a href="{{ route('profile.edit') }}"
                                    class="hover:text-white transition-colors">Profil</a></li>
                        @else
                            <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Créer un
                                    compte</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Connexion</a>
                            </li>
                        @endauth
                        <li><a href="/" class="hover:text-white transition-colors">Mail API</a></li>
                        <li><a href="/support" class="hover:text-white transition-colors">Support</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-2"></i>
                            support@api-otp.com
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-2"></i>
                            +33 1 23 45 67 89
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-2"></i>
                            Paris, France
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-12 pt-8 flex flex-col md:flex-row justify-between items-center">
                <div class="text-gray-400 text-sm">
                    © 2024 OTP API. Tous droits réservés.
                </div>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="/privacy" class="text-gray-400 hover:text-white text-sm transition-colors">Politique de
                        confidentialité</a>
                    <a href="/terms" class="text-gray-400 hover:text-white text-sm transition-colors">Conditions
                        d'utilisation</a>
                    <a href="/cookies" class="text-gray-400 hover:text-white text-sm transition-colors">Cookies</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <div id="back-to-top" class="fixed bottom-8 right-8 opacity-0 pointer-events-none transition-all duration-300">
        <button onclick="scrollToTop()"
            class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>

    <style>
        .code-block {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            border-radius: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .code-block::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
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

        .feature-icon {
            transition: all 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>

    <script>
        // Navigation scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            const backToTop = document.getElementById('back-to-top');

            if (window.scrollY > 100) {
                nav.classList.add('shadow-lg');
                backToTop.classList.remove('opacity-0', 'pointer-events-none');
            } else {
                nav.classList.remove('shadow-lg');
                backToTop.classList.add('opacity-0', 'pointer-events-none');
            }
        });

        // Smooth scroll to top
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Copy code functionality
        document.addEventListener('DOMContentLoaded', function() {
            const codeBlocks = document.querySelectorAll('.code-block pre');

            codeBlocks.forEach(block => {
                const button = document.createElement('button');
                button.className =
                    'absolute top-4 right-4 bg-gray-700 hover:bg-gray-600 text-white px-3 py-1 rounded text-xs opacity-0 group-hover:opacity-100 transition-opacity';
                button.innerHTML = '<i class="fas fa-copy mr-1"></i>Copier';

                const wrapper = document.createElement('div');
                wrapper.className = 'relative group';
                block.parentNode.insertBefore(wrapper, block);
                wrapper.appendChild(block);
                wrapper.appendChild(button);

                button.addEventListener('click', () => {
                    const textArea = document.createElement('textarea');
                    textArea.value = block.textContent;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);

                    button.innerHTML = '<i class="fas fa-check mr-1"></i>Copié !';
                    button.classList.add('bg-green-600');

                    setTimeout(() => {
                        button.innerHTML = '<i class="fas fa-copy mr-1"></i>Copier';
                        button.classList.remove('bg-green-600');
                    }, 2000);
                });
            });
        });

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Parallax effect for hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallax = document.querySelector('.hero-animation');
            if (parallax) {
                const speed = scrolled * 0.5;
                parallax.style.transform = `translateY(${speed}px)`;
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = '0.1s';
                    entry.target.style.animationFillMode = 'both';
                    entry.target.style.animation = 'fadeInUp 0.6s ease-out';
                }
            });
        }, observerOptions);

        // Observe feature cards and sections
        document.querySelectorAll('.card-hover, .feature-card, section').forEach(el => {
            observer.observe(el);
        });

        // Add fadeInUp keyframes
        const style = document.createElement('style');
        style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
`;
        document.head.appendChild(style);
    </script>
</body>

</html>
