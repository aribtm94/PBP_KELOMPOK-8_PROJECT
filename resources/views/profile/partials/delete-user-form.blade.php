<div class="space-y-4">
    <p class="text-red-100 text-sm">
        Before deleting your account, please download any data or information that you wish to retain.
    </p>

    <button type="button" 
            onclick="openDeleteModal()"
            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200">
        Delete Account
    </button>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Are you sure you want to delete your account?</h3>
        
        <p class="text-sm text-gray-600 mb-4">
            Once your account is deleted, all of its resources and data will be permanently deleted. 
            Please enter your password to confirm you would like to permanently delete your account.
        </p>

        <form method="post" action="{{ route('profile.destroy') }}">
            @csrf
            @method('delete')

            <div class="mb-4">
                <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input id="delete_password" name="password" type="password" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                       placeholder="Enter your password">
                @if($errors->userDeletion->has('password'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" 
                        onclick="closeDeleteModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded-lg transition-colors">
                    Cancel
                </button>
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                    Delete Account
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('delete_password').value = '';
}

// Close modal if clicked outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});

// Show modal if there are validation errors
@if($errors->userDeletion->isNotEmpty())
    document.addEventListener('DOMContentLoaded', function() {
        openDeleteModal();
    });
@endif
</script>
