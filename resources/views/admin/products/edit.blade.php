@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-primary hover:text-primary-dark transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Product</h1>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <form id="editProductForm" method="POST" action="{{ route('admin.products.update', $product) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                    <select name="category" id="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Select Category</option>
                        <option value="Shampoo" {{ old('category', $product->category) == 'Shampoo' ? 'selected' : '' }}>Shampoo</option>
                        <option value="Conditioner" {{ old('category', $product->category) == 'Conditioner' ? 'selected' : '' }}>Conditioner</option>
                        <option value="Hair Color" {{ old('category', $product->category) == 'Hair Color' ? 'selected' : '' }}>Hair Color</option>
                        <option value="Treatment Products" {{ old('category', $product->category) == 'Treatment Products' ? 'selected' : '' }}>Treatment Products</option>
                        <option value="Styling Tools" {{ old('category', $product->category) == 'Styling Tools' ? 'selected' : '' }}>Styling Tools</option>
                        <option value="Nail Products" {{ old('category', $product->category) == 'Nail Products' ? 'selected' : '' }}>Nail Products</option>
                        <option value="Others" {{ old('category', $product->category) == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700">Size <span class="text-red-500">*</span></label>
                    <input type="text" name="size" id="size" value="{{ old('size', $product->size) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('size') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $product->quantity) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                    @error('quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price (Optional)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center gap-4">
                <a href="{{ route('admin.products.index') }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Cancel</a>
                <button type="button" @click="confirmAction('Update Product', 'Are you sure you want to update this product?', '#editProductForm', 
                        'POST', 'Update', true)" class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition">Update Product</button>
            </div>
        </form>
    </div>
</div>
@endsection