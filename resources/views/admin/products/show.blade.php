<h3 class="text-lg font-bold mt-6">Leave a Review</h3>

@if(session('success'))
    <div class="p-3 bg-green-100 text-green-800 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('feedback.store', $product->id) }}" method="POST" class="space-y-3">
    @csrf
    <label class="block">Rating</label>
    <select name="rating" required class="border rounded w-full px-3 py-2">
        <option value="">-- Select --</option>
        @for($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}">{{ $i }} ⭐</option>
        @endfor
    </select>

    <label class="block">Comment</label>
    <textarea name="comment" rows="3" class="border rounded w-full px-3 py-2"></textarea>

    <button class="px-4 py-2 bg-indigo-600 text-white rounded">Submit</button>
</form>



<h3 class="text-lg font-bold mt-6">Customer Reviews</h3>

@forelse($reviews as $review)
    <div class="p-3 border rounded mb-2">
        <div class="font-semibold">{{ $review['rating'] }} ⭐</div>
        <p>{{ $review['comment'] ?? 'No comment' }}</p>
        <div class="text-xs text-gray-500">
            {{ $review['created_at']->toDateTime()->format('Y-m-d H:i') }}
        </div>
    </div>
@empty
    <p class="text-gray-500">No reviews yet.</p>
@endforelse
