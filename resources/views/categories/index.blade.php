<x-app-layout>
  {{-- Vintage parchment background (soft, same vibe as home) --}}
  <div class="relative min-h-screen bg-no-repeat bg-cover bg-center"
       style="background-image:url('{{ asset('images/backgrounds/homeBG.jpg') }}');">
    <div class="absolute inset-0 opacity-35 mix-blend-multiply bg-no-repeat bg-cover bg-center"
         style="background-image:url('{{ asset('images/backgrounds/product.jpg') }}');"></div>

    {{-- Page content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 py-10">

      {{-- Softer aesthetic header --}}
      <div class="bg-white/90 backdrop-blur rounded-2xl p-10 text-center shadow-md mb-10">
        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">Browse</p>
        <h1 class="mt-1 text-4xl font-serif font-bold text-stone-900">All Categories</h1>
        <p class="mt-3 text-stone-700 max-w-3xl mx-auto">
          Explore curated collections of oil paintings, monochrome art, and timeless vintage pieces.
        </p>
      </div>

      {{-- Category grid --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($categories as $category)
          <a href="{{ route('categories.show', $category) }}"
             class="group overflow-hidden rounded-xl border border-stone-300/70 bg-white/90 backdrop-blur shadow-sm hover:shadow-md transition">
            {{-- Image window (equal height) --}}
            <div class="h-44 w-full overflow-hidden">
              @if($category->image)
                <img
                  src="{{ asset('images/'.$category->image) }}"
                  alt="{{ $category->name }}"
                  class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03] group-hover:brightness-95"
                  onerror="this.onerror=null;this.src='{{ asset('images/placeholders/category.png') }}';"
                >
              @else
                <img src="{{ asset('images/placeholders/category.png') }}"
                     alt="No image"
                     class="h-full w-full object-cover">
              @endif
            </div>

            {{-- Label --}}
            <div class="p-4 text-center">
              <span class="inline-block rounded bg-[#c59f70] px-3 py-1 text-sm font-medium text-stone-900">
                {{ $category->name }}
              </span>
            </div>
          </a>
        @endforeach
      </div>

      {{-- (Optional) Pagination if you paginate categories --}}
      {{-- <div class="mt-8">{{ $categories->links() }}</div> --}}
    </div>
  </div>
</x-app-layout>
