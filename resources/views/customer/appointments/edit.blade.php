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

        <!-- Edit Form Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-gray-900">Edit Appointment</h1>
            </div>
            <div class="p-6">
                <form id="editAppointmentForm" method="POST" action="{{ route('customer.appointments.update', $appointment) }}"
                    x-data="{
                        service_id: '{{ old('service_id', $appointment->services->first()->id ?? '') }}',
                        appointment_date: '{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}',
                        appointment_time: '{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}',
                        payment_method: '{{ old('payment_method', $appointment->payment_method) }}',
                        discount_id: '{{ old('discount_id', $appointment->discount_id) }}',
                        gcash_reference: '{{ old('gcash_reference', $appointment->payment->reference_number ?? '') }}',
                        get isComplete() {
                            return this.service_id !== '' &&
                                    this.appointment_date !== '' &&
                                    this.appointment_time !== '' &&
                                    this.payment_method !== '';
                        },
                        
                        gcashError: '',
                        timeError: '',

                        get isComplete() {
                            let ok = this.customer_id !== '' &&
                                    this.service_id !== '' &&
                                    this.appointment_date !== '' &&
                                    this.appointment_time !== '' &&
                                    this.payment_method !== '' &&
                                    this.status !== '';
                            if (ok && this.payment_method === 'gcash') {
                                ok = this.gcash_reference.trim().length === 13;
                            }
                            if (!this.isValidTime()) return false;
                            return ok;
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
                        }
                    }">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <!-- Service -->
                        <div>
                            <label for="service_id" class="block text-sm font-medium text-gray-700">Service <span class="text-red-500">*</span></label>
                            <select name="service_id" id="service_id" x-model="service_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                <option value="">Select a service</option>
                                @foreach($services as $service)
                                <option value="{{ $service->id }}" data-price="{{ $service->price }}"
                                    {{ old('service_id', $appointment->services->first()->id ?? '') == $service->id ? 'selected' : '' }}>
                                    {{ $service->name }} - ₱{{ number_format($service->price, 2) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Date -->
                            <div>
                                <label for="appointment_date" class="block text-sm font-medium text-gray-700">Date <span class="text-red-500">*</span></label>
                                <input type="date" name="appointment_date" id="appointment_date" x-model="appointment_date"
                                    :min="minDate" min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
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
                                <option value="cash">Cash (Pay at salon)</option>
                                <option value="gcash">GCash</option>
                            </select>
                        </div>

                        <!-- GCash Reference (conditional) -->
                        <div x-show="payment_method === 'gcash'" x-transition>
                            <label for="gcash_reference" class="block text-sm font-medium text-gray-700">GCash Reference Number (13-digit) <span class="text-red-500">*</span></label>
                            <input type="text" name="gcash_reference" id="gcash_reference" x-model="gcash_reference"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary"
                                maxlength="13" pattern="[0-9]*" inputmode="numeric"
                                oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        </div>

                        <!-- Discount (optional) -->
                        <div>
                            <label for="discount_id" class="block text-sm font-medium text-gray-700">Discount (Optional)</label>
                            <select name="discount_id" id="discount_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                                <option value="">No discount</option>
                                @foreach($discounts as $discount)
                                <option value="{{ $discount->id }}" {{ old('discount_id', $appointment->discount_id) == $discount->id ? 'selected' : '' }}>
                                    {{ $discount->name }} ({{ $discount->code }}) -
                                    @if($discount->type == 'percentage') {{ $discount->value }}% @else ₱{{ number_format($discount->value, 2) }} @endif
                                    @if($discount->usage_limit) ({{ $discount->customer_used }}/{{ $discount->usage_limit }} uses) @endif
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Total Price display -->
                        <div>
                            <p class="text-lg font-semibold">Total: ₱<span id="total_price">{{ number_format($appointment->total_amount, 2) }}</span></p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button"
                            @click="confirmAction('Update Appointment', 'Are you sure you want to update this appointment?', '#editAppointmentForm', 'POST', 'Update')"
                            class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!isComplete">
                            Update Appointment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('service_id').addEventListener('change', function() {
        let price = this.options[this.selectedIndex].dataset.price || 0;
        document.getElementById('total_price').innerText = parseFloat(price).toFixed(2);
    });
    // Trigger on load to set initial price
    window.addEventListener('load', function() {
        let select = document.getElementById('service_id');
        if (select.value) {
            let price = select.options[select.selectedIndex].dataset.price || 0;
            document.getElementById('total_price').innerText = parseFloat(price).toFixed(2);
        }
    });
</script>
@endsection