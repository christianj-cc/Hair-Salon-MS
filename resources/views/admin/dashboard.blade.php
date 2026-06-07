@extends('layouts.admin')

@section('content')
<div class="py-2" x-data="dashboardStats()" x-init="initCharts()">
    <!-- Header with date range selector -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <h1 class="text-2xl font-semibold text-gray-900">Dashboard</h1>
        <div class="flex gap-2">
            <select x-model="selectedRange" @change="changeRange" class="border-gray-300 rounded-md shadow-sm text-sm">
                <option value="7days">Last 7 days</option>
                <option value="30days" selected>Last 30 days</option>
                <option value="90days">Last 90 days</option>
                <option value="month">Last month</option>
                <option value="year">Last year</option>
            </select>
            <button @click="refreshData" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition min-w-[140px] text-center flex items-center justify-center gap-2">Refresh</button>
        </div>
    </div>

    <!-- Stats Cards - Responsive Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 lg:gap-6 mb-8">
        <!-- Total Appointments -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6 min-w-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600 flex-shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-3 lg:ml-4 min-w-0">
                        <p class="text-sm text-gray-500 truncate">Total Appointments</p>
                        <p class="text-xl lg:text-2xl font-semibold text-gray-700 truncate">{{ $totalAppointments }}</p>
                    </div>
                </div>
                @if(isset($totalAppointmentsChange))
                <div class="text-right">
                    <span class="text-xs font-semibold {{ $totalAppointmentsChange['is_positive'] ? 'text-green-600' : ($totalAppointmentsChange['direction'] == 'down' ? 'text-red-600' : 'text-gray-500') }}">
                        {{ $totalAppointmentsChange['is_positive'] ? '+' : '' }}{{ $totalAppointmentsChange['percentage'] }}%
                    </span>
                    <p class="text-xs text-gray-400">vs last month</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Today's Revenue -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6 min-w-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600 flex-shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 lg:ml-4 min-w-0">
                        <p class="text-sm text-gray-500 truncate">Today's Revenue</p>
                        <p class="text-xl lg:text-2xl font-semibold text-gray-700 truncate">₱{{ number_format($todayRevenue, 2) }}</p>
                    </div>
                </div>
                @if(isset($todayRevenueChange))
                <div class="text-right">
                    <span class="text-xs font-semibold {{ $todayRevenueChange['is_positive'] ? 'text-green-600' : ($todayRevenueChange['direction'] == 'down' ? 'text-red-600' : 'text-gray-500') }}">
                        {{ $todayRevenueChange['is_positive'] ? '+' : '' }}{{ $todayRevenueChange['percentage'] }}%
                    </span>
                    <p class="text-xs text-gray-400">vs last week</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6 min-w-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 flex-shrink-0">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-3 lg:ml-4 min-w-0">
                        <p class="text-sm text-gray-500 truncate">Total Customers</p>
                        <p class="text-xl lg:text-2xl font-semibold text-gray-700 truncate">{{ $totalCustomers }}</p>
                    </div>
                </div>
                @if(isset($totalCustomersChange))
                <div class="text-right">
                    <span class="text-xs font-semibold {{ $totalCustomersChange['is_positive'] ? 'text-green-600' : ($totalCustomersChange['direction'] == 'down' ? 'text-red-600' : 'text-gray-500') }}">
                        {{ $totalCustomersChange['is_positive'] ? '+' : '' }}{{ $totalCustomersChange['percentage'] }}%
                    </span>
                    <p class="text-xs text-gray-400">vs last month</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Low Stock Products (no change indicator) -->
        <div class="bg-white rounded-lg shadow p-4 lg:p-6 min-w-0">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600 flex-shrink-0">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div class="ml-3 lg:ml-4 min-w-0">
                    <p class="text-sm text-gray-500 truncate">Low Stock Products</p>
                    <p class="text-xl lg:text-2xl font-semibold text-gray-700 truncate">{{ $lowStockProducts }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart & Change Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-medium text-gray-900">Revenue Trend</h2>
                <div class="flex items-center gap-2">
                    <span class="text-sm text-gray-500">vs previous period:</span>
                    <span :class="revenueChange.direction === 'up' ? 'text-green-600' : 'text-red-600'" class="font-semibold">
                        <span x-text="Math.abs(revenueChange.percentage)"></span>%
                        <span x-show="revenueChange.direction === 'up'">↑</span>
                        <span x-show="revenueChange.direction === 'down'">↓</span>
                    </span>
                </div>
            </div>
            <canvas id="revenueChart" class="w-full h-64"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Customer Retention</h2>
            <canvas id="retentionChart" class="w-full h-48"></canvas>
            <div class="mt-4 text-center text-sm text-gray-600">
                <div class="flex justify-between mb-1">
                    <span>New customers:</span>
                    <span class="font-semibold">{{ $customerRetention['new'] }} ({{ $customerRetention['new_percentage'] }}%)</span>
                </div>
                <div class="flex justify-between">
                    <span>Returning customers:</span>
                    <span class="font-semibold">{{ $customerRetention['returning'] }} ({{ $customerRetention['returning_percentage'] }}%)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Services & Staff Performance -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Top 5 Services</h2>
            <canvas id="topServicesChart" class="w-full h-64"></canvas>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Staff Performance</h2>
                <p class="text-sm text-gray-500">Appointments completed & revenue generated ({{ ucfirst($range) }})</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Staff</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Completed</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($staffPerformance as $staff)
                        <tr>
                            <td class="px-6 py-4">{{ $staff->first_name }} {{ $staff->last_name }}</td>
                            <td class="px-6 py-4">{{ $staff->appointments_completed ?? 0 }}</td>
                            <td class="px-6 py-4">₱{{ number_format($staff->revenue_generated ?? 0, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">No completed appointments in this period.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Appointments Table (unchanged) 
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
                            <td class="px-6 py-4">{{ $appointment->appointment_time }}</td>
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
                                    @else bg-red-100 text-red-800 @endif">
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
        </div>
    </div>-->
</div>

<script>
    // Pass PHP data using plain PHP json_encode (no Blade directives)
    const dashboardData = <?php echo json_encode([
                                'range' => $range,
                                'revenueChange' => $revenueChange,
                                'revenueData' => $revenueData,
                                'topServices' => $topServices,
                                'customerRetention' => $customerRetention,
                            ]); ?>;

    function dashboardStats() {
        return {
            selectedRange: dashboardData.range,
            revenueChange: dashboardData.revenueChange,
            revenueChart: null,
            retentionChart: null,
            topServicesChart: null,
            revenueData: dashboardData.revenueData,
            topServices: dashboardData.topServices,
            customerRetention: dashboardData.customerRetention,

            initCharts() {
                this.initRevenueChart();
                this.initRetentionChart();
                this.initTopServicesChart();
            },

            initRevenueChart() {
                const ctx = document.getElementById('revenueChart').getContext('2d');
                this.revenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: this.revenueData.labels,
                        datasets: [{
                            label: 'Revenue (₱)',
                            data: this.revenueData.values,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => `₱${ctx.raw.toFixed(2)}`
                                }
                            }
                        }
                    }
                });
            },

            initRetentionChart() {
                const ctx = document.getElementById('retentionChart').getContext('2d');
                this.retentionChart = new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['New Customers', 'Returning Customers'],
                        datasets: [{
                            data: [this.customerRetention.new, this.customerRetention.returning],
                            backgroundColor: ['#10b981', '#f59e0b'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            },

            initTopServicesChart() {
                const ctx = document.getElementById('topServicesChart').getContext('2d');
                const labels = this.topServices.map(s => s.name);
                const uses = this.topServices.map(s => s.total_uses);
                this.topServicesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Number of times booked',
                            data: uses,
                            backgroundColor: '#8b5cf6',
                            borderRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        indexAxis: 'y',
                        plugins: {
                            legend: {
                                position: 'top'
                            }
                        }
                    }
                });
            },

            changeRange() {
                window.location.href = `?range=${this.selectedRange}`;
            },

            refreshData() {
                this.changeRange();
            }
        }
    }
</script>
@endsection