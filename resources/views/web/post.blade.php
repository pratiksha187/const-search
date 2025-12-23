@extends('layouts.custapp')

@section('title', 'Add Post')

@section('content')

<style>
:root {
    --navy: #1c2c3e;
    --orange: #f25c05;
    --border: #e3e7ef;
}

/* PAGE BG */
.page-bg {
    padding: 24px 0 80px;
}

/* WRAPPER (ONLY ONE) */
/* .page-wrapper {
    max-width: 1200px;
    margin: auto;
} */
.page-wrapper {
    max-width: 1650px;
    margin: auto;
}
/* MAIN CARD */
.full-form-card {
    background: #ffffff;
    padding: 48px;
    border-radius: 26px;
    box-shadow: 0 25px 60px rgba(0,0,0,0.08);
    border: 1px solid var(--border);
}

/* CARD TITLE */
.card-title {
    font-size: 30px;
    font-weight: 800;
    color: var(--navy);
}

.card-subtitle {
    font-size: 15px;
    color: #6b7280;
    margin-bottom: 30px;
}

/* SECTION TITLE */
.section-title {
    font-size: 18px;
    font-weight: 700;
    color: var(--navy);
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 25px;
}
.section-title::before {
    content: "";
    width: 4px;
    height: 22px;
    background: var(--orange);
    border-radius: 10px;
}

/* LABEL */
.form-label-custom {
    font-weight: 600;
    margin-bottom: 6px;
    color: var(--navy);
}

/* INPUTS */
.form-control-lg,
.form-select-lg,
textarea.form-control-lg {
    background: #fbfcff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 14px 16px;
    font-size: 15px;
    transition: all 0.25s ease;
}
.form-control-lg:focus,
.form-select-lg:focus {
    border-color: var(--orange);
    box-shadow: 0 8px 20px rgba(242,92,5,0.15);
}

/* ICON GROUP */
.input-group-text {
    background: #f1f4fa;
    border: 1px solid var(--border);
    color: #8a94a6;
    border-radius: 14px 0 0 14px !important;
}

/* UPLOAD */
.upload-box {
    border: 2px dashed #cfd6e4;
    border-radius: 18px;
    padding: 26px;
    background: #fafcff;
    text-align: center;
    transition: 0.25s;
}
.upload-box:hover {
    border-color: var(--orange);
    background: #fff4eb;
}
.upload-box small {
    display: block;
    margin-top: 8px;
    font-size: 13px;
    color: #6b7280;
}

/* SUBMIT */
.submit-btn {
    background: linear-gradient(135deg, #ff9a3c, #f25c05);
    padding: 16px 54px;
    border-radius: 18px;
    font-size: 17px;
    font-weight: 800;
    color: #fff;
    border: none;
    box-shadow: 0 18px 40px rgba(242,92,5,0.35);
    transition: 0.25s;
}
.submit-btn:hover {
    transform: translateY(-2px);
}

/* MOBILE */
@media(max-width: 768px){
    .full-form-card {
        padding: 28px;
    }
    .card-title {
        font-size: 24px;
    }
}

.dashboard-content {
    margin-top: 77px;
    padding: 0px;
}
</style>

<div class="page-bg">
<div class="page-wrapper">

    <div class="full-form-card">

        <!-- TITLE -->
        <div class="mb-4">
            <div class="card-title">Create New Project</div>
            <div class="card-subtitle">
                Submit your project details to connect with verified vendors
            </div>
        </div>

        <div class="section-title">Project Information</div>

        <form action="{{ route('save.post') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            <!-- TITLE -->
            <div class="col-md-4">
                <label class="form-label-custom">Project Title</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                    <input type="text" class="form-control form-control-lg" name="title">
                </div>
            </div>

            
             <!-- Vendor -->
        
            <div class="col-md-4">
                <label class="form-label-custom">Vendor Type</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                    <select class="form-select form-select-lg" id="work_type" name="work_type_id">
                        <option value="">Select Vendor Type</option>
                        @foreach($work_types as $worktype)
                            <option value="{{ $worktype->id }}">{{ $worktype->work_type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- TYPE -->
          
            <div class="col-md-4">
                <label class="form-label-custom">Project Type</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-diagram-3"></i></span>
                    <select class="form-select form-select-lg" id="project_type" name="project_type_id">
                        <option value="">Select Project Type</option>
                    </select>
                </div>
            </div>


            <!-- STATE -->
            <div class="col-md-4">
                <label class="form-label-custom">State</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-geo"></i></span>
                    <select class="form-select form-select-lg" id="stateDropdown" name="state">
                        <option value="">Select State</option>
                      
                    </select>
                </div>
            </div>

            <!-- REGION -->
            <div class="col-md-4">
                <label class="form-label-custom">Region</label>
                <select class="form-select form-select-lg" id="regionDropdown" name="region"></select>
            </div>

            <!-- CITY -->
            <div class="col-md-4">
                <label class="form-label-custom">City</label>
                 <input type="text" class="form-control form-control-lg" name="city">
                
            </div>

            <!-- BUDGET -->
            <div class="col-md-4">
                <label class="form-label-custom">Approx Budget (₹)</label>
                <select class="form-select form-select-lg" name="budget">
                    <option value="">Select Budget</option>
                    @foreach($budget_range as $range)
                        <option value="{{ $range->id }}">{{ $range->budget_range }}</option>
                    @endforeach
                </select>
            </div>

            <!-- CONTACT -->
            <div class="col-md-4">
                <label class="form-label-custom">Contact Name</label>
                <input type="text" class="form-control form-control-lg" name="contact_name">
            </div>

            <div class="col-md-4">
                <label class="form-label-custom">Mobile</label>
                <input type="text" class="form-control form-control-lg" name="mobile">
            </div>

            <div class="col-md-4">
                <label class="form-label-custom">Email</label>
                <input type="email" class="form-control form-control-lg" name="email">
            </div>

            <!-- UPLOAD -->
            <div class="col-md-6">
                <label class="form-label-custom">Upload Drawings / BOQ</label>
                <div class="upload-box">
                    <input type="file" class="form-control form-control-lg" name="files[]" multiple>
                    <small>PDF / JPG / PNG / Excel • Secure upload</small>
                </div>
            </div>

            <!-- DESCRIPTION -->
            <div class="col-12">
                <label class="form-label-custom">Project Description</label>
                <textarea class="form-control form-control-lg" rows="4" name="description"></textarea>
            </div>

        </div>

        <div class="text-end mt-4">
            <button class="submit-btn">Submit Project</button>
            <div class="text-muted mt-2" style="font-size:13px;">
                🔒 Your details are shared only with verified vendors
            </div>
        </div>

        </form>

    </div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$("#stateDropdown").change(function () {
    let id = $(this).val();
    $("#regionDropdown").html('<option>Loading...</option>');
    $("#cityDropdown").html('');

    $.get("/get-regions/" + id, function (data) {
        $("#regionDropdown").html('<option value="">Select Region</option>');
        data.forEach(item => {
            $("#regionDropdown").append(`<option value="${item.id}">${item.name}</option>`);
        });
    });
});

$("#regionDropdown").change(function () {
    let id = $(this).val();
    $("#cityDropdown").html('<option>Loading...</option>');

    $.get("/get-cities/" + id, function (data) {
        $("#cityDropdown").html('<option value="">Select City</option>');
        data.forEach(item => {
            $("#cityDropdown").append(`<option value="${item.id}">${item.name}</option>`);
        });
    });
});
</script>
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
    let projectTypeSelect = $('#project_type');

    projectTypeSelect.html('<option>Loading...</option>');

    if (workTypeId) {
        $.ajax({
            url: '/get-project-types/' + workTypeId,
            type: 'GET',
            success: function (data) {
                projectTypeSelect.html('<option value="">Select Project Type</option>');
                data.forEach(item => {
                    projectTypeSelect.append(
                        `<option value="${item.id}">${item.work_subtype}</option>`
                    );
                });
            },
            error: function () {
                projectTypeSelect.html('<option>Error loading project types</option>');
            }
        });
    } else {
        projectTypeSelect.html('<option value="">Select Project Type</option>');
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
@endsection
