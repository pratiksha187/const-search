@extends('layouts.adminapp')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Brand Master</h4>
        <a href="{{ route('brands.create') }}" class="btn btn-primary">
            + Add Brand
        </a>
    </div>

    {{-- ✅ Proper Search Bar (works with Controller search logic) --}}
    <form action="{{ route('brands.index') }}" method="GET" class="row g-2 align-items-center mb-3">
        <div class="col-md-5">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search by brand or product..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-dark">Search</button>
        </div>

        <div class="col-md-2 d-grid">
            <a href="{{ route('brands.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>

        <!-- @if(request('search'))
            <div class="col-md-3 d-flex align-items-center">
                <span class="small text-muted">
                    Showing results for: <b>{{ request('search') }}</b>
                </span>
            </div>
        @endif -->
    </form>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th width="60">#</th>
                <th>Product</th>
                <th>Brand Name</th>
                <th width="140">Logo</th>
                <th width="160">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($brands as $brand)
            <tr>
                <td>{{ $brands->firstItem() + $loop->index }}</td>
                <td>{{ $brand->product->product_name ?? '-' }}</td>
                <td>{{ $brand->name }}</td>
                <td>
                    @if(!empty($brand->logo))
                        <img src="{{ asset('storage/brands/'.$brand->logo) }}" height="45" alt="{{ $brand->name }}">
                    @else
                        <span class="text-muted">No logo</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('brands.edit',$brand->id) }}"
                       class="btn btn-sm btn-warning">Edit</a>

                    <button type="button"
                            class="btn btn-sm btn-danger delete-btn"
                            data-id="{{ $brand->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No brands found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ✅ Keep search keyword while paginating --}}
    {{ $brands->appends(request()->query())->links('pagination::bootstrap-5') }}

</div>

<!-- jQuery (required for AJAX delete) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
$(document).on('click','.delete-btn',function(){
    if(!confirm('Delete this brand?')) return;

    let id = $(this).data('id');

    $.ajax({
        url: "{{ url('brands') }}/" + id,
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
