<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de Bord - UZASHOP Mail API') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if (session('token'))
                <div class="mb-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative"
                    role="alert">
                    <strong>Votre nouveau token API :</strong>
                    <code class="bg-gray-200 px-2 py-1 rounded">{{ session('token') }}</code>
                    <p class="text-sm mt-2">⚠️ Copiez ce token maintenant, il ne sera plus affiché.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Token API Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">🔐 Token API</h3>

                        @if ($user->api_token)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Votre token actuel :</p>
                                <code
                                    class="bg-gray-100 p-2 rounded text-xs break-all block">{{ substr($user->api_token, 0, 20) }}...</code>
                                <p class="text-xs text-gray-500 mt-1">Seuls les premiers caractères sont affichés</p>
                            </div>
                        @else
                            <p class="text-gray-600 mb-4">Aucun token généré. Cliquez sur le bouton ci-dessous pour en
                                créer un.</p>
                        @endif

                        <form method="POST" action="{{ route('dashboard.generate-token') }}">
                            @csrf
                            <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ $user->api_token ? 'Régénérer le Token' : 'Générer un Token' }}
                            </button>
                        </form>

                        <div class="mt-4 p-4 bg-gray-50 rounded">
                            <h4 class="font-semibold text-sm mb-2">💡 Comment utiliser votre token :</h4>
                            <p class="text-xs text-gray-600 mb-2">Ajoutez votre token dans l'en-tête de vos requêtes :
                            </p>
                            <code class="text-xs bg-gray-200 p-2 rounded block">Authorization: Bearer VOTRE_TOKEN</code>
                            <p class="text-xs text-gray-600 mt-2">ou</p>
                            <code class="text-xs bg-gray-200 p-2 rounded block">X-API-Token: VOTRE_TOKEN</code>
                        </div>
                    </div>
                </div>

                <!-- Configuration Email Section -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-semibold mb-4">📧 Configuration Email</h3>

                        <form method="POST" action="{{ route('dashboard.update-mail-config') }}">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Mailer</label>
                                <select name="mail_mailer"
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                                    <option value="smtp" {{ $user->mail_mailer === 'smtp' ? 'selected' : '' }}>SMTP
                                    </option>
                                    <option value="log" {{ $user->mail_mailer === 'log' ? 'selected' : '' }}>Log
                                        (pour test)</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Serveur SMTP</label>
                                <input type="text" name="mail_host" value="{{ $user->mail_host }}"
                                    placeholder="smtp.gmail.com"
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Port</label>
                                <input type="number" name="mail_port" value="{{ $user->mail_port }}" placeholder="587"
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nom d'utilisateur</label>
                                <input type="text" name="mail_username" value="{{ $user->mail_username }}"
                                    placeholder="votre@email.com"
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Mot de passe</label>
                                <input type="password" name="mail_password"
                                    placeholder="Laisser vide pour ne pas changer"
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Chiffrement</label>
                                <select name="mail_encryption"
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                                    <option value="">Aucun</option>
                                    <option value="tls" {{ $user->mail_encryption === 'tls' ? 'selected' : '' }}>TLS
                                    </option>
                                    <option value="ssl" {{ $user->mail_encryption === 'ssl' ? 'selected' : '' }}>SSL
                                    </option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Email d'expédition *</label>
                                <input type="email" name="mail_from_address" value="{{ $user->mail_from_address }}"
                                    required
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nom d'expédition *</label>
                                <input type="text" name="mail_from_name" value="{{ $user->mail_from_name }}"
                                    required
                                    class="w-full px-3 py-2 border rounded focus:outline-none focus:border-blue-500">
                            </div>

                            <div class="flex space-x-2">
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Sauvegarder
                                </button>
                            </div>
                        </form>

                        <form method="POST" action="{{ route('dashboard.test-mail') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                                Tester la Configuration
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Documentation API -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">📚 Documentation API</h3>

                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Endpoint principal :</h4>
                        <code class="bg-gray-100 p-2 rounded block">POST {{ url('/api/send-email') }}</code>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Headers requis :</h4>
                        <pre class="bg-gray-100 p-3 rounded text-sm overflow-x-auto"><code>Content-Type: application/json
Authorization: Bearer VOTRE_TOKEN_API</code></pre>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Exemple de requête :</h4>
                        <pre class="bg-gray-100 p-3 rounded text-sm overflow-x-auto"><code>{
    "to": "destinataire@example.com",
    "subject": "Sujet du message",
    "message": "Contenu du message en HTML ou texte",
    "cc": ["cc1@example.com", "cc2@example.com"],
    "bcc": ["bcc@example.com"]
}</code></pre>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('home') }}" target="_blank"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            📖 Voir la Documentation Complète
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
