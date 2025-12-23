@extends('layouts.suppliersapp')

@section('title', 'Lead Marketplace | ConstructKaro')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
:root{
  --navy:#1c2c3e; --orange:#f25c05; --ink:#0f172a; --muted:#6b7280; --line:#e6ebf2;
  --bg:#f5f7fb; --card:#ffffff; --ring:rgba(66,133,244,.18);
}
body{ background:linear-gradient(180deg,#f8fbff, #eef2f9); }
.page{ max-width:1200px; margin:28px auto; padding-bottom:64px; }
.v.big { font-size: 1.5rem; font-weight: bold; color: #f25c05; }

/* hero */
.hero{
  background:
    radial-gradient(900px 260px at 10% -30%, rgba(240, 240, 240, 0.12), transparent 60%),
    radial-gradient(700px 240px at 95% -20%, rgba(28,44,62,.18), transparent 60%),
    linear-gradient(180deg,#fff,#f8fafc);
  border:1px solid var(--line); border-radius:18px; padding:14px 18px;
  display:flex; align-items:center; justify-content:space-between; gap:12px;
}
.bcrumb{ color:#6b7280; font-size:.92rem; }

/* cards + inputs */
.cardx{ background:var(--card); border:1px solid var(--line); border-radius:16px; padding:18px; box-shadow:0 6px 26px rgba(17,24,39,.06); }
.section-title{ font-weight:800; color:#0f172a; font-size:1.05rem; }
.form-control,.form-select{ border-radius:12px; border:1px solid #d8dee8; padding:.7rem .9rem; }
.form-control:focus,.form-select:focus{ border-color:#b9c7f6; box-shadow:0 0 0 .22rem var(--ring); }
.req::after{ content:" *"; color:#dc3545; margin-left:2px; }
.hint{ color:var(--muted); font-size:.86rem; }

/* uploader */
.drop{
  border:2px dashed #cdd6e4; border-radius:14px; padding:18px; background:linear-gradient(180deg,#fafcff,#f6f8fc);
  text-align:center; transition:.2s; cursor:pointer;
}
.drop.drag{ background:#eef6ff; border-color:#9ec5ff; }
.thumb-grid{ display:grid; grid-template-columns:repeat(4,1fr); gap:10px; }
.thumb{ height:100px; background:#f8fafc; border:1px solid #e6ecf5; border-radius:12px; overflow:hidden; position:relative; }
.thumb img{ width:100%; height:100%; object-fit:cover; }
.thumb .btns{ position:absolute; inset:auto 6px 6px 6px; display:flex; gap:6px; justify-content:flex-end; }
.thumb .btns .btn{ padding:.15rem .35rem; border-radius:8px; backdrop-filter:blur(6px); }

/* summary */
.summary .k{ color:#94a3b8; font-size:.85rem; }
.summary .v{ font-weight:700; color:#0f172a; }
.summary .big{ font-size:1.3rem; }

/* buttons */
.btn-brand{ background:var(--orange); border-color:var(--orange); color:#fff; }
.btn-brand:hover{ background:#db5406; border-color:#db5406; }

/* table */
.table thead th{ background:#f7f8fb; border-bottom:1px solid var(--line); }
.table td,.table th{ vertical-align:middle; }
.ghost{ opacity:.55; font-style:italic; }

/* seo */
.seo-box{ background:#0f172a; color:#e2e8f0; border-radius:14px; padding:14px; }
.seo-url{ color:#a7f3d0; font-size:.85rem; }

.select2-container .select2-selection--single {
    height: 38px;
    padding: 6px 12px;
    border: 1px solid #ced4da;
    border-radius: 4px;
}
.upload-wrapper {
    display: flex;
    flex-direction: column;
    gap: 20px;
  }
  .upload-block {
    border: 1px solid #ddd;
    padding: 15px;
    border-radius: 8px;
    background-color: #fff;
  }
  .drop {
    border: 2px dashed #ccc;
    padding: 20px;
    text-align: center;
    cursor: pointer;
    border-radius: 8px;
    background-color: #f9f9f9;
    transition: border-color 0.3s;
  }
  .drop:hover {
    border-color: #007bff;
  }
  .thumb-grid {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
  }
  .thumb {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
    border: 1px solid #ddd;
  }
</style>

@section('content')
<div class="page">
  {{-- HERO --}}
  <div class="hero">
    <div class="d-flex align-items-center gap-3">
      <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-secondary rounded-3"><i class="bi bi-arrow-left"></i></a>
      <div>
        <h5 class="mb-0">Supplier Registration Form</h5>
        <div class="bcrumb"><i class="bi bi-box-seam me-1"></i> Supplier <i class="bi bi-chevron-right mx-1"></i> Add new</div>
      </div>
    </div>
  </div>

  {{-- GRID --}}
  <div class="row g-4 mt-2">
    {{-- MAIN FORM --}}
    <div class="col-12 col-xl-12">
      <form id="productForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
             <input type="hidden" name="user_id" value="{{$userid}}">

        {{-- Basic Info --}}
        <div class="cardx">
          <h5 class="mb-3">📋 Basic Information</h5>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Shop Name <span class="text-danger">*</span></label>
              <input type="text" name="shop_name" class="form-control" required placeholder="Enter your shop name">
            </div>
            <div class="col-md-6">
              <label class="form-label">Owner/Contact Person <span class="text-danger">*</span></label>
              <input type="text" name="contact_person" class="form-control" required placeholder="Enter owner name">
            </div>
            <div class="col-md-6">
              <label class="form-label">Phone Number <span class="text-danger">*</span></label>
              <input type="tel" name="phone" class="form-control" required placeholder="+91 98765 43210">
            </div>
            <div class="col-md-6">
              <label class="form-label">WhatsApp Number</label>
              <input type="tel" name="whatsapp" class="form-control" placeholder="+91 98765 43210">
            </div>
            <div class="col-12">
              <label class="form-label">Email Address <span class="text-danger">*</span></label>
              <input type="email" name="email" class="form-control" required placeholder="supplier@example.com">
            </div>
            <div class="col-12">
              <label class="form-label">Shop Address <span class="text-danger">*</span></label>
              <textarea name="shop_address" class="form-control" rows="3" required placeholder="Enter complete shop address"></textarea>
            </div>

            <div class="col-md-6">
              <label class="form-label">City <span class="text-danger">*</span></label>
              <select name="city" class="form-select select2" id="city" required>
                <option value="">Select City</option>
                @foreach ($cities as $city)
                  <option value="{{ $city->id }}">{{ $city->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Area <span class="text-danger">*</span></label>
              <select name="area" class="form-select select2" id="area" required>
                <option value="">Select Area</option>
              </select>
            </div>
          </div>
        </div>

     
        {{-- Products & Categories --}}
        <section class="cardx mt-3">
          <div class="card-section mb-4 p-3">
            <h5 class="mb-3">📦 Products & Categories</h5>

            <div class="mb-2">
              <label class="form-label">Material Categories Supplied <span class="text-danger">*</span></label>

              <div class="row g-2" id="categoriesGrid">
                {{-- Cement --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_cement" name="categories[]" value="cement">
                      <label class="form-check-label fw-semibold" for="cat_cement">Cement & Concrete</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[cement]" placeholder="Add details/brands for Cement…">
                  </div>
                </div>

                {{-- Steel --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_steel" name="categories[]" value="steel">
                      <label class="form-check-label fw-semibold" for="cat_steel">Steel & TMT Bars</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[steel]" placeholder="Add details/brands for Steel…">
                  </div>
                </div>

                {{-- Tiles --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_tiles" name="categories[]" value="tiles">
                      <label class="form-check-label fw-semibold" for="cat_tiles">Tiles & Flooring</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[tiles]" placeholder="Add details/brands for Tiles…">
                  </div>
                </div>

                {{-- Paint --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_paint" name="categories[]" value="paint">
                      <label class="form-check-label fw-semibold" for="cat_paint">Paint & Coatings</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[paint]" placeholder="Add details/brands for Paint…">
                  </div>
                </div>

                {{-- Plumbing --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_plumbing" name="categories[]" value="plumbing">
                      <label class="form-check-label fw-semibold" for="cat_plumbing">Plumbing Materials</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[plumbing]" placeholder="Add details/brands for Plumbing…">
                  </div>
                </div>

                {{-- Electrical --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_electrical" name="categories[]" value="electrical">
                      <label class="form-check-label fw-semibold" for="cat_electrical">Electrical Items</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[electrical]" placeholder="Add details/brands for Electrical…">
                  </div>
                </div>

                {{-- Safety --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_safety" name="categories[]" value="safety">
                      <label class="form-check-label fw-semibold" for="cat_safety">Safety Equipment</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[safety]" placeholder="Add details/brands for Safety…">
                  </div>
                </div>

                {{-- Timber --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_timber" name="categories[]" value="timber">
                      <label class="form-check-label fw-semibold" for="cat_timber">Timber & Wood</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[timber]" placeholder="Add details/brands for Timber…">
                  </div>
                </div>

                {{-- Glass --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_glass" name="categories[]" value="glass">
                      <label class="form-check-label fw-semibold" for="cat_glass">Glass & Glazing</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[glass]" placeholder="Add details/brands for Glass…">
                  </div>
                </div>

                {{-- Roofing --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_roofing" name="categories[]" value="roofing">
                      <label class="form-check-label fw-semibold" for="cat_roofing">Roofing Materials</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[roofing]" placeholder="Add details/brands for Roofing…">
                  </div>
                </div>

                {{-- Scaffolding --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_scaffolding" name="categories[]" value="scaffolding">
                      <label class="form-check-label fw-semibold" for="cat_scaffolding">Scaffolding</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[scaffolding]" placeholder="Add details/brands for Scaffolding…">
                  </div>
                </div>

                {{-- Hardware --}}
                <div class="col-12 col-md-6 col-lg-4">
                  <div class="p-2 rounded border bg-light d-flex align-items-start">
                    <div class="form-check">
                      <input class="form-check-input cat-check" type="checkbox" id="cat_hardware" name="categories[]" value="hardware">
                      <label class="form-check-label fw-semibold" for="cat_hardware">Hardware & Tools</label>
                    </div>
                  </div>
                  <div class="mt-2 d-none cat-extra">
                    <input type="text" class="form-control form-control-sm" name="category_notes[hardware]" placeholder="Add details/brands for Hardware…">
                  </div>
                </div>
              </div>
            </div>

            <div class="mb-2">
              <label class="form-label">Brands Supplied</label>
              <textarea name="brands_supplied" class="form-control" rows="3" placeholder="List the major brands you supply (e.g., ACC, Ultratech, Tata Steel, Asian Paints, etc.)"></textarea>
            </div>
          </div>
        </section>

        <section class="cardx mt-3">
          <h5 class="mb-3">🛠️ Product Uploads</h5>

          <div class="upload-wrapper">
            <!-- Product Images -->
            <div class="upload-block">
              <label class="fw-bold mb-2 d-block">🖼️ Product Images</label>
              <div id="drop" class="drop mb-3">
                <i class="bi bi-cloud-arrow-up me-2"></i>
                Drag & drop images here or click to browse
                <input id="imageInput" type="file" name="images[]" multiple accept="image/*" hidden>
              </div>
              <div id="thumbs" class="thumb-grid"></div>
            </div>

            <!-- Product Costing Sheet -->
            <div class="upload-block">
              <label class="fw-bold mb-2 d-block">📑 Product Costing Sheet</label>
              <div id="costingDrop" class="drop mb-3">
                <i class="bi bi-file-earmark-arrow-up me-2"></i>
                Drag & drop costing sheet here or click to browse
                <input id="costingInput" type="file" name="costing_sheet" accept=".pdf,.xls,.xlsx,.csv" hidden>
              </div>
              <div id="costingPreview" class="mt-2 text-muted" style="font-size: 0.9rem;">
                No file selected.
              </div>
            </div>
          </div>
        </section>
        {{-- Documents Upload --}}
        <section class="cardx mt-3">
          <div class="card-section mb-4 p-3">
            <h5 class="mb-3">📄 Documents Upload</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">GST Certificate <span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="gst_certificate" accept=".pdf,.jpg,.jpeg,.png" required>
                <small class="text-muted">Upload PDF, JPG, or PNG (Max 5MB)</small>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">PAN Card <span class="text-danger">*</span></label>
                <input type="file" class="form-control" name="pan_card" accept=".pdf,.jpg,.jpeg,.png" required>
                <small class="text-muted">Upload PDF, JPG, or PNG (Max 5MB)</small>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Shop License/Registration</label>
                <input type="file" class="form-control" name="shop_license" accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Upload PDF, JPG, or PNG (Max 5MB)</small>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Sample Invoice</label>
                <input type="file" class="form-control" name="sample_invoice" accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Upload PDF, JPG, or PNG (Max 5MB)</small>
              </div>
            </div>
          </div>
        </section>

        {{-- Bank Details --}}
        <section class="cardx mt-3">
          <div class="card-section mb-4 p-3">
            <h5 class="mb-3">🏦 Bank Details</h5>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Account Holder Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="account_holder" placeholder="As per bank records" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Bank Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="bank_name" placeholder="e.g., State Bank of India" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">Account Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="account_number" placeholder="Enter account number" required>
              </div>
              <div class="col-md-6">
                <label class="form-label fw-semibold">IFSC Code <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="ifsc_code" placeholder="e.g., SBIN0001234" required>
              </div>
            </div>
          </div>
        </section>

        {{-- Agreement --}}
        <section class="cardx mt-3">
          <div class="card-section mb-4 p-3">
            <h5 class="mb-3">✅ Agreement & Confirmation</h5>
            <div class="form-check mb-2">
              <input class="form-check-input" type="checkbox" id="confirm-details" name="confirm_details" required>
              <label class="form-check-label" for="confirm-details">
                I confirm that all the details provided above are true and accurate to the best of my knowledge.
              </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="agree-terms" name="agree_terms" required>
              <label class="form-check-label" for="agree-terms">
                I agree to ConstructKaro's <a href="#" class="text-primary text-decoration-underline">Terms & Conditions</a>
                and <a href="#" class="text-primary text-decoration-underline">Privacy Policy</a>.
              </label>
            </div>
          </div>

          <div class="d-flex justify-content-end mt-2">
            <button type="submit"
              style="
                background: transparent;
                color: #3d444cff;
                padding: 12px 28px;
                border: 2px solid #3d444cff;
                border-radius: 50px;
                font-size: 16px;
                font-weight: bold;
                cursor: pointer;
                transition: all 0.3s ease;
              "
              onmouseover="this.style.background='#3d444cff';this.style.color='#fff';"
              onmouseout="this.style.background='transparent';this.style.color='#3d444cff';">
              💾 Save Product
            </button>
          </div>
        </section>

      </form>
    </div>
  </div>
</div>

<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.querySelector('input[name="gst_number"]').addEventListener('input', function() {
    this.value = this.value.toUpperCase().replace(/[^0-9A-Z]/g, '').substr(0, 15);
});
</script>
<script>
document.querySelector('input[name="pan_number"]').addEventListener('input', function() {
    this.value = this.value.toUpperCase().replace(/[^0-9A-Z]/g, '').substr(0, 10);
});
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Select Supplier Type",
            allowClear: true,
            width: '100%'
        });
    });
</script>

<script>
// Initialize Select2 and bind City -> Area
$(function() {
  $('.select2').select2({ width: '100%' });

  $('#city').on('change', function() {
    fetchAreas();
  });

  // Trigger once on load if city preselected (edit form case)
  if ($('#city').val()) {
    fetchAreas();
  }
});

function fetchAreas() {
  const cityId = document.getElementById('city').value;
  const areaSelect = document.getElementById('area');

  // Reset
  areaSelect.innerHTML = '<option value="">Select Area</option>';

  if (cityId) {
    fetch(`/areas/${cityId}`)
      .then(response => response.json())
      .then(data => {
        if (Array.isArray(data) && data.length) {
          data.forEach(area => {
            const option = document.createElement('option');
            option.value = area.id;
            option.textContent = area.name;
            areaSelect.appendChild(option);
          });
        }
        // Refresh Select2 options
        $('#area').trigger('change.select2');
      })
      .catch(error => {
        console.error('Error fetching areas:', error);
      });
  }
}
</script>


<script>
// Reveal/hide the small textbox under each category checkbox
document.getElementById('categoriesGrid')?.addEventListener('change', function (e) {
  const cb = e.target.closest('.cat-check');
  if (!cb) return;

  const col = cb.closest('.col-12, .col-md-6, .col-lg-4');
  const extra = col?.querySelector('.cat-extra');
  if (!extra) return;

  if (cb.checked) {
    extra.classList.remove('d-none');
    const input = extra.querySelector('input');
    if (input) input.disabled = false;
  } else {
    const input = extra.querySelector('input');
    if (input) { input.value = ''; input.disabled = true; }
    extra.classList.add('d-none');
  }
});

// Disable hidden inputs on load so they don’t submit empty values
document.querySelectorAll('.cat-extra input').forEach(i => {
  if (i.closest('.cat-extra.d-none')) i.disabled = true;
});
</script>
<script>
  // Image Upload Preview
  const imageInput = document.getElementById('imageInput');
  const thumbs = document.getElementById('thumbs');
  document.getElementById('drop').addEventListener('click', () => imageInput.click());

  imageInput.addEventListener('change', () => {
    thumbs.innerHTML = '';
    [...imageInput.files].forEach(file => {
      const reader = new FileReader();
      reader.onload = e => {
        const img = document.createElement('img');
        img.src = e.target.result;
        img.classList.add('thumb');
        thumbs.appendChild(img);
      };
      reader.readAsDataURL(file);
    });
  });

  // Costing Sheet Preview
  const costingInput = document.getElementById('costingInput');
  const costingPreview = document.getElementById('costingPreview');
  document.getElementById('costingDrop').addEventListener('click', () => costingInput.click());

  costingInput.addEventListener('change', () => {
    costingPreview.textContent = costingInput.files.length > 0
      ? `Selected file: ${costingInput.files[0].name}`
      : 'No file selected.';
  });
</script>

<script>
/* variants */
const body = document.getElementById('variantBody');
const addBtn = document.getElementById('addVariant');
const clearBtn = document.getElementById('clearVariant');
const quickSize = document.getElementById('quickSize');

function addRow(data={}){ 
  if(body.querySelector('.ghost')) body.querySelector('.ghost').remove();
  const id = Date.now()+Math.floor(Math.random()*1000);
  const tr = document.createElement('tr');
  tr.innerHTML = `
    <td><input class="form-control" name="variants[${id}][option]" placeholder="Size / Color" value="${data.option||''}"></td>
    <td><input class="form-control" name="variants[${id}][value]" placeholder="e.g., M / Red" value="${data.value||''}"></td>
    <td><input class="form-control" name="variants[${id}][sku]" placeholder="SKU" value="${data.sku||''}"></td>
    <td><input class="form-control" type="number" step="0.01" name="variants[${id}][price_delta]" placeholder="0.00" value="${data.price_delta||''}"></td>
    <td class="text-end"><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove()"><i class="bi bi-x-circle"></i></button></td>`;
  body.appendChild(tr);
}

addBtn?.addEventListener('click',()=>addRow());
clearBtn?.addEventListener('click',()=>{ body.innerHTML='<tr class="ghost"><td colspan="5">No variants yet. Click “Add row”.</td></tr>'; });
quickSize?.addEventListener('click',()=>['S','M','L','XL'].forEach(v=>addRow({option:'Size', value:v})));
</script>
<script>
(function () {
  // Helpers
  const byId = (id) => document.getElementById(id);
  const toNum = (v) => {
    const n = parseFloat(v);
    return isFinite(n) ? n : 0;
  };
  const clamp = (n, min, max) => Math.min(Math.max(n, min), max);

  // Nice INR formatting (works in all modern browsers)
  const fmtINR = (n) => {
    try {
      return new Intl.NumberFormat('en-IN', { style: 'currency', currency: 'INR', maximumFractionDigits: 2 }).format(n || 0);
    } catch {
      // Fallback
      return '₹' + (isFinite(n) ? Number(n) : 0).toFixed(2);
    }
  };

  // Inputs
  const elMrp   = byId('price');     // MRP
  const elDisc  = byId('discount');  // Discounted Price (final pre-tax)
  const elGst   = byId('gst');       // GST %

  // Outputs
  const outMrp   = byId('sumMrp');
  const outDisc  = byId('sumDisc');
  const outDiscP = byId('sumDiscPct');
  const outSub   = byId('sumSub');
  const outGst   = byId('sumGst');
  const outFinal = byId('sumFinal');

  function recalc() {
    let mrp   = clamp(toNum(elMrp?.value),   0, 1e12);
    let dprix = clamp(toNum(elDisc?.value),  0, 1e12); // discounted price (pre-tax)
    let gstP  = clamp(toNum(elGst?.value),   0, 100);  // 0-100%

    // If discounted price is entered and higher than MRP, cap it to MRP
    if (dprix > 0 && mrp > 0 && dprix > mrp) dprix = mrp;

    const subtotal = dprix > 0 ? dprix : mrp;

    // Discount amount (absolute) and derived percentage
    const discountAmt = Math.max(0, mrp - subtotal);
    const discountPct = mrp > 0 ? (discountAmt / mrp) * 100 : 0;

    // GST amount and final
    const gstAmt = subtotal * (gstP / 100);
    const final  = subtotal + gstAmt;

    // Write outputs
    if (outMrp)   outMrp.textContent   = fmtINR(mrp);
    if (outDisc)  outDisc.innerHTML    = `${fmtINR(discountAmt)} <span id="sumDiscPct">${discountPct ? `(${Math.round(discountPct)}%)` : ''}</span>`;
    if (outSub)   outSub.textContent   = fmtINR(subtotal);
    if (outGst)   outGst.textContent   = fmtINR(gstAmt);
    if (outFinal) outFinal.textContent = fmtINR(final);
  }

  // Bind + initial
  [elMrp, elDisc, elGst].forEach(el => el && el.addEventListener('input', recalc));
  recalc();

  // (Optional) sanitize on blur to 2 decimals
  function sanitize2d(el) {
    if (!el) return;
    el.addEventListener('blur', () => {
      const n = toNum(el.value);
      el.value = n ? n.toFixed(2) : '';
      recalc();
    });
  }
  sanitize2d(elMrp); sanitize2d(elDisc); sanitize2d(elGst);
})();
</script>
<script>
// Attach once the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('productForm');
  if (!form) return;

  // Intercept default submit
  form.addEventListener('submit', saveProduct);
});

async function saveProduct(e) {
  e.preventDefault();
  const form   = e.target;
  const action = form.getAttribute('action');
  const token  = form.querySelector('input[name="_token"]').value;
  const submitBtn = form.querySelector('button[type="submit"]');

  clearErrors(form);

  // Build payload with files (FormData auto-collects all inputs by "name")
  const fd = new FormData(form);

  // Optional: protect user from double-submit
  if (submitBtn) {
    submitBtn.disabled = true;
    submitBtn.dataset.oldText = submitBtn.innerHTML;
    submitBtn.innerHTML = 'Saving...';
  }

  try {
    const resp = await fetch(action, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': token,
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
      },
      body: fd, // DO NOT set Content-Type; fetch will set multipart automatically
    });

    if (resp.ok) {
      const data = await resp.json();
      toast('✅ ' + (data.message || 'Saved successfully.'));
      if (data.redirect) {
        let redirectUrl = "{{ route('products.index') }}";
        window.location.href = redirectUrl;
       
      } else {
        // If you want to reset the form on success:
        // form.reset();
      }
      return;
    }

    // Handle validation errors
    if (resp.status === 422) {
      const payload = await resp.json();
      renderErrors(form, payload.errors || {});
      toast('⚠️ Please correct the highlighted fields.');
      return;
    }

    // Other errors
    const err = await resp.text();
    console.error(err);
    toast('❌ Server error. Please try again.');
  } catch (ex) {
    console.error(ex);
    toast('❌ Network error. Please check your connection.');
  } finally {
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.innerHTML = submitBtn.dataset.oldText || '💾 Save Product';
    }
  }
}

// Helpers
function clearErrors(form) {
  // Remove old error texts
  form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
  form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());
}

function renderErrors(form, errors) {
  Object.keys(errors).forEach(name => {
    const messages = Array.isArray(errors[name]) ? errors[name] : [String(errors[name])];

    // Try to find the field by name (works for arrays like service_areas[] too)
    let field = form.querySelector(`[name="${CSS.escape(name)}"]`);
    if (!field) {
      // Fallback for array notation fields like "service_areas[]"
      field = form.querySelector(`[name="${CSS.escape(name)}[]"]`);
    }
    if (!field) return;

    field.classList.add('is-invalid');

    const fb = document.createElement('div');
    fb.className = 'invalid-feedback';
    fb.innerText = messages[0] || 'Invalid value';
    // Insert after field
    if (field.parentNode) {
      // If field is inside an input-group, place feedback after the group
      const group = field.closest('.input-group');
      if (group && group.parentNode) group.parentNode.appendChild(fb);
      else field.parentNode.appendChild(fb);
    }
  });
}

function toast(msg) {
  // Very simple toast. Replace with your preferred UI (e.g., Bootstrap Toast)
  const t = document.createElement('div');
  t.textContent = msg;
  t.style.position = 'fixed';
  t.style.right = '16px';
  t.style.bottom = '16px';
  t.style.padding = '10px 14px';
  t.style.background = '#111827';
  t.style.color = '#fff';
  t.style.borderRadius = '8px';
  t.style.zIndex = 9999;
  t.style.boxShadow = '0 10px 25px rgba(0,0,0,.2)';
  document.body.appendChild(t);
  setTimeout(() => t.remove(), 2500);
}
</script>


@endsection
