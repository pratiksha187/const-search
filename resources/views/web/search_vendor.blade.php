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

    * {
      box-sizing: border-box;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    }

    /* body {
      background: #f4f6fb;
      padding: 40px;
    } */

    .card {
      width: 420px;
      background: #fff;
      border-radius: 16px;
      padding: 22px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      border-left: 5px solid #5b6cff;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .title {
      font-size: 22px;
      font-weight: 700;
      color: #0f172a;
    }

    .verified {
      background: #22c55e;
      color: #fff;
      font-size: 13px;
      font-weight: 600;
      padding: 6px 12px;
      border-radius: 20px;
    }

    .subtitle {
      margin-top: 8px;
      color: #4f46e5;
      font-weight: 600;
    }

    .location {
      margin-top: 6px;
      color: #64748b;
      font-size: 14px;
    }

    .tags {
      margin-top: 14px;
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }

    .tag {
      background: #f1f5f9;
      color: #0f172a;
      font-size: 13px;
      padding: 6px 12px;
      border-radius: 8px;
      font-weight: 500;
    }

    .details {
      margin-top: 16px;
      color: #475569;
      font-size: 14px;
    }

    .details p {
      margin: 6px 0;
    }

    .actions {
      margin-top: 22px;
      display: flex;
      gap: 12px;
    }

    .btn {
      flex: 1;
      padding: 12px;
      font-size: 15px;
      font-weight: 600;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.25s ease;
    }

    .btn-outline {
      background: #fff;
      border: 2px solid #5b6cff;
      color: #5b6cff;
    }

    .btn-outline:hover {
      background: #5b6cff;
      color: #fff;
    }

    .btn-primary {
      background: #5b6cff;
      border: none;
      color: #fff;
    }

    /* ===== FORCE 2 CARDS PER ROW ===== */
.vendor-grid{
    display:grid;
    grid-template-columns:repeat(2, minmax(0, 1fr));
    gap:24px;
}

/* Tablet */
@media (max-width: 1200px){
    .vendor-grid{
        grid-template-columns:repeat(2, 1fr);
    }
}

/* Mobile */
@media (max-width: 768px){
    .vendor-grid{
        grid-template-columns:1fr;
    }
}

/* Card should fill grid cell */
.vendor-card{
    width:100%;
    max-width:100%;
}

    .btn-primary:hover {
      background: #434eea;
    }

    .tags{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
    margin:10px 0 14px;
}

.tag-chip{
    background:#f1f5f9;
    color:#0f172a;
    font-size:13px;
    font-weight:500;
    padding:6px 10px;
    border-radius:8px;
    white-space:nowrap;
    box-shadow:inset 0 0 0 1px #e5e7eb;
}

</style>
<script>
    window.CUSTOMERID = @json($cust_data->id ?? null);
</script>

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
                        <label class="form-label fw-semibold small text-muted">Region</label>
                        <select id="regionSelect" class="form-select form-select-custom" disabled>
                           <option value="">Select Region</option>
                        </select>
                     </div>
                     <div class="col-md-4">
                        <label class="form-label fw-semibold small text-muted">City</label>
                        <select id="citySelect" class="form-select form-select-custom" disabled>
                           <option value="">Select City</option>
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
                  <div class="card vendor-card"
                  data-vendor-id="{{ $vendor->id }}"
                  {{-- BASIC --}}
                  data-business="{{ $vendor->business_name }}"
                  data-fullname="{{ $vendor->name }}"
                  data-contact-name="{{ $vendor->contact_person_name }}"
                  data-mobile="{{ $vendor->mobile }}"
                  data-email="{{ $vendor->email }}"
                  {{-- WORK --}}
                  data-work-type-id="{{ $vendor->work_type_id }}"
                  data-work-subtype-id='@json(json_decode($vendor->work_subtype_id))'
                  data-work-type="{{ strtolower($vendor->work_type) }}"
                  data-work-subtype="{{ strtolower($vendor->work_subtype_data) }}"
                  data-experience="{{ $vendor->experience_years }}"
                  data-team-size="{{ $vendor->team_size_data }}"
                  data-min-project="{{ $vendor->min_project_value }}"
                  {{-- COMPANY --}}
                  data-company-name="{{ $vendor->company_name }}"
                  data-entity-type="{{ $vendor->entity_type }}"
                  data-gst="{{ $vendor->gst_number }}"
                  data-pan="{{ $vendor->pan_number }}"
                  data-msme="{{ $vendor->msme_registered }}"
                  {{-- LOCATION --}}
                  data-state-id="{{ $vendor->state }}"
                  data-region-id="{{ $vendor->region }}"
                  data-city-id="{{ $vendor->city }}"
                  {{-- BANK (OPTIONAL) --}}
                  data-bank-name="{{ $vendor->bank_name }}"
                  data-account-type="{{ $vendor->account_type }}">
                  <div class="card-header">
                     <div class="title">{{ strtoupper($vendor->business_name) }}</div>
                     <div class="verified">✔ Verified</div>
                  </div>

                  <div class="subtitle">{{ $vendor->work_type }}</div>
                  <div class="location">📍  {{ $vendor->statename ?? '' }},
                        {{ $vendor->regionname ?? '' }},
                        {{ $vendor->cityname ?? '' }}</div>

                  <!-- <div class="tags">
                     <div class="tag">✔ {{ $vendor->work_subtype_data }}</div>
                  
                  </div> -->
                  <div class="tags">
         @foreach(explode(',', $vendor->work_subtype_data) as $subtype)
            <span class="tag-chip">
                  ✔ {{ trim($subtype) }}
            </span>
         @endforeach
      </div>


      <div class="details">
         <p>✔ {{ $vendor->experience_years }} years experience</p>
         <p>✔ Premium {{$vendor->work_type}}</p>
      </div>

      <div class="actions">
        
         <button class="btn btn-outline" onclick="viewProfile({{ $vendor->id }})">
            View Profile
         </button>

      </div>
   </div>
   @endforeach
   </div>
   </div>
</div>
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
           .html('<option value="">Loading regions...</option>');
   
       $('#citySelect')
           .prop('disabled', true)
           .html('<option value="">Select City</option>');
   
       if (!stateId) {
           applyFilters();
           return;
       }
   
       $.get(`/locations/regions/${stateId}`, function (regions) {
   
           let options = '<option value="">Select Region</option>';
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
           .html('<option value="">Loading cities...</option>');
   
       if (!regionId) {
           applyFilters();
           return;
       }
   
       $.get(`/locations/cities/${regionId}`, function (cities) {
   
           let options = '<option value="">Select City</option>';
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


@endsection