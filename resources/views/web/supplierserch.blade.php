@extends($layout)

@section('title','Search Suppliers | ConstructKaro')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
/* ================= PAGE ================= */
.supplier-page{
    background:#f3f9ff;
    font-family:system-ui,-apple-system,BlinkMacSystemFont;
    padding:20px;
    font-size:16px;   /* ✅ FIX */
    line-height:1.5; /* ✅ READABILITY */
}


/* ================= HEADER ================= */
.find-suppliers-header{
    background:linear-gradient(180deg,#1e293b,#111827);
    color:#fff;
    padding:14px 18px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    margin-bottom:12px;
}
.header-left{
    display:flex;
    align-items:center;
    gap:12px;
}
.header-icon{
    width:40px;
    height:40px;
    border-radius:10px;
    background:#2563eb;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
}
.btn-outline{
    flex:1;
    border:2px solid #e5e7eb;
    background:#fff;
    padding:12px;
    border-radius:10px;
    font-weight:600;

    text-decoration:none;   /* ✅ removes underline */
    color:#1f2937;          /* optional: normal text color */
}




/* ================= SEARCH ================= */
.find-search-bar{
    background:#fff;
    border-radius:12px;
    padding:12px;
    display:flex;
    gap:12px;
    align-items:center;
    box-shadow:0 6px 18px rgba(0,0,0,.08);
    margin-bottom:22px;
}
.find-search-bar input{
    border:none;
    outline:none;
    width:100%;
    font-size:15px;
}
.find-search-bar .btn-search{
    background:#2563eb;
    color:#fff;
    border:none;
    padding:10px 22px;
    border-radius:8px;
    font-weight:600;
}

/* ================= LAYOUT ================= */
.content{
    display:grid;
    grid-template-columns:260px 1fr;
    gap:22px;
}

/* ================= FILTERS ================= */
.filters{
    background:#fff;
    border-radius:16px;
    padding:18px;
    box-shadow:0 6px 18px rgba(0,0,0,.06);
}
.filter-header{
    display:flex;
    justify-content:space-between;
    margin-bottom:14px;
}

/* ================= GRID ================= */
.supplier-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:22px;
}

/* ================= SUPPLIER CARD – PROFESSIONAL ================= */

.supplier-card{
    background:#ffffff;
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:18px;
    box-shadow:0 6px 18px rgba(0,0,0,.06);
    transition:all .25s ease;
}

.supplier-card:hover{
    border-color:#c7d2fe;
    box-shadow:0 10px 26px rgba(37,99,235,.15);
    transform:translateY(-2px);
}

/* HEADER */
.card-header{
    display:flex;
    gap:14px;
    align-items:flex-start;
}

/* LOGO */
.logo-circle{
    width:52px;
    height:52px;
    border-radius:12px;
    background:#1c2c3e;
    color:#fff;
    font-weight:700;
    font-size:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    flex-shrink:0;
}

.shop-logo-img{
    width:100%;
    height:100%;
    object-fit:contain;
    background:#ffffff;
}

/* INFO */
.supplier-info{
    flex:1;
}

.supplier-name{
    font-size:25px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:4px;
}

/* META */
.supplier-meta{
    font-size:13px;
    color:#64748b;
    margin:0;
}

.location-text{
    display:flex;
    align-items:center;
    gap:6px;
    font-size: 14px;
    color:#64748b;
}

.location-text i{
    color:#ef4444;
    
    font-size:14px;
}

/* TYPE BADGE */
.supplier-type{
    background:#eef2ff;
    color:#1e40af;
    font-weight:600;
    padding:4px 10px;
    border-radius:999px;
    font-size:12px;
}

/* BADGES */
.badges{
    display:flex;
    flex-direction:column;
    gap:6px;
}

.badge{
    font-size:11px;
    font-weight:700;
    padding:5px 10px;
    border-radius:8px;
    text-transform:uppercase;
}

.badge.featured{
    background:#fff7ed;
    color:#9a3412;
}

.badge.verified{
    background:#ecfdf5;
    color:#065f46;
}

/* MATERIAL TAGS */
.product-tags{
    display:flex;
    flex-wrap:wrap;
    gap:8px;
    margin:14px 0;
}

.product-tags span{
    background:#f8fafc;
    border:1px solid #e2e8f0;
    color:#334155;
    padding:6px 10px;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
}

/* INFO TAGS */
.info-tags{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    font-size:13px;
    color:#475569;
    padding-top:10px;
    border-top:1px dashed #e5e7eb;
}

.info-tags span{
    background:#f1f5f9;
    padding:6px 10px;
    border-radius:8px;
}

.info-tags .distance{
    background:#ecfdf5;
    color:#065f46;
}

/* ACTION */
.card-actions{
    margin-top:14px;
    display:flex;
    justify-content:center;
}

.btn-outline{
    display:flex;
    align-items:center;
    justify-content:center;
    padding:10px 26px;
    min-width:160px;
    border-radius:12px;
    background:#2563eb;
    color:#ffffff;
    font-weight:700;
    font-size:14px;
    text-decoration:none;
    transition:all .25s ease;
}

.btn-outline:hover{
    background:#1d4ed8;
    box-shadow:0 6px 18px rgba(37,99,235,.35);
    transform:translateY(-1px);
}

/* ================= CONTROL BAR ================= */

.control-bar{
    background:#ffffff;
    border-radius:14px;
    padding:16px;
    box-shadow:0 6px 18px rgba(0,0,0,.06);
    margin-bottom:20px;
}

/* SEARCH */
.find-search-bar{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:14px;
}

.find-search-bar i{
    color:#64748b;
}

.find-search-bar input{
    flex:1;
    border:none;
    outline:none;
    font-size:15px;
}

.find-search-bar .btn-search{
    background:#2563eb;
    color:#fff;
    border:none;
    padding:10px 22px;
    border-radius:10px;
    font-weight:600;
}

/* ================= LOCATION FILTER ================= */

.location-filters{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:12px;
}

.location-filters select{
    border:1px solid #e5e7eb;
    border-radius:10px;
    padding:10px 12px;
    font-size:14px;
}

/* ================= LAYOUT ================= */

.content{
    display:grid;
    grid-template-columns:260px 1fr;
    gap:22px;
}

/* ================= FILTER PANEL ================= */

.filters{
    background:#ffffff;
    border-radius:16px;
    padding:18px;
    box-shadow:0 6px 18px rgba(0,0,0,.06);
    position:sticky;
    top:20px;
    height:max-content;
}

.filter-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:14px;
}

.filter-header h6{
    font-weight:700;
    color:#0f172a;
}

.filter-header a{
    font-size:13px;
    font-weight:600;
    color:#2563eb;
    text-decoration:none;
}

/* FILTER SECTIONS */
.filter-section{
    margin-bottom:16px;
}

.filter-section h6{
    font-size:14px;
    font-weight:700;
    color:#0f172a;
    margin-bottom:8px;
}

/* CHECKBOX ITEMS */
.filter-item,
.filter-section label{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:14px;
    color:#475569;
    margin-bottom:6px;
    cursor:pointer;
}

.filter-section input[type="checkbox"]{
    accent-color:#2563eb;
}

/* ================= RESULTS GRID ================= */

.supplier-grid{
    display:grid;
    grid-template-columns:repeat(2, 1fr); /* ✅ EXACTLY 2 CARDS */
    gap:22px;
}

/* OPTIONAL: nice tablet/mobile fallback */
@media (max-width: 992px){
    .supplier-grid{
        grid-template-columns:1fr;
    }
}


</style>

    <div class="supplier-page">

        {{-- HEADER --}}
        <div class="find-suppliers-header">
            <div class="header-left">
                <div class="header-icon"><i class="bi bi-building"></i></div>
                <div>
                    <h5>Find Suppliers</h5>
                    <p>Construction materials near you</p>
                </div>
            </div>
        
        </div>

        {{-- SEARCH --}}
      <div class="control-bar">

        {{-- SEARCH --}}
        <div class="find-search-bar">
            <i class="bi bi-search"></i>
            <input type="text" id="searchText" placeholder="Search by product or supplier name...">
            <button class="btn-search" id="searchBtn">Search</button>
        </div>

        {{-- LOCATION --}}
        <div class="location-filters">
            <select id="filterState">
                <option value="">Select State</option>
                @foreach($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>

            <select id="filterRegion" disabled>
                <option value="">Select Region</option>
            </select>

            <select id="filterCity" disabled>
                <option value="">Select City</option>
            </select>
        </div>

    </div>


    <div class="content">

        {{-- FILTERS --}}
        
        <div class="filters">
            <div class="filter-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Filters</h6>
                <a href="javascript:void(0)" id="clearFilters">Clear All</a>
            </div>


            <div class="filter-section">
                    @foreach($material_categories as $category)
                        <label class="d-block">
                            <input 
                                type="checkbox" 
                                name="categories[]" 
                                value="{{ $category->id }}"
                                data-slug="{{ $category->slug }}"
                            >
                            {{ $category->name }}
                        </label>
                    @endforeach
            </div>
            <hr>
            <div class="filter-section">
                <h6>Delivery & Payment</h6>

                @foreach($delivery_type as $option)
                    <label class="filter-item">
                        <input 
                            type="checkbox"
                            name="delivery_payment[]"
                            value="{{ $option->id }}"
                        >
                        <span>{{ $option->type }}</span>
                    </label>
                @endforeach
            </div>
            <hr>
            <div class="filter-section">
        <h6>Credit Terms</h6>

        @foreach($credit_days as $term)
            <label class="filter-item">
                <input 
                    type="checkbox"
                    name="credit_terms[]"
                    value="{{ $term->id }}"
                >
                <span>{{ $term->days }}</span>
            </label>
        @endforeach
    </div>


    </div>

    {{-- RESULTS --}}
    <div>
        
        <div class="supplier-grid">
            @include('web.supplier_cards', ['supplier_data' => $supplier_data])
        </div>
       
    </div>

</div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
// 🔥 MAKE IT GLOBAL
function fetchSuppliers() {

    let categories = [];
    let delivery   = [];
    let credit     = [];
    let searchText = $('#searchText').val();

    let state  = $('#filterState').val();
    let region = $('#filterRegion').val();
    let city   = $('#filterCity').val();

    $('input[name="categories[]"]:checked').each(function () {
        categories.push($(this).val());
    });

    $('input[name="delivery_payment[]"]:checked').each(function () {
        delivery.push($(this).val());
    });

    $('input[name="credit_terms[]"]:checked').each(function () {
        credit.push($(this).val());
    });

    $.ajax({
        url: "{{ route('supplier.search.filter') }}",
        type: "GET",
        data: {
            categories: categories,
            delivery_payment: delivery,
            credit_terms: credit,
            search: searchText,
            state_id: state,
            region_id: region,
            city_id: city
        },
        success: function (res) {
            $('.supplier-grid').html(res);
        }
    });
}

$(document).ready(function () {

    // 🔄 Trigger on checkbox change
    $('input[type="checkbox"]').on('change', fetchSuppliers);

    // 🔍 Search button
    $('#searchBtn').on('click', fetchSuppliers);

    // ⌨️ Search while typing
    $('#searchText').on('keyup', fetchSuppliers);

    // ❌ Clear filters
    $('#clearFilters').on('click', function () {
        $('input[type="checkbox"]').prop('checked', false);
        $('#filterState,#filterRegion,#filterCity').val('').prop('disabled', true);
        fetchSuppliers();
    });

});
</script>
<script>
$(document).ready(function () {

    // 🔄 Trigger on checkbox change
    $('input[type="checkbox"]').on('change', function () {
        fetchSuppliers();
    });

     // 🔍 Search button click
    $('#searchBtn').on('click', fetchSuppliers);

       // ⌨️ Search while typing (optional but recommended)
    $('#searchText').on('keyup', function () {
        fetchSuppliers();
    });
    
    // ❌ Clear filters
    $('#clearFilters').on('click', function () {
        $('input[type="checkbox"]').prop('checked', false);
        fetchSuppliers();
    });

});
</script>

<script>
document.addEventListener('click', function (e) {

    const btn = e.target.closest('.btn-view-profile');
    if (!btn) return;

    e.preventDefault();

    const isLoggedIn = @json($isLoggedIn);
    const profileUrl = btn.dataset.url;

    const loginModalEl = document.getElementById('loginModal');
    const loginModal = loginModalEl ? new bootstrap.Modal(loginModalEl) : null;

    // 🔐 Not logged in
    if (!isLoggedIn) {
        loginModal?.show();
        return;
    }

    // ✅ Logged in
    window.location.href = profileUrl;
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const enquiryModalEl = document.getElementById('enquiryModal');
    const loginModalEl   = document.getElementById('loginModal');
    const formEl         = document.getElementById('enquiryForm');
    const categorySelect = document.getElementById('modalCategory');

    const enquiryModal = enquiryModalEl ? new bootstrap.Modal(enquiryModalEl) : null;
    const loginModal   = loginModalEl ? new bootstrap.Modal(loginModalEl) : null;

    const isLoggedIn = @json($isLoggedIn);

    document.querySelectorAll('.btn-enquire').forEach(btn => {

        btn.addEventListener('click', function () {

            // 🔐 LOGIN CHECK
            if (!isLoggedIn) {
                loginModal?.show();
                return;
            }

            // ✅ RESET FORM FIRST (IMPORTANT)
            formEl.reset();

            const supplierId   = this.dataset.supplierId;
            const supplierName = this.dataset.supplierName;

            document.getElementById('modalSupplierId').value = supplierId;
            document.getElementById('modalSupplierName').innerText = supplierName;

            // 🧱 POPULATE CATEGORIES
            const categories = JSON.parse(this.dataset.categories || '[]');
            categorySelect.innerHTML = '<option value="">Select Category</option>';

            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id;
                option.textContent = cat.name;
                categorySelect.appendChild(option);
            });

            enquiryModal?.show();
        });

    });

});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const form = document.getElementById('enquiryForm');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Sending...';

        const formData = new FormData(form);

        fetch("{{ route('supplier.enquiry.store') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {

            if (data.status) {
                alert('✅ Enquiry sent successfully');
                bootstrap.Modal.getInstance(
                    document.getElementById('enquiryModal')
                ).hide();
                form.reset();
            } else {
                alert(data.message || 'Something went wrong');
            }

        })
        .catch(() => {
            alert('Server error. Please try again.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Send enquiry';
        });
    });

});
</script>

<script>
$('#filterState').on('change', function () {

    const stateId = $(this).val();
    $('#filterRegion').prop('disabled', true).html('<option value="">Loading...</option>');
    $('#filterCity').prop('disabled', true).html('<option value="">Select City</option>');

    if (!stateId) {
        $('#filterRegion').html('<option value="">Select Region</option>').prop('disabled', true);
        fetchSuppliers();
        return;
    }

    $.get('/locations/regions/' + stateId, function (data) {
        let options = '<option value="">Select Region</option>';
        data.forEach(r => options += `<option value="${r.id}">${r.name}</option>`);
        $('#filterRegion').html(options).prop('disabled', false);
        fetchSuppliers();
    });
});

$('#filterRegion').on('change', function () {

    const regionId = $(this).val();
    $('#filterCity').prop('disabled', true).html('<option value="">Loading...</option>');

    if (!regionId) {
        $('#filterCity').html('<option value="">Select City</option>').prop('disabled', true);
        fetchSuppliers();
        return;
    }

    $.get('/locations/cities/' + regionId, function (data) {
        let options = '<option value="">Select City</option>';
        data.forEach(c => options += `<option value="${c.id}">${c.name}</option>`);
        $('#filterCity').html(options).prop('disabled', false);
        fetchSuppliers();
    });
});

$('#filterCity').on('change', fetchSuppliers);
</script>

@endsection
