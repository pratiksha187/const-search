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
   height:100%;
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
   @media (min-width: 576px) {
   .modal {
   --bs-modal-margin: 6.75rem;
   --bs-modal-box-shadow: var(--bs-box-shadow);
   }
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
   .lead-card{
   background:#fff;
   border-radius:10px;
   padding:22px;
   border:1px solid #e5e7eb;
   box-shadow:0 10px 30px rgba(0,0,0,.06);
   position:relative;
   height:100%;
   }
   .lead-card::before{
   content:'';
   position:absolute;
   left:0;
   top:0;
   width:5px;
   height:100%;
   border-radius:20px 0 0 20px;
   background:linear-gradient(180deg,#6c7cf7,#4f6ef7);
   }
   .lead-title{
   font-size:20px;
   font-weight:800;
   color:#0f172a;
   }
   .lead-role{
   font-size:15px;
   font-weight:600;
   color:#4f46e5;
   }
   .verified-pill{
   background:#22c55e;
   color:#fff;
   font-size:13px;
   font-weight:600;
   padding:6px 14px;
   border-radius:999px;
   display:inline-flex;
   align-items:center;
   gap:6px;
   }
   .lead-location{
   font-size:14px;
   color:#64748b;
   display:flex;
   align-items:center;
   gap:6px;
   }
   .lead-tags{
   display:flex;
   flex-wrap:wrap;
   gap:10px;
   margin-top:12px;
   }
   .lead-tag{
   background:#f1f5f9;
   border:1px solid #e2e8f0;
   border-radius:12px;
   padding:6px 12px;
   font-size:14px;
   font-weight:600;
   }
   .contact-box{
   background:#f8fafc;
   border:1px solid #e5e7eb;
   border-radius:14px;
   padding:12px;
   font-size:14px;
   margin-top:14px;
   }
   .lead-actions{
   display:flex;
   gap:14px;
   margin-top:20px;
   }
   .btn-outline-lead{
   flex:1;
   border:2px solid #6c7cf7;
   color:#6c7cf7;
   background:#fff;
   border-radius:14px;
   padding:12px;
   font-weight:700;
   text-decoration:none;
   text-align:center;
   }
   .btn-outline-lead:hover{
   background:#eef2ff;
   }
   .btn-primary-lead{
   flex:1;
   background:#6c7cf7;
   color:#fff;
   border:none;
   border-radius:14px;
   padding:12px;
   font-weight:700;
   }
   .btn-primary-lead:hover{
   background:#4f6ef7;
   }
   /* LOCKED INFO */
   .locked-box{
   background:#f8fafc;
   border:1px solid #e5e7eb;
   border-radius:14px;
   padding:18px;
   text-align:center;
   }
   .locked-box h5{
   margin:8px 0 4px;
   font-weight:600;
   }
   .locked-box small{
   color:#6b7280;
   }
   .lock-icon{
   font-size:28px;
   }
   /* PRICING SECTION */
   .pricing-section{
   background:#ffffff;
   border:1px solid #e5e7eb;
   border-radius:18px;
   padding:32px;
   }
   .pricing-header{
   text-align:center;
   margin-bottom:28px;
   }
   .pricing-header h4{
   font-weight:700;
   }
   .pricing-header p{
   color:#6b7280;
   margin-bottom:0;
   }
   /* PLAN CARDS */
   .plan-card{
   background:#ffffff;
   border:1px solid #e5e7eb;
   border-radius:16px;
   padding:24px;
   height:100%;
   position:relative;
   }
   .plan-card.recommended{
   border:2px solid #f25c05;
   box-shadow:0 10px 25px rgba(0,0,0,0.08);
   }
   /* BADGE */
   .recommended-badge{
   position:absolute;
   top:-12px;
   left:50%;
   transform:translateX(-50%);
   background:#f25c05;
   color:#fff;
   padding:5px 14px;
   font-size:12px;
   border-radius:20px;
   font-weight:600;
   }
   /* TEXT */
   .plan-title{
   font-size:13px;
   font-weight:600;
   text-transform:uppercase;
   color:#374151;
   }
   .plan-price{
   font-size:34px;
   font-weight:700;
   margin:12px 0 6px;
   }
   .gst{
   font-size:14px;
   color:#6b7280;
   }
   .plan-meta{
   font-size:14px;
   color:#6b7280;
   margin-bottom:16px;
   }
   /* FEATURES */
   .plan-features{
   list-style:none;
   padding:0;
   margin-bottom:20px;
   }
   .plan-features li{
   margin-bottom:8px;
   font-size:14px;
   }
   /* BUTTONS */
   .btn-primary{
   background:#f25c05;
   border:none;
   border-radius:10px;
   padding:10px;
   font-weight:600;
   }
   .btn-outline{
   background:#ffffff;
   border:1px solid #d1d5db;
   border-radius:10px;
   padding:10px;
   font-weight:600;
   }
   /* ===== GRID STABILITY FIX ===== */
.vendor-col {
    display: flex;
}

.vendor-col.hidden {
    display: none !important;
}

.lead-card.vendor-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
}

/* Ensure actions always stay bottom */
.lead-card{
    position:relative;
    overflow:hidden;
}

/* CORNER RIBBON */
.corner-ribbon {
    position: absolute;
    top: 35px;
    right: -52px;
    transform: rotate(45deg);
    background: #f25c05;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    padding: 5px 41px;
    text-transform: uppercase;
    letter-spacing: .5px;
    box-shadow: 0 6px 16px rgba(0, 0, 0, .25);
    z-index: 20;
}

.lead-header{
    padding:14px 0;
}

.lead-title-wrap{
    display:flex;
    align-items:center;
    gap:14px;
    flex-wrap:wrap;
}

/* title */
.lead-title{
    font-size:28px;
    font-weight:800;
    color:#0f172a;
    margin:0;
}

/* pills */
.lead-pill{
    font-size:13px;
    font-weight:600;
    padding:6px 14px;
    border-radius:999px;
    line-height:1;
    white-space:nowrap;
}

.lead-pill.completed{
    background:#dcfce7;
    color:#15803d;
}

.lead-pill.remaining{
    background:#fff7ed;
    color:#c2410c;
}
@media(max-width:576px){
    .lead-title{
        font-size:22px;
    }
}


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
                  <i class="bi bi-map-fill me-1 text-indigo"></i> District
                  </label>
                  <select id="regionSelect" class="form-select form-select-custom" disabled>
                     <option value="">Select District</option>
                  </select>
               </div>
               <div class="col-lg-4 col-md-12">
                  <label class="form-label fw-semibold small text-muted">
                  <i class="bi bi-buildings-fill me-1 text-orange"></i> Region
                  </label>
                  <select id="citySelect" class="form-select form-select-custom" disabled>
                     <option value="">Select City</option>
                  </select>
               </div>
            </div>
         </div>
         <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
               <div class="lead-header">
   <div class="lead-title-wrap">
      <h2 class="lead-title">
         {{ $projects->count() }} Professional Leads
      </h2>

    <span class="lead-pill completed">
   <i class="bi bi-check-circle-fill me-1"></i>
   {{ $complited_project->count() }} Completed
</span>

<span class="lead-pill remaining">
   <i class="bi bi-hourglass-split me-1"></i>
   {{ $remaining_projects->count() }} Remaining
</span>

   </div>
</div>

            </div>
         </div>
         {{-- RESULTS --}}
         <div class="row g-4">
            @foreach($projects as $project)
            <!-- <div class="col-xl-6 col-lg-6 col-md-12"> -->
               <div class="col-xl-6 col-lg-6 col-md-12 vendor-col">

               <div class="lead-card vendor-card"
                  data-work-type-id="{{ $project->work_type_id }}"
                  data-work-subtype-id="{{ $project->work_subtype_id }}"
                  data-work-subtype="{{ strtolower($project->work_subtype) }}"
                  data-name="{{ strtolower($project->title) }}"
                  data-state="{{ strtolower($project->statename ?? '') }}"
                  data-region="{{ strtolower($project->regionname ?? '') }}"
                  data-city="{{ strtolower($project->cityname ?? '') }}"
                  data-project-id="{{ $project->id }}">
                  {{-- HEADER --}}
                  <div class="d-flex justify-content-between align-items-start mb-2">
                     <div class="lead-title">
                        {{ strtoupper($project->title) }}
                     </div>
                     <span class="verified-pill">
                     <i class="bi bi-check-circle-fill"></i> Verified
                     </span>

                     @if($project->get_vendor == 1)
                     <div class="corner-ribbon">
                        Vendor Matched
                     </div>
                     @endif

                  </div>
                  {{-- ROLE --}}
                  <div class="lead-role mb-1">
                     {{ $project->work_type }}
                  </div>
                  {{-- LOCATION --}}
                  <div class="lead-location mb-2">
                     <i class="bi bi-geo-alt-fill text-danger"></i>
                     {{ $project->statename }},
                     {{ $project->regionname }},
                     {{ $project->cityname }}
                  </div>
                  {{-- TAGS --}}
                  <div class="lead-tags">
                     @foreach(explode(',', $project->work_subtype) as $sub)
                     <div class="lead-tag">✓ {{ trim($sub) }}</div>
                     @endforeach
                  </div>
                  {{-- DATE --}}
                  <div class="text-muted small mt-2">
                     <i class="bi bi-calendar-event me-1"></i>
                     Posted on {{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}
                  </div>
                  {{-- CONTACT INFO (MASKED SAME LOGIC) --}}
                  <div class="contact-box">
                     <div class="mb-1">
                        <strong>Contact Person:</strong>
                        <span class="blur-text">{{ strtoupper($project->contact_name) }}</span>
                     </div>
                     <div class="mb-1">
                        <i class="bi bi-telephone-fill text-primary me-1"></i>
                        <strong>Mobile:</strong>
                        @php
                        $mobile = preg_replace('/\D/', '', $project->mobile);
                        $maskedMobile = $mobile
                        ? substr($mobile, 0, 2) . str_repeat('x', max(strlen($mobile) - 2, 0))
                        : 'xxxxxxxxxx';
                        @endphp
                        {{ $maskedMobile }}
                     </div>
                     <div>
                        <i class="bi bi-envelope-fill text-primary me-1"></i>
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
                  {{-- ACTIONS (SAME handleInterested) --}}
                 
                  <div class="lead-actions">
                     @if($project->get_vendor == 1)
                        <a href="javascript:void(0)"
                           class="btn-outline-lead disabled"
                           style="pointer-events:none;opacity:0.5;">
                           View Profile
                        </a>
                     @else
                        <a href="javascript:void(0)"
                           class="btn-outline-lead view-profile-btn"
                           data-id="{{ $project->id }}">
                           View Profile
                        </a>
                     @endif
                  </div>

               </div>
            </div>
            @endforeach
         </div>
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
            <!-- <div class="locked-box mb-4"> -->
            <div id="lockedBox" class="locked-box d-none mb-4">
               <div class="lock-icon">🔒</div>
               <h5>Contact Locked</h5>
               <small>
               Upgrade your plan to view full customer details (Name, Phone & Email)
               </small>
            </div>
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
document.addEventListener('click', function (e) {

    const btn = e.target.closest('.view-profile-btn');
    if (!btn) return;

    e.preventDefault(); // ⛔ STOP default navigation

    const projectId = btn.dataset.id;

    // 🔐 LOGIN CHECK
    if (!window.VENDOR_ID) {
        new bootstrap.Modal(document.getElementById('authModal')).show();
        return;
    }

    // ✅ Logged in → redirect
    window.location.href = "{{ url('customer/profile/id') }}/" + projectId;
});
</script>

<script>
   document.addEventListener('click', function (e) {
       const btn = e.target.closest('.show-interest-btn');
       if (!btn) return;
   
       handleInterested(
           btn.dataset.id,
           btn.dataset.username,
           btn.dataset.usersmobile,
           btn.dataset.useremail,
           '',
           btn.dataset.title,
           btn.dataset.work,
           btn.dataset.location,
           btn.dataset.budget,
           btn.dataset.description,
           btn.dataset.contactTime
       );
   });
   
   
   function resetLeadModalUI() {
       $('#projectDetailsSection').addClass('d-none');
       $('#remainingLeadsInfo').addClass('d-none').text('');
       $('#lockedBox').addClass('d-none');
       $('#pricingSection').addClass('d-none');
   }
   
   
   function handleInterested(
       id,
       username,
       usersmobile,
       useremail,
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
   
       // Fill modal data
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
   
       $.ajax({
           url: "{{ route('customer.interest.check') }}",
           type: "POST",
           data: {
               _token: "{{ csrf_token() }}",
               cust_id: id
           },
   
          success: function (res) {
          
              resetLeadModalUI();
          
              /* ===============================
                  1️⃣ ALREADY UNLOCKED
              ================================ */
              if (res.already_exists === true) {
          
                  $('#projectDetailsSection').removeClass('d-none');
          
                  new bootstrap.Modal(
                      document.getElementById('vendorModal')
                  ).show();
          
                  return; // ⛔ STOP HERE
              }
          
              let remaining = parseInt(res.remaining, 10) || 0;
          
              /* ===============================
                  2️⃣ FREE LEADS AVAILABLE
              ================================ */
              if (remaining > 0 && res.payment_required === false) {
          
                  $('#projectDetailsSection').removeClass('d-none');
          
                  $('#remainingLeadsInfo')
                      .removeClass('d-none')
                      .text(`🎯 ${remaining} free leads remaining`);
          
                  new bootstrap.Modal(
                      document.getElementById('vendorModal')
                  ).show();
          
                  return;
              }
          
              /* ===============================
                  3️⃣ PAYMENT REQUIRED
              ================================ */
              $('#lockedBox').removeClass('d-none');
              $('#pricingSection').removeClass('d-none');
          
              new bootstrap.Modal(
                  document.getElementById('vendorModal')
              ).show();
          },
   
           error: function () {
               Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
           }
       });
   }
</script>
<script>

   $(document).on('click', '.buy-plan-btn', function () {
   
       const plan   = $(this).data('plan');
       const amount = parseInt($(this).data('amount'), 10);
       const custId = $(this).data('cust');
   
       $.post("{{ route('razorpay.createOrder') }}", {
           _token: "{{ csrf_token() }}",
           cust_id: custId,
           plan: plan,
           amount: amount
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
               description: `${plan.toUpperCase()} Lead Package`,
               order_id: res.order_id,
               prefill: {
                       name: "ConstructKaro",
                       email: "connect@constructkaro.com",
                       contact: "8806561819" 
                   },
   
                   readonly: {
                       contact: true,
                       email: true
                   },
               handler: function (response) {
   
                   $.post("{{ route('razorpay.verify') }}", {
                       _token: "{{ csrf_token() }}",
                       razorpay_payment_id: response.razorpay_payment_id,
                       razorpay_order_id: response.razorpay_order_id,
                       razorpay_signature: response.razorpay_signature,
                       cust_id: btoa(custId),
                       plan: plan,
                       amount: amount
                   }, function (verifyRes) {
   
                       if (verifyRes.success) {
                           document.activeElement?.blur();
   
                           bootstrap.Modal.getInstance(
                               document.getElementById('vendorModal')
                           ).hide();
   
                           Swal.fire({
                               icon: 'success',
                               title: 'Payment Successful',
                               text: `₹${amount} payment completed`,
                               confirmButtonColor: '#10b981'
                           }).then(() => location.reload());
                       } else {
                           Swal.fire('Error', 'Payment verification failed', 'error');
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

// function applyFilters() {

//     let selectedCategories = [];
//     let selectedSubtypes   = [];

//     $('.category-check:checked').each(function () {
//         selectedCategories.push(this.value);
//     });

//     $('.subtype-check:checked').each(function () {
//         selectedSubtypes.push(this.value);
//     });

//     let stateText  = $('#stateSelect option:selected').text().toLowerCase().trim();
//     let regionText = $('#regionSelect option:selected').text().toLowerCase().trim();
//     let cityText   = $('#citySelect option:selected').text().toLowerCase().trim();

//     if (stateText === 'select state') stateText = '';
//     if (regionText === 'select region') regionText = '';
//     if (cityText === 'select city') cityText = '';

//     let visible = 0;

//     $('.vendor-col').each(function () {

//         let card = this.querySelector('.vendor-card');

//         let cardTypeId    = card.dataset.workTypeId || '';
//         let cardSubtypeId = card.dataset.workSubtypeId || '';

//         let cardState  = (card.dataset.state || '').toLowerCase();
//         let cardRegion = (card.dataset.region || '').toLowerCase();
//         let cardCity   = (card.dataset.city || '').toLowerCase();

//         /* ===== CATEGORY MATCH ===== */
//         let categoryMatch = true;

//         if (selectedCategories.length > 0) {
//             categoryMatch = selectedCategories.includes(cardTypeId);
//         }

//         if (selectedSubtypes.length > 0) {
//             categoryMatch = selectedSubtypes.includes(cardSubtypeId);
//         }

//         /* ===== LOCATION MATCH ===== */
//         let stateMatch  = !stateText  || cardState.includes(stateText);
//         let regionMatch = !regionText || cardRegion.includes(regionText);
//         let cityMatch   = !cityText   || cardCity.includes(cityText);

//         if (categoryMatch && stateMatch && regionMatch && cityMatch) {
//             this.classList.remove('hidden');
//             visible++;
//         } else {
//             this.classList.add('hidden');
//         }
//     });

//     $('#vendorCount').text(visible);
// }
function applyFilters() {

    let selectedCategories = [];
    let selectedSubtypes   = [];

    $('.category-check:checked').each(function () {
        selectedCategories.push(this.value);
    });

    $('.subtype-check:checked').each(function () {
        selectedSubtypes.push(this.value);
    });

    let stateText    = $('#stateSelect option:selected').text().toLowerCase().trim();
    let districtText = $('#regionSelect option:selected').text().toLowerCase().trim();
    let cityText     = $('#citySelect option:selected').text().toLowerCase().trim();

    if (stateText === 'select state') stateText = '';
    if (districtText === 'select district') districtText = '';
    if (cityText === 'select city') cityText = '';

    let visible = 0;

    $('.vendor-col').each(function () {

        let card = this.querySelector('.vendor-card');

        let cardTypeId     = card.dataset.workTypeId || '';
        let cardSubtypeIds = (card.dataset.workSubtypeId || '').split(',');

        let cardState    = (card.dataset.state || '').toLowerCase();
        let cardDistrict = (card.dataset.region || '').toLowerCase();
        let cardCity     = (card.dataset.city || '').toLowerCase();

        /* ===== CATEGORY MATCH ===== */
        let categoryMatch = true;

        if (selectedCategories.length > 0) {
            categoryMatch = selectedCategories.includes(cardTypeId);
        }

        if (selectedSubtypes.length > 0) {
            categoryMatch = categoryMatch &&
                selectedSubtypes.some(id => cardSubtypeIds.includes(id));
        }

        /* ===== LOCATION MATCH ===== */
        let stateMatch    = !stateText    || cardState === stateText;
        let districtMatch = !districtText || cardDistrict === districtText;
        let cityMatch     = !cityText     || cardCity === cityText;

        if (categoryMatch && stateMatch && districtMatch && cityMatch) {
            this.classList.remove('hidden');
            visible++;
        } else {
            this.classList.add('hidden');
        }
    });

    $('#vendorCount').text(visible);
}


// $('#stateSelect').on('change', function () {

//     let stateId = this.value;

//     $('#regionSelect')
//         .prop('disabled', true)
//         .html('<option value="">Loading regions...</option>');

//     $('#citySelect')
//         .prop('disabled', true)
//         .html('<option value="">Select City</option>');

//     if (!stateId) {
//         applyFilters();
//         return;
//     }

//     $.get(`/locations/regions/${stateId}`, function (regions) {

//         let options = '<option value="">Select Region</option>';
//         regions.forEach(r => {
//             options += `<option value="${r.id}">${r.name}</option>`;
//         });

//         $('#regionSelect')
//             .html(options)
//             .prop('disabled', false);

//         applyFilters();
//     });
// });
// $('#regionSelect').on('change', function () {

//     let regionId = this.value;

//     $('#citySelect')
//         .prop('disabled', true)
//         .html('<option value="">Loading cities...</option>');

//     if (!regionId) {
//         applyFilters();
//         return;
//     }

//     $.get(`/locations/cities/${regionId}`, function (cities) {

//         let options = '<option value="">Select City</option>';
//         cities.forEach(c => {
//             options += `<option value="${c.id}">${c.name}</option>`;
//         });

//         $('#citySelect')
//             .html(options)
//             .prop('disabled', false);

//         applyFilters();
//     });
// });
$('#stateSelect').on('change', function () {

    let stateId = this.value;

    $('#regionSelect')
        .prop('disabled', true)
        .html('<option value="">Loading districts...</option>');

    $('#citySelect')
        .prop('disabled', true)
        .html('<option value="">Select City</option>');

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

<script>
   function requireLogin(callback) {
    if (!window.VENDOR_ID) {
        new bootstrap.Modal(document.getElementById('authModal')).show();
        return false;
    }
    callback();
}

function viewProfile(id) {
   if (!window.VENDOR_ID) {
        new bootstrap.Modal(document.getElementById('authModal')).show();
        return;
    }
    window.location.href = "{{ url('vendor/profile/id') }}/" + id;
}
</script>

@endsection