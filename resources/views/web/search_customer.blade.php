@extends('layouts.vendorapp')
@section('title', 'Search Vendors')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    window.VENDOR_ID = @json($vendor_id);
</script>

<style>
   /* ================= ROOT ================= */
   :root{
   --primary-blue:#2563eb;
   --primary-indigo:#4f46e5;
   --primary-orange:#f97316;
   --success-green:#10b981;
   --bg-gradient:linear-gradient(135deg,#f8fafc 0%,#eff6ff 50%,#f8fafc 100%);
   }
   *{box-sizing:border-box}
   body{
   font-family:'Inter',sans-serif;
   background:var(--bg-gradient);
   color:#1e293b;
   }
   /* ================= HEADER ================= */
   .header{
   background:rgba(255,255,255,.9);
   backdrop-filter:blur(20px);
   border-bottom:1px solid #e2e8f0;
   position:sticky;
   top:0;
   z-index:1000;
   }
   /* ================= BUTTONS ================= */
   .btn-gradient-primary{
   background:linear-gradient(135deg,var(--primary-blue),var(--primary-indigo));
   border:none;
   color:#fff;
   font-weight:600;
   border-radius:10px;
   }
   .btn-gradient-primary:hover{
   transform:scale(1.05);
   box-shadow:0 10px 25px rgba(37,99,235,.4);
   }
   /* ================= FILTER SIDEBAR ================= */
   .filter-sidebar{
   background:#fff;
   border-radius:24px;
   border:1px solid #e2e8f0;
   padding:24px;
   position:sticky;
   top:100px;
   }
   .filter-header{
   display:flex;
   gap:12px;
   border-bottom:1px solid #e2e8f0;
   padding-bottom:20px;
   margin-bottom:24px;
   }
   .filter-icon-box{
   width:40px;height:40px;
   background:linear-gradient(135deg,var(--primary-blue),var(--primary-indigo));
   border-radius:12px;
   display:flex;
   align-items:center;
   justify-content:center;
   color:#fff;
   }
   .filter-category-item{
   padding:12px;
   border-radius:12px;
   cursor:pointer;
   border:2px solid transparent;
   }
   .filter-category-item:hover{
   background:#f8fafc;
   border-color:#e2e8f0;
   }
   .filter-category-item.active{
   background:#eff6ff;
   border-color:#93c5fd;
   }
   /* ================= SEARCH ================= */
   .search-section{
   background:#fff;
   border-radius:24px;
   border:1px solid #e2e8f0;
   padding:24px;
   margin-bottom:24px;
   }
   .form-control-custom,
   .form-select-custom{
   padding:14px 20px;
   border:2px solid #e2e8f0;
   border-radius:12px;
   font-weight:500;
   }
   .form-control-custom:focus,
   .form-select-custom:focus{
   border-color:var(--primary-blue);
   box-shadow:0 0 0 4px rgba(37,99,235,.1);
   }
   /* ================= VENDOR CARD ================= */
   .vendor-card{
   background:#fff;
   border-radius:16px;
   border:1px solid #e2e8f0;
   padding:14px;
   margin-bottom:14px;
   position:relative;
   transition:.3s ease;
   }
   .vendor-card:hover{
   transform:translateY(-2px);
   box-shadow:0 20px 60px rgba(15,23,42,.15);
   }
   /* ================= TEXT ================= */
   .vendor-name{
   font-size:16px;
   font-weight:800;
   }
   /* ================= CONTACT ================= */
   .contact-info-section{
   background:#f8fafc;
   border-radius:12px;
   padding:10px;
   border:1px solid #e2e8f0;
   }
   /* ================= MODAL ================= */
   .modal-content{
   border-radius:24px;
   overflow:hidden;
   }
   /* ================= RESPONSIVE ================= */
   @media(max-width:991px){
   .filter-sidebar{position:relative;top:0}
   }
   /* ===== PREMIUM MODAL ===== */
   .premium-modal { border-radius: 24px; overflow: hidden; }
   .premium-header {
     background: linear-gradient(135deg, #2563eb, #4f46e5);
     color: #fff; padding: 24px 28px;
   }
   .locked-info { padding: 20px; border-radius: 18px; background: #f8fafc; border: 1px dashed #e2e8f0; }
   .lock-icon {
     width: 64px; height: 64px; border-radius: 50%;
     background: linear-gradient(135deg, #ef4444, #dc2626);
     display: flex; align-items: center; justify-content: center;
     color: #fff; font-size: 28px; margin: auto;
   }
   .payment-section-modern {
     background: linear-gradient(135deg, #10b981, #059669);
     color: #fff; border-radius: 20px; padding: 24px; margin-top: 20px;
   }
   .price-tag { font-size: 36px; font-weight: 800; }
   .benefits-list { list-style: none; padding: 0; margin: 15px 0 0; }
   .benefits-list li { display:flex; align-items:center; gap:10px; font-size:14px; margin-bottom:8px; }
   .benefits-list i { color:#d1fae5; }
   .pay-btn {
     background: #065f46; border:none; color:#fff; font-weight:700;
     padding:14px; border-radius:14px; transition:all .3s ease;
   }
   .pay-btn:hover { background:#064e3b; transform: translateY(-1px); }

   /* ===== AUTH MODAL ===== */
   .auth-modal { border-radius: 22px; overflow: hidden; }
   .auth-header {
     background: linear-gradient(135deg, #2563eb, #4f46e5);
     color:#fff; padding: 32px 24px 28px; text-align:center; position:relative;
   }
   .auth-icon {
     width:64px; height:64px; border-radius:16px;
     background: rgba(255,255,255,0.18);
     display:flex; align-items:center; justify-content:center;
     margin:0 auto 12px; font-size:28px;
   }
   .btn-auth-primary {
     background: linear-gradient(135deg, #2563eb, #4f46e5);
     border:none; color:#fff; font-weight:700; padding:14px; border-radius:14px;
     transition: all .3s ease;
   }
   .btn-auth-primary:hover { transform: translateY(-1px); box-shadow: 0 10px 25px rgba(37,99,235,0.4); }
   .btn-auth-outline {
     background:#fff; border:2px solid #e5e7eb; color:#1e293b; font-weight:600;
     padding:14px; border-radius:14px; transition: all .3s ease;
   }
   .btn-auth-outline:hover { background:#f8fafc; border-color:#c7d2fe; }
   .blur-text { filter: blur(6px); pointer-events:none; user-select:none; transition:all .3s ease; }
   .unblur { filter: blur(0); pointer-events:auto; }
   .blur-text::after { content:' 🔒'; filter: blur(0); }
   .text-indigo { color:#4f46e5 }
   .text-orange { color:#f97316 }
</style>

{{-- ================= MAIN CONTENT ================= --}}
<div class="container-fluid px-4 py-4">
  <div class="row g-4">

    {{-- ================= SIDEBAR ================= --}}
    <div class="col-lg-3">
      <div class="filter-sidebar">
        <div class="filter-header">
          <div class="filter-icon-box"><i class="bi bi-funnel-fill"></i></div>
          <div>
            <h5 class="mb-0 fw-bold">Smart Filters</h5>
            <small class="text-muted">Refine your search</small>
          </div>
        </div>

        <div class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-bold mb-0">Work Category</h6>
            <span class="badge bg-primary rounded-pill" id="categoryCount">0</span>
          </div>

          <div id="categoryFilters">
            @foreach($work_types as $work)
              <div class="mb-2">

                <label class="filter-category-item d-flex align-items-center gap-3">
                  <input type="checkbox" class="form-check-input m-0 category-check" value="{{ $work->id }}">
                  <div class="category-icon"><i class="bi {{ $work->icon }}"></i></div>
                  <span class="fw-semibold">{{ $work->work_type }}</span>
                </label>

                <div class="ms-5 mt-2 d-none subtype-box" data-type="{{ $work->id }}">
                  @foreach(DB::table('work_subtypes')->where('work_type_id',$work->id)->get() as $sub)
                    <label class="d-flex align-items-center gap-2 mb-1 small">
                      <input type="checkbox" class="form-check-input subtype-check" value="{{ $sub->id }}">
                      {{ $sub->work_subtype }}
                    </label>
                  @endforeach
                </div>

              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>

    {{-- ================= MAIN LIST ================= --}}
    <div class="col-lg-9">

      <div class="search-section mb-4">
        <div class="row g-3 align-items-end">

          <div class="col-lg-4 col-md-6">
            <label class="form-label fw-semibold small text-muted">
              <i class="bi bi-geo-alt-fill me-1 text-primary"></i> State
            </label>
            <select id="stateSelect" class="form-select form-select-custom">
              <option value="">Select State</option>
              @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="col-lg-4 col-md-6">
            <label class="form-label fw-semibold small text-muted">
              <i class="bi bi-map-fill me-1 text-indigo"></i> Region / Zone
            </label>
            <select id="regionSelect" class="form-select form-select-custom" disabled>
              <option value="">Select Region</option>
            </select>
          </div>

          <div class="col-lg-4 col-md-12">
            <label class="form-label fw-semibold small text-muted">
              <i class="bi bi-buildings-fill me-1 text-orange"></i> City
            </label>
            <select id="citySelect" class="form-select form-select-custom" disabled>
              <option value="">Select City</option>
            </select>
          </div>

        </div>
      </div>

      <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h3 class="fw-bold mb-1"><span id="vendorCount">{{ $projects->count() }}</span> Professional Lead</h3>
            <p class="text-muted mb-0 d-flex align-items-center gap-2">
              <span class="badge bg-success rounded-circle p-1" style="width:10px;height:10px;"></span>
              Verified and ready to serve
            </p>
          </div>
        </div>
      </div>

      {{-- RESULTS --}}
      @foreach($projects as $project)
        <div class="vendor-card shadow-sm p-4 mb-4 rounded"
             data-work-type-id="{{ $project->work_type_id }}"
             data-work-subtype-id="{{ $project->work_subtype_id }}"
             data-work-subtype="{{ strtolower($project->work_subtype) }}"
             data-name="{{ strtolower($project->title) }}"
             data-state="{{ strtolower($project->statename ?? '') }}"
            data-region="{{ strtolower($project->regionname ?? '') }}"
            data-city="{{ strtolower($project->cityname ?? '') }}"
             data-project-id="{{ $project->id }}">
             

          <div class="d-flex justify-content-between align-items-start mb-2">
            <div>
              <span class="text-muted small">Type of Work</span>
              <h5 class="fw-bold text-dark mb-0">{{ strtoupper($project->title) }}</h5>
            </div>
            <span class="badge bg-primary-subtle text-primary px-3 py-2">
              {{ $project->work_type }} - {{ $project->work_subtype }}
            </span>
          </div>

          <div class="mb-2">
            <span class="text-muted small">Contact Person</span>
            <h6 class="vendor-name blur-text mb-0">{{ strtoupper($project->contact_name) }}</h6>
          </div>

          <div class="text-muted small d-flex align-items-center gap-2 mb-3">
            <i class="bi bi-geo-alt-fill text-primary"></i>
             {{ $project->statename ?? '' }},
            {{ $project->regionname ?? '' }},
           
            {{ $project->cityname ?? '' }},
          </div>
           <div class="mb-2">
          
           <h6 class="vendor-name mb-0">
              Project Post Date:
                {{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}
            </h6>

          </div>

          <div class="row align-items-center border-top pt-3">
            <div class="col-md-7">
              <!-- <div class="contact-info-section small">

                <div class="mb-1">
                  <i class="bi bi-telephone-fill text-primary me-2"></i>
                  <strong>Mobile:</strong>
                  @php
                    $mobile = preg_replace('/\D/', '', $project->mobile);
                    $maskedMobile = $mobile ? substr($mobile,0,2).str_repeat('x', max(strlen($mobile)-2,0)) : 'xxxxxxxxxxxx';
                  @endphp
                  {{ $maskedMobile }}
                </div>

                <div>
                  <i class="bi bi-envelope-fill text-primary me-2" ></i>
                  <strong>Email:</strong>
                  @php
                    $email = $project->email;
                    if (!empty($email) && str_contains($email,'@')) {
                      [$name,$domain] = explode('@',$email,2);
                      $maskedEmail = substr($name,0,2).str_repeat('*', max(strlen($name)-2,0)).'@'.$domain;
                    } else { $maskedEmail = 'xxxx@xxxx.com'; }
                  @endphp
                  {{ $maskedEmail }}
                </div>

              </div> -->
              <div class="contact-info-section small">

    {{-- Mobile (XXXX format, NO blur) --}}
    <div class="mb-1">
        <i class="bi bi-telephone-fill text-primary me-2"></i>
        <strong>Mobile:</strong>

        @php
            $mobile = preg_replace('/\D/', '', $project->mobile);
            $maskedMobile = $mobile
                ? substr($mobile, 0, 2) . str_repeat('x', max(strlen($mobile) - 2, 0))
                : 'xxxxxxxxxx';
        @endphp

        <span>{{ $maskedMobile }}</span>
    </div>

    {{-- Email (BLUR only) --}}
    <div>
        <i class="bi bi-envelope-fill text-primary me-2"></i>
        <strong>Email:</strong>

        @php
            $email = $project->email;
            if (!empty($email) && str_contains($email, '@')) {
                [$name, $domain] = explode('@', $email, 2);
                $maskedEmail = substr($name, 0, 2)
                    . str_repeat('*', max(strlen($name) - 2, 0))
                    . '@' . $domain;
            } else {
                $maskedEmail = 'xxxx@xxxx.com';
            }
        @endphp

        <span class="blur-text">{{ $maskedEmail }}</span>
    </div>

</div>

            </div>

            {{-- CTA (onclick version) --}}
            <div class="col-md-5 text-end mt-3 mt-md-0">
             
              <button class="btn btn-primary px-4 py-2"
                onclick="handleInterested(
                    {{ $project->id }},
                    '{{ addslashes($project->username) }}',
                    '{{ addslashes($project->usersmobile) }}',
                    '{{ addslashes($project->useremail) }}',
                    '{{ addslashes($project->contact_name) }}',
                    '{{ addslashes($project->title) }}',
                    '{{ addslashes($project->work_subtype) }}',
                    '{{ addslashes($project->statename . ', ' . $project->regionname . ', ' . $project->cityname) }}',
                    '{{ addslashes($project->budget_range_name ?? 'Flexible') }}',
                    '{{ addslashes($project->description) }}',
                    '{{ addslashes($project->contact_time) }}'
                )">
                ❤️ I'm Interested
                </button>

            </div>

          </div>
        </div>
      @endforeach

    </div>
  </div>
</div>

{{-- ================= CUSTOMER / PAYMENT MODAL ================= --}}
<div class="modal fade" id="vendorModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content premium-modal">

      <div class="modal-header premium-header">
        <div>
          <h5 class="fw-bold mb-0">Customer Lead Details</h5>
          <small class="text-white-50">Protected information</small>
        </div>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4">

        <div id="remainingLeadsInfo" class="alert alert-success text-center fw-semibold d-none mb-4"></div>

        {{-- Locked info (we will hide when details allowed) --}}
        <div class="locked-info text-center mb-4" id="lockedInfo">
          <div class="lock-icon mb-2">
            <i class="bi bi-lock-fill"></i>
          </div>
          <h4 class="fw-bold mt-2">Contact Locked</h4>
          <p class="text-muted mb-1">Upgrade to unlock full details</p>
          <p class="small text-muted">Name, phone & email will be visible after payment</p>
        </div>

        {{-- ✅ PROJECT DETAILS (ONLY ONE BLOCK, no duplicate) --}}
        <div class="project-details-card border rounded p-3 mb-4" id="projectDetailsSection">
          <h6 class="fw-bold mb-3">Project Details</h6>

          <div class="row g-3 small">
             <div class="col-md-6">
              <span class="text-muted">User Name</span>
              <div class="fw-semibold" id="modalusername">—</div>
            </div>
            <div class="col-md-6">
              <span class="text-muted">User Mobile</span>
              <div class="fw-semibold" id="modalusersmobile">—</div>
            </div>
            <div class="col-md-6">
              <span class="text-muted">User Email</span>
              <div class="fw-semibold" id="modaluseremail">—</div>
            </div>
            

            <div class="col-md-6">
              <span class="text-muted">Project Title</span>
              <div class="fw-semibold" id="modalTitle">—</div>
            </div>
            <div class="col-md-6">
              <span class="text-muted">Work Category</span>
              <div class="fw-semibold" id="modalWork">—</div>
            </div>
            <div class="col-md-6">
              <span class="text-muted">Location</span>
              <div class="fw-semibold" id="modalLocation">—</div>
            </div>
            <div class="col-md-6">
              <span class="text-muted">Budget</span>
              <div class="fw-semibold" id="modalBudget">—</div>
            </div>
            <div class="col-12">
              <span class="text-muted">Project Description</span>
              <div class="fw-semibold" id="modalDescription">—</div>
            </div>
            <div class="col-md-6">
              <span class="text-muted">Preferred Contact Time</span>
              <div class="fw-semibold" id="modalContactTime">—</div>
            </div>
            <div class="col-md-6">
              <span class="text-muted">Posted On</span>
              <div class="fw-semibold" id="modalPosted">—</div>
            </div>
          </div>
        </div>

        {{-- PAYMENT SECTION --}}
        <div class="payment-section-modern d-none" id="paymentSection">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h3 class="price-tag mb-0">₹499</h3>
              <small class="text-white-50">One-time access fee</small>
            </div>
            <span class="badge bg-light text-success fw-bold px-3 py-2">Verified Lead</span>
          </div>

          <ul class="benefits-list small">
            <li><i class="bi bi-check-circle-fill me-2"></i> Full customer contact details</li>
            <li><i class="bi bi-check-circle-fill me-2"></i> Genuine project requirement</li>
            <li><i class="bi bi-check-circle-fill me-2"></i> No commission</li>
          </ul>

          <button class="btn pay-btn w-100 mt-3" id="payNowBtn">
            <i class="bi bi-credit-card me-2"></i> Pay & Unlock
          </button>
        </div>

      </div>
    </div>
  </div>
</div>

{{-- ================= AUTH MODAL ================= --}}
<div class="modal fade" id="authModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content auth-modal">

      <div class="auth-header">
        <div class="auth-icon"><i class="bi bi-shield-lock-fill"></i></div>
        <h5 class="fw-bold mb-1">Login Required</h5>
        <p class="mb-0 small opacity-75">Please sign in to continue</p>
        <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center p-4">
        <p class="text-muted mb-4">
          To view customer contact details and unlock premium leads, please log in to your vendor account.
        </p>

        <a href="{{ route('login_register') }}" class="btn btn-auth-primary w-100 mb-3">
          <i class="bi bi-box-arrow-in-right me-2"></i> Login to Continue
        </a>

        <a href="{{ route('login_register') }}" class="btn btn-auth-outline w-100">
          <i class="bi bi-person-plus me-2"></i> Create Free Account
        </a>
      </div>

    </div>
  </div>
</div>

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function resetLeadModalUI() {
    $('#paymentSection').addClass('d-none');
    $('#remainingLeadsInfo').addClass('d-none').text('');
    $('#projectDetailsSection').removeClass('d-none');
    $('#lockedInfo').removeClass('d-none');
}

function handleInterested(
    id,
    username ,
    usersmobile,
    useremail ,
    contactName,
    title,
    work,
    location,
    budget,
    description,
    contactTime
) {

    // 🔐 AUTH CHECK
    if (!window.VENDOR_ID) {
        new bootstrap.Modal(document.getElementById('authModal')).show();
        return;
    }

    resetLeadModalUI();

    // Fill modal content
    $('#modalTitle').text(title || '—');
    $('#modalusername').text(username || '—');
    $('#modalusersmobile').text(usersmobile || '—');
    $('#modaluseremail').text(useremail || '—');
    $('#modalTitle').text(title || '—');
    $('#modalWork').text(work || '—');
    $('#modalLocation').text(location || '—');
    $('#modalBudget').text(budget || 'Flexible');
    $('#modalDescription').text(description || '—');
    $('#modalContactTime').text(contactTime || 'Anytime');
    $('#modalPosted').text('Just now');

    // AJAX check
    $.ajax({
        url: "{{ route('vendor.interest.check') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            cust_id: id
        },
       
        success: function (res) {

    resetLeadModalUI();

    /* ===============================
       1️⃣ ALREADY UNLOCKED → SHOW DETAILS
    ================================ */
    if (res.already_exists === true) {

        $('#lockedInfo').addClass('d-none');
        $('#paymentSection').addClass('d-none');

        $('#projectDetailsSection').removeClass('d-none');
        $('#remainingLeadsInfo').addClass('d-none');

        new bootstrap.Modal(
            document.getElementById('vendorModal')
        ).show();

        return; // ⛔ VERY IMPORTANT
    }

    let remaining = parseInt(res.remaining, 10) || 0;

    /* ===============================
       2️⃣ NO FREE LEADS → PAYMENT
    ================================ */
    if (res.payment_required === true || remaining <= 0) {

        $('#projectDetailsSection').addClass('d-none');
        $('#remainingLeadsInfo').addClass('d-none');

        $('#lockedInfo').removeClass('d-none');
        $('#paymentSection').removeClass('d-none');

        $('#payNowBtn').data('id', id);

        new bootstrap.Modal(
            document.getElementById('vendorModal')
        ).show();

        return;
    }

    /* ===============================
       3️⃣ FREE LEAD → SHOW DETAILS
    ================================ */
    $('#lockedInfo').addClass('d-none');
    $('#paymentSection').addClass('d-none');

    $('#projectDetailsSection').removeClass('d-none');

    $('#remainingLeadsInfo')
        .removeClass('d-none')
        .text(`🎯 ${remaining} free leads remaining`);

    new bootstrap.Modal(
        document.getElementById('vendorModal')
    ).show();
},

        error: function () {
            alert('Something went wrong. Please try again.');
        }
    });
}
</script>

<script>

$('#payNowBtn').on('click', function () {

    let custId = $(this).data('id');

    $.post("{{ route('razorpay.createOrder') }}", {
        _token: "{{ csrf_token() }}",
        cust_id: custId
    }, function (res) {

        if (!res.success) {
            alert('Order creation failed');
            return;
        }

        let options = {
            key: res.key,
            amount: res.amount, // ₹1 * 100
            currency: "INR",
            name: "ConstructKaro",
            description: "₹1 Lead Unlock",
            order_id: res.order_id,

            handler: function (response) {

                $.post("{{ route('razorpay.verify') }}", {
                    _token: "{{ csrf_token() }}",
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature,
                    cust_id: btoa(custId)
                }, function (verifyRes) {

                    if (verifyRes.success) {
                        bootstrap.Modal.getInstance(
                            document.getElementById('vendorModal')
                        ).hide();

                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful',
                            text: '₹1 payment completed. Lead unlocked!',
                            confirmButtonColor: '#10b981'
                        }).then(() => location.reload());
                    } else {
                        alert('Verification failed');
                    }
                });
            },

            theme: { color: "#2563eb" }
        };

        new Razorpay(options).open();
    });
});

</script>
<script>

function applyFilters() {

    let selectedCategories = [];
    let selectedSubtypes   = [];

    document.querySelectorAll('.category-check:checked')
        .forEach(cb => selectedCategories.push(cb.value));

    document.querySelectorAll('.subtype-check:checked')
        .forEach(cb => selectedSubtypes.push(cb.value));

    // 🔑 IMPORTANT: use TEXT, not ID
    let stateText  = (document.querySelector('#stateSelect option:checked')?.textContent || '').toLowerCase().trim();
    let regionText = (document.querySelector('#regionSelect option:checked')?.textContent || '').toLowerCase().trim();
    let cityText   = (document.querySelector('#citySelect option:checked')?.textContent || '').toLowerCase().trim();

    if (stateText === 'select state') stateText = '';
    if (regionText === 'select region') regionText = '';
    if (cityText === 'select city') cityText = '';

    let visible = 0;

    document.querySelectorAll('.vendor-card').forEach(card => {

        let cardTypeId    = card.dataset.workTypeId || '';
        let cardSubtypeId = card.dataset.workSubtypeId || '';

        let cardState  = (card.dataset.state  || '').toLowerCase();
        let cardRegion = (card.dataset.region || '').toLowerCase();
        let cardCity   = (card.dataset.city   || '').toLowerCase();

        /* ---------- CATEGORY MATCH ---------- */
        let categoryMatch = true;

        if (selectedCategories.length > 0) {
            categoryMatch = selectedCategories.includes(cardTypeId);
        }

        if (selectedSubtypes.length > 0) {
            categoryMatch = selectedSubtypes.includes(cardSubtypeId);
        }

        /* ---------- LOCATION MATCH ---------- */
        let stateMatch  = !stateText  || cardState.includes(stateText);
        let regionMatch = !regionText || cardRegion.includes(regionText);
        let cityMatch   = !cityText   || cardCity.includes(cityText);

        if (categoryMatch && stateMatch && regionMatch && cityMatch) {
            card.style.display = 'block';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('vendorCount').innerText = visible;
}

/* ================= EVENTS ================= */

// Category toggle + subtype show/hide
document.querySelectorAll('.category-check').forEach(cb => {
    cb.addEventListener('change', function () {
        let box = document.querySelector(`.subtype-box[data-type="${this.value}"]`);
        if (box) box.classList.toggle('d-none', !this.checked);
        applyFilters();
    });
});

// Subtype
document.querySelectorAll('.subtype-check')
    .forEach(cb => cb.addEventListener('change', applyFilters));

// Location dropdowns
document.getElementById('stateSelect')?.addEventListener('change', applyFilters);
document.getElementById('regionSelect')?.addEventListener('change', applyFilters);
document.getElementById('citySelect')?.addEventListener('change', applyFilters);

// Run once on load
document.addEventListener('DOMContentLoaded', applyFilters);
</script>


@endsection
