@extends('layouts.adminapp')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Material Categories</h4>
        <a href="{{ route('material-categories.create') }}" class="btn btn-primary">
            + Add Category
        </a>
    </div>

    {{-- ✅ Search Bar (AJAX typing) --}}
    <form id="searchForm" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text"
                   name="search"
                   id="searchInput"
                   class="form-control"
                   placeholder="Search name / slug..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <button type="button" id="resetBtn" class="btn btn-outline-secondary w-100">
                Reset
            </button>
        </div>
    </form>

    <div id="table-data">
        @include('web.master.material-categories-table')
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
/* ✅ Load table with search + pagination */
function loadTable(url = null) {
    let baseUrl = url ?? "{{ route('material-categories.index') }}";
    let query = $('#searchForm').serialize(); // search=...

    // if baseUrl already has ?page=, then append with &
    let finalUrl = baseUrl + (baseUrl.includes('?') ? '&' : '?') + query;

    $.ajax({
        url: finalUrl,
        type: "GET",
        success: function (data) {
            $('#table-data').html(data);
        }
    });
}

/* ✅ Pagination click (AJAX) */
$(document).on('click', '#table-data .pagination a', function(e){
    e.preventDefault();
    loadTable($(this).attr('href'));
});

/* ✅ Search on typing (AJAX) */
let timer;
$(document).on('keyup', '#searchInput', function(){
    clearTimeout(timer);
    timer = setTimeout(function(){
        loadTable(); // always load page 1 with current search
    }, 350);
});

/* ✅ Reset button */
$(document).on('click', '#resetBtn', function(){
    $('#searchInput').val('');
    loadTable();
});
</script>
@endsection

