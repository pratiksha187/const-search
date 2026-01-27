@extends('layouts.suppliersapp')

@section('title','My Products')

@section('content')

<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">My Added Products</h4>
        <a href="{{ route('addproducts') }}" class="btn"
           style="background:var(--orange);color:#fff;">
            + Add Product
        </a>
    </div>
    <form method="GET" action="{{ route('myproducts') }}" class="row g-2 mb-3">

        <div class="col-md-3">
            <input type="text"
                name="search"
                class="form-control"
                placeholder="Search product / brand"
                value="{{ request('search') }}">
        </div>

        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">All Categories</option>
                @foreach($products->unique('category') as $p)
                    @if($p->category)
                        <option value="{{ $p->category }}"
                            {{ request('category') == $p->category ? 'selected' : '' }}>
                            {{ $p->category }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>

        <div class="col-md-2">
            <select name="gst" class="form-select">
                <option value="">GST Status</option>
                <option value="1" {{ request('gst') === '1' ? 'selected' : '' }}>
                    GST Included
                </option>
                <option value="0" {{ request('gst') === '0' ? 'selected' : '' }}>
                    GST Excluded
                </option>
            </select>
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                🔍 Filter
            </button>
        </div>

        <div class="col-md-2">
            <a href="{{ route('myproducts') }}" class="btn btn-secondary w-100">
                Reset
            </a>
        </div>

    </form>

    <div class="card shadow-sm">
        
        <div class="card-body">

            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Subtype</th>
                        <th>Brand</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>GST</th>
                        <th>Delivery Time</th>
                        <th>Image</th>
                        <th>Added On</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $key => $row)
                        <tr>
                            <td>{{ $products->firstItem() + $key }}</td>

                            <td>{{ $row->category ?? '-' }}</td>
                            <td>{{ $row->product ?? '-' }}</td>
                            <td>{{ $row->subtype ?? '-' }}</td>
                            <td>{{ $row->brand ?? '-' }}</td>
                            <td>{{ $row->unit }}</td>

                            <td>₹ {{ number_format($row->price,2) }}</td>

                            <td>
                                @if($row->gst_included)
                                    {{ $row->gst_percent }}%
                                @else
                                    Excluded
                                @endif
                            </td>

                            <td>{{ $row->delivery_time ?? '-' }} - Days</td>

                            <td>
                                @if($row->image)
                                    <img src="{{ asset('uploads/products/'.$row->image) }}"
                                         width="50" class="rounded">
                                @else
                                    —
                                @endif
                            </td>

                            <td>{{ date('d M Y', strtotime($row->created_at)) }}</td>

                            <td>
                                <a href="{{ route('products.edit',$row->id) }}"
                                   class="btn btn-sm btn-primary">Edit</a>

                                <a href="{{ route('products.delete',$row->id) }}"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Delete product?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">
                                No products added yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-end mt-3">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>

</div>

@endsection
