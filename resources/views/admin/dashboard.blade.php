@extends('admin.layout')

@section('title','Dashboard')

@section('content')
<div class="space-y-8">

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white border-l-4 border-indigo-500 p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="text-sm font-medium text-gray-500">Total Users</div>
            <div class="text-4xl font-bold text-gray-800 mt-2">{{ $usersCount }}</div>
            <p class="text-sm text-gray-400 mt-1">Registered in the system</p>
        </div>

        <div class="bg-white border-l-4 border-green-500 p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="text-sm font-medium text-gray-500">Total Products</div>
            <div class="text-4xl font-bold text-gray-800 mt-2">{{ $productsCount }}</div>
            <p class="text-sm text-gray-400 mt-1">Currently in catalog</p>
        </div>

        <div class="bg-white border-l-4 border-rose-500 p-6 rounded-xl shadow hover:shadow-lg transition">
            <div class="text-sm font-medium text-gray-500">Total Orders</div>
            <div class="text-4xl font-bold text-gray-800 mt-2">{{ $ordersCount }}</div>
            <p class="text-sm text-gray-400 mt-1">Placed by customers</p>
        </div>
    </div>

    {{-- Quick Manage Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.products.index') }}" 
           class="p-6 rounded-xl shadow-lg hover:shadow-xl transition bg-gradient-to-r from-blue-100 to-blue-200 flex flex-col items-center text-center">
            <div class="text-5xl mb-3">📦</div>
            <h3 class="text-lg font-bold text-gray-800">Manage Products</h3>
            <p class="text-sm text-gray-600 mt-1">Add, edit, and remove products</p>
        </a>

        <a href="{{ route('admin.users.index') }}" 
           class="p-6 rounded-xl shadow-lg hover:shadow-xl transition bg-gradient-to-r from-green-100 to-green-200 flex flex-col items-center text-center">
            <div class="text-5xl mb-3">👤</div>
            <h3 class="text-lg font-bold text-gray-800">Manage Users</h3>
            <p class="text-sm text-gray-600 mt-1">View and update user roles</p>
        </a>

        <a href="{{ route('admin.orders.index') }}" 
           class="p-6 rounded-xl shadow-lg hover:shadow-xl transition bg-gradient-to-r from-red-100 to-red-200 flex flex-col items-center text-center">
            <div class="text-5xl mb-3">🛒</div>
            <h3 class="text-lg font-bold text-gray-800">Manage Orders</h3>
            <p class="text-sm text-gray-600 mt-1">Track and update order statuses</p>
        </a>
    </div>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        {{-- Recent Products --}}
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Recent Products</h2>
            <ul class="divide-y divide-gray-200">
                @forelse(\App\Models\Product::latest()->take(5)->get() as $p)
                    <li class="py-3 flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            @if($p->image)
                                @php
                                    $imgPath = Str::startsWith($p->image, 'products/')
                                        ? asset('images/'.$p->image)   // old products
                                        : asset('storage/'.$p->image); // new uploads
                                @endphp
                                <img src="{{ $imgPath }}"
                                     alt="{{ $p->name }}"
                                     class="h-10 w-10 rounded object-cover border shadow-sm">
                            @else
                                <span class="h-10 w-10 flex items-center justify-center bg-gray-100 rounded text-gray-400">📦</span>
                            @endif
                            <div>
                                <div class="font-medium text-gray-800">{{ $p->name }}</div>
                                <div class="text-sm text-gray-500">{{ $p->category->name ?? '-' }}</div>
                            </div>
                        </div>
                        <div class="text-gray-600">Rs. {{ number_format($p->price,2) }}</div>
                    </li>
                @empty
                    <li class="py-3 text-gray-500 text-center">No products yet</li>
                @endforelse
            </ul>
        </div>

        {{-- New Users --}}
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">New Users</h2>
            <ul class="divide-y divide-gray-200">
                @forelse(\App\Models\User::latest()->take(5)->get() as $u)
                    <li class="py-3 flex items-center justify-between">
                        <div>
                            <div class="font-medium text-gray-800">{{ $u->name }}</div>
                            <div class="text-sm text-gray-500">{{ $u->email }}</div>
                        </div>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $u->role === 'admin' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($u->role) }}
                        </span>
                    </li>
                @empty
                    <li class="py-3 text-gray-500 text-center">No users yet</li>
                @endforelse
            </ul>
        </div>
    </div>

</div>
@endsection
