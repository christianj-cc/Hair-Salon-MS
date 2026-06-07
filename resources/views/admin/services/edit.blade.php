@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.services.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Edit Service</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <!-- ===== MAIN SERVICE UPDATE FORM ===== -->
        <form id="editServiceForm" method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data"
            x-data="{
                  name: '{{ old('name', $service->name) }}',
                  description: '{{ old('description', $service->description) }}',
                  price: '{{ old('price', $service->price) }}',
                  duration: '{{ old('duration', $service->duration) }}',
                  category: '{{ old('category', $service->category) }}',
                  get isComplete() {
                      return this.name.trim() !== '' &&
                             this.price !== '' &&
                             this.duration !== '' &&
                             this.category !== '';
                  }
              }">
            @csrf
            @method('PUT')

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left Column: Image Upload & Preview -->
                <div class="lg:w-1/3">
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <label for="image" class="cursor-pointer block">
                            <div id="previewContainer" class="mb-4 flex justify-center">
                                <img id="preview" src="#" alt="Preview" class="max-w-full max-h-64 object-contain hidden">
                                <div id="placeholder" class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                    @if($service->image && image_exists($service->image))
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="Current image" class="max-w-full max-h-48 object-contain">
                                    @else
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    @endif
                                </div>
                            </div>
                            <p class="text-sm text-gray-600">Click to change image</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF (max 2MB)</p>
                        </label>
                        <input type="file" name="image" id="image" accept="image/*" class="hidden">
                        @error('image') <p class="text-red-500 text-xs mt-2">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Right Column: Service Fields -->
                <div class="lg:w-2/3">
                    <div class="grid grid-cols-1 gap-4">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Service Name <span class="text-red-500">*</span></label>
                            <input type="text" name="name" id="name" x-model="name" value="{{ old('name', $service->name) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" id="description" x-model="description" rows="3"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">{{ old('description', $service->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Price (₱) <span class="text-red-500">*</span></label>
                                <input type="number" step="0.01" name="price" id="price" x-model="price" value="{{ old('price', $service->price) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                @error('price') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <!-- Duration -->
                            <div>
                                <label for="duration" class="block text-sm font-medium text-gray-700">Duration (minutes) <span class="text-red-500">*</span></label>
                                <input type="number" name="duration" id="duration" x-model="duration" value="{{ old('duration', $service->duration) }}"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                @error('duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category <span class="text-red-500">*</span></label>
                            <select name="category" id="category" x-model="category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                                <option value="">Select Category</option>
                                <option value="Haircut" {{ old('category', $service->category) == 'Haircut' ? 'selected' : '' }}>Haircut</option>
                                <option value="Hair Color" {{ old('category', $service->category) == 'Hair Color' ? 'selected' : '' }}>Hair Color</option>
                                <option value="Treatment" {{ old('category', $service->category) == 'Treatment' ? 'selected' : '' }}>Treatment</option>
                                <option value="Rebonding" {{ old('category', $service->category) == 'Rebonding' ? 'selected' : '' }}>Rebonding</option>
                                <option value="Manicure" {{ old('category', $service->category) == 'Manicure' ? 'selected' : '' }}>Manicure</option>
                                <option value="Pedicure" {{ old('category', $service->category) == 'Pedicure' ? 'selected' : '' }}>Pedicure</option>
                                <option value="Gel Polish" {{ old('category', $service->category) == 'Gel Polish' ? 'selected' : '' }}>Gel Polish</option>
                                <option value="Others" {{ old('category', $service->category) == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                            @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('admin.services.index') }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Cancel</a>
                        <button type="button"
                            @click="confirmAction('Update Service', 'Are you sure you want to update this service?', '#editServiceForm', 'POST', 'Update', true)"
                            class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition">
                            Update Service
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- ===== PRODUCT ASSIGNMENT SECTION (outside main form) ===== -->
        <div class="mt-8 border-t pt-6">
            <h3 class="text-lg font-medium mb-4">Products used in this service</h3>

            <!-- Existing products table -->
            <div class="overflow-x-auto mb-4">
                <table class="min-w-full bg-white border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-4 py-2 text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($service->products as $product)
                        <tr>
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('admin.services.products.update', [$service, $product]) }}" class="inline-flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity_used" value="{{ $product->pivot->quantity_used }}" class="w-20 border rounded px-1" min="1">
                                    <button type="submit" class="text-blue-600 hover:text-blue-900" title="Update quantity">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-2 text-center">
                                <form method="POST" action="{{ route('admin.services.products.detach', [$service, $product]) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-900" title="Remove product">
                                        <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-4 text-gray-500">No products assigned yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Add new product assignment -->
            <div class="bg-gray-50 p-4 rounded">
                <label class="block text-sm font-medium mb-1">Add a product to this service</label>
                <div class="flex flex-wrap gap-2 mb-2">
                    <select id="new_product_id" class="border rounded px-3 py-2 flex-1">
                        <option value="">Select product...</option>
                        @foreach($allProducts as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->quantity }})</option>
                        @endforeach
                    </select>
                    <input type="number" id="new_quantity" placeholder="Qty" class="w-24 border rounded px-2" min="1">
                    <button type="button" id="attachProductBtn" class="bg-primary text-white px-4 rounded">Add</button>
                </div>
                <div id="attachErrors" class="text-red-600 text-sm mt-1 space-y-1"></div>
            </div>
        </div>
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

    // Click preview area to open file picker
    document.getElementById('previewContainer').addEventListener('click', function() {
        document.getElementById('image').click();
    });
</script>

<script>
    // AJAX attach product
    document.getElementById('attachProductBtn')?.addEventListener('click', function() {
        const errorContainer = document.getElementById('attachErrors');
        errorContainer.innerHTML = '';

        let productId = document.getElementById('new_product_id').value;
        let quantity = document.getElementById('new_quantity').value;

        if (!productId) {
            errorContainer.innerHTML = '<div>Please select a product.</div>';
            return;
        }
        if (!quantity || quantity < 1) {
            errorContainer.innerHTML = '<div>Please enter a valid quantity (minimum 1).</div>';
            return;
        }

        fetch('{{ route("admin.services.products.attach", $service) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity_used: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    if (data.errors) {
                        let errorHtml = '';
                        for (let field in data.errors) {
                            data.errors[field].forEach(msg => {
                                errorHtml += `<div>${msg}</div>`;
                            });
                        }
                        errorContainer.innerHTML = errorHtml;
                    } else if (data.message) {
                        errorContainer.innerHTML = `<div>${data.message}</div>`;
                    } else {
                        errorContainer.innerHTML = '<div>An unknown error occurred.</div>';
                    }
                }
            })
            .catch(() => {
                errorContainer.innerHTML = '<div>Network error. Please try again.</div>';
            });
    });
</script>
@endsection