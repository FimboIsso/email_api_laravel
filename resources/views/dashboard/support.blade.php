@extends('layouts.app')

@section('title', 'Support')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Centre d'Aide</h1>
                <p class="mt-2 text-sm text-gray-700">Trouvez des réponses à vos questions ou contactez notre support</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">FAQ</h3>
                        <p class="text-sm text-gray-600">Questions fréquemment posées</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Guides</h3>
                        <p class="text-sm text-gray-600">Documentation détaillée</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-gray-900">Contact</h3>
                        <p class="text-sm text-gray-600">Parlez à notre équipe</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Questions Fréquemment Posées</h2>
            </div>
            <div class="p-6">
                <div class="space-y-4" x-data="{ openFaq: null }">

                    <div class="border rounded-lg">
                        <button @click="openFaq = openFaq === 1 ? null : 1"
                            class="w-full px-4 py-4 text-left flex items-center justify-between hover:bg-gray-50">
                            <span class="font-medium text-gray-900">Comment configurer mon serveur SMTP ?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                                :class="{ 'rotate-180': openFaq === 1 }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 1" x-transition class="px-4 pb-4">
                            <div class="text-gray-600 space-y-2">
                                <p>Pour configurer votre serveur SMTP :</p>
                                <ol class="list-decimal list-inside space-y-1 ml-4">
                                    <li>Allez dans "Configuration Email" depuis votre dashboard</li>
                                    <li>Sélectionnez "SMTP" comme driver</li>
                                    <li>Remplissez les informations de votre serveur SMTP</li>
                                    <li>Testez la configuration avec le bouton "Tester"</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-lg">
                        <button @click="openFaq = openFaq === 2 ? null : 2"
                            class="w-full px-4 py-4 text-left flex items-center justify-between hover:bg-gray-50">
                            <span class="font-medium text-gray-900">Comment générer un token API ?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                                :class="{ 'rotate-180': openFaq === 2 }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 2" x-transition class="px-4 pb-4">
                            <div class="text-gray-600 space-y-2">
                                <p>Vous pouvez créer plusieurs tokens API :</p>
                                <ol class="list-decimal list-inside space-y-1 ml-4">
                                    <li>Accédez à la section "Gestion des Tokens"</li>
                                    <li>Cliquez sur "Nouveau Token"</li>
                                    <li>Donnez un nom à votre token</li>
                                    <li>Définissez les permissions et la date d'expiration (optionnel)</li>
                                    <li>Copiez le token généré (il ne sera plus affiché)</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-lg">
                        <button @click="openFaq = openFaq === 3 ? null : 3"
                            class="w-full px-4 py-4 text-left flex items-center justify-between hover:bg-gray-50">
                            <span class="font-medium text-gray-900">Quels sont les formats d'email supportés ?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                                :class="{ 'rotate-180': openFaq === 3 }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 3" x-transition class="px-4 pb-4">
                            <div class="text-gray-600">
                                <p>L'API UZASHOP Email supporte :</p>
                                <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                                    <li>Emails en texte brut</li>
                                    <li>Emails HTML complets</li>
                                    <li>Templates avec variables dynamiques</li>
                                    <li>Pièces jointes (bientôt disponible)</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-lg">
                        <button @click="openFaq = openFaq === 4 ? null : 4"
                            class="w-full px-4 py-4 text-left flex items-center justify-between hover:bg-gray-50">
                            <span class="font-medium text-gray-900">Que faire si mes emails ne sont pas envoyés ?</span>
                            <svg class="w-5 h-5 text-gray-500 transform transition-transform"
                                :class="{ 'rotate-180': openFaq === 4 }" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>
                        <div x-show="openFaq === 4" x-transition class="px-4 pb-4">
                            <div class="text-gray-600">
                                <p>Vérifiez les éléments suivants :</p>
                                <ul class="list-disc list-inside space-y-1 ml-4 mt-2">
                                    <li>Votre configuration SMTP est correcte</li>
                                    <li>Votre token API est valide et actif</li>
                                    <li>Les paramètres requis sont fournis dans la requête</li>
                                    <li>Votre serveur SMTP n'a pas de limites de taux</li>
                                    <li>Consultez les logs d'erreur dans Analytics</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Contacter le Support</h2>
                <p class="text-sm text-gray-600 mt-1">Notre équipe est là pour vous aider</p>
            </div>
            <div class="p-6">
                <form class="space-y-6" id="supportForm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nom complet
                            </label>
                            <input type="text" name="name" value="{{ auth()->user()->name }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email
                            </label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Catégorie
                        </label>
                        <select name="category" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Sélectionnez une catégorie</option>
                            <option value="technical">Problème technique</option>
                            <option value="billing">Facturation</option>
                            <option value="feature">Demande de fonctionnalité</option>
                            <option value="general">Question générale</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Priorité
                        </label>
                        <div class="flex gap-4">
                            <label class="flex items-center">
                                <input type="radio" name="priority" value="low" class="mr-2 text-indigo-600">
                                <span class="text-sm text-gray-700">Faible</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="priority" value="medium" checked
                                    class="mr-2 text-indigo-600">
                                <span class="text-sm text-gray-700">Moyenne</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="priority" value="high" class="mr-2 text-indigo-600">
                                <span class="text-sm text-gray-700">Haute</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="priority" value="urgent" class="mr-2 text-indigo-600">
                                <span class="text-sm text-gray-700">Urgente</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Sujet
                        </label>
                        <input type="text" name="subject" required placeholder="Décrivez brièvement votre problème"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Description détaillée
                        </label>
                        <textarea name="description" rows="6" required
                            placeholder="Décrivez votre problème en détail. Incluez toute information pertinente..."
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            Envoyer la Demande
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Email</h3>
                <p class="text-gray-600 text-sm">support@uzashop.com</p>
                <p class="text-xs text-gray-500 mt-1">Réponse sous 24h</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Chat en Direct</h3>
                <p class="text-gray-600 text-sm">Disponible 9h-18h</p>
                <p class="text-xs text-gray-500 mt-1">Lun-Ven</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Documentation</h3>
                <p class="text-gray-600 text-sm">Guide complet</p>
                <p class="text-xs text-gray-500 mt-1">Toujours à jour</p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('supportForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Simulate form submission
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            submitBtn.innerHTML =
                '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Envoi en cours...';
            submitBtn.disabled = true;

            setTimeout(() => {
                showNotification('Votre demande a été envoyée avec succès! Nous vous répondrons sous 24h.',
                    'success');
                this.reset();
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 2000);
        });

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 max-w-md ${
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
