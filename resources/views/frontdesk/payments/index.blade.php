@extends('layouts.frontdesk')

@section('content')
<div class="py-3">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Pending Payment Validations</h1>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Appointment Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Reference No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($appointments as $appointment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_date->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">₱{{ number_format($appointment->total_amount, 2) }}</td>

                        <!-- Appointment Status Badge -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($appointment->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($appointment->status == 'confirmed') bg-blue-100 text-blue-800
                            @elseif($appointment->status == 'completed') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->payment->reference_number ?? 'N/A' }}</td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('frontdesk.appointments.show', $appointment) }}" class="text-green-600 hover:text-green-900 mr-2" title="View">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            @if(!$appointment->employee_id || $appointment->status != 'confirmed')
                            <span class="text-gray-500 italic">Needs Assignment</span>
                            @else
                            <button @click="confirmAction('Validate Payment', 'Are you sure you want to mark this payment as paid?', '{{ route('frontdesk.payments.validate', $appointment) }}', 'PATCH', 'Validate')"
                                class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                Validate
                            </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No pending validations.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $appointments->links() }}
        </div>
    </div>
</div>
@endsection