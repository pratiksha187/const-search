@extends('layouts.adminapp')

@section('content')
<div class="container">
    <h4>{{ isset($product) ? 'Edit' : 'Add' }} Material Product</h4>

    <form method="POST"
          action="{{ isset($product)
                ? route('material-products.update',$product->id)
                : route('material-products.store') }}">
        @csrf
        @isset($product) @method('PUT') @endisset

        <div class="mb-3">
            <label>Material Category *</label>
            <select name="material_id" class="form-select" required>
                <option value="">Select Category</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}"
                    {{ old('material_id',$product->material_id ?? '') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Product Name *</label>
            <input type="text"
                   name="product_name"
                   class="form-control"
                   value="{{ old('product_name',$product->product_name ?? '') }}"
                   required>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('material-products.index') }}"
           class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
