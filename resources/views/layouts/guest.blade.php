<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 bg-white">
        {{ $slot }}

        {{-- Generic Toast for guest pages (login/forgot) --}}
        @if(session('toast'))
            @php $t = session('toast'); @endphp
            <div id="cartSuccessToast" class="fixed top-4 right-4 @if(isset($t['variant']) && $t['variant']==='blue') bg-gradient-to-r from-blue-500 to-blue-600 @else bg-gradient-to-r from-blue-500 to-blue-600 @endif text-white px-6 py-4 rounded-lg shadow-xl transform translate-x-full transition-transform duration-500 z-50 max-w-sm">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-sm">{{ $t['title'] ?? 'Info' }}</div>
                        <div class="text-xs opacity-90">{{ $t['message'] ?? '' }}</div>
                    </div>
                    <button onclick="closeCartToast()" class="ml-auto flex-shrink-0 text-white hover:text-gray-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const cartToast = document.getElementById('cartSuccessToast');
                if (cartToast) {
                    // Show toast
                    setTimeout(() => {
                        cartToast.classList.remove('translate-x-full');
                        cartToast.classList.add('translate-x-0');
                    }, 200);

                    // Auto hide after 3s
                    setTimeout(() => {
                        closeCartToast();
                    }, 3000);
                }
            });

            function closeCartToast() {
                const cartToast = document.getElementById('cartSuccessToast');
                if (!cartToast) return;
                cartToast.classList.remove('translate-x-0');
                cartToast.classList.add('translate-x-full');
                setTimeout(() => { if (cartToast.parentNode) cartToast.remove(); }, 500);
            }
        </script>
    </body>
</html>
