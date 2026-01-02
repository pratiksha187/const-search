@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between mb-3">
        <h4>Material Categories</h4>
        <a href="{{ route('material-categories.create') }}" class="btn btn-primary">
            + Add Category
        </a>
    </div>

    <div id="table-data">
        @include('web.master.material-categories-table')
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).on('click', '#table-data .pagination a', function(e){
    e.preventDefault();

    let url = $(this).attr('href');

    $.ajax({
        url: url,
        type: "GET",
        success: function(data){
            $('#table-data').html(data);

            // 🔥 Keep URL clean (no ?page=)
            history.replaceState(null, '', location.pathname);
        }
    });
});
</script>
@endpush
