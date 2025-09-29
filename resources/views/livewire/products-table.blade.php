<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Search -->
    <div class="p-4 border-b bg-gray-50">
        <input type="text" wire:model.live="q" placeholder="🔍 Search products..."
               class="border rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-indigo-500 focus:outline-none text-sm">
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-100">
                <tr class="text-gray-600 text-sm uppercase tracking-wide border-b">
                    @foreach([['id','ID'],['name','Name'],['price','Price'],['created_at','Created']] as [$field,$label])
                        <th class="py-3 px-4 font-semibold">
                            <button wire:click="sortBy('{{ $field }}')" class="flex items-center space-x-1">
                                <span>{{ $label }}</span>
                                @if($sort===$field) 
                                    <span class="text-xs">{{ $dir==='asc'?'▲':'▼' }}</span> 
                                @endif
                            </button>
                        </th>
                    @endforeach
                    <th class="py-3 px-4 font-semibold">Category</th>
                    <th class="py-3 px-4 font-semibold">Image</th>
                    <th class="py-3 px-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 text-sm">
                @forelse($products as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">{{ $p->id }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900">{{ $p->name }}</td>
                        <td class="py-3 px-4 text-gray-700">Rs.{{ number_format($p->price, 2) }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $p->created_at->format('Y-m-d') }}</td>
                        <td class="py-3 px-4">
                            @if($p->category)
                                <span class="px-2 py-1 text-xs font-semibold bg-indigo-100 text-indigo-700 rounded-full">
                                    {{ $p->category->name }}
                                </span>
                            @else
                                <span class="text-gray-400 italic">Uncategorized</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            @if($p->image)
                                @php
                                    $imgPath = Str::startsWith($p->image, 'products/')
                                        ? asset('images/'.$p->image)   // old products in public/images
                                        : asset('storage/'.$p->image); // new uploads in storage
                                @endphp
                                <img src="{{ $imgPath }}" 
                                     alt="{{ $p->name }}"
                                     class="h-12 w-12 rounded-lg object-cover border">
                            @else
                                <span class="text-gray-400 italic">No Image</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right space-x-2">
                            <a href="{{ route('admin.products.edit',$p) }}" 
                               class="inline-flex items-center px-2 py-1 text-xs font-medium text-indigo-600 bg-indigo-50 rounded hover:text-indigo-800 hover:bg-indigo-100 transition">
                               ✏️ Edit
                            </a>
                            <form action="{{ route('admin.products.destroy',$p) }}" method="POST" class="inline"
                                  onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-600 bg-red-50 rounded hover:text-red-800 hover:bg-red-100 transition">
                                    🗑 Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-6 px-4 text-center text-gray-500">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t bg-gray-50">
        {{ $products->links() }}
    </div>
</div>
