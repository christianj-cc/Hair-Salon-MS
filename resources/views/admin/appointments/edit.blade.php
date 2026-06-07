@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.appointments.index', $appointment) }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Appointment</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form id="editAppointmentForm" method="POST" action="{{ route('admin.appointments.update', $appointment) }}"
            x-data="{
                customer_id: '{{ old('customer_id', $appointment->customer_id) }}',
                service_id: '{{ old('service_id', $appointment->services->first()->id ?? '') }}',
                employee_id: '{{ old('employee_id', $appointment->employee_id) }}',
                appointment_date: '{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}',
                appointment_time: '{{ old('appointment_time', \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i')) }}',
                payment_method: '{{ old('payment_method', $appointment->payment_method) }}',
                status: '{{ old('status', $appointment->status) }}',
                discount_id: '{{ old('discount_id', $appointment->discount_id) }}',
                gcash_reference: '{{ old('gcash_reference', $appointment->payment->reference_number ?? '') }}',
                
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
                    this.$watch('payment_method', () => {
                        this.validateGcashReference();
                    });
                }
            }">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Customer -->
                <div>
                    <label for="customer_id" class="block text-sm font-medium text-gray-700">Customer <span class="text-red-500">*</span></label>
                    <select name="customer_id" id="customer_id" x-model="customer_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                        <option value="">Select Customer</option>
                        @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id', $appointment->customer_id) == $customer->id ? 'selected' : '' }}>{{ $customer->first_name }} {{ $customer->last_name }}</option>
                        @endforeach
                    </select>
                    @error('customer_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Employee (optional) -->
                <div>
                    <label for="employee_id" class="block text-sm font-medium text-gray-700">Assign Employee (Optional)</label>
                    <select name="employee_id" id="employee_id" x-model="employee_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                        <option value="">Unassigned</option>
                        @foreach($employees as $employee)
                        <option value="{{ $employee->id }}" {{ old('employee_id', $appointment->employee_id) == $employee->id ? 'selected' : '' }}>{{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->jobRole->title }})</option>
                        @endforeach
                    </select>
                    @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Service -->
                <div>
                    <label for="service_id" class="block text-sm font-medium text-gray-700">Service <span class="text-red-500">*</span></label>
                    <select name="service_id" id="service_id" x-model="service_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                        <option value="">Select Service</option>
                        @foreach($services as $service)
                        <option value="{{ $service->id }}" data-price="{{ $service->price }}" {{ old('service_id', $appointment->services->first()->id ?? '') == $service->id ? 'selected' : '' }}>{{ $service->name }} - ₱{{ number_format($service->price, 2) }}</option>
                        @endforeach
                    </select>
                    @error('service_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Date -->
                <div>
                    <label for="appointment_date" class="block text-sm font-medium text-gray-700">Date <span class="text-red-500">*</span></label>
                    <input type="date" name="appointment_date" id="appointment_date" x-model="appointment_date"
                        :min="minDate" value="{{ old('appointment_date', $appointment->appointment_date->format('Y-m-d')) }}"
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
                        <option value="cash" {{ old('payment_method', $appointment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="gcash" {{ old('payment_method', $appointment->payment_method) == 'gcash' ? 'selected' : '' }}>GCash</option>
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
                        <option value="{{ $discount->id }}" {{ old('discount_id', $appointment->discount_id) == $discount->id ? 'selected' : '' }}>
                            {{ $discount->name }} ({{ $discount->code }}) -
                            @if($discount->type == 'percentage') {{ $discount->value }}% @else ₱{{ number_format($discount->value, 2) }} @endif
                            @if($discount->usage_limit) ({{ $discount->customer_used }}/{{ $discount->usage_limit }} uses) @endif
                        </option>
                        @endforeach
                    </select>
                    @error('discount_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status" x-model="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                        <option value="pending" {{ old('status', $appointment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ old('status', $appointment->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ old('status', $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('status', $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Total Price display -->
                <div class="md:col-span-2">
                    <p class="text-lg font-semibold">Total: ₱<span id="total_price">{{ number_format($appointment->total_amount, 2) }}</span></p>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <a href="{{ route('admin.appointments.show', $appointment) }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Cancel</a>
                <button type="button"
                    class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="!isComplete"
                    @click="confirmAction('Update Appointment', 'Are you sure you want to update this appointment?', '#editAppointmentForm', 'POST', 'Update', true)">
                    Update Appointment
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('service_id').addEventListener('change', function() {
        let price = this.options[this.selectedIndex].dataset.price || 0;
        document.getElementById('total_price').innerText = parseFloat(price).toFixed(2);
    });
    // Trigger on load if old value exists
    window.addEventListener('load', function() {
        let select = document.getElementById('service_id');
        if (select.value) {
            let price = select.options[select.selectedIndex].dataset.price || 0;
            document.getElementById('total_price').innerText = parseFloat(price).toFixed(2);
        }
    });
</script>
@endsection