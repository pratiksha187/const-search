<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th width="60">#</th>
            <th>Name</th>
            <th>Slug</th>
            <th width="120">Status</th>
            <th width="80">Sort</th>
            <th width="160">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($categories as $cat)
        <tr>
            <td>{{ $categories->firstItem() + $loop->index }}</td>
            <td>{{ $cat->name }}</td>
            <td>{{ $cat->slug }}</td>
            <td>
                <span class="badge {{ $cat->status ? 'bg-success' : 'bg-danger' }}">
                    {{ $cat->status ? 'Active' : 'Inactive' }}
                </span>
            </td>
            <td>{{ $cat->sort_order }}</td>
            <td>
                <a href="{{ route('material-categories.edit', $cat->id) }}"
                   class="btn btn-sm btn-warning">Edit</a>

                <button type="button"
                        class="btn btn-sm btn-danger delete-btn"
                        data-id="{{ $cat->id }}">
                    Delete
                </button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">No records found</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="d-flex justify-content-center mt-3">
    {{ $categories->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
/* ✅ Delete category (AJAX) + reload current page with current search */
$(document).on('click', '.delete-btn', function () {
    if (!confirm('Are you sure you want to delete this category?')) return;

    let id = $(this).data('id');

    $.ajax({
        url: "{{ url('material-categories') }}/" + id,
        type: "POST",
        data: {
            _method: "DELETE",
            _token: "{{ csrf_token() }}"
        },
        success: function (res) {
            alert(res.message || 'Deleted');

            // reload current page
            let currentUrl = $('#table-data .pagination .active a').attr('href') || "{{ route('material-categories.index') }}";
            loadTable(currentUrl);
        }
    });
});
</script>
