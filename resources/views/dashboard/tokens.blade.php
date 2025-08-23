@extends('layouts.app')

@section('title', 'Gestion des Tokens API')

@section('content')
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Gestion des Tokens API</h1>
                <p class="mt-2 text-sm text-gray-700">Créez et gérez vos clés d'accès sécurisées pour l'API UZASHOP</p>
            </div>
            <button onclick="toggleCreateModal()"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg border border-transparent shadow-sm transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nouveau Token
            </button>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-gray-900">{{ $tokens->count() }}</p>
                        <p class="text-sm text-gray-600">Total des tokens</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-gray-900">{{ $tokens->where('is_active', true)->count() }}</p>
                        <p class="text-sm text-gray-600">Tokens actifs</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-50 to-yellow-50 border border-orange-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        @php
                            $lastUsed = $tokens->where('last_used_at')->sortByDesc('last_used_at')->first();
                        @endphp
                        <p class="text-xs font-bold text-gray-900">
                            @if ($lastUsed && $lastUsed->last_used_at)
                                {{ $lastUsed->last_used_at->diffForHumans() }}
                            @else
                                Jamais utilisé
                            @endif
                        </p>
                        <p class="text-sm text-gray-600">Dernière activité</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-2xl font-bold text-gray-900">{{ $tokens->where('is_active', false)->count() }}</p>
                        <p class="text-sm text-gray-600">Tokens inactifs</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Messages de notification -->
        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
                <div class="flex">
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
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                <div class="flex">
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
            </div>
        @endif

        @if (session('token'))
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="text-lg font-semibold text-blue-900 mb-2">Token créé avec succès !</h4>
                        <p class="text-sm text-blue-700 mb-4">Votre token API est maintenant prêt à être utilisé. Copiez-le dans un endroit sûr.</p>
                        <div class="bg-white p-4 rounded-lg border border-blue-200 flex items-center justify-between">
                            <code class="text-sm text-gray-900 font-mono break-all flex-1 mr-3">{{ session('token') }}</code>
                            <button onclick="copyToClipboard('{{ session('token') }}')"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition-colors font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Copier
                            </button>
                        </div>
                        <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-xs text-yellow-700 font-medium">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Important : Ce token ne sera plus affiché après cette session. Copiez-le maintenant !
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Liste des tokens -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
            <!-- Header du tableau -->
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Vos Tokens API</h3>
                            <p class="text-sm text-gray-500">{{ $tokens->count() }} token(s) au total</p>
                        </div>
                    </div>

                    @if ($tokens->count() > 0)
                        <div class="flex items-center space-x-2">
                            <div
                                class="flex items-center px-3 py-1 bg-green-100 rounded-full text-green-800 text-xs font-medium">
                                <div class="w-1.5 h-1.5 bg-green-400 rounded-full mr-2"></div>
                                {{ $tokens->where('is_active', true)->count() }} actifs
                            </div>
                            @if ($tokens->where('is_active', false)->count() > 0)
                                <div
                                    class="flex items-center px-3 py-1 bg-gray-100 rounded-full text-gray-800 text-xs font-medium">
                                    <div class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-2"></div>
                                    {{ $tokens->where('is_active', false)->count() }} inactifs
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            @if ($tokens->count() > 0)
                <!-- Tokens sous forme de cartes modernes -->
                <div class="p-6">
                    <div class="grid gap-4">
                        @foreach ($tokens as $token)
                            <div
                                class="group bg-gradient-to-r from-white to-gray-50 rounded-xl border border-gray-200 p-6 hover:shadow-lg hover:border-indigo-200 transition-all duration-300">
                                <div class="flex items-start justify-between">
                                    <!-- Informations du token -->
                                    <div class="flex items-start space-x-4 flex-1">
                                        <!-- Icône du token -->
                                        <div class="relative flex-shrink-0">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <!-- Badge de statut -->
                                            <div class="absolute -top-1 -right-1">
                                                @if ($token->is_active && !$token->isExpired())
                                                    <div
                                                        class="w-4 h-4 bg-green-500 border-2 border-white rounded-full animate-pulse">
                                                    </div>
                                                @elseif($token->isExpired())
                                                    <div class="w-4 h-4 bg-red-500 border-2 border-white rounded-full">
                                                    </div>
                                                @else
                                                    <div class="w-4 h-4 bg-gray-400 border-2 border-white rounded-full">
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Détails -->
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <h4 class="text-lg font-semibold text-gray-900 truncate">
                                                    {{ $token->name }}</h4>

                                                <!-- Statut badge -->
                                                @if ($token->is_active && !$token->isExpired())
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3"></circle>
                                                        </svg>
                                                        Actif
                                                    </span>
                                                @elseif($token->isExpired())
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3"></circle>
                                                        </svg>
                                                        Expiré
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                        <svg class="w-2 h-2 mr-1 fill-current" viewBox="0 0 8 8">
                                                            <circle cx="4" cy="4" r="3"></circle>
                                                        </svg>
                                                        Inactif
                                                    </span>
                                                @endif
                                            </div>

                                            <!-- Token masqué et métadonnées -->
                                            <div class="space-y-2">
                                                <div class="flex items-center space-x-2">
                                                    <code
                                                        class="px-3 py-1 bg-gray-100 rounded-lg font-mono text-xs">{{ $token->masked_token }}</code>
                                                    <button onclick="copyToClipboard('{{ $token->token }}')"
                                                        class="p-1 text-gray-400 hover:text-indigo-600 transition-colors"
                                                        title="Copier le token">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        @if ($token->last_used_at)
                                                            Utilisé {{ $token->last_used_at->diffForHumans() }}
                                                        @else
                                                            Jamais utilisé
                                                        @endif
                                                    </div>

                                                    <span class="text-gray-400">•</span>

                                                    <div class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M8 7V3a4 4 0 118 0v4m-4 6l2-2m0 0l2-2m-2 2l-2 2m2-2V17">
                                                            </path>
                                                        </svg>
                                                        Créé le {{ $token->created_at->format('d/m/Y à H:i') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2 flex-shrink-0">
                                        <button
                                            onclick="editToken({{ $token->id }}, '{{ $token->name }}', {{ $token->is_active ? 'true' : 'false' }})"
                                            class="inline-flex items-center px-3 py-2 border border-indigo-200 text-indigo-600 bg-indigo-50 rounded-lg hover:bg-indigo-100 hover:border-indigo-300 transition-all duration-200 text-sm font-medium group/edit">
                                            <svg class="w-4 h-4 mr-1 group-hover/edit:rotate-12 transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                            Modifier
                                        </button>

                                        <form method="POST" action="{{ route('dashboard.tokens.delete', $token) }}"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce token ? Cette action est irréversible.')"
                                                class="inline-flex items-center px-3 py-2 border border-red-200 text-red-600 bg-red-50 rounded-lg hover:bg-red-100 hover:border-red-300 transition-all duration-200 text-sm font-medium group/delete">
                                                <svg class="w-4 h-4 mr-1 group-hover/delete:scale-110 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- État vide avec design moderne -->
                <div class="text-center py-16">
                    <div
                        class="mx-auto w-24 h-24 bg-gradient-to-r from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-12 h-12 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Aucun token créé</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">Créez votre premier token API pour commencer à
                        utiliser nos services. C'est simple et rapide !</p>

                    <!-- Points clés -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 max-w-2xl mx-auto">
                        <div class="p-4 bg-blue-50 rounded-xl">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-blue-900 text-sm mb-1">Sécurisé</h4>
                            <p class="text-blue-700 text-xs">Tokens cryptés et sécurisés</p>
                        </div>

                        <div class="p-4 bg-green-50 rounded-xl">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-green-900 text-sm mb-1">Rapide</h4>
                            <p class="text-green-700 text-xs">Création instantanée</p>
                        </div>

                        <div class="p-4 bg-purple-50 rounded-xl">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                                <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <h4 class="font-medium text-purple-900 text-sm mb-1">Flexible</h4>
                            <p class="text-purple-700 text-xs">Gestion avancée</p>
                        </div>
                    </div>

                    <button onclick="toggleCreateModal()"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Créer mon premier token
                    </button>
                </div>
            @endif
        </div>
    </div>
    </div>

    <!-- Modal moderne pour créer un token -->
    <div id="createTokenModal"
        class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 w-full max-w-lg">
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                <!-- Header du modal -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Nouveau Token API</h3>
                                <p class="text-indigo-100 text-sm">Créez une nouvelle clé d'accès sécurisée</p>
                            </div>
                        </div>
                        <button onclick="toggleCreateModal()" class="text-white/70 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Corps du modal -->
                <form method="POST" action="{{ route('dashboard.tokens.create') }}" class="p-6">
                    @csrf

                    <!-- Guide de création -->
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                        <div class="flex">
                            <svg class="w-5 h-5 text-blue-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div class="text-sm">
                                <p class="text-blue-800 font-medium mb-1">À propos des tokens</p>
                                <p class="text-blue-700">Ce token sera utilisé pour authentifier vos requêtes API.
                                    Gardez-le secret et sécurisé.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Nom du token -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                            Nom du token
                        </label>
                        <input type="text" id="name" name="name" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-all duration-200 bg-gray-50 focus:bg-white"
                            placeholder="Ex: Mon Application Web, API Mobile, Site E-commerce...">
                        <p class="text-xs text-gray-500 mt-1">Choisissez un nom descriptif pour identifier facilement ce
                            token.</p>
                    </div>

                    <!-- Date d'expiration -->
                    <div class="mb-6">
                        <label for="expires_at" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3a4 4 0 118 0v4m-4 6l2-2m0 0l2-2m-2 2l-2 2m2-2V17"></path>
                            </svg>
                            Date d'expiration (optionnel)
                        </label>
                        <input type="date" id="expires_at" name="expires_at" min="{{ date('Y-m-d') }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 focus:outline-none transition-all duration-200 bg-gray-50 focus:bg-white">

                        <!-- Options prédéfinies -->
                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button" onclick="setExpiration(30)"
                                class="px-3 py-1 text-xs bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors">
                                30 jours
                            </button>
                            <button type="button" onclick="setExpiration(90)"
                                class="px-3 py-1 text-xs bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors">
                                90 jours
                            </button>
                            <button type="button" onclick="setExpiration(365)"
                                class="px-3 py-1 text-xs bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors">
                                1 an
                            </button>
                            <button type="button" onclick="document.getElementById('expires_at').value = ''"
                                class="px-3 py-1 text-xs bg-gray-100 hover:bg-indigo-100 text-gray-700 hover:text-indigo-700 rounded-lg transition-colors">
                                Pas d'expiration
                            </button>
                        </div>

                        <p class="text-xs text-gray-500 mt-2">
                            <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Laisser vide pour un token permanent
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="toggleCreateModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Créer le token
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal moderne pour modifier un token -->
    <div id="editTokenModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 w-full max-w-lg">
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">
                <!-- Header du modal -->
                <div class="bg-gradient-to-r from-orange-500 to-red-500 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Modifier le Token</h3>
                                <p class="text-orange-100 text-sm">Ajustez les paramètres de votre token</p>
                            </div>
                        </div>
                        <button onclick="toggleEditModal()" class="text-white/70 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Corps du modal -->
                <form id="editTokenForm" method="POST" class="p-6">
                    @csrf
                    @method('PATCH')

                    <!-- Warning -->
                    <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor"
                                viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <div class="text-sm">
                                <p class="text-yellow-800 font-medium mb-1">Attention</p>
                                <p class="text-yellow-700">La désactivation du token empêchera toutes les requêtes API
                                    utilisant cette clé.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Nom du token -->
                    <div class="mb-6">
                        <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <svg class="w-4 h-4 inline mr-1 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                </path>
                            </svg>
                            Nom du token
                        </label>
                        <input type="text" id="edit_name" name="name" required
                            class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm placeholder-gray-400 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 focus:outline-none transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>

                    <!-- Statut -->
                    <div class="mb-6">
                        <label
                            class="flex items-center p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors cursor-pointer">
                            <input type="checkbox" id="edit_is_active" name="is_active" value="1"
                                class="rounded border-gray-300 text-orange-600 shadow-sm focus:ring-orange-500 focus:ring-2 transition-colors">
                            <div class="ml-3">
                                <span class="text-sm font-medium text-gray-700">Token actif</span>
                                <p class="text-xs text-gray-500">Décochez pour désactiver temporairement ce token</p>
                            </div>
                        </label>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="toggleEditModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all duration-200">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 rounded-lg transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleCreateModal() {
            const modal = document.getElementById('createTokenModal');
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                document.getElementById('name').focus();
            }
        }

        function toggleEditModal() {
            const modal = document.getElementById('editTokenModal');
            modal.classList.toggle('hidden');
        }

        function editToken(tokenId, name, isActive) {
            const form = document.getElementById('editTokenForm');
            form.action = `/dashboard/tokens/${tokenId}`;

            document.getElementById('edit_name').value = name;
            document.getElementById('edit_is_active').checked = isActive;

            toggleEditModal();
        }

        function setExpiration(days) {
            const date = new Date();
            date.setDate(date.getDate() + days);
            document.getElementById('expires_at').value = date.toISOString().split('T')[0];
        }

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Créer une notification moderne
                showNotification('Token copié dans le presse-papiers! 🎉', 'success');
            }, function(err) {
                showNotification('Erreur lors de la copie', 'error');
                console.error('Erreur lors de la copie: ', err);
            });
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            const bgColor = type === 'success' ? 'bg-green-500' : 'bg-red-500';
            const icon = type === 'success' ?
                '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>' :
                '<svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>';

            notification.className =
                `fixed top-4 right-4 ${bgColor} text-white px-6 py-4 rounded-xl shadow-2xl z-50 flex items-center transform translate-x-full transition-transform duration-300 backdrop-blur-sm`;
            notification.innerHTML = `${icon}<span class="font-medium">${message}</span>`;

            document.body.appendChild(notification);

            // Animation d'entrée
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Animation de sortie et suppression
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    if (notification.parentNode) {
                        document.body.removeChild(notification);
                    }
                }, 300);
            }, 4000);
        }

        // Fermer les modals avec Escape
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const createModal = document.getElementById('createTokenModal');
                const editModal = document.getElementById('editTokenModal');

                if (!createModal.classList.contains('hidden')) {
                    toggleCreateModal();
                }
                if (!editModal.classList.contains('hidden')) {
                    toggleEditModal();
                }
            }
        });

        // Fermer les modals en cliquant en dehors
        window.onclick = function(event) {
            const createModal = document.getElementById('createTokenModal');
            const editModal = document.getElementById('editTokenModal');

            if (event.target === createModal) {
                toggleCreateModal();
            }
            if (event.target === editModal) {
                toggleEditModal();
            }
        }

        // Animation au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes de statistiques
            const statsCards = document.querySelectorAll('.group');
            statsCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Validation en temps réel du formulaire
        document.getElementById('name')?.addEventListener('input', function(e) {
            const value = e.target.value;
            if (value.length < 3) {
                e.target.classList.add('border-red-300');
                e.target.classList.remove('border-green-300');
            } else {
                e.target.classList.add('border-green-300');
                e.target.classList.remove('border-red-300');
            }
        });
    </script>

@endsection
