@extends('layouts.suppliersapp')
@section('title','Supplier Registration | ConstructKaro')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
   :root{
   --navy:#1c2c3e;
   --orange:#f25c05;
   --bg:#f5f7fb;
   --line:#e6ebf2;
   }
   body{
   background:linear-gradient(180deg,#f8fbff,#eef2f9);
   }
   .page{
   max-width:1200px;
   margin:24px auto 90px;
   }
   .cardx{
   background:#fff;
   border:1px solid var(--line);
   border-radius:16px;
   padding:20px;
   box-shadow:0 8px 30px rgba(0,0,0,.06);
   }
   .nav-pills{
   background:#fff;
   padding:10px;
   border-radius:50px;
   box-shadow:0 8px 30px rgba(0,0,0,.06);
   }
   .nav-pills .nav-link{
   border-radius:40px;
   font-weight:600;
   padding:10px 22px;
   }
   .nav-pills .nav-link.active{
   background:var(--orange);
   color:#fff;
   }
   .form-label{
   font-weight:600;
   }
   .save-bar{
   position:sticky;
   bottom:0;
   background:#fff;
   padding:16px;
   border-top:1px solid var(--line);
   box-shadow:0 -8px 25px rgba(0,0,0,.08);
   }
   .save-btn{
   background:#f25c05;
   color:#fff;
   border:none;
   border-radius:40px;
   padding:14px 50px;
   font-weight:700;
   }
</style>
@php
/*
|-------------------------------------------------------------
| SAFE DATA HANDLING (FIXES in_array ERROR)
|-------------------------------------------------------------
*/
// Categories (can be JSON / comma string / null)
$rawCategories = $supplier->categories_json ?? '[]';
$savedCategories = [];
if (is_string($rawCategories)) {
$decoded = json_decode($rawCategories, true);
if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
$savedCategories = $decoded;
} else {
$savedCategories = array_filter(explode(',', $rawCategories));
}
}
// Category Notes
$rawNotes = $supplier->category_notes_json ?? '{}';
$savedNotes = json_decode($rawNotes, true);
if (!is_array($savedNotes)) {
$savedNotes = [];
}
@endphp
<div class="page">
   <h4 class="mb-3">🧾 Supplier Registration</h4>
   <ul class="nav nav-pills gap-2 mb-4">
      <li class="nav-item"><button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-basic">Basic</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-business">Business</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-uploads">Uploads</button></li>
      <li class="nav-item"><button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-bank">Bank</button></li>
   </ul>
   <form method="POST" action="{{ route('supplier.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="tab-content">
         {{-- ================= BASIC ================= --}}
         <div class="tab-pane fade show active" id="tab-basic">
            <div class="cardx">
               <div class="row g-3">
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
                                 {{ $supplier->state_id == $state->id ? 'selected' : '' }}>
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

               </div>
            </div>
         </div>
         {{-- ================= BUSINESS ================= --}}
   
         <div class="tab-pane fade" id="tab-business">
            <div class="cardx">
               <div class="row g-3">

                     

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

                     {{-- Credit Days --}}
                     <div class="col-md-6">
                        <label class="form-label">Credit Period (Days)</label>
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

                     {{-- Open Time --}}
                     <div class="col-md-6">
                        <label class="form-label">
                           Business Open Time 
                        </label>
                        <input type="time"
                              name="open_time"
                              class="form-control"
                              value="{{ old('open_time', $supplier->open_time ?? '') }}"
                              >
                     </div>

                     {{-- Close Time --}}
                     <div class="col-md-6">
                        <label class="form-label">
                           Business Close Time 
                        </label>
                        <input type="time"
                              name="close_time"
                              class="form-control"
                              value="{{ old('close_time', $supplier->close_time ?? '') }}"
                              >
                     </div>

                     {{-- Delivery Type --}}
                     <div class="col-md-6">
                        <label class="form-label">
                           Delivery Type 
                        </label>
                        <select name="delivery_type" class="form-select" >
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
                        <label class="form-label">Delivery Time (in Days)</label>
                        <input type="number"
                              name="delivery_days"
                              class="form-control"
                              value="{{ old('delivery_days', $supplier->delivery_days ?? '') }}"
                              placeholder="e.g. 2">
                     </div>

                     {{-- Minimum Order Cost --}}
                     <div class="col-md-6">
                        <label class="form-label">Minimum Order Cost (₹)</label>
                        <input type="number"
                              name="minimum_order_cost"
                              class="form-control"
                              value="{{ old('minimum_order_cost', $supplier->minimum_order_cost ?? '') }}"
                              placeholder="e.g. 5000">
                     </div>

                     {{-- Maximum Delivery Distance --}}
                     <div class="col-md-6">
                        <label class="form-label">Maximum Delivery Distance (KM)</label>
                        <select name="maximum_distance" class="form-select">
                           <option value="">Select Delivery Distance</option>
                           @foreach ($maximum_distances as $maximum_distance)
                                 <option value="{{ $maximum_distance->id }}"
                                    {{ old('maximum_distance', $supplier->maximum_distance ?? '') == $maximum_distance->id ? 'selected' : '' }}>
                                    {{ $maximum_distance->distance_km }} KM
                                 </option>
                           @endforeach
                        </select>
                     </div>

               </div>
            </div>
         </div>

         {{-- ================= UPLOADS ================= --}}
         <div class="tab-pane fade" id="tab-uploads">
            <div class="cardx">
               <div class="row g-3">
               {{-- GST Certificate --}}
               <!-- <div class="col-md-6">
                     <label class="form-label fw-semibold">
                        GST Certificate 
                     </label>

                     @if(!empty($supplier?->gst_certificate_path))
                        <div class="mb-2">
                           <a href="{{ asset($supplier->gst_certificate_path) }}" target="_blank"
                              class="badge bg-success text-decoration-none">
                                 View GST Certificate
                           </a>
                        </div>
                     @endif

                     <input type="file" name="gst_certificate" class="form-control">
               </div> -->
               <div class="col-md-6">
                  <label class="form-label fw-semibold">
                     GST Certificate 
                  </label>

                  @if(!empty($supplier->gst_certificate_path))
                     <div class="mb-2 d-flex gap-2">
                           <a href="{{ asset($supplier->gst_certificate_path) }}"
                              target="_blank"
                              class="badge bg-success text-decoration-none">
                              View
                           </a>

                           <a href="{{ asset($supplier->gst_certificate_path) }}"
                              download
                              class="badge bg-primary text-decoration-none">
                              Download
                           </a>
                     </div>
                  @endif

                  <input type="file" name="gst_certificate" class="form-control">
               </div>



               {{-- PAN Card --}}
              
               <div class="col-md-6">
                  <label class="form-label fw-semibold">
                     PAN Card 
                  </label>

                  @if(!empty($supplier->pan_card_path))
                     <div class="mb-2 d-flex gap-2">
                           <a href="{{ asset($supplier->pan_card_path) }}" target="_blank"
                              class="badge bg-success text-decoration-none">View</a>

                           <a href="{{ asset($supplier->pan_card_path) }}" download
                              class="badge bg-primary text-decoration-none">Download</a>
                     </div>
                  @endif

                  <input type="file" name="pan_card" class="form-control">
               </div>



               {{-- Shop License --}}
            
               <div class="col-md-6">
                  <label class="form-label fw-semibold">
                     Shop License / Registration
                  </label>

                  @if(!empty($supplier->shop_license_path))
                     <div class="mb-2 d-flex gap-2">
                           <a href="{{ asset($supplier->shop_license_path) }}" target="_blank"
                              class="badge bg-success">View</a>

                           <a href="{{ asset($supplier->shop_license_path) }}" download
                              class="badge bg-primary">Download</a>
                     </div>
                  @endif

                  <input type="file" name="shop_license" class="form-control">
               </div>


               {{-- Sample Invoice --}}
            
               <div class="col-md-6">
                  <label class="form-label fw-semibold">
                     Sample Invoice
                  </label>

                  @if(!empty($supplier->sample_invoice_path))
                     <div class="mb-2 d-flex gap-2">
                           <a href="{{ asset($supplier->sample_invoice_path) }}" target="_blank"
                              class="badge bg-success">View</a>

                           <a href="{{ asset($supplier->sample_invoice_path) }}" download
                              class="badge bg-primary">Download</a>
                     </div>
                  @endif

                  <input type="file" name="sample_invoice" class="form-control">
               </div>


               {{-- Costing Sheet --}}
              
               <div class="col-md-6">
                  <label class="form-label fw-semibold">
                     Costing Sheet
                  </label>

                  @if(!empty($supplier->costing_sheet_path))
                     <div class="mb-2 d-flex gap-2">
                           <a href="{{ asset($supplier->costing_sheet_path) }}" target="_blank"
                              class="badge bg-success">View</a>

                           <a href="{{ asset($supplier->costing_sheet_path) }}" download
                              class="badge bg-primary">Download</a>
                     </div>
                  @endif

                  <input type="file" name="costing_sheet" class="form-control">
               </div>

               </div>
            </div>
         </div>

         {{-- ================= BANK ================= --}}
       
         <div class="tab-pane fade" id="tab-bank">
            <div class="cardx">
               <div class="row g-3">

                     {{-- Account Holder --}}
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

      </div>
      <br>
      <div class="text-center">
         <button type="submit" class="save-btn">
         💾 Save Supplier Profile
         </button>
      </div>
   </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   $('.select2').select2();
</script>

<script>
    const SAVED_STATE  = "{{ $supplier->state_id ?? '' }}";
    const SAVED_REGION = "{{ $supplier->region_id ?? '' }}";
    const SAVED_CITY   = "{{ $supplier->city_id ?? '' }}";
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
    document.addEventListener('DOMContentLoaded', function () {
        const msmeSelect = document.getElementById('msme_status');
        const msmeDiv = document.getElementById('msme_number_div');

        function toggleMsmeField() {
            if (msmeSelect.value === 'yes') {
                msmeDiv.style.display = 'block';
            } else {
                msmeDiv.style.display = 'none';
            }
        }

        // Run on load (for edit form)
        toggleMsmeField();

        // Run on change
        msmeSelect.addEventListener('change', toggleMsmeField);
    });
</script>

@endsection