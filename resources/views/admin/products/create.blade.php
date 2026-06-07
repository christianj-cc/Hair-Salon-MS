@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Add New Product</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form id="createProductForm" method="POST" action="{{ route('admin.products.store') }}"
            x-data="{
                  name: '{{ old('name') }}',
                  category: '{{ old('category') }}',
                  size: '{{ old('size') }}',
                  quantity: '{{ old('quantity') }}',
                  price: '{{ old('price') }}',
                  get isComplete() {
                      return this.name.trim() !== '' &&
                             this.category !== '' &&
                             this.quantity !== '';
                  }
              }">
            @csrf

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" x-model="name" value="{{ old('name') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                    <select name="category" id="category" x-model="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                        <option value="">Select Category</option>
                        <option value="Shampoo" {{ old('category') == 'Shampoo' ? 'selected' : '' }}>Shampoo</option>
                        <option value="Conditioner" {{ old('category') == 'Conditioner' ? 'selected' : '' }}>Conditioner</option>
                        <option value="Hair Color" {{ old('category') == 'Hair Color' ? 'selected' : '' }}>Hair Color</option>
                        <option value="Treatment Products" {{ old('category') == 'Treatment Products' ? 'selected' : '' }}>Treatment Products</option>
                        <option value="Styling Tools" {{ old('category') == 'Styling Tools' ? 'selected' : '' }}>Styling Tools</option>
                        <option value="Nail Products" {{ old('category') == 'Nail Products' ? 'selected' : '' }}>Nail Products</option>
                        <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700">Size <span class="text-red-500">*</span></label>
                    <input type="text" name="size" id="size" x-model="size" value="{{ old('size') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                    @error('size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity <span class="text-red-500">*</span></label>
                    <input type="number" step="1" name="quantity" id="quantity" x-model="quantity" value="{{ old('quantity') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                    @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price (Optional)</label>
                    <input type="number" step="1.00" name="price" id="price" x-model="price" value="{{ old('price') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <a href="{{ route('admin.products.index') }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Cancel</a>
                <button type="button"
                    class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="!isComplete"
                    @click="confirmAction('Create Product', 'Are you sure you want to create this product?', '#createProductForm', 'POST', 'Create', true)">
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection