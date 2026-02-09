@extends('layouts.vendorapp')

@section('title','Credits Packages | ConstructKaro')

@section('content')

{{-- REQUIRED LIBS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root{
    --orange:#f25c05;
    --blue:#2563eb;
    --green:#16a34a;
    --border:#e5e7eb;
    --muted:#64748b;
    --bg:#f6f8fb;
    --dark:#0f172a;
}

body{ background:var(--bg); }

.lead-page{
    max-width:1100px;
    margin:40px auto 80px;
    padding:0 14px;
}

/* ================= FREE LEADS ================= */
.free-leads-box{
    background:linear-gradient(135deg,#e0f7ff,#f8fdff);
    border:1px solid #bae6fd;
    border-radius:20px;
    padding:28px;
    margin-bottom:40px;
}
.free-leads-box h5{ font-weight:900; color:var(--dark); }

.free-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:22px;
    text-align:center;
    height:100%;
    transition:.25s;
}
.free-card:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 28px rgba(15,23,42,.08);
}
.free-card h6{ font-weight:800; margin-bottom:6px; }
.free-card p{ font-size:14px; color:var(--muted); }

.free-btn{
    display:inline-block;
    margin-top:10px;
    padding:10px 22px;
    border-radius:999px;
    background:var(--blue);
    border:none;
    color:#fff;
    font-weight:800;
    font-size:13px;
    text-decoration:none;
    cursor:pointer;
}
.free-btn.disabled{
    background:#cbd5f5;
    color:#64748b;
    cursor:not-allowed;
}

.upload-box{ margin-top:14px; text-align:left; }

/* ================= CREDITS PACKS ================= */
.page-head{
    text-align:center;
    margin:10px 0 22px;
}
.page-head h3{ font-weight:900; margin-bottom:8px; }
.page-head p{ color:var(--muted); margin:0; }

.credit-pack{
    background:#fff;
    border:2px solid var(--border);
    border-radius:22px;
    padding:22px 22px 18px;
    margin-bottom:18px;
    box-shadow:0 10px 30px rgba(15,23,42,.06);
    transition:.25s;
}
.credit-pack:hover{
    transform:translateY(-3px);
    box-shadow:0 18px 42px rgba(15,23,42,.10);
}

.pack-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:18px;
}
.pack-left{
    display:flex;
    flex-direction:column;
    gap:10px;
}
.pack-badge{
    display:inline-flex;
    align-items:center;
    gap:10px;
    padding:6px 14px;
    border-radius:999px;
    font-weight:900;
    font-size:13px;
    width:max-content;
}
.pack-badge .dot{
    width:10px; height:10px; border-radius:99px;
    background:currentColor;
    box-shadow:0 0 0 4px rgba(0,0,0,.06);
}

.pack-points{
    margin:0;
    padding-left:0;
    list-style:none;
    display:flex;
    flex-direction:column;
    gap:8px;
    color:#334155;
}
.pack-points li{
    display:flex;
    align-items:flex-start;
    gap:10px;
    font-size:16px;
}
.pack-points i{
    margin-top:2px;
    font-size:18px;
}

.pack-right{
    text-align:right;
}
.pack-price{
    font-size:34px;
    font-weight:900;
    color:#0f172a;
    line-height:1.1;
}
.pack-credits{
    font-size:16px;
    color:var(--muted);
    margin-top:4px;
}

.pack-btn{
    margin-top:16px;
    width:100%;
    border:none;
    border-radius:16px;
    padding:16px 16px;
    font-size:18px;
    font-weight:900;
    color:#fff;
}

/* COLORS */
.pack-green{ border-color:#34d399; }
.pack-green .pack-badge{ background:#dcfce7; color:#16a34a; }
.pack-green .pack-btn{ background:#059669; }

.pack-blue{ border-color:#bfdbfe; }
.pack-blue .pack-badge{ background:#dbeafe; color:#2563eb; }
.pack-blue .pack-btn{ background:#2563eb; }

.pack-purple{ border-color:#c4b5fd; position:relative; }
.pack-purple .pack-badge{ background:#ede9fe; color:#7c3aed; }
.pack-purple .pack-btn{ background:#4f46e5; }
.most-popular{
    position:absolute;
    top:-14px;
    left:20px;
    background:#4f46e5;
    color:#fff;
    padding:6px 14px;
    border-radius:999px;
    font-size:12px;
    font-weight:900;
    display:flex;
    align-items:center;
    gap:8px;
}

.pack-red{ border-color:#fecaca; }
.pack-red .pack-badge{ background:#fee2e2; color:#ef4444; }
.pack-red .pack-btn{ background:#dc2626; }

.pack-dark{ border-color:#cbd5e1; }
.pack-dark .pack-badge{ background:#e2e8f0; color:#334155; }
.pack-dark .pack-btn{ background:#0f172a; }

.small-note{
    text-align:center;
    color:var(--muted);
    margin-top:18px;
    font-size:14px;
}

@media(max-width:768px){
    .pack-top{ flex-direction:column; }
    .pack-right{ text-align:left; }
    .pack-price{ font-size:30px; }
    .pack-points li{ font-size:15px; }
}
</style>

<div class="lead-page">

{{-- ================= FREE LEADS ================= --}}
<div class="free-leads-box">
    <h5>🎁 Earn Free Leads!</h5>
    <p class="text-muted mb-3">Share on social media & upload screenshot to get 1 free verified lead.</p>

    <div class="row g-3">

        {{-- INSTAGRAM --}}
        <div class="col-md-6">
            <div class="free-card">
                <h6>📸 Instagram</h6>
                <p>Add a story & tag us</p>

                @if(in_array('instagram', $freeLeadPlatforms))
                    <button class="free-btn disabled" disabled>Already Applied</button>
                    <div class="text-success small fw-semibold mt-2">✔ Screenshot already submitted</div>
                @else
                    <button class="free-btn" onclick="toggleUpload('instagram')">Claim Free Lead</button>

                    <form class="upload-box d-none"
                          id="upload-instagram"
                          method="POST"
                          enctype="multipart/form-data"
                          action="{{ route('vendor.freelead.upload') }}">
                        @csrf
                        <input type="hidden" name="platform" value="instagram">

                        <label class="form-label small fw-semibold mt-2">Upload Screenshot</label>
                        <input type="file" name="screenshot" class="form-control mb-2" required accept="image/*">

                        <button class="btn btn-success btn-sm w-100">Submit Screenshot</button>
                    </form>
                @endif
            </div>
        </div>

        {{-- FACEBOOK --}}
        <div class="col-md-6">
            <div class="free-card">
                <h6>👍 Facebook</h6>
                <p>Share on Facebook</p>

                @if(in_array('facebook', $freeLeadPlatforms))
                    <button class="free-btn disabled" disabled>Already Applied</button>
                    <div class="text-success small fw-semibold mt-2">✔ Screenshot already submitted</div>
                @else
                    <button class="free-btn" onclick="toggleUpload('facebook')">Claim Free Lead</button>

                    <form class="upload-box d-none"
                          id="upload-facebook"
                          method="POST"
                          enctype="multipart/form-data"
                          action="{{ route('vendor.freelead.upload') }}">
                        @csrf
                        <input type="hidden" name="platform" value="facebook">

                        <label class="form-label small fw-semibold mt-2">Upload Screenshot</label>
                        <input type="file" name="screenshot" class="form-control mb-2" required accept="image/*">

                        <button class="btn btn-success btn-sm w-100">Submit Screenshot</button>
                    </form>
                @endif
            </div>
        </div>

    </div>
</div>

{{-- ================= CREDIT PACKS ================= --}}
<div class="page-head">
    <h3>Choose a pack based on the size of projects you want to access.</h3>
    <p>Credits do not expire. Credits are non-refundable.</p>
</div>

{{-- Trial Access --}}
<div class="credit-pack pack-green">
    <div class="pack-top">
        <div class="pack-left">
            <div class="pack-badge">
                <span class="dot"></span> Trial Access
            </div>

            <ul class="pack-points">
                <li><i class="bi bi-check2"></i> Unlock 1 small project</li>
                <li><i class="bi bi-check2"></i> Ideal for first-time users</li>
            </ul>
        </div>

        <div class="pack-right">
            <div class="pack-price">₹199</div>
            <div class="pack-credits">30 credits</div>
        </div>
    </div>

    <button class="pack-btn buy-credit-btn"
            data-plan="trial"
            data-amount="199"
            data-credits="30"
            data-cust="{{ $vendor_id }}">
        Get Trial Access
    </button>
</div>

{{-- Starter Access --}}
<div class="credit-pack pack-blue">
    <div class="pack-top">
        <div class="pack-left">
            <div class="pack-badge">
                <span class="dot"></span> Starter Access
            </div>

            <ul class="pack-points">
                <li><i class="bi bi-check2"></i> Unlock 2 small projects</li>
                <li><i class="bi bi-check2"></i> OR save for a mid-size project</li>
            </ul>
        </div>

        <div class="pack-right">
            <div class="pack-price">₹399</div>
            <div class="pack-credits">70 credits</div>
        </div>
    </div>

    <button class="pack-btn buy-credit-btn"
            data-plan="starter"
            data-amount="399"
            data-credits="70"
            data-cust="{{ $vendor_id }}">
        Get Starter Access
    </button>
</div>

{{-- Builder Access (Most Popular) --}}
<div class="credit-pack pack-purple">
    <div class="most-popular"><span>⭐</span> Most Popular</div>

    <div class="pack-top">
        <div class="pack-left">
            <div class="pack-badge">
                <span class="dot"></span> Builder Access
            </div>

            <ul class="pack-points">
                <li><i class="bi bi-check2"></i> Unlock 5 small projects</li>
                <li><i class="bi bi-check2"></i> OR 1 mid-size project (₹5–25L)</li>
                <li><i class="bi bi-check2"></i> Credits can be used flexibly</li>
            </ul>
        </div>

        <div class="pack-right">
            <div class="pack-price">₹799</div>
            <div class="pack-credits">160 credits</div>
        </div>
    </div>

    <button class="pack-btn buy-credit-btn"
            data-plan="builder"
            data-amount="799"
            data-credits="160"
            data-cust="{{ $vendor_id }}">
        Get Builder Access
    </button>
</div>

{{-- Pro Access --}}
<div class="credit-pack pack-red">
    <div class="pack-top">
        <div class="pack-left">
            <div class="pack-badge">
                <span class="dot"></span> Pro Access
            </div>

            <ul class="pack-points">
                <li><i class="bi bi-check2"></i> Unlock 2 mid-size projects</li>
                <li><i class="bi bi-check2"></i> OR 1 large project (₹25L–₹1Cr)</li>
            </ul>
        </div>

        <div class="pack-right">
            <div class="pack-price">₹1,499</div>
            <div class="pack-credits">320 credits</div>
        </div>
    </div>

    <button class="pack-btn buy-credit-btn"
            data-plan="pro"
            data-amount="1499"
            data-credits="320"
            data-cust="{{ $vendor_id }}">
        Get Pro Access
    </button>
</div>

{{-- Power Access --}}
<div class="credit-pack pack-dark">
    <div class="pack-top">
        <div class="pack-left">
            <div class="pack-badge">
                <span class="dot"></span> Power Access
            </div>

            <ul class="pack-points">
                <li><i class="bi bi-check2"></i> Unlock multiple large projects</li>
                <li><i class="bi bi-check2"></i> Best for active contractors & MSMEs</li>
            </ul>
        </div>

        <div class="pack-right">
            <div class="pack-price">₹2,999</div>
            <div class="pack-credits">700 credits</div>
        </div>
    </div>

    <button class="pack-btn buy-credit-btn"
            data-plan="power"
            data-amount="2999"
            data-credits="700"
            data-cust="{{ $vendor_id }}">
        Get Power Access
    </button>
</div>

<div class="small-note">
    Credits do not expire. <br>
    Credits are non-refundable.
</div>

</div>

{{-- ================= JS ================= --}}
<script>
function toggleUpload(platform){
    document.querySelectorAll('.upload-box').forEach(el => el.classList.add('d-none'));
    document.getElementById('upload-'+platform).classList.remove('d-none');
}
</script>

{{-- PAYMENT SCRIPT (CREDITS) --}}
<script>
$(document).on('click','.buy-credit-btn',function(){

    const amount  = $(this).data('amount');
    const plan    = $(this).data('plan');
    const credits = $(this).data('credits');
    const custId  = $(this).data('cust');

    $.post("{{ route('razorpay.createOrder') }}",{
        _token:"{{ csrf_token() }}",
        amount:amount,
        plan:plan,
        cust_id:custId,
        credits:credits
    },function(res){

        if(!res.success){
            Swal.fire('Error','Order failed','error');
            return;
        }

        new Razorpay({
            key: res.key,
            amount: res.amount,
            currency: "INR",
            name: "ConstructKaro",
            description: plan + " credits pack",
            order_id: res.order_id,
            handler: function (response) {

                $.post("{{ route('razorpay.verify') }}",{
                    _token:"{{ csrf_token() }}",
                    ...response,
                    plan:plan,
                    amount:amount,
                    credits:credits
                },function(v){
                    if(v.success){
                        Swal.fire('Success','Payment completed & credits added!','success')
                        .then(()=>location.reload());
                    }else{
                        Swal.fire('Error','Verification failed','error');
                    }
                });

            }
        }).open();
    });
});
</script>

@endsection
