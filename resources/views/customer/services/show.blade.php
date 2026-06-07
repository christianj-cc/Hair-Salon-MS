@extends('layouts.customer')

@section('content')
<div class="py-5 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back to Services -->
        <div class="flex items-center mb-6">
            <a href="{{ route('services.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">&nbsp;&nbsp;Back to Services</h1>
        </div>

        <!-- Main Service Card -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-12">
            <div class="md:flex">
                <!-- Image Container (square) -->
                <div class="md:w-1/2">
                    <div class="aspect-square w-full overflow-hidden bg-gray-100">
                        @if($service->image)
                        <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Details Container -->
                <div class="p-10 md:w-1/2 flex flex-col justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mt-4 md:mt-20">{{ $service->name }}</h1>
                        <div class="mt-4 space-y-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="mt-1 text-gray-700">{{ $service->description }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Price</dt>
                                <dd class="mt-1 text-2xl font-bold text-primary">₱{{ number_format($service->price, 2) }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Duration</dt>
                                <dd class="mt-1 text-lg text-gray-700">{{ $service->duration }} minutes</dd>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-between items-center">
                        <!--<a href="{{ route('services.index') }}" class="inline-block text-gray-900 px-6 py-3 rounded-md hover:text-gray-300 transition">Back to Services</a>-->
                        <a href="{{ route('customer.appointments.create', ['service_id' => $service->id]) }}" class="inline-block bg-primary text-white px-6 py-3 rounded-md hover:bg-primary-dark hover:text-gray-700 transition">Book Now</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- You Might Also Like Section -->
        @if($relatedServices->count())
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6">You Might Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($relatedServices as $related)
                <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col transition transform hover:scale-110">
                    @if($related->image)
                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-full h-48 object-cover">
                    @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    @endif
                    <div class="p-4 flex-1 flex flex-col">
                        <h3 class="text-lg font-semibold">{{ $related->name }}</h3>
                        <p class="text-gray-600 text-sm mt-1 flex-1">{{ Str::limit($related->description, 80) }}</p>
                        <div class="mt-4 flex justify-between items-center">
                            <span class="text-primary font-bold">₱{{ number_format($related->price, 2) }}</span>
                            <a href="{{ route('services.show', $related) }}" class="text-primary hover:text-primary-dark">View Details →</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection