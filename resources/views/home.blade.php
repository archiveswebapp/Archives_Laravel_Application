<x-app-layout>
  {{-- Vintage parchment background (no banding) --}}
  <div class="relative min-h-screen bg-no-repeat bg-cover bg-center"
       style="background-image:url('{{ asset('images/backgrounds/homeBG.jpg') }}');">

    {{-- Soft texture overlay that follows page height --}}
    <div class="absolute inset-0 opacity-35 mix-blend-multiply
                bg-no-repeat bg-cover bg-center"
         style="background-image:url('{{ asset('images/backgrounds/product.jpg') }}');">
    </div>

    {{-- Page content sits above overlays --}}
    <div class="relative z-10 max-w-6xl mx-auto px-4 py-10">

      {{-- HERO / INTRO --}}
      <section class="mb-10">
        <div class="overflow-hidden rounded-2xl border border-stone-300/80 bg-black/90 backdrop-blur-sm shadow-sm">
          <div class="grid md:grid-cols-3">
            <div class="md:col-span-2 p-8 md:p-12">
              <p class="tracking-widest text-xs text-stone-500 uppercase">Curated Collection</p>
              <h1 class="mt-1 text-4xl md:text-5xl font-serif font-bold bg-gradient-to-r from-amber-900 to-white bg-clip-text text-transparent leading-tight">
                Archives • Vintage Art & Collectibles
              </h1>
              <p class="mt-4 text-stone-200 leading-relaxed">
                Discover oil paintings, monochrome art, and timeless artifacts — curated to bring vintage elegance into your collection.
              </p>
              <div class="mt-7">
                <a href="{{ route('categories.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-stone-400/80 bg-amber-50 text-stone-900 hover:bg-amber-100 transition">
                  Browse Categories
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.293 15.707a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414L12 12.586V4a1 1 0 10-2 0v8.586L5.707 9.293A1 1 0 104.293 10.707l5 5z"/>
                  </svg>
                </a>
              </div>
            </div>
           <div class="hidden md:block">
           <div class="h-full w-full bg-no-repeat bg-cover bg-center"style="background-image: url('{{ asset('images/Logo_website.png') }}');">
    </div>
</div>

          </div>
        </div>
      </section>

      {{-- CATEGORIES --}}
      <section class="mb-12">
        <div class="text-center mb-6">
          <h2 class="text-2xl font-serif font-bold text-stone-900">Shop by Category</h2>
          <a href="{{ route('categories.index') }}" class="text-sm text-stone-700 hover:text-stone-900 underline">View all</a>
        </div>

        {{-- Center the cards when you have only 3 categories --}}
        <div class="flex justify-center">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @forelse($categories as $category)
              <a href="{{ route('categories.show', $category) }}"
                 class="group flex flex-col overflow-hidden rounded-xl border border-stone-300/80 bg-white/90 backdrop-blur-sm shadow-sm hover:shadow-md transition">
                <div class="relative h-40 w-full overflow-hidden">
                  @if($category->image)
                    <img
                      src="{{ asset('images/'.$category->image) }}"
                      alt="{{ $category->name }}"
                      class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03] group-hover:brightness-95"
                      onerror="this.onerror=null;this.src='{{ asset('images/placeholders/category.png') }}';"
                    >
                  @else
                    <img src="{{ asset('images/placeholders/category.png') }}" alt="No image" class="h-full w-full object-cover">
                  @endif
                  <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-stone-900/40 to-transparent h-10"></div>
                </div>
                <div class="p-4 text-center">
                  <span class="inline-block rounded bg-[#c59f70] px-3 py-1 text-sm font-medium text-stone-900">
                    {{ $category->name }}
                  </span>
                </div>
              </a>
            @empty
              <p class="text-stone-700">No categories yet.</p>
            @endforelse
          </div>
        </div>
      </section>

      {{-- LATEST PRODUCTS --}}
      <section>
        <div class="text-center mb-6">
          <h2 class="text-2xl font-serif font-bold text-stone-900">Latest Arrivals</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          @forelse($products as $product)
            <a href="{{ route('products.show', $product) }}"
               class="group flex flex-col overflow-hidden rounded-xl border border-stone-300/80 bg-white/90 backdrop-blur-sm shadow-sm hover:shadow-md transition">
              <div class="relative h-60 w-full overflow-hidden">
                @if($product->image)
                  <img
                    src="{{ asset('images/'.$product->image) }}"
                    alt="{{ $product->name }}"
                    class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03] group-hover:brightness-95"
                    onerror="this.onerror=null;this.src='{{ asset('images/backgrounds/product.jpg') }}';"
                  >
                @else
                  <img src="{{ asset('images/backgrounds/product.jpg') }}" alt="No image" class="h-full w-full object-cover">
                @endif
                @if($product->category)
                  <span class="absolute top-3 left-3 rounded bg-amber-50/90 px-2.5 py-1 text-[11px] font-semibold text-stone-900 shadow">
                    {{ $product->category->name }}
                  </span>
                @endif
              </div>
              <div class="p-4 flex flex-col justify-between text-center">
                <h3 class="font-serif text-lg font-semibold text-stone-900 leading-snug truncate" title="{{ $product->name }}">
                  {{ $product->name }}
                </h3>
                <p class="mt-1 text-stone-700">Rs. {{ number_format((float)$product->price, 2) }}</p>
              </div>
            </a>
          @empty
            <p class="text-stone-700">No products yet.</p>
          @endforelse
        </div>
      </section>

      <footer class="mt-16 text-center text-white text-xs tracking-widest uppercase">
        © {{ date('Y') }} Archives — Provenance & Preservation
      </footer>
    </div>
  </div>
</x-app-layout>
