<x-guest-layout>
    <!-- Header avec icône et animations -->
    <div class="text-center mb-8">
        <div
            class="mx-auto w-16 h-16 bg-gradient-to-r from-green-600 to-emerald-600 rounded-full flex items-center justify-center mb-4 animate-bounce">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">
            Créez votre compte 🚀
        </h1>
        <p class="text-gray-600">Rejoignez UZASHOP API et commencez dès aujourd'hui</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name avec design moderne -->
        <div class="space-y-2">
            <label for="name" class="block text-sm font-semibold text-gray-700">
                Nom complet
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    autocomplete="name"
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                    placeholder="Votre nom complet">
            </div>
            @error('name')
                <p class="text-sm text-red-600 flex items-center mt-1">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Email Address avec design moderne -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-gray-700">
                Adresse email
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                        </path>
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    autocomplete="username"
                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                    placeholder="votre@email.com">
            </div>
            @error('email')
                <p class="text-sm text-red-600 flex items-center mt-1">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password avec toggle de visibilité -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-gray-700">
                Mot de passe
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                    placeholder="Créez un mot de passe sécurisé">
                <button type="button" onclick="togglePasswordVisibility('password')"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-sm text-red-600 flex items-center mt-1">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
            <div class="text-xs text-gray-500">
                <p>Le mot de passe doit contenir au moins 8 caractères.</p>
            </div>
        </div>

        <!-- Confirm Password avec toggle -->
        <div class="space-y-2">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">
                Confirmer le mot de passe
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    autocomplete="new-password"
                    class="w-full pl-10 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                    placeholder="Confirmez votre mot de passe">
                <button type="button" onclick="togglePasswordVisibility('password_confirmation')"
                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                </button>
            </div>
            @error('password_confirmation')
                <p class="text-sm text-red-600 flex items-center mt-1">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Conditions d'utilisation -->
        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        En créant votre compte, vous acceptez nos
                        <a href="#" class="font-medium underline hover:no-underline">conditions
                            d'utilisation</a>
                        et notre
                        <a href="#" class="font-medium underline hover:no-underline">politique de
                            confidentialité</a>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Submit Button avec gradient et animations -->
        <div class="pt-6">
            <button type="submit"
                class="w-full bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white font-medium py-4 px-6 rounded-xl transition-all duration-200 transform hover:scale-[1.02] focus:ring-2 focus:ring-green-500 focus:ring-offset-2 shadow-lg hover:shadow-xl">
                <span class="flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                    Créer mon compte gratuitement
                </span>
            </button>
        </div>

        <!-- Divider avec style moderne -->
        <div class="relative py-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-200"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white text-gray-500 font-medium">Déjà membre ?</span>
            </div>
        </div>

        <!-- Login Link avec design card -->
        <div class="text-center">
            <div class="p-6 bg-gradient-to-r from-gray-50 to-green-50 rounded-xl border border-gray-200">
                <p class="text-sm text-gray-600 mb-3">
                    Vous avez déjà un compte ? Connectez-vous pour accéder à votre dashboard
                </p>
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-green-600 text-green-600 font-medium rounded-lg hover:bg-green-600 hover:text-white transition-all duration-200 transform hover:scale-105">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                        </path>
                    </svg>
                    Se connecter
                </a>
            </div>
        </div>
    </form>

    <!-- Avantages en bas -->
    <div class="mt-8">
        <h3 class="text-center text-sm font-semibold text-gray-700 mb-4">Pourquoi choisir UZASHOP API ?</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-gray-600">
            <div class="text-center p-3 bg-green-50 rounded-lg">
                <svg class="w-6 h-6 mx-auto mb-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd"></path>
                </svg>
                <p class="font-medium">API fiable</p>
                <p>99.9% de disponibilité garantie</p>
            </div>
            <div class="text-center p-3 bg-blue-50 rounded-lg">
                <svg class="w-6 h-6 mx-auto mb-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                    </path>
                </svg>
                <p class="font-medium">Interface simple</p>
                <p>Dashboard intuitif et complet</p>
            </div>
            <div class="text-center p-3 bg-purple-50 rounded-lg">
                <svg class="w-6 h-6 mx-auto mb-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                        clip-rule="evenodd"></path>
                </svg>
                <p class="font-medium">Support dédié</p>
                <p>Équipe technique réactive 24/7</p>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('svg');

            if (input.type === 'password') {
                input.type = 'text';
                icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L8.464 8.464m1.414 1.414L21.536 21.536"/>
            `;
            } else {
                input.type = 'password';
                icon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            `;
            }
        }
    </script>
</x-guest-layout>
