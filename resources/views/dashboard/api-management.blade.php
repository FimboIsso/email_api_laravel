@extends('layouts.app')

@section('title', 'Tokens API avec Configurations')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- En-tête principal avec navigation -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-3">Gestion API Email</h1>
                    <p class="text-lg text-gray-600">Gérez vos tokens et configurations d'envoi email</p>
                </div>
                <div class="flex gap-4">
                    <button onclick="openConfigModal()"
                        class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 7.89a2 2 0 002.82 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Configuration Email
                    </button>
                    <button onclick="openTokenModal()"
                        class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9l-4-4 6.257-2.257A6 6 0 0117 9z">
                            </path>
                        </svg>
                        Nouveau Token
                    </button>
                </div>
            </div>
        </div>

        <!-- Onglets -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-8 pt-6" aria-label="Tabs">
                    <button onclick="switchTab('tokens')" id="tokens-tab"
                        class="tab-button active whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition-colors">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9l-4-4 6.257-2.257A6 6 0 0117 9z">
                            </path>
                        </svg>
                        Tokens API
                    </button>
                    <button onclick="switchTab('configurations')" id="configurations-tab"
                        class="tab-button whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm focus:outline-none transition-colors">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 7.89a2 2 0 002.82 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        Configurations Email
                    </button>
                </nav>
            </div>

            <!-- Contenu des onglets -->
            <div class="p-8">
                <!-- Onglet Tokens -->
                <div id="tokens-content" class="tab-content">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Tokens API</h2>
                            <p class="text-gray-600 mt-1" id="tokens-count">Chargement...</p>
                        </div>
                        <button onclick="refreshData()"
                            class="px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div id="tokens-list" class="space-y-6">
                        <!-- Les tokens seront chargés ici -->
                    </div>
                    <div id="tokens-empty" class="text-center py-16 hidden">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9l-4-4 6.257-2.257A6 6 0 0117 9z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucun token créé</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Créez votre premier token API pour commencer à utiliser l'API d'envoi d'email.
                        </p>
                        <button onclick="openTokenModal()"
                            class="inline-flex items-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Créer mon premier token
                        </button>
                    </div>
                </div>

                <!-- Onglet Configurations -->
                <div id="configurations-content" class="tab-content hidden">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Configurations Email</h2>
                            <p class="text-gray-600 mt-1" id="configs-count">Chargement...</p>
                        </div>
                        <button onclick="refreshData()"
                            class="px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <div id="configurations-list" class="space-y-6">
                        <!-- Les configurations seront chargées ici -->
                    </div>
                    <div id="configurations-empty" class="text-center py-16 hidden">
                        <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M3 8l7.89 7.89a2 2 0 002.82 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucune configuration</h3>
                        <p class="text-gray-600 mb-8 max-w-md mx-auto">
                            Créez votre première configuration email pour personnaliser l'expédition de vos emails.
                        </p>
                        <button onclick="openConfigModal()"
                            class="inline-flex items-center px-8 py-4 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Créer ma première configuration
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div id="notifications" class="fixed top-4 right-4 z-40 space-y-2"></div>
    </div>

    <!-- Modal Token -->
    <div id="tokenModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 id="token-modal-title" class="text-xl font-bold text-white">Nouveau Token API</h3>
                            <p class="text-blue-100 text-sm mt-1">Créez une nouvelle clé d'accès</p>
                        </div>
                        <button onclick="closeTokenModal()" class="text-white/70 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form id="tokenForm" class="p-6 space-y-6">
                    <div>
                        <label for="token_name" class="block text-sm font-semibold text-gray-700 mb-3">
                            Nom du token
                        </label>
                        <input type="text" id="token_name" name="name" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                            placeholder="Ex: Mon Application Web, API Mobile...">
                    </div>

                    <div>
                        <label for="mail_configuration_id" class="block text-sm font-semibold text-gray-700 mb-3">
                            Configuration email
                        </label>
                        <select id="mail_configuration_id" name="mail_configuration_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">
                            <option value="">Utiliser la configuration par défaut de l'utilisateur</option>
                        </select>
                        <p class="text-sm text-gray-500 mt-2">
                            Sélectionnez la configuration email à utiliser avec ce token.
                            <button type="button" onclick="openConfigModal(); closeTokenModal();"
                                class="text-blue-600 hover:text-blue-800 underline">Créer une nouvelle
                                configuration</button>
                        </p>
                    </div>

                    <div>
                        <label for="token_expires_at" class="block text-sm font-semibold text-gray-700 mb-3">
                            Date d'expiration (optionnel)
                        </label>
                        <input type="date" id="token_expires_at" name="expires_at" min="{{ date('Y-m-d') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all">

                        <div class="mt-3 flex flex-wrap gap-2">
                            <button type="button" onclick="setTokenExpiration(30)"
                                class="px-3 py-1 text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors">30
                                jours</button>
                            <button type="button" onclick="setTokenExpiration(90)"
                                class="px-3 py-1 text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors">90
                                jours</button>
                            <button type="button" onclick="setTokenExpiration(365)"
                                class="px-3 py-1 text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors">1
                                an</button>
                            <button type="button" onclick="clearTokenExpiration()"
                                class="px-3 py-1 text-xs bg-gray-100 hover:bg-blue-100 text-gray-700 hover:text-blue-700 rounded-lg transition-colors">Permanent</button>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="closeTokenModal()"
                            class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl">
                            <span id="token-submit-text">Créer le token</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Configuration -->
    <div id="configModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 id="config-modal-title" class="text-xl font-bold text-white">Nouvelle Configuration Email
                            </h3>
                            <p class="text-green-100 text-sm mt-1">Configurez votre serveur d'envoi</p>
                        </div>
                        <button onclick="closeConfigModal()" class="text-white/70 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <form id="configForm" class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="config_name" class="block text-sm font-semibold text-gray-700 mb-3">
                                Nom de la configuration
                            </label>
                            <input type="text" id="config_name" name="name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                placeholder="Ex: Gmail Personnel, Serveur Entreprise...">
                        </div>

                        <div>
                            <label for="mailer" class="block text-sm font-semibold text-gray-700 mb-3">
                                Type de serveur
                            </label>
                            <select id="mailer" name="mailer" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                                <option value="smtp">SMTP</option>
                                <option value="sendmail">Sendmail</option>
                                <option value="mailgun">Mailgun</option>
                                <option value="postmark">Postmark</option>
                                <option value="ses">Amazon SES</option>
                            </select>
                        </div>

                        <div id="smtp-fields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="host" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Serveur SMTP
                                </label>
                                <input type="text" id="host" name="host"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                    placeholder="smtp.gmail.com">
                            </div>

                            <div>
                                <label for="port" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Port
                                </label>
                                <input type="number" id="port" name="port" min="1" max="65535"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                    placeholder="587">
                            </div>

                            <div>
                                <label for="username" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Nom d'utilisateur
                                </label>
                                <input type="text" id="username" name="username"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                    placeholder="votre-email@gmail.com">
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Mot de passe
                                </label>
                                <input type="password" id="password" name="password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                    placeholder="••••••••••••">
                            </div>

                            <div>
                                <label for="encryption" class="block text-sm font-semibold text-gray-700 mb-3">
                                    Chiffrement
                                </label>
                                <select id="encryption" name="encryption"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all">
                                    <option value="">Aucun</option>
                                    <option value="tls" selected>TLS</option>
                                    <option value="ssl">SSL</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="from_address" class="block text-sm font-semibold text-gray-700 mb-3">
                                Adresse d'expédition
                            </label>
                            <input type="email" id="from_address" name="from_address" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                placeholder="noreply@mondomaine.com">
                        </div>

                        <div>
                            <label for="from_name" class="block text-sm font-semibold text-gray-700 mb-3">
                                Nom d'expédition
                            </label>
                            <input type="text" id="from_name" name="from_name" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                placeholder="Mon Application">
                        </div>

                        <div class="md:col-span-2">
                            <label for="notes" class="block text-sm font-semibold text-gray-700 mb-3">
                                Notes (optionnel)
                            </label>
                            <textarea id="notes" name="notes" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-green-500 focus:ring-2 focus:ring-green-500/20 transition-all"
                                placeholder="Notes sur cette configuration..."></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <label class="flex items-center cursor-pointer">
                                    <input type="checkbox" id="is_default" name="is_default" value="1"
                                        class="rounded border-gray-300 text-green-600 focus:ring-green-500 transition-colors">
                                    <div class="ml-3">
                                        <span class="font-medium text-gray-700">Configuration par défaut</span>
                                        <p class="text-sm text-gray-500">Utilisez cette configuration par défaut pour les
                                            nouveaux tokens</p>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="closeConfigModal()"
                            class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl">
                            <span id="config-submit-text">Créer la configuration</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let tokens = [];
        let configurations = [];
        let editingTokenId = null;
        let editingConfigId = null;
        let currentApiToken = '{{ $tokens->first()->token ?? '' }}'; // Remplace par un vrai token

        // Charger les données au démarrage
        document.addEventListener('DOMContentLoaded', function() {
            loadData();

            // Gestion du changement de type de serveur
            document.getElementById('mailer').addEventListener('change', function() {
                toggleSmtpFields();
            });

            // Initialiser l'affichage des champs SMTP
            toggleSmtpFields();
        });

        function toggleSmtpFields() {
            const mailer = document.getElementById('mailer').value;
            const smtpFields = document.getElementById('smtp-fields');
            const smtpInputs = smtpFields.querySelectorAll('input');

            if (mailer === 'smtp') {
                smtpFields.style.display = 'grid';
                ['host', 'port', 'username', 'password'].forEach(field => {
                    document.getElementById(field).required = true;
                });
            } else {
                smtpFields.style.display = 'none';
                ['host', 'port', 'username', 'password'].forEach(field => {
                    document.getElementById(field).required = false;
                });
            }
        }

        // Charger tokens et configurations
        async function loadData() {
            await Promise.all([loadTokens(), loadConfigurations()]);
        }

        async function loadTokens() {
            try {
                const response = await fetch('/api/api-tokens', {
                    headers: {
                        'Authorization': `Bearer ${currentApiToken}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    tokens = data.tokens;
                    renderTokens();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des tokens:', error);
            }
        }

        async function loadConfigurations() {
            try {
                const response = await fetch('/api/mail-configurations', {
                    headers: {
                        'Authorization': `Bearer ${currentApiToken}`,
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    configurations = data.configurations;
                    renderConfigurations();
                    updateConfigurationSelect();
                }
            } catch (error) {
                console.error('Erreur lors du chargement des configurations:', error);
            }
        }

        function renderTokens() {
            const container = document.getElementById('tokens-list');
            const emptyState = document.getElementById('tokens-empty');
            document.getElementById('tokens-count').textContent = `${tokens.length} token(s) créé(s)`;

            if (tokens.length === 0) {
                container.style.display = 'none';
                emptyState.classList.remove('hidden');
                return;
            }

            container.style.display = 'block';
            emptyState.classList.add('hidden');

            container.innerHTML = tokens.map(token => `
                <div class="border border-gray-200 rounded-xl p-6 hover:border-blue-300 transition-all duration-200 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9l-4-4 6.257-2.257A6 6 0 0117 9z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">${token.name}</h4>
                                    <p class="text-sm text-gray-500">
                                        ${token.mail_configuration ? `Configuration: ${token.mail_configuration.name}` : 'Configuration par défaut'}
                                    </p>
                                </div>
                                <div class="flex gap-2">
                                    ${token.is_active ? '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Actif</span>' : '<span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Inactif</span>'}
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="flex items-center gap-3">
                                    <code id="token-${token.id}" class="flex-1 text-sm font-mono text-gray-800">${token.masked_token}</code>
                                    <button onclick="toggleToken('${token.id}', '${token.token || ''}', '${token.masked_token}')"
                                        id="toggle-${token.id}"
                                        class="p-2 text-gray-500 hover:text-blue-600 hover:bg-white rounded-lg transition-colors"
                                        title="Afficher/Masquer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                    </button>
                                    <button onclick="copyToken('${token.id}')"
                                        id="copy-${token.id}"
                                        class="p-2 text-gray-500 hover:text-green-600 hover:bg-white rounded-lg transition-colors"
                                        title="Copier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center gap-6 text-sm text-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    ${token.last_used_at ? `Utilisé ${formatDate(token.last_used_at)}` : 'Jamais utilisé'}
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a4 4 0 118 0v4m-4 6l2-2m0 0l2-2m-2 2l-2 2m2-2V17"></path>
                                    </svg>
                                    Créé le ${formatDate(token.created_at)}
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 ml-6">
                            <button onclick="editToken(${token.id})"
                                class="px-3 py-1 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg text-sm font-medium transition-colors">
                                Modifier
                            </button>
                            <button onclick="deleteToken(${token.id})"
                                class="px-3 py-1 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg text-sm font-medium transition-colors">
                                Supprimer
                            </button>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function renderConfigurations() {
            const container = document.getElementById('configurations-list');
            const emptyState = document.getElementById('configurations-empty');
            document.getElementById('configs-count').textContent = `${configurations.length} configuration(s) créée(s)`;

            if (configurations.length === 0) {
                container.style.display = 'none';
                emptyState.classList.remove('hidden');
                return;
            }

            container.style.display = 'block';
            emptyState.classList.add('hidden');

            container.innerHTML = configurations.map(config => `
                <div class="border border-gray-200 rounded-xl p-6 hover:border-green-300 transition-all duration-200 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 7.89a2 2 0 002.82 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold text-gray-900">${config.name}</h4>
                                    <p class="text-sm text-gray-500">${config.mailer.toUpperCase()}</p>
                                </div>
                                <div class="flex gap-2">
                                    ${config.is_active ? '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Actif</span>' : '<span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">Inactif</span>'}
                                    ${config.is_default ? '<span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full">Défaut</span>' : ''}
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="font-medium text-gray-700">De:</span>
                                        <p class="text-gray-600">${config.from_name} &lt;${config.from_address}&gt;</p>
                                    </div>
                                    ${config.host ? `
                                            <div>
                                                <span class="font-medium text-gray-700">Serveur:</span>
                                                <p class="text-gray-600">${config.host}:${config.port}</p>
                                            </div>
                                            ` : ''}
                                    ${config.tokens_count ? `
                                            <div>
                                                <span class="font-medium text-gray-700">Tokens utilisant:</span>
                                                <p class="text-gray-600">${config.tokens_count}</p>
                                            </div>
                                            ` : ''}
                                    <div>
                                        <span class="font-medium text-gray-700">Créée le:</span>
                                        <p class="text-gray-600">${formatDate(config.created_at)}</p>
                                    </div>
                                </div>
                                ${config.notes ? `<p class="mt-3 text-sm text-gray-600 italic">${config.notes}</p>` : ''}
                            </div>
                        </div>

                        <div class="flex flex-col gap-2 ml-6">
                            ${!config.is_default ? `
                                    <button onclick="setAsDefault(${config.id})"
                                        class="px-3 py-1 text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-lg text-sm font-medium transition-colors">
                                        Défaut
                                    </button>
                                    ` : ''}
                            <button onclick="testConfiguration(${config.id})"
                                class="px-3 py-1 text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg text-sm font-medium transition-colors">
                                Test
                            </button>
                            <button onclick="editConfiguration(${config.id})"
                                class="px-3 py-1 text-green-600 bg-green-50 hover:bg-green-100 rounded-lg text-sm font-medium transition-colors">
                                Modifier
                            </button>
                            ${config.tokens_count === 0 ? `
                                    <button onclick="deleteConfiguration(${config.id})"
                                        class="px-3 py-1 text-red-600 bg-red-50 hover:bg-red-100 rounded-lg text-sm font-medium transition-colors">
                                        Supprimer
                                    </button>
                                    ` : ''}
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function updateConfigurationSelect() {
            const select = document.getElementById('mail_configuration_id');
            select.innerHTML = '<option value="">Utiliser la configuration par défaut de l\'utilisateur</option>';

            configurations.filter(c => c.is_active).forEach(config => {
                const option = document.createElement('option');
                option.value = config.id;
                option.textContent = `${config.name} (${config.from_address})`;
                if (config.is_default) {
                    option.textContent += ' - Par défaut';
                }
                select.appendChild(option);
            });
        }

        // Fonctions des onglets
        function switchTab(tab) {
            // Gérer les boutons d'onglets
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById(`${tab}-tab`).classList.add('active');

            // Gérer le contenu des onglets
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(`${tab}-content`).classList.remove('hidden');
        }

        // Fonctions des modals
        function openTokenModal() {
            editingTokenId = null;
            document.getElementById('token-modal-title').textContent = 'Nouveau Token API';
            document.getElementById('token-submit-text').textContent = 'Créer le token';
            document.getElementById('tokenForm').reset();
            document.getElementById('tokenModal').classList.remove('hidden');
            document.getElementById('token_name').focus();
        }

        function closeTokenModal() {
            document.getElementById('tokenModal').classList.add('hidden');
        }

        function openConfigModal() {
            editingConfigId = null;
            document.getElementById('config-modal-title').textContent = 'Nouvelle Configuration Email';
            document.getElementById('config-submit-text').textContent = 'Créer la configuration';
            document.getElementById('configForm').reset();
            toggleSmtpFields();
            document.getElementById('configModal').classList.remove('hidden');
            document.getElementById('config_name').focus();
        }

        function closeConfigModal() {
            document.getElementById('configModal').classList.add('hidden');
        }

        // Fonctions utilitaires
        function formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diff = now - date;
            const days = Math.floor(diff / (1000 * 60 * 60 * 24));

            if (days === 0) return 'aujourd\'hui';
            if (days === 1) return 'hier';
            if (days < 7) return `il y a ${days} jours`;

            return date.toLocaleDateString('fr-FR');
        }

        function setTokenExpiration(days) {
            const date = new Date();
            date.setDate(date.getDate() + days);
            document.getElementById('token_expires_at').value = date.toISOString().split('T')[0];
        }

        function clearTokenExpiration() {
            document.getElementById('token_expires_at').value = '';
        }

        function refreshData() {
            loadData();
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `p-4 rounded-xl shadow-xl transform transition-all duration-300 max-w-sm ${
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
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-auto text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            `;

            document.getElementById('notifications').appendChild(notification);

            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => notification.remove(), 300);
            }, 5000);
        }

        // Style CSS pour les onglets
        const style = document.createElement('style');
        style.textContent = `
            .tab-button {
                border-bottom-color: transparent;
                color: #6B7280;
            }
            .tab-button.active {
                border-bottom-color: #3B82F6;
                color: #3B82F6;
            }
            .tab-button:hover:not(.active) {
                color: #374151;
                border-bottom-color: #D1D5DB;
            }
        `;
        document.head.appendChild(style);
    </script>

@endsection
