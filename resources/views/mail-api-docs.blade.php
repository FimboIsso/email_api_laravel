<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail API – Documentation | UZASHOP Open Source</title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="Documentation complète de l'API Mail UZASHOP - Solution open source et gratuite d'envoi d'emails professionnels avec Laravel et PHP.">
    <meta name="keywords"
        content="mail api documentation, email api, laravel, open source, api rest, smtp, php, gratuit, uzashop">
    <meta name="author" content="UZASHOP Sarlu">
    <meta name="robots" content="index, follow">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Documentation Mail API UZASHOP - Open Source">
    <meta property="og:description" content="Guide complet pour utiliser l'API Mail open source de UZASHOP">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="UZASHOP Mail API">

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
                            <div class="flex items-center space-x-2">
                                <h1 class="text-xl font-bold text-gray-800">Mail API</h1>
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
                        <a href="{{ route('auth.login') }}"
                            class="bg-white text-blue-600 font-bold py-3 px-8 rounded-full hover:bg-gray-100 transition-all duration-300 shadow-lg">
                            <i class="fas fa-rocket mr-2"></i>Commencer Gratuitement
                        </a>
                    @endauth
                    <a href="#templates"
                        class="border-2 border-white text-white font-bold py-3 px-8 rounded-full hover:bg-white hover:text-blue-600 transition-all duration-300">
                        <i class="fas fa-magic mr-2"></i>Templates
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
                        Cette API est entièrement <strong>gratuite et open source</strong>.
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
                            <p class="opacity-90">Vous êtes connecté et prêt à utiliser l'API.
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

    <!-- Dynamic Templates Section -->
    <section class="py-16 bg-gradient-to-br from-purple-50 to-pink-50" id="templates">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-magic text-purple-600 mr-3"></i>Templates Dynamiques Blade
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Envoyez des emails personnalisés avec des templates Blade directement depuis vos applications clientes.
                    Plus besoin de stocker vos templates sur le serveur !
                </p>
            </div>

            <!-- Template Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
                <div class="bg-white rounded-xl shadow-lg p-8 border border-purple-100">
                    <div class="w-16 h-16 bg-purple-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-code text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Templates à la Volée</h3>
                    <p class="text-gray-600">
                        Envoyez le contenu Blade directement dans votre requête API. Pas besoin de fichiers de templates pré-stockés.
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 border border-blue-100">
                    <div class="w-16 h-16 bg-blue-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-database text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Variables Dynamiques</h3>
                    <p class="text-gray-600">
                        Utilisez des variables Blade pour personnaliser vos emails : nom, prix, dates, listes, conditions...
                    </p>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 border border-green-100">
                    <div class="w-16 h-16 bg-green-600 rounded-lg flex items-center justify-center mb-6">
                        <i class="fas fa-palette text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">HTML Riche</h3>
                    <p class="text-gray-600">
                        Support complet HTML + CSS avec syntaxe Blade pour créer des emails visuellement attractifs.
                    </p>
                </div>
            </div>

            <!-- Template Examples -->
            <div class="bg-white rounded-xl shadow-2xl p-8 mb-12">
                <h3 class="text-2xl font-bold text-gray-800 mb-8 text-center">
                    <i class="fas fa-examples text-purple-600 mr-3"></i>Exemples de Templates
                </h3>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <!-- Example 1: Welcome Email -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-user-plus text-green-600 mr-2"></i>Email de Bienvenue
                        </h4>
                        <div class="code-block p-4 text-white text-sm overflow-x-auto">
                            <pre><code><span class="text-green-400">// Requête POST /api/send-email</span>
{
  <span class="text-blue-400">"to"</span>: <span class="text-yellow-400">"nouveau@client.com"</span>,
  <span class="text-blue-400">"subject"</span>: <span class="text-yellow-400">"Bienvenue @{{ $user_name }} !"</span>,
  <span class="text-blue-400">"template_content"</span>: <span class="text-yellow-400">"&lt;div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px;'&gt;
    &lt;h1 style='text-align: center; margin-bottom: 30px;'&gt;Bienvenue @{{ $user_name }} ! 🎉&lt;/h1&gt;
    &lt;p style='font-size: 16px; line-height: 1.6; margin-bottom: 20px;'&gt;
        Nous sommes ravis de vous accueillir sur @{{ $platform_name }} !
    &lt;/p&gt;
    &lt;div style='background: rgba(255,255,255,0.1); padding: 20px; border-radius: 8px; margin: 20px 0;'&gt;
        &lt;h3&gt;Vos informations :&lt;/h3&gt;
        &lt;ul&gt;
            &lt;li&gt;Email : @{{ $user_email }}&lt;/li&gt;
            &lt;li&gt;Date d'inscription : @{{ $registration_date }}&lt;/li&gt;
            &lt;li&gt;ID utilisateur : @{{ $user_id }}&lt;/li&gt;
        &lt;/ul&gt;
    &lt;/div&gt;
    &lt;div style='text-align: center; margin-top: 30px;'&gt;
        &lt;a href='@{{ $dashboard_url }}' style='background: #fff; color: #667eea; padding: 15px 30px; text-decoration: none; border-radius: 25px; font-weight: bold; display: inline-block;'&gt;
            Accéder à mon compte
        &lt;/a&gt;
    &lt;/div&gt;
&lt;/div&gt;"</span>,
  <span class="text-blue-400">"template_data"</span>: {
    <span class="text-blue-400">"user_name"</span>: <span class="text-yellow-400">"Marie Dupont"</span>,
    <span class="text-blue-400">"platform_name"</span>: <span class="text-yellow-400">"MonApp.com"</span>,
    <span class="text-blue-400">"user_email"</span>: <span class="text-yellow-400">"marie@example.com"</span>,
    <span class="text-blue-400">"registration_date"</span>: <span class="text-yellow-400">"19/01/2025"</span>,
    <span class="text-blue-400">"user_id"</span>: <span class="text-yellow-400">"USR-12345"</span>,
    <span class="text-blue-400">"dashboard_url"</span>: <span class="text-yellow-400">"https://monapp.com/dashboard"</span>
  }
}</code></pre>
                        </div>
                    </div>

                    <!-- Example 2: Invoice Email -->
                    <div>
                        <h4 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-receipt text-blue-600 mr-2"></i>Facture Dynamique
                        </h4>
                        <div class="code-block p-4 text-white text-sm overflow-x-auto">
                            <pre><code><span class="text-green-400">// Template avec boucles et calculs</span>
{
  <span class="text-blue-400">"template_content"</span>: <span class="text-yellow-400">"&lt;div style='font-family: Arial, sans-serif; max-width: 700px; margin: 0 auto; padding: 20px; border: 1px solid #ddd;'&gt;
    &lt;div style='text-align: center; margin-bottom: 30px;'&gt;
        &lt;h1 style='color: #2563eb;'&gt;@{{ $company_name }}&lt;/h1&gt;
        &lt;p&gt;@{{ $company_address }}&lt;/p&gt;
    &lt;/div&gt;
    
    &lt;h2 style='color: #1f2937; border-bottom: 2px solid #2563eb; padding-bottom: 10px;'&gt;
        Facture #@{{ $invoice_number }}
    &lt;/h2&gt;
    
    &lt;div style='margin: 20px 0;'&gt;
        &lt;p&gt;&lt;strong&gt;Date :&lt;/strong&gt; @{{ $invoice_date }}&lt;/p&gt;
        &lt;p&gt;&lt;strong&gt;Client :&lt;/strong&gt; @{{ $client_name }}&lt;/p&gt;
        &lt;p&gt;&lt;strong&gt;Email :&lt;/strong&gt; @{{ $client_email }}&lt;/p&gt;
    &lt;/div&gt;
    
    &lt;table style='width: 100%; border-collapse: collapse; margin: 20px 0;'&gt;
        &lt;thead&gt;
            &lt;tr style='background-color: #f3f4f6;'&gt;
                &lt;th style='padding: 12px; border: 1px solid #ddd; text-left;'&gt;Article&lt;/th&gt;
                &lt;th style='padding: 12px; border: 1px solid #ddd; text-center;'&gt;Qté&lt;/th&gt;
                &lt;th style='padding: 12px; border: 1px solid #ddd; text-right;'&gt;Prix Unit.&lt;/th&gt;
                &lt;th style='padding: 12px; border: 1px solid #ddd; text-right;'&gt;Total&lt;/th&gt;
            &lt;/tr&gt;
        &lt;/thead&gt;
        &lt;tbody&gt;
            @@foreach($items as $item)
            &lt;tr&gt;
                &lt;td style='padding: 12px; border: 1px solid #ddd;'&gt;@{{ $item['name'] }}&lt;/td&gt;
                &lt;td style='padding: 12px; border: 1px solid #ddd; text-center;'&gt;@{{ $item['quantity'] }}&lt;/td&gt;
                &lt;td style='padding: 12px; border: 1px solid #ddd; text-right;'&gt;@{{ number_format($item['price'], 2) }}€&lt;/td&gt;
                &lt;td style='padding: 12px; border: 1px solid #ddd; text-right;'&gt;@{{ number_format($item['quantity'] * $item['price'], 2) }}€&lt;/td&gt;
            &lt;/tr&gt;
            @@endforeach
        &lt;/tbody&gt;
        &lt;tfoot&gt;
            &lt;tr style='background-color: #1f2937; color: white; font-weight: bold;'&gt;
                &lt;td colspan='3' style='padding: 12px; border: 1px solid #ddd; text-right;'&gt;TOTAL :&lt;/td&gt;
                &lt;td style='padding: 12px; border: 1px solid #ddd; text-right;'&gt;@{{ number_format($total_amount, 2) }}€&lt;/td&gt;
            &lt;/tr&gt;
        &lt;/tfoot&gt;
    &lt;/table&gt;
    
    &lt;p style='margin-top: 30px; font-size: 14px; color: #6b7280;'&gt;
        Merci pour votre confiance ! Cette facture est payable sous @{{ $payment_terms }} jours.
    &lt;/p&gt;
&lt;/div&gt;"</span>,
  <span class="text-blue-400">"template_data"</span>: {
    <span class="text-blue-400">"company_name"</span>: <span class="text-yellow-400">"UZASHOP Sarlu"</span>,
    <span class="text-blue-400">"invoice_number"</span>: <span class="text-yellow-400">"FAC-2025-001"</span>,
    <span class="text-blue-400">"invoice_date"</span>: <span class="text-yellow-400">"19/01/2025"</span>,
    <span class="text-blue-400">"items"</span>: [
      {<span class="text-blue-400">"name"</span>: <span class="text-yellow-400">"Développement API"</span>, <span class="text-blue-400">"quantity"</span>: 10, <span class="text-blue-400">"price"</span>: 150},
      {<span class="text-blue-400">"name"</span>: <span class="text-yellow-400">"Configuration serveur"</span>, <span class="text-blue-400">"quantity"</span>: 1, <span class="text-blue-400">"price"</span>: 500}
    ],
    <span class="text-blue-400">"total_amount"</span>: 2000,
    <span class="text-blue-400">"payment_terms"</span>: 30
  }
}</code></pre>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Template Syntax Guide -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-book-open text-indigo-600 mr-3"></i>Guide de Syntaxe Blade
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Syntaxes de base</h4>
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm font-semibold text-gray-600 mb-2">Variables simples :</div>
                                <code class="text-purple-600">@{{ $nom_variable }}</code>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm font-semibold text-gray-600 mb-2">Conditions :</div>
                                <code class="text-purple-600">@@if($condition) ... @@endif</code>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm font-semibold text-gray-600 mb-2">Boucles :</div>
                                <code class="text-purple-600">@@foreach($items as $item) ... @@endforeach</code>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold text-gray-700 mb-4">Fonctions utiles</h4>
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm font-semibold text-gray-600 mb-2">Formatage nombres :</div>
                                <code class="text-purple-600">@{{ number_format($price, 2) }}</code>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm font-semibold text-gray-600 mb-2">Formatage dates :</div>
                                <code class="text-purple-600">@{{ date('d/m/Y', strtotime($date)) }}</code>
                            </div>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm font-semibold text-gray-600 mb-2">Texte en majuscules :</div>
                                <code class="text-purple-600">@{{ strtoupper($text) }}</code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Call to Action -->
            <div class="text-center mt-12">
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white p-8 rounded-xl">
                    <h3 class="text-2xl font-bold mb-4">Prêt à utiliser les Templates Dynamiques ?</h3>
                    <p class="text-lg mb-6 opacity-90">
                        Consultez la documentation complète avec plus d'exemples et de cas d'usage avancés.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @auth
                            <a href="#test-api" class="bg-white text-purple-600 font-bold py-3 px-6 rounded-full hover:bg-gray-100 transition-all duration-300">
                                <i class="fas fa-play mr-2"></i>Tester avec Templates
                            </a>
                        @else
                            <a href="{{ route('auth.login') }}" class="bg-white text-purple-600 font-bold py-3 px-6 rounded-full hover:bg-gray-100 transition-all duration-300">
                                <i class="fas fa-rocket mr-2"></i>Commencer Maintenant
                            </a>
                        @endauth
                        <a href="https://github.com/FimboIsso/email_api_laravel/blob/main/TEMPLATE_GUIDE.md" target="_blank" class="border-2 border-white text-white font-bold py-3 px-6 rounded-full hover:bg-white hover:text-purple-600 transition-all duration-300">
                            <i class="fas fa-external-link-alt mr-2"></i>Guide Complet
                        </a>
                    </div>
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
                                        <input type="text" id="testSubject" required value="Test Template @{{ $user_name }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>

                                    <!-- Template Mode Toggle -->
                                    <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                                        <div class="flex items-center justify-between mb-3">
                                            <label class="text-sm font-semibold text-purple-800 flex items-center">
                                                <i class="fas fa-magic mr-2"></i>Mode Template Dynamique
                                            </label>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" id="templateMode" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                            </label>
                                        </div>
                                        <p class="text-xs text-purple-600">
                                            Activez cette option pour tester les templates Blade avec des variables dynamiques
                                        </p>
                                    </div>

                                    <!-- Regular Message (default) -->
                                    <div id="regularMessage">
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

                                    <!-- Template Content (hidden by default) -->
                                    <div id="templateContent" style="display: none;">
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    <i class="fas fa-code mr-1"></i>Template Content Blade *
                                                </label>
                                                <textarea id="testTemplateContent" rows="8"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent font-mono text-sm"><div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px;">
    <h1 style="text-align: center; margin-bottom: 30px;">Bonjour @{{ $user_name }} ! 🎉</h1>
    <p style="font-size: 16px; line-height: 1.6; margin-bottom: 20px;">
        Nous testons le template dynamique de l'<strong>API @{{ $api_name }}</strong>.
    </p>
    <div style="background: rgba(255,255,255,0.1); padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h3>Informations du test :</h3>
        <ul>
            <li>Date : @{{ $test_date }}</li>
            <li>Version API : @{{ $api_version }}</li>
            <li>Statut : @{{ $status }}</li>
        </ul>
    </div>
    @@if($show_footer)
    <div style="text-align: center; margin-top: 30px; font-size: 12px; opacity: 0.8;">
        <p>Template généré par UZASHOP Mail API</p>
    </div>
    @@endif
</div></textarea>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                                    <i class="fas fa-database mr-1"></i>Template Data (JSON) *
                                                </label>
                                                <textarea id="testTemplateData" rows="6"
                                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent font-mono text-sm">{
    "user_name": "Marie Dupont",
    "api_name": "UZASHOP Mail",
    "test_date": "19/01/2025 14:30",
    "api_version": "v1.0",
    "status": "✅ Opérationnel",
    "show_footer": true
}</textarea>
                                            </div>
                                        </div>
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
                        <li><a href="#templates" class="hover:text-white transition-colors">Templates Dynamiques</a></li>
                        <li><a href="#documentation" class="hover:text-white transition-colors">Documentation</a></li>
                        <li><a href="#features" class="hover:text-white transition-colors">Fonctionnalités</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Tableau de
                                    Bord</a></li>
                        @else
                            <li><a href="{{ route('auth.login') }}"
                                    class="hover:text-white transition-colors">Commencer</a></li>
                            <li><a href="{{ route('auth.login') }}"
                                    class="hover:text-white transition-colors">Connexion</a>
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
                // Template Mode Toggle
                document.getElementById('templateMode').addEventListener('change', function() {
                    const regularMessage = document.getElementById('regularMessage');
                    const templateContent = document.getElementById('templateContent');
                    const isTemplateMode = this.checked;

                    if (isTemplateMode) {
                        regularMessage.style.display = 'none';
                        templateContent.style.display = 'block';
                    } else {
                        regularMessage.style.display = 'block';
                        templateContent.style.display = 'none';
                    }
                });

                document.getElementById('testForm').addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const sendBtn = document.getElementById('sendBtn');
                    const btnText = document.getElementById('btnText');
                    const responseDiv = document.getElementById('apiResponse');
                    const isTemplateMode = document.getElementById('templateMode').checked;

                    // Loading state
                    sendBtn.disabled = true;
                    btnText.textContent = 'Envoi en cours...';
                    sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>' + btnText.textContent;

                    responseDiv.innerHTML = `
                <div class="text-yellow-400 flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    <span>Envoi de la requête...</span>
                </div>
                <div class="text-gray-500 mt-2 text-xs">Mode: ${isTemplateMode ? 'Template Dynamique' : 'Message Standard'} | ${new Date().toLocaleString()}</div>
            `;

                    // Build request data
                    const data = {
                        to: document.getElementById('testTo').value,
                        subject: document.getElementById('testSubject').value
                    };

                    if (isTemplateMode) {
                        // Template mode
                        data.template_content = document.getElementById('testTemplateContent').value;
                        try {
                            data.template_data = JSON.parse(document.getElementById('testTemplateData').value);
                        } catch (e) {
                            responseDiv.innerHTML = `
                        <div class="text-red-400 font-bold flex items-center mb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span>❌ ERREUR JSON</span>
                        </div>
                        <div class="bg-red-900 bg-opacity-20 p-3 rounded border border-red-400">
                            <div class="text-red-300">Les données du template ne sont pas au format JSON valide :</div>
                            <div class="text-gray-400 text-xs mt-2">${e.message}</div>
                        </div>
                    `;
                            // Reset button
                            sendBtn.disabled = false;
                            btnText.textContent = 'Envoyer l\'Email de Test';
                            sendBtn.innerHTML = '<i class="fas fa-paper-plane mr-2"></i>' + btnText.textContent;
                            return;
                        }
                    } else {
                        // Standard mode
                        data.message = document.getElementById('testMessage').value;
                    }

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
                        <div class="text-gray-300 text-xs mb-3">Temps de réponse: ${duration}ms | Mode: ${isTemplateMode ? 'Template Dynamique' : 'Message Standard'} | ${new Date().toLocaleString()}</div>
                        <div class="bg-green-900 bg-opacity-20 p-3 rounded border border-green-400">
                            <pre class="text-green-300 text-xs overflow-auto">${JSON.stringify(result, null, 2)}</pre>
                        </div>
                        ${isTemplateMode ? '<div class="mt-3 p-3 bg-purple-900 bg-opacity-20 rounded border border-purple-400"><div class="text-purple-300 text-xs">🎉 Template Blade compilé avec succès !</div></div>' : ''}
                    `;
                        } else {
                            responseDiv.innerHTML = `
                        <div class="text-red-400 font-bold flex items-center mb-3">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            <span>❌ ERREUR (${response.status})</span>
                        </div>
                        <div class="text-gray-300 text-xs mb-3">Temps de réponse: ${duration}ms | Mode: ${isTemplateMode ? 'Template Dynamique' : 'Message Standard'} | ${new Date().toLocaleString()}</div>
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
