<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th width="60">#</th>
            <th>Project</th>
            <th>Type</th>
            <th>Location</th>
            <th>Budget</th>
            <th>Status</th>
            <th width="120">Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($posts as $i => $post)
            <tr>
                <td>{{ $posts->firstItem() + $i }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->work_type_name }}</td>
                <td>{{ $post->statename }}, {{ $post->regionname }}, {{ $post->cityname }}</td>
                <td>{{ $post->budget_range }}</td>
                <td>
                    @if($post->post_verify)
                        <span class="badge bg-success">Verified</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>
                <td>
                    <button class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i> View
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center text-muted">
                    No records found
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- PAGINATION BAR -->
<div class="row align-items-center mt-3">
    <div class="col-md-6 text-muted">
        Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} results
    </div>
    <div class="col-md-6 d-flex justify-content-end">
        {{ $posts->links() }}
    </div>
</div>
