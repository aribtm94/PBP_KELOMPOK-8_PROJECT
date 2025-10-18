<x-guest-layout>
    <div class="flex justify-center items-center min-h-screen px-4 py-8 bg-[#16302B]">
        <div class="max-w-4xl w-full rounded-xl relative">
            <div class="w-full mx-auto p-6 sm:p-8 bg-[#A38560] flex flex-col justify-center rounded-[2rem] h-auto">
                <h3 class="text-white text-xl sm:text-2xl font-bold mb-4 text-center">Reset Password</h3>

                <p class="text-white text-sm text-center mb-4">Masukkan email yang terdaftar, kami akan mengirimkan tautan untuk mereset password Anda.</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4 text-white text-sm text-center" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="mx-auto w-full sm:w-3/4">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <input id="email" class="block mt-1 w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 px-4 py-3" type="email" name="email" :value="old('email')" placeholder="Email" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-white text-sm" />
                    </div>

                    <div class="flex items-center justify-center gap-3 mt-4">
                        <button type="submit" class="bg-white text-[#390517] rounded-xl px-4 sm:px-6 py-2 sm:py-2.5 hover:bg-gray-200 font-semibold text-sm w-full sm:w-auto min-w-[160px] text-center inline-flex items-center justify-center transition ease-in-out duration-150">
                            {{ __('Email Password Reset Link') }}
                        </button>

                        <a href="{{ route('login') }}" class="text-white underline hover:opacity-80 text-sm flex items-center">&larr; Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
