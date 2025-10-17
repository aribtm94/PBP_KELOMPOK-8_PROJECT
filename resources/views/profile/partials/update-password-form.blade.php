<form method="post" action="{{ route('password.update') }}" class="space-y-6">
    @csrf
    @method('put')

    <!-- Flash Messages -->
    @if(session('status') === 'password-updated')
        <div class="bg-green-500/20 border border-green-500/30 p-3 rounded-lg">
            <p class="text-green-100 text-sm">Password updated successfully!</p>
        </div>
    @endif

    <div class="space-y-4">
        <div>
            <label for="current_password" class="block text-sm font-medium text-[#FBF2E3] mb-2">Current Password</label>
            <input id="current_password" name="current_password" type="password" 
                   class="w-full px-4 py-3 bg-[#FBF2E3] border border-[#A38560] rounded-lg text-[#390517] focus:ring-2 focus:ring-[#A38560] focus:border-transparent"
                   autocomplete="current-password">
            @if($errors->updatePassword->has('current_password'))
                <p class="mt-1 text-sm text-red-300">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-[#FBF2E3] mb-2">New Password</label>
            <input id="password" name="password" type="password" 
                   class="w-full px-4 py-3 bg-[#FBF2E3] border border-[#A38560] rounded-lg text-[#390517] focus:ring-2 focus:ring-[#A38560] focus:border-transparent"
                   autocomplete="new-password">
            @if($errors->updatePassword->has('password'))
                <p class="mt-1 text-sm text-red-300">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-[#FBF2E3] mb-2">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" 
                   class="w-full px-4 py-3 bg-[#FBF2E3] border border-[#A38560] rounded-lg text-[#390517] focus:ring-2 focus:ring-[#A38560] focus:border-transparent"
                   autocomplete="new-password">
            @if($errors->updatePassword->has('password_confirmation'))
                <p class="mt-1 text-sm text-red-300">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>
    </div>

    <div class="flex justify-end mt-6">
        <button type="submit" class="bg-[#A38560] hover:bg-[#8B7355] text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
            Update Password
        </button>
    </div>
</form>
