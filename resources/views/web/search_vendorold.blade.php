@extends('layouts.custapp')
@section('title', 'Search Vendors')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<meta name="csrf-token" content="{{ csrf_token() }}">

<script>
    window.CUSTOMERID = @json($customer_id);
</script>

{{-- ================= YOUR EXISTING STYLES (UNCHANGED) ================= --}}

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
  
   /* ================= AVATAR ================= */
   .vendor-avatar{
   width:64px;height:64px;
   border-radius:12px;
   background:linear-gradient(135deg,var(--primary-blue),var(--primary-indigo));
   display:flex;
   align-items:center;
   justify-content:center;
   color:#fff;
   font-size:24px;
   font-weight:800;
   position:relative;
   }
  
 
   /* ================= TEXT ================= */
   .vendor-name{
   font-size:16px;
   font-weight:800;
   }
   .category-badge{
   background:#fed7aa;
   color:#c2410c;
   padding:4px 10px;
   border-radius:20px;
   font-size:11px;
   font-weight:700;
   }
   /* ================= CONTACT ================= */
   .contact-info-section{
   background:#f8fafc;
   border-radius:12px;
   padding:10px;
   border:1px solid #e2e8f0;
   }
  
 
   /* ================= ACTION BUTTONS ================= */
   .btn-interested{
   background:linear-gradient(135deg,#f97316,#ea580c);
   border:none;
   color:#fff;
   padding:12px 24px;
   border-radius:12px;
   font-weight:700;
   }
  
   /* ================= MODAL ================= */
   .modal-content{
   border-radius:24px;
   overflow:hidden;
   }
 
   .payment-section{
   background:linear-gradient(135deg,var(--success-green),#059669);
   border-radius:16px;
   padding:24px;
   color:#fff;
   }
   .price-tag{
   font-size:40px;
   font-weight:800;
   }

   /* ================= RESPONSIVE ================= */
   @media(max-width:991px){
   .filter-sidebar{position:relative;top:0}
   }
   @media(max-width:768px){
   .vendor-avatar{width:80px;height:80px}
   }


   /* ===== PREMIUM MODAL ===== */
.premium-modal {
    border-radius: 24px;
    overflow: hidden;
}

.premium-header {
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    color: #fff;
    padding: 24px 28px;
}

/* LOCKED SECTION */
.locked-info {
    padding: 20px;
    border-radius: 18px;
    background: #f8fafc;
    border: 1px dashed #e2e8f0;
}

.lock-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #ef4444, #dc2626);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 28px;
    margin: auto;
}

/* PAYMENT BOX */
.payment-section-modern {
    background: linear-gradient(135deg, #10b981, #059669);
    color: #fff;
    border-radius: 20px;
    padding: 24px;
    margin-top: 20px;
}

.price-tag {
    font-size: 36px;
    font-weight: 800;
}

.benefits-list {
    list-style: none;
    padding: 0;
    margin: 15px 0 0;
}

.benefits-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 14px;
    margin-bottom: 8px;
}

.benefits-list i {
    color: #d1fae5;
}

/* PAY BUTTON */
.pay-btn {
    background: #065f46;
    border: none;
    color: #fff;
    font-weight: 700;
    padding: 14px;
    border-radius: 14px;
    transition: all 0.3s ease;
}

.pay-btn:hover {
    background: #064e3b;
    transform: translateY(-1px);
}

/* ===== AUTH MODAL ===== */
.auth-modal {
    border-radius: 22px;
    overflow: hidden;
}

/* HEADER */
.auth-header {
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    color: #fff;
    padding: 32px 24px 28px;
    text-align: center;
    position: relative;
}

.auth-icon {
    width: 64px;
    height: 64px;
    border-radius: 16px;
    background: rgba(255,255,255,0.18);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    font-size: 28px;
}

/* BUTTONS */
.btn-auth-primary {
    background: linear-gradient(135deg, #2563eb, #4f46e5);
    border: none;
    color: #fff;
    font-weight: 700;
    padding: 14px;
    border-radius: 14px;
    transition: all .3s ease;
}
/* ===== BLUR SENSITIVE INFO ===== */
.blur-text {
    filter: blur(6px);
    pointer-events: none;
    user-select: none;
    transition: all 0.3s ease;
}

/* Unblur when allowed */
.unblur {
    filter: blur(0);
    pointer-events: auto;
}

/* Optional: lock hint */
.blur-text::after {
    content: ' 🔒';
    filter: blur(0);
}

.btn-auth-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 10px 25px rgba(37,99,235,0.4);
}

.btn-auth-outline {
    background: #fff;
    border: 2px solid #e5e7eb;
    color: #1e293b;
    font-weight: 600;
    padding: 14px;
    border-radius: 14px;
    transition: all .3s ease;
}

.btn-auth-outline:hover {
    background: #f8fafc;
    border-color: #c7d2fe;
}
/* ================= LOCATION FILTER UPGRADE ================= */
.search-section {
    background: linear-gradient(135deg,#ffffff,#f8fafc);
    border-radius: 22px;
    border: 1px solid #e5e7eb;
    padding: 22px;
    box-shadow: 0 10px 40px rgba(15,23,42,.08);
}

.form-select-custom {
    height: 54px;
    font-weight: 600;
    border-radius: 14px;
    background-color: #fff;
    transition: all .25s ease;
}

.form-select-custom:hover {
    border-color: #93c5fd;
}

.form-select-custom:disabled {
    background: #f1f5f9;
    cursor: not-allowed;
}

/* Icon colors */
.text-indigo { color:#4f46e5 }
.text-orange { color:#f97316 }


</style>

{{-- ================= MAIN CONTENT ================= --}}
<div class="container-fluid px-4 py-4">
    <div class="row g-4">

        {{-- ================= SIDEBAR (UNCHANGED) ================= --}}
        <div class="col-lg-3">
         <div class="filter-sidebar">
            <div class="filter-header">
               <div class="filter-icon-box">
                  <i class="bi bi-funnel-fill"></i>
               </div>
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
                     <!-- WORK TYPE -->
                     <label class="filter-category-item d-flex align-items-center gap-3">
                        <input type="checkbox"
                           class="form-check-input m-0 category-check"
                           value="{{ $work->id }}">
                        <div class="category-icon">
                           <i class="bi {{ $work->icon }}"></i>
                        </div>
                        <span class="fw-semibold">{{ $work->work_type }}</span>
                     </label>
                     <!-- WORK SUBTYPES -->
                     <div class="ms-5 mt-2 d-none subtype-box" data-type="{{ $work->id }}">
                        @foreach(
                        DB::table('work_subtypes')
                        ->where('work_type_id', $work->id)
                        ->get() as $sub
                        )
                        <label class="d-flex align-items-center gap-2 mb-1 small">
                        <input type="checkbox"
                           class="form-check-input subtype-check"
                           value="{{ $sub->id }}">
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
           
           
            {{-- ================= LOCATION FILTER BAR ================= --}}
            <div class="search-section mb-4">
                <div class="row g-3 align-items-end">

                    <!-- STATE -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-geo-alt-fill me-1 text-primary"></i>
                            State
                        </label>
                        <select id="stateSelect" class="form-select form-select-custom">
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- REGION -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-map-fill me-1 text-indigo"></i>
                            Region / Zone
                        </label>
                        <select id="regionSelect" class="form-select form-select-custom" disabled>
                            <option value="">Select Region</option>
                        </select>
                    </div>

                    <!-- CITY -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">
                            <i class="bi bi-buildings-fill me-1 text-orange"></i>
                            City
                        </label>
                        <select id="citySelect" class="form-select form-select-custom" disabled>
                            <option value="">Select City</option>
                        </select>
                    </div>

                </div>
            </div>

            <!-- RESULTS HEADER -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="fw-bold mb-1"><span id="vendorCount">{{ $vendor_reg->count() }}</span> Professional Vender</h3>
                    <p class="text-muted mb-0 d-flex align-items-center gap-2">
                        <span class="badge bg-success rounded-circle p-1 pulse-animation" style="width: 10px; height: 10px;"></span>
                        Verified and ready to serve
                    </p>
                </div>
                </div>
            </div>

            {{-- RESULTS --}}
        
            @foreach($vendor_reg as $vendor)
              
                <div class="vendor-card"
                data-work-type-id="{{ $vendor->work_type_id }}"
                data-work-subtype-id="{{ $vendor->work_subtype_id }}"
                data-work-subtype="{{ strtolower($vendor->work_subtype) }}"
                data-name="{{ strtolower($vendor->name) }}"
                data-state-id="{{ $vendor->state_id ?? '' }}"
                data-region-id="{{ $vendor->region_id ?? '' }}"
                data-city-id="{{ $vendor->city_id ?? '' }}"
                data-vendor-id="{{ $vendor->id }}">


                <div class="row">
                    <div class="col-auto">
                        <div class="vendor-avatar">
                            {{ strtoupper(substr($vendor->business_name,0,1)) }}

                        </div>
                    </div>

                    <div class="col">

                        <!-- 🔒 BLURRED NAME -->
                        <h3 class="vendor-name blur-text blur-name-{{ $vendor->id }}">
                            {{ strtoupper($vendor->business_name) }}
                        </h3>

                        <span class="category-badge">
                            {{ $vendor->work_type }} - {{ $vendor->work_subtype }}
                        </span>
                        <!-- 📍 ADDRESS (NOT BLURRED) -->
                        <div class="mt-2 text-muted small d-flex align-items-center gap-2">
                            <i class="bi bi-geo-alt-fill text-primary"></i>
                            <span>
                                {{ $vendor->cityname ?? '' }},
                                {{ $vendor->regionname ?? '' }},
                                {{ $vendor->statename ?? '' }}
                            </span>
                        </div>
                        <div class="row mt-3 align-items-center">
                            <div class="col-md-6">
                                <div class="contact-info-section">

                                    <!-- 🔒 BLURRED MOBILE -->
                                    <div class="blur-text blur-mobile-{{ $vendor->id }}">
                                        {{ $vendor->mobile }}
                                    </div>

                                    <!-- 🔒 BLURRED EMAIL -->
                                    <div class="blur-text blur-email-{{ $vendor->id }}">
                                        {{ $vendor->email }}
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-5 text-end">
                                <button class="btn btn-interested"
                                    onclick="handleInterested(
                                        {{ $vendor->id }},
                                        '{{ addslashes($vendor->business_name) }}',
                                        '{{ addslashes($vendor->name) }}',
                                        '{{ addslashes($vendor->work_subtype) }}'
                                    )">
                                    ❤️ I'm Interested
                                </button>
                            </div>
                        </div>

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

            <!-- HEADER -->
            <div class="modal-header premium-header">
                <div>
                    <h5 class="fw-bold mb-0">Vendor Details</h5>
                    <small class="text-white-50">Access protected information</small>
                </div>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body p-4">

                <!-- REMAINING LEADS -->
                <div id="remainingLeadsInfo"
                     class="alert alert-success text-center fw-semibold d-none mb-4"></div>

                <!-- LOCKED INFO -->
                <div class="locked-info text-center mb-4">
                    <div class="lock-icon">
                        <i class="bi bi-lock-fill"></i>
                    </div>
                    <h4 id="modalName" class="fw-bold mt-3">Locked</h4>
                    <p id="modalCategory" class="text-muted mb-1">Upgrade Required</p>
                    <p id="modalBusiness" class="small text-muted">
                        Unlock full customer contact details
                    </p>
                </div>

                <!-- PAYMENT SECTION -->
                <div class="payment-section-modern d-none" id="paymentSection">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h3 class="price-tag mb-0">₹500</h3>
                            <small class="text-white-50">One-time access fee</small>
                        </div>
                        <span class="badge bg-light text-success fw-bold px-3 py-2">
                            Verified Lead
                        </span>
                    </div>

                    <ul class="benefits-list">
                        <li><i class="bi bi-check-circle-fill"></i> Full customer contact</li>
                        <li><i class="bi bi-check-circle-fill"></i> Genuine vendor lead</li>
                        <li><i class="bi bi-check-circle-fill"></i> No commission</li>
                    </ul>

                    <button class="btn pay-btn w-100 mt-3" id="payNowBtn">
                        <i class="bi bi-credit-card me-2"></i> Pay Now
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

            <!-- HEADER -->
            <div class="auth-header">
                <div class="auth-icon">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>
                <h5 class="fw-bold mb-1">Login Required</h5>
                <p class="mb-0 small opacity-75">
                    Please sign in to continue
                </p>

                <button type="button"
                        class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body text-center p-4">

                <p class="text-muted mb-4">
                    To view customer contact details and unlock premium leads,
                    please log in to your vendor account.
                </p>

                <a href="{{ route('login_register') }}"
                   class="btn btn-auth-primary w-100 mb-3">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Login to Continue
                </a>

                <a href="{{ route('login_register') }}"
                   class="btn btn-auth-outline w-100">
                    <i class="bi bi-person-plus me-2"></i>
                    Create Free Account
                </a>

              

            </div>
        </div>
    </div>
</div>


{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function handleInterested(id, name, business, work) {

    if (!window.CUSTOMERID) {
        new bootstrap.Modal(
            document.getElementById('authModal')
        ).show();
        return;
    }

    $.ajax({
        url: "{{ route('customer.interest.check') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            vend_id: id
        },
        success: function (res) {

            if (res.payment_required === true) {

                // Locked text
                $('#modalName').text('Locked');
                $('#modalCategory').text('Upgrade Required');
                $('#modalBusiness').text('Unlock full customer details');

                // Hide remaining leads
                $('#remainingLeadsInfo').addClass('d-none');

                // 🔥 SHOW PAYMENT SECTION (FIX)
                $('#paymentSection').removeClass('d-none');

                // Attach ID for payment
                $('#payNowBtn').data('id', id);

                new bootstrap.Modal(
                    document.getElementById('vendorModal')
                ).show();
                return;
            }

            $('#modalName').text(name);
            $('#modalCategory').text(work);
            $('#modalBusiness').text(business);

            $('#paymentSection').addClass('d-none');

            $('#remainingLeadsInfo')
                .removeClass('d-none')
                .text(`🎯 ${res.remaining} free leads remaining`);

            new bootstrap.Modal(
                document.getElementById('vendorModal')
            ).show();
        }
    });
}

/* PAY NOW */
$('#payNowBtn').on('click', function () {
    let id = $(this).data('id');
    window.location.href =
        "{{ route('razorpay.form') }}?vend_id=" + btoa(id);
});
</script>
<script>
function applyFilters() {

    let selectedCategories = [];
    let selectedSubtypes = [];

    let searchText = document.querySelector('.form-control-custom')?.value.toLowerCase().trim() || '';

    let stateId  = document.getElementById('stateSelect')?.value || '';
    let regionId = document.getElementById('regionSelect')?.value || '';
    let cityId   = document.getElementById('citySelect')?.value || '';

    // MAIN CATEGORIES
    document.querySelectorAll('.category-check:checked').forEach(cb => {
        selectedCategories.push(cb.value.toString());
    });

    // SUBTYPES
    document.querySelectorAll('.subtype-check:checked').forEach(cb => {
        selectedSubtypes.push(cb.value.toString());
    });

    let visible = 0;

    document.querySelectorAll('.vendor-card').forEach(card => {

        let cardTypeId    = card.dataset.workTypeId || '';
        let cardSubtypeId = card.dataset.workSubtypeId || '';
        let cardTitle     = card.dataset.name || '';
        let cardSubtype   = card.dataset.workSubtype || '';

        let cardStateId  = card.dataset.stateId || '';
        let cardRegionId = card.dataset.regionId || '';
        let cardCityId   = card.dataset.cityId || '';

        /* ===============================
           CATEGORY FILTER
        ================================*/
        let categoryMatch = true;

        if (selectedCategories.length > 0) {
            if (selectedSubtypes.length > 0) {
                categoryMatch = selectedSubtypes.includes(cardSubtypeId);
            } else {
                categoryMatch = selectedCategories.includes(cardTypeId);
            }
        }

        /* ===============================
           SEARCH FILTER
        ================================*/
        let textMatch =
            searchText === '' ||
            cardTitle.includes(searchText) ||
            cardSubtype.includes(searchText);

        /* ===============================
           LOCATION FILTER (STATE → REGION → CITY)
        ================================*/
        let stateMatch  = stateId  === '' || cardStateId  === stateId;
        let regionMatch = regionId === '' || cardRegionId === regionId;
        let cityMatch   = cityId   === '' || cardCityId   === cityId;

        if (categoryMatch && textMatch && stateMatch && regionMatch && cityMatch) {
            card.style.display = 'block';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    document.getElementById('vendorCount').innerText = visible;

    document.getElementById('emptyState')
        ?.classList.toggle('d-none', visible !== 0);
}



/* ===============================
   CATEGORY → SHOW SUBTYPES
================================*/
document.querySelectorAll('.category-check').forEach(cb => {
    cb.addEventListener('change', function () {

        let box = document.querySelector(`.subtype-box[data-type="${this.value}"]`);
        if (box) box.classList.toggle('d-none', !this.checked);

        applyFilters();
    });
});

/* ===============================
   AUTO APPLY ON CHANGE
================================*/
document.querySelectorAll('.subtype-check')
    .forEach(cb => cb.addEventListener('change', applyFilters));

document.querySelector('.form-control-custom')
    ?.addEventListener('keyup', applyFilters);

document.getElementById('stateSelect')
    ?.addEventListener('change', applyFilters);


function resetFilters() {

    document.querySelectorAll('.category-check, .subtype-check')
        .forEach(cb => cb.checked = false);

    document.querySelectorAll('.subtype-box')
        .forEach(b => b.classList.add('d-none'));

    document.querySelector('.form-control-custom').value = '';

    document.getElementById('stateSelect').value  = '';
    document.getElementById('regionSelect').value = '';
    document.getElementById('citySelect').value   = '';

    document.getElementById('regionSelect').disabled = true;
    document.getElementById('citySelect').disabled   = true;

    applyFilters();
}
</script>
<script>
$('#stateSelect').on('change', function () {
    let stateId = $(this).val();

    $('#regionSelect').html('<option>Loading...</option>').prop('disabled', true);
    $('#citySelect').html('<option>Select City</option>').prop('disabled', true);

    if (stateId) {
        $.get('/locations/regions/' + stateId, function (regions) {
            let options = '<option value="">Select Region</option>';
            regions.forEach(r => {
                options += `<option value="${r.id}">${r.name}</option>`;
            });
            $('#regionSelect').html(options).prop('disabled', false);
        });
    }
});

$('#regionSelect').on('change', function () {
    let regionId = $(this).val();

    $('#citySelect').html('<option>Loading...</option>').prop('disabled', true);

    if (regionId) {
        $.get('/locations/cities/' + regionId, function (cities) {
            let options = '<option value="">Select City</option>';
            cities.forEach(c => {
                options += `<option value="${c.id}">${c.name}</option>`;
            });
            $('#citySelect').html(options).prop('disabled', false);
        });
    }
});
</script>

@endsection