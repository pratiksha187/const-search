@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Profile Types</h4>
        <a href="{{ route('profiletypes.create') }}" class="btn btn-primary">
            + Add Profile Type
        </a>
    </div>

    {{-- ✅ Search Bar --}}
    <form action="{{ route('profiletypes.index') }}" method="GET" class="row g-2 align-items-center mb-3">
        <div class="col-md-4">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search profile type / sub product..."
                   value="{{ request('search') }}">
        </div>

        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-dark">Search</button>
        </div>

        <div class="col-md-2 d-grid">
            <a href="{{ route('profiletypes.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>

    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th width="60">#</th>
                <th>Sub Product</th>
                <th>Profile Type</th>
                <th width="150">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($profiletypes as $pt)
            <tr>
                <td>{{ $profiletypes->firstItem() + $loop->index }}</td>
                <td>{{ $pt->subcategory->material_subproduct ?? '-' }}</td>
                <td>{{ $pt->type }}</td>
                <td>
                    <a href="{{ route('profiletypes.edit',$pt->id) }}"
                       class="btn btn-sm btn-warning">Edit</a>

                    <button type="button"
                            class="btn btn-sm btn-danger delete-btn"
                            data-id="{{ $pt->id }}">
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

    {{-- ✅ Keep search while paginating --}}
    {{ $profiletypes->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

{{-- jQuery required for delete --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
