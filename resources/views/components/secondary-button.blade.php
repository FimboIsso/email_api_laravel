<button
    {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-white/80 backdrop-blur-sm border border-gray-200 rounded-xl font-semibold text-sm text-gray-700 tracking-wide shadow-sm hover:bg-white hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:ring-offset-2 disabled:opacity-50 transform hover:scale-105 transition-all duration-200']) }}>
    {{ $slot }}
</button>
