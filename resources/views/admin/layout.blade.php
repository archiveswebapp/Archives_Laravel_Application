<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gradient-to-b from-gray-900 to-gray-800 text-white shadow-lg">
        {{-- Archives Logo (centered + rounded) --}}
        <div class="flex items-center justify-center h-24 border-b border-gray-700">
            <img src="{{ asset('images/favicon.png') }}" 
                 alt="Archives Logo" 
                 class="h-16 w-16 rounded-full object-cover shadow-lg">
        </div>

        {{-- Navigation --}}
        <nav class="mt-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-2 rounded transition 
                      {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-600 to-indigo-500' : 'hover:bg-gradient-to-r hover:from-gray-700 hover:to-gray-600' }}">
               🏠 <span class="ml-2">Dashboard</span>
            </a>
            <a href="{{ route('admin.products.index') }}" 
               class="flex items-center px-4 py-2 rounded transition 
                      {{ request()->routeIs('admin.products.*') ? 'bg-gradient-to-r from-green-600 to-green-500' : 'hover:bg-gradient-to-r hover:from-gray-700 hover:to-gray-600' }}">
               📦 <span class="ml-2">Products</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" 
               class="flex items-center px-4 py-2 rounded transition 
                      {{ request()->routeIs('admin.orders.*') ? 'bg-gradient-to-r from-red-600 to-red-500' : 'hover:bg-gradient-to-r hover:from-gray-700 hover:to-gray-600' }}">
               🛒 <span class="ml-2">Orders</span>
            </a>
            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center px-4 py-2 rounded transition 
                      {{ request()->routeIs('admin.users.*') ? 'bg-gradient-to-r from-purple-600 to-purple-500' : 'hover:bg-gradient-to-r hover:from-gray-700 hover:to-gray-600' }}">
               👤 <span class="ml-2">Users</span>
            </a>
        </nav>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col">

        {{-- Top Bar --}}
        <header class="bg-white shadow px-6 py-3 flex items-center justify-between sticky top-0 z-10">
            <h1 class="text-xl font-bold text-gray-800">Admin Dashboard</h1>
            
            <div class="flex items-center space-x-6">
                {{-- User info --}}
                <div class="flex items-center space-x-2">
                    <div class="h-9 w-9 rounded-full bg-gray-300 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" class="h-6 w-6 text-gray-700">
                            <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
                        </svg>
                    </div>
                    <span class="text-gray-700 font-medium">
                        {{ Auth::user()->name ?? 'Admin' }}
                    </span>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded shadow">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6">
            {{-- Removed global flash success & error messages --}}
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
