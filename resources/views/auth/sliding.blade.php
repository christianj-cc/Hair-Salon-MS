<x-guest-layout>
    <div class="min-h-screen" x-data="{
        active: localStorage.getItem('authActive') || '{{ $initial }}',
        init() {
            this.$watch('active', val => localStorage.setItem('authActive', val));
        }
    }">
        <!-- Desktop Layout (hidden on mobile) -->
        <div class="hidden md:flex min-h-screen relative">
            <!-- Login Form -->
            <div class="w-1/2 flex items-center justify-center p-8 bg-white">
                @if(session('status'))
                <div class="mb-4 p-2 bg-green-100 border border-green-400 text-green-700 rounded text-sm text-center">
                    {{ session('status') }}
                </div>
                @endif
                <div class="w-full max-w-md">
                    <div class="flex justify-center items-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/assets/Logo.png') }}" alt="Logo" class="h-16 object-cover">
                        </a>
                    </div>
                    <p class="text-gray-600 mt-4 mb-6 text-center">Sign in to your account</p>

                    <form method="POST" action="{{ route('login') }}" x-data="{
                            email: '{{ old('email') }}',
                            password: '',
                            showPassword: false,
                            get isComplete() { return this.email.trim() !== '' && this.password.trim() !== ''; }
                        }">
                        @csrf
                        <div class="space-y-4">
                            <!-- Email field -->
                            <div class="relative" x-data="{ focused: false }">
                                <input type="email" name="email" id="email_login" x-model="email"
                                    @focus="focused = true"
                                    @blur="focused = false"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                    placeholder=" " required autofocus>
                                <label for="email_login"
                                    class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                    :class="{ '-top-2 text-xs text-primary': email.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': email.trim() === '' && !focused }">
                                    Email
                                </label>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password field with peek -->
                            <div class="relative" x-data="{ focused: false }">
                                <input type="password" name="password" id="password_login" x-model="password"
                                    x-bind:type="showPassword ? 'text' : 'password'"
                                    @focus="focused = true"
                                    @blur="focused = false"
                                    class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                    placeholder=" " required autocomplete="off">
                                <label for="password_login"
                                    class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                    :class="{ '-top-2 text-xs text-primary': password.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': password.trim() === '' && !focused }">
                                    Password
                                </label>
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <!-- Eye open -->
                                    <svg x-show="!showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <!-- Eye closed -->
                                    <svg x-show="showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-between">
                                <label for="remember_me" class="inline-flex items-center">
                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary" name="remember">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                </label>
                                @if (Route::has('password.request'))
                                <a class="text-sm text-primary hover:text-primary-dark" href="{{ route('password.request') }}">
                                    {{ __('Forgot password?') }}
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full py-3 px-4 bg-primary text-white rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="!isComplete">
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Register Form (with real‑time validation) -->
            <div class="w-1/2 flex items-center justify-center p-8 bg-white">
                <div class="w-full max-w-md">
                    <div class="flex justify-center items-center">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('storage/assets/Logo.png') }}" alt="Logo" class="h-16 object-cover">
                        </a>
                    </div>
                    <p class="text-gray-600 mt-4 mb-6 text-center">Fill in your details</p>

                    <form method="POST" action="{{ route('register') }}" x-data="{
                            first_name: '{{ old('first_name') }}',
                            last_name: '{{ old('last_name') }}',
                            email: '{{ old('email') }}',
                            mobile_num: '{{ old('mobile_num') }}',
                            password: '',
                            password_confirmation: '',
                            showPassword: false,
                            showPasswordConfirmation: false,
                            firstNameError: '',
                            lastNameError: '',
                            emailError: '',
                            mobileError: '',
                            passwordError: '',
                            passwordConfirmError: '',
                            get isComplete() {
                                return this.first_name.trim() !== '' &&
                                    this.last_name.trim() !== '' &&
                                    this.email.trim() !== '' &&
                                    this.mobile_num.trim() !== '' &&
                                    this.password.trim() !== '' &&
                                    this.password_confirmation.trim() !== '' &&
                                    !this.firstNameError && !this.lastNameError && !this.emailError && !this.mobileError && !this.passwordError && !this.passwordConfirmError;
                            },
                            validateFirstName() {
                                const val = this.first_name.trim();
                                if (val === '') {
                                    this.firstNameError = 'First name is required.';
                                } else if (!/^[\p{L}\s]+$/u.test(val)) {
                                    this.firstNameError = 'Only letters and spaces allowed.';
                                } else {
                                    this.firstNameError = '';
                                }
                            },
                            validateLastName() {
                                const val = this.last_name.trim();
                                if (val === '') {
                                    this.lastNameError = 'Last name is required.';
                                } else if (!/^[\p{L}\s]+$/u.test(val)) {
                                    this.lastNameError = 'Only letters and spaces allowed.';
                                } else {
                                    this.lastNameError = '';
                                }
                            },
                            validateEmail() {
                                const email = this.email.trim();
                                if (email === '') {
                                    this.emailError = 'Email is required.';
                                } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                                    this.emailError = 'Invalid email format.';
                                } else {
                                    this.emailError = '';
                                }
                            },
                            validateMobile() {
                                const mobile = this.mobile_num.trim();
                                if (mobile === '') {
                                    this.mobileError = 'Mobile number is required.';
                                } else if (!/^\d{11}$/.test(mobile)) {
                                    this.mobileError = 'Mobile must be exactly 11 digits.';
                                } else {
                                    this.mobileError = '';
                                }
                            },
                            validatePassword() {
                                const pwd = this.password;
                                if (pwd !== '' && pwd.length < 8) {
                                    this.passwordError = 'Password must be at least 8 characters.';
                                } else {
                                    this.passwordError = '';
                                }
                                this.validatePasswordConfirm();
                            },
                            validatePasswordConfirm() {
                                if (this.password_confirmation !== '' && this.password !== this.password_confirmation) {
                                    this.passwordConfirmError = 'Passwords do not match.';
                                } else {
                                    this.passwordConfirmError = '';
                                }
                            },
                            clearFirstNameError() { this.firstNameError = ''; },
                            clearLastNameError() { this.lastNameError = ''; },
                            clearEmailError() { this.emailError = ''; },
                            clearMobileError() { this.mobileError = ''; },
                            clearPasswordError() { this.passwordError = ''; },
                            clearPasswordConfirmError() { this.passwordConfirmError = ''; }
                        }" autocomplete="off">
                        @csrf
                        <div class="grid grid-cols-1 gap-4">
                            <!-- First & Last Name -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative" x-data="{ focused: false }">
                                    <input type="text" name="first_name" id="first_name" x-model="first_name"
                                        @focus="focused = true; clearFirstNameError()"
                                        @blur="focused = false; validateFirstName()"
                                        :class="firstNameError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                        class="w-full px-4 py-3 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                        placeholder=" " required
                                        oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                                    <label for="first_name"
                                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                        :class="{ '-top-2 text-xs text-primary': first_name.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': first_name.trim() === '' && !focused }">
                                        First Name <span class="text-red-500">*</span>
                                    </label>
                                    <div x-show="firstNameError" x-text="firstNameError" class="text-red-500 text-xs mt-1"></div>
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>
                                <div class="relative" x-data="{ focused: false }">
                                    <input type="text" name="last_name" id="last_name" x-model="last_name"
                                        @focus="focused = true; clearLastNameError()"
                                        @blur="focused = false; validateLastName()"
                                        :class="lastNameError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                        class="w-full px-4 py-3 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                        placeholder=" " required
                                        oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                                    <label for="last_name"
                                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                        :class="{ '-top-2 text-xs text-primary': last_name.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': last_name.trim() === '' && !focused }">
                                        Last Name <span class="text-red-500">*</span>
                                    </label>
                                    <div x-show="lastNameError" x-text="lastNameError" class="text-red-500 text-xs mt-1"></div>
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="relative" x-data="{ focused: false }">
                                <input type="email" name="email" id="email_reg" x-model="email"
                                    @focus="focused = true; clearEmailError()"
                                    @blur="focused = false; validateEmail()"
                                    :class="emailError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="w-full px-4 py-3 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                    placeholder=" " required>
                                <label for="email_reg"
                                    class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                    :class="{ '-top-2 text-xs text-primary': email.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': email.trim() === '' && !focused }">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <div x-show="emailError" x-text="emailError" class="text-red-500 text-xs mt-1"></div>
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Mobile Number -->
                            <div class="relative" x-data="{ focused: false }">
                                <input type="tel" name="mobile_num" id="mobile_num" x-model="mobile_num"
                                    @focus="focused = true; clearMobileError()"
                                    @blur="focused = false; validateMobile()"
                                    :class="mobileError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="w-full px-4 py-3 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                    placeholder=" " required maxlength="11"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                <label for="mobile_num"
                                    class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                    :class="{ '-top-2 text-xs text-primary': mobile_num.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': mobile_num.trim() === '' && !focused }">
                                    Mobile Number (11-digit) <span class="text-red-500">*</span>
                                </label>
                                <div x-show="mobileError" x-text="mobileError" class="text-red-500 text-xs mt-1"></div>
                                <x-input-error :messages="$errors->get('mobile_num')" class="mt-2" />
                            </div>

                            <!-- Password & Confirmation -->
                            <div class="grid grid-cols-2 gap-4">
                                <div class="relative" x-data="{ focused: false }">
                                    <input type="password" name="password" id="password_reg" x-model="password"
                                        x-bind:type="showPassword ? 'text' : 'password'"
                                        @focus="focused = true; clearPasswordError()"
                                        @blur="focused = false; validatePassword()"
                                        :class="passwordError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                        class="w-full px-4 py-3 pr-10 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                        placeholder=" " required>
                                    <label for="password_reg"
                                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                        :class="{ '-top-2 text-xs text-primary': password.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': password.trim() === '' && !focused }">
                                        Password <span class="text-red-500">*</span>
                                    </label>
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg x-show="!showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                    <div x-show="passwordError" x-text="passwordError" class="text-red-500 text-xs mt-1"></div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div class="relative" x-data="{ focused: false }">
                                    <input type="password" name="password_confirmation" id="password_confirmation" x-model="password_confirmation"
                                        x-bind:type="showPasswordConfirmation ? 'text' : 'password'"
                                        @focus="focused = true; clearPasswordConfirmError()"
                                        @blur="focused = false; validatePasswordConfirm()"
                                        :class="passwordConfirmError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                        class="w-full px-4 py-3 pr-10 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                        placeholder=" " required>
                                    <label for="password_confirmation"
                                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                        :class="{ '-top-2 text-xs text-primary': password_confirmation.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': password_confirmation.trim() === '' && !focused }">
                                        Confirm Password <span class="text-red-500">*</span>
                                    </label>
                                    <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg x-show="!showPasswordConfirmation" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPasswordConfirmation" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                    <div x-show="passwordConfirmError" x-text="passwordConfirmError" class="text-red-500 text-xs mt-1"></div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                        <div class="mt-6">
                            <button type="submit"
                                class="w-full py-3 px-4 bg-primary text-white rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                                :disabled="!isComplete">
                                Register
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sliding Overlay -->
            <div x-data="{ withTransition: false }" x-init="setTimeout(() => withTransition = true, 100)"
                :class="[
                    'absolute top-0 left-0 w-1/2 h-full bg-cover bg-center shadow-2xl',
                    withTransition ? 'transition-transform duration-500 ease-in-out' : '',
                    active === 'login' ? 'translate-x-full' : 'translate-x-0'
                ]"
                style="background-image: url('https://images.unsplash.com/photo-1562322140-8baeececf3df?ixlib=rb-4.0.3&auto=format&fit=crop&w=1769&q=80');">
                <div class="h-full w-full bg-black bg-opacity-40 flex flex-col items-center justify-center text-white p-8">
                    <h1 class="text-4xl text-center font-bold mb-6 mt-15" x-text="active === 'login' ? 'New here?' : 'Welcome back!'"></h1>
                    <p class="text-lg text-center mb-6 mt-15" x-text="active === 'login' ? 'Create an account to book appointments.' : 'Already have an account?'"></p>
                    <button @click="active = active === 'login' ? 'register' : 'login'" class="px-8 py-3 border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-gray-900 transition min-w-[200px]">
                        <span x-text="active === 'login' ? 'Sign Up' : 'Sign In'"></span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Layout (with same persistent tab and real‑time validation) -->
        <div class="md:hidden flex flex-col min-h-screen">
            <div class="flex-1 flex items-center justify-center p-8 bg-white">
                <div class="w-full max-w-md">
                    <!-- Login Form (mobile) -->
                    <div x-show="active === 'login'" x-transition>
                        <div class="flex justify-center items-center">
                            <img src="{{ asset('storage/assets/Logo.png') }}" alt="Logo" class="h-16 object-cover">
                        </div>
                        <p class="text-gray-600 mt-4 mb-6 text-center">Sign in to your account</p>
                        <form method="POST" action="{{ route('login') }}" x-data="{
                                email: '{{ old('email') }}',
                                password: '',
                                showPassword: false,
                                get isComplete() { return this.email.trim() !== '' && this.password.trim() !== ''; }
                            }">
                            @csrf
                            <div class="space-y-4">
                                <div class="relative" x-data="{ focused: false }">
                                    <input type="email" name="email" id="email_login_mobile" x-model="email"
                                        @focus="focused = true" @blur="focused = false"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                        placeholder=" " required autofocus>
                                    <label for="email_login_mobile"
                                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                        :class="{ '-top-2 text-xs text-primary': email.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': email.trim() === '' && !focused }">
                                        Email
                                    </label>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="relative" x-data="{ focused: false }">
                                    <input type="password" name="password" id="password_login_mobile" x-model="password"
                                        x-bind:type="showPassword ? 'text' : 'password'"
                                        @focus="focused = true" @blur="focused = false"
                                        class="w-full px-4 py-3 pr-10 border border-gray-300 rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                        placeholder=" " required autocomplete="off">
                                    <label for="password_login_mobile"
                                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                        :class="{ '-top-2 text-xs text-primary': password.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': password.trim() === '' && !focused }">
                                        Password
                                    </label>
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <!-- Eye icons (same as above) -->
                                    </button>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div class="flex items-center justify-between">
                                    <label for="remember_me" class="inline-flex items-center">
                                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary" name="remember">
                                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                                    </label>
                                    @if (Route::has('password.request'))
                                    <a class="text-sm text-primary hover:text-primary-dark" href="{{ route('password.request') }}">Forgot password?</a>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full py-3 px-4 bg-primary text-white rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                                    :disabled="!isComplete">
                                    Sign in
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Register Form (mobile) with real‑time validation (same as desktop) -->
                    <div x-show="active === 'register'" x-transition>
                        <div class="flex justify-center items-center">
                            <img src="{{ asset('storage/assets/Logo.png') }}" alt="Logo" class="h-16 object-cover">
                        </div>
                        <p class="text-gray-600 mt-4 mb-6 text-center">Fill in your details</p>
                        <form method="POST" action="{{ route('register') }}" x-data="{
                                first_name: '{{ old('first_name') }}',
                                last_name: '{{ old('last_name') }}',
                                email: '{{ old('email') }}',
                                mobile_num: '{{ old('mobile_num') }}',
                                password: '',
                                password_confirmation: '',
                                showPassword: false,
                                showPasswordConfirmation: false,
                                firstNameError: '',
                                lastNameError: '',
                                emailError: '',
                                mobileError: '',
                                passwordError: '',
                                passwordConfirmError: '',
                                get isComplete() {
                                    return this.first_name.trim() !== '' &&
                                        this.last_name.trim() !== '' &&
                                        this.email.trim() !== '' &&
                                        this.mobile_num.trim() !== '' &&
                                        this.password.trim() !== '' &&
                                        this.password_confirmation.trim() !== '' &&
                                        !this.firstNameError && !this.lastNameError && !this.emailError && !this.mobileError && !this.passwordError && !this.passwordConfirmError;
                                },
                                validateFirstName() {
                                    const val = this.first_name.trim();
                                    if (val === '') this.firstNameError = 'First name is required.';
                                    else if (!/^[\p{L}\s]+$/u.test(val)) this.firstNameError = 'Only letters and spaces allowed.';
                                    else this.firstNameError = '';
                                },
                                validateLastName() {
                                    const val = this.last_name.trim();
                                    if (val === '') this.lastNameError = 'Last name is required.';
                                    else if (!/^[\p{L}\s]+$/u.test(val)) this.lastNameError = 'Only letters and spaces allowed.';
                                    else this.lastNameError = '';
                                },
                                validateEmail() {
                                    const email = this.email.trim();
                                    if (email === '') this.emailError = 'Email is required.';
                                    else if (!/^\S+@\S+\.\S+$/.test(email)) this.emailError = 'Invalid email format.';
                                    else this.emailError = '';
                                },
                                validateMobile() {
                                    const mobile = this.mobile_num.trim();
                                    if (mobile === '') this.mobileError = 'Mobile number is required.';
                                    else if (!/^\d{11}$/.test(mobile)) this.mobileError = 'Mobile must be exactly 11 digits.';
                                    else this.mobileError = '';
                                },
                                validatePassword() {
                                    const pwd = this.password;
                                    if (pwd !== '' && pwd.length < 8) this.passwordError = 'Password must be at least 8 characters.';
                                    else this.passwordError = '';
                                    this.validatePasswordConfirm();
                                },
                                validatePasswordConfirm() {
                                    if (this.password_confirmation !== '' && this.password !== this.password_confirmation) {
                                        this.passwordConfirmError = 'Passwords do not match.';
                                    } else {
                                        this.passwordConfirmError = '';
                                    }
                                },
                                clearFirstNameError() { this.firstNameError = ''; },
                                clearLastNameError() { this.lastNameError = ''; },
                                clearEmailError() { this.emailError = ''; },
                                clearMobileError() { this.mobileError = ''; },
                                clearPasswordError() { this.passwordError = ''; },
                                clearPasswordConfirmError() { this.passwordConfirmError = ''; }
                            }" autocomplete="off">
                            @csrf
                            <div class="grid grid-cols-1 gap-4">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative" x-data="{ focused: false }">
                                        <input type="text" name="first_name" id="first_name_mobile" x-model="first_name"
                                            @focus="focused = true; clearFirstNameError()"
                                            @blur="focused = false; validateFirstName()"
                                            :class="firstNameError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                            class="w-full px-4 py-3 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                            placeholder=" " required
                                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                                        <label for="first_name_mobile"
                                            class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                            :class="{ '-top-2 text-xs text-primary': first_name.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': first_name.trim() === '' && !focused }">
                                            First Name <span class="text-red-500">*</span>
                                        </label>
                                        <div x-show="firstNameError" x-text="firstNameError" class="text-red-500 text-xs mt-1"></div>
                                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                    </div>
                                    <div class="relative" x-data="{ focused: false }">
                                        <input type="text" name="last_name" id="last_name_mobile" x-model="last_name"
                                            @focus="focused = true; clearLastNameError()"
                                            @blur="focused = false; validateLastName()"
                                            :class="lastNameError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                            class="w-full px-4 py-3 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                            placeholder=" " required
                                            oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                                        <label for="last_name_mobile"
                                            class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                            :class="{ '-top-2 text-xs text-primary': last_name.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': last_name.trim() === '' && !focused }">
                                            Last Name <span class="text-red-500">*</span>
                                        </label>
                                        <div x-show="lastNameError" x-text="lastNameError" class="text-red-500 text-xs mt-1"></div>
                                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="relative" x-data="{ focused: false }">
                                    <input type="email" name="email" id="email_reg_mobile" x-model="email"
                                        @focus="focused = true; clearEmailError()"
                                        @blur="focused = false; validateEmail()"
                                        :class="emailError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                        class="w-full px-4 py-3 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                        placeholder=" " required>
                                    <label for="email_reg_mobile"
                                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                        :class="{ '-top-2 text-xs text-primary': email.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': email.trim() === '' && !focused }">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <div x-show="emailError" x-text="emailError" class="text-red-500 text-xs mt-1"></div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="relative" x-data="{ focused: false }">
                                    <input type="tel" name="mobile_num" id="mobile_num_mobile" x-model="mobile_num"
                                        @focus="focused = true; clearMobileError()"
                                        @blur="focused = false; validateMobile()"
                                        :class="mobileError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                        class="w-full px-4 py-3 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                        placeholder=" " required maxlength="11"
                                        oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                    <label for="mobile_num_mobile"
                                        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                        :class="{ '-top-2 text-xs text-primary': mobile_num.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': mobile_num.trim() === '' && !focused }">
                                        Mobile Number (11-digit) <span class="text-red-500">*</span>
                                    </label>
                                    <div x-show="mobileError" x-text="mobileError" class="text-red-500 text-xs mt-1"></div>
                                    <x-input-error :messages="$errors->get('mobile_num')" class="mt-2" />
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative" x-data="{ focused: false }">
                                        <input type="password" name="password" id="password_reg_mobile" x-model="password"
                                            x-bind:type="showPassword ? 'text' : 'password'"
                                            @focus="focused = true; clearPasswordError()"
                                            @blur="focused = false; validatePassword()"
                                            :class="passwordError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                            class="w-full px-4 py-3 pr-10 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                            placeholder=" " required>
                                        <label for="password_reg_mobile"
                                            class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                            :class="{ '-top-2 text-xs text-primary': password.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': password.trim() === '' && !focused }">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <!-- eye icons -->
                                        </button>
                                        <div x-show="passwordError" x-text="passwordError" class="text-red-500 text-xs mt-1"></div>
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <div class="relative" x-data="{ focused: false }">
                                        <input type="password" name="password_confirmation" id="password_confirmation_mobile" x-model="password_confirmation"
                                            x-bind:type="showPasswordConfirmation ? 'text' : 'password'"
                                            @focus="focused = true; clearPasswordConfirmError()"
                                            @blur="focused = false; validatePasswordConfirm()"
                                            :class="passwordConfirmError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                            class="w-full px-4 py-3 pr-10 border rounded-md focus:border-primary focus:ring-1 focus:ring-primary"
                                            placeholder=" " required>
                                        <label for="password_confirmation_mobile"
                                            class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
                                            :class="{ '-top-2 text-xs text-primary': password_confirmation.trim() !== '' || focused, 'top-1/2 -translate-y-1/2 text-gray-500': password_confirmation.trim() === '' && !focused }">
                                            Confirm Password <span class="text-red-500">*</span>
                                        </label>
                                        <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                            <!-- eye icons -->
                                        </button>
                                        <div x-show="passwordConfirmError" x-text="passwordConfirmError" class="text-red-500 text-xs mt-1"></div>
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="mt-6">
                                <button type="submit"
                                    class="w-full py-3 px-4 bg-primary text-white rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                                    :disabled="!isComplete">
                                    Register
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="sticky bottom-0 z-10 flex justify-center space-x-4 py-4 bg-white border-t border-gray-200">
                <button @click="active = 'login'" :class="active === 'login' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700'" class="px-6 py-2 rounded-full font-medium transition">Sign In</button>
                <button @click="active = 'register'" :class="active === 'register' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700'" class="px-6 py-2 rounded-full font-medium transition">Sign Up</button>
            </div>
        </div>
    </div>
</x-guest-layout>