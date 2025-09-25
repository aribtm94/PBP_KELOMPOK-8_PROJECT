<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="flex justify-center items-center min-h-screen px-4 py-8 bg-[#16302B]">
            <div class="flex flex-col sm:flex-row max-w-4xl w-full rounded-xl relative min-h-[600px]">
                <!-- Form Register (Kiri) -->
                <div class="w-full sm:w-1/2 p-6 sm:p-8 bg-[#390517] flex flex-col rounded-[2rem] sm:-mr-20 relative z-30 min-h-[600px]">
                    <div class="w-full max-w-md mx-auto flex-1 flex flex-col justify-center">
                        <h2 class="text-[#A38560] text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-center mb-6 transition-all duration-300">Create Account</h2>

                        <!-- Name -->
                        <div class="mb-4">
                            <input id="name" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3" 
                                   type="text" name="name" value="{{ old('name') }}" 
                                   placeholder="Full Name" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mb-4">
                            <input id="email" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3" 
                                   type="email" name="email" value="{{ old('email') }}" 
                                   placeholder="Email Address" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <input id="password" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3" 
                                   type="password" name="password" placeholder="Password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <input id="password_confirmation" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3" 
                                   type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="flex items-center mb-4">
                            <input type="checkbox" class="mr-2 rounded-[6px]" required>
                            <span class="text-[#A38560] text-xs font-bold">I agree to the <a href="#" class="underline">terms of service</a> and <a href="#" class="underline">privacy policy</a></span>
                        </div>

                        <!-- Sign Up Button -->
                        <div class="mt-6">
                            <button type="submit" class="block w-full bg-white text-[#A38560] rounded-xl px-4 py-3 hover:bg-gray-200 font-bold text-md text-center transition ease-in-out duration-150">
                                Sign Up
                            </button>
                        </div>

                        <!-- Sign Up With Section -->
                        <div class="flex items-center justify-center mt-6">
                            <hr class="flex-1 border-[#A38560] border-t">
                            <span class="text-[#A38560] text-sm px-4">Or Sign Up With</span>
                            <hr class="flex-1 border-[#A38560] border-t">
                        </div>

                        <!-- Google Sign Up Button -->
                        <div class="flex justify-center mt-4">
                            <button class="bg-white rounded-full p-3 hover:shadow-lg transition-all duration-200 border border-gray-200">
                                <img src="{{ asset('images/googleLogo.png') }}" alt="Google Logo" class="w-6 h-6">
                            </button>
                        </div>

                        <!-- Already Have an Account Section -->
                        <div class="flex justify-center items-center gap-2 mt-6">
                            <span class="text-[#AAA2A2] text-sm">Already Have an Account?</span>
                            <a href="{{ route('login') }}" class="text-[#A38560] underline text-sm font-semibold hover:text-gray-200 transition-colors">Sign In</a>
                        </div>
                    </div>
                </div>

                <!-- Right Side Text Box (Kanan) -->
                <div class="w-full sm:w-1/2 p-6 sm:p-8 sm:pl-28 bg-[#E0E0E0] flex flex-col rounded-[2rem] relative z-20 min-h-[600px]">
                    <div class="w-full max-w-md mx-auto flex-1 flex flex-col justify-center">
                        <!-- Brand di pojok kanan atas - hanya muncul di desktop -->
                        <div class="hidden sm:block absolute top-6 sm:top-8 right-6 sm:right-8 transition-all duration-300">
                            <h4 class="text-[#390517] text-sm sm:text-base md:text-lg font-bold transition-all duration-300">gayaKu.id</h4>
                            <p class="text-[#390517] text-xs transition-all duration-300">"temukan sesuai gayamu"</p>
                        </div>
                        
                        <div class="text-center pl-0 mt-6">
                        <!-- Brand untuk mobile - di atas welcome text -->
                        <div class="block sm:hidden mb-4">
                            <h4 class="text-[#A38560] text-sm font-bold">gayaKu.id</h4>
                            <p class="text-[#390517] text-xs">"temukan sesuai gayamu"</p>
                        </div>
                        
                        <h2 class="text-[#A38560] text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold transition-all duration-300">Beli UMKM Lokal,</h2>
                        <h1 class="text-[#A38560] text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold transition-all duration-300">Sesuai Gayamu</h1>
                        <p class="text-[#390517] mt-2 sm:mt-4 text-xs xs:text-sm sm:text-sm md:text-sm lg:text-base xl:text-lg break-words leading-tight sm:leading-relaxed word-break overflow-wrap-anywhere max-w-full transition-all duration-300 font-bold">Produk Unik, Untuk Gaya Kamu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-guest-layout>
