@extends('layouts.admin')

@section('content')
<div class="py-3">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.discounts.index') }}" class="inline-flex items-center text-gray-500 hover:text-primary transition mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Add New Discount</h1>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form id="createDiscountForm" method="POST" action="{{ route('admin.discounts.store') }}"
            x-data="{
                  name: '{{ old('name') }}',
                  code: '{{ old('code') }}',
                  type: '{{ old('type', 'percentage') }}',
                  value: '{{ old('value') }}',
                  start_date: '{{ old('start_date') }}',
                  end_date: '{{ old('end_date') }}',
                  get isComplete() {
                      return this.name.trim() !== '' &&
                             this.code.trim() !== '' &&
                             this.value !== '';
                  }
              }">
            @csrf

            <div class="grid grid-cols-1 gap-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Discount Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" x-model="name" value="{{ old('name') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">Discount Code <span class="text-red-500">*</span></label>
                    <input type="text" name="code" id="code" x-model="code" value="{{ old('code') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                    @error('code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Type <span class="text-red-500">*</span></label>
                    <select name="type" id="type" x-model="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                        <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                    </select>
                    @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="value" class="block text-sm font-medium text-gray-700">Value <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="value" id="value" x-model="value" value="{{ old('value') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary" required>
                    @error('value') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date (optional)</label>
                    <input type="date" name="start_date" id="start_date" x-model="start_date" value="{{ old('start_date') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date (optional)</label>
                    <input type="date" name="end_date" id="end_date" x-model="end_date" value="{{ old('end_date') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="usage_limit" class="block text-sm font-medium text-gray-700">Usage Limit (per customer, optional)</label>
                    <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit', $discount->usage_limit) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-primary focus:ring-primary">
                    @error('usage_limit') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <a href="{{ route('admin.discounts.index') }}" class="bg-none text-gray-900 px-6 py-2 rounded-md hover:bg-primary-dark transition">Cancel</a>
                <button type="button"
                    class="bg-primary text-white px-6 py-2 rounded-md hover:bg-primary-dark transition disabled:opacity-50 disabled:cursor-not-allowed"
                    :disabled="!isComplete"
                    @click="confirmAction('Create Discount', 'Are you sure you want to create this discount?', '#createDiscountForm', 'POST', 'Create', true)">
                    Create Discount
                </button>
            </div>
        </form>
    </div>
</div>
@endsection