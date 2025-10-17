<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-6">
    @csrf
    @method('patch')

    <!-- Flash Messages -->
    @if(session('status') === 'profile-updated')
        <div class="bg-green-500/20 border border-green-500/30 p-3 rounded-lg">
            <p class="text-green-100 text-sm">Profile updated successfully!</p>
        </div>
    @endif

    <div class="grid md:grid-cols-2 gap-6">
        <div>
            <label for="name" class="block text-sm font-medium text-[#FBF2E3] mb-2">Full Name</label>
            <input id="name" name="name" type="text" 
                   class="w-full px-4 py-3 bg-[#FBF2E3] border border-[#A38560] rounded-lg text-[#390517] focus:ring-2 focus:ring-[#A38560] focus:border-transparent" 
                   value="{{ old('name', $user->name) }}" required autofocus>
            @if($errors->has('name'))
                <p class="mt-1 text-sm text-red-300">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-[#FBF2E3] mb-2">Email Address</label>
            <input id="email" name="email" type="email" 
                   class="w-full px-4 py-3 bg-[#FBF2E3] border border-[#A38560] rounded-lg text-[#390517] focus:ring-2 focus:ring-[#A38560] focus:border-transparent" 
                   value="{{ old('email', $user->email) }}" required>

            @if($errors->has('email'))
                <p class="mt-1 text-sm text-red-300">{{ $errors->first('email') }}</p>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 bg-yellow-500/20 border border-yellow-500/30 rounded-lg">
                    <p class="text-sm text-yellow-100">
                        Your email address is unverified.
                        <button form="send-verification" class="underline hover:no-underline">
                            Click here to re-send the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-200">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
            Save Changes
        </button>
    </div>
</form>
