@php
$layout = match(Auth::user()->role) {
'manager' => 'layouts.admin',
'frontdesk' => 'layouts.frontdesk',
'tech' => 'layouts.tech',
default => 'layouts.customer',
};
$containerClass = Auth::user()->role == 'customer' ? 'max-w-6xl mx-auto mt-8' : 'max-w-8xl mx-auto';
@endphp

@extends($layout)

@section('content')
<div class="py-2">
    <div class="{{ $containerClass }}">
        <div class="flex justify-between items-center mb-6 mt-1">
            <h1 class="text-2xl font-semibold text-gray-900">My Account</h1>
        </div>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <form id="profileForm" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6"
                    x-data="{
                        first_name: '{{ old('first_name', $profile ? $profile->first_name : '') }}',
                        last_name: '{{ old('last_name', $profile ? $profile->last_name : '') }}',
                        name: '{{ old('name', $user->name) }}',
                        email: '{{ old('email', $user->email) }}',
                        mobile_num: '{{ old('mobile_num', $profile ? $profile->mobile_num : '') }}',
                        birthdate: '{{ old('birthdate', $profile ? $profile->birthdate?->format('Y-m-d') : '') }}',
                        gender: '{{ old('gender', $profile ? $profile->gender : '') }}',
                        password: '',
                        password_confirmation: '',
                        showPassword: false,
                        showPasswordConfirmation: false,
                        firstNameError: '',
                        lastNameError: '',
                        emailError: '',
                        mobileError: '',
                        birthdateError: '',
                        genderError: '',
                        passwordError: '',
                        passwordConfirmError: '',

                        get isFormValid() {
                            // Required fields: first_name, last_name, name, email, mobile_num, birthdate, gender
                            if (!this.first_name.trim() || !this.last_name.trim() || !this.name.trim() || !this.email.trim()) return false;
                            if (!this.mobile_num.trim()) return false;
                            if (!this.birthdate.trim()) return false;
                            if (!this.gender) return false;
                            // Mobile must be exactly 11 digits
                            if (!/^\d{11}$/.test(this.mobile_num.trim())) return false;
                            // If password is entered, it must be >=8 chars and match confirmation
                            if (this.password.trim()) {
                                if (this.password.length < 8) return false;
                                if (this.password !== this.password_confirmation) return false;
                            }
                            // No active errors
                            return !this.firstNameError && !this.lastNameError && !this.emailError && !this.mobileError && !this.birthdateError && !this.genderError && !this.passwordError && !this.passwordConfirmError;
                        },

                        validateFirstName() {
                            const val = this.first_name.trim();
                            if (val === '') {
                                this.firstNameError = 'First name is required.';
                            } else if (!/^[\p{L}\s]+$/u.test(val)) {
                                this.firstNameError = 'First name may only contain letters and spaces.';
                            } else {
                                this.firstNameError = '';
                            }
                        },
                        validateLastName() {
                            const val = this.last_name.trim();
                            if (val === '') {
                                this.lastNameError = 'Last name is required.';
                            } else if (!/^[\p{L}\s]+$/u.test(val)) {
                                this.lastNameError = 'Last name may only contain letters and spaces.';
                            } else {
                                this.lastNameError = '';
                            }
                        },
                        validateEmail() {
                            const email = this.email.trim();
                            if (email === '') {
                                this.emailError = 'Email is required.';
                            } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                                this.emailError = 'Please enter a valid email address.';
                            } else {
                                this.emailError = '';
                            }
                        },
                        validateMobile() {
                            const mobile = this.mobile_num.trim();
                            if (mobile === '') {
                                this.mobileError = 'Mobile number is required.';
                            } else if (!/^\d{11}$/.test(mobile)) {
                                this.mobileError = 'Mobile number must be exactly 11 digits.';
                            } else {
                                this.mobileError = '';
                            }
                        },
                        validateBirthdate() {
                            const bdate = this.birthdate;
                            if (!bdate) {
                                this.birthdateError = 'Birthdate is required.';
                            } else {
                                this.birthdateError = '';
                            }
                        },
                        validateGender() {
                            if (!this.gender) {
                                this.genderError = 'Gender is required.';
                            } else {
                                this.genderError = '';
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
                        clearBirthdateError() { this.birthdateError = ''; },
                        clearGenderError() { this.genderError = ''; },
                        clearPasswordError() { this.passwordError = ''; },
                        clearPasswordConfirmError() { this.passwordConfirmError = ''; }
                    }">
                    @csrf
                    <input type="hidden" name="_method" value="PATCH">

                    <!-- Container 1: Profile Image (centered, larger) -->
                    <div class="flex flex-col items-center bg-gray-50 rounded-lg p-6">
                        <div class="h-32 w-32 rounded-full overflow-hidden bg-gray-200">
                            @if($profile && image_exists($profile->image))
                            <img src="{{ asset('storage/' . $profile->image) }}" alt="Profile" class="h-full w-full object-cover">
                            @else
                            <div class="h-full w-full flex items-center justify-center">
                                <svg class="h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            @endif
                        </div>
                        <div class="mt-4">
                            <label for="image" class="cursor-pointer inline-flex items-center px-4 py-2 bg-primary text-white rounded-md hover:bg-primary-dark transition">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Choose Photo
                            </label>
                            <input type="file" name="image" id="image" accept="image/*" class="hidden">
                        </div>
                        @error('image') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>

                    <!-- Container 2: Personal Information -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="first_name" id="first_name"
                                    x-model="first_name"
                                    @blur="validateFirstName()"
                                    @focus="clearFirstNameError()"
                                    :class="firstNameError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="mt-1 block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                                <div x-show="firstNameError" x-text="firstNameError" class="text-red-500 text-xs mt-1"></div>
                                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="last_name" id="last_name"
                                    x-model="last_name"
                                    @blur="validateLastName()"
                                    @focus="clearLastNameError()"
                                    :class="lastNameError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="mt-1 block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                    oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')">
                                <div x-show="lastNameError" x-text="lastNameError" class="text-red-500 text-xs mt-1"></div>
                                @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Full Name (Display) -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Full Name (Display) <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" x-model="name"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Role (read-only) -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                                <input type="text" id="role" value="{{ ucfirst($user->role) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm bg-gray-100" readonly disabled>
                            </div>
                            <!-- Mobile Number -->
                            <div>
                                <label for="mobile_num" class="block text-sm font-medium text-gray-700">Mobile Number <span class="text-red-500">*</span></label>
                                <input type="tel" name="mobile_num" id="mobile_num"
                                    x-model="mobile_num"
                                    @blur="validateMobile()"
                                    @focus="clearMobileError()"
                                    :class="mobileError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="mt-1 block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                    maxlength="11" pattern="[0-9]*" inputmode="numeric"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
                                <div x-show="mobileError" x-text="mobileError" class="text-red-500 text-xs mt-1"></div>
                                @error('mobile_num') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Birthdate -->
                            <div>
                                <label for="birthdate" class="block text-sm font-medium text-gray-700">Birthdate <span class="text-red-500">*</span></label>
                                <input type="date" name="birthdate" id="birthdate"
                                    x-model="birthdate"
                                    @blur="validateBirthdate()"
                                    @focus="clearBirthdateError()"
                                    :class="birthdateError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="mt-1 block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                <div x-show="birthdateError" x-text="birthdateError" class="text-red-500 text-xs mt-1"></div>
                                @error('birthdate') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Gender -->
                            <div>
                                <label for="gender" class="block text-sm font-medium text-gray-700">Gender <span class="text-red-500">*</span></label>
                                <select name="gender" id="gender"
                                    x-model="gender"
                                    @blur="validateGender()"
                                    @focus="clearGenderError()"
                                    :class="genderError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="mt-1 block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                    <option value="">Select</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                                <div x-show="genderError" x-text="genderError" class="text-red-500 text-xs mt-1"></div>
                                @error('gender') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Container 3: Account Information -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" id="email"
                                    x-model="email"
                                    @blur="validateEmail()"
                                    @focus="clearEmailError()"
                                    :class="emailError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="mt-1 block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary">
                                <div x-show="emailError" x-text="emailError" class="text-red-500 text-xs mt-1"></div>
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- New Password (optional) -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">New Password (optional)</label>
                                <div class="relative mt-1">
                                    <input type="password" name="password" id="password"
                                        x-model="password"
                                        @blur="validatePassword()"
                                        @focus="clearPasswordError()"
                                        :class="passwordError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                        class="block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary pr-10">
                                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg x-show="!showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <div x-show="passwordError" x-text="passwordError" class="text-red-500 text-xs mt-1"></div>
                                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <div class="relative mt-1">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        x-model="password_confirmation"
                                        @blur="validatePasswordConfirm()"
                                        @focus="clearPasswordConfirmError()"
                                        :class="passwordConfirmError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                        class="block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary pr-10">
                                    <button type="button" @click="showPasswordConfirmation = !showPasswordConfirmation" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg x-show="!showPasswordConfirmation" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showPasswordConfirmation" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <div x-show="passwordConfirmError" x-text="passwordConfirmError" class="text-red-500 text-xs mt-1"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="button"
                            :disabled="!isFormValid"
                            @click="if (isFormValid) confirmAction('Update Profile', 'Are you sure you want to save your changes?', '#profileForm', 'POST', 'Save')"
                            class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // This script is only for the image preview (keep your existing image preview logic)
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        // If you want to update the preview image dynamically, you can add a preview element.
        // For simplicity, we keep the existing behaviour. If you need preview, extend accordingly.
    });
</script>
@endsection