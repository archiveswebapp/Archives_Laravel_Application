@extends('admin.layout')

@section('title','Products')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800">📦 Manage Products</h1>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg shadow hover:bg-indigo-700 transition">
            + Add Product
        </a>
    </div>

    {{-- Flash success message --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Livewire table --}}
    <div class="overflow-hidden border border-gray-200 rounded-lg">
        @livewire('products-table')
    </div>
</div>
@endsection
