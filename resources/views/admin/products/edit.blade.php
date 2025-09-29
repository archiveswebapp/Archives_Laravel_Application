@extends('admin.layout')

@section('title','Edit Product')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">Edit Product</h1>
    <form action="{{ route('admin.products.update',$product) }}" method="POST" enctype="multipart/form-data"
          class="bg-white p-6 rounded shadow max-w-2xl">
        @csrf @method('PUT')
        @include('admin.products.partials.form', ['product'=>$product, 'categories'=>$categories, 'button'=>'Update'])
    </form>
@endsection
