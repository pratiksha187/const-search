@extends($layout)
@section('title', $supplier->shop_name.' | Supplier Profile')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
:root{
    --primary:#4f46e5;
    --primary-soft:#eef2ff;
    --success:#16a34a;
    --text-dark:#0f172a;
    --text-muted:#64748b;
}

/* BODY */
body{
    background:linear-gradient(180deg,#f8fafc,#eef2ff);
    font-family:'Inter',system-ui;
    color:var(--text-dark);
}

/* CARD */
.card-box{
    background:#fff;
    border-radius:20px;
    padding:26px;
    box-shadow:0 20px 40px rgba(79,70,229,.08);
}

/* PROFILE HEADER */
.profile-card{
    background:linear-gradient(135deg,#4f46e5,#6366f1);
    color:#fff;
    border-radius:24px;
    padding:28px;
    margin-bottom:24px;
}

/* PRODUCT TABLE */
.product-table{
    border-collapse:separate;
    border-spacing:0 8px;
    font-size:14px;
}
.product-table tbody tr{
    background:#fff;
    box-shadow:0 6px 14px rgba(0,0,0,.06);
}
.product-table td{
    vertical-align:middle;
}

/* CATEGORY ROW */
.category-row td{
    background:#eef2ff;
    font-weight:800;
    color:#1e3a8a;
}

/* PRODUCT ROW */
.product-row td{
    background:#f8fafc;
    font-weight:700;
}

/* VARIANT ROW */
.variant-row td{
    background:#fff;
    font-size:13px;
}

/* QTY */
.qty-box{
    display:flex;
    gap:4px;
}
.qty-btn{
    background:var(--primary-soft);
    color:var(--primary);
    border:none;
    width:26px;
    height:26px;
    border-radius:6px;
}
.qty-input{
    width:40px;
    text-align:center;
    font-weight:700;
}

/* ADD */
.add-to-cart{
    border-radius:999px;
    font-weight:600;
}

/* CART */
.cart-summary{
    position:sticky;
    bottom:20px;
    background:linear-gradient(135deg,#16a34a,#22c55e);
    color:#fff;
}
</style>

{{-- ================= PROFILE ================= --}}
<div class="profile-card">
    <h2 class="fw-bold">{{ $supplier->shop_name }}</h2>
    <p class="mb-2">
        {{ ucfirst($supplier->primary_type ?? 'Supplier') }} |
        {{ $supplier->statename }}, {{ $supplier->cityname }}
    </p>

    <div class="d-flex gap-3 flex-wrap">
        <span class="badge bg-success">✔ Verified Supplier</span>
        <span class="badge bg-light text-dark">⭐ 5+ Years Experience</span>
        <span class="badge bg-light text-dark">🚚 Delivery {{ $supplier->maximum_distance ?? 50 }} km</span>
    </div>
</div>

{{-- ================= PRODUCTS OFFERED ================= --}}
<div class="card-box">
    <h4 class="fw-bold mb-3">📦 Products Offered</h4>

    <div class="table-responsive">
        <table class="table align-middle product-table">
            <thead class="table-light">
                <tr>
                    <th width="200">Category</th>
                    <th width="220">Product</th>
                    <th>Specification</th>
                    <th>Brand</th>
                    <th>MOQ</th>
                    <th width="140">Quantity</th>
                    <th width="120">Action</th>
                </tr>
            </thead>

            <tbody>
            @foreach($grouped as $categoryName => $products)

                {{-- CATEGORY --}}
                <tr class="category-row">
                    <td colspan="7">{{ $categoryName }}</td>
                </tr>

                @foreach($products as $productName => $items)

                    {{-- PRODUCT --}}
                    <tr class="product-row">
                        <td></td>
                        <td colspan="6">{{ $productName }}</td>
                    </tr>

                    @foreach($items as $item)

                    @php
                    $productJson = [
                        // 🔑 IDS (for DB)
                        'category_id' => $item->category_id,
                        'product_id'  => $item->product_id,
                        'spec_id'     => $item->spec_id,
                        'brand_id'    => $item->brand_id,

                        // 🧾 LABELS (for UI only)
                        'category' => $categoryName,
                        'product'  => $productName,
                        'spec'     => $item->material_subproduct,
                        'brand'    => $item->brand_name,
                    ];
                    @endphp


                    {{-- VARIANT --}}
                    <tr class="variant-row" data-product='@json($productJson)'>
                        <td></td>
                        <td></td>
                        <td>{{ $item->material_subproduct }}</td>
                        <td>{{ $item->brand_name }}</td>
                        <td>{{ $supplier->minimum_order_qty ?? 'N/A' }}</td>
                        <td>
                            <div class="qty-box">
                                <button class="qty-btn minus">−</button>
                                <input type="text" class="qty-input" value="1">
                                <button class="qty-btn plus">+</button>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary add-to-cart">
                                <i class="bi bi-cart-plus"></i> Add
                            </button>
                        </td>
                    </tr>

                    @endforeach
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- ================= CART ================= --}}
<div class="card-box cart-summary d-none mt-4" id="cartSummary">
    <h5 class="fw-bold">🛒 Selected Items</h5>
    <div id="cartItems" class="small mb-3"></div>
    <button class="btn btn-light w-100 fw-bold cta-quote" id="openEnquiry">
        Proceed to Enquiry →
    </button>

</div>
<!-- ================= ENQUIRY MODAL ================= -->
<div class="modal fade" id="enquiryModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <div>
          <h5 class="modal-title fw-bold">Place Order / Request Quotation</h5>
          <small class="text-muted">{{ $supplier->shop_name }}</small>
        </div>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form method="POST" action="{{ route('productenquirystore') }}">

        <input type="hidden" name="supplier_id" id="modalSupplierId" value="{{ $supplier->id }}">
        <input type="hidden" name="customer_id" value="{{ session('customer_id') }}">
        <input type="hidden" name="vendor_id" value="{{ session('vendor_id') }}">
        @csrf

        <div class="modal-body">

          <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
          <input type="hidden" name="cart_data" id="cartData">

          <div class="table-responsive mb-4">
            <table class="table table-bordered">
              <thead class="table-light">
                <tr>
                  <th>Product</th>
                  <th>Specification</th>
                  <th>Brand</th>
                  <th width="100">Qty</th>
                </tr>
              </thead>
              <tbody id="modalCartTable"></tbody>
            </table>
          </div>

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Delivery Location</label>
              <input type="text" name="delivery_location" class="form-control" required>
            </div>

            <div class="col-md-6">
              <label class="form-label">Required By Date</label>
              <input type="date" name="required_by" class="form-control">
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="submit" class="btn btn-dark px-4">
            Send Enquiry
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

{{-- ================= SCRIPTS ================= --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
let cart = [];

document.addEventListener('click', e => {

    if(e.target.classList.contains('plus')){
        let i = e.target.previousElementSibling;
        i.value = +i.value + 1;
    }

    if(e.target.classList.contains('minus')){
        let i = e.target.nextElementSibling;
        if(+i.value > 1) i.value--;
    }

    if(e.target.classList.contains('add-to-cart')){
        let row = e.target.closest('tr');
        let data = JSON.parse(row.dataset.product);
        let qty  = row.querySelector('.qty-input').value;

        cart.push({...data, qty});
        renderCart();
    }
});

function renderCart(){
    let box = document.getElementById('cartSummary');
    let list = document.getElementById('cartItems');

    box.classList.remove('d-none');
    list.innerHTML = '';

    cart.forEach(i => {
        list.innerHTML += `
            <div class="d-flex justify-content-between">
                <span>${i.product} (${i.spec})</span>
                <strong>${i.qty}</strong>
            </div>`;
    });
}
</script>
<script>
document.getElementById('openEnquiry')?.addEventListener('click', () => {

    if(cart.length === 0){
        alert('Please add at least one product');
        return;
    }

    let tbody  = document.getElementById('modalCartTable');
    let hidden = document.getElementById('cartData');

    tbody.innerHTML = '';

    cart.forEach(item => {
        tbody.innerHTML += `
            <tr>
                <td>${item.product}</td>
                <td>${item.spec}</td>
                <td>${item.brand}</td>
                <td class="fw-bold">${item.qty}</td>
            </tr>
        `;
    });

    hidden.value = JSON.stringify(cart);

    let modal = new bootstrap.Modal(document.getElementById('enquiryModal'));
    modal.show();
});
</script>

@endsection
