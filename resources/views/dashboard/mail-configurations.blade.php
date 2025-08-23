@extends('layouts.app')

@section('title', 'Configurations Email')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- En-tête principal -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 mb-3">Configurations Email</h1>
                    <p class="text-lg text-gray-600">Gérez vos différentes configurations d'envoi d'email</p>
                </div>
                <button onclick="openCreateModal()"
                    class="inline-flex items-center px-6 py-4 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Nouvelle Configuration
                </button>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 7.89a2 2 0 002.82 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-3xl font-bold text-gray-900" id="total-configs">0</h3>
                        <p class="text-gray-600 font-medium">Total configurations</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-3xl font-bold text-gray-900" id="active-configs">0</h3>
                        <p class="text-gray-600 font-medium">Actives</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-3xl font-bold text-gray-900" id="default-config">0</h3>
                        <p class="text-gray-600 font-medium">Par défaut</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-100 p-6 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 12H9l-4-4 6.257-2.257A6 6 0 0117 9z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-3xl font-bold text-gray-900" id="tokens-using">0</h3>
                        <p class="text-gray-600 font-medium">Tokens utilisant</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div id="notifications" class="space-y-4"></div>

        <!-- Liste des configurations -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="p-8 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Mes Configurations</h2>
                        <p class="text-gray-600 mt-1" id="config-count">0 configuration(s) créée(s)</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <button onclick="refreshConfigurations()"
                            class="px-4 py-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div id="configurations-list" class="space-y-6">
                    <!-- Les configurations seront chargées ici par JavaScript -->
                </div>

                <!-- État de chargement -->
                <div id="loading" class="text-center py-16">
                    <div
                        class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 animate-pulse">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 7.89a2 2 0 002.82 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-600">Chargement des configurations...</p>
                </div>

                <!-- État vide -->
                <div id="empty-state" class="text-center py-16 hidden">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M3 8l7.89 7.89a2 2 0 002.82 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-3">Aucune configuration</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Créez votre première configuration email pour commencer à envoyer des emails avec différentes
                        adresses d'expéditeur.
                    </p>
                    <button onclick="openCreateModal()"
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

    <!-- Modal de création/édition -->
    <div id="configModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="bg-gradient-to-r from-green-600 to-green-700 p-6 rounded-t-2xl">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 id="modal-title" class="text-xl font-bold text-white">Nouvelle Configuration Email</h3>
                            <p class="text-green-100 text-sm mt-1">Configurez votre serveur SMTP</p>
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
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-3">
                                Nom de la configuration
                            </label>
                            <input type="text" id="name" name="name" required
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
                                    <option value="tls">TLS</option>
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

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div>
                            <button type="button" id="test-btn" onclick="testConfiguration()"
                                class="hidden px-4 py-2 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-lg font-medium transition-colors">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Test
                            </button>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="closeConfigModal()"
                                class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors">
                                Annuler
                            </button>
                            <button type="submit"
                                class="px-8 py-3 bg-green-600 hover:bg-green-700 text-white rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl">
                                <span id="submit-text">Créer la configuration</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de test -->
    <div id="testModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900">Test de configuration</h3>
                    <p class="text-gray-600 text-sm mt-1">Envoyez un email de test</p>
                </div>

                <form id="testForm" class="p-6 space-y-4">
                    <div>
                        <label for="test_email" class="block text-sm font-semibold text-gray-700 mb-3">
                            Email de test
                        </label>
                        <input type="email" id="test_email" name="test_email" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 transition-all"
                            placeholder="test@example.com">
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" onclick="closeTestModal()"
                            class="px-6 py-3 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium transition-colors">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-colors">
                            Envoyer le test
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let configurations = [];
        let editingConfigId = null;
        let testingConfigId = null;

        // Charger les configurations au démarrage
        document.addEventListener('DOMContentLoaded', function() {
            loadConfigurations();

            // Gestion du changement de type de serveur
            document.getElementById('mailer').addEventListener('change', function() {
                const smtpFields = document.getElementById('smtp-fields');
                if (this.value === 'smtp') {
                    smtpFields.style.display = 'grid';
                    // Rendre les champs SMTP requis
                    ['host', 'port', 'username', 'password'].forEach(field => {
                        document.getElementById(field).required = true;
                    });
                } else {
                    smtpFields.style.display = 'none';
                    // Enlever le requis des champs SMTP
                    ['host', 'port', 'username', 'password'].forEach(field => {
                        document.getElementById(field).required = false;
                    });
                }
            });
        });

        // Charger les configurations
        async function loadConfigurations() {
            try {
                const response = await fetch('/api/mail-configurations', {
                    headers: {
                        'Authorization': 'Bearer {{ $tokens->first()->token ?? '' }}',
                        'Content-Type': 'application/json'
                    }
                });

                if (response.ok) {
                    const data = await response.json();
                    configurations = data.configurations;
                    renderConfigurations();
                    updateStatistics();
                } else {
                    showNotification('Erreur lors du chargement des configurations', 'error');
                }
            } catch (error) {
                showNotification('Erreur de connexion', 'error');
            } finally {
                document.getElementById('loading').style.display = 'none';
            }
        }

        // Afficher les configurations
        function renderConfigurations() {
            const container = document.getElementById('configurations-list');
            const emptyState = document.getElementById('empty-state');

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
                                        <p class="text-gray-600">${new Date(config.created_at).toLocaleDateString('fr-FR')}</p>
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

        // Mettre à jour les statistiques
        function updateStatistics() {
            document.getElementById('total-configs').textContent = configurations.length;
            document.getElementById('active-configs').textContent = configurations.filter(c => c.is_active).length;
            document.getElementById('default-config').textContent = configurations.filter(c => c.is_default).length;
            document.getElementById('tokens-using').textContent = configurations.reduce((total, c) => total + c
                .tokens_count, 0);
            document.getElementById('config-count').textContent = `${configurations.length} configuration(s) créée(s)`;
        }

        // Fonctions pour les modals
        function openCreateModal() {
            editingConfigId = null;
            document.getElementById('modal-title').textContent = 'Nouvelle Configuration Email';
            document.getElementById('submit-text').textContent = 'Créer la configuration';
            document.getElementById('configForm').reset();
            document.getElementById('test-btn').classList.add('hidden');
            document.getElementById('configModal').classList.remove('hidden');
            document.getElementById('name').focus();
        }

        function editConfiguration(configId) {
            const config = configurations.find(c => c.id === configId);
            if (!config) return;

            editingConfigId = configId;
            document.getElementById('modal-title').textContent = 'Modifier la Configuration';
            document.getElementById('submit-text').textContent = 'Sauvegarder';
            document.getElementById('test-btn').classList.remove('hidden');

            // Remplir le formulaire
            document.getElementById('name').value = config.name;
            document.getElementById('mailer').value = config.mailer;
            document.getElementById('host').value = config.host || '';
            document.getElementById('port').value = config.port || '';
            document.getElementById('username').value = config.username || '';
            // Le mot de passe n'est pas pré-rempli pour des raisons de sécurité
            document.getElementById('encryption').value = config.encryption || '';
            document.getElementById('from_address').value = config.from_address;
            document.getElementById('from_name').value = config.from_name;
            document.getElementById('notes').value = config.notes || '';
            document.getElementById('is_default').checked = config.is_default;

            // Déclencher l'événement change pour afficher/masquer les champs SMTP
            document.getElementById('mailer').dispatchEvent(new Event('change'));

            document.getElementById('configModal').classList.remove('hidden');
        }

        function closeConfigModal() {
            document.getElementById('configModal').classList.add('hidden');
        }

        function closeTestModal() {
            document.getElementById('testModal').classList.add('hidden');
        }

        // Soumission du formulaire
        document.getElementById('configForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            // Ajouter le checkbox is_default s'il n'est pas coché
            if (!data.is_default) {
                data.is_default = false;
            }

            try {
                const url = editingConfigId ?
                    `/api/mail-configurations/${editingConfigId}` :
                    '/api/mail-configurations';

                const method = editingConfigId ? 'PUT' : 'POST';

                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Authorization': 'Bearer {{ $tokens->first()->token ?? '' }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    showNotification(result.message, 'success');
                    closeConfigModal();
                    await loadConfigurations();
                } else {
                    showNotification(result.message || 'Erreur lors de l\'opération', 'error');
                }
            } catch (error) {
                showNotification('Erreur de connexion', 'error');
            }
        });

        // Fonctions d'action
        async function setAsDefault(configId) {
            try {
                const response = await fetch(`/api/mail-configurations/${configId}/set-default`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer {{ $tokens->first()->token ?? '' }}',
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    showNotification(result.message, 'success');
                    await loadConfigurations();
                } else {
                    showNotification(result.message || 'Erreur lors de l\'opération', 'error');
                }
            } catch (error) {
                showNotification('Erreur de connexion', 'error');
            }
        }

        function testConfiguration(configId = null) {
            testingConfigId = configId || editingConfigId;
            document.getElementById('testModal').classList.remove('hidden');
            document.getElementById('test_email').focus();
        }

        // Soumission du test
        document.getElementById('testForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = Object.fromEntries(formData.entries());

            try {
                const response = await fetch(`/api/mail-configurations/${testingConfigId}/test`, {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer {{ $tokens->first()->token ?? '' }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    showNotification(result.message, 'success');
                    closeTestModal();
                } else {
                    showNotification(result.message || 'Erreur lors du test', 'error');
                }
            } catch (error) {
                showNotification('Erreur de connexion', 'error');
            }
        });

        async function deleteConfiguration(configId) {
            if (!confirm('Êtes-vous sûr de vouloir supprimer cette configuration ?')) {
                return;
            }

            try {
                const response = await fetch(`/api/mail-configurations/${configId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': 'Bearer {{ $tokens->first()->token ?? '' }}',
                        'Content-Type': 'application/json'
                    }
                });

                const result = await response.json();

                if (response.ok) {
                    showNotification(result.message, 'success');
                    await loadConfigurations();
                } else {
                    showNotification(result.message || 'Erreur lors de la suppression', 'error');
                }
            } catch (error) {
                showNotification('Erreur de connexion', 'error');
            }
        }

        function refreshConfigurations() {
            document.getElementById('loading').style.display = 'block';
            loadConfigurations();
        }

        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `p-4 rounded-xl shadow-xl transform transition-all duration-300 ${
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

        // Fermer les modals avec Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeConfigModal();
                closeTestModal();
            }
        });

        // Fermer les modals en cliquant en dehors
        window.addEventListener('click', (e) => {
            if (e.target.id === 'configModal') closeConfigModal();
            if (e.target.id === 'testModal') closeTestModal();
        });
    </script>

@endsection
