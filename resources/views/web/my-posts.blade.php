@extends('layouts.custapp')

@section('title', 'My Project Posts')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="card mb-4">
        <div class="card-body d-flex justify-content-between align-items-center">
            <div>
                <h3 class="fw-bold">My Project Posts</h3>
                <small>Total Posts: {{ $posts->count() }}</small>
            </div>
            <button class="btn btn-warning text-white" onclick="openAddModal()">
                <i class="bi bi-plus-circle"></i> Add Project
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="card">
        <div class="card-body">
            <table id="postsTable" class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Project</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Budget</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($posts as $i => $post)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->work_type_name }}</td>
                        <td>{{ $post->city }}, {{ $post->state }}</td>
                        <td>{{ $post->budget_range }}</td>
                        <td>
                           

                            <button class="btn btn-sm btn-primary"
                                onclick='openEditModal(@json($post))'>Edit</button>

                            <!-- <button class="btn btn-sm btn-danger"
                                onclick="deletePost({{ $post->id }})">Delete</button> -->
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ================= MODAL ================= -->
<div class="modal fade" id="postModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form id="postForm" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="methodField">
                <div class="modal-header">
                    <h5 id="modalTitle">Add Project</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label>Project Title</label>
                            <input type="text" name="title" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Vendor Type</label>
                            <select name="work_type_id" class="form-select">
                                @foreach($work_types as $w)
                                    <option value="{{ $w->id }}">{{ $w->work_type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label>Project Type</label>
                            <select name="work_subtype_id" class="form-select"></select>
                        </div>

                        <div class="col-md-4">
                            <label>State</label>
                            <input type="text" name="state" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Region</label>
                            <input type="text" name="region" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>City</label>
                            <input type="text" name="city" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Budget</label>
                            <input type="text" name="budget" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Contact Name</label>
                            <input type="text" name="contact_name" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Mobile</label>
                            <input type="text" name="mobile" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label>Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button id="submitBtn" class="btn btn-warning text-white">Submit</button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script>
const modal = new bootstrap.Modal(document.getElementById('postModal'));

function openAddModal() {
    resetForm();
    $('#modalTitle').text('Add Project');
    $('#postForm').attr('action', '{{ route("save.post") }}');
    $('#methodField').html('');
    enableForm(true);
    modal.show();
}

function openEditModal(post) {
    fillForm(post);
    enableForm(true);
    $('#modalTitle').text('Edit Project');
    $('#submitBtn').show().text('Update');
    $('#postForm').attr('action', `/posts/${post.id}`);
    $('#methodField').html('<input type="hidden" name="_method" value="PUT">');
    modal.show();
}

function fillForm(post) {
    Object.keys(post).forEach(k => {
        $(`[name="${k}"]`).val(post[k]);
    });
}

function enableForm(enable) {
    $('#postForm input, #postForm select, #postForm textarea')
        .prop('disabled', !enable);
}

function resetForm() {
    $('#postForm')[0].reset();
}
</script>

@endsection
