@extends($layout)
@section('title', $supplier->shop_name.' | Supplier Profile')
@section('content')
<style>
   /* ================= GLOBAL ================= */
   body{
   background:#f4f6fb;
   font-size:14px;
   line-height:1.6;
   }
   .section-gap{
   margin-top:48px;
   }
   /* ================= PROFILE HEADER ================= */
   .profile-card{
   background:#fff;
   border-radius:22px;
   padding:32px;
   box-shadow:0 15px 40px rgba(0,0,0,.08);
   max-width:1200px;
   margin:40px auto;
   position:relative;
   overflow:hidden;
   }
   .profile-card::after{
   content:'';
   position:absolute;
   top:-140px;
   right:-140px;
   width:300px;
   height:300px;
   background:radial-gradient(circle,#2563eb33,transparent 70%);
   }
   .profile-header{
   display:flex;
   gap:24px;
   align-items:center;
   }
   .profile-logo{
   width:90px;
   height:90px;
   border-radius:22px;
   background:linear-gradient(135deg,#3b82f6,#2563eb);
   color:#fff;
   font-size:34px;
   font-weight:800;
   display:flex;
   align-items:center;
   justify-content:center;
   }
   .profile-title h2{
   font-size:26px;        /* was 32px */
   font-weight:800;
   margin-bottom:4px;
   letter-spacing:-.5px;
   }
   .profile-title p{
   font-size:15px;
   color:#64748b;
   }
   .badge-row{
   display:flex;
   flex-wrap:wrap;
   gap:12px;
   margin-top:14px;
   }
   .badge-chip{
   padding:8px 14px;
   border-radius:12px;
   font-weight:700;
   font-size:13px;
   color:#fff;
   box-shadow:0 6px 14px rgba(0,0,0,.15);
   }
   .badge-green{background:#10b981;}
   .badge-blue{background:#2563eb;}
   .badge-indigo{background:#4f46e5;}
   /* ================= INFO GRID ================= */
   .info-grid{
   display:grid;
   grid-template-columns:repeat(3,1fr);
   gap:20px;
   margin-top:32px;
   }
   .info-box{
   background:#f0f9ff;
   border:1px solid #dbeafe;
   border-radius:16px;
   padding:18px;
   font-size:14px;
   font-weight:600;
   }
   .info-box strong{
   display:block;
   font-size:15px;
   color:#1e3a8a;
   margin-top:6px;
   }
   /* ================= FOOTER STRIP ================= */
   .footer-strip{
   background:#f8fafc;
   border-radius:16px;
   padding:20px;
   display:flex;
   justify-content:space-between;
   margin-top:28px;
   font-weight:600;
   flex-wrap:wrap;
   gap:10px;
   }
   /* ================= CTA BAR ================= */
   .supplier-cta-wrapper{
   background:#fff;
   border-radius:20px;
   padding:24px;
   box-shadow:0 18px 45px rgba(0,0,0,.12);
   max-width:1200px;
   margin:40px auto;
   position:sticky;
   top:72px;
   z-index:50;
   }
   .supplier-cta{
   display:grid;
   grid-template-columns:repeat(3,1fr);
   gap:20px;
   }
   .cta-btn{
   display:flex;
   align-items:center;
   justify-content:center;
   gap:12px;
   height:56px;
   border-radius:14px;
   font-size:16px;
   font-weight:800;
   text-decoration:none;
   color:#fff;
   transition:.25s;
   box-shadow:0 10px 26px rgba(0,0,0,.15);
   }
   .cta-btn i{font-size:18px;}
   .cta-quote{background:linear-gradient(135deg,#2563eb,#1d4ed8);}
   .cta-call{background:linear-gradient(135deg,#10b981,#059669);}
   .cta-whatsapp{background:linear-gradient(135deg,#22c55e,#16a34a);}
   .cta-btn:hover{
   transform:translateY(-3px);
   }
   .cta-response{
   margin-top:16px;
   text-align:center;
   font-weight:600;
   color:#475569;
   }
   .cta-response strong{color:#16a34a;}
   /* ================= DETAILS ================= */
   .supplier-details-container{
   max-width:1200px;
   margin:40px auto;
   display:grid;
   grid-template-columns:2fr 1fr;
   gap:24px;
   }
   .card-box{
   background:#fff;
   border-radius:18px;
   padding:24px;
   box-shadow:0 10px 30px rgba(0,0,0,.08);
   margin-bottom:24px;
   }
   .section-title{
   font-size:18px;
   font-weight:900;
   display:flex;
   align-items:center;
   gap:10px;
   margin-bottom:16px;
   }
   .section-text{
   color:#334155;
   font-size:14px;
   line-height:1.7;
   }
   /* ================= PRODUCTS ================= */
   .product-grid{
   display:grid;
   grid-template-columns:1fr 1fr;
   gap:20px;
   }
   .product-card{
   border:1px solid #e2e8f0;
   border-radius:16px;
   padding:18px;
   transition:.25s;
   }
   .product-card:hover{
   transform:translateY(-4px);
   box-shadow:0 12px 28px rgba(0,0,0,.12);
   }
   .product-img{
   font-size:40px;
   background:#f1f5f9;
   border-radius:12px;
   width:64px;
   height:64px;
   display:flex;
   align-items:center;
   justify-content:center;
   margin-bottom:12px;
   }
   .product-meta{
   display:flex;
   justify-content:space-between;
   font-size:14px;
   margin:12px 0;
   }
   .green{color:#16a34a;font-weight:700;}
   .btn-quote{
   width:100%;
   background:#2563eb;
   color:#fff;
   padding:12px;
   border:none;
   border-radius:12px;
   font-weight:800;
   }
   /* ================= CREDENTIALS ================= */
   .cred-box{
   border-radius:14px;
   padding:14px;
   font-weight:700;
   margin-bottom:12px;
   }
   .green-bg{background:#ecfdf5;color:#065f46;}
   .blue-bg{background:#eff6ff;color:#1e40af;}
   .purple-bg{background:#f5f3ff;color:#5b21b6;}
   .orange-bg{background:#fff7ed;color:#9a3412;}
   .yellow-bg{background:#fffbeb;color:#92400e;}
   .location-tags{
   display:flex;
   flex-wrap:wrap;
   gap:10px;
   }
   .location-tags span{
   padding:8px 14px;
   background:#ecfeff;
   border:1px solid #67e8f9;
   border-radius:999px;
   font-weight:700;
   }
   /* ================= DELIVERY & CREDIT ================= */
   .dpc-card{
   background:#fff;
   border-radius:20px;
   padding:26px;
   box-shadow:0 14px 38px rgba(0,0,0,.08);
   max-width:1200px;
   margin:40px auto;
   }
   .dpc-grid{
   display:grid;
   grid-template-columns:repeat(2,1fr);
   gap:28px;
   }
   .dpc-item{
   display:flex;
   gap:12px;
   background:#f8fafc;
   border:1px solid #e2e8f0;
   border-radius:14px;
   padding:14px;
   font-weight:700;
   margin-bottom:12px;
   }
   .check{
   background:#10b981;
   color:#fff;
   width:26px;
   height:26px;
   border-radius:8px;
   display:flex;
   align-items:center;
   justify-content:center;
   }
   .dpc-min-order{
   background:#eff6ff;
   border:2px solid #bfdbfe;
   border-radius:18px;
   padding:22px;
   }
   .min-value{
   font-size:36px;
   font-weight:900;
   color:#2563eb;
   }
   /* ================= RESPONSIVE ================= */
   @media(max-width:992px){
   .info-grid,
   .supplier-details-container,
   .supplier-cta{
   grid-template-columns:1fr;
   }
   .profile-header{
   flex-direction:column;
   align-items:flex-start;
   }
   }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- ================= PROFILE HEADER ================= --}}
<div class="profile-card">
   <div class="profile-header">
      <div class="profile-logo">
         {{ strtoupper(substr($supplier->shop_name,0,2)) }}
      </div>
      <div class="profile-title">
         <h2>{{ $supplier->shop_name }}</h2>
         <p>
            {{ ucfirst($supplier->primary_type ?? 'Supplier') }}
            @if($materials->count())
            of {{ $materials->take(3)->implode(', ') }}
            @endif
         </p>
         <div class="badge-row">
            <span class="badge-chip badge-green">✔ Verified Supplier</span>
            <span class="badge-chip badge-blue">{{ ucfirst($supplier->primary_type ?? 'Supplier') }}</span>
            <span class="badge-chip badge-indigo">⭐ 5+ Years Experience</span>
         </div>
      </div>
   </div>
   <div class="info-grid">
      <div class="info-box">
         📍 Location
         <strong>
         {{ $supplier->statename ?? 'N/A' }} , {{ $supplier->cityname ?? 'N/A' }}, {{ $supplier->regionname ?? 'N/A' }}
         </strong>
      </div>
      <div class="info-box">📦 Products <strong>
         {{ $materials->count() ? $materials->implode(', ') : 'Products not listed' }}
         </strong>
      </div>
      <div class="info-box">⚡ Dispatch  <strong>{{ $supplier->dispatch_time ?? 'Same / Next Day' }}</strong></div>
   </div>
   <div class="footer-strip">
      <div>🚚 Delivery ({{ $supplier->maximum_distance ?? 50 }} km)</div>
      <div>💳 Credit: {{ $supplier->credit_days_value ?? 'N/A' }} Days</div>
      <div>
         💰
         {{ $supplier->payment_modes ?? 'Cash & Online' }}
      </div>
   </div>
</div>
{{-- ================= CTA ================= --}}
<div class="supplier-cta-wrapper">
   <div class="supplier-cta">
      <a href="javascript:void(0)" class="cta-btn cta-quote">
         <i class="bi bi-file-earmark-text"></i> Request Quote
      </a>

      <a href="tel:{{ $supplier->mobile }}" class="cta-btn cta-call"><i class="bi bi-telephone"></i>Call Supplier</a>
      <a href="https://wa.me/91{{ $supplier->whatsapp ?? $supplier->mobile }}"
         target="_blank"
         class="cta-btn cta-whatsapp">
      <i class="bi bi-whatsapp"></i>WhatsApp</a>
   </div>
   <div class="cta-response">⚡ Response time: <strong>Usually within 2–4 hours</strong></div>
</div>
{{-- ================= DETAILS ================= --}}
<div class="supplier-details-container">
   <div>
      <div class="card-box">
         <h4 class="section-title"><i class="bi bi-info-circle"></i>About Supplier</h4>
         <p class="section-text">
            {{ $supplier->about_company
            ?? 'This supplier provides construction materials and services across multiple regions.' }}
         </p>
      </div>
      <div class="card-box">
         <h4 class="section-title"><i class="bi bi-box-seam"></i>Products Offered</h4>
         <div class="product-grid">
            @foreach($materials as $mat)
            <div class="product-card">
               <div class="product-img">🧱</div>
               <h5>{{ $mat }}</h5>
               <div class="product-meta">
                  <span>MOQ: {{ $supplier->minimum_order_qty ?? 'N/A' }}</span>
                  <span class="green">{{ $supplier->dispatch_time ?? 'Same / Next Day' }}</span>
               </div>
               <!-- <button class="btn-quote">Request Quote</button> -->
            </div>
            @endforeach
         </div>
      </div>
   </div>
   <div>
      <div class="card-box">
         <h4 class="section-title"><i class="bi bi-patch-check"></i>Credentials</h4>
         @if($supplier->years_in_business)
         <div class="cred-box green-bg">
            {{ $supplier->years_in_business }}+ Years Experience
         </div>
         @endif
         @if($supplier->primary_type)
         <div class="cred-box purple-bg">
            {{ ucfirst($supplier->primary_type) }}
         </div>
         @endif
         @if($supplier->gst_number)
         <div class="cred-box orange-bg">GST Registered</div>
         @endif
      </div>
      <div class="card-box">
         <h4 class="section-title"><i class="bi bi-map"></i>Supply Coverage</h4>
         <div class="location-tags">
            <!-- <span>Pune</span><span>Raigad</span><span>Panvel</span> -->
         </div>
      </div>
   </div>
</div>
{{-- ================= DELIVERY & CREDIT ================= --}}
<div class="dpc-card">
   <h4 class="section-title"><i class="bi bi-check-circle-fill"></i>Delivery, Payment & Credit</h4>
   <div class="dpc-grid">
     
      <div>
         <div class="dpc-item"><span class="check">✔</span>Cash / Online / Bank</div>
         @if($supplier->credit_days_value)
         <div class="dpc-item">
            <span class="check">✔</span>
            {{ $supplier->credit_days_value }} Days Credit
         </div>
         @endif
         <div class="min-value">
            ₹{{ number_format($supplier->minimum_order_value ?? 00) }}
         </div>
      </div>
   </div>
</div>





<div class="modal fade" id="enquiryModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div>
          <h5 class="modal-title">Send Enquiry</h5>
          <!-- <small class="text-muted">To: <span id="modalSupplierName"></span></small> -->
          <small class="text-muted">
            To: <span id="modalSupplierName">{{ $supplier->shop_name }}</span>
         </small>

        </div>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="enquiryForm" method="POST" enctype="multipart/form-data">
      @csrf
        <div class="modal-body">

          <!-- <input type="hidden" name="supplier_id" id="modalSupplierId"> -->
          <input type="hidden" name="supplier_id" id="modalSupplierId" value="{{ $supplier->id }}">

          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label">Category</label>
              
               <select class="form-select" name="category" id="modalCategory">
                  <option value="">Select Category</option>

                  @foreach ($materials as $category)
                     <option value="{{ $category }}">
                           {{ $category }}
                     </option>
                  @endforeach
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
<!-- Bootstrap CSS (usually already present) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS (REQUIRED) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- <script>
document.addEventListener('DOMContentLoaded', function () {

    const enquiryModalEl = document.getElementById('enquiryModal');
    const enquiryModal   = enquiryModalEl
        ? new bootstrap.Modal(enquiryModalEl)
        : null;

    document.querySelectorAll('.cta-quote').forEach(btn => {

        btn.addEventListener('click', function (e) {
            e.preventDefault();

            // Optional: reset form each time
            const form = document.getElementById('enquiryForm');
            if (form) form.reset();

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

        fetch("{{ route('productenquiry') }}", {
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

            if (data.status === true) {
                alert('✅ Enquiry sent successfully');

                bootstrap.Modal
                    .getInstance(document.getElementById('enquiryModal'))
                    .hide();

                form.reset();
            } else {
                alert(data.message || '❌ Something went wrong');
            }

        })
        .catch(() => {
            alert('❌ Server error. Please try again.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Send enquiry';
        });
    });

});
</script> -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof bootstrap === 'undefined') {
        console.error('Bootstrap not loaded');
        return;
    }

    const enquiryModalEl = document.getElementById('enquiryModal');
    const form           = document.getElementById('enquiryForm');
    const csrfToken      = document.querySelector('meta[name="csrf-token"]');

    if (!enquiryModalEl || !form) {
        console.error('Modal or form not found');
        return;
    }

    const enquiryModal = new bootstrap.Modal(enquiryModalEl);

    document.querySelectorAll('.cta-quote').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            form.reset();
            enquiryModal.show();
        });
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerText = 'Sending...';

        const formData = new FormData(form);

        fetch("{{ route('productenquirystore') }}", {
            method: "POST",
            headers: csrfToken ? {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content')
            } : {},
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === true) {
                alert('✅ Enquiry sent successfully');
                enquiryModal.hide();
                form.reset();
            } else {
                alert(data.message || '❌ Something went wrong');
            }
        })
        .catch(() => {
            alert('❌ Server error. Please try again.');
        })
        .finally(() => {
            submitBtn.disabled = false;
            submitBtn.innerText = 'Send enquiry';
        });
    });

});
</script>


@endsection