@extends('layouts.app')

@section('title', 'Tokens API')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    
    <!-- En-tête principal -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <h1 class="text-4xl font-bold text-gray-900 mb-3">Tokens API</h1>
                <p class="text-lg text-gray-600">Gérez vos clés d'accès sécurisées pour l'API UZASHOP Email</p>
            </div>
            <button onclick="openCreateModal()" 
                class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Créer un Token
            </button>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9l-4-4 6.257-2.257A6 6 0 0117 9z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $tokens->count() }}</h3>
                    <p class="text-gray-600 font-medium">Total tokens</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    <h3 class="text-3xl font-bold text-gray-900">{{ $tokens->where('is_active', true)->count() }}</h3>
                    <p class="text-gray-600 font-medium">Actifs</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-5">
                    @php
                        $lastUsed = $tokens->where('last_used_at')->sortByDesc('last_used_at')->first();
                    @endphp
                    <h3 class="text-sm font-bold text-gray-900">
                        @if ($lastUsed && $lastUsed->last_used_at)
                            {{ $lastUsed->last_used_at->diffForHumans() }}
                        @else
                            Jamais utilisé
                        @endif
                    </h3>
                    <p class="text-gray-600 font-medium">Dernière activité</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications -->
    @if (session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 rounded-lg p-5">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <p class="ml-3 font-medium text-green-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 rounded-lg p-5">
            <div class="flex items-center">
                <svg class="h-6 w-6 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <p class="ml-3 font-medium text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <!-- Nouveau token créé -->
    @if (session('token'))
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-8">
            <div class="flex items-start">
                <div class="w-16 h-16 bg-blue-500 rounded-2xl flex items-center justify-center flex-shrink-0">
                    <svg class="h-8 w-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-6 flex-1">
                    <h3 class="text-2xl font-bold text-blue-900 mb-2">🎉 Token créé avec succès !</h3>
                    <p class="text-blue-700 mb-6 text-lg">Copiez ce token maintenant car il ne sera plus jamais affiché après cette session.</p>
                    
                    <div class="bg-white rounded-xl border-2 border-blue-300 p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <code id="session-token" class="flex-1 text-base font-mono text-gray-800 bg-gray-50 p-4 rounded-lg border select-all break-all">{{ session('token') }}</code>
                            <button onclick="copyToken('{{ session('token') }}', 'session')" id="copy-session" 
                                class="px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all duration-200 transform hover:scale-105 shadow-lg">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-xl">
                        <p class="text-amber-800 font-semibold">
                            <svg class="w-5 h-5 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Important : Sauvegardez ce token en lieu sûr !
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Liste des tokens -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="p-8 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Mes Tokens API</h2>
                    <p class="text-gray-600 mt-1">{{ $tokens->count() }} token(s) créé(s)</p>
                </div>
                @if ($tokens->count() > 0)
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-3 py-1 bg-green-100 rounded-full text-green-800 text-sm font-medium">
                            <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                            {{ $tokens->where('is_active', true)->count() }} actifs
                        </span>
                        @if ($tokens->where('is_active', false)->count() > 0)
                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 rounded-full text-gray-800 text-sm font-medium">
                                <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                                {{ $tokens->where('is_active', false)->count() }} inactifs
                            </span>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        @if ($tokens->count() > 0)
            <div class="p-8">
                <div class="space-y-6">
                    @foreach ($tokens as $token)
                        <div class="border border-gray-200 rounded-xl p-6 hover:border-blue-300 transition-all duration-200 hover:shadow-md">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9l-4-4 6.257-2.257A6 6 0 0117 9z"></path>
                                        </svg>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h4 class="text-lg font-bold text-gray-900">{{ $token->name }}</h4>
                                            @if ($token->is_active && !$token->isExpired())
                                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                                    Actif
                                                </span>
                                            @elseif($token->isExpired())
                                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                                    Expiré
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                                    Inactif
                                                </span>
                                            @endif
                                        </div>

                                        <!-- Token avec boutons -->
                                        <div class="bg-gray-50 rounded-lg p-4 mb-3">
                                            <div class="flex items-center gap-3">
                                                <code id="token-{{ $token->id }}" class="flex-1 text-sm font-mono text-gray-800">{{ $token->masked_token }}</code>
                                                
                                                <button onclick="toggleToken('{{ $token->id }}', '{{ $token->token }}', '{{ $token->masked_token }}')" 
                                                    id="toggle-{{ $token->id }}" 
                                                    class="p-2 text-gray-500 hover:text-blue-600 hover:bg-white rounded-lg transition-colors"
                                                    title="Afficher/Masquer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </button>
                                                
                                                <button onclick="copyToken('{{ $token->token }}', '{{ $token->id }}')" 
                                                    id="copy-{{ $token->id }}" 
                                                    class="p-2 text-gray-500 hover:text-green-600 hover:bg-white rounded-lg transition-colors"
                                                    title="Copier">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Informations du token -->
                                        <div class="flex items-center gap-6 text-sm text-gray-600">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                @if ($token->last_used_at)
                                                    Utilisé {{ $token->last_used_at->diffForHumans() }}
                                                @else
                                                    Jamais utilisé
                                                @endif
                                            </div>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 6l2-2m0 0l2-2m-2 2l-2 2m2-2V17"></path>
                                                </svg>
                                                Créé le {{ $token->created_at->format('d/m/Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-2">
                                    <button onclick="editToken({{ $token->id }}, '{{ $token->name }}', {{ $token->is_active ? 'true' : 'false' }})" 
                                        class="px-4 py-2 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg font-medium transition-colors">
                                        <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Modifier
                                    </button>

                                    <form method="POST" action="{{ route('dashboard.tokens.delete', $token) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce token ?')" 
                                            class="px-4 py-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg font-medium transition-colors">
                                            <svg class="w-4 h-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
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
            <!-- État vide -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9l-4-4 6.257-2.257A6 6 0 0117 9z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucun token créé</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Créez votre premier token API pour commencer à utiliser l'API UZASHOP Email. C'est rapide et sécurisé !
                </p>
                <button onclick="openCreateModal()" 
                    class="inline-flex items-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Créer mon premier token
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Modal de création -->
<div id="createModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-white">Nouveau Token API</h3>
                        <p class="text-blue-100 text-sm mt-1">Créez une nouvelle clé d'accès sécurisée</p>
                    </div>
                    <button onclick="closeCreateModal()" class="text-white/70 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <form method="POST" action="{{ route('dashboard.tokens.create') }}" class="p-6 space-y-6">
                @csrf
                
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm">
                            <p class="text-blue-800 font-medium">Information importante</p>
                            <p class="text-blue-700 mt-1">Ce token sera utilisé pour authentifier vos requêtes API. Gardez-le secret et sécurisé.</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                        Nom du token
                    </label>
                    <input type="text" id="name" name="name" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all" 
                        placeholder="Ex: Mon Application Web, API Mobile...">
                </div>

                <div>
                    <label for="expires_at" class="block text-sm font-semibold text-gray-700 mb-3">
                        Date d'expiration (optionnel)
                    </label>
                    <input type="date" id="expires_at" name="expires_at" min="{{ date('Y-m-d') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                    
                    <div class="mt-3 flex flex-wrap gap-2">
                        <button type="button" onclick="setExpiration(30)" class="px-3 py-1 text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors">30 jours</button>
                        <button type="button" onclick="setExpiration(90)" class="px-3 py-1 text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors">90 jours</button>
                        <button type="button" onclick="setExpiration(365)" class="px-3 py-1 text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors">1 an</button>
                        <button type="button" onclick="clearExpiration()" class="px-3 py-1 text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors">Permanent</button>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeCreateModal()" 
                        class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors">
                        Annuler
                    </button>
                    <button type="submit" 
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl">
                        Créer le token
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal d'édition -->
<div id="editModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg">
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold text-gray-900">Modifier le Token</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <form id="editForm" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PATCH')

                <div>
                    <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-3">Nom du token</label>
                    <input type="text" id="edit_name" name="name" required 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                </div>

                <div class="p-4 bg-gray-50 rounded-xl">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" id="edit_is_active" name="is_active" value="1" 
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 transition-colors">
                        <div class="ml-3">
                            <span class="font-medium text-gray-700">Token actif</span>
                            <p class="text-sm text-gray-500">Décochez pour désactiver temporairement ce token</p>
                        </div>
                    </label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditModal()" 
                        class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors">
                        Annuler
                    </button>
                    <button type="submit" 
                        class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-colors">
                        Sauvegarder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Fonctions pour les modals
function openCreateModal() {
    document.getElementById('createModal').classList.remove('hidden');
    document.getElementById('name').focus();
}

function closeCreateModal() {
    document.getElementById('createModal').classList.add('hidden');
}

function editToken(tokenId, name, isActive) {
    const form = document.getElementById('editForm');
    form.action = `/dashboard/tokens/${tokenId}`;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_is_active').checked = isActive;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}

// Fonctions pour les dates d'expiration
function setExpiration(days) {
    const date = new Date();
    date.setDate(date.getDate() + days);
    document.getElementById('expires_at').value = date.toISOString().split('T')[0];
}

function clearExpiration() {
    document.getElementById('expires_at').value = '';
}

// Fonctions pour les tokens
function toggleToken(tokenId, fullToken, maskedToken) {
    const tokenElement = document.getElementById(`token-${tokenId}`);
    const toggleBtn = document.getElementById(`toggle-${tokenId}`);
    
    if (tokenElement.textContent === maskedToken) {
        // Afficher le token complet
        tokenElement.textContent = fullToken;
        tokenElement.className = 'flex-1 text-sm font-mono text-green-800 break-all select-all bg-green-50 p-2 rounded';
        toggleBtn.innerHTML = `
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L12 12m3.878-3.878L21 21m-9.122-9.122L12 12"></path>
            </svg>
        `;
    } else {
        // Masquer le token
        tokenElement.textContent = maskedToken;
        tokenElement.className = 'flex-1 text-sm font-mono text-gray-800';
        toggleBtn.innerHTML = `
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            </svg>
        `;
    }
}

function copyToken(token, tokenId) {
    navigator.clipboard.writeText(token).then(() => {
        const btn = document.getElementById(`copy-${tokenId}`);
        const originalHTML = btn.innerHTML;
        
        btn.innerHTML = `
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        `;
        btn.className = 'p-2 text-green-600 bg-green-50 rounded-lg transition-colors';
        
        showNotification('Token copié dans le presse-papiers !', 'success');
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.className = 'p-2 text-gray-500 hover:text-green-600 hover:bg-white rounded-lg transition-colors';
        }, 2000);
    }).catch(() => {
        showNotification('Erreur lors de la copie', 'error');
    });
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-xl shadow-xl z-50 transform transition-all duration-300 ${
        type === 'success' 
            ? 'bg-green-50 border border-green-200 text-green-800'
            : 'bg-red-50 border border-red-200 text-red-800'
    }`;
    
    notification.innerHTML = `
        <div class="flex items-center">
            ${type === 'success' 
                ? '<svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>'
                : '<svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>'
            }
            <span class="font-medium">${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => notification.remove(), 300);
    }, 4000);
}

// Fermer les modals avec Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeCreateModal();
        closeEditModal();
    }
});

// Fermer les modals en cliquant en dehors
window.addEventListener('click', (e) => {
    if (e.target.id === 'createModal') closeCreateModal();
    if (e.target.id === 'editModal') closeEditModal();
});
</script>

@endsection
