<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Forgot Password?</h1>
        <p class="text-gray-600 text-center leading-relaxed">
            No problem! Enter your email address and we'll send you a password reset link.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus
                placeholder="Enter your email address" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <x-primary-button class="w-full">
                {{ __('Send Reset Link') }}
            </x-primary-button>
        </div>

        <!-- Back to Login Link -->
        <div class="text-center pt-4">
            <a href="{{ route('login') }}"
                class="text-sm text-indigo-600 hover:text-indigo-500 font-medium transition-colors">
                ← Back to login
            </a>
        </div>
    </form>
</x-guest-layout>
