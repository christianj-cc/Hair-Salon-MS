@extends('layouts.frontdesk')

@section('content')
<div class="py-3">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Front Desk Dashboard</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
        <!-- Today's Appointments -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Today's Appointments</p>
                        <p class="text-2xl font-semibold text-gray-700">{{ $todayAppointments }}</p>
                    </div>
                </div>
                @if(isset($todayAppointmentsChange))
                <div class="text-right">
                    <span class="text-xs font-semibold {{ $todayAppointmentsChange['is_positive'] ? 'text-green-600' : ($todayAppointmentsChange['direction'] == 'down' ? 'text-red-600' : 'text-gray-500') }}">
                        {{ $todayAppointmentsChange['is_positive'] ? '+' : '' }}{{ $todayAppointmentsChange['percentage'] }}%
                    </span>
                    <p class="text-xs text-gray-400">vs yesterday</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Today's Revenue -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Today's Revenue</p>
                        <p class="text-2xl font-semibold text-gray-700">₱{{ number_format($todayRevenue, 2) }}</p>
                    </div>
                </div>
                @if(isset($todayRevenueChange))
                <div class="text-right">
                    <span class="text-xs font-semibold {{ $todayRevenueChange['is_positive'] ? 'text-green-600' : ($todayRevenueChange['direction'] == 'down' ? 'text-red-600' : 'text-gray-500') }}">
                        {{ $todayRevenueChange['is_positive'] ? '+' : '' }}{{ $todayRevenueChange['percentage'] }}%
                    </span>
                    <p class="text-xs text-gray-400">vs yesterday</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Pending Validations -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Pending Payment Validations</p>
                    <p class="text-2xl font-semibold text-gray-700">{{ $pendingValidations }}</p>
                </div>
            </div>
        </div>

        <!-- Upcoming Appointments Count (next 7 days) -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Upcoming (7 days)</p>
                    <p class="text-2xl font-semibold text-gray-700">{{ $upcomingAppointments->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Appointments Chart & Upcoming List -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Chart Card -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Appointments This Week</h2>
            <canvas id="weeklyChart" class="w-full h-64"></canvas>
        </div>

        <!-- Upcoming Appointments List -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Upcoming Appointments</h2>
                <p class="text-sm text-gray-500">Next 7 days</p>
            </div>
            <div class="divide-y divide-gray-200 max-h-80 overflow-y-auto">
                @forelse($upcomingAppointments as $appointment)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-medium text-gray-900">{{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}</p>
                            <p class="text-sm text-gray-500">{{ $appointment->appointment_date->format('M d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</p>
                            <p class="text-sm text-gray-500">Stylist: {{ $appointment->employee->first_name ?? 'Unassigned' }}</p>
                        </div>
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($appointment->status == 'confirmed') bg-green-100 text-green-800
                            @elseif($appointment->status == 'pending') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($appointment->status) }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-6 text-center text-gray-500">No upcoming appointments.</div>
                @endforelse
            </div>
            @if($upcomingAppointments->count() > 0)
            <div class="px-6 py-3 bg-gray-50 text-right">
                <a href="{{ route('frontdesk.appointments.index') }}" class="text-sm text-primary hover:underline">View all →</a>
            </div>
            @endif
        </div>
    </div>

    <!-- Recent Appointments Table (paginated) -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Recent Appointments</h2>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stylist</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($recentAppointments as $appointment)
                        <tr>
                            <td class="px-6 py-4">{{ $appointment->customer->first_name }} {{ $appointment->customer->last_name }}</td>
                            <td class="px-6 py-4">{{ $appointment->appointment_date->format('M d, Y') }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</td>
                            <td class="px-6 py-4">{{ $appointment->employee->first_name ?? 'Unassigned' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($appointment->status == 'confirmed') bg-green-100 text-green-800
                                    @elseif($appointment->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($appointment->status == 'completed') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($appointment->payment_status == 'paid') bg-green-100 text-green-800
                                    @elseif($appointment->payment_status == 'for_validation') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($appointment->payment_status) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">No recent appointments.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $recentAppointments->links() }}
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const weeklyData = @json($weeklyData);
        const ctx = document.getElementById('weeklyChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: weeklyData.labels,
                datasets: [{
                    label: 'Appointments',
                    data: weeklyData.counts,
                    backgroundColor: '#3b82f6',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.raw} appointments`
                        }
                    }
                }
            }
        });
    });
</script>
@endsection