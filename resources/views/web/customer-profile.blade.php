@extends('layouts.vendorapp')
@section('title','Cusromer Profile')

{{-- ===================== CSS ===================== --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
:root{
    --primary:#6c7cf7;
    --primary-dark:#4f6ef7;
    --success:#22c55e;
    --bg:#f5f7fb;
    --card:#ffffff;
    --border:#e5e7eb;
}

/* body{
    font-family:'Inter',sans-serif;
    background:var(--bg);
} */

/* HEADER */
.profile-header{
    background:linear-gradient(135deg,#6c7cf7,#7c6fd6);
    color:#fff;
    padding:32px 40px;
    border-radius:16px;
    margin-bottom:30px;
    position:relative;
}

.profile-header h1{
    font-size:32px;
    font-weight:800;
}

.profile-sub{ opacity:.9; }
.profile-location{ margin-top:8px; }

.verified-badge{
    position:absolute;
    right:30px;
    top:30px;
    background:#22c55e;
    padding:8px 14px;
    border-radius:10px;
    font-weight:600;
    font-size:14px;
}

/* CARDS */
.profile-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:22px 24px;
    margin-bottom:20px;
}

.profile-card h4{
    font-size:22px;
    font-weight:700;
    margin-bottom:14px;
}

/* LIST */
.check-list{ list-style:none; padding:0; margin:0; }
.check-list li{ margin-bottom:10px; }
.check-list li i{ color:var(--success); margin-right:8px; }

/* RIGHT PANEL */
.side-box{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:22px;
    margin-bottom:20px;
}

.value-text{ font-size:18px; font-weight:700; }

.btn-interest{
    width:100%;
    background:var(--primary);
    color:#fff;
    padding:14px;
    border-radius:14px;
    font-weight:700;
    border:none;
}

.btn-interest:hover{ background:var(--primary-dark); }

.note-box{
    border:2px solid var(--primary);
    border-radius:14px;
    padding:16px;
    background:#f8fafc;
}

 /* PRICING SECTION */
   .pricing-section{
   background:#ffffff;
   border:1px solid #e5e7eb;
   border-radius:18px;
   padding:32px;
   }
   .pricing-header{
   text-align:center;
   margin-bottom:28px;
   }
   .pricing-header h4{
   font-weight:700;
   }
   .pricing-header p{
   color:#6b7280;
   margin-bottom:0;
   }
   /* PLAN CARDS */
   .plan-card{
   background:#ffffff;
   border:1px solid #e5e7eb;
   border-radius:16px;
   padding:24px;
   height:100%;
   position:relative;
   }
   .plan-card.recommended{
   border:2px solid #f25c05;
   box-shadow:0 10px 25px rgba(0,0,0,0.08);
   }
   /* BADGE */
   .recommended-badge{
   position:absolute;
   top:-12px;
   left:50%;
   transform:translateX(-50%);
   background:#f25c05;
   color:#fff;
   padding:5px 14px;
   font-size:12px;
   border-radius:20px;
   font-weight:600;
   }
   /* TEXT */
   .plan-title{
   font-size:13px;
   font-weight:600;
   text-transform:uppercase;
   color:#374151;
   }
   .plan-price{
   font-size:34px;
   font-weight:700;
   margin:12px 0 6px;
   }
   .gst{
   font-size:14px;
   color:#6b7280;
   }
   .plan-meta{
   font-size:14px;
   color:#6b7280;
   margin-bottom:16px;
   }
   /* FEATURES */
   .plan-features{
   list-style:none;
   padding:0;
   margin-bottom:20px;
   }
   .plan-features li{
   margin-bottom:8px;
   font-size:14px;
   }
   /* BUTTONS */
   .btn-primary{
   background:#f25c05;
   border:none;
   border-radius:10px;
   padding:10px;
   font-weight:600;
   }
   .btn-outline{
   background:#ffffff;
   border:1px solid #d1d5db;
   border-radius:10px;
   padding:10px;
   font-weight:600;
   }
   @media (min-width: 576px) {
    .modal {
        --bs-modal-margin: 7.75rem;
        --bs-modal-box-shadow: var(--bs-box-shadow);
    }
}
</style>

@section('content')
<div class="container my-4">

    {{-- ===================== HEADER ===================== --}}
    <div class="profile-header">

        <button class="btn btn-light btn-sm"
            style="position:absolute; left:30px; top:30px; border-radius:10px;"
            onclick="window.history.back()">
            <i class="bi bi-arrow-left"></i> Back
        </button>

        <span class="verified-badge">
            <i class="bi bi-check-circle-fill"></i> Verified Customer
        </span>

        <h1 class="mt-4">{{ $customer_data->title }}</h1>
        <div class="profile-sub">{{ $customer_data->work_typename }}</div>

        <div class="profile-location">
            📍 {{ $customer_data->cityname }},
            {{ $customer_data->regionname }},
            {{ $customer_data->statename }}
        </div>
    </div>

    <div class="row g-4">

        {{-- ===================== LEFT ===================== --}}
        <div class="col-lg-8">

            {{-- ABOUT --}}
            <div class="profile-card">
                <h4>About Project Description:</h4>
                <p class="mb-0">
                    {{ $customer_data->description }}
                 
                </p>
            </div>

            {{-- SERVICES --}}
            <div class="profile-card">
                <h4>Services</h4>
                <ul class="check-list">
                    @forelse($workSubtypes as $service)
                        <li><i class="bi bi-check-lg"></i> {{ $service }}</li>
                    @empty
                        <li class="text-muted">Services will be updated soon</li>
                    @endforelse
                </ul>
            </div>

            {{-- EXPERIENCE --}}
            <div class="profile-card">
                <h4> Work Type</h4>
                <ul class="check-list">
                  
                    <li><i class="bi bi-check-lg"></i>
                        {{ $customer_data->work_typename }} services
                    </li>

                    @if(!empty($workSubtypes))
                        <li><i class="bi bi-check-lg"></i>
                            Specialized in {{ implode(', ', $workSubtypes) }}
                        </li>
                    @endif

                   
                </ul>
            </div>
        </div>

        {{-- ===================== RIGHT ===================== --}}
        <div class="col-lg-4">

            <div class="side-box">
                <h5>Project Capacity</h5>
                <div class="mb-3">
                    <div class="text-muted">Minimum project value</div>
                    <div class="value-text">
                        ₹{{ number_format($customer_data->min_project_value ?? 0) }}
                    </div>
                </div>

                <div>
                    <div class="text-muted">Team size</div>
                    <div class="value-text">
                        {{ $customer_data->team_size_data ?? '-' }}
                    </div>
                </div>
            </div>

            <button class="btn-interest" onclick="handleInterested()">
                Show Interest
            </button>


            <div class="note-box">
                <strong>Note:</strong>
                Contact details will be shared only after vendor acceptance.
            </div>
        </div>
    </div>
</div>

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
          Fill in your details and the vendor will review your enquiry.
          Contact details will be shared once accepted.
        </p>

        <form id="interestForm">
          @csrf
          <input type="hidden" name="cust_id" value="{{ $customer_data->cust_id }}">

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

{{-- ===================== payment MODAL ===================== --}}
{{-- ===================== PAYMENT MODAL ===================== --}}
<div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0">

      <div class="modal-header">
        <h5 class="modal-title">Show Interest in {{ $customer_data->title }}</h5>
        <button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Social sharing incentive section -->
        <div class="alert alert-info mb-4">
          <h6>🎁 Earn Free Leads!</h6>
          <p>Share your interest on social media to get free leads:</p>

          <div class="row g-3">
            <!-- Instagram -->
            <div class="col-md-6">
              <div class="social-card instagram-card p-3 border rounded text-center">
                <div class="social-icon mb-2">📸</div>
                <div class="social-title mb-1"><strong>Instagram</strong></div>
                <div class="social-desc mb-2">Add a story and tag us to earn 1 free lead.</div>
                <button
                  class="btn btn-outline-primary claim-lead-btn"
                  data-platform="instagram"
                  data-cust="{{ $customer_data->id }}">
                  Claim Free Lead
                </button>
              </div>
            </div>

            <!-- Facebook -->
            <div class="col-md-6">
              <div class="social-card facebook-card p-3 border rounded text-center">
                <div class="social-icon mb-2">👍</div>
                <div class="social-title mb-1"><strong>Facebook</strong></div>
                <div class="social-desc mb-2">Share on Facebook to earn 1 free lead.</div>
                <button
                  class="btn btn-outline-primary claim-lead-btn"
                  data-platform="facebook"
                  data-cust="{{ $customer_data->id }}">
                  Claim Free Lead
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Pricing section -->
        <div class="pricing-header">
          <h4>Choose Your Lead Package</h4>
          <p>Pay once • No commission • Verified leads only</p>
        </div>

        <div class="payment-section-modern " id="paymentSection">
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
                  data-cust="{{ $customer_data->id }}">
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
                  data-cust="{{ $customer_data->id }}">
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
                  data-cust="{{ $customer_data->id }}">
                  Buy Grow Pack
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
{{-- ===================== JS ===================== --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>


<script>
function handleInterested() {

    if (window.CUSTOMERID === null) {
        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('authModal')
        ).show();
        return;
    }

    bootstrap.Modal.getOrCreateInstance(
        document.getElementById('vendorModal')
    ).show();
}
</script>

<script>
function handleInterested() {

    if (window.CUSTOMERID === null) {
        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('authModal')
        ).show();
        return;
    }

    // Call the checkLeadBalance function before showing the vendor modal
    checkLeadBalance().then((hasBalance) => {
        if (hasBalance) {
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('vendorModal')
            ).show();
        } else {
            alert('❌ You do not have enough lead balance.');
            bootstrap.Modal.getOrCreateInstance(
                document.getElementById('paymentModal')
            ).show();
            // Optionally, redirect or take another action
        }
    });
}

// Function to check lead balance via AJAX
function checkLeadBalance() {
    return new Promise((resolve, reject) => {
        $.ajax({
            url: "{{ route('vendor.check_lead_balance') }}", // your backend route
            method: "GET", // or POST if needed
            data: { customer_id: window.CUSTOMERID },
            success: function(res) {
                // Assuming your backend returns { balance: number }
                if (res.balance > 0) {
                    resolve(true);
                } else {
                    resolve(false);
                }
            },
            error: function() {
                alert('❌ Failed to check lead balance');
                resolve(false);
            }
        });
    });
}
</script>

<script>
function submitInterest() {

    $.ajax({
        url: "{{ route('vendor.interest.check') }}",
        method: "POST",
        data: $('#interestForm').serialize(),
        success: function (res) {
            alert('✅ Enquiry submitted successfully');
            bootstrap.Modal.getInstance(
                document.getElementById('vendorModal')
            ).hide();
             window.location.href = "{{route('search_customer')}}";
        },
        error: function () {
            alert('❌ Something went wrong');
        }
    });
}


const csrfMeta = document.querySelector('meta[name="csrf-token"]');
const csrfToken = csrfMeta ? csrfMeta.content : '';

document.querySelectorAll('.claim-lead-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const { platform, cust } = btn.dataset;

        btn.disabled = true;
        btn.textContent = 'Claiming...';

        fetch("{{ route('claim_free_lead') }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ platform })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status) {
                alert(`✅ 1 free lead added for ${platform}`);
                btn.textContent = 'Claimed';
            } else {
                alert(data.message || '❌ Could not claim lead');
                btn.disabled = false;
                btn.textContent = 'Claim Free Lead';
            }
        })
        .catch(() => {
            alert('❌ Server error. Please try again.');
            btn.disabled = false;
            btn.textContent = 'Claim Free Lead';
        });
    });
});


</script>
<script>
$(document).ready(function () {

    // ----- FUNCTION: Show Payment Modal -----
    function showPaymentModal(custId) {
        $('#paymentModal').data('cust', custId);
        // show modal
        new bootstrap.Modal(document.getElementById('paymentModal')).show();
        // show payment section
        $('#paymentSection').removeClass('d-none');
    }

    // ----- CLAIM FREE LEAD -----
    $(document).on('click', '.claim-lead-btn', function() {
        const platform = $(this).data('platform');
        const custId = $(this).data('cust');

        $.post("/claim-lead", {
            _token: "{{ csrf_token() }}",
            platform: platform,
            cust_id: custId
        }, function(res){
            if(res.success) {
                Swal.fire('Success', 'Your free lead has been added!', 'success');
            } else {
                Swal.fire('Oops!', res.message || 'Failed to claim lead.', 'error');
            }
        });
    });

    // ----- BUY PLAN / PAYMENT -----
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
                description: `₹${amount} Lead Unlock`,
                order_id: res.order_id,
                prefill: {
                    name: "ConstructKaro",
                    email: "connect@constructkaro.com",
                    contact: "8806561819"
                },
                handler: function(response) {
                    $.post("{{ route('razorpay.verify') }}", {
                        _token: "{{ csrf_token() }}",
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature,
                        cust_id: btoa(custId),
                        plan: plan,
                        amount: amount
                    }, function(verifyRes) {
                        if(verifyRes.success) {
                            bootstrap.Modal.getInstance(document.getElementById('paymentModal')).hide();
                            Swal.fire({
                                icon: 'success',
                                title: 'Payment Successful',
                                text: `₹${amount} payment completed. Lead unlocked!`,
                                confirmButtonColor: '#10b981'
                            }).then(() => location.reload());
                        } else {
                            Swal.fire('Error', 'Verification failed', 'error');
                        }
                    });
                },
                theme: { color: "#2563eb" }
            };

            new Razorpay(options).open();
        });
    });

    // ----- OPTIONAL: Show modal automatically if payment required -----
    if(typeof res !== 'undefined' && (res.payment_required === true || res.remaining <= 0)){
        showPaymentModal(res.cust_id);
    }
});
</script>

@endsection
