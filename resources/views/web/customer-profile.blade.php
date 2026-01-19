@extends('layouts.vendorapp')
@section('title','Cusromer Profile')

{{-- ===================== CSS ===================== --}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
                <h4>About</h4>
                <p class="mb-0">
                    We are a {{ $customer_data->work_typename ?? 'construction' }} firm
                    with experience in
                    {{ count($workSubtypes) ? implode(', ', $workSubtypes) : 'multiple construction works' }}
                    for private and government projects.
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

            <!-- <button class="btn-interest mb-3"
                onclick="handleInterested({{ $customer_data->id }})">
                Show Interest
            </button> -->
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

{{-- ===================== MODAL ===================== --}}
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
          <input type="hidden" name="cust_id" value="{{ $customer_data->id }}">

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


{{-- ===================== JS ===================== --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


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
        },
        error: function () {
            alert('❌ Something went wrong');
        }
    });
}
</script>

@endsection
