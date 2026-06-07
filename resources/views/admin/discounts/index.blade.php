@extends('layouts.admin')

@section('content')
<div class="py-2">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Promos & Discounts</h1>
        <a href="{{ route('admin.discounts.create') }}"
            class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition min-w-[190px] text-center flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Add Discount</span>
        </a>
    </div>

    <!-- Toolbar -->
    <div class="bg-white rounded-lg shadow p-3 mb-6">
        <div class="flex flex-wrap items-center gap-2">
            <!-- Search input with icon -->
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search name or code..."
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm">
            </div>

            <!-- Type filter dropdown -->
            <select name="type" id="type" class="block w-32 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                <option value="">All Types</option>
                <option value="fixed" {{ request('type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                <option value="percentage" {{ request('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
            </select>

            <!-- Filter button -->
            <button type="submit" form="filter-form" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary hover:bg-secondary hover:text-white transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Filter
            </button>

            <!-- Clear button -->
            <a href="{{ route('admin.discounts.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                Clear
            </a>

            <!-- Archive icon button -->
            <a href="{{ route('admin.discounts.archived') }}" class="ml-auto text-gray-500 hover:text-primary transition duration-150 ease-in-out transform hover:scale-110 p-2" title="Archived">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Hidden form to submit filter -->
    <form id="filter-form" method="GET" action="{{ route('admin.discounts.index') }}" class="hidden">
        <input type="hidden" name="search" id="hidden-search" value="{{ request('search') }}">
        <input type="hidden" name="type" id="hidden-type" value="{{ request('type') }}">
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Value</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valid From</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Valid Until</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($discounts as $discount)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $discount->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $discount->code }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($discount->type) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($discount->type == 'percentage')
                            {{ $discount->value }}%
                            @else
                            ₱{{ number_format($discount->value, 2) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $discount->start_date ? $discount->start_date->format('M d, Y') : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $discount->end_date ? $discount->end_date->format('M d, Y') : 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.discounts.edit', $discount) }}" class="text-blue-600 hover:text-blue-900 mr-1" title="Edit">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button @click="confirmAction('Archive Discount', 'Are you sure you want to archive this discount?', '{{ route('admin.discounts.destroy', $discount) }}', 'DELETE', 'Archive', true)"
                                class="text-red-600 hover:text-red-900" title="Archive">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-500">No discounts found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $discounts->appends(request()->except('page'))->links() }}
    </div>
</div>

<script>
    document.querySelector('button[type="submit"][form="filter-form"]').addEventListener('click', function(e) {
        document.getElementById('hidden-search').value = document.getElementById('search').value;
        document.getElementById('hidden-type').value = document.getElementById('type').value; // changed
    });
</script>
@endsection