@extends('layouts.customer')

@section('content')
<div class="py-3 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back to Appointments -->
        <div class="flex items-center mb-6">
            <a href="{{ route('customer.appointments.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">&nbsp;&nbsp;Back to Appointments</h1>
        </div>

        <!-- Container 1: Status Stepper -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="p-6">
                @php
                $steps = [
                ['label' => 'Booked', 'done' => true],
                ['label' => 'Assigned', 'done' => !is_null($appointment->employee_id)],
                ['label' => 'Paid', 'done' => $appointment->payment_status === 'paid'],
                ['label' => 'Completed', 'done' => $appointment->status === 'completed'],
                ];
                $isCancelled = $appointment->status === 'cancelled';
                @endphp

                @if($isCancelled)
                <div class="bg-red-100 text-red-800 p-4 rounded-lg text-center font-semibold">
                    This appointment has been cancelled.
                </div>
                @else
                <div class="flex justify-between items-center max-w-3xl mx-auto">
                    @foreach($steps as $index => $step)
                    <div class="flex flex-col items-center flex-1">
                        <div class="relative w-full">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center mx-auto
                                {{ $step['done'] ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600' }}
                                border-2 {{ $step['done'] ? 'border-primary' : 'border-gray-300' }}">
                                @if($step['done'])
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                @else
                                <span>{{ $index + 1 }}</span>
                                @endif
                            </div>
                            @if($index < count($steps) - 1)
                                <div class="absolute top-1/2 left-full w-full h-0.5 bg-gray-300 -translate-y-1/2"
                                style="left: calc(50% + 1.25rem); width: calc(100% - 2.5rem);">
                        </div>
                        @endif
                    </div>
                    <span class="mt-2 text-sm font-medium {{ $step['done'] ? 'text-primary' : 'text-gray-500' }}">
                        {{ $step['label'] }}
                    </span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Container 2: Stylist Card -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Stylist</h3>
        </div>
        <div class="p-6">
            @if($appointment->employee)
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-200">
                        @if($appointment->employee->image && image_exists($appointment->employee->image))
                        <img src="{{ asset('storage/' . $appointment->employee->image) }}" alt="{{ $appointment->employee->first_name }}" class="h-full w-full object-cover">
                        @else
                        <div class="h-full w-full flex items-center justify-center">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-lg font-semibold">{{ $appointment->employee->first_name }} {{ $appointment->employee->last_name }}</p>
                    <p class="text-sm text-gray-600">{{ $appointment->employee->jobRole->title }}</p>
                    <p class="text-sm text-gray-600">{{ $appointment->employee->mobile_num ?? 'N/A' }}</p>
                </div>
            </div>
            @else
            <p class="text-gray-500">No stylist assigned yet.</p>
            @endif
        </div>
    </div>

    <!-- Container 3: Appointment Details -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Appointment Details</h3>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Services</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        @foreach($appointment->services as $service)
                        {{ $service->name }} (₱{{ number_format($service->price, 2) }})@if(!$loop->last), @endif
                        @endforeach
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Date & Time</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Total Amount</dt>
                    <dd class="mt-1 text-sm text-gray-900">₱{{ number_format($appointment->total_amount, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Payment Method</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($appointment->payment_method) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Appointment Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($appointment->status == 'confirmed') bg-green-100 text-green-800
                                @elseif($appointment->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($appointment->status == 'completed') bg-blue-100 text-blue-800
                                @elseif($appointment->status == 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </dd>
                </div>
                @if($appointment->payment && $appointment->payment->reference_number)
                <div>
                    <dt class="text-sm font-medium text-gray-500">GCash Reference</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $appointment->payment->reference_number }}</dd>
                </div>
                @endif
                @if($appointment->discount)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Discount</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                        {{ $appointment->discount->name }} ({{ $appointment->discount->code }})
                        @if($appointment->discount->type == 'percentage')
                        -{{ $appointment->discount->value }}%
                        @else
                        -₱{{ number_format($appointment->discount->value, 2) }}
                        @endif
                    </dd>
                </div>
                @endif
                <div>
                    <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                    <dd class="mt-1">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                @if($appointment->payment_status == 'paid') bg-green-100 text-green-800
                                @elseif($appointment->payment_status == 'for_validation') bg-purple-100 text-purple-800
                                @else bg-red-100 text-red-800
                                @endif">
                            @if($appointment->payment_status == 'for_validation')
                            For Validation
                            @else
                            {{ ucfirst($appointment->payment_status) }}
                            @endif
                        </span>
                    </dd>
                </div>
            </dl>

            <div class="mt-6 flex justify-between items-center">
                @if(!in_array($appointment->status, ['completed', 'cancelled']))
                <button @click="confirmAction('Cancel Appointment', 'Are you sure you want to cancel this appointment?', '{{ route('customer.appointments.cancel', $appointment) }}', 'POST', 'Cancel Appointment', true, true)"
                    class=" bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                    Cancel Appointment
                </button>
                @endif
                @if($appointment->status == 'pending')
                <a href="{{ route('customer.appointments.edit', $appointment) }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition">
                    Edit Appointment
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection