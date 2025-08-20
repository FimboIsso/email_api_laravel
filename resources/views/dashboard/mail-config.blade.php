@extends('layouts.app')

@section('title', 'Configuration Email')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Configuration Email</h1>
                <p class="mt-2 text-sm text-gray-700">Configurez vos paramètres SMTP pour l'envoi d'emails</p>
            </div>
            <div class="flex gap-3">
                <button onclick="testEmail()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    Tester la Configuration
                </button>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <!-- Configuration Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6">
                <form method="POST" action="{{ route('dashboard.mail-config.update') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Driver Selection -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Driver Email
                            </label>
                            <select name="mail_mailer"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                onchange="toggleSmtpFields(this.value)">
                                <option value="smtp"
                                    {{ (auth()->user()->mail_mailer ?? 'smtp') === 'smtp' ? 'selected' : '' }}>SMTP</option>
                                <option value="log"
                                    {{ (auth()->user()->mail_mailer ?? 'smtp') === 'log' ? 'selected' : '' }}>Log (Test)
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Chiffrement
                            </label>
                            <select name="mail_encryption"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 smtp-field">
                                <option value="">Aucun</option>
                                <option value="tls"
                                    {{ (auth()->user()->mail_encryption ?? '') === 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl"
                                    {{ (auth()->user()->mail_encryption ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                            </select>
                        </div>
                    </div>

                    <!-- SMTP Configuration -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="smtp-field">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Serveur SMTP <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="mail_host" value="{{ auth()->user()->mail_host ?? '' }}"
                                placeholder="smtp.gmail.com"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="smtp-field">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Port <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="mail_port" value="{{ auth()->user()->mail_port ?? '587' }}"
                                placeholder="587"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <!-- Credentials -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="smtp-field">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nom d'utilisateur
                            </label>
                            <input type="text" name="mail_username" value="{{ auth()->user()->mail_username ?? '' }}"
                                placeholder="votre-email@example.com"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <div class="smtp-field">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Mot de passe
                            </label>
                            <input type="password" name="mail_password"
                                placeholder="Laissez vide pour conserver le mot de passe actuel"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <!-- From Configuration -->
                    <div class="border-t pt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Configuration Expéditeur</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email expéditeur <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="mail_from_address"
                                    value="{{ auth()->user()->mail_from_address ?? '' }}" required
                                    placeholder="noreply@votredomaine.com"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nom expéditeur <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="mail_from_name"
                                    value="{{ auth()->user()->mail_from_name ?? 'UZASHOP API' }}" required
                                    placeholder="UZASHOP API"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-6 border-t">
                        <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Enregistrer la Configuration
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Configuration Tips -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <h3 class="text-lg font-medium text-blue-900 mb-3">💡 Conseils de Configuration</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-blue-800">
                <div>
                    <h4 class="font-medium mb-2">Gmail :</h4>
                    <ul class="space-y-1 text-xs">
                        <li>• Serveur : smtp.gmail.com</li>
                        <li>• Port : 587 (TLS) ou 465 (SSL)</li>
                        <li>• Utilisez un mot de passe d'application</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-medium mb-2">Outlook/Hotmail :</h4>
                    <ul class="space-y-1 text-xs">
                        <li>• Serveur : smtp-mail.outlook.com</li>
                        <li>• Port : 587 (TLS)</li>
                        <li>• Authentification requise</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleSmtpFields(driver) {
            const smtpFields = document.querySelectorAll('.smtp-field');
            const isSmtp = driver === 'smtp';

            smtpFields.forEach(field => {
                if (isSmtp) {
                    field.style.display = 'block';
                    field.querySelector('input, select').removeAttribute('disabled');
                } else {
                    field.style.display = 'none';
                    field.querySelector('input, select').setAttribute('disabled', 'disabled');
                }
            });
        }

        function testEmail() {
            const button = event.target;
            const originalText = button.innerHTML;

            button.innerHTML =
                '<svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Test en cours...';
            button.disabled = true;

            fetch('{{ route('dashboard.mail-config.test') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showNotification('Email de test envoyé avec succès!', 'success');
                    } else {
                        showNotification('Erreur: ' + data.message, 'error');
                    }
                })
                .catch(error => {
                    showNotification('Erreur lors de l\'envoi du test', 'error');
                })
                .finally(() => {
                    button.innerHTML = originalText;
                    button.disabled = false;
                });
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
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

        // Initialize SMTP field visibility
        document.addEventListener('DOMContentLoaded', function() {
            const driverSelect = document.querySelector('select[name="mail_mailer"]');
            toggleSmtpFields(driverSelect.value);
        });
    </script>
@endsection
