@extends('layouts.vendorapp')
@section('title','Edit Product')

@section('content')

<div class="container-fluid px-4 py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold">
            Edit Product
        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('products.update',$product->id) }}"
                  enctype="multipart/form-data">
                @csrf

                <div class="row g-3">

                    {{-- CATEGORY --}}
                    <div class="col-md-4">
                        <label class="form-label">Category</label>
                        <select name="material_category_id" class="form-select">
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}"
                                    {{ $product->material_category_id == $c->id ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PRODUCT --}}
                    <div class="col-md-4">
                        <label class="form-label">Product</label>
                        <select name="material_product_id" class="form-select">
                            @foreach($products as $p)
                                <option value="{{ $p->id }}"
                                    {{ $product->material_product_id == $p->id ? 'selected' : '' }}>
                                    {{ $p->product_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- SUBTYPE --}}
                    <div class="col-md-4">
                        <label class="form-label">Subtype</label>
                        <select name="material_product_subtype_id" class="form-select">
                            @foreach($subtypes as $s)
                                <option value="{{ $s->id }}"
                                    {{ $product->material_product_subtype_id == $s->id ? 'selected' : '' }}>
                                    {{ $s->material_subproduct }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- BRAND --}}
                    <div class="col-md-4">
                        <label class="form-label">Brand</label>
                        <select name="brand_id" class="form-select">
                            @foreach($brands as $b)
                                <option value="{{ $b->id }}"
                                    {{ $product->brand_id == $b->id ? 'selected' : '' }}>
                                    {{ $b->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- UNIT --}}
                    <div class="col-md-4">
                        <label class="form-label">Unit</label>
                        <select name="unit_id" class="form-select">
                            @foreach($units as $u)
                                <option value="{{ $u->id }}"
                                    {{ $product->unit_id == $u->id ? 'selected' : '' }}>
                                    {{ $u->unitname }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- DELIVERY --}}
                    <div class="col-md-4">
                        <label class="form-label">Delivery Type</label>
                        <select name="delivery_type_id" class="form-select">
                            @foreach($deliveryTypes as $d)
                                <option value="{{ $d->id }}"
                                    {{ $product->delivery_type_id == $d->id ? 'selected' : '' }}>
                                    {{ $d->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- PRICE --}}
                    <div class="col-md-4">
                        <label class="form-label">Price (₹)</label>
                        <input type="number" step="0.01"
                               name="price"
                               class="form-control"
                               value="{{ $product->price }}" required>
                    </div>

                    {{-- GST --}}
                    <div class="col-md-4">
                        <label class="form-label">GST %</label>
                        <input type="number"
                               name="gst_percent"
                               class="form-control"
                               value="{{ $product->gst_percent }}">
                    </div>

                    {{-- GST INCLUDED --}}
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check">
                            <input type="checkbox"
                                   name="gst_included"
                                   value="1"
                                   class="form-check-input"
                                   {{ $product->gst_included ? 'checked' : '' }}>
                            <label class="form-check-label">GST Included</label>
                        </div>
                    </div>

                    {{-- IMAGE --}}
                    <div class="col-md-6">
                        <label class="form-label">Product Image</label>
                        <input type="file" name="image" class="form-control">
                        @if($product->image)
                            <img src="{{ asset('uploads/products/'.$product->image) }}"
                                 class="mt-2 rounded"
                                 width="120">
                        @endif
                    </div>

                </div>

                <div class="mt-4">
                    <button class="btn btn-success">Update Product</button>
                    <a href="{{ route('myproducts') }}" class="btn btn-secondary">Back</a>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection
