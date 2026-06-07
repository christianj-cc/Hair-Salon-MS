<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-10 py-6 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/assets/Logo.png') }}" alt="Salon Logo" class="h-16 w-auto">
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Reset Password</h2>
            <p class="text-sm text-gray-600 text-center mb-6">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" x-data="{ email: '{{ old('email') }}' }">
                @csrf

                <!-- Email field with floating label -->
                <div class="relative" x-data="{ focused: false }">
                    <input type="email" name="email" id="email" x-model="email"
                        @focus="focused = true"
                        @blur="focused = false"
                        class="peer w-full px-4 py-3 border border-gray-300 rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                        placeholder=" " required autofocus>
                    <label for="email"
                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none
                               peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-gray-500
                               peer-focus:top-0 peer-focus:text-xs peer-focus:text-primary"
                        :class="{ 'top-0 text-xs text-primary': email.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': email.trim() === '' && !focused }">
                        Email
                    </label>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-primary hover:text-primary-dark">
                        ← Back to Login
                    </a>
                    <x-primary-button class="bg-primary hover:bg-primary-dark focus:ring-primary" x-bind:disabled="!email.trim()">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>