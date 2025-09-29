<x-app-layout>
  <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-10 bg-[#f7f3ef] rounded-xl shadow-inner">

    {{-- Billing & Payment --}}
    <div class="lg:col-span-2 space-y-8 bg-[#fdfaf6] rounded-xl shadow-lg p-8 border border-[#d9c7b8]">
      <h2 class="text-2xl font-bold text-center text-[#5a4632] mb-6">Checkout</h2>

      @if(session('error'))
        <div class="mb-4 p-3 bg-red-100 border border-red-300 text-red-700 rounded">
          {{ session('error') }}
        </div>
      @endif

      <form method="POST" action="{{ route('checkout.place') }}" class="space-y-8" id="checkout-form">
        @csrf

        {{-- Name & Email --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-[#5a4632] mb-1">Full Name</label>
            <input type="text" name="name" required
                   class="border border-[#cbbba4] rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-[#a68a64] bg-[#fffdfa]">
          </div>
          <div>
            <label class="block text-sm font-semibold text-[#5a4632] mb-1">Email Address</label>
            <input type="email" name="email" required
                   class="border border-[#cbbba4] rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-[#a68a64] bg-[#fffdfa]">
          </div>
        </div>

        {{-- Address --}}
        <div>
          <label class="block text-sm font-semibold text-[#5a4632] mb-1">Address</label>
          <input type="text" name="address" required
                 class="border border-[#cbbba4] rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-[#a68a64] bg-[#fffdfa]">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label class="block text-sm font-semibold text-[#5a4632] mb-1">City</label>
            <input type="text" name="city" required
                   class="border border-[#cbbba4] rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-[#a68a64] bg-[#fffdfa]">
          </div>
          <div>
            <label class="block text-sm font-semibold text-[#5a4632] mb-1">ZIP Code</label>
            <input type="text" name="zip" required
                   class="border border-[#cbbba4] rounded-lg px-4 py-2 w-full focus:ring-2 focus:ring-[#a68a64] bg-[#fffdfa]">
          </div>
        </div>

        {{-- Payment Options --}}
        <div>
          <h3 class="text-lg font-semibold text-[#5a4632] mb-4 text-center">Payment Method</h3>
          <div class="space-y-4">

            {{-- Cash on Delivery --}}
            <label class="flex items-center justify-between border border-[#cbbba4] rounded-lg p-3 cursor-pointer bg-[#fffdfa] hover:bg-[#f7f3ef]">
              <div class="flex items-center space-x-2">
                <input type="radio" name="payment" value="cod" checked class="payment-radio">
                <span class="text-[#5a4632]">Cash on Delivery</span>
              </div>
              <span class="text-sm text-gray-500">Pay when item arrives</span>
            </label>

            {{-- Card --}}
            <label class="flex items-center justify-between border border-[#cbbba4] rounded-lg p-3 cursor-pointer bg-[#fffdfa] hover:bg-[#f7f3ef]">
              <div class="flex items-center space-x-2">
                <input type="radio" name="payment" value="card" class="payment-radio">
                <span class="text-[#5a4632]">Credit / Debit Card</span>
              </div>
              <div class="flex space-x-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg"
                     alt="Visa" class="h-6">
                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2a/Mastercard-logo.svg"
                     alt="Mastercard" class="h-6">
              </div>
            </label>
            <div id="card-fields" class="hidden ml-6 space-y-3">
              <input type="text" name="card_number" placeholder="Card Number"
                     class="border border-[#cbbba4] rounded-lg px-4 py-2 w-full bg-[#fffdfa] focus:ring-2 focus:ring-[#a68a64]">
              <div class="grid grid-cols-2 gap-4">
                <input type="text" name="expiry" placeholder="MM/YY"
                       class="border border-[#cbbba4] rounded-lg px-4 py-2 bg-[#fffdfa] focus:ring-2 focus:ring-[#a68a64]">
                <input type="text" name="cvv" placeholder="CVV"
                       class="border border-[#cbbba4] rounded-lg px-4 py-2 bg-[#fffdfa] focus:ring-2 focus:ring-[#a68a64]">
              </div>
            </div>

            {{-- PayPal --}}
            <label class="flex items-center justify-between border border-[#cbbba4] rounded-lg p-3 cursor-pointer bg-[#fffdfa] hover:bg-[#f7f3ef]">
              <div class="flex items-center space-x-2">
                <input type="radio" name="payment" value="paypal" class="payment-radio">
                <span class="text-[#5a4632]">PayPal</span>
              </div>
              <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg"
                   alt="PayPal" class="h-6">
            </label>
            <div id="paypal-fields" class="hidden ml-6 space-y-3">
              <input type="email" name="paypal_email" placeholder="PayPal Email"
                     class="border border-[#cbbba4] rounded-lg px-4 py-2 w-full bg-[#fffdfa] focus:ring-2 focus:ring-[#a68a64]">
            </div>
          </div>
        </div>

        {{-- Place Order Button --}}
        <button id="place-order-btn"
                class="w-full py-4 bg-[#6b4f33] text-white font-semibold rounded-lg hover:bg-[#5a4632] transition flex items-center justify-center">
          <span id="btn-text">Place Order</span>
          <svg id="btn-spinner" class="animate-spin h-5 w-5 ml-2 text-white hidden"
               xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8h4z"></path>
          </svg>
        </button>
      </form>
    </div>

    {{-- Order Summary --}}
    <div class="bg-[#fdfaf6] rounded-xl shadow-lg p-8 h-fit border border-[#d9c7b8]">
      <h2 class="text-xl font-bold mb-4 text-center text-[#5a4632]">Order Summary</h2>
      <ul class="divide-y divide-[#e0d6cc] mb-4">
        @foreach($cart as $row)
          <li class="flex items-center justify-between py-4">
            <div class="flex items-center space-x-4">
              <img src="{{ asset('images/'.$row['image']) }}"
                   class="h-14 w-14 rounded-lg object-cover border shadow-sm">
              <div>
                <p class="font-medium text-[#5a4632]">{{ $row['name'] }}</p>
                <p class="text-sm text-gray-500">Qty: {{ $row['qty'] }}</p>
              </div>
            </div>
            <span class="text-[#5a4632] font-medium">
              Rs. {{ number_format($row['price'] * $row['qty'],2) }}
            </span>
          </li>
        @endforeach
      </ul>
      <div class="flex justify-between font-bold text-lg border-t border-[#e0d6cc] pt-4 text-[#5a4632]">
        <span>Total</span>
        <span>Rs. {{ number_format($total,2) }}</span>
      </div>
    </div>
  </div>

  {{-- Script --}}
  <script>
    document.querySelectorAll('.payment-radio').forEach(radio => {
      radio.addEventListener('change', function() {
        document.getElementById('card-fields').classList.add('hidden');
        document.getElementById('paypal-fields').classList.add('hidden');
        if (this.value === 'card') {
          document.getElementById('card-fields').classList.remove('hidden');
        } else if (this.value === 'paypal') {
          document.getElementById('paypal-fields').classList.remove('hidden');
        }
      });
    });

    const checkoutForm = document.getElementById('checkout-form');
    const placeOrderBtn = document.getElementById('place-order-btn');
    const btnText = document.getElementById('btn-text');
    const btnSpinner = document.getElementById('btn-spinner');

    checkoutForm.addEventListener('submit', () => {
      placeOrderBtn.disabled = true;
      btnText.textContent = 'Processing...';
      btnSpinner.classList.remove('hidden'); 
    });
  </script>
</x-app-layout>
