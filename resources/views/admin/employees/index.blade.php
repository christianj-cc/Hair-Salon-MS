@extends('layouts.admin')

@section('content')
<div class="py-2">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Employees</h1>
        <a href="{{ route('admin.employees.create') }}"
            class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition min-w-[190px] text-center flex items-center justify-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            <span>Add Employee</span>
        </a>
    </div>

    <!-- Toolbar -->
    <div class="bg-white rounded-lg shadow p-3 mb-6">
        <div class="flex flex-wrap items-center gap-2">
            <!-- Search -->
            <div class="relative flex-1 min-w-[200px]">
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search name or email..."
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md">
            </div>

            <!-- Job Role filter -->
            <select name="job_role" id="job_role" class="block w-40 py-2 border-gray-300 rounded-md">
                <option value="">All Job Roles</option>
                <option value="Hair Stylist" {{ request('job_role') == 'Hair Stylist' ? 'selected' : '' }}>Hair Stylist</option>
                <option value="Nail Technician" {{ request('job_role') == 'Nail Technician' ? 'selected' : '' }}>Nail Technician</option>
                <option value="Front Desk" {{ request('job_role') == 'Front Desk' ? 'selected' : '' }}>Front Desk</option>
                <option value="Manager" {{ request('job_role') == 'Manager' ? 'selected' : '' }}>Manager</option>
            </select>

            <!-- Status filter -->
            <select name="status" id="status" class="block w-40 py-2 border-gray-300 rounded-md">
                <option value="">All Status</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="invited" {{ request('status') == 'invited' ? 'selected' : '' }}>Pending Invite</option>
            </select>

            <!-- Filter & Clear buttons -->
            <button type="submit" form="filter-form" class="bg-primary text-white px-4 py-2 rounded-md">Filter</button>
            <a href="{{ route('admin.employees.index') }}" class="border border-gray-300 px-4 py-2 rounded-md">Clear</a>

            <!-- Archive link -->
            <a href="{{ route('admin.employees.archived') }}" class="ml-auto text-gray-500 hover:text-primary" title="Archived">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
            </a>
        </div>
    </div>

    <!-- Hidden form for filter submission -->
    <form id="filter-form" method="GET" action="{{ route('admin.employees.index') }}" class="hidden">
        <input type="hidden" name="search" id="hidden-search" value="{{ request('search') }}">
        <input type="hidden" name="job_role" id="hidden-job_role" value="{{ request('job_role') }}">
        <input type="hidden" name="status" id="hidden-status" value="{{ request('status') }}">
    </form>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mobile</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invite Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Invite Actions</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($employees as $employee)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if(image_exists($employee->image))
                            <img src="{{ asset('storage/' . $employee->image) }}" alt="Profile" class="h-10 w-10 rounded-full object-cover">
                            @else
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->first_name }} {{ $employee->last_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->mobile_num ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $employee->jobRole->title }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($employee->user->status == 'active')
                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                            @elseif($employee->user->status == 'invited')
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                            @else
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">Archived</span>
                            @endif
                        </td>
                        @if($employee->user->status == 'invited')
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.employees.resend-invitation', $employee) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-blue-600 hover:text-blue-900" title="Resend invitation email">
                                    <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </form>
                            <button @click="confirmAction('Cancel Invite', 'Are you sure you want to cancel this invitation?', '{{ route('admin.employees.destroy-invite', $employee) }}', 'DELETE', 'Cancel', true)" class="text-red-600 hover:text-red-900 ml-2" title="Cancel invitation">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </td>
                        @else
                        <td class="px-6 py-4 whitespace-nowrap text-gray-400">
                            ---
                        </td>
                        @endif
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a href="{{ route('admin.employees.show', $employee) }}" class="text-green-600 hover:text-green-900 mr-1" title="View Details">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            <a href="{{ route('admin.employees.edit', $employee) }}" class="text-blue-600 hover:text-blue-900 mr-1" title="Edit">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <button @click="confirmAction('Archive Employee', 'Are you sure you want to archive this employee?', 
                        '{{ route('admin.employees.destroy', $employee) }}', 'DELETE', 'Archive', true)" class="text-red-600 hover:text-red-900" title="Archive">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No employees found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        {{ $employees->appends(request()->except('page'))->links() }}
    </div>
</div>

<script>
    document.getElementById('filter-form').addEventListener('submit', function(e) {
        document.getElementById('hidden-search').value = document.getElementById('search').value;
        document.getElementById('hidden-job_role').value = document.getElementById('job_role').value;
        document.getElementById('hidden-status').value = document.getElementById('status').value;
    });
</script>

@endsection