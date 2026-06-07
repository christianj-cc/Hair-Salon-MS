@props(['name', 'label', 'type' => 'text', 'model' => null, 'required' => false])

<div x-data="{ 
        value: @entangle($model).defer, 
        focused: false,
        hasValue() { return this.value && this.value.trim() !== '' }
    }"
    x-effect="() => { if (value) hasValue = true }"
    class="relative mt-4">
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        x-model="value"
        @focus="focused = true"
        @blur="focused = false"
        class="peer w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary"
        :class="{ 'border-primary': focused || hasValue() }"
        {{ $required ? 'required' : '' }}>
    <label
        for="{{ $name }}"
        class="absolute left-4 px-1 transition-all duration-200 bg-white pointer-events-none"
        :class="{
            'top-2 text-xs text-primary': focused || hasValue(),
            'top-1/2 -translate-y-1/2 text-gray-500': !focused && !hasValue()
        }">
        {{ $label }}
    </label>
</div>