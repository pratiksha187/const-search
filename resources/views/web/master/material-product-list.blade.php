@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Material Products</h4>
        <a href="{{ route('material-products.create') }}" class="btn btn-primary">
            + Add Product
        </a>
    </div>

    {{-- ✅ Search Bar --}}
    <form action="{{ route('material-products.index') }}" method="GET" class="row g-2 align-items-center mb-3">
        <div class="col-md-4">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search product / category..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-dark">Search</button>
        </div>

        <div class="col-md-2 d-grid">
            <a href="{{ route('material-products.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th width="60">#</th>
                <th>Category</th>
                <th>Product Name</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
            <tr>
                <td>{{ $products->firstItem() + $loop->index }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ $product->product_name }}</td>
                <td>
                    <a href="{{ route('material-products.edit',$product->id) }}"
                       class="btn btn-sm btn-warning">Edit</a>

                    <button type="button"
                            class="btn btn-sm btn-danger delete-btn"
                            data-id="{{ $product->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center text-muted">No records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ✅ Keep search keyword while paginating --}}
    {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).on('click','.delete-btn',function(){
    if(!confirm('Delete this product?')) return;

    let id = $(this).data('id');

    $.ajax({
        url: "{{ url('material-products') }}/" + id,
        type: "POST",
        data:{
            _method:'DELETE',
            _token:"{{ csrf_token() }}"
        },
        success:function(res){
            location.reload();
        }
    });
});
</script>
@endsection
