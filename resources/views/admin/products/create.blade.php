@extends('admin.layout')

@section('title','Add Product')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Add Product</h1>
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow max-w-2xl">
        @csrf
        @include('admin.products.partials.form', ['product'=>$product, 'categories'=>$categories, 'button'=>'Create'])
    </form>
@endsection
