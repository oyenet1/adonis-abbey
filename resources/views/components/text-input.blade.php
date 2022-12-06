<div class="w-full space-y-1">
    <label for="{{ $name }}" class="text-sm capitalize">{{ $label }}</label>
    <input
        {{ $attributes->merge(['class' => 'w-full shadow-sm border border-primary bg-white placeholder-gray-500 text-dark h-full pt-6  pl-4 peer focus:outline-none font-medium shadow rounded-lg focus:bg-white tt focus:border-2 focus:border-primary', 'type' => $type, 'name' => $name, 'id' => $name]) }} />
    @error($name)
        <span class="mb-2 text-red-600 text-sm">{{ $message }}</span>
    @enderror
</div>
