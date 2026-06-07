@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Add New Service</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form id="createServiceForm" method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data"
            x-data="{
                  name: '{{ old('name') }}',
                  description: '{{ old('description') }}',
                  price: '{{ old('price') }}',
                  duration: '{{ old('duration') }}',
                  category: '{{ old('category') }}',
                  get isComplete() {
                      return this.name.trim() !== '' &&
                             this.price !== '' &&
                             this.duration !== '' &&
                             this.category !== '';
                  }
              }">
            @csrf

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column: Image Upload & Preview -->
                <div class="lg:w-1/3">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <label for="image" class="cursor-pointer block">
                            <div id="previewContainer" class="mb-4 flex justify-center">
                                <img id="preview" src="#" alt="Preview" class="max-w-full max-h-64 object-contain hidden">
                                <div id="placeholder" class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">Click to upload image</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF (max 2MB)</p>
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden">
                        @error('image') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Right Column: Form Fields -->
                <div class="lg:w-2/3">
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Service Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" x-model="name" value="{{ old('name') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" x-model="description" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price (₱) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="price" id="price" x-model="price" value="{{ old('price') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes) <span class="text-red-500">*</span></label>
                                <input type="number" name="duration" id="duration" x-model="duration" value="{{ old('duration') }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                @error('duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                            <select name="category" id="category" x-model="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                <option value="">Select Category</option>
                                <option value="Haircut" {{ old('category') == 'Haircut' ? 'selected' : '' }}>Haircut</option>
                                <option value="Hair Color" {{ old('category') == 'Hair Color' ? 'selected' : '' }}>Hair Color</option>
                                <option value="Treatment" {{ old('category') == 'Treatment' ? 'selected' : '' }}>Treatment</option>
                                <option value="Rebonding" {{ old('category') == 'Rebonding' ? 'selected' : '' }}>Rebonding</option>
                                <option value="Manicure" {{ old('category') == 'Manicure' ? 'selected' : '' }}>Manicure</option>
                                <option value="Pedicure" {{ old('category') == 'Pedicure' ? 'selected' : '' }}>Pedicure</option>
                                <option value="Gel Polish" {{ old('category') == 'Gel Polish' ? 'selected' : '' }}>Gel Polish</option>
                                <option value="Others" {{ old('category') == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('admin.services.index') }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Cancel</a>
                        <button type="button"
                            class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!isComplete"
                            @click="confirmAction('Create Service', 'Are you sure you want to create this service?', '#createServiceForm', 'POST', 'Create', true)">
                            Create Service
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Image preview
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('placeholder');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    });
</script>
@endsection