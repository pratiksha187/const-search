@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Material Products</h4>
        <a href="{{ route('material-products.create') }}" class="btn btn-primary">
            + Add Product
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Category</th>
                <th>Product Name</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $products->firstItem() + $loop->index }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ $product->product_name }}</td>
                <td>
                    <a href="{{ route('material-products.edit',$product->id) }}"
                       class="btn btn-sm btn-warning">Edit</a>

                    <button class="btn btn-sm btn-danger delete-btn"
                            data-id="{{ $product->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links('pagination::bootstrap-5') }}
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
