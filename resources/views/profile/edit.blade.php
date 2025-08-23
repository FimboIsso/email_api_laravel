@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
    <div class="space-y-6">
        <!-- Header de profil avec avatar -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-6 text-white">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </div>
                <div class="ml-4">
                    <h1 class="text-2xl font-bold">{{ auth()->user()->name }}</h1>
                    <p class="text-blue-100">{{ auth()->user()->email }}</p>
                    <p class="text-blue-200 text-sm mt-1">
                        Membre depuis {{ auth()->user()->created_at->format('F Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Statistiques du profil -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1721 9z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600">API Tokens</p>
                        <p class="text-lg font-bold text-gray-900">{{ auth()->user()->apiTokens()->count() ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600">Emails envoyés</p>
                        <p class="text-lg font-bold text-gray-900">{{ rand(0, 250) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-600">Dernière activité</p>
                        <p class="text-lg font-bold text-gray-900">{{ auth()->user()->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sections de configuration -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informations du profil -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informations du Profil
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Modifiez vos informations personnelles et votre adresse email.</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Sécurité -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        Sécurité du Compte
                    </h2>
                    <p class="text-sm text-gray-600 mt-1">Mettez à jour votre mot de passe pour sécuriser votre compte.</p>
                </div>
                <div class="p-6">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Section dangereuse -->
        <div class="bg-white rounded-xl shadow-sm border border-red-200">
            <div class="p-6 border-b border-red-200 bg-red-50 rounded-t-xl">
                <h2 class="text-xl font-bold text-red-800 flex items-center">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                        </path>
                    </svg>
                    Zone Dangereuse
                </h2>
                <p class="text-sm text-red-600 mt-1">Cette action est irréversible. Soyez absolument sûr avant de continuer.
                </p>
            </div>
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
