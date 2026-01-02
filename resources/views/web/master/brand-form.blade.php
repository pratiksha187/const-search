@extends('layouts.adminapp')

@section('content')
<div class="container">
    <h4>{{ isset($brand) ? 'Edit' : 'Add' }} Brand</h4>

    <form method="POST"
          action="{{ isset($brand)
                ? route('brands.update',$brand->id)
                : route('brands.store') }}">
        @csrf
        @isset($brand) @method('PUT') @endisset

        <div class="mb-3">
            <label>Material Product *</label>
            <select name="material_product_id" class="form-select" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                <option value="{{ $product->id }}"
                    {{ old('material_product_id',$brand->material_product_id ?? '') == $product->id ? 'selected' : '' }}>
                    {{ $product->product_name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Brand Name *</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name',$brand->name ?? '') }}"
                   required>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('brands.index') }}"
           class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
