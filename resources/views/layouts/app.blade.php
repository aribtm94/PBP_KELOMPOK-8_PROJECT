<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name') }}</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&display=swap" rel="stylesheet">
  
  <style>
    @font-face {
      font-family: 'Sloop Script Bold Two';
      src: url('{{ asset('fonts/Sloop Script Bold Two Regular.ttf') }}') format('truetype');
      font-weight: normal;
      font-style: normal;
      font-display: swap;
    }

    /* Animation keyframes */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
      }
      to {
        opacity: 1;
      }
    }

    @keyframes slideInLeft {
      from {
        opacity: 0;
        transform: translateX(-30px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* Animation classes */
    .animate-fade-in {
      animation: fadeInUp 0.6s ease-out forwards;
    }

    .animate-fade-in-delay {
      animation: fadeInUp 0.6s ease-out 0.2s forwards;
      opacity: 0;
    }

    .animate-slide-left {
      animation: slideInLeft 0.6s ease-out forwards;
    }

    /* Hover effects */
    .hover-glow:hover {
      box-shadow: 0 0 20px rgba(163, 133, 96, 0.5);
      transform: translateY(-2px);
    }

    /* Gradient text */
    .gradient-text {
      background: linear-gradient(135deg, #E0E0E0 0%, #A38560 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }

    ::-webkit-scrollbar-track {
      background: #16302B;
    }

    ::-webkit-scrollbar-thumb {
      background: #A38560;
      border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
      background: #8B7355;
    }
  </style>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-[#16302B] text-gray-800 pt-20">
  <nav id="navbar" class="bg-[#A38560] fixed top-0 left-0 right-0 z-50 transition-all duration-300 ease-in-out">
    <div class="w-full px-0 py-3 flex items-center justify-between">
        <!-- Hamburger dan Logo - Mepet Kiri -->
        <div class="flex items-center pl-6">
            <!-- Hamburger Menu - Show when menu is hidden -->
            <button id="mobile-menu-toggle" class="xl:hidden text-[#390517] hover:opacity-75">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
            
            <!-- Garis Vertikal -->
            <div class="xl:hidden h-8 w-px bg-[#390517]/30 mx-4"></div>
            
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex flex-col hover:opacity-80 transition-opacity">
                        <span class="text-[#390517] text-xl font-bold">{{ config('app.name') }}</span>
                        <span class="hidden sm:block text-[#390517] text-sm font-bold italic">Temukan Sesuai Gayamu!</span>
                    </a>
                @else
                    <a href="{{ route('home') }}" class="flex flex-col hover:opacity-80 transition-opacity">
                        <span class="text-[#390517] text-xl font-bold">{{ config('app.name') }}</span>
                        <span class="hidden sm:block text-[#390517] text-sm font-bold italic">Temukan Sesuai Gayamu!</span>
                    </a>
                @endif
            @else
                <a href="{{ route('home') }}" class="flex flex-col hover:opacity-80 transition-opacity">
                    <span class="text-[#390517] text-xl font-bold">{{ config('app.name') }}</span>
                    <span class="hidden sm:block text-[#390517] text-sm font-bold italic">Temukan Sesuai Gayamu!</span>
                </a>
            @endauth
        </div>

        <!-- Search Bar - Only for Users and Guests -->
        @auth
            @if(auth()->user()->role !== 'admin')
                <div class="hidden lg:flex flex-shrink-0 ml-8">
                    <form method="GET" action="{{ route('home') }}" class="relative flex items-center">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Cari produk..." 
                            value="{{ request('search') }}"
                            class="px-3 py-2 pr-12 rounded-full border-none focus:outline-none focus:ring-2 focus:ring-white/50 text-gray-800 w-80 xl:w-96 bg-[#E0E0E0]"
                        >
                        <button type="submit" class="absolute right-2 p-2 hover:opacity-75">
                            <img src="{{ asset('images/Search-Icon.png') }}" alt="Search" class="w-5 h-5">
                        </button>
                    </form>
                </div>
            @endif
        @else
            <div class="hidden lg:flex flex-shrink-0 ml-8">
                <form method="GET" action="{{ route('home') }}" class="relative flex items-center">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Cari produk..." 
                        value="{{ request('search') }}"
                        class="px-3 py-2 pr-12 rounded-full border-none focus:outline-none focus:ring-2 focus:ring-white/50 text-gray-800 w-80 xl:w-96 bg-[#E0E0E0]"
                    >
                    <button type="submit" class="absolute right-2 p-2 hover:opacity-75">
                        <img src="{{ asset('images/Search-Icon.png') }}" alt="Search" class="w-5 h-5">
                    </button>
                </form>
            </div>
        @endauth

        <!-- Navigation Links - Different for Admin and User -->
        @auth
            @if(auth()->user()->role === 'admin')
                <!-- Admin Navigation -->
                <div class="hidden xl:flex gap-16">
                    <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">
                        📦 Kelola Produk
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">
                        📋 Kelola Pesanan
                    </a>
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">
                        🏠 Lihat Toko
                    </a>
                </div>
            @else
                <!-- User Navigation -->
                <div class="hidden xl:flex gap-16">
                    <a href="{{ route('kemeja') }}" class="{{ Route::currentRouteName() == 'kemeja' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">T-Shirts</a>
                    <a href="{{ route('kaos') }}" class="{{ Route::currentRouteName() == 'kaos' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">Shirts</a>
                    <a href="{{ route('pants') }}" class="{{ Route::currentRouteName() == 'pants' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">Pants</a>
                    <a href="{{ route('jaket') }}" class="{{ Route::currentRouteName() == 'jaket' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">Outerwear</a>
                </div>
            @endif
        @else
            <!-- Guest Navigation -->
            <div class="hidden xl:flex gap-16">
                <a href="{{ route('kemeja') }}" class="{{ Route::currentRouteName() == 'kemeja' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">T-Shirts</a>
                <a href="{{ route('kaos') }}" class="{{ Route::currentRouteName() == 'kaos' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">Shirts</a>
                <a href="{{ route('pants') }}" class="{{ Route::currentRouteName() == 'pants' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">Pants</a>
                <a href="{{ route('jaket') }}" class="{{ Route::currentRouteName() == 'jaket' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 px-3 transition-opacity">Outerwear</a>
            </div>
        @endauth

        <!-- Mobile Search & User Authentication -->
        <div class="flex gap-2 sm:gap-4 items-center pr-3 sm:pr-6 flex-shrink-0">
            @auth
                @if(auth()->user()->role !== 'admin')
                    <!-- Mobile Search Icon Only -->
                    <button id="mobile-search-toggle" class="lg:hidden text-[#390517] hover:opacity-75 flex-shrink-0">
                        <img src="{{ asset('images/Search-Icon.png') }}" alt="Search" class="w-4 h-4 sm:w-5 sm:h-5">
                    </button>

                    <!-- Garis Vertikal - Mobile Search -->
                    <div class="lg:hidden h-6 sm:h-8 w-px bg-[#390517]/30 flex-shrink-0"></div>
                @endif
            @else
                <!-- Mobile Search Icon Only -->
                <button id="mobile-search-toggle" class="lg:hidden text-[#390517] hover:opacity-75 flex-shrink-0">
                    <img src="{{ asset('images/Search-Icon.png') }}" alt="Search" class="w-4 h-4 sm:w-5 sm:h-5">
                </button>

                <!-- Garis Vertikal - Mobile Search -->
                <div class="lg:hidden h-6 sm:h-8 w-px bg-[#390517]/30 flex-shrink-0"></div>
            @endauth

            @auth
                @if(auth()->user()->role === 'user')
                    <!-- Cart Icon - Only for Users -->
                    <a href="{{ route('cart.index') }}" class="text-white hover:opacity-75 flex items-center flex-shrink-0">
                        <img src="{{ asset('images/cart-icon.png') }}" alt="Cart" class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0">
                        @if(auth()->user()->cart?->items()->sum('qty'))
                            <span class="ml-1 bg-red-500 text-white text-xs rounded-full px-1 min-w-[16px] text-center">{{ auth()->user()->cart->items()->sum('qty') }}</span>
                        @endif
                    </a>

                    <!-- Garis Vertikal -->
                    <div class="h-6 sm:h-8 w-px bg-[#390517]/30 flex-shrink-0"></div>
                @endif

                <!-- Profile Icon -->
                <div class="relative flex-shrink-0">
                    <button id="profile-button" class="text-[#390517] flex items-center">
                        @if(auth()->user()->profile_image)
                            <!-- Profile Image in Circle -->
                            <div class="w-5 h-5 sm:w-6 sm:h-6 rounded-full overflow-hidden border-2 border-white flex-shrink-0">
                                <img src="{{ asset('storage/'.auth()->user()->profile_image) }}" alt="Profile" class="w-full h-full object-cover">
                            </div>
                        @else
                            <!-- Default Profile Icon -->
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        @endif
                    </button>
                    <!-- Dropdown Menu -->
                    <div id="profile-dropdown" class="absolute right-0 top-full mt-2 w-48 bg-white rounded-md shadow-lg hidden z-50" style="transition: none !important; animation: none !important;">
                        <div class="py-2" style="transition: none !important; animation: none !important;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800" style="transition: none !important; transform: none !important; animation: none !important; background-color: transparent !important;">Profile</a>
                            @if(auth()->user()->role === 'user')
                                <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-gray-800" style="transition: none !important; transform: none !important; animation: none !important; background-color: transparent !important;">Pesanan Saya</a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-gray-800" style="transition: none !important; transform: none !important; animation: none !important; background-color: transparent !important;">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const profileButton = document.getElementById('profile-button');
                    const profileDropdown = document.getElementById('profile-dropdown');
                    
                    if (profileButton && profileDropdown) {
                        profileButton.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();
                            profileDropdown.classList.toggle('hidden');
                        });
                        
                        // Close dropdown when clicking outside
                        document.addEventListener('click', function(e) {
                            if (!profileButton.contains(e.target) && !profileDropdown.contains(e.target)) {
                                profileDropdown.classList.add('hidden');
                            }
                        });
                    }

                    // Setup CSRF token for AJAX requests
                    const token = document.querySelector('meta[name="csrf-token"]');
                    if (token) {
                        window.Laravel = {
                            csrfToken: token.content
                        };
                    }

                    // Handle logout form submission with fresh CSRF token
                    const logoutForm = document.querySelector('form[action*="logout"]');
                    if (logoutForm) {
                        logoutForm.addEventListener('submit', function(e) {
                            // Get fresh CSRF token if needed
                            const csrfInput = this.querySelector('input[name="_token"]');
                            if (csrfInput && token) {
                                csrfInput.value = token.content;
                            }
                        });
                    }
                });
                </script>
            @else
                <!-- Login/Register Links -->
                <a href="{{ route('login') }}" class="text-white border px-2 sm:px-3 py-1 rounded hover:bg-white/10 text-sm flex-shrink-0">Login</a>
                <a href="{{ route('register') }}" class="text-white border px-2 sm:px-3 py-1 rounded hover:bg-white/10 text-sm flex-shrink-0">Register</a>
            @endauth
        </div>
    </div>

    <!-- Mobile Navigation Menu - Hidden by default -->
    <div id="mobile-menu" class="hidden xl:hidden bg-[#A38560] mx-6 rounded-b-3xl -mt-1">
        <div class="px-6 py-4 border-t border-[#390517]/20">
            <div class="flex flex-col gap-3">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <!-- Admin Mobile Navigation -->
                        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">📦 Kelola Produk</a>
                        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">📋 Kelola Pesanan</a>
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">🏠 Lihat Toko</a>
                    @else
                        <!-- User Mobile Navigation -->
                        <a href="{{ route('kemeja') }}" class="{{ Route::currentRouteName() == 'kemeja' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">T-Shirts</a>
                        <a href="{{ route('kaos') }}" class="{{ Route::currentRouteName() == 'kaos' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">Shirts</a>
                        <a href="{{ route('pants') }}" class="{{ Route::currentRouteName() == 'pants' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">Pants</a>
                        <a href="{{ route('jaket') }}" class="{{ Route::currentRouteName() == 'jaket' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">Outerwear</a>
                    @endif
                @else
                    <!-- Guest Mobile Navigation -->
                    <a href="{{ route('kemeja') }}" class="{{ Route::currentRouteName() == 'kemeja' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">T-Shirts</a>
                    <a href="{{ route('kaos') }}" class="{{ Route::currentRouteName() == 'kaos' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">Shirts</a>
                    <a href="{{ route('pants') }}" class="{{ Route::currentRouteName() == 'pants' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">Pants</a>
                    <a href="{{ route('jaket') }}" class="{{ Route::currentRouteName() == 'jaket' ? 'text-[#E0E0E0]' : 'text-[#390517]' }} font-bold hover:opacity-75 py-2 transition-opacity">Outerwear</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Mobile Search Dropdown - Hidden by default -->
    <div id="mobile-search" class="hidden lg:hidden bg-[#A38560] mx-6 rounded-b-3xl -mt-1">
        <div class="px-6 py-3 border-t border-[#390517]/20">
            <form method="GET" action="{{ route('home') }}" class="relative flex items-center">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="Cari produk..." 
                    value="{{ request('search') }}"
                    class="px-3 py-2 pr-12 rounded-full border-none focus:outline-none focus:ring-2 focus:ring-white/50 text-gray-800 w-full bg-[#E0E0E0]"
                >
                <button type="submit" class="absolute right-2 p-2 hover:opacity-75">
                    <img src="{{ asset('images/Search-Icon.png') }}" alt="Search" class="w-5 h-5">
                </button>
            </form>
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get elements
    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileSearchToggle = document.getElementById('mobile-search-toggle');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileSearch = document.getElementById('mobile-search');

    // Check if elements exist before adding event listeners
    if (mobileMenuToggle && mobileMenu) {
        // Toggle mobile menu
        mobileMenuToggle.addEventListener('click', function() {
            console.log('Hamburger clicked!'); // Debug log
            
            // Close search if open
            if (mobileSearch) {
                mobileSearch.classList.add('hidden');
            }
            
            // Toggle menu
            mobileMenu.classList.toggle('hidden');
        });
    }

    if (mobileSearchToggle && mobileSearch) {
        // Toggle mobile search
        mobileSearchToggle.addEventListener('click', function() {
            console.log('Search toggle clicked!'); // Debug log
            
            // Close menu if open
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
            }
            
            // Toggle search
            mobileSearch.classList.toggle('hidden');
        });
    }

    // Close mobile menus when window is resized to desktop
    window.addEventListener('resize', function() {
        if (window.innerWidth >= 1280) { // xl breakpoint
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
            }
        }
        if (window.innerWidth >= 1024) { // lg breakpoint
            if (mobileSearch) {
                mobileSearch.classList.add('hidden');
            }
        }
    });
    
    // Full Sentence Typing Animation
    const fullText = "Dress with confidence, redefine your style with ";
    const changingWords = ['timeless', 'luxury', 'precision', 'comfort', 'purpose'];
    let currentWordIndex = 0;
    
    const animatedTextEl = document.getElementById('full-animated-text');
    
    function typeFullSentence(callback) {
        console.log('typeFullSentence started - typing:', fullText);
        let i = 0;
        animatedTextEl.innerHTML = '';
        
        const typeInterval = setInterval(() => {
            if (i < fullText.length) {
                animatedTextEl.innerHTML = `<span style="font-family: 'Cinzel', serif; font-weight: bold; color: #E0E0E0;">${fullText.substring(0, i + 1)}</span>`;
            } else {
                // Start typing the changing word in colored span with different font
                const wordIndex = i - fullText.length;
                const currentWord = changingWords[currentWordIndex];
                
                if (wordIndex <= currentWord.length) {
                    const typedWord = currentWord.substring(0, wordIndex);
                    animatedTextEl.innerHTML = `<span style="font-family: 'Cinzel', serif; font-weight: bold; color: #E0E0E0;">${fullText}</span><span class="text-[#A38560]" style="font-family: 'Sloop Script Bold Two', cursive; font-size: 1.2em; font-weight: normal;">${typedWord}</span>`;
                } else {
                    // Finished typing complete sentence
                    clearInterval(typeInterval);
                    setTimeout(callback, 2000); // Wait 2 seconds before changing word
                }
            }
            i++;
        }, 80); // Typing speed
    }
    
    function changeWord(callback) {
        const currentWord = changingWords[currentWordIndex];
        console.log('changeWord called for:', currentWord, 'index:', currentWordIndex);
        
        // Check if this is the last word ("purpose") - if so, erase everything and restart
        if (currentWordIndex === changingWords.length - 1) {
            console.log('Last word reached, will erase everything and restart');
            // First erase "purpose" word
            let eraseWordIndex = currentWord.length;
            const eraseWordInterval = setInterval(() => {
                const remainingWord = currentWord.substring(0, eraseWordIndex);
                animatedTextEl.innerHTML = `<span style="font-family: 'Cinzel', serif; font-weight: bold; color: #E0E0E0;">${fullText}</span><span class="text-[#A38560]" style="font-family: 'Sloop Script Bold Two', cursive; font-size: 1.2em; font-weight: normal;">${remainingWord}</span>`;
                eraseWordIndex--;
                
                if (eraseWordIndex < 0) {
                    clearInterval(eraseWordInterval);
                    
                    // Now erase the full sentence character by character
                    let eraseFullIndex = fullText.length;
                    const eraseFullInterval = setInterval(() => {
                        const remainingFullText = fullText.substring(0, eraseFullIndex);
                        animatedTextEl.innerHTML = `<span style="font-family: 'Cinzel', serif; font-weight: bold; color: #E0E0E0;">${remainingFullText}</span>`;
                        eraseFullIndex--;
                        
                        if (eraseFullIndex < 0) {
                            clearInterval(eraseFullInterval);
                            // Reset and restart full animation
                            currentWordIndex = 0;
                            console.log('Everything erased, restarting animation...');
                            setTimeout(callback, 1000);
                        }
                    }, 60);
                }
            }, 60);
        } else {
            // Normal word change (not last word)
            console.log('Normal word change, erasing and typing next');
            let eraseIndex = currentWord.length;
            
            // Erase current word
            const eraseInterval = setInterval(() => {
                const remainingWord = currentWord.substring(0, eraseIndex);
                animatedTextEl.innerHTML = `<span style="font-family: 'Cinzel', serif; font-weight: bold; color: #E0E0E0;">${fullText}</span><span class="text-[#A38560]" style="font-family: 'Sloop Script Bold Two', cursive; font-size: 1.2em; font-weight: normal;">${remainingWord}</span>`;
                eraseIndex--;
                
                if (eraseIndex < 0) {
                    clearInterval(eraseInterval);
                    // Move to next word
                    currentWordIndex++;
                    
                    // Type new word
                    const newWord = changingWords[currentWordIndex];
                    let typeIndex = 0;
                    
                    const typeNewInterval = setInterval(() => {
                        const typedNewWord = newWord.substring(0, typeIndex + 1);
                        animatedTextEl.innerHTML = `<span style="font-family: 'Cinzel', serif; font-weight: bold; color: #E0E0E0;">${fullText}</span><span class="text-[#A38560]" style="font-family: 'Sloop Script Bold Two', cursive; font-size: 1.2em; font-weight: normal;">${typedNewWord}</span>`;
                        typeIndex++;
                        
                        if (typeIndex === newWord.length) {
                            clearInterval(typeNewInterval);
                            setTimeout(() => {
                                changeWord(callback);
                            }, 2000); // Wait before next word change
                        }
                    }, 80);
                }
            }, 60);
        }
    }
    
    function startFullAnimation() {
        console.log('startFullAnimation called - clearing text and starting typing');
        // Clear everything first
        animatedTextEl.innerHTML = '';
        
        typeFullSentence(() => {
            console.log('typeFullSentence finished, starting word changes');
            changeWord(startFullAnimation);
        });
    }
    
    // Start animation when page loads
    console.log('DOM loaded, looking for element...');
    
    if (animatedTextEl) {
        console.log('✅ Element found! Starting with empty content');
        
        // Start animation immediately with a small delay to ensure page is fully loaded
        setTimeout(() => {
            try {
                console.log('🚀 Starting animation now!');
                startFullAnimation();
            } catch (error) {
                console.error('❌ Animation error:', error);
            }
        }, 500); // Reduced to 0.5 seconds for faster start
    } else {
        console.error('❌ ERROR: Element #full-animated-text not found!');
        console.log('Available elements with id:', document.querySelectorAll('[id]'));
    }
    
    // Navbar Scroll Animation
    const navbar = document.getElementById('navbar');
    let lastScrollTop = 0;
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > 50) {
            // Scrolled down - add rounded style and margins
            navbar.classList.add('rounded-3xl', 'mt-6', 'mx-6');
            navbar.classList.remove('mt-0', 'mx-0');
        } else {
            // At top - remove rounded style and margins
            navbar.classList.remove('rounded-3xl', 'mt-6', 'mx-6');
            navbar.classList.add('mt-0', 'mx-0');
        }
        
        lastScrollTop = scrollTop;
    });

    // Handle back button navigation to prevent flash messages from showing
    if (window.performance && window.performance.navigation.type === 2) {
        // This is a back navigation, reload to clear flash messages
        window.location.reload(true);
        return; // Exit early to prevent toast from showing
    }

    // Cart Success Toast Control
    const cartSuccessToast = document.getElementById('cartSuccessToast');
    
    if (cartSuccessToast) {
        // Show toast with slide-in animation
        setTimeout(() => {
            cartSuccessToast.classList.remove('translate-x-full');
            cartSuccessToast.classList.add('translate-x-0');
        }, 300);
        
        // Auto hide after 3 seconds
        setTimeout(() => {
            closeCartToast();
        }, 3000);
    }

    // Handle pageshow event for back button
    window.addEventListener('pageshow', function(event) {
        // Check if page was loaded from cache (back button)
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            // Refresh the page to clear any flash messages
            window.location.reload(true);
        }
    });
});

// Cart Toast Close Function
function closeCartToast() {
    const cartSuccessToast = document.getElementById('cartSuccessToast');
    if (cartSuccessToast) {
        // Slide out to the right
        cartSuccessToast.classList.remove('translate-x-0');
        cartSuccessToast.classList.add('translate-x-full');
        
        // Remove element after animation completes
        setTimeout(() => {
            if (cartSuccessToast.parentNode) {
                cartSuccessToast.remove();
            }
        }, 500);
    }
}
</script>

<style>
/* Full Text Typing Animation Styles */
#full-animated-text {
    display: inline-block;
    min-height: 1em;
}

/* Navbar Scroll Animation Styles */
#navbar {
    transition: all 0.3s ease-in-out;
}

/* Navbar default state (top of page) */
#navbar.mt-0 {
    margin-top: 0;
    margin-left: 0;
    margin-right: 0;
    border-radius: 0;
}

/* Navbar scrolled state */
#navbar.rounded-3xl {
    border-radius: 1.5rem;
}

#navbar.mt-6 {
    margin-top: 1.5rem;
}

#navbar.mx-6 {
    margin-left: 1.5rem;
    margin-right: 1.5rem;
}

/* Responsive text sizes */
@media (max-width: 640px) {
    .typing-text {
        min-width: 150px;
    }
}
</style>

  <!-- Cart Success Toast -->
  @if(session('cart_success'))
  <div id="cartSuccessToast" class="fixed top-4 right-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-4 rounded-lg shadow-xl transform translate-x-full transition-transform duration-500 z-50 max-w-sm">
      <div class="flex items-center gap-3">
          <div class="flex-shrink-0">
              <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
              </svg>
          </div>
          <div>
              <div class="font-bold text-sm">Berhasil Ditambahkan!</div>
              <div class="text-xs opacity-90">Produk telah masuk ke keranjang</div>
          </div>
          <button onclick="closeCartToast()" class="ml-auto flex-shrink-0 text-white hover:text-gray-200">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
          </button>
      </div>
  </div>
  @endif

  <!-- Generic Toast (used for actions like password reset) -->
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

  <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8 w-full flex-1">
    @if(session('error'))   <div class="mb-3 p-3 bg-red-500/20 rounded border border-red-500/30 text-sm sm:text-base" style="color: #E0E0E0;">{{ session('error') }}</div>   @endif
    
    @yield('content')
  </main>

    @php
      // Deteksi apakah halaman berada di dalam /admin/*
      $isAdminPage = request()->is('admin/*');
  @endphp

  @if (!$isAdminPage)
      <footer class="bg-[#A38560] text-[#390517] text-center py-6 rounded-t-[2rem]">
          <div class="max-w-6xl mx-auto px-4">
              <!-- Tentang GayaKu -->
              <p class="text-lg font-semibold mb-4">Tentang Gayaku.id</p>
              <p class="mb-6">
                  Gayaku.id adalah platform e-commerce yang mendukung produk lokal UMKM dengan kualitas terbaik.
                  Temukan berbagai pilihan fashion unik dan berkualitas dari para pengrajin Indonesia,
                  langsung dari rumah ke gaya hidupmu.
              </p>
              
              <!-- Garis Pembatas -->
              <hr class="border-[#390517]/30 mb-6">
              
              <!-- Kontak dan Social Media -->
              <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                  <!-- Kontak Kami -->
                  <div class="text-center">
                      <p class="font-semibold mb-2">Kontak Kami</p>
                      <p>WA: 082145676556</p>
                      <p>Email: Gayaku.id@gmail.com</p>
                  </div>
                  
                  <!-- Ikuti Kami -->
                  <div class="text-center">
                      <p class="font-semibold mb-2">Ikuti Kami</p>
                      <div class="flex justify-center gap-6">
                          <a href="#" class="hover:opacity-75 transition-opacity">
                              <img src="{{ asset('images/IGLogo.png') }}" alt="Instagram" class="w-8 h-8">
                          </a>
                          <a href="#" class="hover:opacity-75 transition-opacity">
                              <img src="{{ asset('images/FBLogo.png') }}" alt="Facebook" class="w-8 h-8">
                          </a>
                          <a href="#" class="hover:opacity-75 transition-opacity">
                              <img src="{{ asset('images/XLogo.png') }}" alt="Twitter" class="w-8 h-8">
                          </a>
                          <a href="#" class="hover:opacity-75 transition-opacity">
                              <img src="{{ asset('images/TTLogo.png') }}" alt="TikTok" class="w-8 h-8">
                          </a>
                      </div>
                  </div>
              </div>

              <!-- Copyright -->
              <p>© Gayaku.id 2025, Company</p>
          </div>
      </footer>
  @endif

</body>
@stack('scripts')
</html>
