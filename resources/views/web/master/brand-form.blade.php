@extends('layouts.adminapp')

@section('content')
<div class="container">
    <h4>{{ isset($brand) ? 'Edit' : 'Add' }} Brand</h4>

    <form method="POST" 
          action="{{ isset($brand) ? route('brands.update', $brand->id) : route('brands.store') }}" 
          enctype="multipart/form-data">
          
        @csrf
        @isset($brand)
            @method('PUT')
        @endisset

        <!-- Material Product -->
        <div class="mb-3">
            <label>Material Product *</label>
            <select name="material_product_id" class="form-select" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" 
                        {{ old('material_product_id', $brand->material_product_id ?? '') == $product->id ? 'selected' : '' }}>
                        {{ $product->product_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Brand Name -->
        <div class="mb-3">
            <label>Brand Name *</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $brand->name ?? '') }}" required>
        </div>

        <!-- Brand Logo -->
        <div class="mb-3">
            <label>Brand Logo</label>
            <input type="file" name="logo" class="form-control" accept="image/*">

            @if(isset($brand) && $brand->logo)
                <img src="{{ asset('storage/brands/'.$brand->logo) }}" 
                    alt="{{ $brand->name }}" 
                    style="height:70px; border:1px solid #ccc; padding:4px; border-radius:8px;">
            @endif

        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
