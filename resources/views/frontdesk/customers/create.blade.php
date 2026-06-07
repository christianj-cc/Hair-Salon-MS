@extends('layouts.frontdesk')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('frontdesk.customers.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Add New Customer</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form id="createCustomerForm" method="POST" action="{{ route('frontdesk.customers.store') }}" enctype="multipart/form-data"
            x-data="{
                first_name: '{{ old('first_name') }}',
                last_name: '{{ old('last_name') }}',
                email: '{{ old('email') }}',
                mobile_num: '{{ old('mobile_num') }}',
                birthdate: '{{ old('birthdate') }}',
                gender: '{{ old('gender') }}',
                password: '',
                password_confirmation: '',
                showPassword: false,
                showPasswordConfirmation: false,

                mobileError: '',
                emailError: '',
                passwordError: '',
                passwordConfirmError: '',

                get isComplete() {
                    return this.first_name.trim() !== '' &&
                        this.last_name.trim() !== '' &&
                        this.email.trim() !== '' &&
                        this.mobile_num.trim() !== '' &&
                        this.birthdate.trim() !== '' &&
                        this.gender !== '' &&
                        this.password.trim() !== '' &&
                        this.password_confirmation.trim() !== '';
                },

                validateMobile() {
                    const mobile = this.mobile_num;
                    if (mobile === '') {
                        this.mobileError = '';
                    } else if (!/^\d{11}$/.test(mobile)) {
                        this.mobileError = 'Mobile number must be exactly 11 digits.';
                    } else {
                        this.mobileError = '';
                    }
                },
                validateEmail() {
                    const email = this.email;
                    if (email === '') {
                        this.emailError = '';
                    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                        this.emailError = 'Please enter a valid email address.';
                    } else {
                        this.emailError = '';
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
                clearMobileError() { this.mobileError = ''; },
                clearEmailError() { this.emailError = ''; },
                clearPasswordError() { this.passwordError = ''; },
                clearPasswordConfirmError() { this.passwordConfirmError = ''; }
            }">
            @csrf

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column: Image Upload & Preview (optional) -->
                <div class="lg:w-1/3">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <label for="image" class="cursor-pointer block">
                            <div id="previewContainer" class="mb-4 flex justify-center">
                                <img id="preview" src="#" alt="Preview" class="max-w-full max-h-64 object-contain hidden">
                                <div id="placeholder" class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">Click to upload profile photo (optional)</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF (max 2MB)</p>
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden">
                        @error('image') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Right Column: Form Fields -->
                <div class="lg:w-2/3">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- First Name -->
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                            <input type="text" name="first_name" id="first_name" x-model="first_name" value="{{ old('first_name') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" required>
                            @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Last Name -->
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                            <input type="text" name="last_name" id="last_name" x-model="last_name" value="{{ old('last_name') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" required>
                            @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" placeholder="example@gmail.com" x-model="email"
                                @blur="validateEmail()" @focus="clearEmailError()"
                                :class="emailError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                            <div x-show="emailError" x-text="emailError" class="text-red-500 text-xs mt-1"></div>
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Mobile Number (required) -->
                        <div>
                            <label for="mobile_num" class="block text-sm font-medium text-gray-700">Mobile Number (11-digit) <span class="text-red-500">*</span></label>
                            <input type="tel" name="mobile_num" id="mobile_num" x-model="mobile_num"
                                @blur="validateMobile()" @focus="clearMobileError()"
                                :class="mobileError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                maxlength="11" pattern="[0-9]*" inputmode="numeric"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                            <div x-show="mobileError" x-text="mobileError" class="text-red-500 text-xs mt-1"></div>
                            @error('mobile_num') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Birthdate (required) -->
                        <div>
                            <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate <span class="text-red-500">*</span></label>
                            <input type="date" name="birthdate" id="birthdate" x-model="birthdate" value="{{ old('birthdate') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                            @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Gender (required) -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                            <select name="gender" id="gender" x-model="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                            <div class="relative mt-1">
                                <input type="password" name="password" id="password" x-model="password"
                                    x-bind:type="showPassword ? 'text' : 'password'"
                                    @blur="validatePassword()" @focus="clearPasswordError()"
                                    :class="passwordError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary pr-10" required>
                                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg x-show="!showPassword" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPassword" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <div x-show="passwordError" x-text="passwordError" class="text-red-500 text-xs mt-1"></div>
                            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                            <div class="relative mt-1">
                                <input type="password" name="password_confirmation" id="password_confirmation" x-model="password_confirmation"
                                    x-bind:type="showPasswordConfirmation ? 'text' : 'password'"
                                    @blur="validatePasswordConfirm()" @focus="clearPasswordConfirmError()"
                                    :class="passwordConfirmError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary pr-10" required>
                                <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg x-show="!showPasswordConfirmation" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg x-show="showPasswordConfirmation" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>
                            <div x-show="passwordConfirmError" x-text="passwordConfirmError" class="text-red-500 text-xs mt-1"></div>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('frontdesk.customers.index') }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Cancel</a>
                        <button type="button"
                            class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!isComplete"
                            @click="confirmAction('Create Customer', 'Are you sure you want to create this customer?', '#createCustomerForm', 'POST', 'Create', true)">
                            Create Customer
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    });
</script>
@endsection