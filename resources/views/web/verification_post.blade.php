@extends('layouts.adminapp')

@section('title', 'All Project Posts')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<div class="container-fluid py-4">

    {{-- ================= HEADER ================= --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center">

                <div class="col-md-6">
                    <h3 class="fw-bold mb-1">My Project Posts</h3>
                    <small class="text-muted">Total Posts: {{ $posts->total() }}</small>
                </div>

                <div class="col-md-4 ms-auto">
                    <input
                        type="text"
                        id="tableSearch"
                        class="form-control"
                        placeholder="Search project, type, location..."
                    >
                </div>

            </div>
        </div>
    </div>

    {{-- ================= TABLE ================= --}}
    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table id="postverifyTable" class="table table-bordered table-hover align-middle w-100">
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
                            <td><strong>{{ $post->title }}</strong></td>
                            <td>{{ $post->work_type_name ?? '-' }}</td>
                            <td>
                                {{ $post->statename ?? '-' }},
                                {{ $post->regionname ?? '-' }},
                                {{ $post->cityname ?? '-' }}
                            </td>
                            <td>{{ $post->budget_range ?? '-' }}</td>
                            <td>
                                @if($post->post_verify == 1)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-primary"
                                    onclick='openViewModal(@json($post))'>
                                    <i class="bi bi-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
ops
                            <td colspan="7" class="text-center text-muted py-4">
                                No project posts found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ================= PAGINATION ================= --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links('pagination::bootstrap-5') }}
    </div>

</div>

{{-- ================= MODAL ================= --}}
<div class="modal fade" id="postModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form id="postForm" method="POST">
                {{-- IMPORTANT: explicit CSRF --}}
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="modal-header">
                    <h5 class="fw-bold mb-0">Project Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Project Title</label>
                            <input type="text" id="title" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Vendor Type</label>
                            <input type="text" id="work_type" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Project Type</label>
                            <input type="text" id="work_subtype" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" id="state" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Region</label>
                            <input type="text" id="region" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" id="city" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Budget</label>
                            <input type="text" id="budget" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Contact Name</label>
                            <input type="text" id="contact_name" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Mobile</label>
                            <input type="text" id="mobile" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" disabled>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea id="description" class="form-control" rows="3" disabled></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Project Status</label>
                            <select name="post_verify" id="status" class="form-select">
                                <option value="0">Select Action</option>
                                <option value="1">Accept</option>
                               
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">
                        Submit Decision
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- ================= SCRIPTS ================= --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const modal = new bootstrap.Modal(document.getElementById('postModal'));

function openViewModal(post) {

    // IMPORTANT: always reset form action
    document.getElementById('postForm').action = `/posts/${post.id}`;

    $('#title').val(post.title);
    $('#work_type').val(post.work_type_name);
    $('#work_subtype').val(post.work_subtype_name);
    $('#state').val(post.statename);
    $('#region').val(post.regionname);
    $('#city').val(post.cityname);
    $('#budget').val(post.budget_range);
    $('#contact_name').val(post.contact_name);
    $('#mobile').val(post.mobile);
    $('#email').val(post.email);
    $('#description').val(post.description);
    $('#status').val(post.post_verify ?? '');

    modal.show();
}
</script>

<script>
$(function () {
    $('#tableSearch').on('keyup', function () {
        let value = $(this).val().toLowerCase();
        $('#postverifyTable tbody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
});
</script>

@endsection
