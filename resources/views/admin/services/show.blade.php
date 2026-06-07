@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Service Details</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column: Image -->
            <div class="lg:w-1/3">
                <div class="border-2 border-gray-200 rounded-lg p-4 text-center bg-gray-50">
                    @if($service->image && image_exists($service->image))
                    <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="max-w-full max-h-64 object-contain mx-auto">
                    @else
                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Service Details (read-only) -->
            <div class="lg:w-2/3">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Service Name</label>
                        <p class="mt-1 text-gray-900">{{ $service->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-gray-900">{{ $service->description ?: 'No description' }}</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Price (₱)</label>
                            <p class="mt-1 text-gray-900">₱{{ number_format($service->price, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                            <p class="mt-1 text-gray-900">{{ $service->duration }} mins</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <p class="mt-1 text-gray-900">{{ $service->category }}</p>
                    </div>
                </div>

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

                <div class="mt-6 flex gap-4">
                    <a href="{{ route('admin.services.index') }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Back to Services</a>
                    <a href="{{ route('admin.services.edit', $service) }}" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition">Edit Service</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection