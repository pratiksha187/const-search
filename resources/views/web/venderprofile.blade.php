@extends('layouts.vendorapp') @section('title', 'Vendor Profile') @section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<style>
   :root{
   --navy:#1c2c3e;
   --orange:#f25c05;
   --border:#e5e7eb;
   --muted:#64748b;
   --bg:#f4f6fb;
   }
   /* WRAPPER */
   .profile-wrapper {
   max-width: 1599px;
   margin: auto;
   }
   /* HEADER CARD */
   .profile-header{
   background:#fff;
   border-radius:18px;
   padding:26px 30px;
   border:1px solid var(--border);
   box-shadow:0 12px 30px rgba(15,23,42,.08);
   display:flex;
   align-items:center;
   justify-content:space-between;
   margin-bottom:28px;
   }
   .profile-info{
   display:flex;
   gap:18px;
   align-items:center;
   }
   .status-badge{
   background:#dcfce7;
   color:#166534;
   padding:6px 14px;
   border-radius:999px;
   font-size:13px;
   font-weight:700;
   }
   /* TABS */
   .profile-tabs{
   background:#fff;
   border-radius:16px;
   padding:14px;
   border:1px solid var(--border);
   display:flex;
   gap:10px;
   margin-bottom:22px;
   }
   .profile-tabs .nav-link{
   border-radius:10px;
   font-weight:700;
   color:var(--navy);
   }
   .profile-tabs .nav-link.active{
   background:var(--orange);
   color:#fff;
   }
   /* CARD */
   .profile-card{
   background:#fff;
   border-radius:18px;
   padding:26px;
   border:1px solid var(--border);
   box-shadow:0 10px 26px rgba(15,23,42,.06);
   }
   /* ROW */
   .detail-row{
   display:flex;
   justify-content:space-between;
   align-items:center;
   padding:14px 0;
   border-bottom:1px dashed var(--border);
   }
   .detail-row:last-child{border-bottom:none;}
   .detail-label{
   color:var(--muted);
   font-size:14px;
   }
   .detail-value{
   font-weight:700;
   color:var(--navy);
   }
   /* INLINE FORM */
   .inline-form{
   display:flex;
   gap:8px;
   }
   .inline-form input{
   max-width:220px;
   }
   /* PROGRESS */
   .progress{
   height:10px;
   border-radius:999px;
   }
   .progress-bar{
   background:linear-gradient(135deg,#ff9a3c,#f25c05);
   }
   /* MOBILE */
   @media(max-width:768px){
   .detail-row{
   flex-direction:column;
   align-items:flex-start;
   gap:6px;
   }
   }
   h4, h5 { font-weight: 700; background: linear-gradient(90deg, #2949e9ff, #1c2c3e); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
   .form-label { font-weight: 600; color: #1b2a3d; }
   .form-control, .form-select { border-radius: 8px; border: 1px solid #ced4da; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
   .form-control:focus, .form-select:focus { border-color: #f47c1c; box-shadow: 0 0 0 0.2rem rgba(244,124,28,0.25); }
   .form-section { background:#fff; border:1px solid #e3e6ea; border-left:5px solid #f47c1c; padding:1.5rem; margin-bottom:2rem; border-radius:12px; }
   .btn-primary { background-color:#f47c1c; border:none; font-weight:600; padding:12px 24px; border-radius:8px; transition:.3s; }
   .btn-primary:hover { background-color:#e86e12; }
   .progress { height: 10px; }
   .progress + .progress { margin-top: .5rem; }
   input[type="file"] { padding: 6px; border-radius: 6px; }

   /* ===== BASIC INFO GRID LOOK ===== */
.info-box {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 14px 16px;
    height: 100%;
    transition: all 0.25s ease;
}

.info-box:hover {
    border-color: var(--orange);
    box-shadow: 0 6px 18px rgba(242, 92, 5, 0.08);
    transform: translateY(-2px);
}

.info-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--muted);
    margin-bottom: 6px;
}

.info-value {
    font-size: 15px;
    font-weight: 700;
    color: var(--navy);
}

.inline-form {
    display: flex;
    gap: 6px;
}

.inline-form input {
    font-size: 13px;
    height: 34px;
}

.inline-form button {
    height: 34px;
    padding: 0 12px;
    font-size: 13px;
    font-weight: 600;
}

@media(max-width: 768px) {
    .info-box {
        padding: 12px;
    }
}

/* ===== BUSINESS TAB DESIGN ===== */
.business-card {
    background: #ffffff;
    border-radius: 18px;
    padding: 26px;
    border: 1px solid var(--border);
    box-shadow: 0 10px 26px rgba(15,23,42,.06);
}

.business-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 18px;
}

.business-title {
    font-size: 18px;
    font-weight: 800;
    color: var(--navy);
}

.business-subtitle {
    font-size: 13px;
    color: var(--muted);
}

.select-wrapper {
    background: #f9fafb;
    padding: 14px;
    border-radius: 14px;
    border: 1px solid var(--border);
}

.project-type-box {
    background: #f9fafb;
    padding: 16px;
    border-radius: 14px;
    border: 1px solid var(--border);
}

.project-type-box label {
    font-size: 14px;
    font-weight: 700;
    color: var(--navy);
}

#workSubtypeCheckboxes label {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    padding: 10px 14px;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s ease;
}

#workSubtypeCheckboxes label:hover {
    border-color: var(--orange);
    background: #fff7f1;
}

#workSubtypeCheckboxes input[type="checkbox"] {
    margin-right: 8px;
    accent-color: var(--orange);
}

@media(max-width:768px){
    .business-card {
        padding: 18px;
    }
}

.project-type-card {
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    padding: 14px 16px;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
    transition: all .2s ease;
    background: #fff;
}

.project-type-card:hover {
    border-color: #f25c05;
    background: #fff7f1;
}
</style>

<form method="POST"
      action="{{ route('vendor.profile.update') }}"
      enctype="multipart/form-data">
@csrf

@php
  // ✅ if you store region as JSON in DB
  $savedRegions = [];
  if(!empty($vendor->region)){
      $decoded = json_decode($vendor->region, true);
      $savedRegions = is_array($decoded) ? $decoded : [];
  }

  // ✅ if you store selected subtypes somewhere (example: JSON or comma)
  // Adjust this according to your DB structure:
  $savedSubtypes = [];
  if(!empty($vendor->work_subtype_id)){
      $decodedSub = json_decode($vendor->work_subtype_id, true);
      $savedSubtypes = is_array($decodedSub) ? $decodedSub : (is_string($vendor->work_subtype_id) ? explode(',', $vendor->work_subtype_id) : []);
  }
@endphp

<div class="profile-wrapper">
   {{-- TABS --}}
  <ul class="nav nav-pills profile-tabs" role="tablist">
    <li class="nav-item">
        <button type="button" class="nav-link active"
                data-bs-toggle="pill"
                data-bs-target="#basicTab">
            Basic Information
        </button>
    </li>

    <li class="nav-item">
        <button type="button" class="nav-link"
                data-bs-toggle="pill"
                data-bs-target="#businessTab">
            Business Details
        </button>
    </li>

    <li class="nav-item">
        <button type="button" class="nav-link"
                data-bs-toggle="pill"
                data-bs-target="#completionTab">
            Profile Completion
        </button>
    </li>

    <li class="nav-item">
        <button type="button" class="nav-link"
                data-bs-toggle="pill"
                data-bs-target="#bankdetailsTab">
            Bank Details
        </button>
    </li>

    <li class="nav-item">
        <button type="button" class="nav-link"
                data-bs-toggle="pill"
                data-bs-target="#requireddocumentsTab">
            Required Documents
        </button>
    </li>
</ul>


   {{-- TAB CONTENT --}}
   <div class="tab-content">

      {{-- BASIC INFO --}}
      <div class="tab-pane fade show active form-section" id="basicTab">
          <div class="profile-card">
              <div class="row g-4">

                  {{-- FULL NAME --}}
                  <div class="col-md-4">
                      <div class="info-box">
                          <div class="info-label">Full Name</div>
                          <div class="info-value">{{ $vendor->name }}</div>
                      </div>
                  </div>

                  {{-- ✅ MOBILE (FIXED: single-form field) --}}
                  <div class="col-md-4">
                      <div class="info-box">
                          <div class="info-label">Mobile</div>
                          <input type="text"
                                 name="mobile"
                                 class="form-control form-control-sm"
                                 value="{{ $vendor->mobile }}"
                                 placeholder="Add mobile">
                      </div>
                  </div>

                  {{-- ✅ EMAIL (FIXED) --}}
                  <div class="col-md-4">
                      <div class="info-box">
                          <div class="info-label">Email</div>
                          <input type="email"
                                 name="email"
                                 class="form-control form-control-sm"
                                 value="{{ $vendor->email }}"
                                 placeholder="Add email">
                      </div>
                  </div>

                  {{-- ✅ BUSINESS NAME (FIXED) --}}
                  <div class="col-md-4">
                      <div class="info-box">
                          <div class="info-label">Business Name</div>
                          <input type="text"
                                 name="business_name"
                                 class="form-control form-control-sm"
                                 value="{{ $vendor->business_name }}"
                                 placeholder="Business name">
                      </div>
                  </div>

                  {{-- ✅ GST NUMBER (FIXED) --}}
                  <div class="col-md-4">
                      <div class="info-box">
                          <div class="info-label">GST Number</div>
                          <input type="text"
                                 id="gst_number"
                                 name="gst_number"
                                 class="form-control form-control-sm"
                                 value="{{ $vendor->gst_number }}"
                                 placeholder="GST number">
                          <div id="gst_error" style="color:red;display:none;">GST must be 15 characters.</div>
                      </div>
                  </div>

              </div>
          </div>
      </div>

      {{-- BUSINESS INFO --}}
      <div class="tab-pane fade" id="businessTab">
          <div class="profile-card form-section">

              <div class="mb-4">
                  <h5 class="fw-bold text-dark mb-1">Business & Work Details</h5>
                  <small class="text-muted">
                      Select your construction category and project expertise
                  </small>
              </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">
                        Find Your Construction Vendor <span class="text-danger">*</span>
                    </label>

                    {{-- ✅ preselect work_type --}}
                    <select id="work_type" name="work_type_id" class="form-select select2">
                        <option value="">Select Construction Type</option>
                        @foreach($workTypes as $type)
                            <option value="{{ $type->id }}" {{ (string)$vendor->work_type_id === (string)$type->id ? 'selected' : '' }}>
                                {{ $type->work_type }}
                            </option>
                        @endforeach
                    </select>
                </div>

              <hr class="my-4">

              <div class="mb-3">
                  <label class="form-label fw-semibold">
                      Project Type <span class="text-danger">*</span>
                  </label>
                  <small class="text-muted d-block mb-3">
                      Select all project types you have experience in
                  </small>

                  <div id="workSubtypeCheckboxes" class="row g-3">
                      <!-- Dynamically injected checkboxes -->
                  </div>
              </div>

          </div>
      </div>

      {{-- PROFILE COMPLETION --}}
      <div class="tab-pane fade" id="completionTab">
          <div class="profile-card">
              <div class="form-wrapper">

                  <div class="form-section">
                      <h5>Basic Business Information</h5>

                      <div class="row mb-3">
                          <div class="col-md-6">
                              <label class="form-label">Years of Experience *</label>
                              <select id="experience_years" name="experience_years" class="form-select">
                                  <option value="">-- Select --</option>
                                  @foreach ($experience_years as $years)
                                      <option value="{{ $years->id }}" {{ (string)$vendor->experience_years === (string)$years->id ? 'selected' : '' }}>
                                          {{ $years->experiance }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>

                          <div class="col-md-6">
                              <label class="form-label">Team Size *</label>
                              <select id="team_size" name="team_size" class="form-select">
                                  <option value="">-- Select --</option>
                                  @foreach ($team_size as $size)
                                      <option value="{{ $size->id }}" {{ (string)$vendor->team_size === (string)$size->id ? 'selected' : '' }}>
                                          {{ $size->team_size }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                      </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="state" class="form-label">State</label>
                                <select id="stateSelect" name="state" class="form-select form-select-custom">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ isset($vendor->state) && $vendor->state == $state->id ? 'selected' : '' }}>
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                              <label for="region" class="form-label">Region</label>
                               <select id="regionSelect" name="region" class="form-select form-select-custom" disabled>
                                <option value="">Select Region</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="region" class="form-label">City</label>
                                    <select id="citySelect" name="city" class="form-select form-select-custom" disabled>
                                <option value="">Select City</option>
                            </select>
                          </div>

                          <div class="col-md-6">
                              <label class="form-label">Accepting projects of minimum value (₹) *</label>
                              <input type="number"
                                     id="min_project_value"
                                     name="min_project_value"
                                     class="form-control"
                                     placeholder="₹ Minimum project value"
                                     value="{{ $vendor->min_project_value }}">
                              <div id="valueInWords" class="mt-2 text-muted"></div>
                          </div>
                      </div>
                  </div>

                  <hr>

                  <div class="form-section">
                      <h5>Company Details</h5>

                      <div class="row mb-3">
                          <div class="col-md-6">
                              <label class="form-label">Company Name *</label>
                              <input type="text" class="form-control" id="company_name" name="company_name" value="{{ $vendor->company_name }}">
                          </div>

                          <div class="col-md-6">
                              <label class="form-label">Type of Entity *</label>
                              <select id="entity_type" name="entity_type" class="form-select">
                                  <option value="">-- Select --</option>
                                  @foreach ($entity_type as $entity)
                                      <option value="{{ $entity->id }}" {{ (string)$vendor->entity_type === (string)$entity->id ? 'selected' : '' }}>
                                          {{ $entity->entity_type }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>

                          <div class="col-md-6 mt-3" id="aadhar_section" style="display: none;">
                              <label class="form-label">Aadhar Card No</label>
                              <input type="text" name="aadhar_card_no" id="aadhar_card_no" class="form-control" maxlength="12" placeholder="Enter Aadhar number" value="{{ $vendor->aadhar_card_no }}">
                              <div id="aadhar_error" style="color: red; display: none;">Please enter a valid 12-digit Aadhar number.</div>
                          </div>

                          <div class="col-md-6 mt-3" id="cin_section" style="display: none;">
                              <label class="form-label">CIN No</label>
                              <input type="text" name="cin_no" id="cin_no" class="form-control" placeholder="Enter CIN number" maxlength="21" style="text-transform: uppercase;" value="{{ $vendor->cin_no }}">
                              <div id="cin_error" style="color: red; display: none;">Please enter a valid 21-character CIN number.</div>
                          </div>

                          <div class="col-md-6 mt-3" id="llpin" style="display: none;">
                              <label class="form-label">LLPIN No</label>
                              <input type="text" name="llpin_no" id="llpin_no" class="form-control" placeholder="Enter LLPIN number" value="{{ $vendor->llpin_no }}">
                          </div>

                          <div class="col-md-6 mt-3" id="partnershipdeed" style="display: none;">
                              <label class="form-label">Partnership deed</label>
                              <input type="text" name="partnershipdeed_no" id="partnershipdeed_no" class="form-control" placeholder="Enter Partnership deed number" value="{{ $vendor->partnershipdeed_no }}">
                          </div>
                      </div>

                      <div class="mb-3">
                          <label class="form-label">Registered Office Address *</label>
                          <textarea class="form-control" id="registered_address" name="registered_address">{{ $vendor->registered_address }}</textarea>
                      </div>

                      <div class="row mb-3">
                          <div class="col-md-6">
                              <label class="form-label">Contact Person Designation *</label>
                              <input type="text" id="contact_person_designation" name="contact_person_designation" class="form-control" value="{{ $vendor->contact_person_designation }}">
                          </div>
                          <div class="col-md-6">
                              <label class="form-label">Contact Person Name </label>
                              <input type="text" id="contact_person_name" name="contact_person_name" class="form-control" value="{{ $vendor->contact_person_name }}">
                          </div>
                      </div>

                      <div class="row mb-3">
                          <div class="col-md-6">
                              <label class="form-label">PAN Number</label>
                              <input type="text" id="pan_number" name="pan_number" class="form-control" maxlength="10" style="text-transform: uppercase;" value="{{ $vendor->pan_number }}">
                              <div id="pan_error" style="color: red; display: none;">Please enter a valid PAN number.</div>
                          </div>
                          <div class="col-md-6">
                              <label class="form-label">TAN Number</label>
                              <input type="text" id="tan_number" name="tan_number" class="form-control" maxlength="10" style="text-transform: uppercase;" value="{{ $vendor->tan_number }}">
                              <div id="tan_error" style="color: red; display: none;">Please enter a valid TAN number (format: AAAA99999A).</div>
                          </div>
                      </div>

                      <div class="row mb-3">
                          <div class="col-md-6">
                              <label class="form-label">ESIC Number </label>
                              <input type="text" id="esic_number" name="esic_number" class="form-control" maxlength="17" style="text-transform: uppercase;" value="{{ $vendor->esic_number }}">
                              <div id="esic_error" style="color: red; display: none;">Please enter a valid 17-digit ESIC number.</div>
                          </div>
                          <div class="col-md-6">
                              <label class="form-label">PF No</label>
                              <input type="text" id="pf_code" name="pf_code" class="form-control" style="text-transform: uppercase;" value="{{ $vendor->pf_code }}">
                          </div>
                      </div>

                      <div class="row mb-3">
                          <div class="col-md-6">
                              <label class="form-label">MSME/Udyam Registered *</label>
                              <br>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="msme_registered" value="yes" onclick="toggleMsmeUpload()" {{ $vendor->msme_registered === 'yes' ? 'checked' : '' }}>
                                  <label class="form-check-label">Yes</label>
                              </div>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="radio" name="msme_registered" value="no" onclick="toggleMsmeUpload()" {{ $vendor->msme_registered === 'no' ? 'checked' : '' }}>
                                  <label class="form-check-label">No</label>
                              </div>
                              <div id="msmeUploadSection" style="display: none; margin-top: 10px;">
                                  <label for="msme_file" class="form-label">Upload MSME/Udyam Certificate:</label>
                                  <input type="file" id="msme_file" name="msme_file" class="form-control" accept="application/pdf">
                                  @if(!empty($vendor->msme_file))
                                      <a class="d-inline-block mt-2" target="_blank" href="{{ asset('storage/'.$vendor->msme_file) }}">View Uploaded MSME</a>
                                  @endif
                              </div>
                          </div>
                      </div>
                  </div>

                  <hr>
              </div>
          </div>
      </div>

      {{-- BANK DETAILS --}}
      <div class="tab-pane fade" id="bankdetailsTab">
          <div class="form-section">
              <h5>Bank Details</h5>

              <div class="row mb-3">
                  <div class="col-md-6">
                      <label class="form-label">Bank Name </label>
                      <input type="text" id="bank_name" name="bank_name" class="form-control" style="text-transform: uppercase;" value="{{ $vendor->bank_name }}">
                  </div>
                  <div class="col-md-6">
                      <label class="form-label">Account Number </label>
                      <input type="text" id="account_number" name="account_number" class="form-control" value="{{ $vendor->account_number }}">
                  </div>
              </div>

              <div class="row mb-3">
                  <div class="col-md-6">
                      <label class="form-label">IFSC Code </label>
                      <input type="text" id="ifsc_code" name="ifsc_code" class="form-control" style="text-transform: uppercase;" value="{{ $vendor->ifsc_code }}">
                  </div>
                  <div class="col-md-6">
                      <label class="form-label">Type of Account </label>
                      <select class="form-select" id="account_type" name="account_type">
                          <option value="">Select account type</option>
                          @foreach($account_type as $type)
                              <option value="{{ $type->id }}" {{ (string)$vendor->account_type === (string)$type->id ? 'selected' : '' }}>
                                  {{ $type->name }}
                              </option>
                          @endforeach
                      </select>
                  </div>
              </div>

              <div class="mb-3">
                  <label class="form-label">Upload Cancelled Cheque or Bank Passbook Copy <small class="text-muted">(PDF, max 20 MB)</small></label>
                  <input type="file" id="cancelled_cheque_file" name="cancelled_cheque_file" class="form-control" accept="application/pdf">
                  @if(!empty($vendor->cancelled_cheque_file))
                      <a class="d-inline-block mt-2" target="_blank" href="{{ asset('storage/'.$vendor->cancelled_cheque_file) }}">View Uploaded Cheque/Passbook</a>
                  @endif
              </div>
          </div>
      </div>

      {{-- REQUIRED DOCUMENTS --}}
      <div class="tab-pane fade" id="requireddocumentsTab">
          <div class="form-section">
              <h5>Required Documents</h5>

              <div class="row g-3">
                  <div class="col-md-6">
                      <label class="form-label required">PAN Card<small class="text-muted">(PDF, max 20 MB)</small></label>
                      <input accept="application/pdf" type="file" id="pan_card_file" name="pan_card_file" class="form-control">
                      @if(!empty($vendor->pan_card_file))
                          <a class="d-inline-block mt-2" target="_blank" href="{{ asset('storage/'.$vendor->pan_card_file) }}">View PAN</a>
                      @endif
                  </div>

                  <div class="col-md-6">
                      <label class="form-label required">GST Certificate<small class="text-muted">(PDF, max 20 MB)</small></label>
                      <input accept="application/pdf" type="file" id="gst_certificate_file" name="gst_certificate_file" class="form-control">
                      @if(!empty($vendor->gst_certificate_file))
                          <a class="d-inline-block mt-2" target="_blank" href="{{ asset('storage/'.$vendor->gst_certificate_file) }}">View GST</a>
                      @endif
                  </div>

                  <div class="col-md-6">
                      <label class="form-label required">Aadhaar Card (Authorised Person)<small class="text-muted">(PDF, max 20 MB)</small></label>
                      <input accept="application/pdf" type="file" id="aadhaar_card_file" name="aadhaar_card_file" class="form-control">
                      @if(!empty($vendor->aadhaar_card_file))
                          <a class="d-inline-block mt-2" target="_blank" href="{{ asset('storage/'.$vendor->aadhaar_card_file) }}">View Aadhaar</a>
                      @endif
                  </div>

                  <div class="col-md-6">
                      <label id="certificate_label" class="form-label required">
                      Certificate of Incorporation / LLPIN / SHOP ACT (For Proprietor)<small class="text-muted">(PDF, max 20 MB)</small>
                      </label>
                      <input accept="application/pdf" type="file" id="certificate_of_incorporation_file" name="certificate_of_incorporation_file" class="form-control" multiple>
                      <ul id="file_list" class="file-list"></ul>
                      @if(!empty($vendor->certificate_of_incorporation_file))
                          <a class="d-inline-block mt-2" target="_blank" href="{{ asset('storage/'.$vendor->certificate_of_incorporation_file) }}">View Certificate</a>
                      @endif
                  </div>

                  <div class="row">
                      <div class="col-12">
                          <label class="form-label fw-semibold">
                          Work Completion Certificate <span class="text-danger">(Add 3 Documents)</span>
                          <small class="text-muted">(PDF only, max 20 MB each)</small>
                          </label>
                      </div>
                      <div class="col-md-4">
                          <div class="input-group">
                              <span class="input-group-text bg-light fw-semibold">File 1</span>
                              <input type="file" id="work_completion_certificates_file1" name="work_completion_certificates_file1" class="form-control" accept="application/pdf">
                          </div>
                          <div id="file-error1" class="text-danger small mt-1" style="display:none;"></div>
                      </div>
                      <div class="col-md-4">
                          <div class="input-group">
                              <span class="input-group-text bg-light fw-semibold">File 2</span>
                              <input type="file" id="work_completion_certificates_file2" name="work_completion_certificates_file2" class="form-control" accept="application/pdf">
                          </div>
                          <div id="file-error2" class="text-danger small mt-1" style="display:none;"></div>
                      </div>
                      <div class="col-md-4">
                          <div class="input-group">
                              <span class="input-group-text bg-light fw-semibold">File 3</span>
                              <input type="file" id="work_completion_certificates_file3" name="work_completion_certificates_file3" class="form-control" accept="application/pdf">
                          </div>
                          <div id="file-error3" class="text-danger small mt-1" style="display:none;"></div>
                      </div>
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">PF Registration Documents<small class="text-muted">(PDF, max 20 MB)</small></label>
                      <input accept="application/pdf" type="file" id="pf_documents_file" name="pf_documents_file" class="form-control">
                      @if(!empty($vendor->pf_documents_file))
                          <a class="d-inline-block mt-2" target="_blank" href="{{ asset('storage/'.$vendor->pf_documents_file) }}">View PF Doc</a>
                      @endif
                  </div>

                  <div class="col-md-6">
                      <label class="form-label">ESIC Registration Documents<small class="text-muted">(PDF, max 20 MB)</small></label>
                      <input accept="application/pdf" type="file" id="esic_documents_file" name="esic_documents_file" class="form-control">
                      @if(!empty($vendor->esic_documents_file))
                          <a class="d-inline-block mt-2" target="_blank" href="{{ asset('storage/'.$vendor->esic_documents_file) }}">View ESIC Doc</a>
                      @endif
                  </div>

              </div>
          </div>
      </div>

   </div>

   {{-- ================== SAVE BUTTON ================== --}}
   <div class="text-end mt-4">
      <button class="btn btn-lg btn-success px-5">
         ✅ Update Profile
      </button>
   </div>

</div>
</form>

<!-- Bootstrap JS (REQUIRED FOR TABS) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- <script>
    const EXISTING_STATE  = "{{ $vendor->state ?? '' }}";
    const EXISTING_REGION = "{{ $vendor->region ?? '' }}";
    const EXISTING_CITY   = "{{ $vendor->city ?? '' }}";
</script> -->

<script>
    const SAVED_STATE  = "{{ $vendor->state ?? '' }}";
    const SAVED_REGION = "{{ $vendor->region ?? '' }}";
    const SAVED_CITY   = "{{ $vendor->city ?? '' }}";
</script>

<script>
   $(document).ready(function() {
       $('#region').select2({
         placeholder: "-- Select region --",
         allowClear: true,
         width: '100%'
       });

       // ✅ preselect saved regions after options load
       let savedRegions = @json($savedRegions);
       if (savedRegions && savedRegions.length) {
           $('#region').val(savedRegions).trigger('change');
       }
   });
</script>

<script>
   $('#entity_type').on('change', function () {
       const selectedOption = $(this).find("option:selected");
       const text = selectedOption.text();
       const value = selectedOption.val();

       if (text === "Proprietorship") {
              $("#certificate_label").text("PAN Of Proprietorship*");
          } else if (text === "Private Limited") {
              $("#certificate_label").text("Certificate Of Incopration*");
          } else  if (text === "Partnership") {
              $("#certificate_label").text("Partnership Deed*");
          } else if (text === "LLP") {
              $("#certificate_label").text("LLP Agreement*");
          } else if (text === "Public Limited") {
              $("#certificate_label").text("Certificate Of Incopration*");
          } else if (text === "OPC") {
              $("#certificate_label").text("Certificate Of Incopration*");
          } else if (text === "HUF") {
              $("#certificate_label").text("HUF PAN Card*");
          } else{
              $("#certificate_label").text("Relevant Document *");
          }

       // --- Show/hide sections ---
       if (value === '1') {
           $('#aadhar_pan_link_section').hide();
           $('#aadhar_section').hide();
           $('#partnershipdeed').hide();

           $('#cin_section').show();
           $('#llpin').hide();
       } else if (value === '2') {
           $('#aadhar_pan_link_section').hide();
           $('#aadhar_section').hide();
           $('#partnershipdeed').show();

           $('#cin_section').hide();
           $('#llpin').hide();
       } else if (value === '3') {
           $('#aadhar_pan_link_section').show();
           $('#aadhar_section').show();
           $('#partnershipdeed').hide();

           $('#cin_section').hide();
           $('#llpin').hide();
       } else if (value === '6') {
           $('#aadhar_pan_link_section').hide();
           $('#cin_section').hide();
           $('#partnershipdeed').hide();
           $('#aadhar_section').hide();
           $('#llpin').show();
       } else if (value === '7') {
           $('#aadhar_pan_link_section').hide();
           $('#cin_section').show();
           $('#partnershipdeed').hide();

           $('#aadhar_section').hide();
           $('#llpin').hide();
       } else if (value === '8') {
           $('#aadhar_pan_link_section').hide();
           $('#cin_section').show();
           $('#partnershipdeed').hide();

           $('#aadhar_section').hide();
           $('#llpin').hide();
       } else if (value === '9') {
           $('#aadhar_pan_link_section').hide();
           $('#cin_section').show();
           $('#partnershipdeed').hide();

           $('#aadhar_section').hide();
           $('#llpin').hide();
       } else {
           $('#llpin, #aadhar_pan_link_section, #aadhar_section, #cin_section').hide();
       }
   });

   // ✅ run once on page load to show correct sections based on saved entity type
   $(document).ready(function(){
       $('#entity_type').trigger('change');
       toggleMsmeUpload();
   });

   function toggleOptions() {
     const selectedValue = document.querySelector('input[name="pan_aadhar_seeded"]:checked').value;
     const uploadSection = document.getElementById('uploadSection');
     const linkSection = document.getElementById('linkSection');
     if (selectedValue === 'yes') {
       uploadSection.style.display = 'block';
       linkSection.style.display = 'none';
     } else if (selectedValue === 'no') {
       uploadSection.style.display = 'block';
       linkSection.style.display = 'block';
     }
   }

   function toggleMsmeUpload() {
     const checked = document.querySelector('input[name="msme_registered"]:checked');
     const msmeUploadSection = document.getElementById('msmeUploadSection');
     if(!checked){ msmeUploadSection.style.display = 'none'; return; }
     msmeUploadSection.style.display = (checked.value === 'yes') ? 'block' : 'none';
   }

   $('#itr_file').on('change', function () {
     let fileList = $(this)[0].files;
     let output = "";
     if (fileList.length > 0) {
       for (let i = 0; i < fileList.length; i++) {
         output += "<li>" + fileList[i].name + "</li>";
       }
     } else {
       output = "<li>No file selected</li>";
     }
     $('#itr_file_list').html(output);
   });

   // Certificate of Incorporation (multiple)
   $('#certificate_of_incorporation_file').on('change', function () {
     let fileList = this.files;
     let output = '';
     if (fileList.length > 0) {
       for (let i = 0; i < fileList.length; i++) {
         output += `<li>📄 ${fileList[i].name}</li>`;
       }
     } else {
       output = '<li>No file selected</li>';
     }
     $('#file_list').html(output);
   });

   // Work Completion Certificates (these lists not present in HTML, kept as-is)
   $('#work_completion_certificates_file1').on('change', function () {
     let f = this.files;
     $('#work_completion_certificates_list1').html(f.length ? `<li>📄 ${f[0].name}</li>` : '<li>No file selected</li>');
   });
   $('#work_completion_certificates_file2').on('change', function () {
     let f = this.files;
     $('#work_completion_certificates_list2').html(f.length ? `<li>📄 ${f[0].name}</li>` : '<li>No file selected</li>');
   });
   $('#work_completion_certificates_file3').on('change', function () {
     let f = this.files;
     $('#work_completion_certificates_list3').html(f.length ? `<li>📄 ${f[0].name}</li>` : '<li>No file selected</li>');
   });
</script>

<script>
   const gstInput = document.getElementById('gst_number');
   const gstError = document.getElementById('gst_error');

   if(gstInput){
     gstInput.addEventListener('blur', () => {
       const gstValue = gstInput.value.trim();
       if (gstValue.length && gstValue.length !== 15) {
         gstError.style.display = 'block';
         gstInput.classList.add('is-invalid');
       } else {
         gstError.style.display = 'none';
         gstInput.classList.remove('is-invalid');
       }
     });
   }
</script>

<script>
   const panInput = document.getElementById('pan_number');
   const panError = document.getElementById('pan_error');

   function isValidPAN(pan) {
     const panRegex = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
     return panRegex.test(pan.toUpperCase());
   }

   if(panInput){
     panInput.addEventListener('blur', () => {
       const panValue = panInput.value.trim().toUpperCase();
       panInput.value = panValue;
       if (panValue !== "" && !isValidPAN(panValue)) {
         panError.style.display = 'block';
         panInput.classList.add('is-invalid');
       } else {
         panError.style.display = 'none';
         panInput.classList.remove('is-invalid');
       }
     });
   }
</script>

<script>
   const tanInput = document.getElementById('tan_number');
   const tanError = document.getElementById('tan_error');

   function isValidTAN(tan) {
     const tanRegex = /^[A-Z]{4}[0-9]{5}[A-Z]{1}$/;
     return tanRegex.test(tan);
   }

   if(tanInput){
     tanInput.addEventListener('blur', () => {
       const tanValue = tanInput.value.trim().toUpperCase();
       tanInput.value = tanValue;
       if (tanValue !== "" && !isValidTAN(tanValue)) {
         tanError.style.display = 'block';
         tanInput.classList.add('is-invalid');
       } else {
         tanError.style.display = 'none';
         tanInput.classList.remove('is-invalid');
       }
     });

     tanInput.addEventListener('input', () => {
       tanInput.value = tanInput.value.toUpperCase().replace(/[^A-Z0-9]/g, '');
     });
   }
</script>

<script>
   const esicInput = document.getElementById('esic_number');
   const esicError = document.getElementById('esic_error');

   function isValidESIC(esic) {
     const esicRegex = /^\d{17}$/;
     return esicRegex.test(esic);
   }

   if(esicInput){
     esicInput.addEventListener('blur', () => {
       const esicValue = esicInput.value.trim();
       if (esicValue !== "" && !isValidESIC(esicValue)) {
         esicError.style.display = 'block';
         esicInput.classList.add('is-invalid');
       } else {
         esicError.style.display = 'none';
         esicInput.classList.remove('is-invalid');
       }
     });
   }
</script>

<script>
   const cinInput = document.getElementById('cin_no');
   const cinError = document.getElementById('cin_error');

   function isValidCIN(cin) {
     const cinRegex = /^[LU]{1}[0-9]{5}[A-Z]{2}[0-9]{4}[A-Z]{3}[0-9]{6}$/;
     return cinRegex.test(cin.toUpperCase());
   }

   if(cinInput){
     cinInput.addEventListener('blur', () => {
       const cinValue = cinInput.value.trim().toUpperCase();
       cinInput.value = cinValue;
       if (cinValue !== "" && !isValidCIN(cinValue)) {
         cinError.style.display = 'block';
         cinInput.classList.add('is-invalid');
       } else {
         cinError.style.display = 'none';
         cinInput.classList.remove('is-invalid');
       }
     });
   }
</script>

<script>
   const aadharInput = document.getElementById('aadhar_card_no');
   const aadharError = document.getElementById('aadhar_error');

   function isValidAadhar(aadhar) {
     const aadharRegex = /^\d{12}$/;
     return aadharRegex.test(aadhar);
   }

   if(aadharInput){
     aadharInput.addEventListener('blur', () => {
       const aadharValue = aadharInput.value.trim();
       if (aadharValue !== "" && !isValidAadhar(aadharValue)) {
         aadharError.style.display = 'block';
         aadharInput.classList.add('is-invalid');
       } else {
         aadharError.style.display = 'none';
         aadharInput.classList.remove('is-invalid');
       }
     });
   }
</script>

<script>
   $(document).ready(function() {
       $('#experience_years').change(function() {
           let selected = $(this).val();
           if(selected == "1") {
               $('#itr_section').hide();
               $('.itr_file').prop('required', false);
           } else if(selected != "") {
               $('#itr_section').show();
               $('.itr_file').prop('required', true);
           } else {
               $('#itr_section').hide();
               $('.itr_file').prop('required', false);
           }
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

       function loadSubtypes(workTypeId, selectedIds = []) {
           $('#workSubtypeCheckboxes').html('<span class="text-muted">Loading...</span>');

           if (workTypeId) {
               $.ajax({
                   url: '/get-subtypes/' + workTypeId,
                   type: 'GET',
                   success: function (res) {
                       let html = '';

                       if (res.length > 0) {
                           res.forEach(function (subtype) {
                               let checked = selectedIds.includes(String(subtype.id)) ? 'checked' : '';
                               html += `
                                   <div class="col-md-6 col-12">
                                       <label class="project-type-card w-100">
                                           <input type="checkbox"
                                                  name="work_subtype_id[]"
                                                  value="${subtype.id}"
                                                  class="form-check-input me-2"
                                                  ${checked}>
                                           ${subtype.work_subtype}
                                       </label>
                                   </div>
                               `;
                           });
                       } else {
                           html = '<span class="text-danger">No Project Types Found</span>';
                       }

                       $('#workSubtypeCheckboxes').html(html);
                   },
                   error: function () {
                       $('#workSubtypeCheckboxes').html(
                           '<span class="text-danger">Failed to load project types</span>'
                       );
                   }
               });
           } else {
               $('#workSubtypeCheckboxes').empty();
           }
       }

       // ✅ On change
       $('#work_type').on('change', function () {
           var workTypeId = $(this).val();
           loadSubtypes(workTypeId, []);
       });

       // ✅ On page load: if vendor already has work_type, load subtypes and auto-check saved ones
       let initialWorkType = $('#work_type').val();
       let saved = @json(array_map('strval', $savedSubtypes));
       if(initialWorkType){
           loadSubtypes(initialWorkType, saved);
       }
   });
</script>
<script>
$(document).ready(function () {

    // 🔹 AUTO LOAD REGION IF STATE EXISTS
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

        $('#regionSelect')
            .html('<option>Loading...</option>')
            .prop('disabled', true);

        $('#citySelect')
            .html('<option>Select City</option>')
            .prop('disabled', true);

        if (!stateId) return;

        $.get('/locations/regions/' + stateId, function (regions) {

            let options = '<option value="">Select Region</option>';
            regions.forEach(r => {
                options += `<option value="${r.id}">${r.name}</option>`;
            });

            $('#regionSelect')
                .html(options)
                .prop('disabled', false);

            // 🔹 AUTO SELECT SAVED REGION
            if (SAVED_REGION) {
                $('#regionSelect').val(SAVED_REGION);
                loadCities(SAVED_REGION);
            }
        });
    }

    function loadCities(regionId) {

        $('#citySelect')
            .html('<option>Loading...</option>')
            .prop('disabled', true);

        if (!regionId) return;

        $.get('/locations/cities/' + regionId, function (cities) {

            let options = '<option value="">Select City</option>';
            cities.forEach(c => {
                options += `<option value="${c.id}">${c.name}</option>`;
            });

            $('#citySelect')
                .html(options)
                .prop('disabled', false);

            // 🔹 AUTO SELECT SAVED CITY
            if (SAVED_CITY) {
                $('#citySelect').val(SAVED_CITY);
            }
        });
    }

});
</script>



@endsection
