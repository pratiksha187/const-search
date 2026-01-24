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
    --bg:#f5f7fb;
    --line:#e6ebf2;
}
body{
    background:linear-gradient(180deg,#f8fbff,#eef2f9);
}
.page{
    max-width:1202px;
    margin:87px auto 90px;
}
.cardx{
    background:#fff;
    border-radius:20px;
    padding:26px;
    border:none;
    box-shadow:0 20px 45px rgba(15,23,42,.08);
    margin-bottom:24px;
}
.form-control,
.form-select{
    border-radius:12px;
    padding:12px 14px;
    border:1px solid #e5e7eb;
}

.form-control:focus,
.form-select:focus{
    border-color:#f25c05;
    box-shadow:0 0 0 3px rgba(242,92,5,.15);
}
.save-bar{
    position:sticky;
    bottom:0;
    background:linear-gradient(180deg,#ffffff,#f8fafc);
    padding:18px 24px;
    border-top:1px solid #e5e7eb;
    box-shadow:0 -14px 40px rgba(0,0,0,.15);
}

.save-btn{
    background:linear-gradient(135deg,#f25c05,#ea580c);
    padding:14px 56px;
    font-size:16px;
    box-shadow:0 12px 25px rgba(242,92,5,.45);
}
.save-btn:hover{
    transform:translateY(-2px);
}
/* PROGRESS */
.progress-wrapper{
    background:linear-gradient(135deg,#1e293b,#0f172a);
    border-radius:18px;
    padding:24px;
    color:#fff;
    box-shadow:0 18px 40px rgba(15,23,42,.35);
}

.step-card{
    background:rgba(255,255,255,.08);
    border-radius:16px;
    padding:18px;
    min-height:140px;
    transition:.3s;
}

.step-card:hover{
    transform:translateY(-4px);
    background:rgba(255,255,255,.14);
}
.step-card.active{opacity:1;}
.step-badge{
    width:32px;height:32px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;
    font-weight:700;color:#fff;
}

/* CATEGORY */
.category-tabs .list-group-item{
    cursor:pointer;
    border-left:4px solid transparent;
}
.category-tabs .list-group-item.active{
    background:#fff3e9;
    border-left-color:#f25c05;
    color:#f25c05;
    font-weight:600;
}
.category-page{display:none;}
.category-page.active{display:block;}

.dashboard-content {
    margin-left: 237px;
    padding: 22px;
    padding-top: 20px;
    transition: .3s;
}
.step-card{
    height: 100%;
    transition: all .3s ease;
}
.step-card.active{
    opacity: 1;
    box-shadow: 0 10px 30px rgba(0,0,0,.25);
}
.category-tabs .list-group-item{
    font-size:14px;
    padding:10px 14px;
    border:0;
    border-bottom:1px solid #e5e7eb;
    cursor:pointer;
    background:#f1f1f1;
}

.category-tabs .list-group-item:nth-child(odd){
    background:#ffffff;
}

.category-tabs .list-group-item.active{
    background:#e5e7eb;
    font-weight:600;
    color:#000;
    border-left:4px solid #f25c05;
}
.material-pill {
    position: relative;
    cursor: pointer;
}

.material-pill input {
    display: none;
}

.pill-content{
    padding:10px 16px;
    font-size:14px;
    border-radius:999px;
    box-shadow:0 6px 14px rgba(0,0,0,.06);
}


.material-pill:hover .pill-content {
    border-color: #f25c05;
}
.category-tabs{
    max-height:70vh;
    overflow-y:auto;
}

.category-tabs .list-group-item{
    transition:.2s;
}

.category-tabs .list-group-item:hover{
    background:#fff7f0;
    color:#f25c05;
}

.material-pill input:checked + .pill-content {
    border-color: #f25c05;
    background: #fff7f0;
    color: #f25c05;
    box-shadow: 0 0 0 1px #f25c05 inset;
}

.pill-icon {
    font-size: 14px;
}
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding-bottom:14px;
    border-bottom:1px solid var(--line);
}


</style>

{{-- ================= SAFE DATA HANDLING ================= --}}
@php
$rawCategories = $supplier->categories_json ?? '[]';
$savedCategories = [];

if(is_string($rawCategories)){
    $decoded = json_decode($rawCategories,true);
    $savedCategories = is_array($decoded) ? $decoded : array_filter(explode(',',$rawCategories));
}

$savedNotes = json_decode($supplier->category_notes_json ?? '{}', true);
$savedNotes = is_array($savedNotes) ? $savedNotes : [];

$categoryIdMap = [
    5=>'ConstructionChemicals',6=>'plumbing',7=>'electrical',8=>'doorswindows',
    9=>'glassglazing',10=>'hardwaretools',11=>'machineries',12=>'timberwood',
    13=>'roofing',14=>'pavers',15=>'concreteproducts',16=>'roadsafety',
    17=>'facadecladding',18=>'scaffolding',19=>'hvacutilities',
    20=>'readymix',21=>'paintcoating',22=>'tilesflooring',
    2=>'steel-tmt-bars',1=>'cement-concrete',28=>'aggregates',29=>'roadconstruction'
];

@endphp
@php
$categoryLabelMap = [
    'cement-concrete'      => 'Cement & Concrete',
    'steel-tmt-bars'             => 'Steel & TMT Bars',
    'ConstructionChemicals'=> 'Construction & Chemicals',
    'plumbing'             => 'Plumbing Materials',
    'electrical'           => 'Electrical Items',
    'doorswindows'         => 'Doors & Windows',
    'glassglazing'         => 'Glass & Glazing',
    'hardwaretools'        => 'Hardware & Tools',
    'machineries'          => 'Machineries & Equipments',
    'timberwood'           => 'Timber & Wood',
    'roofing'              => 'Roofing Materials',
    'pavers'               => 'Pavers & Kerbstones',
    'concreteproducts'     => 'Concrete Products',
    'roadsafety'           => 'Road Safety Products',
    'facadecladding'       => 'Facade & Cladding Materials',
    'scaffolding'          => 'Scaffolding',
    'hvacutilities'        => 'HVAC & Utilities',
    'readymix'             => 'Ready Mix Concrete',
    'paintcoating'         => 'Paint & Coatings',
    'tilesflooring'        => 'Tiles & Flooring',
    'aggregates'           => 'Aggregates, Sand, and Masonry Materials',
    'roadconstruction'     => 'Road Construction Materials & Asphalt Works',
];
@endphp
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

<div class="page">
<div class="page-header mb-4">
    <div>
        <h3 class="fw-bold mb-1">Supplier Registration</h3>
        <p class="text-muted mb-0">
            Complete your profile to start receiving verified enquiries
        </p>
    </div>
</div>

{{-- ================= PROGRESS ================= --}}

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
               <div class="row g-4">
                  <!-- LEFT SIDEBAR -->
                  <div class="col-md-3">
                     <div class="card shadow-sm">
                        <div class="card-header fw-semibold">
                           Material Categories
                        </div>
                        <ul class="list-group list-group-flush category-tabs" id="categoryTabs">
                           @foreach($enabledCategoryTabs as $catId)
                              @if(isset($categoryIdMap[$catId]))
                                    @php
                                       $slug  = $categoryIdMap[$catId];
                                       $label = $categoryLabelMap[$slug] ?? ucwords(str_replace('-', ' ', $slug));
                                    @endphp

                                    <li class="list-group-item {{ $loop->first ? 'active' : '' }}"
                                       data-target="{{ $slug }}">
                                       {{ $label }}
                                    </li>
                              @endif
                           @endforeach
                        </ul>

                        
                     </div>
                  </div>
                  <!-- RIGHT CONTENT -->
                  <div class="col-md-9">
                     <!-- ConstructionChemicals -->
                     <div class="category-page" id="ConstructionChemicals">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Construction Chemicals</div>
                           <div class="card-body">
                              @include('web.catalog.construction-chemicals')
                           </div>
                        </div>
                     </div>
                     <!-- STEEL -->
                     <div class="category-page" id="steel-tmt-bars">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Steel & TMT Bars</div>
                           <div class="card-body">
                              @include('web.catalog.steeltmt')
                           </div>
                        </div>
                     </div>
                     <!-- TILES -->
                     <div class="category-page" id="tiles">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Tiles & Flooring</div>
                           <div class="card-body">
                              @include('web.catalog.tilesflooring')
                           </div>
                        </div>
                     </div>
                     <!-- PAINT -->
                     <div class="category-page" id="paint">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Paint & Coatings</div>
                           <div class="card-body">
                              @include('web.catalog.paint-coatings')
                           </div>
                        </div>
                     </div>
                     <!-- ELECTRICAL -->
                     <div class="category-page" id="electrical">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Electrical Items</div>
                           <div class="card-body">
                              @include('web.catalog.electrical-items')
                           </div>
                        </div>
                     </div>
                     <!-- PLUMBING -->
                     <div class="category-page" id="plumbing">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Plumbing Materials</div>
                           <div class="card-body">
                              @include('web.catalog.plumbing-materials')
                           </div>
                        </div>
                     </div>
                     <!-- doorswindows -->
                     <div class="category-page" id="doorswindows">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Doors & Windows</div>
                           <div class="card-body">
                              @include('web.catalog.doorswindows')
                           </div>
                        </div>
                     </div>
                     <!-- glassglazing -->
                     <div class="category-page" id="glassglazing">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Glass & Glazing</div>
                           <div class="card-body">
                              @include('web.catalog.glassglazing')
                           </div>
                        </div>
                     </div>
                     <!-- hardwaretools -->
                     <div class="category-page" id="hardwaretools">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product –  Hardware & Tools</div>
                           <div class="card-body">
                              @include('web.catalog.hardwaretools')
                           </div>
                        </div>
                     </div>
                     <!-- machineries -->
                     <div class="category-page" id="machineries">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product –  Machineries & Equipments</div>
                           <div class="card-body">
                              @include('web.catalog.machineries')
                           </div>
                        </div>
                     </div>
                     <!-- timberwood -->
                     <div class="category-page" id="timberwood">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Timber & Wood</div>
                           <div class="card-body">
                              @include('web.catalog.timberwood')
                           </div>
                        </div>
                     </div>
                     <!-- roofing -->
                     <div class="category-page" id="roofing">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Roofing Materials</div>
                           <div class="card-body">
                              @include('web.catalog.roofing')
                           </div>
                        </div>
                     </div>
                     <!-- pavers -->
                     <div class="category-page" id="pavers">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Pavers & Kerbstones</div>
                           <div class="card-body">
                              @include('web.catalog.pavers')
                           </div>
                        </div>
                     </div>
                     <!-- concreteproducts -->
                     <div class="category-page" id="concreteproducts">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Concrete Products </div>
                           <div class="card-body">
                              @include('web.catalog.concreteproducts')
                           </div>
                        </div>
                     </div>
                     <!-- roadsafety -->
                     <div class="category-page" id="roadsafety">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Road Safety Products </div>
                           <div class="card-body">
                              @include('web.catalog.roadsafety')
                           </div>
                        </div>
                     </div>
                     <!-- facadecladding -->
                     <div class="category-page" id="facadecladding">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Facade & Cladding Materials </div>
                           <div class="card-body">
                              @include('web.catalog.facadecladding')
                           </div>
                        </div>
                     </div>
                     <!-- Scaffolding -->
                     <div class="category-page" id="scaffolding">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Scaffolding </div>
                           <div class="card-body">
                              @include('web.catalog.scaffolding')
                           </div>
                        </div>
                     </div>
                     <!-- hvacutilities -->
                     <div class="category-page" id="hvacutilities">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – HVAC & Utilities </div>
                           <div class="card-body">
                              @include('web.catalog.hvacutilities')
                           </div>
                        </div>
                     </div>
                     <!-- readymix -->
                     <div class="category-page" id="readymix">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Ready Mix Concrete</div>
                           <div class="card-body">
                              @include('web.catalog.readymix')
                           </div>
                        </div>
                     </div>
                     <!-- Paint & Coatings									 -->
                     <div class="category-page" id="paintcoating">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Paint & Coatings</div>
                           <div class="card-body">
                              @include('web.catalog.paint-coatings')
                           </div>
                        </div>
                     </div>
                     <!-- tilesflooring -->
                     <div class="category-page" id="tilesflooring">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Tiles & Flooring	</div>
                           <div class="card-body">
                              @include('web.catalog.tilesflooring')
                           </div>
                        </div>
                     </div>
                     
                     <!-- cement-concrete -->
                     <div class="category-page" id="cement-concrete">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Cement & Concrete</div>
                           <div class="card-body">
                              @include('web.catalog.cementconcrete')
                           </div>
                        </div>
                     </div>
                     <!-- aggregates -->
                     <div class="category-page" id="aggregates">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Aggregates, sand, and Masonry Materials</div>
                           <div class="card-body">
                              @include('web.catalog.aggregates')
                           </div>
                        </div>
                     </div>
                     <!-- roadconstruction -->
                     <div class="category-page" id="roadconstruction">
                        <div class="card shadow-sm mb-4">
                           <div class="card-header fw-semibold">Add Product – Road Construction Materials & Asphalt Works</div>
                           <div class="card-body">
                              @include('web.catalog.roadconstruction')
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
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
                     {{ $maximum_distance->distance_km }} KM
                     </option>
                     @endforeach
                  </select>
               </div>
         </div>
      </div>
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
<script>
$(document).on('click', '.category-tabs .list-group-item', function () {

    // Remove active from all tabs
    $('.category-tabs .list-group-item').removeClass('active');
    $(this).addClass('active');

    // Hide all category pages
    $('.category-page').removeClass('active');

    // Show selected category page
    const target = $(this).data('target');
    $('#' + target).addClass('active');
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const cache = {}; // 🔥 Prevent multiple calls

    document.querySelectorAll('.js-product-type').forEach(select => {

        select.addEventListener('change', function () {

            const form = this.closest('form');
            if (!form) return;

            const subtype = form.querySelector('.js-product-subtype');
            const brand   = form.querySelector('.js-brand');

            const productId = this.value;

            // Reset
            subtype.innerHTML = '<option value="">Select sub type</option>';
            brand.innerHTML   = '<option value="">Select brand</option>';
            subtype.disabled = true;
            brand.disabled   = true;

            if (!productId) return;

            // ✅ If already fetched → use cache
            if (cache[productId]) {
                fillData(cache[productId], subtype, brand);
                return;
            }

            // 🔥 SINGLE REQUEST
            fetch(`/get-product-meta/${productId}`)
                .then(res => res.json())
                .then(data => {
                    cache[productId] = data;
                    fillData(data, subtype, brand);
                });

        });
    });

    function fillData(data, subtype, brand) {

        data.subtypes.forEach(i => {
            subtype.innerHTML +=
                `<option value="${i.id}">${i.material_subproduct}</option>`;
        });

        data.brands.forEach(b => {
            brand.innerHTML +=
                `<option value="${b.id}">${b.name}</option>`;
        });

        subtype.disabled = false;
        brand.disabled   = false;
    }

    // BRAND CHANGE LOGIC
    document.querySelectorAll('.js-brand').forEach(select => {
        select.addEventListener('change', function () {

            const form = this.closest('form');
            const spec = form.querySelector('.js-specification');
            const other = form.querySelector('.js-other-brand');

            spec.classList.add('d-none');
            other.classList.add('d-none');

            if (!this.value) return;

            spec.classList.remove('d-none');

            if (this.value === '25') { // OTHER brand id
                other.classList.remove('d-none');
            }
        });
    });

});



document.querySelectorAll('.tab-pane').forEach(p=>{
    if(p.classList.contains('active')){
        document.querySelector(`[onclick*="${p.id}"]`)?.classList.add('active');
    }
});

</script>

@endsection
