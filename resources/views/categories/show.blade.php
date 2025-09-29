<x-app-layout>
  {{-- Vintage parchment background --}}
  <div class="relative min-h-screen bg-no-repeat bg-cover bg-center"
       style="background-image:url('{{ asset('images/backgrounds/homeBG.jpg') }}');">

    {{-- Soft texture overlay to avoid banding --}}
    <div class="absolute inset-0 opacity-35 mix-blend-multiply bg-no-repeat bg-cover bg-center"
         style="background-image:url('{{ asset('images/backgrounds/product.jpg') }}');">
    </div>

    {{-- Page content above overlays --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 py-10">

      {{-- Header / Hero --}}
      <section class="mb-8">
        <div class="overflow-hidden rounded-2xl border border-stone-300/70 bg-white/90 backdrop-blur-sm shadow-sm">
          <div class="px-6 sm:px-10 py-8 text-center">
            <p class="tracking-widest text-[11px] text-stone-500 uppercase">Category</p>
            <h1 class="mt-1 text-3xl sm:text-4xl font-serif font-bold text-stone-900">
              {{ $category->name }}
            </h1>

            {{-- optional subtitle/description if you have one --}}
            @if(!empty($category->description))
              <p class="mt-3 text-stone-700 max-w-2xl mx-auto leading-relaxed">
                {{ $category->description }}
              </p>
            @endif

            {{-- breadcrumb-ish helper --}}
            <div class="mt-5 text-sm text-stone-600">
              <a href="{{ route('home') }}" class="underline hover:text-stone-900">Home</a>
              <span class="mx-2">/</span>
              <a href="{{ route('categories.index') }}" class="underline hover:text-stone-900">Categories</a>
              <span class="mx-2">/</span>
              <span class="text-stone-800">{{ $category->name }}</span>
            </div>
          </div>
        </div>
      </section>

      {{-- Product Grid --}}
      <section>
        @if ($products->count())
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
              <a href="{{ route('products.show', $product) }}"
                 class="group flex flex-col overflow-hidden rounded-xl border border-stone-300/70 bg-white/90 backdrop-blur-sm shadow-sm hover:shadow-md transition">

                {{-- equal-height image window --}}
                <div class="relative h-56 w-full overflow-hidden">
                  @if ($product->image)
                    <img
                      src="{{ asset('images/'.$product->image) }}"
                      alt="{{ $product->name }}"
                      class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03] group-hover:brightness-95"
                      onerror="this.onerror=null;this.src='{{ asset('images/placeholders/product.jpg') }}';"
                    >
                  @else
                    <img
                      src="{{ asset('images/placeholders/product.png') }}"
                      alt="No image"
                      class="h-full w-full object-cover"
                    >
                  @endif

                  {{-- subtle bottom gradient --}}
                  <div class="pointer-events-none absolute inset-x-0 bottom-0 h-12 bg-gradient-to-t from-stone-900/30 to-transparent"></div>

                  {{-- category badge (redundant here but looks nice) --}}
                  <span class="absolute top-3 left-3 rounded bg-amber-50/95 px-2.5 py-1 text-[11px] font-semibold text-stone-900 shadow">
                    {{ $category->name }}
                  </span>
                </div>

                {{-- text area --}}
                <div class="p-4 flex flex-col gap-1">
                  <h3 class="font-serif text-lg font-semibold text-stone-900 leading-snug line-clamp-2">
                    {{ $product->name }}
                  </h3>
                  <p class="text-stone-700">Rs. {{ number_format((float)$product->price, 2) }}</p>
                </div>
              </a>
            @endforeach
          </div>

          {{-- Pagination --}}
          <div class="mt-8">
            {{ $products->links() }}
          </div>
        @else
          <div class="mt-10 text-center text-stone-700">
            No products found in this category.
          </div>
        @endif
      </section>

    </div>
  </div>
</x-app-layout>
