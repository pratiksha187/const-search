@extends('layouts.custapp')

@section('title', 'Activate Project | ConstructKaro')

@section('content')

<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --bg:#f5f7fb;
    --border:#e6ebf2;
    --text:#1f2937;
    --muted:#6b7280;
    --card:#ffffff;
}

/* PAGE */
body{
    background:var(--bg);
    font-family: Inter, system-ui, sans-serif;
}

/* WRAPPER */
.sub-wrapper{
    max-width:1100px;
    margin:40px auto;
    padding:0 16px;
}

/* HEADER */
.sub-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:32px;
}

.sub-header h1{
    font-size:28px;
    font-weight:800;
    color:var(--navy);
}

.sub-header p{
    color:var(--muted);
    margin-top:6px;
}

/* CARD */
.sub-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:30px;
}

/* PLAN */
.plan-box{
    border:2px solid var(--orange);
    border-radius:16px;
    padding:26px;
    background:#fff7ed;
}

.plan-title{
    font-size:20px;
    font-weight:800;
    margin-bottom:8px;
}

.plan-desc{
    font-size:14px;
    color:var(--muted);
    margin-bottom:18px;
}

.price{
    font-size:36px;
    font-weight:800;
    color:var(--navy);
}

.price span{
    font-size:14px;
    color:var(--muted);
    font-weight:600;
}

.gst-note{
    font-size:13px;
    color:var(--muted);
    margin-top:4px;
}

/* FEATURES */
.feature-list{
    list-style:none;
    padding:0;
    margin:20px 0;
}

.feature-list li{
    margin-bottom:10px;
    font-size:14px;
}

.feature-list i{
    color:#22c55e;
    margin-right:8px;
}

/* RIGHT INFO */
.info-box{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:24px;
    height:100%;
}

.info-title{
    font-weight:700;
    margin-bottom:12px;
}

/* PAY BUTTON */
.pay-btn{
    width:100%;
    padding:14px;
    background:var(--orange);
    color:#fff;
    border:none;
    border-radius:12px;
    font-size:16px;
    font-weight:800;
    transition:.2s;
}

.pay-btn:hover{
    background:#d94f04;
}

/* FOOT NOTE */
.secure-note{
    font-size:13px;
    color:var(--muted);
    text-align:center;
    margin-top:14px;
}

/* MOBILE */
@media(max-width:768px){
    .sub-header{
        flex-direction:column;
        align-items:flex-start;
        gap:12px;
    }
}
</style>

<div class="sub-wrapper">

    <!-- HEADER -->
    <div class="sub-header">
        <div>
            <h1>Activate Your Project</h1>
            <p>Complete payment to publish your project and receive verified vendor responses</p>
        </div>
    </div>

    <div class="row g-4">
    <input type="hidden" id="hiddenCValue" value="c">

        <!-- LEFT : PLAN -->
        <div class="col-lg-7">
            <div class="sub-card plan-box">

                <div class="plan-title">
                    Project Activation Fee
                </div>

                <div class="plan-desc">
                    One-time payment required to publish each new project
                </div>

                <div class="price">
                    <small class="text-muted">
                        ₹4,999 (Inclusive of all taxes)
                    </small>

                </div>
                <div class="gst-note">
                    GST will be calculated as per government norms
                </div>

                <ul class="feature-list">
                    <li><i class="bi bi-check-circle"></i> Project visible to verified vendors</li>
                    <li><i class="bi bi-check-circle"></i> Genuine vendor responses only</li>
                    <li><i class="bi bi-check-circle"></i> No commission on work value</li>
                    <li><i class="bi bi-check-circle"></i> Full control over vendor selection</li>
                    <li><i class="bi bi-check-circle"></i> Secure & transparent process</li>
                </ul>
                
                <button
                    id="payProjectSubscription"
                    data-cust="{{ $cust_data->id }}"
                    data-project="{{ $project->id ?? '' }}"
                    class="pay-btn">
                    Pay ₹4,999 + GST & Publish Project
                </button>
                


                <div class="secure-note">
                    🔒 100% secure payment • Powered by Razorpay
                </div>

            </div>
        </div>

        <!-- RIGHT : INFO -->
        <div class="col-lg-5">
            <div class="info-box">
                <div class="info-title">
                    Why is payment required?
                </div>

                <p class="text-muted">
                    To maintain quality and avoid fake enquiries, every project is activated
                    only after a small one-time payment.
                </p>

                <p class="text-muted">
                    This ensures:
                </p>

                <ul class="feature-list">
                    <li><i class="bi bi-shield-check"></i> Serious project owners only</li>
                    <li><i class="bi bi-shield-check"></i> Better vendor response quality</li>
                    <li><i class="bi bi-shield-check"></i> Reduced spam & fake bids</li>
                </ul>

                <hr>

                <p class="text-muted mb-0">
                    Need help?  
                    <strong>Call us at +91 7385882657</strong>
                </p>
            </div>
        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
$(document).on('click', '#payProjectSubscription', function () {

    const custId = $(this).data('cust');

    // ✅ GST-INCLUSIVE PRICE
    // const totalAmount = 4999;
    const totalAmount =1;
    const plan = 'single'; // keep existing plan to avoid controller change

    $.post("{{ route('razorpay.createOrder') }}", {
        _token: "{{ csrf_token() }}",
        cust_id: custId,
        plan: plan,
        amount: totalAmount
    }, function (res) {

        if (!res.success) {
            Swal.fire('Error', 'Order creation failed', 'error');
            return;
        }

        const options = {
            key: res.key,
            amount: res.amount,
            currency: "INR",
            name: "ConstructKaro",
            description: "Project Activation Fee (GST Included)",
            order_id: res.order_id,

            prefill: {
                name: "ConstructKaro",
                email: "connect@constructkaro.com",
                contact: "8806561819"
            },

            handler: function (response) {
                const cValue = $('#hiddenCValue').val();

                $.post("{{ route('razorpay.verify') }}", {
                    _token: "{{ csrf_token() }}",
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature,
                    cust_id: btoa(custId),
                    plan: plan,
                    amount: totalAmount,
                    c: 'project_activation'
                }, function (verifyRes) {

                    if (verifyRes.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful',
                            text: '₹4,999 paid successfully',
                            confirmButtonColor: '#10b981'
                        }).then(() => {
                            window.location.href = "{{ route('post') }}";
                        });
                    } else {
                        Swal.fire('Error', 'Payment verification failed', 'error');
                    }
                });
            },

            theme: { color: "#f25c05" }
        };

        new Razorpay(options).open();
    });
});
</script>




@endsection
