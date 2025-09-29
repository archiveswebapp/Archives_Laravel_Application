@extends('admin.layout')

@section('title','Order #'.$order->id)

@section('content')
<div class="bg-white rounded-xl shadow-lg p-6">
    <!-- Header -->
    <div class="flex items-center justify-between border-b pb-4 mb-4">
        <div>
            <h1 class="text-2xl font-semibold">Order #{{ $order->id }}</h1>
            <p class="text-gray-500">
                Customer: {{ optional($order->user)->name ?? 'N/A' }} (ID: {{ $order->user_id }})
            </p>
        </div>
        <form action="{{ route('admin.orders.update',$order) }}" method="POST" class="flex items-center gap-2">
            @csrf @method('PUT')
            <select name="status" class="border rounded px-3 py-2 text-sm">
                @foreach(['pending','placed','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" @selected($order->status===$s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded">
                Update
            </button>
        </form>
    </div>

    <!-- Items Table -->
    <div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-4 text-gray-600 font-medium">Item</th>
                    <th class="py-3 px-4 text-gray-600 font-medium">Qty</th>
                    <th class="py-3 px-4 text-gray-600 font-medium">Price</th>
                    <th class="py-3 px-4 text-gray-600 font-medium">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $it)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ optional($it->product)->name ?? ('#'.$it->product_id) }}</td>
                        <td class="py-3 px-4">{{ $it->quantity }}</td>
                        <td class="py-3 px-4">Rs.{{ number_format($it->price,2) }}</td>
                        <td class="py-3 px-4">Rs.{{ number_format($it->total,2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-right mt-4 font-semibold text-lg">
            Grand Total: Rs.{{ number_format($order->total_price,2) }}
        </div>
    </div>
</div>
@endsection
