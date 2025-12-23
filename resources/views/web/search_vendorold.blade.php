@extends('layouts.custapp')
@section('title', 'Search Vendors')

@section('content')

<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --blue:#1A73E8;
    --green:#16a34a;
    --gray:#64748B;
    --border:#E2E8F0;
    --bg:#f5f7fb;
}
body{ background:var(--bg); }

/* LAYOUT */
.page-container{
    max-width:1500px;
    margin:auto;
    display:flex;
    gap:28px;
    padding:25px 0;
}

/* FILTER PANEL */
.filter-box{
    width:300px;
    background:#fff;
    padding:22px;
    border-radius:18px;
    border:1px solid var(--border);
    position:sticky;
    top:90px;
}
.filter-box h4{ font-weight:800 }
.filter-row{
    display:flex;
    gap:10px;
    align-items:center;
    margin-bottom:10px;
    font-size:14px;
}
.apply-btn{
    background:var(--orange);
    color:#fff;
    width:100%;
    padding:12px;
    border:none;
    border-radius:12px;
    font-weight:700;
}

/* RIGHT */
.right-section{ flex:1 }

/* SEARCH BAR */
.search-wrapper{
    background:#fff;
    padding:14px;
    border-radius:16px;
    display:flex;
    gap:12px;
    flex-wrap:wrap;
    align-items:center;
    margin-bottom:18px;
    border:1px solid var(--border);
}
.search-wrapper select{
    padding:10px 14px;
    border-radius:12px;
    border:1px solid var(--border);
    min-width:220px;
}
.search-btn,.clear-btn{
    padding:10px 18px;
    border-radius:12px;
    border:none;
    font-weight:700;
}
.search-btn{background:var(--blue);color:#fff}
.clear-btn{background:#475569;color:#fff}

/* RESULT COUNT */
.result-count{
    font-weight:700;
    margin:10px 0 18px;
}

/* VENDOR CARD */
.vendor-card{
    background:#fff;
    border:1px solid var(--border);
    padding:20px 22px;
    border-radius:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
    box-shadow:0 10px 25px rgba(15,23,42,.06);
}
.vendor-left{
    display:flex;
    gap:16px;
    align-items:center;
}
.vendor-avatar{
    width:64px;height:64px;
    background:linear-gradient(135deg,var(--blue),var(--navy));
    color:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:800;
    font-size:20px;
}
.vendor-name{
    font-weight:800;
    font-size:1.05rem;
}
.vendor-business{ color:var(--gray); font-size:14px }
.vendor-meta{
    display:flex;
    gap:18px;
    font-size:14px;
    margin-top:4px;
}

/* ACTIONS */
.vendor-actions{
    display:flex;
    flex-direction:column;
    gap:10px;
}
.btn-interest{
    background:var(--orange);
    color:#fff;
    border:none;
    padding:10px 18px;
    border-radius:12px;
    font-weight:700;
}
.btn-contact{
    background:var(--blue);
    color:#fff;
    border:none;
    padding:10px 18px;
    border-radius:12px;
    font-weight:700;
}
</style>

<form method="POST" action="{{ route('search_vendor_post') }}">
@csrf

<div class="page-container">

    <!-- FILTERS -->
    <div class="filter-box">
        <h4>Filters</h4>

        <h6 class="mt-3">Work Category</h6>
        @foreach($work_types as $work)
        <div class="filter-row">
            <input type="checkbox" name="category[]" value="{{ $work->id }}">
            <label>{{ $work->work_type }}</label>
        </div>
        @endforeach

        <button class="apply-btn mt-3">Apply Filters</button>
    </div>

    <!-- RESULTS -->
    <div class="right-section">

        <!-- SEARCH -->
        <div class="search-wrapper">
            <select name="state">
                <option value="">Select State</option>
                @foreach($states as $state)
                <option value="{{ $state->id }}">{{ $state->name }}</option>
                @endforeach
            </select>

            <button class="search-btn">Search</button>
            <button type="button" class="clear-btn"
                onclick="window.location.href='{{ route('search_vendor') }}'">
                Clear
            </button>
        </div>

        <div class="result-count">
            {{ $vendor_reg->count() }} Vendors Found
        </div>

        @foreach($vendor_reg as $vendor)
        <div class="vendor-card">

            <div class="vendor-left">
                <div class="vendor-avatar">
                    {{ strtoupper(substr($vendor->name,0,1)) }}
                </div>

                <div>
                    <div class="vendor-name">
                        {{ $vendor->name }} ({{ $vendor->work_type }})
                    </div>
                    <div class="vendor-business">
                        {{ $vendor->business_name }}
                    </div>

                    <div class="vendor-meta">
                        <div>📞 {{ $vendor->mobile }}</div>
                        <div>✉️ {{ $vendor->email }}</div>
                    </div>
                </div>
            </div>

            <div class="vendor-actions">
                <button type="button" class="btn-interest"
                    onclick="handleInterested(
                        {{ $vendor->id }},
                        '{{ addslashes($vendor->name) }}',
                        '{{ addslashes($vendor->business_name) }}',
                        '{{ addslashes($vendor->work_type) }}'
                    )">
                    ❤️ Interested
                </button>
            </div>

        </div>
        @endforeach

    </div>
</div>
</form>

<!-- MODAL -->
<div class="modal fade" id="vendorModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content p-3">

<div class="modal-header border-0">
    <h5 id="vendorName"></h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
    <b>Business</b>
    <div id="vendorBusiness" class="mb-2"></div>

    <b>Work Type</b>
    <div id="vendorWork"></div>

    <div id="paymentSection" style="display:none;">
        <hr>
        <div class="d-flex justify-content-between">
            <span>Service Fee</span>
            <b class="text-success">₹500</b>
        </div>
    </div>
</div>

<div class="modal-footer border-0">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
    <button class="btn btn-success" id="payNowBtn" style="display:none;">
        Pay Now
    </button>
</div>

</div>
</div>
</div>
<!-- LOGIN / REGISTER MODAL -->
<div class="modal fade" id="authModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">

      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Login Required</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p class="mb-3">
          Please login or register to show interest in vendors.
        </p>

        <a href="{{ route('login') }}" class="btn btn-primary w-100 mb-2">
          Login
        </a>

        <a href="{{ route('register') }}" class="btn btn-outline-secondary w-100">
          Register
        </a>
      </div>

    </div>
  </div>
</div>

<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// function handleInterested(id, name, business, work) {
//     $.post("{{ route('vendor.interest.check') }}", {
//         _token: "{{ csrf_token() }}",
//         vendor_id: id
//     }, function (res) {
//         openVendorModal(id, name, business, work, res.payment_required === true);
//     });
// }

function handleInterested(id, name, business, work) {
    $.ajax({
        url: "{{ route('vendor.interest.check') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            vendor_id: id
        },
        success: function (res) {
            openVendorModal(
                id,
                name,
                business,
                work,
                res.payment_required === true
            );
        },
        error: function (xhr) {
            // ✅ UNAUTHORIZED → LOGIN POPUP
            if (xhr.status === 401) {
                new bootstrap.Modal(
                    document.getElementById('authModal')
                ).show();
            } else {
                alert('Something went wrong. Please try again.');
            }
        }
    });
}


function openVendorModal(id, name, business, work, showPayment) {
    $('#vendorName').text(name);
    $('#vendorBusiness').text(business);
    $('#vendorWork').text(work);

    if (showPayment) {
        $('#paymentSection').show();
        $('#payNowBtn').show().data('id', id);
    } else {
        $('#paymentSection').hide();
        $('#payNowBtn').hide();
    }

    new bootstrap.Modal(document.getElementById('vendorModal')).show();
}

$('#payNowBtn').on('click', function () {
    let id = $(this).data('id');
    window.location.href = "{{ route('razorpay.form') }}?vendor_id=" + btoa(id);
});
</script>

@if(session('payment_success') && session('unlock_vendor'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    let vendor = @json(session('unlock_vendor'));
    openVendorModal(
        vendor.id,
        vendor.name,
        vendor.business_name,
        vendor.work_type,
        false
    );
});
</script>
@endif

@endsection
