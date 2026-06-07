@extends('layouts.customer')

@section('content')
<div class="py-6 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-row sm:flex-row justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">My Appointments</h1>
            <a href="{{ route('customer.appointments.create') }}"
                class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition min-w-[190px] text-center flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Book Appointment</span>
            </a>
        </div>

        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow p-4 mb-6">
            <form method="GET" action="{{ route('customer.appointments.index') }}" class="flex flex-wrap gap-3">
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by service or date..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm">
                    </div>
                </div>
                <div>
                    <select name="status" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition">Filter</button>
                    @if(request('search') || request('status'))
                    <a href="{{ route('customer.appointments.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition">Clear</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Appointments List -->
        @if($appointments->count())
        <div class="space-y-4">
            @foreach($appointments as $appointment)
            <!-- Date in red -->
            <div class="mb-1">
                <p class="text-primary font-bold text-m">{{ $appointment->appointment_date->format('M d, Y') }}</p>
            </div>
            <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-md transition mt-1">
                <div class="p-4">
                    <div class="flex flex-row sm:flex-row sm:items-center sm:justify-between">
                        <!-- Details: services, time, stylist -->
                        <div class="flex-1">
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="flex flex-wrap items-center gap-2 text-sm">
                                    <span class="font-bold text-gray-900">
                                        @foreach($appointment->services as $service)
                                        {{ $service->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </span>
                                    <span class="text-gray-400">•</span>
                                    <span class="font-medium">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</span>
                                    <span class="text-gray-400">•</span>
                                    <span>Stylist: {{ $appointment->employee->first_name ?? 'Not assigned' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Status badge and chevron – aligned right on all screens -->
                        <div class="flex items-center justify-end gap-3 mt-2 sm:mt-0">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                    @if($appointment->status == 'confirmed') bg-green-100 text-green-800
                    @elseif($appointment->status == 'pending') bg-yellow-100 text-yellow-800
                    @elseif($appointment->status == 'completed') bg-blue-100 text-blue-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                            <a href="{{ route('customer.appointments.show', $appointment) }}" class="text-gray-400 hover:text-primary transition p-4">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $appointments->appends(request()->except('page'))->links() }}
        </div>
        @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500">No appointments found.</p>
            <a href="{{ route('customer.appointments.create') }}" class="mt-4 inline-block bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark">Book an Appointment</a>
        </div>
        @endif
    </div>
</div>
@endsection