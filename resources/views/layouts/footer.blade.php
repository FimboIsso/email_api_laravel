<!-- Fixed Footer -->
<footer class="bg-white border-t border-gray-200 shadow-lg mt-auto">
    <div class="px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between">
            <!-- Left side - Status and info -->
            <div class="flex items-center space-x-6">
                <div class="flex items-center text-sm text-gray-600">
                    <div class="flex items-center">
                        <div class="h-2 w-2 bg-green-400 rounded-full mr-2 animate-pulse"></div>
                        <span class="font-medium">API Status: </span>
                        <span class="text-green-600 ml-1">Active</span>
                    </div>
                </div>

                <div class="hidden sm:block text-sm text-gray-500">
                    Dernière synchronisation: {{ now()->format('H:i') }}
                </div>
            </div>

            <!-- Center - Quick stats -->
            <div class="hidden lg:flex items-center space-x-6 text-sm">
                <div class="flex items-center text-gray-600">
                    <svg class="h-4 w-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                        </path>
                    </svg>
                    <span class="font-medium">0</span>
                    <span class="ml-1">Tokens</span>
                </div>

                <div class="flex items-center text-gray-600">
                    <svg class="h-4 w-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 7.89a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span class="font-medium">0</span>
                    <span class="ml-1">Emails ce mois</span>
                </div>
            </div>

            <!-- Right side - Links and actions -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard.api-docs') }}"
                    class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">
                    Documentation
                </a>

                <a href="{{ route('dashboard.support') }}"
                    class="text-sm text-gray-500 hover:text-indigo-600 transition-colors">
                    Support
                </a>

                <div class="flex items-center text-xs text-gray-400">
                    <span>&copy; 2025 UZASHOP</span>
                </div>
            </div>
        </div>
    </div>
</footer>
