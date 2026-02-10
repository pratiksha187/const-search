@extends('layouts.vendorapp')
@section('title','Customer Profile')

@section('content')

{{-- (Optional) If your layout already loads Bootstrap, remove these 2 links --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    /* ✅ sticky wrapper for full right side */
.sticky-right{
    position: sticky;
    top: 95px; /* header fixed height */
    align-self: flex-start;
}

/* ✅ IMPORTANT: don't keep sticky inside another sticky */
.side-box{
    position: static; /* remove sticky from here */
}

/* Mobile: disable sticky */
@media(max-width: 992px){
    .sticky-right{
        position: static;
        top: auto;
    }
}

:root{
    --primary:#4f46e5;
    --primary2:#6366f1;
    --success:#22c55e;
    --border:#e5e7eb;
    --muted:#64748b;
    --orange:#f25c05;
}

.profile-page{
    font-family:'Inter',sans-serif;
    background: linear-gradient(180deg,#f8fafc,#eef2ff);
    min-height:100vh;
}

/* HEADER */
.profile-header{
    background: linear-gradient(135deg,var(--primary),var(--primary2));
    border-radius:22px;
    padding:38px 42px;
    color:#fff;
    position:relative;
    box-shadow:0 20px 40px rgba(79,70,229,.25);
    overflow:hidden;
    margin-bottom:22px;
}
.profile-header:after{
    content:'';
    position:absolute;
    inset:0;
    background: radial-gradient(900px 300px at 20% 20%, rgba(255,255,255,.22), transparent 60%);
    opacity:.7;
}
.profile-header *{ position:relative; z-index:2; }

.profile-header h1{
    font-size:30px;
    font-weight:900;
    margin:0 0 8px;
    letter-spacing:-.3px;
}
.profile-sub{ font-size:15px; opacity:.95; font-weight:700; }
.profile-location{ margin-top:10px; font-size:14px; opacity:.92; }

.verified-badge{
    position:absolute;
    right:24px;
    top:24px;
    background:var(--success);
    padding:8px 14px;
    border-radius:999px;
    font-size:13px;
    font-weight:900;
    box-shadow:0 8px 20px rgba(34,197,94,.4);
    z-index:3;
}

/* CREDIT PILL */
.credit-pill{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 14px;
    border-radius:999px;
    font-size:13px;
    font-weight:900;
    border:1px solid rgba(255,255,255,.25);
    background:rgba(255,255,255,.15);
    color:#fff;
    backdrop-filter: blur(10px);
}
.credit-pill.light{
    background:#eef2ff;
    border:1px solid #c7d2fe;
    color:#3730a3;
}
.credit-pill.prime{
    background:#fff7ed;
    border:1px solid #fed7aa;
    color:#b45309;
}

/* CONTENT CARDS */
.profile-card{
    background:#fff;
    border-radius:18px;
    padding:26px;
    border:1px solid var(--border);
    box-shadow:0 12px 28px rgba(15,23,42,.06);
    margin-bottom:18px;
}
.profile-card h4{
    font-size:18px;
    font-weight:900;
    margin-bottom:14px;
    color:#111827;
}

/* LIST */
.check-list{ list-style:none; padding:0; margin:0; }
.check-list li{
    display:flex;
    align-items:center;
    font-size:15px;
    margin-bottom:10px;
    color:#0f172a;
    font-weight:600;
}
.check-list i{
    color:var(--success);
    font-size:18px;
    margin-right:10px;
}

/* RIGHT PANEL */
.side-box{
    background:#fff;
    border-radius:20px;
    padding:26px;
    border:1px solid var(--border);
    box-shadow:0 16px 30px rgba(15,23,42,.08);
    position:sticky;
    top:90px;
}
.side-box h5{ font-weight:900; margin-bottom:16px; }
.value-text{ font-size:20px; font-weight:900; color:#1e293b; }

/* CTA */
.btn-interest{
    width:100%;
    background: linear-gradient(135deg,#f97316,#fb923c);
    border:none;
    color:#fff;
    font-weight:900;
    padding:16px;
    border-radius:16px;
    box-shadow:0 16px 32px rgba(249,115,22,.35);
    transition:.25s;
}
.btn-interest:hover{ transform:translateY(-2px); }

.note-box{
    margin-top:14px;
    background:#fff7ed;
    border-left:4px solid #f97316;
    padding:14px 16px;
    border-radius:14px;
    font-size:14px;
    color:#9a3412;
}
.file-btn{
    border-radius:12px;
    font-weight:800;
}
@media (min-width: 576px) {
    .modal {
        --bs-modal-margin: 10.75rem;
        --bs-modal-box-shadow: var(--bs-box-shadow);
    }
}
</style>

@php
    $files = $customer_data->files ?? '[]';
    $filesArr = is_array($files) ? $files : json_decode($files, true);
    if (!is_array($filesArr)) $filesArr = [];
@endphp

<div class="profile-page">
<div class="container py-4">

    {{-- HEADER --}}
    <div class="profile-header">

        <a href="javascript:history.back()"
           class="btn btn-light btn-sm"
           style="position:absolute; left:24px; top:24px; border-radius:12px; z-index:5;">
            <i class="bi bi-arrow-left"></i> Back
        </a>

        <span class="verified-badge">
            <i class="bi bi-check-circle-fill"></i> Verified Customer
        </span>

        {{-- Credits Badge under Verified --}}
        <div style="position:absolute; right:24px; top:64px; z-index:5;">
            @if(($customer_data->lead_credit_label ?? '') === 'Prime Lead')
                <span class="credit-pill prime">
                    <i class="bi bi-lightning-charge-fill"></i> Prime Lead
                </span>
            @elseif(!empty($customer_data->lead_credit_value))
                <span class="credit-pill">
                    <i class="bi bi-coin"></i> {{ $customer_data->lead_credit_value }} Credits
                </span>
            @endif
        </div>

        <h1 class="mt-4">{{ $customer_data->title }}</h1>
        <div class="profile-sub">{{ $customer_data->work_typename }}</div>

        <div class="profile-location">
            📍 {{ $customer_data->cityname }}, {{ $customer_data->regionname }}, {{ $customer_data->statename }}
        </div>
    </div>

    <div class="row g-4 mt-1">

        {{-- LEFT --}}
        <div class="col-lg-8">
            <div class="profile-card">
                <h4>About Project</h4>
                <p class="mb-0 text-muted">{{ $customer_data->description }}</p>
            </div>

            <div class="profile-card">
                <h4>Services Required</h4>
                <ul class="check-list">
                    @forelse($workSubtypes as $service)
                        <li><i class="bi bi-check-lg"></i> {{ $service }}</li>
                    @empty
                        <li class="text-muted">Services will be updated soon</li>
                    @endforelse
                </ul>
            </div>

            <div class="profile-card">
                <h4>Work Type</h4>
                <ul class="check-list">
                    <li><i class="bi bi-check-lg"></i> {{ $customer_data->work_typename }} services</li>
                    @if(!empty($workSubtypes))
                        <li><i class="bi bi-check-lg"></i> Specialized in {{ implode(', ', $workSubtypes) }}</li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- RIGHT --}}
       {{-- RIGHT --}}
<div class="col-lg-4">
    <div class="sticky-right">  {{-- ✅ wrapper sticky --}}

        <div class="side-box mb-3">
            <h5>Project Value</h5>

            <div class="mb-2">
                <div class="text-muted">Minimum Project Value</div>
                <div class="value-text">{{ $customer_data->budget_range_name }}</div>

                {{-- Credits Required --}}
                <div class="mt-2">
                    @if(($customer_data->lead_credit_label ?? '') === 'Prime Lead')
                        <span class="credit-pill light prime">
                            <i class="bi bi-lightning-charge-fill"></i> Prime Lead
                        </span>
                    @elseif(!empty($customer_data->lead_credit_value))
                        <span class="credit-pill light">
                            <i class="bi bi-coin"></i> {{ $customer_data->lead_credit_value }} Credits Required
                        </span>
                    @endif
                </div>
            </div>

            {{-- Attachments --}}
            @if(count($filesArr) > 0)
                <hr>
                <div class="text-muted mb-2 fw-semibold">Attachments</div>
                <div class="d-grid gap-2">
                    @foreach($filesArr as $file)
                        @php
                            $fileUrl = asset('storage/'.$file);
                            $fileName = basename($file);
                        @endphp
                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-primary btn-sm file-btn">
                            <i class="bi bi-paperclip me-1"></i> {{ $fileName }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Button Logic --}}
        @if(($customer_data->lead_credit_label ?? '') === 'Prime Lead')

            <button class="btn btn-success mb-2 w-100"
                    data-bs-toggle="modal"
                    data-bs-target="#talkModal">
                💬 Talk To Us
            </button>

        @else

            <button class="btn-interest mb-2"
                    onclick="handleInterested()">
                🚀 Show Interest & Unlock Contact
            </button>

        @endif

        <div class="note-box">
            <strong>Note:</strong> Contact details will be shared only after vendor acceptance.
        </div>

    </div>
</div>


    </div>
</div>
</div>

{{-- Your existing modals go here (vendorModal, paymentModal, customerContactModal) --}}
{{-- Keep them exactly as you already have. --}}

{{-- ===================== request MODAL ===================== --}}
<div class="modal fade" id="vendorModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0">

      <div class="modal-header">
        <h5 class="modal-title">
          Show Interest in {{ $customer_data->title }}
        </h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <p class="text-muted">
          Share your details to review the enquiry.
            Customer contact details will be shared after Submition.
        </p>

        <form id="interestForm">
          @csrf
          <input type="hidden" name="cust_id" value="{{ $customer_data->id }}">
    <input type="hidden" name="required_credits" id="required_credits"
        value="{{ $customer_data->lead_credit_value ?? 0 }}">

    <input type="hidden" name="lead_type" id="lead_type"
        value="{{ ($customer_data->lead_credit_label ?? '') === 'Prime Lead' ? 'prime' : 'credit' }}">

          <div class="mb-3">
            <label class="form-label">Your Name *</label>
            <input type="text" class="form-control" name="vendor_name" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Type of Work *</label>
            <input type="text" class="form-control" name="work_type"
                   placeholder="e.g. Road construction, Building design" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Location *</label>
            <input type="text" class="form-control" name="location"
                   placeholder="Project location" required>
          </div>

          
        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
          Cancel
        </button>
        <button class="btn btn-primary" onclick="submitInterest()">
          Submit Enquiry
        </button>
      </div>

    </div>
  </div>
</div>

{{-- ===================== PAYMENT MODAL ===================== --}}


<div class="modal fade" id="customerContactModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">📞 Customer Contact Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center">

                <p class="mb-2">
                    <strong>Mobile Number</strong><br>
                    <span id="customerMobile" class="text-primary fs-5"> {{ $customer_data->mobile }} </span>
                </p>

                <p>
                    <strong>Email Address</strong><br>
                    <span id="customerEmail" class="text-primary fs-6"> {{ $customer_data->email }} </span>
                </p>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>

                <a href="{{ route('search_customer') }}" class="btn btn-primary">
                    Go to Dashboard
                </a>
            </div>

        </div>
    </div>
</div>
<!-- Talk To Us Modal -->
<div class="modal fade" id="talkModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      
      <div class="modal-header">
        <h5 class="modal-title">Talk To Us</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form action="{{route('vendor.talk.submit')}}" method="POST">
        @csrf
        <input type="hidden" 
            name="post_id" 
            value="{{ $customer_data->id }}">

        <div class="modal-body">
          
          <div class="mb-3">
            <label class="form-label">Your Message</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Preferred Call Time</label>
            <input type="text" name="call_time" class="form-control" placeholder="e.g. 4 PM - 6 PM">
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
              Submit Request
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

{{-- JS LIBS (keep only if not already in layout) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    // ✅ Customer user id (login check)
    window.CUSTOMERID = {{ (int)($customer_data->cust_id ?? 0) }};

    /* ===================== HELPERS ===================== */

    function openModal(id){
        const el = document.getElementById(id);
        if(!el) return;
        bootstrap.Modal.getOrCreateInstance(el).show();
    }

    function hideModal(id){
        const el = document.getElementById(id);
        if(!el) return;
        const inst = bootstrap.Modal.getInstance(el);
        if(inst) inst.hide();
    }

    /* ===================== MAIN: HANDLE INTEREST ===================== */
    function handleInterested() {

        if (!window.CUSTOMERID || window.CUSTOMERID === 0) {
            openModal('authModal');
            return;
        }

        $.ajax({
            url: "{{ route('vendor.check_lead_balance') }}",
            method: "GET",
            data: { customer_id: window.CUSTOMERID },

            success: function (res) {

                if (res.already_exists === true) {

                    if (res.customer_mobile) $('#customerMobile').text(res.customer_mobile);
                    if (res.customer_email)  $('#customerEmail').text(res.customer_email);

                    Swal.fire({
                        icon: 'info',
                        title: 'Already Unlocked',
                        text: 'You have already unlocked this customer.',
                        confirmButtonColor: '#2563eb'
                    }).then(() => {
                        openModal('customerContactModal');
                    });

                    return;
                }

                if ((res.balance ?? 0) > 0) {
                    openModal('vendorModal');
                    return;
                }

                Swal.fire({
                    icon: 'warning',
                    title: 'Insufficient Balance',
                    text: 'You do not have enough lead balance. Please add credits.',
                    confirmButtonColor: '#f25c05'
                }).then(() => {
                    openModal('paymentModal');
                });
            },

            error: function () {
                Swal.fire('Error','Failed to check lead balance','error');
            }
        });
    }

    /* ===================== FREE LEAD UPLOAD TOGGLE ===================== */
    function toggleUpload(platform) {
        document.querySelectorAll('.upload-box').forEach(box => box.classList.add('d-none'));
        const box = document.getElementById('upload-' + platform);
        if (box) box.classList.toggle('d-none');
    }

    /* ===================== SUBMIT INTEREST FORM ===================== */
    function submitInterest() {

        const requiredCredits = parseInt($('#required_credits').val() || 0);
       
        const leadType        = $('#lead_type').val() || 'credit';
        //  alert(leadType);
        const payload = $('#interestForm').serialize() +
            '&required_credits=' + encodeURIComponent(requiredCredits) +
            '&lead_type=' + encodeURIComponent(leadType);

        $.ajax({
            url: "{{ route('vendor.interest.check') }}",
            method: "POST",
            data: payload,

            success: function (res) {

                if(res.payment_required === true && res.redirect_url){
                    Swal.fire({
                        icon: 'warning',
                        title: 'Not enough credits',
                        text: res.message || 'Please buy credits to unlock.',
                        confirmButtonText: 'Buy Credits',
                        confirmButtonColor: '#f25c05'
                    }).then(() => {
                        window.location.href = res.redirect_url;
                    });
                    return;
                }

                Swal.fire({
                    icon: 'success',
                    title: 'Enquiry Submitted',
                    text: 'Your enquiry has been submitted successfully.',
                    confirmButtonColor: '#10b981'
                });

                hideModal('vendorModal');

                if (res.customer_mobile) $('#customerMobile').text(res.customer_mobile);
                if (res.customer_email)  $('#customerEmail').text(res.customer_email);

                openModal('customerContactModal');
            },

            error: function () {
                Swal.fire('Error','Something went wrong','error');
            }
        });
    }

    /* ===================== DOCUMENT READY ===================== */
    $(document).ready(function () {

        // ✅ CLAIM FREE LEAD
        $(document).on('click', '.claim-lead-btn', function() {
            const platform = $(this).data('platform');

            $.post("{{ route('claim_free_lead') }}", {
                _token: "{{ csrf_token() }}",
                platform: platform
            }, function(res){
                if(res.status || res.success){
                    Swal.fire('Success', '1 free lead added!', 'success')
                        .then(()=>location.reload());
                }else{
                    Swal.fire('Oops', res.message || 'Failed to claim lead', 'error');
                }
            }).fail(function(){
                Swal.fire('Error','Server error','error');
            });
        });

        // ✅ BUY PLAN (Razorpay)
        $(document).on('click', '.buy-plan-btn', function() {

            const custId = $(this).data('cust');
            const amount = $(this).data('amount');
            const plan   = $(this).data('plan');

            $.post("{{ route('razorpay.createOrder') }}", {
                _token: "{{ csrf_token() }}",
                cust_id: custId,
                plan: plan,
                amount: amount
            }, function(res) {

                if(!res.success){
                    Swal.fire('Error', 'Order creation failed', 'error');
                    return;
                }

                const options = {
                    key: res.key,
                    amount: res.amount,
                    currency: "INR",
                    name: "ConstructKaro",
                    description: plan + " package",
                    order_id: res.order_id,
                    handler: function (response) {

                        $.post("{{ route('razorpay.verify') }}", {
                            _token: "{{ csrf_token() }}",
                            razorpay_payment_id: response.razorpay_payment_id,
                            razorpay_order_id: response.razorpay_order_id,
                            razorpay_signature: response.razorpay_signature,
                            cust_id: btoa(custId),
                            plan: plan,
                            amount: amount
                        }, function(v) {

                            if(v.success){
                                hideModal('paymentModal');

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Successful',
                                    text: 'Credits added successfully.',
                                    confirmButtonColor: '#10b981'
                                }).then(()=>location.reload());

                            }else{
                                Swal.fire('Error','Verification failed','error');
                            }
                        });
                    },
                    theme: { color: "#2563eb" }
                };

                new Razorpay(options).open();

            });
        });

        /* ===================== TALK TO US NORMAL ALERT ===================== */

        @if(session('already_exists'))
            alert("You have already submitted a Talk To Us request for this Prime Lead.");
        @endif

        @if(session('success'))
            alert("Your Talk To Us request has been submitted successfully.");
        @endif

    });

</script>



@endsection
