@extends('layouts.tech')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('tech.appointments.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Appointment Details</h1>
    </div>

    <!-- Container 1: Status Stepper -->
    <div class="bg-transparent rounded-lg overflow-hidden mb-6">
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

<!-- Container 1: Client -->
<div class="bg-transparent gap-6 mt-6">
    <!-- Client Card -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Client</h3>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 rounded-full overflow-hidden">
                        @if($appointment->customer->image)
                        <img src="{{ asset('storage/' . $appointment->customer->image) }}"
                            alt="{{ $appointment->customer->first_name }}"
                            class="h-full w-full object-cover">
                        @else
                        <div class="h-full w-full bg-gray-200 flex items-center justify-center">
                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>
                <div>
                    <p class="text-lg font-semibold">{{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}</p>
                    <p class="text-sm text-gray-600">{{ $appointment->customer->user->email }}</p>
                    <p class="text-sm text-gray-600">{{ $appointment->customer->mobile_num ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Container 2: Appointment Details -->
<div class="bg-white rounded-lg shadow overflow-hidden mt-6">
    <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-medium text-gray-900">Appointment Information</h3>
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
                <dt class="text-sm font-medium text-gray-500">Payment Status</dt>
                <dd class="mt-1">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($appointment->payment_status == 'paid') bg-green-100 text-green-800
                            @elseif($appointment->payment_status == 'for_validation') bg-purple-100 text-purple-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                        {{ ucfirst($appointment->payment_status) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Appointment Status</dt>
                <dd class="mt-1">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($appointment->status == 'confirmed') bg-green-100 text-green-800
                            @elseif($appointment->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($appointment->status == 'completed') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </dd>
            </div>
        </dl>

        <!--@if($appointment->status == 'confirmed')
            <div class="mt-6">
                <button @click="confirmAction('Complete Appointment', 'Are you sure you want to mark this appointment as completed?', '{{ route('tech.appointments.complete', $appointment) }}', 'PATCH', 'Complete')" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                    Mark as Completed
                </button>
            </div>
            @endif-->
    </div>
</div>
</div>
@endsection