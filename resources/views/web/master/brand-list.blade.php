@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Brand Master</h4>
        <a href="{{ route('brands.create') }}" class="btn btn-primary">
            + Add Brand
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Brand Name</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($brands as $brand)
            <tr>
                <td>{{ $brands->firstItem() + $loop->index }}</td>
                <td>{{ $brand->product->product_name ?? '-' }}</td>
                <td>{{ $brand->name }}</td>
                <td>
                    <a href="{{ route('brands.edit',$brand->id) }}"
                       class="btn btn-sm btn-warning">Edit</a>

                    <button class="btn btn-sm btn-danger delete-btn"
                            data-id="{{ $brand->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $brands->links('pagination::bootstrap-5') }}
</div>
<!-- jQuery (REQUIRED for AJAX delete & pagination) -->
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
        success:function(){
            location.reload();
        }
    });
});
</script>
@endsection
