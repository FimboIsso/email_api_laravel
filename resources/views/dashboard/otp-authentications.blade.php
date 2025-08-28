@extends('layouts.app')

@section('title', 'Authentifications OTP')

@section('content')
    <div class="min-h-screen bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="space-y-8">
                <!-- Page Header -->
                <div class="bg-white border border-gray-300 rounded-xl p-8 shadow-lg">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h1 class="text-4xl font-bold text-black flex items-center">
                                <svg class="w-10 h-10 mr-4 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                Authentifications OTP
                            </h1>
                            <p class="mt-3 text-lg text-gray-800">
                                Gérez et surveillez vos codes d'authentification à usage unique
                            </p>
                        </div>
                        <div class="mt-6 sm:mt-0">
                            <a href="#test-api"
                                class="inline-flex items-center px-6 py-3 border-2 border-blue-600 text-base font-semibold rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Tester l'API
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Total OTPs -->
                    <div
                        class="bg-white border-2 border-gray-300 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                        <div class="p-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-6 flex-1">
                                    <dt class="text-sm font-semibold text-gray-700 uppercase tracking-wide">Total des OTP
                                    </dt>
                                    <dd class="text-3xl font-bold text-black mt-2">{{ number_format($stats['total']) }}</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Verified OTPs -->
                    <div
                        class="bg-white border-2 border-gray-300 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                        <div class="p-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-6 flex-1">
                                    <dt class="text-sm font-semibold text-gray-700 uppercase tracking-wide">OTP Utilisés
                                    </dt>
                                    <dd class="text-3xl font-bold text-black mt-2">{{ number_format($stats['verified']) }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Expired OTPs -->
                    <div
                        class="bg-white border-2 border-gray-300 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                        <div class="p-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-red-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-6 flex-1">
                                    <dt class="text-sm font-semibold text-gray-700 uppercase tracking-wide">OTP Expirés</dt>
                                    <dd class="text-3xl font-bold text-black mt-2">{{ number_format($stats['expired']) }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Active OTPs -->
                    <div
                        class="bg-white border-2 border-gray-300 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-200">
                        <div class="p-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-yellow-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-6 flex-1">
                                    <dt class="text-sm font-semibold text-gray-700 uppercase tracking-wide">OTP Actifs</dt>
                                    <dd class="text-3xl font-bold text-black mt-2">{{ number_format($stats['active']) }}
                                    </dd>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filters -->
                <div class="bg-white border-2 border-gray-300 rounded-xl shadow-lg">
                    <div class="px-8 py-6 border-b-2 border-gray-200">
                        <h3 class="text-2xl font-bold text-black flex items-center">
                            <svg class="w-6 h-6 mr-3 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z">
                                </path>
                            </svg>
                            Filtres de Recherche
                        </h3>
                    </div>
                    <div class="p-8">
                        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-6">
                            <div>
                                <label for="email" class="block text-sm font-bold text-black mb-2">Adresse Email</label>
                                <input type="text" name="email" id="email" value="{{ $email ?? '' }}"
                                    placeholder="user@example.com"
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black bg-white text-base">
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-bold text-black mb-2">Statut</label>
                                <select name="status" id="status"
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black bg-white text-base">
                                    <option value="">Tous les statuts</option>
                                    <option value="verified" {{ ($status ?? '') === 'verified' ? 'selected' : '' }}>✅
                                        Utilisés</option>
                                    <option value="valid" {{ ($status ?? '') === 'valid' ? 'selected' : '' }}>🟡 Valides
                                        (non utilisés)</option>
                                    <option value="expired" {{ ($status ?? '') === 'expired' ? 'selected' : '' }}>❌ Expirés
                                    </option>
                                </select>
                            </div>
                            <div>
                                <label for="type" class="block text-sm font-bold text-black mb-2">Type d'OTP</label>
                                <select name="type" id="type"
                                    class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black bg-white text-base">
                                    <option value="">Tous les types</option>
                                    @if (isset($availableTypes))
                                        @foreach ($availableTypes as $availableType)
                                            <option value="{{ $availableType }}"
                                                {{ ($type ?? '') === $availableType ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $availableType)) }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="flex items-end space-x-3">
                                <button type="submit"
                                    class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-md">
                                    🔍 Filtrer
                                </button>
                                <a href="{{ route('dashboard.otp.authentications') }}"
                                    class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200 shadow-md">
                                    🔄 Reset
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- OTP Table -->
                <div class="bg-white border-2 border-gray-300 rounded-xl shadow-lg">
                    <div class="px-8 py-6 border-b-2 border-gray-200">
                        <h3 class="text-2xl font-bold text-black flex items-center">
                            <svg class="w-6 h-6 mr-3 text-gray-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                            Liste des Authentifications ({{ isset($otps) ? $otps->total() : 0 }})
                        </h3>
                    </div>

                    @if (isset($otps) && $otps->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-bold text-black uppercase tracking-wider border-b-2 border-gray-300">
                                            Email</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-bold text-black uppercase tracking-wider border-b-2 border-gray-300">
                                            Type</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-bold text-black uppercase tracking-wider border-b-2 border-gray-300">
                                            Code</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-bold text-black uppercase tracking-wider border-b-2 border-gray-300">
                                            Statut</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-bold text-black uppercase tracking-wider border-b-2 border-gray-300">
                                            Tentatives</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-bold text-black uppercase tracking-wider border-b-2 border-gray-300">
                                            Créé le</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-bold text-black uppercase tracking-wider border-b-2 border-gray-300">
                                            Expire le</th>
                                        <th
                                            class="px-6 py-4 text-left text-sm font-bold text-black uppercase tracking-wider border-b-2 border-gray-300">
                                            Utilisé le</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white">
                                    @foreach ($otps as $otp)
                                        <tr class="hover:bg-gray-50 border-b border-gray-200">
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="text-base font-semibold text-black">{{ $otp->email }}</div>
                                                @if ($otp->identifier)
                                                    <div class="text-sm text-gray-600">ID: {{ $otp->identifier }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <span
                                                    class="inline-flex px-3 py-2 text-sm font-bold rounded-full border-2
                                                    @switch($otp->type)
                                                        @case('email_verification')
                                                            bg-purple-100 text-purple-800 border-purple-300
                                                            @break
                                                        @case('password_reset')
                                                            bg-red-100 text-red-800 border-red-300
                                                            @break
                                                        @case('login_verification')
                                                            bg-green-100 text-green-800 border-green-300
                                                            @break
                                                        @case('two_factor')
                                                            bg-indigo-100 text-indigo-800 border-indigo-300
                                                            @break
                                                        @default
                                                            bg-gray-100 text-gray-800 border-gray-300
                                                    @endswitch
                                                ">
                                                    {{ ucfirst(str_replace('_', ' ', $otp->type)) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div
                                                    class="text-base font-mono font-bold text-black bg-gray-100 px-3 py-1 rounded-md border">
                                                    {{ $otp->code }}</div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                @if ($otp->is_used)
                                                    <span
                                                        class="inline-flex px-3 py-2 text-sm font-bold rounded-full bg-green-100 text-green-800 border-2 border-green-300">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Utilisé
                                                    </span>
                                                @elseif($otp->expires_at < now())
                                                    <span
                                                        class="inline-flex px-3 py-2 text-sm font-bold rounded-full bg-red-100 text-red-800 border-2 border-red-300">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Expiré
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex px-3 py-2 text-sm font-bold rounded-full bg-yellow-100 text-yellow-800 border-2 border-yellow-300">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Actif
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="text-base font-semibold text-black">{{ $otp->attempts }}/5
                                                </div>
                                                @if ($otp->attempts >= 5)
                                                    <div class="text-sm text-red-600 font-bold">Maximum atteint</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-sm text-black">
                                                <div title="{{ $otp->created_at->format('Y-m-d H:i:s') }}"
                                                    class="font-medium">
                                                    {{ $otp->created_at->diffForHumans() }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-sm text-black">
                                                <div title="{{ $otp->expires_at->format('Y-m-d H:i:s') }}"
                                                    class="font-medium">
                                                    {{ $otp->expires_at->diffForHumans() }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-sm text-black">
                                                @if ($otp->used_at)
                                                    <div title="{{ $otp->used_at->format('Y-m-d H:i:s') }}"
                                                        class="font-medium">
                                                        {{ $otp->used_at->diffForHumans() }}
                                                    </div>
                                                @else
                                                    <span class="text-gray-500 font-medium">-</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="px-6 py-4 border-t-2 border-gray-200 bg-gray-50">
                            {{ $otps->links() }}
                        </div>
                    @else
                        <div class="px-6 py-16 text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            <h3 class="mt-4 text-xl font-bold text-black">Aucune authentification trouvée</h3>
                            <p class="mt-2 text-base text-gray-700">
                                @if (request()->hasAny(['email', 'status', 'type']))
                                    Aucune authentification ne correspond aux filtres appliqués.
                                @else
                                    Aucune authentification OTP n'a encore été effectuée.
                                @endif
                            </p>
                            @if (request()->hasAny(['email', 'status', 'type']))
                                <div class="mt-8">
                                    <a href="{{ route('dashboard.otp.authentications') }}"
                                        class="inline-flex items-center px-6 py-3 border-2 border-blue-600 text-base font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 shadow-md">
                                        Voir toutes les authentifications
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                @if (Auth::user()->api_token)
                    <!-- API Test Section -->
                    <div class="bg-white border-2 border-gray-300 rounded-xl shadow-lg" id="test-api">
                        <div class="px-8 py-6 border-b-2 border-gray-200">
                            <h3 class="text-2xl font-bold text-black flex items-center">
                                <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                                    </path>
                                </svg>
                                Testeur API OTP
                            </h3>
                            <p class="text-base text-gray-700 mt-2">Testez votre API OTP directement depuis le dashboard
                            </p>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                <!-- Generate OTP Test -->
                                <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-6">
                                    <h4 class="text-xl font-bold text-black mb-6">🔐 Générer un OTP</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-bold text-black mb-2">Email</label>
                                            <input type="email" id="test-email" placeholder="user@example.com"
                                                class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black bg-white text-base">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-black mb-2">Type</label>
                                            <select id="test-type"
                                                class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black bg-white text-base">
                                                <option value="email_verification">Email Verification</option>
                                                <option value="password_reset">Password Reset</option>
                                                <option value="login_verification">Login Verification</option>
                                                <option value="two_factor">Two Factor</option>
                                            </select>
                                        </div>
                                        <button onclick="generateOtpTest()"
                                            class="w-full px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200 shadow-md text-base">
                                            🚀 Générer OTP
                                        </button>
                                    </div>
                                </div>

                                <!-- Verify OTP Test -->
                                <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-6">
                                    <h4 class="text-xl font-bold text-black mb-6">✅ Vérifier un OTP</h4>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-bold text-black mb-2">Email</label>
                                            <input type="email" id="verify-email" placeholder="user@example.com"
                                                class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black bg-white text-base">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-black mb-2">Code OTP</label>
                                            <input type="text" id="verify-code" placeholder="123456" maxlength="6"
                                                class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black bg-white text-base">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-black mb-2">Type</label>
                                            <select id="verify-type"
                                                class="block w-full px-4 py-3 border-2 border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-black bg-white text-base">
                                                <option value="email_verification">Email Verification</option>
                                                <option value="password_reset">Password Reset</option>
                                                <option value="login_verification">Login Verification</option>
                                                <option value="two_factor">Two Factor</option>
                                            </select>
                                        </div>
                                        <button onclick="verifyOtpTest()"
                                            class="w-full px-6 py-4 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200 shadow-md text-base">
                                            🔍 Vérifier OTP
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Results -->
                            <div id="test-results" class="mt-8 hidden">
                                <h4 class="text-xl font-bold text-black mb-4">📊 Résultat du test</h4>
                                <div class="bg-gray-100 border-2 border-gray-300 rounded-lg p-6 overflow-x-auto">
                                    <pre id="test-output" class="text-sm text-black font-mono"></pre>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Info Footer -->
                <div class="bg-gray-100 border-2 border-gray-300 rounded-xl p-6 shadow-md">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between text-base text-black">
                        <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-6">
                            <span class="font-semibold">📊 Dernière mise à jour :
                                {{ now()->format('d/m/Y H:i:s') }}</span>
                            <span class="hidden sm:block">•</span>
                            <span class="font-semibold">🔒 OTP valides pendant 1-60 minutes</span>
                        </div>
                        <div class="mt-4 sm:mt-0">
                            <span
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-800 border-2 border-green-300">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                Système OTP Actif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Remove any dark mode styles */
        * {
            color-scheme: light !important;
        }

        /* Custom scrollbar for table */
        .overflow-x-auto::-webkit-scrollbar {
            height: 12px;
        }

        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Hover effects */
        .hover\:shadow-xl:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>

    @if (Auth::user()->api_token)
        <script>
            const API_TOKEN = '{{ Auth::user()->api_token }}';
            const BASE_URL = '{{ url('/') }}';

            async function generateOtpTest() {
                const email = document.getElementById('test-email').value;
                const type = document.getElementById('test-type').value;

                if (!email) {
                    alert('Veuillez entrer un email');
                    return;
                }

                try {
                    const response = await fetch(`${BASE_URL}/api/otp/generate`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${API_TOKEN}`,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            email: email,
                            type: type
                        })
                    });

                    const result = await response.json();
                    showTestResult('🚀 Génération OTP', result, response.ok);
                } catch (error) {
                    showTestResult('🚀 Génération OTP', {
                        error: error.message
                    }, false);
                }
            }

            async function verifyOtpTest() {
                const email = document.getElementById('verify-email').value;
                const code = document.getElementById('verify-code').value;
                const type = document.getElementById('verify-type').value;

                if (!email || !code) {
                    alert('Veuillez entrer un email et un code');
                    return;
                }

                try {
                    const response = await fetch(`${BASE_URL}/api/otp/verify`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${API_TOKEN}`,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            email: email,
                            code: code,
                            type: type
                        })
                    });

                    const result = await response.json();
                    showTestResult('✅ Vérification OTP', result, response.ok);
                } catch (error) {
                    showTestResult('✅ Vérification OTP', {
                        error: error.message
                    }, false);
                }
            }

            function showTestResult(title, result, success) {
                const resultsDiv = document.getElementById('test-results');
                const outputDiv = document.getElementById('test-output');

                resultsDiv.classList.remove('hidden');
                outputDiv.innerHTML = `${title} - ${success ? '✅ SUCCÈS' : '❌ ERREUR'}\n\n${JSON.stringify(result, null, 2)}`;

                // Scroll to results
                resultsDiv.scrollIntoView({
                    behavior: 'smooth'
                });

                // Auto-reload page after 5 seconds if successful
                if (success) {
                    setTimeout(() => {
                        window.location.reload();
                    }, 5000);
                }
            }
        </script>
    @endif
@endsection
