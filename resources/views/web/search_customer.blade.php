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
:root{
  --blue:#2563eb;
  --indigo:#4f46e5;
  --orange:#f97316;
}
body{
  font-family:'Inter',sans-serif;
  background:linear-gradient(135deg,#f8fafc 0%,#eff6ff 50%,#f8fafc 100%);
}
.filter-sidebar{
  background:#fff;
  border-radius:24px;
  border:1px solid #e2e8f0;
  padding:24px;
  position:sticky;
  top:100px;
}
.search-section{
  background:#fff;
  border-radius:24px;
  border:1px solid #e2e8f0;
  padding:24px;
}
.form-select-custom{
  padding:14px 18px;
  border-radius:12px;
  border:2px solid #e2e8f0;
}
.vendor-card{
  background:#fff;
  border-radius:16px;
  border:1px solid #e2e8f0;
  padding:16px;
  transition:.25s;
}
.vendor-card:hover{
  transform:translateY(-2px);
  box-shadow:0 18px 40px rgba(15,23,42,.15);
}
.blur-text{
  filter:blur(6px);
  pointer-events:none;
}
</style>

<div class="container-fluid px-4 py-4">
<div class="row g-4">

{{-- ================= SIDEBAR ================= --}}
<div class="col-lg-3">
<div class="filter-sidebar">

<h6 class="fw-bold mb-3">
<i class="bi bi-funnel-fill text-primary"></i> Work Category
</h6>

@foreach($work_types as $work)
<div class="mb-2">
<label class="d-flex gap-2">
<input type="checkbox" class="form-check-input category-check" value="{{ $work->id }}">
<span class="fw-semibold">{{ $work->work_type }}</span>
</label>

<div class="ms-4 mt-1 d-none subtype-box" data-type="{{ $work->id }}">
@foreach(DB::table('work_subtypes')->where('work_type_id',$work->id)->get() as $sub)
<label class="d-flex gap-2 small">
<input type="checkbox" class="form-check-input subtype-check" value="{{ $sub->id }}">
{{ $sub->work_subtype }}
</label>
@endforeach
</div>
</div>
@endforeach

</div>
</div>

{{-- ================= MAIN ================= --}}
<div class="col-lg-9">

<div class="search-section mb-4">
<div class="row g-3">
<div class="col-md-4">
<label class="small fw-semibold">State</label>
<select id="stateSelect" class="form-select form-select-custom">
<option value="">Select State</option>
@foreach($states as $state)
<option value="{{ $state->id }}">{{ $state->name }}</option>
@endforeach
</select>
</div>

<div class="col-md-4">
<label class="small fw-semibold">Region</label>
<select id="regionSelect" class="form-select form-select-custom" disabled>
<option value="">Select Region</option>
</select>
</div>

<div class="col-md-4">
<label class="small fw-semibold">City</label>
<select id="citySelect" class="form-select form-select-custom" disabled>
<option value="">Select City</option>
</select>
</div>
</div>
</div>

<h4 class="fw-bold mb-3">
<span id="vendorCount">{{ $projects->count() }}</span> Professional Lead
</h4>

{{-- ================= RESULTS ================= --}}
@foreach($projects as $project)
<div class="vendor-card mb-3"
 data-work-type-id="{{ $project->work_type_id }}"
 data-work-subtype-id="{{ $project->work_subtype_id }}"
 data-work-subtype="{{ strtolower($project->work_subtype) }}"
 data-name="{{ strtolower($project->title) }}"
 data-state="{{ strtolower($project->state ?? '') }}"
 data-region="{{ strtolower($project->region ?? '') }}"
 data-city="{{ strtolower($project->city ?? '') }}">

<h6 class="fw-bold">{{ strtoupper($project->title) }}</h6>

<div class="small text-muted">
<i class="bi bi-geo-alt-fill text-primary"></i>
{{ $project->state }}, {{ $project->city }}
</div>

<div class="mt-2 blur-text fw-semibold">{{ $project->contact_name }}</div>

<button class="btn btn-primary btn-sm mt-3"
onclick="handleInterested({{ $project->id }})">
❤️ I'm Interested
</button>
</div>
@endforeach

</div>
</div>
</div>

{{-- ================= AUTH MODAL ================= --}}
<div class="modal fade" id="authModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<div class="modal-header bg-primary text-white">
<h6 class="mb-0">Login Required</h6>
<button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
</div>
<div class="modal-body text-center">
<p class="text-muted">Please login to unlock lead details.</p>
<a href="{{ route('login_register') }}" class="btn btn-primary w-100">Login</a>
</div>
</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
/* ================= FILTER ================= */
function applyFilters(){

let searchText =
  document.querySelector('.form-control-custom')
    ?.value.toLowerCase().trim() || '';

let stateText  = ($('#stateSelect option:selected').text() || '').toLowerCase().trim();
let regionText = ($('#regionSelect option:selected').text() || '').toLowerCase().trim();
let cityText   = ($('#citySelect option:selected').text() || '').toLowerCase().trim();

if(stateText==='select state') stateText='';
if(regionText==='select region') regionText='';
if(cityText==='select city') cityText='';

let categories=[], subtypes=[];
$('.category-check:checked').each(function(){categories.push(this.value)});
$('.subtype-check:checked').each(function(){subtypes.push(this.value)});

let visible=0;

$('.vendor-card').each(function(){

let show=true;

if(stateText && !$(this).data('state').includes(stateText)) show=false;
if(regionText && !$(this).data('region').includes(regionText)) show=false;
if(cityText && !$(this).data('city').includes(cityText)) show=false;

if(categories.length && !categories.includes(String($(this).data('work-type-id')))) show=false;
if(subtypes.length && !subtypes.includes(String($(this).data('work-subtype-id')))) show=false;

let title=$(this).data('name');
let subtype=$(this).data('work-subtype');
if(searchText && !(title.includes(searchText) || subtype.includes(searchText))) show=false;

$(this).toggle(show);
if(show) visible++;
});

$('#vendorCount').text(visible);
}

/* EVENTS */
$('.category-check').on('change',function(){
$('.subtype-box[data-type="'+this.value+'"]').toggleClass('d-none',!this.checked);
applyFilters();
});
$('.subtype-check').on('change',applyFilters);
$('#stateSelect,#regionSelect,#citySelect').on('change',applyFilters);

/* STATE → REGION */
$('#stateSelect').change(function(){
$('#regionSelect').prop('disabled',true).html('<option>Select Region</option>');
$('#citySelect').prop('disabled',true).html('<option>Select City</option>');
applyFilters();
if(this.value){
$.get('/locations/regions/'+this.value,function(res){
let o='<option value="">Select Region</option>';
res.forEach(r=>o+=`<option value="${r.id}">${r.name}</option>`);
$('#regionSelect').html(o).prop('disabled',false);
});
}
});

/* REGION → CITY */
$('#regionSelect').change(function(){
$('#citySelect').prop('disabled',true).html('<option>Select City</option>');
applyFilters();
if(this.value){
$.get('/locations/cities/'+this.value,function(res){
let o='<option value="">Select City</option>';
res.forEach(c=>o+=`<option value="${c.id}">${c.name}</option>`);
$('#citySelect').html(o).prop('disabled',false);
});
}
});

/* PROFILE DROPDOWN SAFE */
document.addEventListener('DOMContentLoaded',()=>{
const p=document.getElementById('profileDropdown');
if(p){
p.addEventListener('click',e=>{
e.stopPropagation();
p.classList.toggle('show');
});
document.addEventListener('click',()=>p.classList.remove('show'));
}
});

/* INTEREST */
function handleInterested(){
if(!window.VENDOR_ID){
new bootstrap.Modal(document.getElementById('authModal')).show();
return;
}
alert('Lead unlocked (payment logic already exists)');
}
</script>

@endsection
