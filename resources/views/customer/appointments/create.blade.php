@extends('layouts.customer')

@section('content')
<div class="py-6 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back to Appointments -->
        <div class="flex items-center mb-6">
            <a href="{{ route('customer.appointments.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">&nbsp;&nbsp;Back to Appointment</h1>
        </div>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Book an Appointment</h1>
            </div>
            <div class="p-6">
                <form id="appointmentForm" method="POST" action="{{ route('customer.appointments.store') }}"
                    x-data="{
                        service_id: '{{ request('service_id') }}',
                        appointment_date: '',
                        appointment_time: '',
                        payment_method: 'cash',
                        discount_id: '',
                        gcash_reference: '',
                        loyaltyDiscountAvailable: {{ $loyaltyDiscountAvailable ? 'true' : 'false' }},
                        applyLoyalty: false,
                        servicePrice: 0,
                        preselectedServiceId: '{{ request('service_id') }}',
                        
                        gcashError: '',
                        timeError: '',
                        
                        get isComplete() {
                            let ok = this.service_id !== '' &&
                                     this.appointment_date !== '' &&
                                     this.appointment_time !== '' &&
                                     this.payment_method !== '';
                            if (ok && this.payment_method === 'gcash') {
                                ok = this.gcash_reference.trim().length === 13;
                            }
                            if (!this.isValidTime()) return false;
                            return ok;
                        },
                        
                        get totalPrice() {
                            let price = parseFloat(this.servicePrice) || 0;
                            if (this.applyLoyalty && this.loyaltyDiscountAvailable) {
                                price = price * 0.9;
                            }
                            return price;
                        },

                        updateServicePrice() {
                            const select = document.getElementById('service_id');
                            if (select && select.options.length) {
                                const selectedOption = select.options[select.selectedIndex];
                                this.servicePrice = selectedOption ? (parseFloat(selectedOption.dataset.price) || 0) : 0;
                            } else {
                                this.servicePrice = 0;
                            }
                        },
                        
                        validateTime() {
                            const time = this.appointment_time;
                            if (!time) {
                                this.timeError = '';
                                return;
                            }
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
                        
                        clearGcashError() { this.gcashError = ''; },
                        clearTimeError() { this.timeError = ''; },
                        
                        minDate() {
                            let today = new Date();
                            let tomorrow = new Date(today);
                            tomorrow.setDate(today.getDate() + 1);
                            return tomorrow.toISOString().split('T')[0];
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
                            this.$watch('payment_method', () => {
                                this.validateGcashReference();
                            });
                            this.$nextTick(() => {
                                this.updateServicePrice();
                            });
                        }
                    }">
                    @csrf

                    <div class="space-y-4">
                        <!-- Service -->
                        <div>
                            <label for="service_id" class="block text-sm font-medium text-gray-700">Service <span class="text-red-500">*</span></label>
                            <select name="service_id" id="service_id" x-model="service_id"
                                @change="updateServicePrice()"
                                :disabled="preselectedServiceId != ''"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary disabled:bg-gray-100 disabled:cursor-not-allowed"
                                required>
                                <option value="">Select Service</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }} - ₱{{ number_format($service->price, 2) }}</option>
                                @endforeach
                            </select>
                            <!-- Hidden input to submit service_id when select is disabled -->
                            <input type="hidden" name="service_id" x-bind:value="service_id" x-show="preselectedServiceId != ''">
                            @error('service_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method <span class="text-red-500">*</span></label>
                            <select name="payment_method" id="payment_method" x-model="payment_method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash (Pay at Salon)</option>
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

                        <!-- Loyalty discount checkbox (if available) -->
                        <div x-show="loyaltyDiscountAvailable" x-cloak class="mt-4 p-3 bg-purple-50 border border-purple-200 rounded-md">
                            <label class="inline-flex items-center">
                                <input type="checkbox" x-model="applyLoyalty" class="rounded border-gray-300 text-primary">
                                <span class="ml-2 text-sm text-gray-700">Apply your 10% loyalty discount (earned after 3 visits)</span>
                            </label>
                        </div>

                        <!-- Total with discount -->
                        <div>
                            <p class="text-lg font-semibold">Total: ₱<span x-text="totalPrice.toFixed(2)"></span></p>
                            <input type="hidden" name="apply_loyalty" x-model="applyLoyalty">
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="button"
                            @click="confirmAction('Book Appointment', 'Are you sure you want to book this appointment?', '#appointmentForm', 'POST', 'Book')"
                            class="w-full bg-primary text-white py-3 px-4 rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!isComplete">
                            Book Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection