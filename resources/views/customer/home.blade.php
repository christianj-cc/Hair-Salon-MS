@extends('layouts.customer')

@section('content')
<!-- Hero Section with Background Image -->
<section class="relative hero-section hero-bg h-96 md:h-128 flex items-center">
    <!-- <div class="absolute inset-0 bg-black bg-opacity-50"></div> -->
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="text-left">
            <p class="text-2xl text-white m-0">Welcome to</p>
            <h1 class="text-7xl text-white font-bold m-0">LEO REVITA</h1>
            <h1 class="text-7xl text-white font-bold m-0">HAIR SALON</h1>
            <p class="text-xl text-white mt-4 mb-8">Premium hair styling tailored to your unique look.</p>
            <div class="transition transform hover:scale-110 inline-block">
                <a href="{{ route('services.index') }}" class="bg-white text-primary px-8 py-3 rounded-full font-semibold hover:bg-primary-dark">Browse Services</a>
            </div>
        </div>
    </div>
</section>

<section class=" py-16">
    <!-- Values / Team Highlights -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center">Why Choose Us</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
            <div class="text-center p-6 bg-white rounded-lg shadow transition transform hover:scale-110">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Experienced Team</h3>
                <p class="text-gray-600">Our stylists have years of experience and ongoing training.</p>
            </div>
            <div class="text-center p-6 bg-white rounded-lg shadow transition transform hover:scale-110">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Premium Products</h3>
                <p class="text-gray-600">We use only high-quality, professional products for lasting results.</p>
            </div>
            <div class="text-center p-6 bg-white rounded-lg shadow transition transform hover:scale-110">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-primary text-white mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold mb-2">Personalized Service</h3>
                <p class="text-gray-600">We listen to your needs and tailor each service to you.</p>
            </div>
        </div>
    </div>
</section>

<!-- Featured Services -->
<section class="mb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-gray-900 text-center mb-12">Our Featured Services</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredServices as $service)
            <div class="bg-white rounded-lg shadow overflow-hidden flex flex-col h-full transition transform hover:scale-110">
                @if($service->image)
                <img src="{{ asset('storage/' . $service->image) }}" alt="{{ $service->name }}" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                @endif
                <div class="p-4 flex-1 flex flex-col">
                    <h3 class="text-lg font-semibold">{{ $service->name }}</h3>
                    <p class="text-gray-600 text-sm mt-1 flex-1">{{ Str::limit($service->description, 80) }}</p>
                    <div class="mt-4 flex justify-between items-center">
                        <span class="text-primary font-bold">₱{{ number_format($service->price, 2) }}</span>
                        <a href="{{ route('services.show', $service) }}" class="text-primary hover:text-primary-dark">Learn More →</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection