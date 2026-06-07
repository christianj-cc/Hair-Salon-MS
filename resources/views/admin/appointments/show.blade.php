@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.appointments.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Appointment Details</h1>
    </div>

    <!-- Container 1: Status Diagram (stepper) -->
    <div class="space-y-6">
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

<!-- Container 2: Client & Stylist -->
<div class="bg-transparent grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    <!-- Client Card -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Client</h3>
            <div class="space-x-2">
                <a href="{{ route('admin.customers.show', $appointment->customer->id) }}"
                    class="text-primary hover:text-primary-dark">
                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    View Details
                </a>
            </div>
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

    <!-- Stylist Card -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Stylist</h3>
            @if($appointment->status !== 'completed')
            @if(!$appointment->employee_id)
            <a href="{{ route('admin.appointments.assign', $appointment) }}" class="text-primary hover:text-primary-dark">
                + Assign Stylist
            </a>
            @else
            <a href="{{ route('admin.appointments.assign', $appointment) }}" class="text-primary hover:text-primary-dark">
                + Reassign Stylist
            </a>
            @endif
            @endif
        </div>
        <div class="p-6">
            @if($appointment->employee)
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 rounded-full overflow-hidden">
                        @if($appointment->employee->image)
                        <img src="{{ asset('storage/' . $appointment->employee->image) }}"
                            alt="{{ $appointment->employee->first_name }}"
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
                    <p class="text-lg font-semibold">{{ $appointment->employee->first_name }} {{ $appointment->employee->last_name }}</p>
                    <p class="text-sm text-gray-600">{{ $appointment->employee->jobRole->title }}</p>
                    <p class="text-sm text-gray-600">{{ $appointment->employee->mobile_num ?? 'N/A' }}</p>
                </div>
            </div>
            @else
            <p class="text-gray-500 text-sm">No stylist assigned yet.</p>
            @endif
        </div>
    </div>
</div>

<!-- Container 3: Appointment Details -->
<div class="bg-white rounded-lg shadow overflow-hidden mt-6">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Appointment Details</h3>
        <a href="{{ route('admin.appointments.edit', $appointment) }}" class="text-primary hover:text-primary-dark">
            <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Edit Details
        </a>
    </div>
    <div class="p-6">
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Date & Time</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $appointment->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Services</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    @foreach($appointment->services as $service)
                    {{ $service->name }} (₱{{ number_format($service->price, 2) }})@if(!$loop->last), @endif
                    @endforeach
                </dd>
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
            <div>
                <dt class="text-sm font-medium text-gray-500">Created</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $appointment->created_at->format('M d, Y h:i A') }}</dd>
            </div>
        </dl>

        <!-- Products used in this service -->
        <div class="mt-6 border-t pt-4">
            <h3 class="text-md font-medium text-gray-900 mb-3">Products used in this service</h3>

            @if($service->products->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantity used</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($service->products as $product)
                        <tr>
                            <td class="px-4 py-2">
                                {{ $product->name }}
                                @if($product->size)
                                <span class="text-xs text-gray-500 ml-1">({{ $product->size }})</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $product->pivot->quantity_used }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-gray-500 text-sm">No products assigned to this service.</p>
            @endif
        </div>
    </div>


    <!-- Action Buttons -->
    <div class="px-6 py-4 border-t border-gray-200 flex justify-between items-center">
        <div>
            @if(!in_array($appointment->status, ['completed', 'cancelled']))
            <button @click="confirmAction('Cancel Appointment', 'Are you sure you want to cancel this appointment?', '{{ route('admin.appointments.cancel', $appointment) }}', 'POST', 'Cancel Appointment', true, true)"
                class=" bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                Cancel Appointment
            </button>
            @endif
        </div>
        <div class=" space-x-2">
            @if($appointment->employee_id && $appointment->payment_status !== 'paid' && $appointment->status !== 'cancelled')
            <button type="button"
                @click="confirmAction('Mark as Paid', 'Are you sure you want to mark this appointment as paid?', '{{ route('admin.appointments.mark-paid', $appointment) }}', 'POST', 'Mark as Paid', true)"
                class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">
                Mark as Paid
            </button>
            @endif
            @if($appointment->payment_status === 'paid' && $appointment->status !== 'completed' && $appointment->status !== 'cancelled')
            <button type="button"
                @click="confirmAction('Mark as Completed', 'Are you sure you want to mark this appointment as completed?', '{{ route('admin.appointments.complete', $appointment) }}', 'POST', 'Mark as Completed', true)"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                Mark as Completed
            </button>
            @endif
        </div>
    </div>
</div>

</div>
@endsection