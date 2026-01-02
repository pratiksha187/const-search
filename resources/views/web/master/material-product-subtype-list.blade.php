@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Material Product Subtypes</h4>
        <a href="{{ route('material-product-subtypes.create') }}"
           class="btn btn-primary">
            + Add Sub Product
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Product</th>
                <th>Sub Product</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($subtypes as $sub)
            <tr>
                <td>{{ $subtypes->firstItem() + $loop->index }}</td>
                <td>{{ $sub->product->product_name ?? '-' }}</td>
                <td>{{ $sub->material_subproduct }}</td>
                <td>
                    <a href="{{ route('material-product-subtypes.edit',$sub->id) }}"
                       class="btn btn-sm btn-warning">Edit</a>

                    <button class="btn btn-sm btn-danger delete-btn"
                            data-id="{{ $sub->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $subtypes->links('pagination::bootstrap-5') }}
</div>
<!-- jQuery (REQUIRED for AJAX delete & pagination) -->
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
