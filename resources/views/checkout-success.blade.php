<x-app-layout>
  <div class="max-w-3xl mx-auto px-6 py-16">
    <div class="bg-gradient-to-br from-yellow-50 via-white to-yellow-100 border border-yellow-200 rounded-2xl shadow-xl p-10 text-center">
      
      {{-- Icon --}}
      <div class="flex justify-center mb-6">
        <div class="h-20 w-20 flex items-center justify-center rounded-full bg-green-100 border border-green-300 shadow">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
      </div>

      {{-- Heading --}}
      <h1 class="text-3xl font-extrabold text-gray-800 mb-4 tracking-wide">
        Order Placed Successfully!
      </h1>

      {{-- Message --}}
      <p class="text-lg text-gray-600 mb-8 leading-relaxed">
        Thank you for shopping with <span class="font-semibold text-indigo-700">Archives</span>.  
        Your order has been received and is now being processed.  
        You’ll receive an update soon.
      </p>

      {{-- Button --}}
      <a href="{{ route('home') }}" 
         class="inline-block px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition transform hover:scale-105">
        Continue Shopping
      </a>
    </div>
  </div>
</x-app-layout>
