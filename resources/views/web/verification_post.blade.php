@extends('layouts.adminapp')

@section('title', 'All Project Posts')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold mb-0">My Project Posts</h3>
                <small>Total Posts: {{ $posts->count() }}</small>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-body">
            <table id="postsTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Project</th>
                        <th>Type</th>
                        <th>Location</th>
                        <th>Budget</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $i => $post)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->work_type_name }}</td>
                            <td>{{ $post->statename }}, {{ $post->regionname }}, {{ $post->cityname }}</td>
                            <td>{{ $post->budget_range }}</td>
                            <td>
                                @if($post->post_verify == 1)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    onclick='openViewModal(@json($post))'>
                                    <i class="bi bi-eye"></i> View
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="postModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form id="postForm" method="POST">
                @csrf

                <div class="modal-header">
                    <h5 class="fw-bold">Project Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <!-- Read-only Fields -->
                        <div class="col-md-4">
                            <label class="form-label">Project Title</label>
                            <input type="text" id="title" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Vendor Type</label>
                            <input type="text" id="work_type" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Project Type</label>
                            <input type="text" id="work_subtype" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">State</label>
                            <input type="text" id="state" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Region</label>
                            <input type="text" id="region" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">City</label>
                            <input type="text" id="city" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Budget</label>
                            <input type="text" id="budget" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Contact Name</label>
                            <input type="text" id="contact_name" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Mobile</label>
                            <input type="text" id="mobile" class="form-control" readonly>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" readonly>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea id="description" class="form-control" rows="3" readonly></textarea>
                        </div>

                        <!-- Status Dropdown -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Project Status</label>
                            <select name="post_verify" id="status" class="form-select" required>
                                <option value="">Select Action</option>
                                <option value="1">Accept</option>
                                <option value="0">Reject</option>
                            </select>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit Decision</button>
                </div>

            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const modal = new bootstrap.Modal(document.getElementById('postModal'));

function openViewModal(post) {
    // Set form action dynamically
    $('#postForm').attr('action', `/posts/${post.id}`);

    // Fill read-only inputs
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

    // Set status select and enable it
    $('#status').val(post.post_verify);
    $('#status').prop('disabled', false);

    // Make all other inputs readonly
    $('#postModal input, #postModal textarea').prop('readonly', true);

    modal.show();
}
</script>

@endsection
