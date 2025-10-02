{{-- resources/views/livewire/cart.blade.php --}}
<div class="relative min-h-screen">

    {{-- 🔒 Background image as a real element (hard to “miss”) --}}
    <img
        src="{{ asset('images/backgrounds/homeBG.jpg') }}"
        alt=""
        class="fixed inset-0 -z-10 h-full w-full object-cover"
    />

    
    {{--
    <img
        src="{{ asset('images/backgrounds/product.jpg') }}"
        alt=""
        class="fixed inset-0 -z-10 h-full w-full object-cover opacity-25 mix-blend-multiply"
    />
    --}}

    {{-- Soft veil for readability (light, so background shows through) --}}
    <div class="min-h-screen bg-white/40 backdrop-blur-[2px]">

        <div class="max-w-6xl mx-auto px-4 py-10">
            {{-- Header --}}
            <div class="mb-8 text-center">
                <p class="text-xs uppercase tracking-[0.18em] text-stone-700">Your Basket</p>
                <h1 class="mt-1 text-3xl md:text-4xl font-serif font-bold text-stone-900">Your Cart</h1>
                <p class="mt-2 text-stone-800">
                    Review your selections before checkout. Quantities and items can be adjusted below.
                </p>
            </div>

            @if(empty($items))
                {{-- Empty state --}}
                <div class="rounded-2xl border border-stone-300/70 bg-white/85 backdrop-blur p-10 text-center shadow-sm">
                    <div class="mx-auto h-24 w-24 rounded-full bg-[#c59f70]/20 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-[#c59f70]" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 7h14l-2-7M10 21a1 1 0 11-2 0 1 1 0 012 0zm8 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                        </svg>
                    </div>
                    <h2 class="mt-4 text-xl font-serif font-semibold text-stone-900">Your cart is empty</h2>
                    <p class="mt-1 text-stone-700">Start exploring our collections to add something beautiful.</p>
                    <a href="{{ route('home') }}"
                       class="mt-6 inline-flex items-center gap-2 rounded-full border border-stone-400/70 bg-amber-50 px-5 py-2.5 text-stone-900 hover:bg-amber-100 transition">
                        Browse Collections
                    </a>
                </div>
            @else
                {{-- 2-column layout: items + summary --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    {{-- Cart items --}}
                    <div class="lg:col-span-2 space-y-5">
                        @foreach($items as $id => $row)
                            <div class="group flex items-center justify-between gap-4 rounded-xl border border-stone-300/70 bg-white/85 backdrop-blur p-4 shadow-sm hover:shadow-md transition">

                                {{-- Left: image + name/price --}}
                                <div class="flex items-center gap-4">
                                    <div class="h-20 w-24 overflow-hidden rounded-md border border-stone-200">
                                        <img
                                            src="{{ asset('images/'.$row['image']) }}"
                                            alt="{{ $row['name'] }}"
                                            class="h-full w-full object-cover"
                                            onerror="this.onerror=null;this.src='{{ asset('images/placeholders/product.png') }}';"
                                        >
                                    </div>
                                    <div>
                                        <div class="font-serif text-lg font-semibold text-stone-900">
                                            {{ $row['name'] }}
                                        </div>
                                        <div class="text-stone-700 text-sm">
                                            Rs. {{ number_format($row['price'], 2) }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Middle: qty controls --}}
                                <div class="flex items-center gap-3">
                                    <button
                                        wire:click="decrement({{ $id }})"
                                        wire:loading.attr="disabled"
                                        class="h-9 w-9 rounded border border-stone-300 text-stone-700 hover:bg-stone-100 transition"
                                        aria-label="Decrease quantity">−</button>
                                    <span class="min-w-[1.5rem] text-center">{{ $row['qty'] }}</span>
                                    <button
                                        wire:click="increment({{ $id }})"
                                        wire:loading.attr="disabled"
                                        class="h-9 w-9 rounded border border-stone-300 text-stone-700 hover:bg-stone-100 transition"
                                        aria-label="Increase quantity">+</button>
                                </div>

                                {{-- Right: line total + remove --}}
                                <div class="flex items-center gap-6">
                                    <div class="w-28 text-right font-semibold text-stone-900">
                                        Rs. {{ number_format($row['price'] * $row['qty'], 2) }}
                                    </div>
                                    <button
                                        wire:click="remove({{ $id }})"
                                        wire:loading.attr="disabled"
                                        class="text-sm text-red-600 hover:text-red-700 underline">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        <div class="flex items-center justify-between">
                            <button
                                wire:click="clear"
                                wire:loading.attr="disabled"
                                class="text-stone-700 hover:text-stone-900 underline">
                                Clear cart
                            </button>
                            <a href="{{ route('categories.index') }}"
                               class="text-stone-800 hover:text-stone-900 underline">
                                Continue shopping
                            </a>
                        </div>
                    </div>

                    {{-- Summary panel --}}
                    <aside class="lg:sticky lg:top-24 h-max">
                        <div class="rounded-2xl border border-stone-300/70 bg-white/90 backdrop-blur p-6 shadow-sm">
                            <h3 class="text-xl font-serif font-semibold text-stone-900">Order Summary</h3>

                            {{-- Line items list (name • qty • price) --}}
                            <ul class="mt-4 max-h-64 overflow-auto divide-y divide-stone-200">
                                @foreach($items as $row)
                                    <li class="py-3 flex items-center gap-3">
                                        <div class="h-12 w-12 flex-shrink-0 overflow-hidden rounded border border-stone-200">
                                            <img
                                                src="{{ asset('images/'.$row['image']) }}"
                                                alt="{{ $row['name'] }}"
                                                class="h-full w-full object-cover"
                                                onerror="this.onerror=null;this.src='{{ asset('images/placeholders/product.png') }}';"
                                            >
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate font-medium text-stone-900">{{ $row['name'] }}</p>
                                            <p class="text-sm text-stone-700">
                                                Rs. {{ number_format($row['price'], 2) }} × {{ $row['qty'] }}
                                            </p>
                                        </div>
                                        <div class="text-right font-semibold text-stone-900">
                                            Rs. {{ number_format($row['price'] * $row['qty'], 2) }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="mt-4 space-y-3 text-sm">
                                <div class="flex justify-between text-stone-800">
                                    <span>Subtotal</span>
                                    <span>Rs. {{ number_format($total, 2) }}</span>
                                </div>
                                <div class="border-t border-stone-200 pt-3 flex justify-between text-base font-semibold text-stone-900">
                                    <span>Total</span>
                                    <span>Rs. {{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <a href="{{ route('checkout.show') }}"
                               class="mt-6 inline-flex w-full items-center justify-center gap-2 rounded-lg bg-emerald-600 px-5 py-3 font-medium text-white hover:bg-emerald-700 transition">
                                Proceed to Checkout
                            </a>

                            <p class="mt-3 text-xs text-stone-600 text-center">
                                Secure checkout • Your information is protected
                            </p>
                        </div>
                    </aside>
                </div>
            @endif
        </div>
    </div>
</div>
