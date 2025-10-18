<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <!-- Flash Messages -->
    @if(session('status') === 'profile-updated')
        <div class="bg-green-500/20 border border-green-500/30 p-3 rounded-lg">
            <p class="text-green-100 text-sm">Profile updated successfully!</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Left: Fields -->
        <div class="md:col-span-2 space-y-5">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-[#FBF2E3] mb-2">Username</label>
                    <input id="username" name="username" type="text" 
                           class="w-full px-4 py-3 bg-[#FBF2E3] border border-[#A38560] rounded-lg text-[#390517] focus:ring-2 focus:ring-[#A38560] focus:border-transparent" 
                           value="{{ old('username', $user->username) }}">
                    @error('username')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-[#FBF2E3] mb-2">Name</label>
                    <input id="name" name="name" type="text" 
                           class="w-full px-4 py-3 bg-[#FBF2E3] border border-[#A38560] rounded-lg text-[#390517] focus:ring-2 focus:ring-[#A38560] focus:border-transparent" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-[#FBF2E3] mb-2">Email</label>
                    <input id="email" name="email" type="email" 
                           class="w-full px-4 py-3 bg-[#FBF2E3] border border-[#A38560] rounded-lg text-[#390517] focus:ring-2 focus:ring-[#A38560] focus:border-transparent" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-[#FBF2E3] mb-2">Phone Number</label>
                    <input id="phone" name="phone" type="text" 
                           class="w-full px-4 py-3 bg-[#FBF2E3] border border-[#A38560] rounded-lg text-[#390517] focus:ring-2 focus:ring-[#A38560] focus:border-transparent" 
                           value="{{ old('phone', $user->phone) }}">
                    @error('phone')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <span class="block text-sm font-medium text-[#FBF2E3] mb-2">Gender</span>
                    <div class="flex items-center gap-6 text-[#FBF2E3]">
                        <label class="flex items-center gap-2">
                            <input type="radio" name="gender" value="male" class="text-[#A38560] focus:ring-[#A38560]" {{ old('gender', $user->gender) == 'male' ? 'checked' : '' }}>
                            <span>Male</span>
                        </label>
                        <label class="flex items-center gap-2">
                            <input type="radio" name="gender" value="female" class="text-[#A38560] focus:ring-[#A38560]" {{ old('gender', $user->gender) == 'female' ? 'checked' : '' }}>
                            <span>Female</span>
                        </label>
                    </div>
                    @error('gender')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-[#FBF2E3] mb-2">Date of Birth</label>
                    <input id="date_of_birth" name="date_of_birth" type="date" 
                           class="w-full px-4 py-3 bg-[#FBF2E3] border border-[#A38560] rounded-lg text-[#390517] focus:ring-2 focus:ring-[#A38560] focus:border-transparent" 
                           value="{{ old('date_of_birth', $user->date_of_birth) }}">
                    @error('date_of_birth')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Email Verification Notice -->
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="p-4 bg-yellow-500/20 border border-yellow-500/30 rounded-lg">
                    <p class="text-sm text-yellow-100 mb-2">
                        Your email address is unverified.
                    </p>
                    <button form="send-verification" 
                            class="bg-yellow-600 hover:bg-yellow-700 text-white text-sm px-4 py-2 rounded-lg transition-colors">
                        Click here to re-send the verification email
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm text-green-200">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Right: Avatar -->
        <div class="md:col-span-1">
            <div class="flex flex-col items-center gap-4">
                <img src="{{ $user->avatar_path ? asset('storage/'.$user->avatar_path) : 'https://placehold.co/160x160?text=Avatar' }}" 
                     alt="avatar" 
                     class="w-40 h-40 rounded-full object-cover bg-[#FBF2E3]/40">
                <label class="w-full">
                    <span class="sr-only">Choose avatar</span>
                    <input type="file" name="avatar" accept="image/png,image/jpeg" 
                           class="block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-[#A38560] file:text-white hover:file:bg-[#8B7355]">
                </label>
                <p class="text-xs text-[#FBF2E3]/70">File size: max 1 MB • JPEG, PNG</p>
                @error('avatar')<p class="mt-1 text-sm text-red-300">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
            Save Changes
        </button>
    </div>
</form>
