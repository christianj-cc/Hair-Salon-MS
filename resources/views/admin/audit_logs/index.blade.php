@extends('layouts.admin')

@section('content')
<div class="py-3">
    <h1 class="text-2xl font-semibold text-gray-900 mb-6">Audit Logs</h1>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">
            <div>
                <label for="user" class="block text-sm font-medium text-gray-700">User</label>
                <select name="user" id="user" class="mt-1 block w-48 border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    <option value="">All users</option>
                    @foreach($users as $id => $name)
                    <option value="{{ $id }}" {{ request('user') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="action" class="block text-sm font-medium text-gray-700">Action</label>
                <select name="action" id="action" class="mt-1 block w-40 border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    <option value="">All actions</option>
                    @foreach($actions as $action)
                    <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>{{ ucfirst($action) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                <select name="model" id="model" class="mt-1 block w-48 border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    <option value="">All models</option>
                    @foreach($models as $model)
                    <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>
                        {{ class_basename($model) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark">Filter</button>
            <a href="{{ route('admin.audit_logs.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-primary-dark transition">Clear</a>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Timestamp</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Model</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Old Values</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">New Values</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($logs as $log)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->user->name ?? 'System' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($log->action) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ class_basename($log->model_type) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->model_id }}</td>
                    <td class="px-6 py-4 max-w-xs truncate">
                        @if($log->old_values)
                        <pre class="text-xs">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
                        @else
                        —
                        @endif
                    </td>
                    <td class="px-6 py-4 max-w-xs truncate">
                        @if($log->new_values)
                        <pre class="text-xs">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
                        @else
                        —
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $log->ip }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">No audit logs found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">
            {{ $logs->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>
@endsection