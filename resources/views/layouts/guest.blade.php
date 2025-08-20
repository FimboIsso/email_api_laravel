<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <!-- Background with gradient -->
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
        <!-- Decorative elements -->
        <div class="absolute inset-0 overflow-hidden">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-purple-400/20 rounded-full blur-3xl">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-pink-400/20 rounded-full blur-3xl">
            </div>
        </div>

        <!-- Logo section -->
        <div class="relative z-10">
            <a href="/" class="flex items-center justify-center">
                <div class="bg-white/80 backdrop-blur-sm p-4 rounded-2xl shadow-lg border border-white/20">
                    <x-application-logo class="w-12 h-12 fill-current text-indigo-600" />
                </div>
            </a>
        </div>

        <!-- Main card -->
        <div class="relative z-10 w-full sm:max-w-md mt-8 mx-4">
            <div class="bg-white/80 backdrop-blur-lg shadow-2xl border border-white/20 overflow-hidden sm:rounded-2xl">
                <div class="px-8 py-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</body>

</html>
