<div class="space-y-4">

    {{-- Product Name --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Name</label>
        <input name="name"
               value="{{ old('name', $product->name) }}"
               class="border rounded w-full px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
               required>
        @error('name')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Category --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Category</label>
        <select name="category_id"
                class="border rounded w-full px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
                required>
            <option value="">-- Select --</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}"
                        @selected(old('category_id', $product->category_id) == $c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Price --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Price (Rs.)</label>
        <input name="price" type="number" step="0.01" min="0"
               value="{{ old('price', $product->price) }}"
               class="border rounded w-full px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
               required>
        @error('price')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Stock --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Stock</label>
        <input name="stock" type="number" min="0"
               value="{{ old('stock', $product->stock ?? 0) }}"
               class="border rounded w-full px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none"
               required>
        @error('stock')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Description --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" rows="4"
                  class="border rounded w-full px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">{{ old('description', $product->description) }}</textarea>
        @error('description')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Image --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Image</label>
        <input type="file" name="image"
               class="border rounded w-full px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

        {{-- Show current image if editing --}}
        @if($product->image)
            <div class="mt-2">
                <img src="{{ Str::startsWith($product->image, 'products/') 
                              ? asset('storage/'.$product->image) 
                              : asset('images/'.$product->image) }}"
                     alt="{{ $product->name }}"
                     class="h-20 w-20 rounded object-cover border shadow">
            </div>
        @endif

        @error('image')
            <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
        @enderror
    </div>

    {{-- Buttons --}}
    <div class="pt-2 flex items-center space-x-2">
        <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded shadow">
            {{ $button }}
        </button>
        <a href="{{ route('admin.products.index') }}"
           class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded shadow">
            Cancel
        </a>
    </div>

</div>
