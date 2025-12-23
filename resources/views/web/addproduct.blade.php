@extends('layouts.suppliersapp')
@section('title','Supplier Registration | ConstructKaro')
@section('content')

<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --border:#e5e7eb;
    --muted:#64748b;
    --bg:#f6f8fb;
    --card:#ffffff;
}

/* Page background */
.page-wrapper{
    background: var(--bg);
    padding: 25px 20px 90px;
}

/* Card */
.cardx{
    background: var(--card);
    border-radius: 14px;
    padding: 22px;
    border: 1px solid var(--border);
    box-shadow: 0 8px 24px rgba(0,0,0,0.06);
}

/* Title */
.cardx h5{
    font-weight: 700;
    color: var(--navy);
}

/* Table */
.table thead th{
    background:#f1f5f9;
    font-weight:700;
    font-size:14px;
    border-bottom:2px solid var(--border);
}

.table tbody td{
    vertical-align: top;
    font-size:14px;
}

/* Category */
.table tbody td:first-child{
    font-weight:600;
    color:#0f172a;
}

/* Checkbox */
.form-check-input{
    width:18px;
    height:18px;
    cursor:pointer;
}

/* Product wrapper */
.product-wrapper{
    background:#f9fafb;
    border:1px dashed var(--border);
    border-radius:10px;
    padding:12px;
    animation:fadeIn .25s ease-in;
}

/* Inputs */
.product-row input{
    font-size:13px;
}

/* Buttons */
.add-product{
    margin-top:8px;
    font-size:13px;
}
.remove-product{
    border-radius:50%;
    width:28px;
    height:28px;
    padding:0;
}

/* Sticky Save Bar */
.save-bar{
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #ffffff;
    padding: 12px 30px;
    border-top: 1px solid var(--border);
    z-index: 999;
    box-shadow: 0 -4px 16px rgba(0,0,0,.06);
}
.save-btn{
    background:#16a34a;
    border:none;
    padding:10px 28px;
    font-weight:700;
    border-radius:10px;
    box-shadow:0 8px 20px rgba(22,163,74,.35);
}
.save-btn:hover{
    background:#15803d;
}

/* Animation */
@keyframes fadeIn{
    from{opacity:0; transform:translateY(6px)}
    to{opacity:1; transform:none}
}
</style>

<div class="page-wrapper">

<form method="POST" action="{{ route('supplier.products.save') }}">
@csrf

{{-- SUCCESS / ERROR --}}
@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger mb-3">Please fix the errors and try again.</div>
@endif

<div class="cardx">
    <h5 class="mb-3">📦 Products & Categories</h5>

    @php
        $categoriesList = [
            'cement'        => 'Cement & Concrete',
            'steel'         => 'Steel & TMT Bars',
            'tiles'         => 'Tiles & Flooring',
            'paint'         => 'Paint & Coatings',
            'chemicals'     => 'Construction Chemicals',
            'plumbing'      => 'Plumbing Materials',
            'electrical'    => 'Electrical Items',
            'doors'         => 'Doors & Windows',
            'glass'         => 'Glass & Glazing',
            'hardware'      => 'Hardware & Tools',
            'machinery'     => 'Machineries & Equipments',
            'timber'        => 'Timber & Wood',
            'roofing'       => 'Roofing Materials',
            'scaffolding'   => 'Scaffolding',
            'hvac'          => 'HVAC & Utilities',
            'pavers'        => 'Pavers & Kerbstones',
            'compound_wall' => 'Compound Wall Materials',
            'road_safety'   => 'Road Safety Products',
            'facade'        => 'Facade & Cladding Materials',
        ];

        $savedCategories = json_decode($supplier->categories ?? '[]', true);
        $savedProducts   = json_decode($supplier->product_details ?? '{}', true);
    @endphp

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th width="25%">Material Category</th>
                    <th width="10%" class="text-center">Select</th>
                    <th width="65%">Products (Name • Unit • Price)</th>
                </tr>
            </thead>
            <tbody>

            @foreach($categoriesList as $key => $label)
                @php
                    $checked  = in_array($key, $savedCategories);
                    $products = $savedProducts[$key] ?? [];
                @endphp

                <tr>
                    <td>{{ $label }}</td>

                    <td class="text-center">
                        <input type="checkbox"
                               class="form-check-input category-check"
                               data-category="{{ $key }}"
                               name="categories[]"
                               value="{{ $key }}"
                               {{ $checked ? 'checked' : '' }}>
                    </td>

                    <td>
                        <div id="products_{{ $key }}"
                             class="product-wrapper"
                             style="{{ $checked ? '' : 'display:none' }}">

                            @foreach($products as $p)
                            <div class="row g-2 mb-2 product-row">
                                <div class="col-md-5">
                                    <input type="text" class="form-control form-control-sm"
                                           name="category_products[{{ $key }}][name][]"
                                           value="{{ $p['name'] ?? '' }}"
                                           placeholder="Product name">
                                </div>
                                <div class="col-md-3">
                                    <input type="text" class="form-control form-control-sm"
                                           name="category_products[{{ $key }}][unit][]"
                                           value="{{ $p['unit'] ?? '' }}"
                                           placeholder="Unit">
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control form-control-sm"
                                           name="category_products[{{ $key }}][price][]"
                                           value="{{ $p['price'] ?? '' }}"
                                           placeholder="Price">
                                </div>
                                <div class="col-md-1 d-flex align-items-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm remove-product">✕</button>
                                </div>
                            </div>
                            @endforeach

                            <button type="button"
                                    class="btn btn-sm btn-outline-primary add-product"
                                    data-category="{{ $key }}">
                                + Add Product
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>

<div class="save-bar text-end">
    <button type="submit" class="btn save-btn">
        💾 Save Products
    </button>
</div>

</form>
</div>

<script>
document.addEventListener('click', function (e) {

    // ADD PRODUCT ROW
    if (e.target.classList.contains('add-product')) {
        const cat = e.target.dataset.category;
        const wrap = document.getElementById('products_' + cat);

        const row = document.createElement('div');
        row.className = 'row g-2 mb-2 product-row';
        row.innerHTML = `
            <div class="col-md-5">
                <input type="text" class="form-control form-control-sm"
                       name="category_products[${cat}][name][]" placeholder="Product name">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control form-control-sm"
                       name="category_products[${cat}][unit][]" placeholder="Unit">
            </div>
            <div class="col-md-3">
                <input type="number" class="form-control form-control-sm"
                       name="category_products[${cat}][price][]" placeholder="Price">
            </div>
            <div class="col-md-1 d-flex align-items-center">
                <button type="button"
                        class="btn btn-outline-danger btn-sm remove-product">✕</button>
            </div>
        `;
        wrap.insertBefore(row, e.target);
    }

    // REMOVE PRODUCT ROW
    if (e.target.classList.contains('remove-product')) {
        e.target.closest('.product-row').remove();
    }
});

// SHOW / HIDE CATEGORY (FIXED)
document.querySelectorAll('.category-check').forEach(cb => {
    cb.addEventListener('change', function () {
        const wrap = document.getElementById('products_' + this.dataset.category);

        if (this.checked) {
            wrap.style.display = 'block';
        } else {
            wrap.style.display = 'none';
        }
    });
});
</script>

@endsection
