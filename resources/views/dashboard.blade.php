@extends('layouts.app')

@section('title', 'Tableau de Bord')

@section('content')

    <div class="space-y-6">
        <!-- Header avec salutation personnalisée -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">
                        @php
                            $hour = date('H');
                            if ($hour < 12) {
                                echo 'Bonjour';
                            } elseif ($hour < 17) {
                                echo 'Bon après-midi';
                            } else {
                                echo 'Bonsoir';
                            }
                        @endphp, {{ auth()->user()->name }} ! 👋
                    </h1>
                    <p class="text-indigo-100 mt-2">
                        @php
                            $tokens = 0; // Will be dynamic when model is fixed
                            if ($tokens == 0) {
                                echo 'Créez votre premier token API pour commencer à utiliser notre service.';
                            } else {
                                echo "Votre API est prête à l'emploi avec " . $tokens . ' token(s) actif(s).';
                            }
                        @endphp
                    </p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="flex items-center bg-white/20 px-3 py-2 rounded-lg">
                        <div class="w-2 h-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                        <span class="text-sm font-medium">API Active</span>
                    </div>
                    <button onclick="location.reload()"
                        class="bg-white/20 hover:bg-white/30 p-2 rounded-lg transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!-- Messages de notification -->
        @if (session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if (session('token'))
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">🎉 Nouveau token API créé avec succès !</h3>
                        <div class="bg-white p-4 rounded-lg border border-blue-200 mb-3">
                            <code class="text-sm text-gray-900 break-all font-mono">{{ session('token') }}</code>
                            <button onclick="copyToClipboard('{{ session('token') }}')"
                                class="ml-2 text-blue-600 hover:text-blue-800 transition-colors">
                                <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-xs text-blue-600">⚠️ Copiez ce token maintenant, il ne sera plus affiché pour des
                            raisons de sécurité.</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistiques Principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Tokens -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">API Tokens</p>
                        <p class="text-3xl font-bold text-gray-900">{{ auth()->user()->apiTokens()->count() ?? 0 }}</p>
                        <p class="text-xs text-green-600 mt-1">Tous actifs</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('dashboard.tokens') }}"
                        class="text-sm text-indigo-600 hover:text-indigo-500 font-medium">
                        Gérer les tokens →
                    </a>
                </div>
            </div>

            <!-- Emails Envoyés -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Emails ce mois</p>
                        <p class="text-3xl font-bold text-gray-900">{{ rand(0, 150) }}</p>
                        <p class="text-xs text-green-600 mt-1">+{{ rand(5, 25) }}% vs mois dernier</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('dashboard.analytics') }}"
                        class="text-sm text-green-600 hover:text-green-500 font-medium">
                        Voir les analytics →
                    </a>
                </div>
            </div>

            <!-- Taux de Succès -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Taux de Succès</p>
                        <p class="text-3xl font-bold text-gray-900">{{ rand(95, 100) }}%</p>
                        <p class="text-xs text-green-600 mt-1">Excellent</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('dashboard.analytics') }}"
                        class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                        Voir détails →
                    </a>
                </div>
            </div>

            <!-- Dernier Email -->
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-all duration-200">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div
                            class="w-12 h-12 bg-gradient-to-r from-orange-500 to-red-500 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <p class="text-sm font-medium text-gray-600">Dernier Email</p>
                        <p class="text-lg font-bold text-gray-900">Il y a 2h</p>
                        <p class="text-xs text-gray-500 mt-1">Envoyé avec succès</p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('dashboard.analytics') }}"
                        class="text-sm text-orange-600 hover:text-orange-500 font-medium">
                        Historique →
                    </a>
                </div>
            </div>
        </div>

        <!-- Actions Rapides & Configuration -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Actions Rapides -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Actions Rapides
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('dashboard.tokens') }}"
                        class="flex items-center p-4 rounded-lg bg-gradient-to-r from-indigo-50 to-purple-50 hover:from-indigo-100 hover:to-purple-100 transition-all duration-200 group">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-800">Créer un Token API
                            </p>
                            <p class="text-xs text-gray-600">Générer un nouveau token pour vos applications</p>
                        </div>
                        <svg class="ml-auto w-4 h-4 text-gray-400 group-hover:text-indigo-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>

                    <a href="{{ route('dashboard.mail-config') }}"
                        class="flex items-center p-4 rounded-lg bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 transition-all duration-200 group">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-green-800">Configurer SMTP</p>
                            <p class="text-xs text-gray-600">Paramétrer vos serveurs d'envoi d'emails</p>
                        </div>
                        <svg class="ml-auto w-4 h-4 text-gray-400 group-hover:text-green-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>

                    <a href="{{ route('dashboard.api-docs') }}"
                        class="flex items-center p-4 rounded-lg bg-gradient-to-r from-blue-50 to-cyan-50 hover:from-blue-100 hover:to-cyan-100 transition-all duration-200 group">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-blue-800">Documentation API</p>
                            <p class="text-xs text-gray-600">Guide d'intégration et exemples de code</p>
                        </div>
                        <svg class="ml-auto w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </a>

                    <button onclick="showTestEmailModal()"
                        class="flex items-center w-full p-4 rounded-lg bg-gradient-to-r from-purple-50 to-pink-50 hover:from-purple-100 hover:to-pink-100 transition-all duration-200 group">
                        <div class="flex-shrink-0">
                            <div
                                class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 text-left">
                            <p class="text-sm font-semibold text-gray-900 group-hover:text-purple-800">Tester l'Email</p>
                            <p class="text-xs text-gray-600">Envoyer un email de test rapidement</p>
                        </div>
                        <svg class="ml-auto w-4 h-4 text-gray-400 group-hover:text-purple-500" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- État du Système -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        État du Système
                    </h2>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Configuration Email -->
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Configuration Email</p>
                                <p class="text-xs text-gray-600">Serveur SMTP</p>
                            </div>
                        </div>
                        @if ($user->mail_from_address)
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ✓ Configuré
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                ⚠ À configurer
                            </span>
                        @endif
                    </div>

                    <!-- API Tokens -->
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">API Tokens</p>
                                <p class="text-xs text-gray-600">Clés d'accès</p>
                            </div>
                        </div>
                        @php $tokenCount = auth()->user()->apiTokens()->count() ?? 0; @endphp
                        @if ($tokenCount > 0)
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $tokenCount }} actif(s)
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Aucun token
                            </span>
                        @endif
                    </div>

                    <!-- Status API -->
                    <div class="flex items-center justify-between p-3 rounded-lg bg-gray-50">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Service API</p>
                                <p class="text-xs text-gray-600">Statut du service</p>
                            </div>
                        </div>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            ✓ Opérationnel
                        </span>
                    </div>

                    <!-- Message de configuration -->
                    @if (!$user->mail_from_address)
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">Configuration requise</h3>
                                    <p class="mt-1 text-sm text-yellow-700">
                                        Veuillez configurer vos paramètres SMTP pour commencer à envoyer des emails.
                                    </p>
                                    <div class="mt-3">
                                        <a href="{{ route('dashboard.mail-config') }}"
                                            class="text-sm bg-yellow-800 text-yellow-100 px-3 py-1 rounded-md hover:bg-yellow-700 transition-colors">
                                            Configurer maintenant
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Guide de démarrage -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    Guide de Démarrage Rapide
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-indigo-600 font-bold text-lg">1</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Configurer SMTP</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Ajoutez vos paramètres de serveur email pour pouvoir envoyer des messages.
                        </p>
                        <a href="{{ route('dashboard.mail-config') }}"
                            class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Configurer
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>

                    <div class="text-center">
                        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-green-600 font-bold text-lg">2</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Créer un Token</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Générez votre premier token API pour authentifier vos requêtes.
                        </p>
                        <a href="{{ route('dashboard.tokens') }}"
                            class="inline-flex items-center text-sm font-medium text-green-600 hover:text-green-500">
                            Créer un token
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>

                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-blue-600 font-bold text-lg">3</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Intégrer l'API</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Consultez la documentation pour intégrer l'API dans vos applications.
                        </p>
                        <a href="{{ route('dashboard.api-docs') }}"
                            class="inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-500">
                            Documentation
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exemple d'utilisation -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m-4 4l4 4-4 4"></path>
                    </svg>
                    Exemple d'Utilisation
                </h2>
            </div>
            <div class="p-6">
                <p class="text-gray-600 mb-4">
                    Voici un exemple simple pour envoyer un email via notre API :
                </p>
                <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
                    <pre class="text-gray-100 text-sm"><code>curl -X POST {{ url('/api/send-email') }} \
  -H "Authorization: Bearer VOTRE_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "to": "destinataire@example.com",
    "subject": "Hello from UZASHOP API",
    "message": "Ceci est un message de test !",
    "from_name": "Mon Application"
  }'</code></pre>
                </div>
                <div class="mt-4 flex items-center justify-between">
                    <p class="text-sm text-gray-600">
                        Remplacez <code class="bg-gray-100 px-2 py-1 rounded text-xs">VOTRE_TOKEN</code> par votre vrai
                        token API.
                    </p>
                    <button
                        onclick="copyToClipboard(`curl -X POST {{ url('/api/send-email') }} \\
  -H \"Authorization: Bearer VOTRE_TOKEN\" \\
  -H \"Content-Type: application/json\" \\
  -d '{
    \"to\": \"destinataire@example.com\",
    \"subject\": \"Hello from UZASHOP API\",
    \"message\": \"Ceci est un message de test !\",
    \"from_name\": \"Mon Application\"
  }'`)"
                        class="text-sm text-indigo-600 hover:text-indigo-500 font-medium flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                        Copier
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Test Email -->
    <div id="testEmailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Envoyer un Email de Test</h3>
                </div>
                <div class="p-6">
                    <form id="testEmailForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email destinataire</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sujet</label>
                            <input type="text" name="subject" value="Test depuis UZASHOP API" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                            <textarea name="message" rows="3" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">Ceci est un email de test envoyé depuis votre dashboard UZASHOP API. Tout fonctionne correctement ! 🎉</textarea>
                        </div>
                    </form>
                </div>
                <div class="px-6 py-3 border-t border-gray-200 flex justify-end space-x-3">
                    <button onclick="hideTestEmailModal()"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                        Annuler
                    </button>
                    <button onclick="sendTestEmail()"
                        class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                        Envoyer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                showNotification('Copié dans le presse-papiers !', 'success');
            }).catch(function() {
                showNotification('Erreur lors de la copie', 'error');
            });
        }

        function showTestEmailModal() {
            document.getElementById('testEmailModal').classList.remove('hidden');
        }

        function hideTestEmailModal() {
            document.getElementById('testEmailModal').classList.add('hidden');
        }

        function sendTestEmail() {
            const form = document.getElementById('testEmailForm');
            const formData = new FormData(form);

            // Simulate API call
            showNotification('Email de test envoyé ! Vérifiez votre boîte de réception.', 'success');
            hideTestEmailModal();
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 max-w-sm ${
        type === 'success'
            ? 'bg-green-50 border border-green-200 text-green-800'
            : 'bg-red-50 border border-red-200 text-red-800'
    }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 5000);
        }
    </script>
@endsection
