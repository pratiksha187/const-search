@extends('layouts.suppliersapp')

@section('title','Supplier Registration | ConstructKaro')

@section('content')

{{-- ================= STYLES & LIBS ================= --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --line:#e6ebf2;
}

/* PAGE */
body{
    background:linear-gradient(180deg,#f8fbff,#eef2f9);
}

.page{
    max-width:1202px;
    margin:87px auto 90px;
}

/* HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding-bottom:14px;
    border-bottom:1px solid var(--line);
}

/* CARD */
.cardx{
    background:#fff;
    border-radius:20px;
    padding:26px;
    margin-bottom:24px;
    box-shadow:0 20px 45px rgba(15,23,42,.08);
}

/* FORM */
.form-control,
.form-select{
    border-radius:12px;
    padding:12px 14px;
    border:1px solid #e5e7eb;
}

.form-control:focus,
.form-select:focus{
    border-color:var(--orange);
    box-shadow:0 0 0 3px rgba(242,92,5,.15);
}

/* PROGRESS */
.progress-wrapper{
    background:linear-gradient(135deg,#0f172a,#1e293b);
    border-radius:20px;
    padding:26px;
    color:#fff;
    margin-bottom:24px;
}

.progress{
    height:8px;
    background:rgba(255,255,255,.15);
    border-radius:999px;
    overflow:hidden;
}

.progress-bar{
    background:linear-gradient(90deg,#f59e0b,#f97316,#f25c05);
}

/* STEP CARDS */
.step-card{
    background:rgba(255,255,255,.12);
    border-radius:18px;
    padding:20px;
    height:100%;
    cursor:pointer;
    border:1px solid rgba(255,255,255,.15);
}

.step-card h6{
    margin:14px 0 4px;
    font-weight:700;
    font-size:15px;
}

.step-card p{
    margin:0;
    font-size:13px;
    opacity:.8;
}

.step-card.active{
    background:#fff;
    color:#111827;
    box-shadow:0 16px 40px rgba(0,0,0,.25);
}

.step-card.active p{
    color:#374151;
}

/* STEP BADGE */
.step-badge{
    width:34px;
    height:34px;
    border-radius:10px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:800;
    font-size:14px;
    color:#fff;
}

/* SAVE BAR */
.save-bar{
    position:sticky;
    bottom:0;
    background:#ffffff;
    padding:18px 24px;
    border-top:1px solid #e5e7eb;
    box-shadow:0 -14px 40px rgba(0,0,0,.15);
    z-index:99;
}

.save-btn{
    background:linear-gradient(135deg,#f25c05,#ea580c);
    padding:14px 56px;
    font-size:16px;
    color:#fff;
    border-radius:12px;
    border:none;
}

.save-btn:hover{
    transform:translateY(-2px);
}
</style>

@php
$materialIconMap = [
    'Cement & Concrete' => '🧱',
    'Steel & TMT Bars' => '🔩',
    'Aggregates / Sand' => '🪨',
    'Blocks / Bricks' => '🧱',
    'Electrical Items' => '⚡',
    'Plumbing Materials' => '🚰',
    'Road Safety Products' => '🚧',
    'Machineries & Equipments' => '⚙️',
    'Construction & Chemicals' => '🧪',
    'Paint & Coatings' => '🎨',
    'Tiles & Flooring' => '⬜',
    'Doors & Windows' => '🚪',
    'Glass & Glazing' => '🪟',
    'Hardware & Tools' => '🛠️',
    'Timber & Wood' => '🪵',
    'Roofing Materials' => '🏠',
    'Pavers & Kerbstones' => '🧱',
    'Concrete Products' => '🏗️',
    'HVAC & Utilities' => '❄️',
    'Ready Mix Concrete' => '🚚',
];
@endphp


{{-- ================= SAFE DATA HANDLING ================= --}}

<div class="page">
<div class="page-header mb-4">
    <div>
        <h3 class="fw-bold mb-1">Supplier Registration</h3>
        <p class="text-muted mb-0">
            Complete your profile to start receiving verified enquiries
        </p>
    </div>
</div>

<div class="progress-wrapper mb-4">
    <div class="d-flex justify-content-between mb-2">
        <strong>Registration Progress</strong>
        <span class="small">{{ $profileCompletion }}%</span>
    </div>

    <div class="progress mb-4" style="height:8px;">
        <div class="progress-bar bg-warning"
             role="progressbar"
             style="width: {{ $profileCompletion }}%;">
        </div>
    </div>

    <div class="row g-3">

        <div class="col-md-3">
            <div class="step-card {{ $profileSteps['basic'] ? 'active' : '' }}"
                 onclick="openTab('tab-basic')">
                <span class="step-badge bg-secondary">1</span>
                <h6>Basic Visibility</h6>
                <p>Appear in search</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="step-card {{ $profileSteps['material'] ? 'active' : '' }}"
                 onclick="openTab('tab-material')">
                <span class="step-badge bg-warning">2</span>
                <h6>Enquiry Enabled</h6>
                <p>Receive enquiries</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="step-card {{ $profileSteps['uploads'] ? 'active' : '' }}"
                 onclick="openTab('tab-uploads')">
                <span class="step-badge bg-success">3</span>
                <h6>Verified Supplier</h6>
                <p>Featured badge</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="step-card {{ $profileSteps['bank'] ? 'active' : '' }}"
                 onclick="openTab('tab-bank')">
                <span class="step-badge bg-info">4</span>
                <h6>Supplier Bank Details</h6>
                <p>Bank Details</p>
            </div>
        </div>

    </div>
</div>


{{-- ================= FORM ================= --}}
<form method="POST" action="{{ route('supplier.store') }}" enctype="multipart/form-data">
@csrf

<div class="tab-content">

{{-- ================= BASIC TAB ================= --}}
<div class="tab-pane fade show active" id="tab-basic">
      <div class="cardx">
        @php
         // Normalize $supplier->material_category to an array for checkbox selection
         $rawMaterialData = $supplier->material_category ?? null;
         if (is_null($rawMaterialData)) {
         $selectedMaterials = [];
         } elseif (is_array($rawMaterialData)) {
         // Already an array
         $selectedMaterials = $rawMaterialData;
         } else {
         // Attempt JSON decode
         $decoded = json_decode($rawMaterialData, true);
         if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
         $selectedMaterials = $decoded;
         } else {
         // Treat as single value (string or int)
         $selectedMaterials = [$rawMaterialData];
         }
         }
         @endphp
   
         <div class="row g-3">
            <div class="col-md-6">
               <label class="form-label">Shop Logo</label>
               <input type="file"
                  name="shop_logo"
                  class="form-control"
                  accept="image/*">
               @if(!empty($supplier->shop_logo))
               <img src="{{ asset('storage/supplier_logos/'.$supplier->shop_logo) }}"
                  height="70"
                  class="rounded border p-1">
               @endif
            </div>
            <div class="col-md-6">
               <label class="form-label">Shop Name</label>
               <input type="text" name="shop_name" class="form-control"
                  value="{{ old('shop_name',$supplier->shop_name ?? '') }}">
            </div>
            <div class="col-md-6">
               <label class="form-label">Owner/Contact Person</label>
               <input type="text" name="contact_person" class="form-control"
                  value="{{ old('contact_person',$supplier->contact_person ?? '') }}">
            </div>
            <div class="col-md-6">
               <label class="form-label">Phone Number</label>
               <input type="text" name="mobile" class="form-control"
                  value="{{ old('mobile',$supplier->mobile ?? '') }}">
            </div>
            <div class="col-md-6">
               <label class="form-label">WhatsApp</label>
               <input type="text" name="whatsapp" class="form-control"
                  value="{{ old('whatsapp',$supplier->whatsapp ?? '') }}">
            </div>
            <div class="col-md-6">
               <label class="form-label">Email</label>
               <input type="email" name="email" class="form-control"
                  value="{{ old('email',$supplier->email ?? '') }}">
            </div>
            <div class="col-md-6">
               <label class="form-label">State</label>
               <select id="stateSelect" name="state_id" class="form-select">
                  <option value="">Select State</option>
                  @foreach($states as $state)
                     <option value="{{ $state->id }}"
                           {{ isset($supplier) && $supplier->state_id == $state->id ? 'selected' : '' }}>
                           {{ $state->name }}
                     </option>
                  @endforeach
               </select>

            </div>
            <div class="col-md-6">
               <label for="region" class="form-label">Region</label>
               <select id="regionSelect" name="region_id" class="form-select form-select-custom" disabled>
                  <option value="">Select Region</option>
               </select>
            </div>
            <div class="col-md-6">
               <label for="region" class="form-label">City</label>
               <select id="citySelect" name="city_id" class="form-select form-select-custom" disabled>
                  <option value="">Select City</option>
               </select>
            </div>
            <div class="col-12">
               <label class="form-label">Shop Address</label>
               <textarea name="shop_address" class="form-control" rows="3">{{ old('shop_address',$supplier->shop_address ?? '') }}</textarea>
            </div>
            {{-- Years in Business --}}
            <div class="col-md-6">
               <label class="form-label">
               Years in Business 
               </label>
               <select name="years_in_business" class="form-select">
                  <option value="">Select Experience</option>
                  @foreach ($experience as $experiences)
                  <option value="{{ $experiences->id }}"
                  {{ old('years_in_business', $supplier->years_in_business ?? '') == $experiences->id ? 'selected' : '' }}>
                  {{ ucfirst($experiences->years) }}
                  </option>
                  @endforeach
               </select>
            </div>
            {{-- GST Number --}}
            <div class="col-md-6">
               <label class="form-label">
               GST Number 
               </label>
               <input type="text"
                  name="gst_number"
                  class="form-control"
                  maxlength="15"
                  value="{{ old('gst_number', $supplier->gst_number ?? '') }}"
                  placeholder="22AAAAA0000A1Z5"
                  >
            </div>
            {{-- PAN Number --}}
            <div class="col-md-6">
               <label class="form-label">
               PAN Number 
               </label>
               <input type="text"
                  name="pan_number"
                  class="form-control"
                  maxlength="10"
                  value="{{ old('pan_number', $supplier->pan_number ?? '') }}"
                  placeholder="ABCDE1234F"
                  >
            </div>
            <div class="col-md-6">
               <label class="form-label">MSME Registration</label>
               <select name="msme_status" id="msme_status" class="form-select">
                  <option value="">Select Status</option>
                  <option value="yes" {{ old('msme_status', $supplier->msme_status ?? '') == 'yes' ? 'selected' : '' }}>
                  Yes - Registered
                  </option>
                  <option value="no" {{ old('msme_status', $supplier->msme_status ?? '') == 'no' ? 'selected' : '' }}>
                  No - Not Registered
                  </option>
                  <option value="applied" {{ old('msme_status', $supplier->msme_status ?? '') == 'applied' ? 'selected' : '' }}>
                  Applied - Under Process
                  </option>
               </select>
            </div>
            <!-- MSME Number Field -->
            <div class="col-md-6 mt-2" id="msme_number_div" style="display: none;">
               <label class="form-label">MSME Registration Number</label>
               <input
                  type="text"
                  name="msme_number"
                  class="form-control"
                  placeholder="Enter MSME Registration Number"
                  value="{{ old('msme_number', $supplier->msme_number ?? '') }}"
                  >
            </div>
            {{-- Materials --}}
           
            <div class="col-md-12">
               <label class="form-label fw-bold">Materials Supplied</label>

               <div class="d-flex flex-wrap gap-3">
                  @foreach ($material_categories as $material_category)

                        @php
                           $icon = $materialIconMap[$material_category->name] ?? '📦';
                        @endphp

                        <label class="material-pill">
                           <input
                              type="checkbox"
                              name="material_category[]"
                              value="{{ $material_category->id }}"
                              {{ in_array($material_category->id, $selectedMaterials) ? 'checked' : '' }}
                           >

                           <span class="pill-content">
                              <span class="pill-icon">{{ $icon }}</span>
                              <span class="pill-text">{{ $material_category->name }}</span>
                           </span>
                        </label>

                  @endforeach
               </div>
            </div>

         </div>
      </div>
</div>

{{-- ================= MATERIAL TAB ================= --}}
<div class="tab-pane fade" id="tab-material">
      <div class="cardx">
          <div class="row g-3">
              
              
               {{-- Credit Days --}}
               <div class="col-md-6">
                  <label class="form-label  fw-bold">Credit Period (Days)</label>
                  <select name="credit_days" class="form-select">
                     <option value="">Select Credit Days</option>
                     @foreach ($credit_days as $credit_day)
                     <option value="{{ $credit_day->id }}"
                     {{ old('credit_days', $supplier->credit_days ?? '') == $credit_day->id ? 'selected' : '' }}>
                     {{ $credit_day->days }}
                     </option>
                     @endforeach
                  </select>
               </div>
               {{-- Business Open Time --}}
               <div class="col-md-6">
                  <label class="form-label  fw-bold">Business Open Time</label>
                  <input
                     type="time"
                     name="open_time"
                     class="form-control"
                     value="{{ old('open_time', $supplier->open_time ?? '') }}"
                     >
               </div>
               {{-- Business Close Time --}}
               <div class="col-md-6">
                  <label class="form-label  fw-bold">Business Close Time</label>
                  <input
                     type="time"
                     name="close_time"
                     class="form-control"
                     value="{{ old('close_time', $supplier->close_time ?? '') }}"
                     >
               </div>
               {{-- Delivery Type --}}
               <div class="col-md-6">
                  <label class="form-label  fw-bold">Delivery Type</label>
                  <select name="delivery_type" class="form-select">
                     <option value="">Select Delivery Type</option>
                     @foreach ($delivery_type as $dtype)
                     <option value="{{ $dtype->id }}"
                     {{ old('delivery_type', $supplier->delivery_type ?? '') == $dtype->id ? 'selected' : '' }}>
                     {{ ucfirst($dtype->type) }}
                     </option>
                     @endforeach
                  </select>
               </div>
               {{-- Delivery Days --}}
               <div class="col-md-6">
                  <label class="form-label  fw-bold">Delivery Time (in Days)</label>
                  <input
                     type="number"
                     name="delivery_days"
                     class="form-control"
                     value="{{ old('delivery_days', $supplier->delivery_days ?? '') }}"
                     placeholder="e.g. 2"
                     >
               </div>
               {{-- Minimum Order Cost --}}
               <div class="col-md-6">
                  <label class="form-label  fw-bold">Minimum Order Cost (₹)</label>
                  <input
                     type="number"
                     name="minimum_order_cost"
                     class="form-control"
                     value="{{ old('minimum_order_cost', $supplier->minimum_order_cost ?? '') }}"
                     placeholder="e.g. 5000"
                     >
               </div>
               {{-- Maximum Delivery Distance --}}
               <div class="col-md-6">
                  <label class="form-label  fw-bold">Maximum Delivery Distance (KM)</label>
                  <select name="maximum_distance" class="form-select">
                     <option value="">Select Delivery Distance</option>
                     @foreach ($maximum_distances as $maximum_distance)
                     <option value="{{ $maximum_distance->id }}"
                     {{ old('maximum_distance', $supplier->maximum_distance ?? '') == $maximum_distance->id ? 'selected' : '' }}>
                     {{ $maximum_distance->distance_km }}
                     </option>
                     @endforeach
                  </select>
               </div>
         </div>
      </div>
      {{-- ================= ADDED PRODUCTS TABLE ================= --}}


</div>


        {{-- ================= UPLOADS TAB ================= --}}
<div class="tab-pane fade" id="tab-uploads">
    <div class="cardx">
        <div class="row g-4">

            <div class="col-md-6">
                <label class="form-label fw-semibold">GST Certificate</label>
                @if(!empty($supplier->gst_certificate_path))
                    <div class="mb-2 d-flex gap-2">
                        <a href="{{ asset($supplier->gst_certificate_path) }}" target="_blank" class="badge bg-success">View</a>
                        <a href="{{ asset($supplier->gst_certificate_path) }}" download class="badge bg-primary">Download</a>
                    </div>
                @endif
                <input type="file" name="gst_certificate" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">PAN Card</label>
                @if(!empty($supplier->pan_card_path))
                    <div class="mb-2 d-flex gap-2">
                        <a href="{{ asset($supplier->pan_card_path) }}" target="_blank" class="badge bg-success">View</a>
                        <a href="{{ asset($supplier->pan_card_path) }}" download class="badge bg-primary">Download</a>
                    </div>
                @endif
                <input type="file" name="pan_card" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Shop License / Registration</label>
                @if(!empty($supplier->shop_license_path))
                    <div class="mb-2 d-flex gap-2">
                        <a href="{{ asset($supplier->shop_license_path) }}" target="_blank" class="badge bg-success">View</a>
                        <a href="{{ asset($supplier->shop_license_path) }}" download class="badge bg-primary">Download</a>
                    </div>
                @endif
                <input type="file" name="shop_license" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Sample Invoice</label>
                @if(!empty($supplier->sample_invoice_path))
                    <div class="mb-2 d-flex gap-2">
                        <a href="{{ asset($supplier->sample_invoice_path) }}" target="_blank" class="badge bg-success">View</a>
                        <a href="{{ asset($supplier->sample_invoice_path) }}" download class="badge bg-primary">Download</a>
                    </div>
                @endif
                <input type="file" name="sample_invoice" class="form-control">
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Costing Sheet</label>
                @if(!empty($supplier->costing_sheet_path))
                    <div class="mb-2 d-flex gap-2">
                        <a href="{{ asset($supplier->costing_sheet_path) }}" target="_blank" class="badge bg-success">View</a>
                        <a href="{{ asset($supplier->costing_sheet_path) }}" download class="badge bg-primary">Download</a>
                    </div>
                @endif
                <input type="file" name="costing_sheet" class="form-control">
            </div>

        </div>
    </div>
</div>

      

{{-- ================= BANK TAB ================= --}}
<div class="tab-pane fade" id="tab-bank">
    <div class="cardx">
      <div class="row g-4">
        <div class="col-md-6">
                  <label class="form-label fw-semibold">
                  Account Holder Name 
                  </label>
                  <input type="text"
                     name="account_holder"
                     class="form-control"
                     value="{{ old('account_holder',$supplier->account_holder ?? '') }}"
                     placeholder="Account Holder">
               </div>
               {{-- Bank Name --}}
               <div class="col-md-6">
                  <label class="form-label fw-semibold">
                  Bank Name 
                  </label>
                  <input type="text"
                     name="bank_name"
                     class="form-control"
                     value="{{ old('bank_name',$supplier->bank_name ?? '') }}"
                     placeholder="Bank Name">
               </div>
               {{-- Account Number --}}
               <div class="col-md-6">
                  <label class="form-label fw-semibold">
                  Account Number 
                  </label>
                  <input type="text"
                     name="account_number"
                     class="form-control"
                     value="{{ old('account_number',$supplier->account_number ?? '') }}"
                     placeholder="Account Number">
               </div>
               {{-- IFSC Code --}}
               <div class="col-md-6">
                  <label class="form-label fw-semibold">
                  IFSC Code 
                  </label>
                  <input type="text"
                     name="ifsc_code"
                     class="form-control"
                     value="{{ old('ifsc_code',$supplier->ifsc_code ?? '') }}"
                     placeholder="IFSC Code">
               </div>

    </div>
    </div>
</div>
{{-- ================= SAVE BUTTON ================= --}}
<div class="save-bar text-end">
    <button type="submit" class="save-btn">💾 Save Supplier Profile</button>
</div>
</form>
</div>



{{-- ================= SCRIPTS ================= --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$('.select2').select2();
</script>
<script>
const SAVED_STATE = "{{ isset($supplier) ? $supplier->state_id : '' }}";
const SAVED_REGION = "{{ isset($supplier) ? $supplier->region_id : '' }}";
const SAVED_CITY = "{{ isset($supplier) ? $supplier->city_id : '' }}";
</script>

<script>
   $(document).ready(function () {
   
       // 🔹 If editing & state exists → auto load regions
       if (SAVED_STATE) {
           loadRegions(SAVED_STATE);
       }
   
       $('#stateSelect').on('change', function () {
           let stateId = $(this).val();
           loadRegions(stateId);
       });
   
       $('#regionSelect').on('change', function () {
           let regionId = $(this).val();
           loadCities(regionId);
       });
   
       function loadRegions(stateId) {
   
           $('#regionSelect').html('<option>Loading...</option>').prop('disabled', true);
           $('#citySelect').html('<option>Select City</option>').prop('disabled', true);
   
           if (!stateId) return;
   
           $.get('/locations/regions/' + stateId, function (regions) {
   
               let options = '<option value="">Select Region</option>';
               regions.forEach(r => {
                   options += `<option value="${r.id}">${r.name}</option>`;
               });
   
               $('#regionSelect').html(options).prop('disabled', false);
   
               // ✅ Auto select saved region
               if (SAVED_REGION) {
                   $('#regionSelect').val(SAVED_REGION);
                   loadCities(SAVED_REGION);
               }
           });
       }
   
       function loadCities(regionId) {
   
           $('#citySelect').html('<option>Loading...</option>').prop('disabled', true);
   
           if (!regionId) return;
   
           $.get('/locations/cities/' + regionId, function (cities) {
   
               let options = '<option value="">Select City</option>';
               cities.forEach(c => {
                   options += `<option value="${c.id}">${c.name}</option>`;
               });
   
               $('#citySelect').html(options).prop('disabled', false);
   
               // ✅ Auto select saved city
               if (SAVED_CITY) {
                   $('#citySelect').val(SAVED_CITY);
               }
           });
       }
   
   });
</script>
<script>
function openTab(id){
    document.querySelectorAll('.tab-pane').forEach(p=>p.classList.remove('show','active'));
    document.getElementById(id).classList.add('show','active');
    document.getElementById(id).scrollIntoView({behavior:'smooth'});
}
</script>


@endsection
