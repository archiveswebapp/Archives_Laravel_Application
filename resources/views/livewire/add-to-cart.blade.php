<div class="space-y-3">
    {{-- Quantity input --}}
    <div class="flex items-center gap-3">
        <label for="qty" class="sr-only">Quantity</label>
        <input
            id="qty"
            name="qty"
            type="number"
            min="1"
            step="1"
            wire:model.live="qty"
            class="w-20 rounded border-gray-300 focus:ring-indigo-500 focus:border-indigo-500"
        />

        {{-- Add to cart button --}}
        <button
            type="button"
            wire:click="add"
            wire:loading.attr="disabled"
            wire:target="add"
            class="px-5 py-3 bg-indigo-600 text-white rounded hover:bg-indigo-700 disabled:opacity-60"
        >
            <span wire:loading.remove wire:target="add">Add to Cart</span>
            <span wire:loading wire:target="add">Adding…</span>
        </button>
    </div>

    {{-- Validation error from Livewire --}}
    @error('qty')
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror

    {{-- Optional flash message from session --}}
    @if (session('status'))
        <p class="text-sm text-green-600">{{ session('status') }}</p>
    @endif
</div>
