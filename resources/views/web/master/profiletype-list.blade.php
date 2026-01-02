@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Profile Types</h4>
        <a href="{{ route('profiletypes.create') }}" class="btn btn-primary">
            + Add Profile Type
        </a>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Sub Product</th>
                <th>Profile Type</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($profiletypes as $pt)
            <tr>
                <td>{{ $profiletypes->firstItem() + $loop->index }}</td>
                <td>{{ $pt->subcategory->material_subproduct ?? '-' }}</td>
                <td>{{ $pt->type }}</td>
                <td>
                    <a href="{{ route('profiletypes.edit',$pt->id) }}"
                       class="btn btn-sm btn-warning">Edit</a>

                    <button class="btn btn-sm btn-danger delete-btn"
                            data-id="{{ $pt->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $profiletypes->links('pagination::bootstrap-5') }}
</div>

<script>
$(document).on('click','.delete-btn',function(){
    if(!confirm('Delete this profile type?')) return;

    let id = $(this).data('id');

    $.ajax({
        url: "{{ url('profiletypes') }}/" + id,
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
