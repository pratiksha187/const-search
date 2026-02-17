@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Material Product Subtypes</h4>
        <a href="{{ route('material-product-subtypes.create') }}" class="btn btn-primary">
            + Add Sub Product
        </a>
    </div>

    {{-- ✅ Search Bar --}}
    <form action="{{ route('material-product-subtypes.index') }}" method="GET" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search sub product / product..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-dark">Search</button>
        </div>

        <div class="col-md-2 d-grid">
            <a href="{{ route('material-product-subtypes.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Sub Product</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subtypes as $sub)
            <tr>
                <td>{{ $subtypes->firstItem() + $loop->index }}</td>
                <td>{{ $sub->product->product_name ?? '-' }}</td>
                <td>{{ $sub->material_subproduct }}</td>
                <td>
                    <a href="{{ route('material-product-subtypes.edit',$sub->id) }}" class="btn btn-sm btn-warning">Edit</a>

                    <button class="btn btn-sm btn-danger delete-btn" data-id="{{ $sub->id }}">
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

    {{ $subtypes->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).on('click','.delete-btn',function(){
    if(!confirm('Delete this sub product?')) return;

    let id = $(this).data('id');

    $.ajax({
        url: "{{ url('material-product-subtypes') }}/" + id,
        type: "POST",
        data:{
            _method:'DELETE',
            _token:"{{ csrf_token() }}"
        },
        success:function(){
            location.reload();
        }
    });
});
</script>
@endsection
