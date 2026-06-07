<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/assets/Logo.png') }}" alt="Logo" class="h-16 w-auto">
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Set Your Password</h2>
            <p class="text-sm text-gray-600 text-center mb-6">
                Please choose a password for your account. We recommend a strong, unique password.
            </p>

            <form method="POST" action="{{ route('invitation.accept', $token) }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" value="{{ $email }}" disabled class="mt-1 block w-full bg-gray-100 border-gray-300 rounded-md">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required class="mt-1 block w-full border-gray-300 rounded-md">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full border-gray-300 rounded-md">
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark">
                        Activate Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>