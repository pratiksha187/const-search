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
{{-- ================= YOUR ORIGINAL CSS (UNCHANGED) ================= --}}
<style>
:root{
    --navy:#1c2c3e;
    --orange:#f97316;
    --light:#f8fafc;
    --gray:#64748b;
}

/* ================= GLOBAL ================= */

body{
    font-family:'Inter',sans-serif;
    background:
        linear-gradient(rgba(248,250,252,.96), rgba(248,250,252,.96)),
        url('https://images.unsplash.com/photo-1581090700227-4c4f50f7b7c4?auto=format&fit=crop&w=1600&q=60');
    background-size:cover;
    background-attachment:fixed;
}

/* ================= HERO ================= */

.marketplace-hero{
    background:linear-gradient(135deg,var(--navy),#0f172a);
    padding:60px 40px;
    border-radius:20px;
    color:#fff;
    margin-bottom:35px;
    box-shadow:0 25px 60px rgba(0,0,0,.25);
}

.marketplace-hero h2{
    font-weight:900;
    font-size:32px;
    margin-bottom:8px;
}

.marketplace-hero p{
    opacity:.85;
    font-weight:500;
}

/* ================= SIDEBAR ================= */

.filter-sidebar{
    background:#fff;
    border-radius:20px;
    padding:22px;
    box-shadow:0 15px 40px rgba(0,0,0,.08);
    border:1px solid #e2e8f0;
}

.filter-header{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:20px;
    padding-bottom:15px;
    border-bottom:1px solid #eee;
}

/* ================= GRID ================= */

.vendor-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:28px;
}

@media(max-width:992px){
    .vendor-grid{grid-template-columns:1fr;}
}

/* ================= VENDOR CARD ================= */

.vendor-card{
    background:#fff;
    border-radius:18px;
    padding:22px;
    position:relative;
    box-shadow:0 15px 45px rgba(15,23,42,.08);
    transition:.35s;
    overflow:hidden;
}

.vendor-card:hover{
    transform:translateY(-6px);
    box-shadow:0 25px 70px rgba(15,23,42,.18);
}

/* Industrial Accent Stripe */
.vendor-card::before{
    content:"";
    position:absolute;
    left:0;
    top:0;
    width:6px;
    height:100%;
    background:linear-gradient(180deg,var(--orange),var(--navy));
}

/* watermark */
.vendor-card .watermark{
    position:absolute;
    right:15px;
    bottom:15px;
    font-size:70px;
    opacity:.05;
    color:var(--navy);
}

/* ================= HEADER ================= */

.vendor-header{
    display:flex;
    gap:15px;
    align-items:center;
}

.vendor-logo{
    width:58px;
    height:58px;
    border-radius:12px;
    overflow:hidden;
    background:#f1f5f9;
    display:flex;
    align-items:center;
    justify-content:center;
}

.logo-placeholder{
    background:var(--navy);
    color:#fff;
    font-weight:800;
    font-size:20px;
    width:100%;
    height:100%;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* ================= TEXT ================= */

.vendor-name{
    font-weight:800;
    font-size:17px;
    color:var(--navy);
}

.vendor-type{
    font-size:14px;
    font-weight:600;
    color:var(--orange);
}

.vendor-location{
    font-size:13px;
    color:var(--gray);
    margin-top:4px;
}

/* ================= TAGS ================= */

.tag-chip{
    background:#eef2ff;
    color:#1c2c3e;
    font-size:12px;
    padding:6px 10px;
    border-radius:8px;
    display:inline-block;
    margin:4px 4px 0 0;
}

/* ================= BADGES ================= */

.badge.verified{
    background:#e6fffa;
    color:#065f46;
    border:1px solid #10b981;
}

.badge.trusted{
    background:#fff7ed;
    color:#9a3412;
    border:1px solid var(--orange);
}

/* ================= BUTTONS ================= */

.btn-outline-custom{
    border:2px solid var(--navy);
    color:var(--navy);
    font-weight:600;
    border-radius:12px;
    padding:8px 16px;
}

.btn-outline-custom:hover{
    background:var(--navy);
    color:#fff;
}

.btn-rating{
    border:1px solid var(--orange);
    background:#fff7ed;
    color:#9a3412;
    font-weight:600;
    border-radius:8px;
    padding:6px 14px;
}

.rating-display{
    font-weight:600;
    color:#374151;
}

.rating-display i{
    color:#f59e0b;
}

/* ================= CONSTRUCTION CARD STYLE ================= */

.construction-card{
    background:#ffffff;
    border-radius:18px;
    padding:24px;
    position:relative;
    box-shadow:0 20px 50px rgba(15,23,42,.08);
    transition:.35s ease;
    overflow:hidden;
}

.construction-card:hover{
    transform:translateY(-6px);
    box-shadow:0 30px 70px rgba(15,23,42,.18);
}

/* Accent Strip */
.construction-accent{
    position:absolute;
    left:0;
    top:0;
    height:100%;
    width:6px;
    background:linear-gradient(180deg,#f97316,#1c2c3e);
}

/* Watermark */
.construction-watermark{
    position:absolute;
    right:15px;
    bottom:15px;
    font-size:70px;
    opacity:.04;
    color:#1c2c3e;
}

/* Header Layout */
.vendor-header{
    display:flex;
    gap:16px;
}

.vendor-logo{
    width:60px;
    height:60px;
    border-radius:12px;
    overflow:hidden;
    background:#f1f5f9;
    display:flex;
    align-items:center;
    justify-content:center;
}

.vendor-logo img{
    width:100%;
    height:100%;
    object-fit:contain;
}

.logo-placeholder{
    width:100%;
    height:100%;
    background:#1c2c3e;
    color:#fff;
    font-weight:800;
    display:flex;
    align-items:center;
    justify-content:center;
}

.vendor-name{
    font-weight:800;
    font-size:16px;
    color:#1c2c3e;
    margin-bottom:4px;
}

.vendor-type{
    font-size:14px;
    font-weight:600;
    color:#f97316;
}

.vendor-location{
    font-size:13px;
    color:#64748b;
}

/* Tags */
.tag-chip{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:#eef2ff;
    color:#1c2c3e;
    font-size:12px;
    padding:6px 10px;
    border-radius:8px;
}

/* Details */
.detail-item{
    font-size:13px;
    margin-bottom:4px;
    display:flex;
    gap:6px;
    align-items:center;
}

/* Footer */
.vendor-footer{
    margin-top:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.btn-profile{
    background:#1c2c3e;
    color:#fff;
    border:none;
    padding:8px 18px;
    border-radius:10px;
    font-weight:600;
    transition:.3s;
}

.btn-profile:hover{
    background:#f97316;
    color:#fff;
}

/* Rating */
.rating-display{
    font-size:14px;
    font-weight:600;
    display:flex;
    gap:6px;
    align-items:center;
}

.rating-display i{
    color:#f59e0b;
}

</style>

<script>
    window.CUSTOMERID = @json($cust_data->id ?? null);
</script>
<div class="marketplace-hero text-center">
    <h2>India’s Trusted Construction Vendor Network</h2>
    <p>Verified Contractors • Architects • Consultants • Interior Experts</p>
</div>

      {{-- ================= MAIN CONTENT ================= --}}
      <div class="container-fluid px-4 py-4">
         <div class="row g-4">
            {{-- ================= SIDEBAR ================= --}}
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
                     @foreach($work_types as $work)
                     <div class="mb-2">
                        <label class="filter-category-item d-flex align-items-center gap-3">
                        <input type="checkbox" class="form-check-input m-0 category-check" value="{{ $work->id }}">
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
            {{-- ================= MAIN LIST ================= --}}
            <div class="col-lg-9">
               {{-- ================= LOCATION FILTER ================= --}}
               <div class="search-section mb-4">
                  <div class="row g-3">
                     <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">State</label>
                        <select id="stateSelect" class="form-select form-select-custom">
                           <option value="">Select State</option>
                           @foreach($states as $state)
                           <option value="{{ $state->id }}">{{ $state->name }}</option>
                           @endforeach
                        </select>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">District</label>
                        <select id="regionSelect" class="form-select form-select-custom" disabled>
                           <option value="">Select District</option>
                        </select>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">Region</label>
                        <select id="citySelect" class="form-select form-select-custom" disabled>
                           <option value="">Select Region</option>
                        </select>
                     </div>
                  </div>
               </div>
               <h3 class="fw-bold mb-3">
                  <span id="vendorCount">{{ $vendor_reg->count() }}</span> Professional Vendor
               </h3>
               {{-- ================= VENDORS ================= --}}
              
               <div class="vendor-grid">
                    @foreach($vendor_reg as $vendor)

                    <div class="vendor-card construction-card"
                        data-vendor-id="{{ $vendor->id }}"
                        data-business="{{ $vendor->business_name }}"
                        data-fullname="{{ $vendor->name }}"
                        data-contact-name="{{ $vendor->contact_person_name }}"
                        data-mobile="{{ $vendor->mobile }}"
                        data-email="{{ $vendor->email }}"
                        data-work-type-id="{{ $vendor->work_type_id }}"
                        data-work-subtype-id='@json(json_decode($vendor->work_subtype_id))'
                        data-state-id="{{ $vendor->state }}"
                        data-region-id="{{ $vendor->region }}"
                        data-city-id="{{ $vendor->city }}"
                    >

                        <!-- Industrial Accent -->
                        <div class="construction-accent"></div>

                        <!-- Watermark Icon -->
                        <div class="construction-watermark">
                            <i class="bi bi-building"></i>
                        </div>

                        <!-- ================= HEADER ================= -->
                        <div class="vendor-header">

                            <div class="vendor-logo">
                                @if(!empty($vendor->company_logo))
                                    <img src="{{ asset('storage/'.$vendor->company_logo) }}"
                                        alt="{{ $vendor->business_name }}">
                                @else
                                    <div class="logo-placeholder">
                                        {{ strtoupper(substr($vendor->business_name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="vendor-info">
                                <h5 class="vendor-name">
                                    {{ strtoupper($vendor->business_name) }}
                                </h5>

                                <div class="vendor-type">
                                    {{ $vendor->work_type }}
                                </div>

                                <div class="vendor-location">
                                    📍 {{ $vendor->statename }},
                                    {{ $vendor->regionname }},
                                    {{ $vendor->cityname }}
                                </div>

                                <div class="badge-wrapper mt-1">
                                    @if($vendor->profile_percent >= 90)
                                        <span class="badge verified">✔ Verified</span>
                                        <span class="badge trusted">⭐ Trusted</span>
                                    @elseif($vendor->profile_percent >= 60)
                                        <span class="badge verified">✔ Verified</span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <!-- ================= TAGS ================= -->
                        <div class="tags mt-3">
                            @foreach(explode(',', $vendor->work_subtype_data) as $subtype)
                                <span class="tag-chip">
                                    <i class="bi bi-check2-circle"></i>
                                    {{ trim($subtype) }}
                                </span>
                            @endforeach
                        </div>

                        <!-- ================= DETAILS ================= -->
                        <div class="details mt-3">
                            <div class="detail-item">
                                <i class="bi bi-award-fill text-warning"></i>
                                {{ $vendor->experiance }} Experience
                            </div>

                        </div>

                        <!-- ================= FOOTER ACTION ================= -->
                        <div class="vendor-footer">

                            <button class="btn btn-profile"
                                onclick="viewProfile({{ $vendor->id }})">
                                View Profile
                            </button>

                            @if(($vendor->total_reviews ?? 0) > 0)
                                <div class="rating-display">
                                    @php $r = (int) round($vendor->avg_rating ?? 0); @endphp
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $r)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor

                                    <span>
                                        {{ number_format((float)($vendor->avg_rating ?? 0), 1) }}
                                        ({{ $vendor->total_reviews }})
                                    </span>
                                </div>
                            @else
                                <button class="btn btn-rating"
                                    onclick="openRatingModal({{ $vendor->id }})">
                                    ⭐ Add Rating
                                </button>
                            @endif

                        </div>

                    </div>

                    @endforeach 
<!-- </div> -->

         <!-- </div> -->
      </div>
{{-- ================= AUTH MODAL (UNCHANGED) ================= --}}

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
               To view Vendor contact details and unlock premium leads, please log in to your Customer account.
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
<div class="modal fade" id="ratingModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Rate Vendor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">

                <input type="hidden" id="ratingVendorId">
                <input type="hidden" id="ratingValue">

                <p class="mb-2 text-muted">How was your experience?</p>

                <div class="star-rating" id="starRating">
                    <i class="bi bi-star" data-value="1"></i>
                    <i class="bi bi-star" data-value="2"></i>
                    <i class="bi bi-star" data-value="3"></i>
                    <i class="bi bi-star" data-value="4"></i>
                    <i class="bi bi-star" data-value="5"></i>
                </div>

                <div class="rating-text mt-2" id="ratingText">Select a rating</div>

                <textarea class="form-control mt-3"
                    id="ratingComment"
                    placeholder="Write a short review (optional)"
                    rows="3"></textarea>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>

                <button class="btn btn-primary" onclick="submitRating()">
                    Submit Rating
                </button>
            </div>

        </div>
    </div>
</div>

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   function handleInterested(id) {
   
       if (!window.CUSTOMERID) {
           new bootstrap.Modal(document.getElementById('authModal')).show();
           return;
       }
      const card = document.querySelector(`.vendor-card[data-vendor-id="${id}"]`);
      $('#vFullname').text(card.dataset.fullname);
       $('#vBusiness').text(card.dataset.business);
       $('#vMobile').text(card.dataset.mobile);
       $('#vEmail').text(card.dataset.email);
       $('#vLocation').text(
           [card.dataset.cityName, card.dataset.regionName, card.dataset.stateName].join(', ')
       );
   
       new bootstrap.Modal(document.getElementById('vendorModal')).show();
       $.ajax({
           url: "{{ route('customer.interest.check') }}",
           method: "POST",
           headers: {
               'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
           },
           data: {
               vend_id: id
           },
           success: function (res) {
               alert('Interest sent successfully ✅');
   
               // Optional: open vendor modal
               new bootstrap.Modal(document.getElementById('vendorModal')).show();
           },
           error: function () {
               alert('Something went wrong ❌');
           }
       });
   }
</script>
<script>
   function applyFilters() {
   
       let cats = $('.category-check:checked').map((_,e)=>e.value).get();
       let subs = $('.subtype-check:checked').map((_,e)=>e.value).get();
   
       let s = $('#stateSelect').val();
       let r = $('#regionSelect').val();
       let c = $('#citySelect').val();
   
       let count = 0;
   
       $('.vendor-card').each(function () {
   
           let card = this;
           let subtypes = JSON.parse(card.dataset.workSubtypeId || '[]');
   
           let match =
               (!cats.length || cats.includes(card.dataset.workTypeId)) &&
               (!subs.length || subs.some(x => subtypes.includes(x))) &&
               (!s || s == card.dataset.stateId) &&
               (!r || r == card.dataset.regionId) &&
               (!c || c == card.dataset.cityId);
   
           card.style.display = match ? 'block' : 'none';
           if (match) count++;
       });
   
       $('#vendorCount').text(count);
       $('#categoryCount').text(cats.length);
   }
   
   $('.category-check').on('change', function () {
       $(`.subtype-box[data-type="${this.value}"]`).toggleClass('d-none', !this.checked);
       applyFilters();
   });
   
   $('.subtype-check, #stateSelect, #regionSelect, #citySelect')
   .on('change', applyFilters);
   
   document.addEventListener('DOMContentLoaded', applyFilters);
   
   
   $('#stateSelect').on('change', function () {
   
       let stateId = this.value;
   
       $('#regionSelect')
           .prop('disabled', true)
           .html('<option value="">Loading District...</option>');
   
       $('#citySelect')
           .prop('disabled', true)
           .html('<option value="">Select regions</option>');
   
       if (!stateId) {
           applyFilters();
           return;
       }
   
       $.get(`/locations/regions/${stateId}`, function (regions) {
   
           let options = '<option value="">Select District</option>';
           regions.forEach(r => {
               options += `<option value="${r.id}">${r.name}</option>`;
           });
   
           $('#regionSelect')
               .html(options)
               .prop('disabled', false);
   
           applyFilters();
       });
   });
   $('#regionSelect').on('change', function () {
   
       let regionId = this.value;
   
       $('#citySelect')
           .prop('disabled', true)
           .html('<option value="">Loading Region...</option>');
   
       if (!regionId) {
           applyFilters();
           return;
       }
   
       $.get(`/locations/cities/${regionId}`, function (cities) {
   
           let options = '<option value="">Select Region</option>';
           cities.forEach(c => {
               options += `<option value="${c.id}">${c.name}</option>`;
           });
   
           $('#citySelect')
               .html(options)
               .prop('disabled', false);
   
           applyFilters();
       });
   });
   
   $('#citySelect').on('change', applyFilters);
</script>
<script>
   function requireLogin(callback) {
    if (!window.CUSTOMERID) {
        new bootstrap.Modal(document.getElementById('authModal')).show();
        return false;
    }
    callback();
}

function viewProfile(id) {
   if (!window.CUSTOMERID) {
        new bootstrap.Modal(document.getElementById('authModal')).show();
        return;
    }
    window.location.href = "{{ url('vendor/profile/id') }}/" + id;
}
</script>


<script>
const ratingLabels = {
    1: "Very Bad",
    2: "Bad",
    3: "Average",
    4: "Good",
    5: "Excellent"
};

function openRatingModal(vendorId){
    document.getElementById('ratingVendorId').value = vendorId;
    document.getElementById('ratingValue').value = '';
    document.getElementById('ratingText').innerText = 'Select a rating';

    document.querySelectorAll('#starRating i').forEach(star => {
        star.classList.remove('active');
    });

    new bootstrap.Modal(document.getElementById('ratingModal')).show();
}

document.querySelectorAll('#starRating i').forEach(star => {

    star.addEventListener('mouseenter', function(){
        const val = this.dataset.value;
        highlightStars(val, 'hover');
    });

    star.addEventListener('mouseleave', function(){
        clearHover();
    });

    star.addEventListener('click', function(){
        const val = this.dataset.value;
        document.getElementById('ratingValue').value = val;
        document.getElementById('ratingText').innerText = ratingLabels[val];
        highlightStars(val, 'active');
    });
});

function highlightStars(val, type){
    document.querySelectorAll('#starRating i').forEach(star => {
        star.classList.remove('hover', 'active');
        if(star.dataset.value <= val){
            star.classList.add(type);
        }
    });
}

function clearHover(){
    const selected = document.getElementById('ratingValue').value;
    document.querySelectorAll('#starRating i').forEach(star => {
        star.classList.remove('hover');
        if(selected && star.dataset.value <= selected){
            star.classList.add('active');
        }
    });
}

function submitRating(){

    const vendorId = document.getElementById('ratingVendorId').value;
    const rating   = document.getElementById('ratingValue').value;
    const comment  = document.getElementById('ratingComment').value;

    if(!rating){
        alert('Please select a rating');
        return;
    }

    $.ajax({
        url: "/vendor/rate", // 🔁 change to your route
        method: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            vendor_id: vendorId,
            rating: rating,
            comment: comment
        },
        success: function(){
            alert('⭐ Rating submitted successfully');
            bootstrap.Modal.getInstance(
                document.getElementById('ratingModal')
            ).hide();
        },
        error: function(){
            alert('❌ Failed to submit rating');
        }
    });
}
</script>

@endsection