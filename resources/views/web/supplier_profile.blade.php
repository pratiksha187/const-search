@extends($layout)
@section('title', $supplier->shop_name.' | Supplier Profile')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
   /* ================= THEME ================= */
   :root{
   --primary:#2563eb;
   --primary-soft:#eef2ff;
   --success:#16a34a;
   --text:#0f172a;
   --muted:#64748b;
   --border:#e5e7eb;
   --bg:#f6f8fc;
   }
   body{
   background:var(--bg);
   font-family:Inter,system-ui;
   }
   /* ================= PROFILE ================= */
   /* .profile-card{
   background:linear-gradient(135deg,#2563eb,#4f46e5);
   color:#fff;
   border-radius:18px;
   padding:26px;
   margin-bottom:28px;
   } */
   /* ================= WRAPPER ================= */
   .card-box{
   background:#fff;
   border-radius:20px;
   padding:22px;
   box-shadow:0 15px 35px rgba(0,0,0,.08);
   }
   /* ================= CATEGORY BLOCK ================= */
   .category-block{
   background:#f9fafb;
   border:1px solid var(--border);
   border-radius:18px;
   padding:18px;
   margin-bottom:26px;
   }
   /* CATEGORY HEADER */
   .category-title{
   background:#fff;
   padding:14px 18px;
   border-radius:14px;
   font-size:18px;
   font-weight:800;
   display:flex;
   justify-content:space-between;
   align-items:center;
   cursor:pointer;
   box-shadow:0 6px 16px rgba(0,0,0,.06);
   }
   .category-title .icon{
   font-size:22px;
   transition:.3s;
   }
   .category-title.active .icon{
   transform:rotate(45deg);
   }
   /* ================= PRODUCT BLOCK ================= */
   .product-block{
   background:#fff;
   border-radius:16px;
   padding:18px;
   margin-top:18px;
   border:1px solid #eef2f7;
   }
   /* PRODUCT HEADER */
   .product-subtitle{
   font-size:15px;
   font-weight:700;
   display:flex;
   justify-content:space-between;
   align-items:center;
   cursor:pointer;
   padding-bottom:10px;
   border-bottom:1px dashed var(--border);
   }
   .product-subtitle .icon{
   font-size:20px;
   transition:.3s;
   }
   .product-subtitle.active .icon{
   transform:rotate(45deg);
   }
   /* ================= GRID ================= */
   .product-grid{
   display:grid;
   grid-template-columns:repeat(auto-fill,minmax(230px,1fr));
   gap:18px;
   margin-top:18px;
   }
   /* ================= PRODUCT CARD ================= */
   .product-card{
   background:#fff;
   border-radius:16px;
   padding:14px;
   box-shadow:0 10px 30px rgba(0,0,0,.08);
   display:flex;
   flex-direction:column;
   transition:.25s;
   }
   .product-card:hover{
   transform:translateY(-4px);
   }
   .cart-summary{
   position:sticky;
   bottom:20px;
   z-index:10;
   }
   .cart-item{
   display:flex;
   justify-content:space-between;
   align-items:center;
   padding:8px 0;
   border-bottom:1px dashed var(--border);
   }
   .cart-item:last-child{border-bottom:none}
   .cart-remove{
   color:#dc2626;
   cursor:pointer;
   font-weight:700;
   }
   /* IMAGE */
   .product-img{
   height:150px;
   background:#f3f4f6;
   border-radius:12px;
   display:flex;
   align-items:center;
   justify-content:center;
   margin-bottom:10px;
   }
   .product-img img{
   max-width:100%;
   max-height:100%;
   object-fit:contain;
   }
   /* TEXT */
   .product-title{font-weight:700;font-size:14px}
   .product-meta{font-size:12px;color:var(--muted);margin:6px 0}
   .product-price{font-weight:800;color:var(--success);margin-bottom:8px}
   /* QTY */
   .qty-box{display:flex;gap:6px;margin-bottom:8px}
   .qty-btn{
   width:28px;height:28px;border-radius:6px;
   border:1px solid #c7d2fe;background:#eef2ff;font-weight:700;
   }
   .qty-input{
   width:42px;text-align:center;border:1px solid #c7d2fe;border-radius:6px;
   }
   /* BUTTON */
   .add-cart-btn{
   margin-top:auto;
   background:#2563eb;
   color:#fff;
   border:none;
   border-radius:12px;
   padding:9px;
   font-weight:600;
   }
   .add-cart-btn:hover{background:#1e40af}

   .profile-card{
    background:#ffffff;
    border-radius:16px;
    padding:22px;
    box-shadow:0 8px 24px rgba(0,0,0,.08);
    border:1px solid #e5e7eb;
}

/* TITLE */
.supplier-title{
    font-size:22px;
    font-weight:800;
    color:#0f172a;
    margin-bottom:4px;
}

/* LOCATION */
.supplier-location{
    font-size:15px;
    color:#475569;
    display:flex;
    align-items:center;
    gap:6px;
    margin-bottom:10px;
}

.supplier-location i{
    color:#ef4444;
}

/* BADGES */
.supplier-badges{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.badge{
    font-size:13px;
    font-weight:600;
    padding:6px 12px;
    border-radius:999px;
}

/* VERIFIED */
.badge-verified{
    background:#ecfdf5;
    color:#065f46;
}

/* DISTANCE */
.badge-distance{
    background:#f1f5f9;
    color:#334155;
}

/* CREDIT */
.badge-credit{
    background:#eef2ff;
    color:#1e40af;
}

/* ACTION */
.profile-actions{
    display:flex;
    align-items:center;
}

.profile-actions .btn{
    padding:10px 18px;
    font-weight:700;
    border-radius:12px;
}


.supplier-profile-card{
    background:#ffffff;
    border-radius:18px;
    padding:24px;
    box-shadow:0 12px 32px rgba(0,0,0,.08);
    max-width:100%;
}

/* HEADER */
.profile-logo{
    width:90px;
    height:90px;
    border-radius:16px;
    background:#1c2c3e;
    color:#fff;
    font-size:30px;
    font-weight:800;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

.profile-logo img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.supplier-name{
    font-size:26px;
    font-weight:800;
    color:#0f172a;
}

.supplier-location{
    font-size:14px;
    color:#475569;
}

/* BADGES */
.badge-row{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    margin-top:8px;
}

.badge{
    padding:6px 14px;
    font-size:13px;
    font-weight:600;
    border-radius:999px;
}

.badge.verified{background:#ecfdf5;color:#065f46;}
.badge.msme{background:#eef2ff;color:#1e40af;}
.badge.distance{background:#f1f5f9;color:#334155;}

/* GRID SECTIONS */
.section-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:16px 30px;
    margin-top:16px;
}

.section-grid span{
    display:block;
    font-size:13px;
    color:#64748b;
}

.section-grid strong{
    font-size:15px;
    color:#0f172a;
}

/* DOC LINKS */
.doc-row{
    display:flex;
    gap:14px;
    flex-wrap:wrap;
    margin-top:14px;
}

.doc-row a{
    font-size:13px;
    font-weight:600;
    color:#2563eb;
    text-decoration:none;
}

.doc-row a:hover{
    text-decoration:underline;
}

hr{
    margin:20px 0;
    border-top:1px dashed #e5e7eb;
}



/* ===== SUPPLIER HERO CARD ===== */
.supplier-card-pro{
    background:#fff;
    border-radius:20px;
    padding:26px;
    box-shadow:0 18px 45px rgba(0,0,0,.10);
    border:1px solid #eef2f7;
    margin-bottom:28px;
}

/* TOP */
.supplier-top{
    display:grid;
    grid-template-columns:90px 1fr auto;
    gap:20px;
    align-items:center;
}

.supplier-logo{
    width:90px;
    height:90px;
    border-radius:18px;
    background:linear-gradient(135deg,#1c2c3e,#0f172a);
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
    color:#fff;
    font-size:30px;
    font-weight:800;
}

.supplier-logo img{
    width:100%;
    height:100%;
    object-fit:cover;
}

.supplier-name{
    font-size:26px;
    font-weight:900;
    color:#0f172a;
}

.supplier-location{
    font-size:14px;
    color:#64748b;
    margin-top:4px;
}

/* BADGES */
.supplier-badges{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
    margin-top:10px;
}

.badge-pill{
    padding:6px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.badge-verified{background:#ecfdf5;color:#065f46;}
.badge-msme{background:#eef2ff;color:#1e40af;}
.badge-distance{background:#fff7ed;color:#9a3412;}

/* QUICK STATS */
.quick-stats{
    display:flex;
    gap:12px;
}

.stat-box{
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:14px;
    padding:10px 14px;
    text-align:center;
}

.stat-box span{
    display:block;
    font-size:12px;
    color:#64748b;
}

.stat-box strong{
    font-size:15px;
    color:#0f172a;
}

/* DIVIDER */
.hr-soft{
    border:none;
    border-top:1px dashed #e5e7eb;
    margin:22px 0;
}

/* INFO GRID */
.info-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:18px 40px;
}

.info-item span{
    font-size:12px;
    color:#64748b;
}

.info-item strong{
    font-size:15px;
    color:#0f172a;
    display:block;
    margin-top:2px;
}

/* DOCS */
.doc-links{
    display:flex;
    gap:16px;
    flex-wrap:wrap;
}

.doc-links a{
    background:#f1f5f9;
    border-radius:10px;
    padding:8px 14px;
    font-size:13px;
    font-weight:700;
    color:#2563eb;
    text-decoration:none;
}

.doc-links a:hover{
    background:#e0e7ff;
}

/* MOBILE */
@media(max-width:992px){
    .supplier-top{
        grid-template-columns:1fr;
    }
    .info-grid{
        grid-template-columns:1fr;
    }
    .quick-stats{
        flex-wrap:wrap;
    }
}
.doc-links .no-docs{
    font-size:13px;
    color:#64748b;
    background:#f8fafc;
    padding:8px 12px;
    border-radius:8px;
    display:inline-block;
}

</style>
{{-- ================= PROFILE ================= --}}
<div class="supplier-card-pro">

    {{-- TOP --}}
    <div class="supplier-top">

        {{-- LOGO --}}
        <div class="supplier-logo">
            @if($supplier->shop_logo)
                <img src="{{ asset('storage/'.$supplier->shop_logo) }}">
            @else
                {{ strtoupper(substr($supplier->shop_name,0,1)) }}
            @endif
        </div>

        {{-- BASIC INFO --}}
        <div>
            <div class="supplier-name">{{ $supplier->shop_name }}</div>
            <div class="supplier-location">
                <i class="bi bi-geo-alt-fill text-danger"></i>
                {{ $supplier->shop_address }},
                {{ $supplier->cityname }},
                {{ $supplier->regionname }},
                {{ $supplier->statename }}
            </div>

            <div class="supplier-badges">
                <span class="badge-pill badge-verified">✔ Verified</span>
                @if($supplier->msme_status === 'yes')
                    <span class="badge-pill badge-msme">MSME Registered</span>
                @endif
                <span class="badge-pill badge-distance">
                    🚚 {{ $supplier->maximum_distance }} km delivery
                </span>
            </div>
        </div>

        {{-- QUICK STATS --}}
        <div class="quick-stats">
            <div class="stat-box">
                <span>Credit</span>
                <strong>{{ $supplier->credit_days_value }}</strong>
            </div>
            <div class="stat-box">
                <span>MOQ</span>
                <strong>₹ {{ number_format($supplier->minimum_order_cost) }}</strong>
            </div>
            <div class="stat-box">
                <span>Delivery</span>
                <strong>{{ $supplier->delivery_days }} Days</strong>
            </div>
        </div>

    </div>

    <hr class="hr-soft">

    {{-- DETAILS --}}
    <div class="info-grid">
        <div class="info-item">
            <span>Contact Person</span>
            <strong>{{ $supplier->contact_person }}</strong>
        </div>
        <div class="info-item">
            <span>Mobile</span>
            <strong>{{ $supplier->mobile }}</strong>
        </div>
        <div class="info-item">
            <span>Email</span>
            <strong>{{ $supplier->email }}</strong>
        </div>
        <div class="info-item">
            <span>Experience</span>
            <strong>{{ $supplier->experiance_year }}</strong>
        </div>
        <div class="info-item">
            <span>Working Hours</span>
            <strong>{{ $supplier->open_time }} – {{ $supplier->close_time }}</strong>
        </div>
        <div class="info-item">
            <span>Delivery Type</span>
            <strong>{{ $supplier->delivery_type == 2 ? 'Home Delivery' : 'Pickup' }}</strong>
        </div>
    </div>

    <hr class="hr-soft">

    {{-- LEGAL --}}
    <div class="info-grid">
        <div class="info-item">
            <span>GST Number</span>
            <strong>{{ $supplier->gst_number }}</strong>
        </div>
        <div class="info-item">
            <span>PAN Number</span>
            <strong>{{ $supplier->pan_number }}</strong>
        </div>
    </div>

    {{-- DOCUMENTS --}}
    <div class="doc-links mt-3">

    @php
        $hasDocs =
            $supplier->gst_certificate_path ||
            $supplier->pan_card_path ||
            $supplier->shop_license_path ||
            $supplier->sample_invoice_path ||
            $supplier->costing_sheet_path;
    @endphp

    @if($hasDocs)

        @if($supplier->gst_certificate_path)
            <a href="{{ asset('storage/'.$supplier->gst_certificate_path) }}" target="_blank">
                GST Certificate
            </a>
        @endif

        @if($supplier->pan_card_path)
            <a href="{{ asset('storage/'.$supplier->pan_card_path) }}" target="_blank">
                PAN Card
            </a>
        @endif

        @if($supplier->shop_license_path)
            <a href="{{ asset('storage/'.$supplier->shop_license_path) }}" target="_blank">
                Shop License
            </a>
        @endif

        @if($supplier->sample_invoice_path)
            <a href="{{ asset('storage/'.$supplier->sample_invoice_path) }}" target="_blank">
                Sample Invoice
            </a>
        @endif

        @if($supplier->costing_sheet_path)
            <a href="{{ asset('storage/'.$supplier->costing_sheet_path) }}" target="_blank">
                Costing Sheet
            </a>
        @endif

    @else
       
          <span class="no-docs">📄 No documents uploaded</span>

        
    @endif

</div>


</div>


{{-- ================= PRODUCTS ================= --}}
<div class="card-box mb-3">
    <div class="input-group">
        <span class="input-group-text bg-white">
            🔍
        </span>
        <input type="text" id="productSearch"
               class="form-control"
               placeholder="Search product, specification or brand...">
    </div>
</div>

<div class="card-box">
   @foreach($grouped as $categoryName => $products)
   <div class="category-block">
      <div class="category-title category-toggle">
         <span>{{ $categoryName }}</span>
         <span class="icon">+</span>
      </div>
      <div class="category-content d-none">
         @foreach($products as $productName => $items)
         <div class="product-block">
            <div class="product-subtitle product-toggle">
               <span>{{ $productName }}</span>
               <span class="icon">+</span>
            </div>
            <div class="product-grid d-none">
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
                        'p_image'    => $item->p_image ?? null,
                        'unit'      => $item->unitname ?? 'N/A',
                        'price'     => $item->price ?? '0',
                        'available_qty' => (int) ($item->spquntity ?? 0),
                    ];
                    @endphp
                    <div class="product-card" data-product='@json($productJson)'>
                        <div class="product-img">
                            @if($item->p_image)
                            <img src="{{ asset('uploads/products/'.$item->p_image) }}">
                            @else
                            <span class="text-muted">No Image</span>
                            @endif
                        </div>
                        <div class="product-title">{{ $item->material_subproduct }}</div>
                        <div class="product-meta">
                            Brand: {{ $item->brand_name }}<br>
                            Unit: {{ $item->unitname ?? 'N/A' }}
                        </div>
                        <div class="product-price">
                            ₹ {{ number_format($item->price ?? 0,2) }}
                        </div>
                        <div class="qty-box">
                            <button class="qty-btn minus">−</button>
                            <input class="qty-input" value="1">
                            <button class="qty-btn plus">+</button>
                        </div>
                        <button class="add-cart-btn add-to-cart">
                        <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                    @endforeach
            </div>
         </div>
         @endforeach
      </div>
   </div>
   @endforeach
</div>
<div class="modal fade" id="enquiryModal" tabindex="-1">
   <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title fw-bold">Place Order / Request Quotation</h5>
            <button class="btn-close" data-bs-dismiss="modal"></button>
         </div>
         <form method="POST" action="{{ route('productenquirystore') }}">
            @csrf
            <input type="hidden" name="supplier_id" value="{{ $supplier->id }}">
            <input type="hidden" name="cart_data" id="cartData">
            <input type="hidden" name="sub_total" id="subTotalInput">
            <input type="hidden" name="gst_total" id="gstTotalInput">
            <input type="hidden" name="grand_total" id="grandTotalInput">
            <input type="hidden" name="customer_id" value="{{ session('customer_id') }}">
            <input type="hidden" name="vendor_id" value="{{ session('vendor_id') }}">
            <div class="modal-body">
               <div class="table-responsive mb-4">
                  <table class="table table-bordered">
                     <thead class="table-light">
                        <tr>
                           <th>Product</th>
                           <th>Specification</th>
                           <th>Brand</th>
                           <th>Unit</th>
                           <th>Price</th>
                           <th>Qty</th>
                           <th>GST</th>
                           <th>GST Amt</th>
                           <th>Total</th>
                        </tr>
                     </thead>
                     <tbody id="modalCartTable">
                        <tr>
                            <th colspan="8" class="text-end">Sub Total</th>
                            <th id="subTotal">₹ 0.00</th>
                        </tr>
                        <tr>
                            <th colspan="8" class="text-end">Total GST</th>
                            <th id="gstTotal">₹ 0.00</th>
                        </tr>
                        <tr>
                            <th colspan="8" class="text-end fw-bold">Grand Total</th>
                            <th class="fw-bold" id="grandTotal">₹ 0.00</th>
                        </tr>
                     </tbody>
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
               <button type="submit" class="btn btn-dark px-4">Send Enquiry</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="card-box cart-summary d-none mt-4" id="cartSummary">
   <h5 class="fw-bold mb-3">🛒 Selected Items</h5>
   <div id="cartItems" class="small mb-3"></div>
   <button class="btn btn-dark w-100 fw-bold cta-quote" id="openEnquiry">
   Proceed to Enquiry →
   </button>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
   let cart = [];
   
   /* ================= CATEGORY & PRODUCT TOGGLES ================= */
   document.querySelectorAll('.category-toggle').forEach(cat=>{
       cat.addEventListener('click',()=>{
           document.querySelectorAll('.category-content').forEach(c=>{
               if(c!==cat.nextElementSibling){
                   c.classList.add('d-none');
                   c.previousElementSibling.classList.remove('active');
               }
           });
           cat.nextElementSibling.classList.toggle('d-none');
           cat.classList.toggle('active');
       });
   });
   
   document.querySelectorAll('.product-toggle').forEach(p=>{
       p.addEventListener('click',()=>{
           p.nextElementSibling.classList.toggle('d-none');
           p.classList.toggle('active');
       });
   });
   
   /* ================= GLOBAL CLICK HANDLER ================= */
   document.addEventListener('click', e => {
   
       /* PLUS QTY */
       if(e.target.classList.contains('plus')){
           const card = e.target.closest('.product-card');
           const input = card.querySelector('.qty-input');
           const data = JSON.parse(card.dataset.product);
   
           if(+input.value >= data.available_qty){
               alert(`Only ${data.available_qty} available`);
               return;
           }
           input.value++;
       }
   
       /* MINUS QTY */
       if(e.target.classList.contains('minus')){
           const input = e.target.closest('.product-card').querySelector('.qty-input');
           if(+input.value > 1) input.value--;
       }
   
       /* ADD TO CART */
       if(e.target.classList.contains('add-to-cart')){
           const card = e.target.closest('.product-card');
           const data = JSON.parse(card.dataset.product);
           const qty  = +card.querySelector('.qty-input').value;
   
           if(data.available_qty === 0){
               alert('Out of stock');
               return;
           }
   
           if(qty > data.available_qty){
               alert(`Only ${data.available_qty} available`);
               return;
           }
   
           addToCart(data, qty);
       }
   
       /* REMOVE FROM CART */
       if(e.target.classList.contains('cart-remove')){
           const index = e.target.dataset.index;
           cart.splice(index,1);
           renderCartSummary();
       }
   
       /* PROCEED TO ENQUIRY */
       if(e.target.id === 'openEnquiry'){
           openModal();
       }
   });
   
   /* ================= CART SUMMARY ================= */
   function renderCartSummary(){
       const box   = document.getElementById('cartSummary');
       const items = document.getElementById('cartItems');
   
       if(cart.length === 0){
           box.classList.add('d-none');
           items.innerHTML = '';
           return;
       }
   
       box.classList.remove('d-none');
       items.innerHTML = '';
   
       cart.forEach((item,index)=>{
           items.innerHTML += `
           <div class="cart-item">
               <div>
                   <strong>${item.product}</strong><br>
                   <small>${item.spec} | ${item.brand}</small><br>
                   <small>Qty: ${item.qty} ${item.unit}</small>
               </div>
               <span class="cart-remove" data-index="${index}">✕</span>
           </div>`;
       });
   }
   
   /* ================= ADD / MERGE CART ================= */
   function addToCart(data, qty){
       const key = `${data.product}|${data.spec}|${data.brand}`;
       const existing = cart.find(item => item.key === key);
   
       if(existing){
           if(existing.qty + qty > data.available_qty){
               alert(`Maximum available ${data.available_qty}`);
               return;
           }
           existing.qty += qty;
       }else{
           cart.push({
               key,
               ...data,
               qty
           });
       }
   
       renderCartSummary();
   }
   
   /* ================= MODAL ================= */

function openModal(){
    const tbody      = document.getElementById('modalCartTable');
    const hidden     = document.getElementById('cartData');

    const subInput   = document.getElementById('subTotalInput');
    const gstInput   = document.getElementById('gstTotalInput');
    const grandInput = document.getElementById('grandTotalInput');

    const subEl   = document.getElementById('subTotal');
    const gstEl   = document.getElementById('gstTotal');
    const grandEl = document.getElementById('grandTotal');

    let subTotal = 0;
    let gstTotal = 0;

    tbody.innerHTML = '';

    cart.forEach(item => {

        const price   = Number(item.price);
        const qty     = Number(item.qty);
        const gstPerc = Number(item.gst_percent);

        const amount = price * qty;
        const gstAmt = (amount * gstPerc) / 100;
        const total  = amount + gstAmt;

        subTotal += amount;
        gstTotal += gstAmt;

        tbody.innerHTML += `
        <tr>
            <td>${item.product}</td>
            <td>${item.spec}</td>
            <td>${item.brand}</td>
            <td>${item.unit}</td>
            <td>₹ ${price.toFixed(2)}</td>
            <td>${qty}</td>
            <td>${gstPerc}%</td>
            <td>₹ ${gstAmt.toFixed(2)}</td>
            <td>₹ ${total.toFixed(2)}</td>
        </tr>`;
    });

    const grandTotal = subTotal + gstTotal;

    // UI
    subEl.innerText   = `₹ ${subTotal.toFixed(2)}`;
    gstEl.innerText   = `₹ ${gstTotal.toFixed(2)}`;
    grandEl.innerText = `₹ ${grandTotal.toFixed(2)}`;

    // 🔥 PASS TO FORM
    subInput.value   = subTotal.toFixed(2);
    gstInput.value   = gstTotal.toFixed(2);
    grandInput.value = grandTotal.toFixed(2);

    hidden.value = JSON.stringify(cart);

    new bootstrap.Modal(
        document.getElementById('enquiryModal')
    ).show();
}
/* ================= PRODUCT SEARCH ================= */
document.getElementById('productSearch').addEventListener('input', function () {

    const keyword = this.value.toLowerCase().trim();

    document.querySelectorAll('.category-block').forEach(category => {

        let categoryVisible = false;

        category.querySelectorAll('.product-block').forEach(productBlock => {

            let productVisible = false;

            productBlock.querySelectorAll('.product-card').forEach(card => {

                const data = JSON.parse(card.dataset.product);

                const searchableText = `
                    ${data.product}
                    ${data.spec}
                    ${data.brand}
                `.toLowerCase();

                if (searchableText.includes(keyword)) {
                    card.style.display = '';
                    productVisible = true;
                    categoryVisible = true;
                } else {
                    card.style.display = 'none';
                }
            });

            // Show / hide product block
            productBlock.style.display = productVisible ? '' : 'none';
        });

        // Show / hide category block
        category.style.display = categoryVisible ? '' : 'none';
    });
});


</script>
@endsection