@extends('admin.layout')

@section('title','Orders')

@section('content')
<div class="bg-white rounded-xl shadow-lg overflow-hidden">
    <!-- Header -->
    <div class="p-6 flex items-center justify-between border-b">
        <h1 class="text-2xl font-semibold text-gray-700">Manage Orders</h1>
        <form method="GET" class="flex items-center gap-2">
            <select name="status" class="border rounded px-3 py-2 text-sm">
                <option value="">All statuses</option>
                @foreach(['pending','placed','processing','shipped','delivered','cancelled'] as $s)
                    <option value="{{ $s }}" @selected($status===$s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
            <button class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm rounded">
                Filter
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-4 text-gray-600 font-medium">ID</th>
                    <th class="py-3 px-4 text-gray-600 font-medium">Customer</th>
                    <th class="py-3 px-4 text-gray-600 font-medium">Status</th>
                    <th class="py-3 px-4 text-gray-600 font-medium">Total</th>
                    <th class="py-3 px-4 text-gray-600 font-medium">Created</th>
                    <th class="py-3 px-4 text-gray-600 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $o)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">#{{ $o->id }}</td>
                        <td class="py-3 px-4">{{ optional($o->user)->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'placed' => 'bg-blue-100 text-blue-700',
                                    'processing' => 'bg-indigo-100 text-indigo-700',
                                    'shipped' => 'bg-purple-100 text-purple-700',
                                    'delivered' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$o->status] ?? 'bg-gray-100 text-gray-700' }}">
                                {{ ucfirst($o->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">Rs.{{ number_format($o->total_price,2) }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $o->created_at->format('Y-m-d') }}</td>
                        <td class="py-3 px-4 text-right">
                            <a href="{{ route('admin.orders.show',$o) }}" 
                               class="text-indigo-600 hover:underline">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">No orders found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="p-4 border-t">
        {{ $orders->links() }}
    </div>
</div>
@endsection
