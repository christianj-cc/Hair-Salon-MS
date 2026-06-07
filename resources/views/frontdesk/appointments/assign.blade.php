@extends('layouts.frontdesk')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('frontdesk.appointments.show', $appointment) }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Assign Stylist to Appointment</h1>
    </div>

    <div class="space-y-6">
        <!-- Client & Appointment Details Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Appointment Details</h3>
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
                        <dd class="text-lg font-semibold">
                            @foreach($appointment->services as $service)
                            {{ $service->name }}@if(!$loop->last), @endif
                            @endforeach
                        </dd>
                        <dd class="text-sm text-gray-600">{{ $appointment->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</dd>
                        <p class="text-sm text-gray-600">{{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stylist Selection Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Select Stylist</h3>
            </div>
            <div class="p-6">
                <form id="assignForm" method="POST" action="{{ route('frontdesk.appointments.assign', $appointment) }}"
                    x-data="{ selectedEmployeeId: null }">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($employees as $employee)
                        <label class="flex items-center space-x-3 p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" name="employee_id" value="{{ $employee->id }}"
                                x-model="selectedEmployeeId"
                                class="mt-1 flex-shrink-0 mr-3" required>
                            <div class="flex flex-1 items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 rounded-full overflow-hidden mr-3">
                                        @if($employee->image)
                                        <img src="{{ asset('storage/' . $employee->image) }}" alt="{{ $employee->first_name }}" class="h-full w-full object-cover">
                                        @else
                                        <div class="h-full w-full bg-gray-200 flex items-center justify-center">
                                            <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                                    <p class="text-sm text-gray-600">{{ $employee->jobRole->title }}</p>
                                    <p class="text-sm text-gray-500">{{ $employee->mobile_num ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('frontdesk.appointments.show', $appointment) }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Cancel</a>
                        <button type="button"
                            @click="if (selectedEmployeeId) confirmAction('Assign Stylist', 'Are you sure you want to assign this stylist?', '#assignForm', 'POST', 'Assign', true)"
                            :disabled="!selectedEmployeeId"
                            class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                            :class="{ 'opacity-50 cursor-not-allowed': !selectedEmployeeId }">
                            Assign Stylist
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection