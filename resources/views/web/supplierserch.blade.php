@extends($layout)

@section('title','Search Suppliers | ConstructKaro')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root{
  --navy:#0f172a;
  --orange:#f25c05;
  --border:#e5e7eb;
  --bg:#f6f8fb;
  --card:#ffffff;
  --muted:#64748b;
}

/* PAGE */
.supplier-search-page{max-width:1450px;margin:auto;padding:24px;background:var(--bg);}
.search-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;}
.search-header h4{margin:0;font-weight:800;color:var(--navy);}
.search-header p{margin:6px 0 0;color:var(--muted);font-size:14px;}
.header-actions{display:flex;gap:10px;flex-wrap:wrap}

/* BUTTONS */
.btn-outline-ck{border:1px solid var(--border);background:#fff;padding:10px 18px;border-radius:12px;font-weight:700;}
.btn-primary-ck{background:var(--navy);color:#fff;padding:10px 18px;border-radius:12px;border:none;font-weight:800;}
.btn-primary-ck:hover{background:var(--orange);}

/* FILTER PANEL */
.filter-panel{background:#fff;border-radius:18px;padding:18px;border:1px solid var(--border);margin-bottom:22px;}
.filter-grid{display:grid;grid-template-columns:2fr 1fr;gap:22px;}
@media(max-width:992px){.filter-grid{grid-template-columns:1fr;}}
.filter-block label{font-weight:800;color:var(--navy);}
.filter-block p{font-size:13px;color:var(--muted);margin-bottom:8px;}

/* CHIPS */
.chip,.pill{
  padding:8px 14px;border-radius:999px;border:1px solid var(--border);
  cursor:pointer;font-size:14px;background:#fff;
}
.chip.active,.pill.active{background:var(--navy);color:#fff;border-color:var(--navy);}

/* SEARCH */
.search-box input{
  width:100%;padding:12px 16px;border-radius:14px;border:1px solid var(--border);
}
.search-box input:focus{border-color:var(--orange);box-shadow:0 0 0 4px rgba(242,92,5,.12);}

/* GRID */
.supplier-grid{
  display:grid;
  grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
  gap:22px;
}

/* CARD */
.supplier-card{
  background:#fff;border:1px solid var(--border);border-radius:18px;padding:18px;
  box-shadow:0 10px 25px rgba(0,0,0,.06);
  transition:.3s ease;position:relative;
}
.supplier-card:hover{transform:translateY(-6px);box-shadow:0 20px 45px rgba(0,0,0,.12);}

/* HEADER */
.card-head h5{margin:0;font-weight:900;font-size:17px;color:#111827;}
.card-head p{margin:3px 0 0;font-size:13px;color:var(--muted);}
.location{margin-top:6px;font-size:13px;color:#64748b;display:flex;gap:6px}

/* CATEGORY TAG */
.category-row{margin-top:10px;display:flex;gap:8px;flex-wrap:wrap;}
.tag.material{
  background:linear-gradient(135deg,#fff7ed,#ffedd5);
  border:1px solid #fed7aa;
  color:#9a3412;
  padding:6px 12px;
  border-radius:999px;
  font-size:12px;
  font-weight:700;
}

/* BADGES */
.badge-row{display:flex;flex-wrap:wrap;gap:8px;margin-top:12px;}
.ck-badge{
  padding:6px 12px;font-size:12px;font-weight:700;border-radius:999px;
  display:inline-flex;gap:6px;
}
.verified{background:#e0f2fe;color:#0369a1;}
.open{background:#dcfce7;color:#166534;}
.closed{background:#fee2e2;color:#991b1b;}
.delivery{background:#fef3c7;color:#92400e;}
.credit{background:#ede9fe;color:#5b21b6;}
.cash{background:#f3f4f6;color:#374151;}

/* FOOTER */
.card-footer{
  display:flex;justify-content:space-between;align-items:center;
  border-top:1px dashed var(--border);margin-top:14px;padding-top:12px;
  font-size:13px;color:#475569;
}
.btn-enquire{
  background:linear-gradient(135deg,#f25c05,#fb923c);
  color:#fff;padding:8px 16px;border-radius:10px;font-weight:800;
  text-decoration:none;
}
.btn-enquire:hover{opacity:.9;color:#fff;}
</style>


<div class="supplier-search-page">

  <!-- HEADER -->
  <div class="search-header">
    <div>
      <h4>Suppliers</h4>
      <p>{{ $supplier_data->count() }} suppliers found</p>
    </div>
    <div class="header-actions">
      <button type="button" class="btn-outline-ck" id="resetBtn">Reset</button>
      <button type="button" class="btn-primary-ck" onclick="applyFilters()">Apply</button>
    </div>
  </div>

  <!-- FILTER PANEL -->
  <div class="filter-panel">
    <div class="filter-grid">

      <div>
        <!-- Credit -->
        <div class="filter-block mb-3">
          <label>Credit filter</label>
          <p>Choose credit days (or Any).</p>

          <div class="chip-group" id="creditFilter">
            <span class="chip active" data-value="">Any</span>
            @foreach ($credit_days as $credit)
              <span class="chip" data-value="{{ $credit->id }}">{{ $credit->days }}</span>
            @endforeach
          </div>

          <input type="hidden" name="credit_days" id="credit_days_input" value="">
        </div>

        <!-- Delivery Type -->
        <div class="filter-block">
          <label>Delivery Type</label>
          <p>Choose delivery option (or All).</p>

          <div class="toggle-row" id="deliveryTypeToggle">
            <span class="pill active" data-value="">All</span>
            @foreach ($delivery_type as $dtype)
              <span class="pill" data-value="{{ $dtype->id }}">{{ $dtype->type }}</span>
            @endforeach
          </div>

          <input type="hidden" name="delivery_type" id="delivery_type_input" value="">
        </div>
      </div>

      <div>
        <!-- Distance -->
        <div class="filter-block">
          <label>Distance</label>
          <p>Max distance: <span id="distanceLabel">Any</span></p>

          <div class="chip-group" id="distanceFilter">
            <span class="chip active" data-value="">Any</span>
            @foreach ($maximum_distances as $dist)
              <span class="chip" data-value="{{ $dist->distance_km }}" data-label="{{ $dist->distance_km }}">
                {{ $dist->distance_km }}
              </span>
            @endforeach
          </div>

          <input type="hidden" name="maximum_distance" id="maximum_distance_input" value="">
        </div>

        <!-- Search -->
        <div class="search-box mt-3">
          <input type="text" id="searchInput" placeholder="Try: Fosroc, ACC, Khopoli, bricks..." />
        </div>
      </div>

    </div>
  </div>

  <!-- GRID -->
  <div class="supplier-grid" id="supplierGrid">

    @forelse($supplier_data as $supplier)
      <div class="supplier-card">
        <div class="card-head">
          <div class="supplier-info">
            <h5>{{ $supplier->shop_name }}</h5>
            <p>Owner: {{ $supplier->contact_person }}</p>

            <p class="location">
              <i class="bi bi-geo-alt-fill"></i>
              {{ $supplier->area_name ?? '—' }}, {{ $supplier->city_name ?? '—' }}
              • {{ $supplier->maximum_distance ?? '—' }} km
            </p>
          </div>
        </div>
      
        @if(!empty($supplier->material_categories))
          <div class="category-row">
            @foreach($supplier->material_categories as $cat)
              <span class="tag material">
                <i class="bi bi-box-seam"></i> {{ $cat['name'] }}
              </span>
            @endforeach
          </div>
        @endif


        <div class="badge-row">

          @if($supplier->status === 'verified')
            <span class="ck-badge verified"><i class="bi bi-patch-check-fill"></i> Verified</span>
          @endif

          @if($supplier->open_time && $supplier->close_time)
            @php
              $now = now()->format('H:i');
              $isOpen = ($now >= $supplier->open_time && $now <= $supplier->close_time);
            @endphp
            <span class="ck-badge {{ $isOpen ? 'open' : 'closed' }}">
              <i class="bi bi-clock-fill"></i> {{ $isOpen ? 'Open now' : 'Closed' }}
            </span>
          @else
            <span class="ck-badge closed"><i class="bi bi-clock-history"></i> Timings not set</span>
          @endif

          @if($supplier->delivery_type)
            <span class="ck-badge delivery"><i class="bi bi-truck"></i> Delivery</span>
          @endif

          @if(!empty($supplier->credit_days_value))
            <span class="ck-badge credit"><i class="bi bi-calendar-check"></i> Credit {{ $supplier->credit_days_value }} Days</span>
          @else
            <span class="ck-badge cash"><i class="bi bi-cash-coin"></i> Cash Only</span>
          @endif
        </div>

        @if($supplier->years_in_business)
          <div class="category-row">
            <span class="tag">{{ $supplier->years_in_business }} yrs experience</span>
          </div>
        @endif

        <div class="card-footer">
          <span>
            {{ $supplier->delivery_days ? $supplier->delivery_days.' days delivery' : 'Same / Next day' }}
            • Min: ₹{{ number_format($supplier->minimum_order_cost ?? 0) }}
          </span>

        
          <a href="javascript:void(0)"
            class="btn-enquire enquire-btn"
            data-supplier-id="{{ $supplier->id }}"
            data-supplier-name="{{ $supplier->shop_name }}"
            data-credit="{{ $supplier->credit_days }}"
            data-categories='@json($supplier->material_categories)'>
            Enquire
          </a>


        </div>
      </div>
    @empty
      <p class="text-muted text-center mt-5">No suppliers found.</p>
    @endforelse

  </div>
</div>

<!-- ENQUIRY MODAL -->
<div class="modal fade" id="enquiryModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div>
          <h5 class="modal-title">Send Enquiry</h5>
          <small class="text-muted">To: <span id="modalSupplierName"></span></small>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="enquiryForm">
        <div class="modal-body">

          <input type="hidden" name="supplier_id" id="modalSupplierId">

          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label">Category</label>
              <select class="form-select" name="category" id="modalCategory">
                <option value="">Select Category</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Quantity</label>
              <input type="text" class="form-control" name="quantity" placeholder="200 bags">
            </div>

            <div class="col-12">
              <label class="form-label">Specs (type freely)</label>
              <textarea class="form-control" name="specs" rows="3"
                        placeholder="Brand, grade, size, approx qty..."></textarea>
              <small class="text-muted">Tip: Add brand preference, grade, pack size, usage, site urgency.</small>
            </div>

            <div class="col-md-6">
              <label class="form-label">Delivery location</label>
              <input type="text" class="form-control" name="delivery_location" placeholder="Khopoli site">
            </div>

            <div class="col-md-6">
              <label class="form-label">Required by</label>
              <input type="text" class="form-control" name="required_by" placeholder="Tomorrow">
            </div>

            <div class="col-md-6">
              <label class="form-label">Payment preference</label>
              <select class="form-select" name="payment_preference" id="modalPayment">
                <option value="cash">Cash</option>
                <option value="online">Online</option>
                <option value="credit">Credit (if available)</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Attachments</label>
              <input type="file" class="form-control" name="attachments[]" multiple>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-dark px-4">Send enquiry</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- LOGIN MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login Required</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <p class="text-muted mb-3">Please login to send enquiry to suppliers.</p>
        <a href="{{ route('login_register') }}" class="btn btn-dark w-100 mb-2">Login</a>
        <a href="{{ route('login_register') }}" class="btn btn-outline-dark w-100">Create Account</a>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
/* ===============================
   LOGIN FLAG
================================ */
window.IS_LOGGED_IN = @json(
    session()->has('customer_id') ||
    session()->has('vendor_id') ||
    session()->has('supplier_id')
);

document.addEventListener('DOMContentLoaded', function () {

  /* ===============================
     CHIP / PILL SINGLE SELECT
  ================================ */
  function makeSingleSelect(containerSelector, itemSelector, activeClass, inputId, extraOnSelect) {
    const container = document.querySelector(containerSelector);
    if (!container) return;

    container.querySelectorAll(itemSelector).forEach(item => {
      item.addEventListener('click', function () {

        container.querySelectorAll(itemSelector)
          .forEach(i => i.classList.remove(activeClass));

        this.classList.add(activeClass);

        const input = document.getElementById(inputId);
        if (input) input.value = this.dataset.value || '';

        if (typeof extraOnSelect === 'function') {
          extraOnSelect(this);
        }
      });
    });
  }

  makeSingleSelect('#creditFilter', '.chip', 'active', 'credit_days_input');
  makeSingleSelect('#deliveryTypeToggle', '.pill', 'active', 'delivery_type_input');
  makeSingleSelect('#distanceFilter', '.chip', 'active', 'maximum_distance_input', function (el) {
    const label = document.getElementById('distanceLabel');
    if (label) label.innerText = el.dataset.label || 'Any';
  });

  /* ===============================
     RENDER SUPPLIERS (AJAX)
  ================================ */
  function renderSuppliers(list) {

    const grid = document.getElementById('supplierGrid');
    grid.innerHTML = '';

    if (!list || !list.length) {
      grid.innerHTML = `<p class="text-muted text-center mt-5">No suppliers found.</p>`;
      return;
    }

    list.forEach(s => {

      const categoriesHTML = (s.material_categories && s.material_categories.length)
        ? `<div class="category-row">
            ${s.material_categories.map(c =>
              `<span class="tag material">${c.name}</span>`
            ).join('')}
           </div>`
        : '';

      grid.insertAdjacentHTML('beforeend', `
        <div class="supplier-card">
          <div class="card-head">
            <h5>${s.shop_name ?? '-'}</h5>
            <p>Owner: ${s.contact_person ?? '-'}</p>
            <p class="location">
              <i class="bi bi-geo-alt-fill"></i>
              ${(s.area_name ?? '—')}, ${(s.city_name ?? '—')}
              • ${(s.maximum_distance ?? '—')} km
            </p>
          </div>

          ${categoriesHTML}

          <div class="badge-row">
            ${s.status === 'verified' ? `<span class="ck-badge verified">Verified</span>` : ''}
            ${s.delivery_type ? `<span class="ck-badge delivery">Delivery</span>` : ''}
            ${s.credit_days_value
              ? `<span class="ck-badge credit">Credit ${s.credit_days_value} Days</span>`
              : `<span class="ck-badge cash">Cash Only</span>`}
          </div>

          <div class="card-footer">
            <span>
              ${s.delivery_days ?? 'Same / Next day'}
              • Min ₹${Number(s.minimum_order_cost ?? 0).toLocaleString()}
            </span>

            <a href="javascript:void(0)"
               class="btn-enquire enquire-btn"
               data-supplier-id="${s.id}"
               data-supplier-name="${s.shop_name ?? s.contact_person}"
               data-categories='${JSON.stringify(s.material_categories)}'>
               Enquire
            </a>
          </div>
        </div>
      `);
    });

    attachEnquireEvents();
  }

  /* ===============================
     APPLY FILTERS (AJAX)
  ================================ */
  window.applyFilters = function () {

    fetch("{{ route('supplier.search.ajax') }}", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
      },
      body: JSON.stringify({
        credit_days: document.getElementById('credit_days_input').value || '',
        delivery_type: document.getElementById('delivery_type_input').value || '',
        maximum_distance: document.getElementById('maximum_distance_input').value || '',
        search: document.getElementById('searchInput').value || ''
      })
    })
    .then(res => res.json())
    .then(res => {
      if (res.status) renderSuppliers(res.suppliers);
    })
    .catch(err => console.error(err));
  };

  /* ===============================
     AUTO APPLY FILTERS
  ================================ */
  document.querySelectorAll(
    '#creditFilter .chip, #deliveryTypeToggle .pill, #distanceFilter .chip'
  ).forEach(el => {
    el.addEventListener('click', () => setTimeout(window.applyFilters, 150));
  });

  document.getElementById('searchInput')
    ?.addEventListener('keyup', window.applyFilters);

  /* ===============================
     RESET FILTERS
  ================================ */
  document.getElementById('resetBtn')?.addEventListener('click', function () {

    document.querySelectorAll('.chip, .pill')
      .forEach(el => el.classList.remove('active'));

    document.querySelector('#creditFilter .chip[data-value=""]')?.classList.add('active');
    document.querySelector('#deliveryTypeToggle .pill[data-value=""]')?.classList.add('active');
    document.querySelector('#distanceFilter .chip[data-value=""]')?.classList.add('active');

    document.getElementById('credit_days_input').value = '';
    document.getElementById('delivery_type_input').value = '';
    document.getElementById('maximum_distance_input').value = '';
    document.getElementById('searchInput').value = '';

    document.getElementById('distanceLabel').innerText = 'Any';

    window.applyFilters();
  });

  /* ===============================
     ENQUIRE MODAL
  ================================ */
  // function attachEnquireEvents() {

  //   document.querySelectorAll('.enquire-btn').forEach(btn => {

  //     btn.onclick = function () {

  //       const supplierId   = this.dataset.supplierId;
  //       const supplierName = this.dataset.supplierName;

  //       let categories = [];
  //       try {
  //         categories = JSON.parse(this.dataset.categories || '[]');
  //       } catch (e) {}

  //       document.getElementById('modalSupplierId').value = supplierId;
  //       document.getElementById('modalSupplierName').innerText = supplierName;

  //       const select = document.getElementById('modalCategory');
  //       select.innerHTML = `<option value="">Select Category</option>`;

  //       categories.forEach(cat => {
  //         const opt = document.createElement('option');
  //         opt.value = cat.id;
  //         opt.textContent = cat.name;
  //         select.appendChild(opt);
  //       });

  //       new bootstrap.Modal(
  //         document.getElementById('enquiryModal')
  //       ).show();
  //     };
  //   });
  // }
  function attachEnquireEvents() {

  document.querySelectorAll('.enquire-btn').forEach(btn => {

    btn.onclick = function () {

      /* ===============================
         LOGIN CHECK (NEW LOGIC)
      ================================ */
      if (!window.IS_LOGGED_IN) {
        new bootstrap.Modal(
          document.getElementById('loginModal')
        ).show();
        return; // ⛔ stop here
      }

      /* ===============================
         ENQUIRY FLOW (EXISTING)
      ================================ */
      const supplierId   = this.dataset.supplierId;
      const supplierName = this.dataset.supplierName;

      let categories = [];
      try {
        categories = JSON.parse(this.dataset.categories || '[]');
      } catch (e) {}

      document.getElementById('modalSupplierId').value = supplierId;
      document.getElementById('modalSupplierName').innerText = supplierName;

      const select = document.getElementById('modalCategory');
      select.innerHTML = `<option value="">Select Category</option>`;

      categories.forEach(cat => {
        const opt = document.createElement('option');
        opt.value = cat.id;
        opt.textContent = cat.name;
        select.appendChild(opt);
      });

      new bootstrap.Modal(
        document.getElementById('enquiryModal')
      ).show();
    };
  });
}


  attachEnquireEvents();

  const enquiryForm = document.getElementById('enquiryForm');

  enquiryForm?.addEventListener('submit', function (e) {
    e.preventDefault();

    const btn = this.querySelector('button[type="submit"]');
    btn.disabled = true;
    btn.innerText = 'Sending...';

    fetch("{{ route('supplier.enquiry.store') }}", {
      method: "POST",
      headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
      body: new FormData(this)
    })
    .then(res => res.json())
    .then(res => {
      if (res.status) {
        alert('✅ Enquiry sent successfully');
        this.reset();
        bootstrap.Modal.getInstance(
          document.getElementById('enquiryModal')
        ).hide();
      } else {
        alert('❌ Something went wrong');
      }
    })
    .catch(() => alert('❌ Server error'))
    .finally(() => {
      btn.disabled = false;
      btn.innerText = 'Send enquiry';
    });
  });

});
</script>


@endsection
