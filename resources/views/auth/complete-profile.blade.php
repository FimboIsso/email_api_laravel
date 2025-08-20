<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complétez votre profil - UZASHOP Email API</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8">
            <!-- Logo et header -->
            <div class="text-center">
                <div
                    class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h1 class="mt-6 text-3xl font-bold text-gray-900">Complétez votre profil</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Dernière étape ! Ajoutez vos informations pour finaliser votre compte
                </p>
            </div>

            <!-- Barre de progression -->
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-6 border border-white/20 shadow-lg">
                <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                    <span>Progression</span>
                    <span>Étape 3/3</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-purple-600 h-2 rounded-full" style="width: 100%">
                    </div>
                </div>
            </div>

            <!-- Formulaire -->
            <div class="bg-white/80 backdrop-blur-lg py-8 px-6 shadow-2xl rounded-2xl border border-white/20">
                @if (session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">{{ session('error') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('auth.complete-profile') }}" method="POST">
                    @csrf

                    <!-- Informations personnelles -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Informations personnelles
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Ces informations sont requises pour finaliser votre
                                compte</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nom complet <span class="text-red-500">*</span>
                                </label>
                                <input id="name" name="name" type="text" required value="{{ old('name') }}"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm @error('name') border-red-300 @enderror"
                                    placeholder="John Doe">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">
                                    Numéro de téléphone
                                </label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone') }}"
                                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm @error('phone') border-red-300 @enderror"
                                    placeholder="+33 6 12 34 56 78">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="company" class="block text-sm font-medium text-gray-700">
                                Entreprise / Organisation
                            </label>
                            <input id="company" name="company" type="text" value="{{ old('company') }}"
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm @error('company') border-red-300 @enderror"
                                placeholder="Mon Entreprise">
                            @error('company')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">
                                Adresse
                            </label>
                            <textarea id="address" name="address" rows="3"
                                class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm @error('address') border-red-300 @enderror"
                                placeholder="123 Rue de la Paix&#10;75001 Paris, France">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Sécurité -->
                    <div class="space-y-6">
                        <div class="border-b border-gray-200 pb-4">
                            <h3 class="text-lg font-medium text-gray-900 flex items-center">
                                <svg class="h-5 w-5 text-blue-600 mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                                Sécurité du compte
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">Choisissez un mot de passe sécurisé</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Mot de passe <span class="text-red-500">*</span>
                                </label>
                                <input id="password" name="password" type="password" required
                                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm @error('password') border-red-300 @enderror"
                                    placeholder="••••••••" minlength="8">
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Minimum 8 caractères</p>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    Confirmer le mot de passe <span class="text-red-500">*</span>
                                </label>
                                <input id="password_confirmation" name="password_confirmation" type="password"
                                    required
                                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <!-- Indicateur de force du mot de passe -->
                        <div id="password-strength" class="hidden">
                            <div class="text-sm text-gray-600 mb-1">Force du mot de passe :</div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="strength-bar" class="h-2 rounded-full transition-all duration-300"></div>
                            </div>
                            <div id="strength-text" class="text-xs text-gray-500 mt-1"></div>
                        </div>
                    </div>

                    <!-- Information sur l'email -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-800">
                                    <strong>Votre email :</strong>
                                    {{ auth()->user()->email ?? session('auth_email') }}<br>
                                    <span class="text-xs">Votre adresse email a été vérifiée avec succès.</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Bouton submit -->
                    <div>
                        <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-blue-300 group-hover:text-blue-200" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </span>
                            Finaliser mon compte
                        </button>
                    </div>

                    <div class="text-center">
                        <p class="text-xs text-gray-500">
                            En créant votre compte, vous acceptez nos
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500">conditions
                                d'utilisation</a>
                            et notre
                            <a href="#" class="font-medium text-blue-600 hover:text-blue-500">politique de
                                confidentialité</a>.
                        </p>
                    </div>
                </form>
            </div>

            <div class="text-center text-sm text-gray-500">
                Développé par <a href="https://uzashop.co"
                    class="font-medium text-blue-600 hover:text-blue-500">UZASHOP Sarlu</a>
            </div>
        </div>
    </div>

    <script>
        // Auto-focus sur le champ nom
        document.getElementById('name').focus();

        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthContainer = document.getElementById('password-strength');
        const strengthBar = document.getElementById('strength-bar');
        const strengthText = document.getElementById('strength-text');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            if (password.length === 0) {
                strengthContainer.classList.add('hidden');
                return;
            }

            strengthContainer.classList.remove('hidden');
            const strength = calculatePasswordStrength(password);
            updateStrengthIndicator(strength);
        });

        function calculatePasswordStrength(password) {
            let score = 0;
            const checks = {
                length: password.length >= 8,
                lowercase: /[a-z]/.test(password),
                uppercase: /[A-Z]/.test(password),
                numbers: /\d/.test(password),
                special: /[^A-Za-z\d]/.test(password)
            };

            score = Object.values(checks).filter(Boolean).length;

            if (password.length >= 12) score++;

            return Math.min(score, 5);
        }

        function updateStrengthIndicator(strength) {
            const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e', '#16a34a'];
            const texts = ['Très faible', 'Faible', 'Moyen', 'Fort', 'Très fort'];
            const widths = ['20%', '40%', '60%', '80%', '100%'];

            const colorIndex = Math.max(0, strength - 1);

            strengthBar.style.width = widths[colorIndex];
            strengthBar.style.backgroundColor = colors[colorIndex];
            strengthText.textContent = texts[colorIndex];
            strengthText.style.color = colors[colorIndex];
        }

        // Password confirmation validation
        const confirmPasswordInput = document.getElementById('password_confirmation');
        confirmPasswordInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.setCustomValidity('Les mots de passe ne correspondent pas');
            } else {
                this.setCustomValidity('');
            }
        });

        passwordInput.addEventListener('input', function() {
            if (confirmPasswordInput.value && confirmPasswordInput.value !== this.value) {
                confirmPasswordInput.setCustomValidity('Les mots de passe ne correspondent pas');
            } else {
                confirmPasswordInput.setCustomValidity('');
            }
        });
    </script>
</body>

</html>
