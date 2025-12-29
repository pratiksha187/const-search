
@extends($layout)

@section('title','Search Suppliers | ConstructKaro')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
   :root{
   --navy:#0f172a;
   --orange:#f25c05;
   --border:#e5e7eb;
   --bg:#f6f8fb;
   --card:#ffffff;
   --muted:#64748b;
   }
   /* Page */
   .supplier-search-page{
   max-width:1450px;
   margin:auto;
   padding:24px;
   background:var(--bg);
   }
   /* Header */
   .search-header{
   display:flex;
   justify-content:space-between;
   align-items:center;
   margin-bottom:20px;
   }
   .search-header h4{
   margin:0;
   font-weight:700;
   }
   .search-header p{
   margin:4px 0 0;
   color:var(--muted);
   font-size:14px;
   }
  
   .header-actions {
   display: flex;
   gap: 10px;
   align-content: space-around;
   flex-wrap: wrap;
   flex-direction: row-reverse;
   }
   .btn-outline{
   border:1px solid var(--border);
   background:#fff;
   padding:10px 18px;
   border-radius:12px;
   font-weight:600;
   }
   .btn-primary{
   background:var(--navy);
   color:#fff;
   padding:10px 18px;
   border-radius:12px;
   border:none;
   font-weight:600;
   }
   /* Filter Panel */
   .filter-panel{
   background:#fff;
   border-radius:20px;
   padding:22px;
   border:1px solid var(--border);
   margin-bottom:26px;
   }
   .filter-grid{
   display:grid;
   grid-template-columns:2fr 1fr;
   gap:30px;
   }
   .filter-block label{
   font-weight:600;
   }
   .filter-block p{
   font-size:13px;
   color:var(--muted);
   margin-bottom:8px;
   }
   /* Chips */
   .chip-group{
   display:flex;
   gap:10px;
   flex-wrap:wrap;
   }
   .chip{
   padding:8px 16px;
   border-radius:999px;
   border:1px solid var(--border);
   font-size:13px;
   cursor:pointer;
   background:#fff;
   }
   .chip.active{
   background:var(--navy);
   color:#fff;
   border-color:var(--navy);
   }
   /* Toggle Pills */
   .toggle-row{
   display:flex;
   gap:12px;
   flex-wrap:wrap;
   margin-top:18px;
   }
   .pill{
   padding:10px 18px;
   border-radius:16px;
   border:1px solid var(--border);
   font-size:14px;
   cursor:pointer;
   background:#fff;
   }
   /* Search */
   .search-box input{
   width:100%;
   padding:12px 16px;
   border-radius:14px;
   border:1px solid var(--border);
   }
   /* Supplier Grid */
   .supplier-grid{
   display:grid;
   grid-template-columns:repeat(auto-fill,minmax(430px,1fr));
   gap:22px;
   }
   /* Supplier Card */
   .supplier-card{
   background:#fff;
   border-radius:22px;
   padding:22px;
   border:1px solid var(--border);
   }
   .card-head{
   display:flex;
   justify-content:space-between;
   }
   .card-head h5{
   margin:0;
   font-weight:700;
   }
   .card-head p{
   margin:4px 0 0;
   font-size:13px;
   color:var(--muted);
   }
   /* Rating */
   .rating{
   text-align:right;
   font-weight:700;
   }
   .rating small{
   display:block;
   font-weight:400;
   font-size:12px;
   color:var(--muted);
   }
   /* Badges */
   .badge-row{
   display:flex;
   gap:8px;
   flex-wrap:wrap;
   margin:14px 0;
   }
   .badge{
   padding:6px 14px;
   border-radius:999px;
   font-size:12px;
   }
   .badge.verified{background:#e0f2fe;color:#0369a1}
   .badge.open{background:#dcfce7;color:#166534}
   .badge.closed{background:#fee2e2;color:#991b1b}
   .badge.delivery{background:#ecfeff;color:#155e75}
   .badge.cash{background:#fff7ed;color:#9a3412}
   .badge.credit{background:#ecfdf5;color:#065f46}
   /* Categories */
   .category-row{
   display:flex;
   gap:8px;
   flex-wrap:wrap;
   }
   .tag{
   background:#f1f5f9;
   padding:7px 14px;
   border-radius:999px;
   font-size:12px;
   }
   /* Footer */
   .card-footer{
   display:flex;
   justify-content:space-between;
   align-items:center;
   margin-top:18px;
   font-size:13px;
   color:#475569;
   }
   .btn-enquire{
   background:var(--navy);
   color:#fff;
   padding:10px 22px;
   border-radius:14px;
   border:none;
   font-weight:600;
   }
   .chip-group{
   display:flex;
   flex-wrap:wrap;
   gap:10px;
   }
   .chip{
   padding:8px 14px;
   border-radius:20px;
   border:1px solid #e5e7eb;
   cursor:pointer;
   font-size:14px;
   background:#fff;
   transition:.2s;
   }
   .chip:hover{
   border-color:#f25c05;
   }
   .chip.active{
   background:#0f172a;
   color:#fff;
   border-color:#0f172a;
   }
   .toggle-row{
   display:flex;
   flex-wrap:wrap;
   gap:10px;
   margin-top:6px;
   }
   .pill{
   padding:8px 16px;
   border-radius:20px;
   border:1px solid #e5e7eb;
   cursor:pointer;
   font-size:14px;
   background:#fff;
   transition:.2s;
   }
   .pill:hover{
   border-color:#f25c05;
   }
   .pill.active{
   background:#0f172a;
   color:#fff;
   border-color:#0f172a;
   }
   .chip-group{
   display:flex;
   flex-wrap:wrap;
   gap:10px;
   }
   .chip{
   padding:8px 16px;
   border-radius:20px;
   border:1px solid #e5e7eb;
   cursor:pointer;
   font-size:14px;
   background:#fff;
   transition:.2s;
   }
   .chip:hover{
   border-color:#f25c05;
   }
   .chip.active{
   background:#0f172a;
   color:#fff;
   border-color:#0f172a;
   }
</style>
<div class="supplier-search-page">
   <!-- HEADER -->
   <div class="search-header">
      <div>
         <h4>Suppliers</h4>
         <p>5 suppliers found • Sort: Verified → Rating → Distance</p>
      </div>
   </div>
   <!-- FILTER PANEL -->
   <div class="filter-panel">
      <div class="filter-grid">
         <div>
            <div class="filter-block">
               <label>Credit filter</label>
               <p>Choose minimum credit days (or toggle Cash Only).</p>
               <div class="chip-group" id="creditFilter">
                  {{-- Any --}}
                  <span class="chip active" data-value="">
                  Any
                  </span>
                  {{-- Dynamic credit days --}}
                  @foreach ($credit_days as $credit)
                  <span class="chip"
                     data-value="{{ $credit->id }}">
                  {{ $credit->days }}
                  </span>
                  @endforeach
               </div>
               {{-- hidden input to submit selected credit --}}
               <input type="hidden" name="credit_days" id="credit_days_input">
            </div>
            <div class="toggle-row" id="deliveryTypeToggle">
               {{-- Static utility pills --}}
               <span class="pill active" data-value="">
               All
               </span>
               {{-- Dynamic delivery/payment types --}}
               @foreach ($delivery_type as $dtype)
               <span class="pill"
                  data-value="{{ $dtype->id }}">
               {{ $dtype->type }}
               </span>
               @endforeach
               {{-- Hidden input for form / AJAX --}}
               <input type="hidden" name="delivery_type" id="delivery_type_input">
            </div>
         </div>
         <div>
            <div class="filter-block">
               <label>Distance</label>
               <p>Max distance: <span id="distanceLabel">Any</span></p>
               <div class="chip-group" id="distanceFilter">
                  {{-- Any --}}
                  <span class="chip active" data-value="">
                  Any
                  </span>
                  {{-- Dynamic distances from DB --}}
                  @foreach ($maximum_distances as $dist)
                  <span class="chip"
                     data-value="{{ $dist->id }}"
                     data-label="{{ $dist->distance_km }}">
                  {{ $dist->distance_km }}
                  </span>
                  @endforeach
               </div>
               {{-- Hidden input --}}
               <input type="hidden" name="maximum_distance" id="maximum_distance_input">
            </div>
            <div class="search-box mt-3">
               <input type="text" placeholder="Try: Fosroc, ACC, Khopoli, bricks..." />
            </div>
         </div>
      </div>
      <br><br>
      <div class="header-actions">
         <button class="btn-outline">Reset</button>
         <button class="btn-primary">Filters</button>
      </div>
   </div>
   <div class="supplier-grid">
      @forelse($supplier_data as $supplier)
      <div class="supplier-card">
         {{-- HEADER --}}
         <div class="card-head">
            <div>
               <h5>{{ $supplier->shop_name }}</h5>
               <p>
                  'Area',
                  'City'
                  {{-- Distance placeholder --}}
                  • {{ $supplier->distance_km ?? '—' }} km
               </p>
            </div>
            <div class="rating">
               ⭐ {{ $supplier->rating ?? '4.5' }}
               <small>{{ $supplier->reviews_count ?? rand(20,200) }} reviews</small>
            </div>
         </div>
         {{-- BADGES --}}
         <div class="badge-row">
            <div class="badge-row">
               <span class="badge verified">Verified</span>
               <span class="badge closed">Closed</span>
               <span class="badge delivery">Delivery</span>
               <span class="badge cash">Cash Only</span>
            </div>
            {{-- Verified --}}
            @if($supplier->status === 'verified')
            <span class="badge verified">Verified</span>
            @endif
            {{-- Open / Closed --}}
            @if($supplier->open_time && $supplier->close_time)
            @php
            $now = now()->format('H:i');
            $isOpen = ($now >= $supplier->open_time && $now <= $supplier->close_time);
            @endphp
            <span class="badge {{ $isOpen ? 'open' : 'closed' }}">
            {{ $isOpen ? 'Open now' : 'Closed' }}
            </span>
            @endif
            {{-- Delivery --}}
            @if($supplier->delivery_type)
            <span class="badge delivery">Delivery</span>
            @endif
            {{-- Credit / Cash --}}
            @if($supplier->credit_days)
            <span class="badge credit">
            Credit {{ $supplier->credit_days }}d
            </span>
            @else
            <span class="badge cash">Cash Only</span>
            @endif
         </div>
         {{-- CATEGORIES --}}
         <div class="category-row">
            @php
            $categories = json_decode($supplier->categories_json ?? '[]', true);
            @endphp
            @foreach(array_slice($categories, 0, 3) as $cat)
            <span class="tag">{{ ucfirst($cat) }}</span>
            @endforeach
            @if(count($categories) > 3)
            <span class="tag">+{{ count($categories) - 3 }} more</span>
            @endif
         </div>
         {{-- FOOTER --}}
         <div class="card-footer">
            <span>
            {{ $supplier->delivery_days ? $supplier->delivery_days.' days' : 'Same / Next day' }}
            • Min: ₹{{ number_format($supplier->minimum_order_cost ?? 0) }}
            </span>
          
          
            <a href="javascript:void(0)"
               class="btn-enquire enquire-btn"
               data-supplier-id="{{ $supplier->id }}"
               data-supplier-name="{{ $supplier->shop_name }}"
               data-categories='@json(json_decode($supplier->categories_json ?? "[]"))'
               data-credit="{{ $supplier->credit_days }}">
               Enquire
            </a>

   Enquire
</a>

         </div>
      </div>
      @empty
      <p class="text-muted">No suppliers found.</p>
      @endforelse
   </div>
</div>


<div class="modal fade" id="enquiryModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      {{-- HEADER --}}
      <div class="modal-header">
        <div>
          <h5 class="modal-title">Send Enquiry</h5>
          <small class="text-muted">
            To: <span id="modalSupplierName"></span>
          </small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      {{-- BODY --}}
      <form id="enquiryForm">
        <div class="modal-body">

          <input type="hidden" name="supplier_id" id="modalSupplierId">

          <div class="row g-3">

            {{-- Category --}}
            <div class="col-md-6">
              <label class="form-label">Category</label>
              <select class="form-select" name="category" id="modalCategory">
                <option value="">Select Category</option>
              </select>
            </div>

            {{-- Quantity --}}
            <div class="col-md-6">
              <label class="form-label">Quantity</label>
              <input type="text" class="form-control" name="quantity" placeholder="200 bags">
            </div>

            {{-- Specs --}}
            <div class="col-12">
              <label class="form-label">Specs (type freely)</label>
              <textarea class="form-control" name="specs" rows="3"
                placeholder="Brand, grade, size, approx qty..."></textarea>
              <small class="text-muted">
                Tip: Add brand preference, grade, pack size, usage, site urgency.
              </small>
            </div>

            {{-- Delivery Location --}}
            <div class="col-md-6">
              <label class="form-label">Delivery location</label>
              <input type="text" class="form-control" name="delivery_location"
                     placeholder="Khopoli site">
            </div>

            {{-- Required By --}}
            <div class="col-md-6">
              <label class="form-label">Required by</label>
              <input type="text" class="form-control" name="required_by"
                     placeholder="Tomorrow">
            </div>

            {{-- Payment --}}
            <div class="col-md-6">
              <label class="form-label">Payment preference</label>
              <select class="form-select" name="payment_preference" id="modalPayment">
                <option value="cash">Cash</option>
                <option value="online">Online</option>
                <option value="credit">Credit (if available)</option>
              </select>
            </div>

            {{-- Attachments --}}
            <div class="col-md-6">
              <label class="form-label">Attachments</label>
              <input type="file" class="form-control" name="attachments[]" multiple>
            </div>

          </div>
        </div>

        {{-- FOOTER --}}
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
            Cancel
          </button>
          <button type="submit" class="btn btn-dark px-4">
            Send enquiry
          </button>
        </div>
      </form>

    </div>
  </div>
</div>


<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login Required</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="text-muted mb-3">
          Please login to send enquiry to suppliers.
        </p>
        <a href="{{ route('login_register') }}" class="btn btn-dark w-100 mb-2">
          Login
        </a>
        <a href="{{ route('login_register') }}" class="btn btn-outline-dark w-100">
          Create Account
        </a>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
   document.querySelectorAll('#creditFilter .chip').forEach(chip => {
       chip.addEventListener('click', function () {
   
           // remove active from all
           document.querySelectorAll('#creditFilter .chip')
               .forEach(c => c.classList.remove('active'));
   
           // add active to clicked
           this.classList.add('active');
   
           // set hidden input value
           document.getElementById('credit_days_input').value =
               this.dataset.value || '';
       });
   });
</script>
<script>
   document.querySelectorAll('#deliveryTypeToggle .pill').forEach(pill => {
       pill.addEventListener('click', function () {
   
           // remove active from all
           document.querySelectorAll('#deliveryTypeToggle .pill')
               .forEach(p => p.classList.remove('active'));
   
           // add active to clicked
           this.classList.add('active');
   
           // set hidden input
           document.getElementById('delivery_type_input').value =
               this.dataset.value || '';
       });
   });
</script>
<script>
   document.querySelectorAll('#distanceFilter .chip').forEach(chip => {
       chip.addEventListener('click', function () {
   
           // remove active from all
           document.querySelectorAll('#distanceFilter .chip')
               .forEach(c => c.classList.remove('active'));
   
           // activate clicked
           this.classList.add('active');
   
           // update hidden input
           document.getElementById('maximum_distance_input').value =
               this.dataset.value || '';
   
           // update label text
           document.getElementById('distanceLabel').innerText =
               this.dataset.label || 'Any';
       });
   });
</script>
<script>
    window.IS_LOGGED_IN = @json(
        session()->has('customer_id') ||
        session()->has('vendor_id') ||
        session()->has('supplier_id')
    );
</script>
<script>
document.querySelectorAll('.enquire-btn').forEach(btn => {

    btn.addEventListener('click', function () {

        /* ============================
           🔐 LOGIN CHECK
        ============================ */
        if (!window.IS_LOGGED_IN) {
            new bootstrap.Modal(
                document.getElementById('loginModal')
            ).show();
            return;
        }

        /* ============================
           📩 ENQUIRY MODAL LOGIC
        ============================ */
        const supplierId   = this.dataset.supplierId;
        const supplierName = this.dataset.supplierName;
        const categories   = JSON.parse(this.dataset.categories || '[]');
        const creditDays   = this.dataset.credit;

        // Fill hidden fields
        document.getElementById('modalSupplierId').value = supplierId;
        document.getElementById('modalSupplierName').innerText = supplierName;

        // Fill category dropdown
        const categorySelect = document.getElementById('modalCategory');
        categorySelect.innerHTML = `<option value="">Select Category</option>`;
        categories.forEach(cat => {
            categorySelect.innerHTML += `<option value="${cat}">${cat}</option>`;
        });

        // Payment preference
        document.getElementById('modalPayment').value =
            creditDays ? 'credit' : 'cash';

        // Open enquiry modal
        new bootstrap.Modal(
            document.getElementById('enquiryModal')
        ).show();
    });

});
</script>
<script>
document.getElementById('enquiryForm').addEventListener('submit', function(e){
    e.preventDefault();

    const form = this;
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerText = 'Sending...';

    const formData = new FormData(form);

    fetch("{{ route('supplier.enquiry.store') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status){
            alert('✅ Enquiry sent successfully');
            form.reset();
            bootstrap.Modal.getInstance(
                document.getElementById('enquiryModal')
            ).hide();
        }else{
            alert('❌ Something went wrong');
        }
    })
    .catch(() => {
        alert('❌ Server error');
    })
    .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Send enquiry';
    });
});
</script>

<!-- <script>
document.getElementById('enquiryModal').addEventListener('show.bs.modal', function (event) {

    const button = event.relatedTarget;

    const supplierId   = button.getAttribute('data-supplier-id');
    const supplierName = button.getAttribute('data-supplier-name');
    const categories   = JSON.parse(button.getAttribute('data-categories') || '[]');
    const creditDays   = button.getAttribute('data-credit');

    // Set supplier info
    document.getElementById('modalSupplierId').value = supplierId;
    document.getElementById('modalSupplierName').innerText = supplierName;

    // Fill categories
    const categorySelect = document.getElementById('modalCategory');
    categorySelect.innerHTML = `<option value="">Select Category</option>`;
    categories.forEach(cat => {
        categorySelect.innerHTML += `<option value="${cat}">${cat}</option>`;
    });

    // Payment preference
    const paymentSelect = document.getElementById('modalPayment');
    paymentSelect.value = creditDays ? 'credit' : 'cash';

});
</script> -->

<!-- <script>
document.getElementById('enquiryForm').addEventListener('submit', function(e){
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    fetch("{{ route('supplier.enquiry.store') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.status){
            alert('✅ Enquiry sent successfully');
            form.reset();
            bootstrap.Modal.getInstance(
                document.getElementById('enquiryModal')
            ).hide();
        }else{
            alert('❌ Something went wrong');
        }
    })
    .catch(err => {
        console.error(err);
        alert('❌ Server error');
    });
});
</script> -->


@endsection