@extends('layouts.customer')

@section('content')
<div class="py-6 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">My Account</h1>

            <!-- Container 1: Profile Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0">
                        <div class="h-24 w-24 rounded-full overflow-hidden bg-gray-200">
                            @if($customer->image && image_exists($customer->image))
                            <img src="{{ asset('storage/' . $customer->image) }}" alt="{{ $customer->first_name }}" class="h-full w-full object-cover">
                            @else
                            <div class="h-full w-full flex items-center justify-center">
                                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $customer->first_name }} {{ $customer->last_name }}</h2>
                        <p class="text-gray-600">{{ $customer->user->email }}</p>
                        <p class="text-gray-600">{{ $customer->mobile_num ?? 'No mobile number' }}</p>
                        <a href="{{ route('profile.edit') }}" class="mt-2 inline-block text-primary hover:text-primary-dark">Edit Profile Info →</a>
                    </div>
                </div>
            </div>

            <!-- Container 2: Service History Summary -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Service History Summary</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-primary">{{ $totalAppointments }}</p>
                        <p class="text-sm text-gray-600">Total Appointments</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-red-500">{{ $cancelled }}</p>
                        <p class="text-sm text-gray-600">Cancelled</p>
                    </div>
                    <div class="bg-white rounded-lg p-4 text-center">
                        <p class="text-3xl font-bold text-green-600">₱{{ number_format($totalPaid, 2) }}</p>
                        <p class="text-sm text-gray-600">Total Paid</p>
                    </div>
                </div>
                <div class="mt-4 text-right">
                    <a href="{{ route('customer.appointments.index') }}" class="text-primary hover:text-primary-dark">View All Appointments →</a>
                </div>
            </div>

            <!-- Container 3: Personal Information -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
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
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('profile.edit') }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition">Edit Personal Info</a>
                </div>
            </div>

            <!-- Deactivate Account Button -->
            <div class="mt-6 flex justify-end">
                <button @click="confirmAction('Deactivate Account', 'Are you sure you want to deactivate your account? This action cannot be undone.', '{{ route('customer.account.deactivate') }}', 'POST', 'Deactivate', true)"
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                    Deactivate Account
                </button>
            </div>
        </div>
    </div>
</div>
</div>
@endsection