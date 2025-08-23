<section class="space-y-6">
    <div class="p-6 bg-red-50 border border-red-200 rounded-lg">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Attention - Action irréversible</h3>
                <div class="mt-2 text-sm text-red-700">
                    <p>Une fois votre compte supprimé, toutes vos données seront définitivement perdues :</p>
                    <ul class="list-disc pl-5 mt-2 space-y-1">
                        <li>Tous vos tokens API seront désactivés</li>
                        <li>Votre configuration email sera supprimée</li>
                        <li>L'historique de vos envois sera perdu</li>
                        <li>Cette action ne peut pas être annulée</li>
                    </ul>
                </div>
                <div class="mt-4">
                    <p class="text-sm font-medium text-red-800">
                        Avant de continuer, assurez-vous de sauvegarder toutes les données importantes.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-center">
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
                Supprimer définitivement mon compte
            </span>
        </button>
    </div>

    <!-- Modal de confirmation -->
    <div x-data="{ show: @js($errors->userDeletion->isNotEmpty()) }" x-on:open-modal.window="$event.detail == 'confirm-user-deletion' ? show = true : null"
        x-on:close.stop="show = false" x-on:keydown.escape.window="show = false" x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">

        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-on:click="show = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <!-- Modal panel -->
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-3">
                                    Êtes-vous absolument sûr ?
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600 mb-4">
                                        Cette action va <strong>définitivement supprimer</strong> votre compte et toutes
                                        vos données.
                                        Pour confirmer cette action, veuillez saisir votre mot de passe ci-dessous.
                                    </p>

                                    <div class="mt-4">
                                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                            Mot de passe de confirmation
                                        </label>
                                        <input id="password" name="password" type="password"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all duration-200"
                                            placeholder="Saisissez votre mot de passe" required>
                                        @error('password', 'userDeletion')
                                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Oui, supprimer mon compte
                        </button>
                        <button type="button" x-on:click="show = false"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
