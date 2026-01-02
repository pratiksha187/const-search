@extends('layouts.adminapp')

@section('content')
<div class="container">
    <h4>{{ isset($subtype) ? 'Edit' : 'Add' }} Material Product Subtype</h4>

    <form method="POST"
          action="{{ isset($subtype)
                ? route('material-product-subtypes.update',$subtype->id)
                : route('material-product-subtypes.store') }}">
        @csrf
        @isset($subtype) @method('PUT') @endisset

        <div class="mb-3">
            <label>Material Product *</label>
            <select name="material_product_id" class="form-select" required>
                <option value="">Select Product</option>
                @foreach($products as $product)
                <option value="{{ $product->id }}"
                    {{ old('material_product_id',$subtype->material_product_id ?? '') == $product->id ? 'selected' : '' }}>
                    {{ $product->product_name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Sub Product Name *</label>
            <input type="text"
                   name="material_subproduct"
                   class="form-control"
                   value="{{ old('material_subproduct',$subtype->material_subproduct ?? '') }}"
                   required>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('material-product-subtypes.index') }}"
           class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
