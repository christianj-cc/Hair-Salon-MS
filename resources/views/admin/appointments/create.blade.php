@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.appointments.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Create Appointment</h1>
    </div>

    <form id="createAppointmentForm" method="POST" autocomplete="off" action="{{ route('admin.appointments.store') }}"
        x-data="{
            customer_id: '{{ old('customer_id') }}',
            service_id: '{{ old('service_id') }}',
            employee_id: '{{ old('employee_id') }}',
            appointment_date: '{{ old('appointment_date') }}',
            appointment_time: '{{ old('appointment_time') }}',
            payment_method: '{{ old('payment_method', 'cash') }}',
            status: '{{ old('status', 'pending') }}',
            discount_id: '{{ old('discount_id') }}',
            gcash_reference: '{{ old('gcash_reference') }}',
            newCustomer: {{ old('newCustomer') ? 'true' : 'false' }},
            first_name: '{{ old('first_name') }}',
            last_name: '{{ old('last_name') }}',
            new_email: '{{ old('new_email') }}',
            new_mobile: '{{ old('new_mobile') }}',
            new_password: '',
            new_password_confirmation: '',
            showNewPassword: false,
            showNewPasswordConfirmation: false,

            mobileError: '',
            emailError: '',
            passwordError: '',
            passwordConfirmError: '',
            gcashError: '',
            timeError: '',

            get isComplete() {
                // Base conditions
                let baseOk = true;
                if (this.newCustomer) {
                    baseOk = this.first_name.trim() !== '' &&
                            this.last_name.trim() !== '' &&
                            this.new_email.trim() !== '' &&
                            this.new_mobile.trim() !== '' &&
                            this.new_password.trim() !== '' &&
                            this.new_password_confirmation.trim() !== '';
                } else {
                    baseOk = this.customer_id !== '';
                }

                // Additional common conditions
                baseOk = baseOk &&
                        this.service_id !== '' &&
                        this.appointment_date !== '' &&
                        this.appointment_time !== '' &&
                        this.payment_method !== '' &&
                        this.status !== '';

                // GCash extra requirement: non‑empty, exactly 13 digits, digits only
                if (this.payment_method === 'gcash') {
                    const ref = this.gcash_reference.trim();
                    if (ref === '' || !/^\d{13}$/.test(ref)) {
                        return false;
                    }
                }
                if (!this.isValidTime()) return false;

                return baseOk;
            },

            validateMobile() {
                const mobile = this.new_mobile;
                if (mobile === '') {
                    this.mobileError = '';
                } else if (!/^\d{11}$/.test(mobile)) {
                    this.mobileError = 'Mobile number must be exactly 11 digits.';
                } else {
                    this.mobileError = '';
                }
            },
            validateEmail() {
                const email = this.new_email;
                if (email === '') {
                    this.emailError = '';
                } else if (!/^\S+@\S+\.\S+$/.test(email)) {
                    this.emailError = 'Please enter a valid email address.';
                } else {
                    this.emailError = '';
                }
            },
            validatePassword() {
                const pwd = this.new_password;
                if (pwd !== '' && pwd.length < 8) {
                    this.passwordError = 'Password must be at least 8 characters.';
                } else {
                    this.passwordError = '';
                }
                this.validatePasswordConfirm();
            },
            validatePasswordConfirm() {
                if (this.new_password_confirmation !== '' && this.new_password !== this.new_password_confirmation) {
                    this.passwordConfirmError = 'Passwords do not match.';
                } else {
                    this.passwordConfirmError = '';
                }
            },
            validateGcashReference() {
                if (this.payment_method !== 'gcash') {
                    this.gcashError = '';
                    return;
                }
                const ref = this.gcash_reference.trim();
                if (ref === '') {
                    this.gcashError = 'GCash reference number is required.';
                } else if (!/^\d{13}$/.test(ref)) {
                    this.gcashError = 'GCash reference number must be exactly 13 digits.';
                } else {
                    this.gcashError = '';
                }
            },
            validateTime() {
                const time = this.appointment_time;
                if (!time) {
                    this.timeError = '';
                    return;
                }
                // Validate format HH:MM
                const timeRegex = /^([01][0-9]|2[0-3]):[0-5][0-9]$/;
                if (!timeRegex.test(time)) {
                    this.timeError = 'Invalid time format.';
                    return;
                }
                const hour = parseInt(time.split(':')[0]);
                if (hour < 6 || hour > 19) {
                    this.timeError = 'Appointment time must be between 6:00 AM and 7:00 PM.';
                } else {
                    this.timeError = '';
                }
            },
            
            clearMobileError() { this.mobileError = ''; },
            clearEmailError() { this.emailError = ''; },
            clearPasswordError() { this.passwordError = ''; },
            clearPasswordConfirmError() { this.passwordConfirmError = ''; },
            clearGcashError() { this.gcashError = ''; },
            clearTimeError() { this.timeError = ''; },
            
            minDate() {
                let today = new Date();
                return today.toISOString().split('T')[0];
            },
            
            isValidDate() {
                if (!this.appointment_date) return false;
                let selected = new Date(this.appointment_date);
                let min = new Date(this.minDate());
                return selected >= min;
            },
            
            isValidTime() {
                if (!this.appointment_time) return false;
                let time = this.appointment_time;
                let hour = parseInt(time.split(':')[0]);
                return hour >= 6 && hour <= 19;
            },

            init() {
                // When payment method changes, revalidate the GCash reference
                this.$watch('payment_method', () => {
                    this.validateGcashReference();
                });
            }
        }">
        @csrf
        <input type="hidden" name="newCustomer" :value="newCustomer ? 1 : 0">

        <div class="space-y-6">
            <!-- Container 1: Customer Details -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Customer Details</h3>
                </div>
                <div class="p-6">
                    <!-- Toggle for new customer -->
                    <div class="mb-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" x-model="newCustomer" class="rounded border-gray-300 text-primary focus:ring-primary">
                            <span class="ml-2 text-sm text-gray-600">Register New Customer</span>
                        </label>
                    </div>

                    <!-- Existing customer dropdown (hidden when newCustomer is true) -->
                    <div x-show="!newCustomer" x-transition>
                        <label for="customer_id" class="block text-sm font-medium text-gray-700">Select Customer <span class="text-red-500">*</span></label>
                        <select name="customer_id" id="customer_id" x-model="customer_id" x-bind:required="!newCustomer" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                            <option value="">Choose a customer</option>
                            @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->first_name }} {{ $customer->last_name }}</option>
                            @endforeach
                        </select>
                        @error('customer_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- New customer registration form (shown when newCustomer is true) -->
                    <div x-show="newCustomer" x-transition>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- First Name -->
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name <span class="text-red-500">*</span></label>
                                <input type="text" name="first_name" id="first_name" x-model="first_name" x-bind:required="newCustomer" value="{{ old('first_name') }}" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                                @error('first_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Last Name -->
                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name <span class="text-red-500">*</span></label>
                                <input type="text" name="last_name" id="last_name" x-model="last_name" x-bind:required="newCustomer" value="{{ old('last_name') }}" oninput="this.value = this.value.replace(/[^A-Za-z\s]/g, '')" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                                @error('last_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Email -->
                            <div>
                                <label for="new_email" class="block text-sm font-medium text-gray-700">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="new_email" id="new_email" placeholder="example@gmail.com" x-model="new_email"
                                    @blur="validateEmail()" @focus="clearEmailError()"
                                    :class="emailError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="mt-1 block w-full rounded-md shadow-sm focus:ring-primary focus:border-primary">
                                <div x-show="emailError" x-text="emailError" class="text-red-500 text-xs mt-1"></div>
                                @error('new_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Mobile Number -->
                            <div>
                                <label for="new_mobile" class="block text-sm font-medium text-gray-700">Mobile Number (11-digit) <span class="text-red-500">*</span></label>
                                <input type="tel" name="new_mobile" id="new_mobile" x-model="new_mobile"
                                    @blur="validateMobile()" @focus="clearMobileError()"
                                    :class="mobileError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                    class="mt-1 block w-full rounded-md shadow-sm focus:ring-primary focus:border-primary"
                                    maxlength="11" pattern="[0-9]*" inputmode="numeric"
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                                <div x-show="mobileError" x-text="mobileError" class="text-red-500 text-xs mt-1"></div>
                                @error('new_mobile') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <!-- Password with peek and validation -->
                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                                <div class="relative mt-1">
                                    <input :type="showNewPassword ? 'text' : 'password'"
                                        name="new_password" id="new_password"
                                        x-model="new_password"
                                        @blur="validatePassword()"
                                        @focus="clearPasswordError()"
                                        x-bind:required="newCustomer"
                                        autocomplete="new-password"
                                        :class="passwordError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                        class="block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary pr-10">
                                    <button type="button" @click="showNewPassword = !showNewPassword" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <!-- Eye open (visible when password is hidden) -->
                                        <svg x-show="!showNewPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <!-- Eye closed (visible when password is shown) -->
                                        <svg x-show="showNewPassword" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <div x-show="passwordError" x-text="passwordError" class="text-red-500 text-xs mt-1"></div>
                                @error('new_password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Confirm Password with peek and validation -->
                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password <span class="text-red-500">*</span></label>
                                <div class="relative mt-1">
                                    <input :type="showNewPasswordConfirmation ? 'text' : 'password'"
                                        name="new_password_confirmation" id="new_password_confirmation"
                                        x-model="new_password_confirmation"
                                        @blur="validatePasswordConfirm()"
                                        @focus="clearPasswordConfirmError()"
                                        x-bind:required="newCustomer"
                                        autocomplete="new-password"
                                        :class="passwordConfirmError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                        class="block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary pr-10">
                                    <button type="button" @click="showNewPasswordConfirmation = !showNewPasswordConfirmation" class="absolute inset-y-0 right-0 flex items-center pr-3">
                                        <svg x-show="!showNewPasswordConfirmation" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                        <svg x-show="showNewPasswordConfirmation" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                                <div x-show="passwordConfirmError" x-text="passwordConfirmError" class="text-red-500 text-xs mt-1"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Container 2: Appointment Details -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Appointment Details</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Service -->
                        <div>
                            <label for="service_id" class="block text-sm font-medium text-gray-700">Service <span class="text-red-500">*</span></label>
                            <select name="service_id" id="service_id" x-model="service_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                <option value="">Select Service</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }} - ₱{{ number_format($service->price, 2) }}</option>
                                @endforeach
                            </select>
                            @error('service_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Employee (optional) -->
                        <div>
                            <label for="employee_id" class="block text-sm font-medium text-gray-700">Assign Employee (Optional)</label>
                            <select name="employee_id" id="employee_id" x-model="employee_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                                <option value="">Unassigned</option>
                                @foreach($employees as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>{{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->jobRole->title }})</option>
                                @endforeach
                            </select>
                            @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Date -->
                        <div>
                            <label for="appointment_date" class="block text-sm font-medium text-gray-700">Date <span class="text-red-500">*</span></label>
                            <input type="date" name="appointment_date" id="appointment_date" x-model="appointment_date" :min="minDate" value="{{ old('appointment_date') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                            @error('appointment_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Time -->
                        <div>
                            <label for="appointment_time" class="block text-sm font-medium text-gray-700">Time <span class="text-red-500">*</span></label>
                            <input type="time" name="appointment_time" id="appointment_time"
                                x-model="appointment_time"
                                @blur="validateTime()"
                                @focus="clearTimeError()"
                                :class="timeError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                min="06:00" max="19:00"
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                required>
                            <div x-show="timeError" x-text="timeError" class="text-red-500 text-xs mt-1"></div>
                            @error('appointment_time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method <span class="text-red-500">*</span></label>
                            <select name="payment_method" id="payment_method" x-model="payment_method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="gcash" {{ old('payment_method') == 'gcash' ? 'selected' : '' }}>GCash</option>
                            </select>
                            @error('payment_method') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- GCash Reference (conditional) -->
                        <div x-show="payment_method === 'gcash'" x-transition>
                            <label for="gcash_reference" class="block text-sm font-medium text-gray-700">GCash Reference Number (13-digit) <span class="text-red-500">*</span></label>
                            <input type="text" name="gcash_reference" id="gcash_reference"
                                x-model="gcash_reference"
                                @blur="validateGcashReference()"
                                @focus="clearGcashError()"
                                :class="gcashError ? 'border-red-500 focus:border-red-500' : 'border-gray-300'"
                                class="mt-1 block w-full rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                maxlength="13" pattern="[0-9]*" inputmode="numeric"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                            <div x-show="gcashError" x-text="gcashError" class="text-red-500 text-xs mt-1"></div>
                            @error('gcash_reference') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Discount (optional) -->
                        <div>
                            <label for="discount_id" class="block text-sm font-medium text-gray-700">Discount (Optional)</label>
                            <select name="discount_id" id="discount_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                                <option value="">No discount</option>
                                @foreach($discounts as $discount)
                                <option value="{{ $discount->id }}" {{ old('discount_id') == $discount->id ? 'selected' : '' }}>
                                    {{ $discount->name }} ({{ $discount->code }}) -
                                    @if($discount->type == 'percentage') {{ $discount->value }}% @else ₱{{ number_format($discount->value, 2) }} @endif
                                    @if($discount->usage_limit) (max {{ $discount->usage_limit }} uses per customer) @endif
                                </option>
                                @endforeach
                            </select>
                            @error('discount_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" x-model="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Total Price display -->
                        <div class="md:col-span-2">
                            <p class="text-lg font-semibold">Total: ₱<span id="total_price">0.00</span></p>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('admin.appointments.index') }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Cancel</a>
                        <button type="button"
                            class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!isComplete"
                            @click="confirmAction('Create Appointment', 'Are you sure you want to create this appointment?', '#createAppointmentForm', 'POST', 'Create', true)">
                            Create Appointment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('service_id').addEventListener('change', function() {
        let price = this.options[this.selectedIndex].dataset.price || 0;
        document.getElementById('total_price').innerText = parseFloat(price).toFixed(2);
    });
    window.addEventListener('load', function() {
        let select = document.getElementById('service_id');
        if (select.value) {
            let price = select.options[select.selectedIndex].dataset.price || 0;
            document.getElementById('total_price').innerText = parseFloat(price).toFixed(2);
        }
    });
</script>
@endsection