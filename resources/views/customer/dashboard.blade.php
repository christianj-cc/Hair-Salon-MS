@extends('layouts.customer')

@section('content')
<div class="py-6 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">My Profile</h1>

        <!-- Profile Info Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="p-6 flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="h-20 w-20 rounded-full overflow-hidden bg-gray-200">
                        @if($customer->image && image_exists($customer->image))
                        <img src="{{ asset('storage/' . $customer->image) }}" alt="{{ $customer->first_name }}" class="h-full w-full object-cover">
                        @else
                        <div class="h-full w-full flex items-center justify-center">
                            <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">{{ $customer->first_name }} {{ $customer->last_name }}</h2>
                        <p class="text-gray-600">{{ $customer->user->email }}</p>
                        <p class="text-gray-600">{{ $customer->mobile_num ?? 'No mobile number' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service History Summary -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Service History Summary</h3>
                <a href="{{ route('customer.appointments.index') }}" class="text-primary hover:text-primary-dark">View All →</a>
            </div>
            <div class="p-6">
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
                        <p class="text-3xl font-bold text-green-600">₱{{ number_format($totalPaid, 2) }}</p>
                        <p class="text-sm text-gray-600">Total Paid</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Loyalty Reward -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Loyalty Reward</h3>
            </div>
            <div class="p-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">{{ $completedVisits }} visits</span>
                    <span class="text-sm text-gray-600">{{ $visitsToNextDiscount }} more visits to 10% off</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                    <div class="bg-primary h-2 rounded-full" style="width: {{ min(100, max(0, $progressPercent ?? 0)) }}%;"></div>
                </div>
                <p class="mt-2 text-sm text-gray-500">Get 10% off on your next service after every 3 visits!</p>
                @if($customer->loyalty_discount_available)
                <div class="mt-2 p-2 bg-green-100 text-green-800 rounded text-sm">
                    🎉 Congratulations! You have a 10% discount available on your next booking!
                </div>
                @endif
            </div>
        </div>

        <!-- Personal Information -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                <a href="{{ route('profile.edit') }}" class="text-primary hover:text-primary-dark">Edit Account→</a>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">First Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $customer->first_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Name</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $customer->last_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Birthdate</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $customer->birthdate ? $customer->birthdate->format('F d, Y') : 'N/A' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Gender</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($customer->gender ?? 'N/A') }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Deactivate Account Button -->
        <div class="mt-6 flex justify-end">
            <button @click="confirmAction('Deactivate Account', 'Are you sure you want to deactivate your account? This action cannot be undone.', '{{ route('customer.deactivate') }}', 'POST', 'Deactivate', true)"
                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                Deactivate Account
            </button>
        </div>
    </div>
</div>
@endsection