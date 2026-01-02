@extends('layouts.adminapp')

@section('content')
<div class="container">
    <h4>{{ isset($profiletype) ? 'Edit' : 'Add' }} Profile Type</h4>

    <form method="POST"
          action="{{ isset($profiletype)
                ? route('profiletypes.update',$profiletype->id)
                : route('profiletypes.store') }}">
        @csrf
        @isset($profiletype) @method('PUT') @endisset

        <div class="mb-3">
            <label>Material Product Subtype *</label>
            <select name="sub_categories_id" class="form-select" required>
                <option value="">Select Sub Product</option>
                @foreach($subcategories as $sub)
                <option value="{{ $sub->id }}"
                    {{ old('sub_categories_id',$profiletype->sub_categories_id ?? '') == $sub->id ? 'selected' : '' }}>
                    {{ $sub->material_subproduct }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Profile Type *</label>
            <input type="text"
                   name="type"
                   class="form-control"
                   value="{{ old('type',$profiletype->type ?? '') }}"
                   required>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('profiletypes.index') }}"
           class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
