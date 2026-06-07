@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.employees.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Employee Details</h1>
    </div>

    <!-- Three stacked containers -->
    <div class="space-y-6">
        <!-- Container 1: Profile & Basic Info -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6 flex items-center space-x-6">
                <!-- Profile Image -->
                <div class="flex-shrink-0">
                    @if(image_exists($employee->image))
                    <img src="{{ asset('storage/' . $employee->image) }}" alt="{{ $employee->first_name }}" class="h-24 w-24 rounded-full object-cover border-2 border-gray-200">
                    @else
                    <div class="h-24 w-24 rounded-full bg-gray-200 flex items-center justify-center border-2 border-gray-200">
                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    @endif
                </div>
                <!-- Name and Role -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $employee->first_name }} {{ $employee->last_name }}</h2>
                    <p class="text-gray-600 mt-1">
                        <span class="font-medium"></span> {{ $employee->jobRole->title }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Container 2: Service History Summary -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Service History Summary</h3>
                <a href="{{ route('admin.employees.history', $employee) }}" class="text-primary hover:text-primary-dark font-medium">
                    View Service History →
                </a>
            </div>
            <div class="p-6">
                @php
                $appointments = $employee->appointments;
                $totalAppointments = $appointments->count();
                $cancelled = $appointments->where('status', 'cancelled')->count();
                $totalEarned = $appointments->where('payment_status', 'paid')->sum('total_amount');
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-primary">{{ $totalAppointments }}</p>
                        <p class="text-sm text-gray-600">Total Appointments</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-red-500">{{ $cancelled }}</p>
                        <p class="text-sm text-gray-600">Cancelled</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-green-600">
                            ₱{{ number_format($totalEarned, 2) }}
                        </p>
                        <p class="text-sm text-gray-600">Total Earned</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container 3: Personal Information -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                <a href="{{ route('admin.employees.edit', $employee) }}" class="text-primary hover:text-primary-dark">
                    <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Details
                </a>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Work Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Personal Email</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->personal_email ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Mobile Number</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->mobile_num ?? 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Birthdate</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->birthdate ? $employee->birthdate->format('F d, Y') : 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Gender</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($employee->gender ?? 'N/A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Hire Date</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $employee->hire_date ? $employee->hire_date->format('F d, Y') : 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $employee->user->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($employee->user->status) }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection