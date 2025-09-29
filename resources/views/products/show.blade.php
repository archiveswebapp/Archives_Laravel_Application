<x-app-layout>
  <div class="min-h-screen bg-gradient-to-b from-[#beaa8d] to-[#ead7bd]">
    <div class="max-w-6xl mx-auto px-4 py-10">

      {{-- Product Card --}}
      <div class="rounded-2xl border border-stone-300/60 bg-white/95 shadow-sm">
        <div class="grid md:grid-cols-2">

          {{-- Image --}}
          <div class="p-5 md:p-7">
            <div class="overflow-hidden rounded-xl bg-stone-100 border border-stone-200/70">
              @if($product->image)
                <img src="{{ asset('images/'.$product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-full h-auto object-cover"
                     onerror="this.onerror=null;this.src='{{ asset('images/backgrounds/product.jpg') }}';">
              @else
                <div class="aspect-[4/3] w-full flex items-center justify-center text-stone-400">
                  No image available
                </div>
              @endif
            </div>
          </div>

          {{-- Details --}}
          <div class="p-6 md:p-8 md:border-s md:border-stone-200/70">
            @if($product->category)
              <a href="{{ route('categories.show', $product->category) }}"
                 class="inline-flex items-center gap-2 rounded-full border border-stone-300 bg-amber-50/80 px-3 py-1 text-xs font-semibold text-stone-900 hover:bg-amber-100 transition">
                {{ $product->category->name }}
              </a>
            @endif

            <h1 class="mt-3 font-serif text-3xl md:text-4xl font-bold bg-gradient-to-r from-amber-900 to-stone-700 bg-clip-text text-transparent leading-tight">
              {{ $product->name }}
            </h1>

            <div class="mt-3">
              <span class="text-[12px] uppercase tracking-widest text-stone-500">Price</span>
              <p class="mt-1 text-[28px] font-semibold text-stone-900">
                Rs. {{ number_format((float)$product->price, 2) }}
              </p>
            </div>

            <div class="my-5 h-px w-full bg-gradient-to-r from-transparent via-stone-300 to-transparent"></div>

            <p class="text-stone-700 leading-relaxed">
              {{ $product->description ?: 'A carefully curated piece from our Archives collection.' }}
            </p>

            <div class="mt-6">
              <livewire:add-to-cart :product="$product" />
              <p class="mt-2 text-xs text-stone-500">Hand-packed with care • Secure checkout</p>
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-4 text-sm">
              <a href="{{ url()->previous() }}" class="text-stone-700 hover:text-stone-900 underline">Back</a>
              <a href="{{ route('cart') }}" class="text-indigo-700 hover:text-indigo-900 underline">Go to Cart</a>
            </div>
          </div>
        </div>
      </div>

      {{-- Feedback Form --}}
      <div class="mt-10 rounded-xl border border-stone-300 bg-white/95 shadow-sm p-6">
        <h3 class="text-lg font-bold mb-4">Leave a Review</h3>

        @if(session('success'))
          <div class="p-3 bg-green-100 text-green-800 rounded mb-4">
            {{ session('success') }}
          </div>
        @endif

        @auth
          <form action="{{ route('feedback.store', $product->id) }}" method="POST" class="space-y-3">
            @csrf
            <label class="block text-sm font-medium">Rating</label>
            <select name="rating" required class="border rounded w-full px-3 py-2">
              <option value="">-- Select --</option>
              @for($i = 1; $i <= 5; $i++)
                <option value="{{ $i }}">{{ $i }} ⭐</option>
              @endfor
            </select>

            <label class="block text-sm font-medium">Comment</label>
            <textarea name="comment" rows="3" class="border rounded w-full px-3 py-2"></textarea>

            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Submit</button>
          </form>
        @else
          <p class="text-sm text-stone-600">
            Please <a href="{{ route('login') }}" class="underline">log in</a> to leave a review.
          </p>
        @endauth
      </div>

      {{-- Reviews --}}
      <div class="mt-8 rounded-xl border border-stone-300 bg-white/95 shadow-sm p-6">
        <h3 class="text-lg font-bold mb-4">Customer Reviews</h3>

        @forelse($reviews as $review)
          <div class="p-3 border rounded mb-3">
            {{-- Stars --}}
            <div class="flex items-center gap-1">
              @for($i = 1; $i <= 5; $i++)
                @if($i <= $review->rating)
                  <span class="text-yellow-500">★</span>
                @else
                  <span class="text-gray-300">☆</span>
                @endif
              @endfor
            </div>

            {{-- Comment --}}
            <p class="mt-1 text-stone-700">{{ $review->comment ?? 'No comment' }}</p>

            {{-- User + Date --}}
            <div class="text-xs text-gray-500 mt-1">
              {{ $review->user->name ?? 'Anonymous' }} •
              {{ \Carbon\Carbon::parse($review->created_at)->format('Y-m-d H:i') }}
            </div>
          </div>
        @empty
          <p class="text-gray-500">No reviews yet.</p>
        @endforelse
      </div>

      <div class="mt-10 text-center text-[11px] tracking-widest text-stone-500 uppercase">
        Archives • Provenance &amp; Preservation
      </div>
    </div>
  </div>
</x-app-layout>
