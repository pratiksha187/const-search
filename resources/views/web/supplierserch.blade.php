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
.btn-primary{
    flex:1;
    border:2px solid #225ed7;
    background:#fff;
    padding:12px;
    border-radius:10px;
    font-weight:600;

    text-decoration:none;   /* ✅ removes underline */
    color:#1f2937;          /* optional: normal text color */
}
.btn-outline:hover{
    text-decoration:none;
}


.btn-post{
    background:#fff;
    color:#1f2937;
    padding:8px 14px;
    border-radius:8px;
    font-weight:600;
    text-decoration:none;
    font-size:14px;
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

/* ================= SUPPLIER CARD ================= */
.supplier-card{
    background:#fffdf5;
    border-radius:18px;
    padding:18px;
    border:2px solid #fde68a;
    box-shadow:0 10px 25px rgba(253,230,138,.35);
    transition:
        background .3s ease,
        border-color .3s ease,
        box-shadow .3s ease,
        transform .2s ease;
}

/* HOVER ONLY (NO RANDOM COLOR CHANGE) */
.supplier-card:hover{
    background:#f0f9ff;
    border-color:#93c5fd;
    box-shadow:0 14px 32px rgba(147,197,253,.45);
    transform:translateY(-3px);
}

/* ================= CARD HEADER ================= */
.card-header{
    display:flex;
    align-items:flex-start;
    gap:12px;
}
.logo-circle{
    width:50px;
    height:50px;
    border-radius:14px;
    background:#2563eb;
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
    font-size:18px;
}

/* ================= BADGES ================= */
.badges{
    margin-left:auto;
    display:flex;
    flex-direction:column;
    gap:6px;
}
.badge{
    font-size:12px;
    font-weight:700;
    padding:6px 12px;
    border-radius:8px;
}
.badge.featured{ background:#fbbf24; color:#78350f; }
.badge.verified{ background:#22c55e; color:#fff; }
.badge.enterprise{ background:#8b5cf6; color:#fff; }

/* ================= TAGS ================= */
.product-tags span{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:#eef2ff;
    color:#1e3a8a;
    padding:6px 10px;
    border-radius:8px;
    font-size:13px;
    font-weight:600;
    margin-right:6px;
    margin-top:10px;
}
.info-tags span{
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:#f1f5f9;
    padding:6px 10px;
    border-radius:8px;
    font-size:13px;
    margin-right:6px;
    margin-top:10px;
}
.info-tags .distance{
    background:#dcfce7;
    color:#166534;
}

/* ================= ACTIONS ================= */
.card-actions{
    display:flex;
    gap:12px;
    margin-top:16px;
}
.btn-outline{
    flex:1;
    border:2px solid #e5e7eb;
    background:#fff;
    padding:12px;
    border-radius:10px;
    font-weight:600;
}
.btn-primary{
    flex:1;
    background:#2563eb;
    color:#fff;
    padding:12px;
    border-radius:10px;
    border:none;
    font-weight:700;
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
    <!-- <a href="#" class="btn-post">Post Requirement</a> -->
</div>

{{-- SEARCH --}}
<div class="find-search-bar">
    <i class="bi bi-search"></i>
    <input type="text" placeholder="Search by product, location, or supplier name...">
    <button class="btn-search">Search</button>
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
$(document).ready(function () {

    function fetchSuppliers() {

        let categories = [];
        let delivery   = [];
        let credit     = [];

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
                credit_terms: credit
            },
            success: function (res) {
                $('.supplier-grid').html(res);
            }
        });
    }

    // 🔄 Trigger on checkbox change
    $('input[type="checkbox"]').on('change', function () {
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
@endsection
