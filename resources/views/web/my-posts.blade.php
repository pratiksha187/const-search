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
                <h3 class="fw-bold mb-0">My Project Posts</h3>
                <small>Total Posts: {{ $posts->count() }}</small>
            </div>

            <a href="{{ route('post') }}" class="btn btn-warning text-white">
                <i class="bi bi-plus-circle"></i> Add Project
            </a>
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
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $i => $post)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->work_type_name }}</td>
                            <td>
                                {{ $post->statename }},
                                {{ $post->regionname }},
                                {{ $post->cityname }}
                            </td>
                            <td>{{ $post->budget_range }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary"
                                    onclick='openEditModal(@json($post))'>
                                    <i class="bi bi-pencil"></i> Edit
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
<div class="modal fade" id="postModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form id="postForm" method="POST">
                @csrf
                <div id="methodField"></div>

                <div class="modal-header">
                    <h5 id="modalTitle" class="fw-bold">Edit Project</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Project Title</label>
                            <input type="text" id="title" name="title" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Vendor Type</label>
                            <select id="work_type_id" name="work_type_id" class="form-select">
                                @foreach($work_types as $w)
                                    <option value="{{ $w->id }}">{{ $w->work_type }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Project Type</label>
                            <select id="work_subtype_id" name="work_subtype_id" class="form-select">
                                <option value="">Select Project Type</option>
                            </select>
                        </div>

                       
                        <div class="col-md-4">
                        <label class="form-label">State</label>
                        <select id="state_id" name="state_id" class="form-select">
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Region</label>
                        <select id="region_id" name="region_id" class="form-select">
                            <option value="">Select Region</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <select id="city_id" name="city_id" class="form-select">
                            <option value="">Select City</option>
                        </select>
                    </div>

                        <div class="col-md-4">
                            <label class="form-label-custom">Approx Budget (₹)</label>
                            <select class="form-select form-select" name="budget"  id="budget">
                                <option value="">Select Budget</option>
                                @foreach($budget_range as $range)
                                    <option value="{{ $range->id }}">{{ $range->budget_range }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Contact Name</label>
                            <input type="text" id="contact_name" name="contact_name" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Mobile</label>
                            <input type="text" id="mobile" name="mobile" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Description</label>
                            <textarea id="description" name="description" rows="3" class="form-control"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button id="submitBtn" class="btn btn-warning text-white">
                        Update Project
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
const modal = new bootstrap.Modal(document.getElementById('postModal'));


function openEditModal(post) {

    $('#postForm').attr('action', `/posts/${post.id}`);
    $('#methodField').html('<input type="hidden" name="_method" value="PUT">');

    $('#title').val(post.title);
    $('#work_type_id').val(post.work_type_id);
    loadProjectTypes(post.work_type_id, post.work_subtype_id);

    // ✅ LOCATION NOW WORKS
    $('#state_id').val(post.state_id);
    loadRegions(post.state_id, post.region_id, post.city_id);

    // ✅ BUDGET FIXED
    $('#budget').val(post.budget_id);

    $('#contact_name').val(post.contact_name);
    $('#mobile').val(post.mobile);
    $('#email').val(post.email);
    $('#description').val(post.description);

    modal.show();
}




$('#work_type_id').on('change', function () {
    loadProjectTypes($(this).val());
});

function loadProjectTypes(workTypeId, selectedId = null) {

    let select = $('#work_subtype_id');
    select.html('<option value="">Loading...</option>');

    if (!workTypeId) {
        select.html('<option value="">Select Project Type</option>');
        return;
    }

    $.get('/get-project-types/' + workTypeId, function (data) {

        select.html('<option value="">Select Project Type</option>');

        data.forEach(item => {
            let selected = selectedId == item.id ? 'selected' : '';
            select.append(
                `<option value="${item.id}" ${selected}>
                    ${item.work_subtype}
                </option>`
            );
        });
    });
}

</script>
<script>
$('#work_type_id').on('change', function () {

    let workTypeId = $(this).val();
    let select = $('#work_subtype_id');

    select.html('<option value="">Loading...</option>');

    if (workTypeId) {
        $.get('/get-project-types/' + workTypeId, function (data) {

            select.html('<option value="">Select Project Type</option>');

            data.forEach(item => {
                select.append(
                    `<option value="${item.id}">${item.work_subtype}</option>`
                );
            });
        });
    } else {
        select.html('<option value="">Select Project Type</option>');
    }
});
</script>
<script>
$('#state_id').on('change', function () {
    loadRegions($(this).val());
});

function loadRegions(stateId, selectedRegion = null, selectedCity = null) {

    let regionSelect = $('#region_id');
    let citySelect = $('#city_id');

    regionSelect.html('<option value="">Loading...</option>');
    citySelect.html('<option value="">Select City</option>');

    if (!stateId) {
        regionSelect.html('<option value="">Select Region</option>');
        return;
    }

    $.get('/locations/regions/' + stateId, function (regions) {

        regionSelect.html('<option value="">Select Region</option>');

        regions.forEach(region => {
            let selected = region.id == selectedRegion ? 'selected' : '';
            regionSelect.append(
                `<option value="${region.id}" ${selected}>
                    ${region.name}
                </option>`
            );
        });

        if (selectedRegion) {
            loadCities(selectedRegion, selectedCity);
        }
    });
}


$('#region_id').on('change', function () {
    loadCities($(this).val());
});

function loadCities(regionId, selectedCity = null) {

    let citySelect = $('#city_id');
    citySelect.html('<option value="">Loading...</option>');

    if (!regionId) {
        citySelect.html('<option value="">Select City</option>');
        return;
    }

    $.get('/locations/cities/' + regionId, function (cities) {

        citySelect.html('<option value="">Select City</option>');

        cities.forEach(city => {
            let selected = city.id == selectedCity ? 'selected' : '';
            citySelect.append(
                `<option value="${city.id}" ${selected}>
                    ${city.name}
                </option>`
            );
        });
    });
}

</script>
@endsection
