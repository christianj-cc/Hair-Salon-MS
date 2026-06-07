@extends('layouts.customer')

@section('content')
<div class="py-3 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-4xl font-bold text-gray-900 mb-8 mt-4 text-center">Our Services</h2>
        <!-- Search Bar -->
        <div class="mb-2">
            <form method="GET" action="{{ route('services.index') }}" class="flex gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search services..." class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary focus:border-primary sm:text-sm">
                </div>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-gray-300 transition">Search</button>
                @if(request('search') || request('category'))
                <a href="{{ route('services.index') }}" class="bg-gray-50 text-gray-900 px-4 py-2 rounded-md hover:bg-gray-200 transition">Clear</a>
                @endif
            </form>
        </div>

        <!-- Category Tabs (sticky, scrollable on mobile) -->
        <div class="sticky top-16 z-10 bg-gray-50 border-b border-gray-200">
            <div class="overflow-x-auto scrollbar-hide">
                <nav class="flex flex-nowrap justify-start md:justify-center gap-2">
                    <a href="{{ route('services.index', ['search' => request('search')]) }}"
                        class="inline-block py-3 px-5 text-sm font-medium whitespace-nowrap {{ !request('category') ? 'border-b-4 border-primary text-primary' : 'text-gray-500 hover:text-gray-700' }}">
                        All
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('services.index', ['category' => $cat, 'search' => request('search')]) }}"
                        class="inline-block py-3 px-5 text-sm font-medium whitespace-nowrap {{ request('category') == $cat ? 'border-b-4 border-primary text-primary' : 'text-gray-500 hover:text-gray-700' }}">
                        {{ $cat }}
                    </a>
                    @endforeach
                </nav>
            </div>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach($services as $service)
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col transition transform hover:scale-110">
                <div class=" h-48 w-full overflow-hidden">
                    @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @endif
                </div>
                <div class="p-4 flex-1">
                    <h3 class="text-lg font-semibold text-gray-900">{{ $service->name }}</h3>
                    <p class="text-gray-600 text-sm mt-1 line-clamp-2">{{ Str::limit($service->description, 100) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-primary font-bold text-xl">₱{{ number_format($service->price, 2) }}</span>
                        <span class="text-sm text-gray-500">{{ $service->duration }} mins</span>
                    </div>
                </div>
                <div class="px-4 pb-4">
                    <a href="{{ route('services.show', $service) }}" class="block text-center bg-primary text-white py-2 rounded-md hover:bg-primary-dark transition">View Details</a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $services->appends(request()->except('page'))->links() }}
        </div>
    </div>
</div>
@endsection