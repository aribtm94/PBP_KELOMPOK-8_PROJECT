<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="flex justify-center items-center min-h-screen px-4 py-8 bg-[#16302B]">
            <div class="flex flex-col sm:flex-row max-w-4xl w-full rounded-xl relative h-96">
                <!-- Kotak Teks (Kiri) -->
                <div class="w-full sm:w-1/2 p-6 sm:p-8 sm:pr-16 bg-[#E0E0E0] flex flex-col justify-center rounded-[2rem] sm:-ml-4 relative z-20 h-full">
                    <!-- Brand di pojok kiri atas - hanya muncul di desktop -->
                    <div class="hidden sm:block absolute top-4 left-6 sm:left-8 transition-all duration-300">
                        <h4 class="text-[#390517] text-sm sm:text-base md:text-lg font-bold transition-all duration-300">gayaKu.id</h4>
                        <p class="text-[#390517] text-xs transition-all duration-300">"temukan sesuai gayamu"</p>
                    </div>
                    
                    <div class="text-left pl-0 pr-0 sm:pr-12">
                        <!-- Brand untuk mobile - di atas welcome text -->
                        <div class="block sm:hidden mb-4">
                            <h4 class="text-[#390517] text-sm font-bold">gayaKu.id</h4>
                            <p class="text-[#390517] text-xs">"temukan sesuai gayamu"</p>
                        </div>
                        
                        <h2 class="text-[#390517] text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold transition-all duration-300">Hello,</h2>
                        <h2 class="text-[#390517] text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold transition-all duration-300">welcome!</h2>
                        <p class="text-[#390517] mt-2 sm:mt-4 text-xs xs:text-sm sm:text-sm md:text-sm lg:text-base xl:text-lg break-words leading-tight sm:leading-relaxed word-break overflow-wrap-anywhere max-w-full sm:max-w-[100%] transition-all duration-300">Yuk, masuk dan temukan produk keren yang pas dengan gayamu!</p>
                    </div>
                </div>

                <!-- Kotak Form Login (Kanan) - Same Width -->
                <div class="w-full sm:w-1/2 p-6 sm:p-8 bg-[#A38560] flex flex-col justify-center rounded-[2rem] sm:-ml-20 relative z-50 h-full">
                <h3 class="text-white text-xl sm:text-2xl font-bold mb-6 text-center">Log In</h3>

                <!-- Email Address (Rounded Box) -->
                <div class="mb-4">
                    <input id="email" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3" 
                           type="email" name="email" value="{{ old('email') }}" 
                           placeholder="Email" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password (Rounded Box) -->
                <div class="mb-4">
                    <input id="password" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3" 
                           type="password" name="password" placeholder="Password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-white">{{ __('Remember me') }}</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-white underline hover:opacity-80">{{ __('Forgot your password?') }}</a>
                    @endif
                </div>

                <!-- Login & Sign Up Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-3 mt-6 px-2">
                    <button type="submit" class="bg-white text-[#390517] rounded-xl px-4 sm:px-6 py-2 sm:py-2.5 hover:bg-gray-200 font-semibold text-sm w-full sm:w-auto min-w-[80px] sm:min-w-[100px] text-center inline-flex items-center justify-center transition ease-in-out duration-150">
                        {{ __('Log in') }}
                    </button>
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="bg-transparent border-2 border-white text-white rounded-xl px-3 sm:px-5 py-1.5 sm:py-2 hover:bg-white hover:text-[#390517] font-semibold text-sm w-full sm:w-auto min-w-[80px] sm:min-w-[100px] text-center inline-flex items-center justify-center transition ease-in-out duration-150">
                            {{ __('Sign Up') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
