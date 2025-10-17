@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FBF2E3] py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="text-4xl font-bold text-[#390517] mb-2">Profile Settings</h1>
            <p class="text-[#390517] opacity-70">Manage your account information and preferences</p>
        </div>

        <!-- Profile Information Section -->
        <div class="bg-[#390517] rounded-xl p-6 mb-6 shadow-lg">
            <h2 class="text-2xl font-semibold text-[#FBF2E3] mb-4">Profile Information</h2>
            <p class="text-[#FBF2E3] opacity-70 mb-6">Update your account's profile information and email address.</p>
            
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Password Section -->
        <div class="bg-[#390517] rounded-xl p-6 mb-6 shadow-lg">
            <h2 class="text-2xl font-semibold text-[#FBF2E3] mb-4">Update Password</h2>
            <p class="text-[#FBF2E3] opacity-70 mb-6">Ensure your account is using a long, random password to stay secure.</p>
            
            @include('profile.partials.update-password-form')
        </div>

        <!-- Delete Account Section -->
        <div class="bg-red-900 rounded-xl p-6 shadow-lg">
            <h2 class="text-2xl font-semibold text-red-100 mb-4">Delete Account</h2>
            <p class="text-red-100 opacity-70 mb-6">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
            
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

<script>
// Handle back button navigation to prevent flash messages
document.addEventListener('DOMContentLoaded', function() {
    // Check for back navigation
    if (window.performance && window.performance.navigation.type === 2) {
        // This is a back navigation, reload to clear flash messages
        window.location.reload(true);
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
</script>
@endsection
