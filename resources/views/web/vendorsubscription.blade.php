@extends('layouts.vendorapp')

@section('title','Lead Packages | ConstructKaro')

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
    max-width:1200px;
    margin:40px auto 80px;
}

/* ================= FREE LEADS ================= */
.free-leads-box{
    background:linear-gradient(135deg,#e0f7ff,#f8fdff);
    border:1px solid #bae6fd;
    border-radius:20px;
    padding:28px;
    margin-bottom:50px;
}

.free-leads-box h5{
    font-weight:900;
    color:var(--dark);
}

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

.free-card h6{
    font-weight:800;
    margin-bottom:6px;
}

.free-card p{
    font-size:14px;
    color:var(--muted);
}

.free-btn{
    display:inline-block;
    margin-top:10px;
    padding:10px 22px;
    border-radius:999px;
    background:var(--blue);
    color:#fff;
    font-weight:800;
    font-size:13px;
    text-decoration:none;
}

/* ================= SECTION TITLE ================= */
.section-title{
    text-align:center;
    margin-bottom:42px;
}
.section-title h3{
    font-weight:900;
    color:var(--dark);
}
.section-title p{
    color:var(--muted);
    font-size:15px;
}

/* ================= PLAN CARDS ================= */
.plan-card{
    background:#ffffff;
    border:1px solid var(--border);
    border-radius:22px;
    padding:30px 26px;
    height:100%;
    position:relative;
    text-align:center;
    transition:.3s;
}

.plan-card:hover{
    transform:translateY(-6px);
    box-shadow:0 20px 45px rgba(15,23,42,.12);
}

.plan-card.recommended{
    border:2px solid var(--orange);
    box-shadow:0 18px 45px rgba(242,92,5,.18);
}

.recommended-badge{
    position:absolute;
    top:-16px;
    left:50%;
    transform:translateX(-50%);
    background:var(--orange);
    color:#fff;
    padding:6px 18px;
    border-radius:999px;
    font-size:12px;
    font-weight:900;
}

/* TEXT */
.plan-title{
    font-size:14px;
    font-weight:800;
    letter-spacing:.5px;
    color:#334155;
    margin-bottom:6px;
}

.plan-price{
    font-size:36px;
    font-weight:900;
    color:var(--dark);
    margin:8px 0;
}

.plan-price .gst{
    font-size:13px;
    color:var(--muted);
}

.plan-meta{
    font-size:14px;
    color:var(--muted);
    margin-bottom:18px;
}

.plan-features{
    list-style:none;
    padding:0;
    margin:20px 0;
    text-align:left;
}

.plan-features li{
    font-size:14px;
    margin-bottom:10px;
    color:#334155;
}

/* BUTTONS */
.plan-card .btn{
    margin-top:16px;
    padding:12px 0;
    font-weight:800;
    border-radius:12px;
}

.btn-outline{
    border:2px solid var(--blue);
    color:var(--blue);
    background:#fff;
}

.btn-outline:hover{
    background:#eff6ff;
}

.btn-primary{
    background:var(--blue);
    border:none;
}

.btn-primary:hover{
    background:#1d4ed8;
}

/* MOBILE */
@media(max-width:768px){
    .plan-price{ font-size:32px; }
    .lead-page{ margin:20px auto 60px; }
}

</style>

<div class="lead-page">

{{-- FREE LEADS --}}
<div class="free-leads-box">
    <h5>🎁 Earn Free Leads!</h5>
    <p>Share on social media to get 1 free verified lead.</p>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="free-card">
                <h6>📸 Instagram</h6>
                <p>Add a story & tag us</p>
                <a href="#" class="free-btn">Claim Free Lead</a>
            </div>
        </div>

        <div class="col-md-6">
            <div class="free-card">
                <h6>👍 Facebook</h6>
                <p>Share on Facebook</p>
                <a href="#" class="free-btn">Claim Free Lead</a>
            </div>
        </div>
    </div>
</div>

{{-- PACKAGES --}}
<div class="text-center mb-4">
    <h3 class="fw-bold">Choose Your Lead Package</h3>
    <p class="text-muted">Pay once • No commission • Verified leads only</p>
</div>

<div class="row g-4">

 <!-- SINGLE LEAD -->
            <div class="col-12 col-md-4">
              <div class="plan-card">
                <div class="plan-title">Single Lead</div>
                <div class="plan-price">₹499</div>
                <p class="plan-meta">1 verified lead</p>
                <ul class="plan-features">
                  <li>✔ Full customer contact</li>
                  <li>✔ Genuine requirement</li>
                  <li>✔ No commission</li>
                </ul>
                <button
                  class="btn btn-outline w-100 buy-plan-btn"
                  data-plan="single"
                  data-amount="499"
                  data-cust="{{ $vendor_id }}">
                  Pay & Unlock
                </button>
              </div>
            </div>

            <!-- STARTER PACKAGE (RECOMMENDED) -->
            <div class="col-12 col-md-4">
              <div class="plan-card recommended">
                <div class="recommended-badge">Best Value</div>
                <div class="plan-title">Starter Package</div>
                <div class="plan-price">₹1,999 <span class="gst">+ GST</span></div>
                <p class="plan-meta">10 verified leads • <strong>You save ₹2,991</strong></p>
                <ul class="plan-features">
                  <li>✔ ₹199 per lead</li>
                  <li>✔ Priority access</li>
                  <li>✔ No middleman</li>
                </ul>
                <button
                  class="btn btn-primary w-100 buy-plan-btn"
                  data-plan="starter"
                  data-amount="1999"
                  data-cust="{{ $vendor_id }}">
                  Buy Starter Pack
                </button>
              </div>
            </div>

            <!-- GROW PACKAGE -->
            <div class="col-12 col-md-4">
              <div class="plan-card">
                <div class="plan-title">Grow Package</div>
                <div class="plan-price">₹2,999 <span class="gst">+ GST</span></div>
                <p class="plan-meta">25 verified leads • <strong>You save ₹9,476</strong></p>
                <ul class="plan-features">
                  <li>✔ ₹120 per lead</li>
                  <li>✔ Maximum savings</li>
                  <li>✔ Business growth pack</li>
                </ul>
                <button
                  class="btn btn-outline w-100 buy-plan-btn"
                  data-plan="grow"
                  data-amount="2999"
                  data-cust="{{ $vendor_id }}">
                  Buy Grow Pack
                </button>
              </div>
            </div>

</div>
</div>

{{-- PAYMENT SCRIPT --}}
<script>
$(document).on('click','.buy-plan-btn',function(){

    const amount = $(this).data('amount');
    const plan   = $(this).data('plan');
    const custId = $(this).data('cust');

    $.post("{{ route('razorpay.createOrder') }}",{
        _token:"{{ csrf_token() }}",
        amount:amount,
        plan:plan,
        cust_id:custId
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
            description: plan + " lead package",
            order_id: res.order_id,
            handler: function (response) {
                $.post("{{ route('razorpay.verify') }}",{
                    _token:"{{ csrf_token() }}",
                    ...response,
                    plan:plan,
                    amount:amount
                },function(v){
                    if(v.success){
                        Swal.fire('Success','Payment completed','success')
                        .then(()=>location.reload());
                    }
                });
            }
        }).open();
    });
});
</script>

@endsection
