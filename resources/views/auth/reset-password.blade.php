<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/assets/Logo.png') }}" alt="Salon Logo" class="h-16 w-auto">
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Reset Password</h2>
            <p class="text-sm text-gray-600 text-center mb-6">
                {{ __('Please enter your new password below.') }}
            </p>

            <!-- Display all validation errors -->
            @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}" x-data="{
        email: '{{ $request->email ?? old('email') }}',
        password: '',
        password_confirmation: '',
        showPassword: false,
        showPasswordConfirmation: false,
        get isComplete() {
            return this.email.trim() !== '' &&
                   this.password.trim() !== '' &&
                   this.password_confirmation.trim() !== '' &&
                   this.password === this.password_confirmation;
        }
    }">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email field (readonly) -->
                <div class="relative mb-4" x-data="{ focused: false }">
                    <input type="email" name="email" id="email" x-model="email"
                        @focus="focused = true"
                        @blur="focused = false"
                        class="peer w-full px-4 py-3 border border-gray-300 rounded-md focus:border-primary focus:ring-1 focus:ring-primary bg-gray-50"
                        placeholder=" " required readonly>
                    <label for="email"
                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none
                               peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-gray-500
                               peer-focus:top-0 peer-focus:text-xs peer-focus:text-primary"
                        :class="{ 'top-0 text-xs text-primary': email.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': email.trim() === '' && !focused }">
                        Email
                    </label>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password field with peek -->
                <div class="relative mb-4" x-data="{ focused: false }">
                    <input type="password" name="password" id="password" x-model="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                        @focus="focused = true"
                        @blur="focused = false"
                        class="peer w-full px-4 py-3 pr-10 border border-gray-300 rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                        placeholder=" " required>
                    <label for="password"
                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none
                               peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-gray-500
                               peer-focus:top-0 peer-focus:text-xs peer-focus:text-primary"
                        :class="{ 'top-0 text-xs text-primary': password.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': password.trim() === '' && !focused }">
                        New Password
                    </label>
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <!-- SVG icons (keep as before) -->
                    </button>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password field with peek -->
                <div class="relative mb-4" x-data="{ focused: false }">
                    <input type="password" name="password_confirmation" id="password_confirmation" x-model="password_confirmation"
                        x-bind:type="showPasswordConfirmation ? 'text' : 'password'"
                        @focus="focused = true"
                        @blur="focused = false"
                        class="peer w-full px-4 py-3 pr-10 border border-gray-300 rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                        placeholder=" " required>
                    <label for="password_confirmation"
                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none
                               peer-placeholder-shown:top-1/2 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:text-gray-500
                               peer-focus:top-0 peer-focus:text-xs peer-focus:text-primary"
                        :class="{ 'top-0 text-xs text-primary': password_confirmation.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': password_confirmation.trim() === '' && !focused }">
                        Confirm Password
                    </label>
                    <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation" class="absolute inset-y-0 right-0 flex items-center pr-3">
                        <!-- SVG icons -->
                    </button>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Client-side password match error -->
                <div x-show="password_confirmation.trim() !== '' && password !== password_confirmation" class="text-sm text-red-600 mt-1">
                    Passwords do not match.
                </div>

                <div class="flex items-center justify-between mt-4">
                    <a href="{{ route('login') }}" class="text-sm text-primary hover:text-primary-dark">
                        ← Back to Login
                    </a>
                    <x-primary-button class="bg-primary hover:bg-primary-dark focus:ring-primary" x-bind:disabled="!isComplete">
                        {{ __('Reset Password') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>