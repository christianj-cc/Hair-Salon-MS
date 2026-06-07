@extends('layouts.admin')

@section('content')
<div class="py-3">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Sales Reports</h1>

    <!-- Filter Form -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ $startDate }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ $endDate }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
            </div>
            <div>
                <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                <select name="payment_method" id="payment_method" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    <option value="">All Methods</option>
                    <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="gcash" {{ request('payment_method') == 'gcash' ? 'selected' : '' }}>GCash</option>
                </select>
            </div>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition">Filter</button>
            <a href="{{ route('admin.reports.index') }}" class="border border-gray-300 px-4 py-2 rounded-md">Clear</a>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Total Sales</h3>
            <p class="text-3xl font-bold text-gray-900">₱{{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Total Appointments</h3>
            <p class="text-3xl font-bold text-gray-900">{{ $totalAppointments }}</p>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-sm font-medium text-gray-500">Average Order Value</h3>
            <p class="text-3xl font-bold text-gray-900">₱{{ number_format($averageOrderValue, 2) }}</p>
        </div>
    </div>

    <!-- Graphs Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Line Chart: Sales Over Time -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Sales Trend</h2>
            <canvas id="salesTrendChart" height="200"></canvas>
        </div>

        <!-- Pie Chart: Payment Method Breakdown -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Payment Method Split</h2>
            <canvas id="paymentMethodChart" height="200"></canvas>
        </div>
    </div>

    <!-- Detailed Tables (same as before) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Sales by Date -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Sales by Date</h2>
            </div>
            <div class="p-6">
                @if($salesData->count())
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                            <th class="py-2 text-right text-xs font-medium text-gray-500 uppercase">Appointments</th>
                            <th class="py-2 text-right text-xs font-medium text-gray-500 uppercase">Total Sales</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($salesData as $data)
                        <tr>
                            <td class="py-2 text-left">{{ \Carbon\Carbon::parse($data->date)->format('M d, Y') }}</td>
                            <td class="py-2 text-right">{{ $data->count }}</td>
                            <td class="py-2 text-right">₱{{ number_format($data->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-gray-500 text-center py-4">No sales data for selected filters.</p>
                @endif
            </div>
        </div>

        <!-- Payment Method Breakdown Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Payment Method Breakdown</h2>
            </div>
            <div class="p-6">
                @if($paymentMethodBreakdown->count())
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                            <th class="py-2 text-right text-xs font-medium text-gray-500 uppercase">Count</th>
                            <th class="py-2 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($paymentMethodBreakdown as $method)
                        <tr>
                            <td class="py-2 text-left">{{ $method->payment_method == 'gcash' ? 'GCash' : 'Cash' }}</td>
                            <td class="py-2 text-right">{{ $method->count }}</td>
                            <td class="py-2 text-right">₱{{ number_format($method->total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-gray-500 text-center py-4">No payment data.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function() {
        // Pass PHP data using json_encode
        const reportData = <?php echo json_encode([
                                'salesData' => $salesData->map(fn($item) => [
                                    'date'  => \Carbon\Carbon::parse($item->date)->format('M d'),
                                    'total' => $item->total,
                                    'count' => $item->count,
                                ])->values(),
                                'paymentMethodBreakdown' => $paymentMethodBreakdown->map(fn($item) => [
                                    'method' => $item->payment_method == 'gcash' ? 'GCash' : 'Cash',
                                    'total'  => $item->total,
                                    'count'  => $item->count,
                                ])->values(),
                            ]); ?>;

        // Wait for the DOM to be fully loaded
        function initCharts() {
            // Line chart
            const lineCanvas = document.getElementById('salesTrendChart');
            if (!lineCanvas) {
                console.error('Canvas #salesTrendChart not found');
                return;
            }
            const lineCtx = lineCanvas.getContext('2d');
            const lineLabels = reportData.salesData.map(item => item.date);
            const lineValues = reportData.salesData.map(item => item.total);

            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: lineLabels,
                    datasets: [{
                        label: 'Sales (₱)',
                        data: lineValues,
                        backgroundColor: 'rgba(193, 154, 107, 0.2)',
                        borderColor: '#c19a6b',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
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
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: (val) => '₱' + val.toFixed(2)
                            }
                        }
                    }
                }
            });

            // Pie chart
            const pieCanvas = document.getElementById('paymentMethodChart');
            if (!pieCanvas) {
                console.error('Canvas #paymentMethodChart not found');
                return;
            }
            if (reportData.paymentMethodBreakdown.length) {
                const pieCtx = pieCanvas.getContext('2d');
                const pieLabels = reportData.paymentMethodBreakdown.map(item => item.method);
                const pieValues = reportData.paymentMethodBreakdown.map(item => item.total);
                new Chart(pieCtx, {
                    type: 'pie',
                    data: {
                        labels: pieLabels,
                        datasets: [{
                            data: pieValues,
                            backgroundColor: ['#c19a6b', '#4A6D8C'],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => `${ctx.label}: ₱${ctx.raw.toFixed(2)}`
                                }
                            }
                        }
                    }
                });
            } else {
                pieCanvas.parentElement.innerHTML += '<p class="text-gray-500 text-center mt-4">No payment data available.</p>';
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initCharts);
        } else {
            initCharts();
        }
    })();
</script>
@endsection