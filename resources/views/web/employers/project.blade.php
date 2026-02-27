@extends('layouts.employerapp')

@section('title', 'Project')

@section('page-title', 'Project')
@section('page-subtitle', 'High-level view of procurement activity')

@section('content')
<style>
.form-section {
    background: #f9fafc;
    padding: 20px;
    border-radius: 16px;
    border: 1px solid #eef1f4;
}

.section-heading {
    font-weight: 600;
    margin-bottom: 15px;
    color: #1c2c3e;
}

.modal-content {
    background: #ffffff;
}

.form-control-lg,
.form-select {
    border-radius: 12px;
}

.modal-header h5 {
    color: #1c2c3e;
}
</style>
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-0">Projects</h5>
                    <small class="text-muted">
                        Every RFQ and PO is tagged to a project
                    </small>
                </div>

                <button type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#projectModal">
                    <i class="bi bi-plus"></i> New Project
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Project</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>
                                    <strong>{{ $project->contact_name }}</strong>
                                    <div class="small text-muted">
                                        {{ $project->code }}
                                    </div>
                                </td>

                                <td>
                                    {{ $project->type_name ?? '-' }}
                                </td>

                                <td>
                                    {{ $project->statename ?? '-' }}, {{ $project->regionname ?? '-' }}, {{ $project->city_name ?? '-' }}
                                </td>

                                <td>
                                    {{ $project->budget_range }}
                                </td>

                                <td>
                                    @if($project->status == 'Active')
                                        <span class="badge bg-warning text-dark">
                                            {{ $project->status }}
                                        </span>
                                    @elseif($project->status == 'Planning')
                                        <span class="badge bg-secondary">
                                            {{ $project->status }}
                                        </span>
                                    @elseif($project->status == 'Completed')
                                        <span class="badge bg-success">
                                            {{ $project->status }}
                                        </span>
                                    @else
                                        <span class="badge bg-dark">
                                            {{ $project->status }}
                                        </span>
                                    @endif
                                </td>

                                
                                <td class="text-end">
                                    <a href="{{ route('employer.projects.show', $project->id) }}"
                                    class="btn btn-outline-primary btn-sm">
                                        Open Procurement
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No Projects Found
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<!-- Project Modal -->
<!-- Premium Project Modal -->
<div class="modal fade" id="projectModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">

            <!-- Header -->
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="fw-bold mb-1">Create New Project</h5>
                    <small class="text-muted">
                        Submit your project details to connect with verified vendors
                    </small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body pt-4">

                <form action="{{ route('save.project.details') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- SECTION 1 -->
                    <div class="form-section">
                        <h6 class="section-heading">Project Basics</h6>

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Vendor Type</label>
                                <select class="form-select form-control-lg" name="work_type_id" id="work_type">
                                    <option>Select Vendor Type</option>
                                    @foreach($work_types as $worktype)
                                        <option value="{{ $worktype->id }}">
                                            {{ $worktype->work_type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Project Type</label>
                                <select class="form-select form-control" name="work_subtype_id" id="work_subtype">
                                    <option>Select Project Type</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Project Title</label>
                                <input type="text"
                                       name="title"  id="project_title"
                                       class="form-control"
                                       placeholder="e.g. 2BHK Residential Construction">
                            </div>

                        </div>
                    </div>

                    <!-- SECTION 2 -->
                    <div class="form-section mt-4">
                        <h6 class="section-heading">Location Details</h6>

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">State</label>
                                <select class="form-select form-control" id="stateSelect" name="state_id">
                                    <option>Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Region</label>
                                <select class="form-select form-control" id="regionSelect" name="region_id">
                                    <option>Select Region</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">City</label>
                                <select class="form-select form-control" id="citySelect" name="city_id">
                                    <option>Select City</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <!-- SECTION 3 -->
                    <div class="form-section mt-4">
                        <h6 class="section-heading">Budget & Contact</h6>

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Approx Budget (₹)</label>
                                <select class="form-select form-control" name="budget">
                                    <option>Select Budget</option>
                                    @foreach($budget_range as $range)
                                        <option value="{{ $range->id }}">
                                            {{ $range->budget_range }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Contact Name</label>
                                <input type="text"
                                       name="contact_name"
                                       class="form-control form-control"
                                       placeholder="Aniket Patil">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Mobile</label>
                                <input type="text"
                                       name="mobile"
                                       class="form-control form-control"
                                       placeholder="9876543210">
                            </div>

                        </div>
                    </div>

                    <!-- SECTION 4 -->
                    <div class="form-section mt-4">
                        <h6 class="section-heading">Additional Details</h6>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Upload Drawings / BOQ</label>
                                <input type="file"
                                       name="files[]"
                                       class="form-control"
                                       multiple>
                                <small class="text-muted">
                                    PDF / JPG / PNG / Excel • Secure upload
                                </small>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Project Description</label>
                                <textarea class="form-control"
                                          rows="4"
                                          name="description"
                                          placeholder="Describe project scope, expected timeline, etc."></textarea>
                            </div>

                        </div>
                    </div>

                    <div class="form-section mt-4">
                        <h6 class="section-heading">Project Timeline & Category</h6>

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label class="form-label">Start Date</label>
                                <input type="date"
                                    name="start_date"
                                    class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">End Date</label>
                                <input type="date"
                                    name="end_date"
                                    class="form-control">
                            </div>

                           

                        </div>
                    </div>
                    <!-- Footer -->
                    <div class="modal-footer border-0 mt-4 pt-3">
                        <div class="w-100 d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                🔒 Shared only with verified vendors
                            </small>

                            <button type="submit"
                                    class="btn btn-primary px-4 rounded-pill">
                                Submit Project
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- <script>
const CUSTOMER_ID = {{ $customer_id ?? 'null' }}; // ✅ SAFE

$(document).on('click', '#payProjectSubscription', function () {

    if (!CUSTOMER_ID) {
        Swal.fire('Session Expired', 'Please login again', 'warning');
        return;
    }

    console.log('custId:', CUSTOMER_ID); // ✅ will show number

    const totalAmount = 4999; // 
    const plan = 'single';

    $.post("{{ route('razorpay.createOrder') }}", {
        _token: "{{ csrf_token() }}",
        cust_id: CUSTOMER_ID,
        plan: plan,
        amount: totalAmount
    }, function (res) {

        if (!res.success) {
            Swal.fire('Error', 'Order creation failed', 'error');
            return;
        }

        const options = {
            key: res.key,
            amount: res.amount,
            currency: "INR",
            name: "ConstructKaro",
            description: "Project Activation Fee",
            order_id: res.order_id,

            prefill: {
                name: "ConstructKaro",
                email: "connect@constructkaro.com",
                contact: "8806561819"
            },

            handler: function (response) {

                $.post("{{ route('razorpay.verify') }}", {
                    _token: "{{ csrf_token() }}",
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature,
                    cust_id: btoa(CUSTOMER_ID),
                    plan: plan,
                    amount: totalAmount,
                    c: 'project_activation'
                }, function (verifyRes) {

                    if (verifyRes.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful',
                            text: 'Payment completed successfully',
                            confirmButtonColor: '#10b981'
                        }).then(() => {
                            window.location.href = "{{ route('post') }}";
                        });
                    } else {
                        Swal.fire('Error', 'Payment verification failed', 'error');
                    }
                });
            },

            theme: { color: "#f25c05" }
        };

        new Razorpay(options).open();
    });
});
</script> -->

<script>
$(document).ready(function () {
    // Initialize Select2
    $('.select2').select2({
        placeholder: "Select an option",
        allowClear: true,
        width: '100%'
    });


    $('#work_type').on('change', function () {
        let workTypeId = $(this).val();
        let select = $('#work_subtype');

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

    // Reset form
    $('#resetBtn').on('click', function () {
        $('#work_type').val(null).trigger('change');
        $('#workSubtypeCheckboxes').empty();
        $('#projectGroups').empty();
    });

});
</script>

<script>
$(document).ready(function () {

    /* ===============================
       STATE → REGION
    ================================*/
    $('#stateSelect').on('change', function () {

        let stateId = $(this).val();

        $('#regionSelect')
            .html('<option value="">Loading...</option>')
            .prop('disabled', true);

        $('#citySelect')
            .html('<option value="">Select City</option>')
            .prop('disabled', true);

        if (!stateId) {
            $('#regionSelect').html('<option value="">Select Region</option>');
            return;
        }

        $.get('/locations/regions/' + stateId, function (regions) {

            let options = '<option value="">Select Region</option>';

            regions.forEach(function (region) {
                options += `<option value="${region.id}">
                                ${region.name}
                            </option>`;
            });

            $('#regionSelect')
                .html(options)
                .prop('disabled', false);
        });
    });

    /* ===============================
       REGION → CITY
    ================================*/
    $('#regionSelect').on('change', function () {

        let regionId = $(this).val();

        $('#citySelect')
            .html('<option value="">Loading...</option>')
            .prop('disabled', true);

        if (!regionId) {
            $('#citySelect').html('<option value="">Select City</option>');
            return;
        }

        $.get('/locations/cities/' + regionId, function (cities) {

            let options = '<option value="">Select City</option>';

            cities.forEach(function (city) {
                options += `<option value="${city.id}">
                                ${city.name}
                            </option>`;
            });

            $('#citySelect')
                .html(options)
                .prop('disabled', false);
        });
    });

});
</script>
<script>

$('form').on('submit', function (e) {
    e.preventDefault();

    let form = this;
    let formData = new FormData(form);

    $.ajax({
        url: $(form).attr('action'),
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,

        success: function (res) {

            

           

            if (res.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: res.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('erpproject') }}";
                });
            }
        },

        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let msgs = Object.values(errors).flat().join('<br>');
                Swal.fire('Validation Error', msgs, 'error');
            } else {
                Swal.fire('Error', 'Something went wrong', 'error');
            }
        }
    });
});

</script>
<script>
const projectTitleSamples = {

    /* ================= CONTRACTOR (1) ================= */
    1: {
        1: "Construction of G+7 Residential Building",
        2: "Construction of Bituminous Road & Highway Stretch",
        3: "Construction of RCC Culvert for Residential Layout",
        4: "Earthwork & Excavation for G+4 Residential Building",
        6: "Electrical Works for 2BHK Residential Block",
        7: "Plumbing & Sanitary Works for G+5 Residential Building",
        8: "Mechanical Services Installation for G+2 Building",
        9: "HVAC Installation for G+5 Residential Building",
        10: "Interior & Exterior Painting for G+2 Residential Building",
        11: "Basement & Roof Waterproofing for G+3 Residential Building",
        12: "Structural Steel Fabrication for G+2 Residential Building",
        13: "Landscaping Works for Residential Building Premises",
        15: "Manpower Deployment for G+3 Building Project"
    },

    /* ================= ARCHITECT (2) ================= */
    2: {
        16: "Architectural Design for G+24 Residential Building",
        17: "Architectural Design for G+3 Office",
        18: "Landscape Design for G+10 Residential Building Premises",
        19: "Interior Design for G+2 Residential Building",
        20: "Urban Planning Design for Housing Project",
        21: "Architectural Design for Industrial Shed Building",
        22: "Conservation Planning for Old G+6 Structure",
        23: "Sustainable Design for G+14 Residential Building",
        24: "Structural Concept Design for G+8 Residential Building"
    },

    /* ================= CONSULTANT (3) ================= */
    3: {
        25: "Structural Design & Analysis for G+8 Residential Building",
        26: "Complete MEP Planning for G+5 Apartment",
        27: "HVAC Design Consultancy for G+10 Residential Building",
        28: "Project Management Consultancy for G+7 Residential Building",
        29: "Cost Estimation & BOQ for G+4 Residential Building",
        30: "Environmental Clearance Consultancy for G+8 Project",
        31: "Construction Safety Consultancy for G+4 Building Project",
        32: "Architectural Design Consultancy for G+8 Residential Building",
        35: "Urban Planning Services for Housing Project",
        36: "Soil Investigation & Geotechnical Study for G+8 Building",
        37: "Fire Fighting System Design for G+9 Residential Building",
        38: "Façade Design Consultancy for G+7 Residential Building",
        39: "Green Building Consultancy for G+12 Residential Project",
        40: "Quality Control & NDT Testing for G+11 Residential Building"
    },

    /* ================= INTERIORS (4) ================= */
    4: {
        41: "Interior Design for 2BHK Residential Plot – 500 sq.ft",
        42: "Interior Design for G+7 Commercial Bare Shell Office",
        43: "Office Interior Design for Corporate Building",
        44: "G+7 Hotel Interior Design Project",
        45: "Showroom Interior Design Project",
        46: "Luxury Interior Design for Apartment",
        47: "Minimalist Interior Design for Residential Apartment",
        48: "Modern Interior Design for G+2 Residential Building",
        49: "Industrial Theme Interior Design for Office Space",
        50: "Traditional Interior Design for Residential G+2 Home",
        51: "Modular Kitchen & Wardrobe Interior Project"
    },

    /* ================= SURVEYOR (5) ================= */
    5: {
        52: "Land Survey for Residential Building Plot",
        53: "Quantity Survey & BOQ for G+2 Residential Building",
        54: "Building Condition Survey for G+2 Residential Building",
        55: "Rock & Soil Study for Residential Project",
        56: "Topographic Survey for Residential Plot Development",
        57: "Drainage & Water Flow Survey for Construction Site",
        58: "Mine Site Survey for Industrial Development",
        59: "Structural Survey for G+2 Residential Building",
        60: "Drone Survey & Mapping for Residential Land"
    }
};


/* ================= AUTO SET PLACEHOLDER ================= */
document.getElementById('work_subtype').addEventListener('change', function () {
    const workType = document.getElementById('work_type').value;
    const subtype = this.value;
    const titleInput = document.getElementById('project_title');

    if (
        projectTitleSamples[workType] &&
        projectTitleSamples[workType][subtype]
    ) {
        titleInput.value = ''; // clear any typed value
        titleInput.placeholder = projectTitleSamples[workType][subtype];
    } else {
        titleInput.value = '';
        titleInput.placeholder =
            'e.g. 2BHK Residential Construction, Office Renovation';
    }
});
</script>

@endsection
