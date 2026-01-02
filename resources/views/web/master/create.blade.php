@extends('layouts.adminapp')

@section('content')
<div class="container">
    <h4>{{ isset($category) ? 'Edit' : 'Add' }} Category</h4>

    <form method="POST"
        action="{{ isset($category) 
            ? route('material-categories.update',$category->id) 
            : route('material-categories.store') }}">
        @csrf
        @isset($category) @method('PUT') @endisset

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name',$category->name ?? '') }}" required>
        </div>

        <!-- <div class="mb-3">
            <label>Sort Order</label>
            <input type="number" name="sort_order" class="form-control"
                   value="{{ old('sort_order',$category->sort_order ?? 0) }}">
        </div> -->
        <div class="mb-3">
            <label>Sort Order</label>
            <input type="number"
                name="sort_order"
                class="form-control"
                value="{{ old(
                        'sort_order',
                        isset($category)
                            ? $category->sort_order
                            : ($nextSortOrder ?? 1)
                ) }}">
        </div>


        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ (isset($category) && $category->status) ? 'selected' : '' }}>
                    Active
                </option>
                <option value="0" {{ (isset($category) && !$category->status) ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="{{ route('material-categories.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
