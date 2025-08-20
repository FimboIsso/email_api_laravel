<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification - UZASHOP Email API</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo et header -->
            <div class="text-center">
                <div
                    class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>
                <h1 class="mt-6 text-3xl font-bold text-gray-900">Code de vérification</h1>
                <p class="mt-2 text-sm text-gray-600">
                    Nous avons envoyé un code de vérification à<br>
                    <span class="font-medium text-gray-900">{{ session('auth_email') }}</span>
                </p>
            </div>

            <!-- Formulaire -->
            <div class="bg-white/80 backdrop-blur-lg py-8 px-6 shadow-2xl rounded-2xl border border-white/20">
                @if (session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
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

                <form class="space-y-6" action="{{ route('auth.verify-code') }}" method="POST">
                    @csrf

                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">
                            Code de vérification
                        </label>
                        <div class="mt-1 relative">
                            <input id="code" name="code" type="text" maxlength="6" required
                                value="{{ old('code') }}"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-xl shadow-sm text-center text-2xl font-mono letter-spacing-wide placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all duration-200 bg-white/50 backdrop-blur-sm @error('code') border-red-300 text-red-900 placeholder-red-300 focus:outline-none focus:ring-red-500 focus:border-red-500 @enderror"
                                placeholder="000000" inputmode="numeric" pattern="[0-9]{6}">
                        </div>
                        @error('code')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Entrez le code à 6 chiffres que vous avez reçu par email
                        </p>
                    </div>

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
                            Vérifier le code
                        </button>
                    </div>

                    <!-- Timer et resend -->
                    <div class="text-center space-y-4">
                        <div id="timer-section" class="text-sm text-gray-500">
                            Code expire dans : <span id="timer"
                                class="font-mono font-bold text-red-600">15:00</span>
                        </div>

                        <div id="resend-section" class="hidden">
                            <button type="button" onclick="resendCode()"
                                class="text-sm text-blue-600 hover:text-blue-500 font-medium">
                                Renvoyer le code
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Bouton retour -->
                <div class="mt-6 text-center">
                    <a href="{{ route('auth.login') }}" class="text-sm text-gray-500 hover:text-gray-700">
                        ← Changer d'adresse email
                    </a>
                </div>
            </div>

            <!-- Note de sécurité -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-800">
                            <strong>Sécurité :</strong> Ne partagez jamais votre code avec personne.
                            UZASHOP ne vous demandera jamais votre code par téléphone ou email.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-focus sur le champ code
        document.getElementById('code').focus();

        // Timer countdown
        let timeLeft = 15 * 60; // 15 minutes en secondes
        const timer = document.getElementById('timer');
        const timerSection = document.getElementById('timer-section');
        const resendSection = document.getElementById('resend-section');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timer.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            if (timeLeft <= 0) {
                timerSection.classList.add('hidden');
                resendSection.classList.remove('hidden');
                return;
            }

            timeLeft--;
            setTimeout(updateTimer, 1000);
        }

        updateTimer();

        // Format input as user types
        document.getElementById('code').addEventListener('input', function(e) {
            // Remove non-numeric characters
            this.value = this.value.replace(/[^0-9]/g, '');

            // Auto-submit when 6 digits are entered
            if (this.value.length === 6) {
                this.form.submit();
            }
        });

        // Resend code function
        function resendCode() {
            fetch('{{ route('auth.resend-code') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reset timer
                        timeLeft = 15 * 60;
                        timerSection.classList.remove('hidden');
                        resendSection.classList.add('hidden');
                        updateTimer();

                        // Show success message
                        const successDiv = document.createElement('div');
                        successDiv.className =
                            'mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg';
                        successDiv.innerHTML = `
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">Code renvoyé avec succès !</p>
                            </div>
                        </div>
                    `;
                        document.querySelector('form').insertBefore(successDiv, document.querySelector('form')
                            .firstChild);

                        // Remove message after 3 seconds
                        setTimeout(() => {
                            successDiv.remove();
                        }, 3000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

    <style>
        .letter-spacing-wide {
            letter-spacing: 0.5rem;
        }
    </style>
</body>

</html>
