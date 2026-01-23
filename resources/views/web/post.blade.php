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

.paywall-card{
    border-radius:18px;
    box-shadow:0 25px 60px rgba(0,0,0,0.25);
    font-family: Inter, system-ui, sans-serif;
}

.limit-box{
    background:#f8fafc;
    border-radius:12px;
    padding:12px 14px;
    font-size:15px;
    color:#374151;
}

.price-box{
    background:linear-gradient(135deg,#fff7ed,#fff);
    border-radius:16px;
    padding:18px;
}

.price{
    font-size:38px;
    font-weight:800;
    color:#f25c05;
    line-height:1;
}

.gst{
    font-size:14px;
    color:#6b7280;
    margin-top:4px;
}

.per{
    font-size:13px;
    color:#6b7280;
    margin-top:2px;
}

.pay-btn{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    border:none;
    font-weight:600;
    padding:14px;
}

.pay-btn:hover{
    opacity:0.95;
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
                    
                    <input type="hidden" id="customer_id"  name="customer_id"  value="{{$customer_id}}">

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
                            <select class="form-select form-select-lg" id="work_subtype" name="work_subtype_id">
                                <option value="">Select Project Type</option>
                            </select>
                        </div>
                    </div>

                    <!-- TITLE -->
                    <div class="col-md-4">
                        <label class="form-label-custom">Project Title</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-pencil"></i></span>
                            <input type="text" class="form-control form-control-lg" name="title"   id="project_title" placeholder="e.g. 2BHK Residential Construction, Office Renovation">
                        </div>
                    </div>
                    <!-- STATE -->
                    <div class="col-md-4">
                        <label class="form-label-custom">State</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-geo"></i></span>
                            <select class="form-select form-select-lg" id="stateSelect"  name="state">
                            
                                <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                                    @endforeach
                            </select>

                            
                        </div>
                    </div>

                
                    <!-- REGION -->
                    <div class="col-md-4">
                        <label class="form-label-custom">Region</label>
                        <select id="regionSelect"
                                name="region_id"
                                class="form-select form-select-lg"
                                disabled>
                            <option value="">Select Region</option>
                        </select>
                    </div>

                    <!-- CITY -->
                    <div class="col-md-4">
                        <label class="form-label-custom">City</label>
                        <select id="citySelect"
                                name="city_id"
                                class="form-select form-select-lg"
                                disabled>
                            <option value="">Select City</option>
                        </select>
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
                        <input type="text" class="form-control form-control-lg" name="contact_name" placeholder="e.g. Aniket Patil">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-custom">Mobile</label>
                        <input type="text" class="form-control form-control-lg" name="mobile" placeholder="e.g. 9876543210">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-custom">Email</label>
                        <input type="email" class="form-control form-control-lg" name="email" placeholder="e.g. Aniket@example.com">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-custom">Area</label>
                        <input type="text" class="form-control form-control-lg" name="area" placeholder="e.g. Plot: 2000 sq.ft / Built-up: 1500 sq.ft">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label-custom">Unit</label>
                        <select class="form-select form-select-lg" name="budget">
                            <option value="">Select Unit</option>
                            @foreach($unit as $units)
                                <option value="{{ $units->id }}">{{ $units->unitname }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- UPLOAD -->
                    <div class="col-md-4">
                        <label class="form-label-custom">Upload Drawings / BOQ</label>
                        <div class="upload-box">
                            <input type="file" class="form-control form-control-lg" name="files[]" multiple>
                            <small>PDF / JPG / PNG / Excel • Secure upload</small>
                        </div>
                    </div>

                    <!-- DESCRIPTION -->
                    <div class="col-12">
                        <label class="form-label-custom">Project Description</label>
                        <textarea
                            class="form-control form-control-lg"
                            rows="4"
                            name="description"
                            placeholder="Example: Construction of a 2BHK residential house on a 1500 sq.ft plot in Pune. Work includes civil, plumbing, electrical & finishing. Expected start in 1 month."></textarea>
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


<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true" style="--bs-modal-width: 420px;">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content paywall-card border-0">

      <!-- HEADER -->
      <div class="modal-header border-0 pb-0">
        <div class="w-100 text-center position-relative">
          <h5 class="modal-title fw-bold text-dark mb-1">
            🔒 Upgrade Required
          </h5>
          <p class="text-muted mb-0 fs-6">
            Unlock more project posts
          </p>
          <button type="button" class="btn-close position-absolute end-0 top-0"
                  data-bs-dismiss="modal"></button>
        </div>
      </div>

      <!-- BODY -->
      <div class="modal-body text-center px-4 pt-3 pb-2">

        <div class="limit-box mb-4">
          You’ve reached your free limit of  
          <strong>3 project posts</strong>
        </div>

        <div class="price-box mb-4">
          <div class="price">₹4,999</div>
          <div class="gst">+ GST</div>
          <div class="per">per project post</div>
        </div>

        <button
            id="payProjectSubscription"
            class="btn pay-btn btn-lg w-100 rounded-pill">
            🚀 Proceed to Pay
        </button>

      </div>

      <!-- FOOTER -->
      <div class="modal-footer border-0 justify-content-center pt-0">
        <small class="text-muted">
          🔐 Secure & encrypted payment
        </small>
      </div>

    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
const CUSTOMER_ID = {{ $customer_id ?? 'null' }}; // ✅ SAFE

$(document).on('click', '#payProjectSubscription', function () {

    if (!CUSTOMER_ID) {
        Swal.fire('Session Expired', 'Please login again', 'warning');
        return;
    }

    console.log('custId:', CUSTOMER_ID); // ✅ will show number

    const totalAmount = 1; // test (change to 4999 for live)
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
$(document).ready(function () {

    $('form').on('submit', function (e) {
        e.preventDefault(); // prevent normal submit

        let form = this;
        let formData = new FormData(form);

        $.ajax({
            url: $(form).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {

                if (res.status === 'payment_required') {
                    // Show payment modal
                    new bootstrap.Modal(
                        document.getElementById('paymentModal')
                    ).show();
                }

                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = "{{ route('myposts') }}";
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

    // Handle payment action
    $('#payNowBtn').on('click', function () {
        // Redirect to payment page
        // window.location.href = "";
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

/* ================= AUTO FILL TITLE ================= */
document.getElementById('work_subtype').addEventListener('change', function () {
    const workType = document.getElementById('work_type').value;
    const subtype = this.value;

    if (
        projectTitleSamples[workType] &&
        projectTitleSamples[workType][subtype]
    ) {
        document.getElementById('project_title').value =
            projectTitleSamples[workType][subtype];
    } else {
        document.getElementById('project_title').value = '';
    }
});
</script>


@endsection
