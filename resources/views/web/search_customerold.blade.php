@extends('layouts.vendorapp')

@section('title', 'Lead Marketplace | ConstructKaro')

@section('content')

<style>
:root{
    --navy:#0f172a;
    --orange:#f97316;
    --orange-dark:#ea580c;
    --blue:#2563eb;
    --muted:#64748b;
    --border:#e5e7eb;
    --bg:#f8fafc;
}

body{ background:linear-gradient(180deg,#f8fafc,#eef2f7); }

/* ===== LAYOUT ===== */



.market-wrapper {
    max-width: 1427px;
    margin: 28px auto 80px;
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 45px;
    padding: 0 14px;
}

/* ===== TITLE ===== */
.page-title{
    font-size:1.75rem;
    font-weight:800;
    color:var(--navy);
    margin-bottom:14px;
}

/* ===== FILTER ===== */
.filter-panel{
    background:#fff;
    border-radius:16px;
    padding:18px;
    border:1px solid var(--border);
    position:sticky;
    top:96px;
}

.filter-panel h5{
    font-size:1rem;
    font-weight:700;
    margin-bottom:12px;
}

.filter-item{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:.88rem;
    margin-bottom:8px;
}

.filter-item input{ accent-color:var(--orange); }

.apply-btn{
    margin-top:12px;
    width:100%;
    background:var(--orange);
    border:none;
    padding:10px;
    border-radius:10px;
    color:#fff;
    font-weight:700;
}

/* ===== SEARCH ===== */
.search-bar{
    background:#fff;
    padding:12px;
    border-radius:14px;
    border:1px solid var(--border);
    display:flex;
    gap:10px;
    margin-bottom:16px;
}

.search-bar select{
    flex:1;
    padding:10px 12px;
    border-radius:10px;
    border:1px solid var(--border);
    font-size:.9rem;
}

.search-btn{
    background:var(--blue);
    color:#fff;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    font-weight:700;
}

.clear-btn{
    background:#6b7280;
    color:#fff;
    border:none;
    padding:10px 16px;
    border-radius:10px;
    font-size:.85rem;
}

/* ===== LEAD CARD ===== */
.lead-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:16px 18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:12px;
    transition:.2s;
}

.lead-card:hover{
    border-color:#c7d2fe;
    background:#fafafa;
}

.lead-title{
    font-size:.98rem;
    font-weight:700;
    color:var(--navy);
}

.badge-type{
    margin-left:6px;
    background:#eef2ff;
    color:#3730a3;
    font-size:.65rem;
    padding:3px 8px;
    border-radius:999px;
    font-weight:700;
}

.lead-meta{
    font-size:.82rem;
    color:var(--muted);
    margin-top:4px;
}

.budget-chip{
    margin-top:6px;
    display:inline-block;
    background:#fff7ed;
    color:#c2410c;
    padding:4px 10px;
    border-radius:999px;
    font-size:.78rem;
    font-weight:700;
}

/* ===== CTA ===== */
.view-btn{
    background:#020617;
    color:#fff;
    border:none;
    padding:10px 18px;
    border-radius:999px;
    font-size:.85rem;
    font-weight:700;
}

.view-btn:hover{ background:#0f172a; }

/* ===== MODAL ===== */
.premium-modal{
    border-radius:18px;
    padding:28px;
    text-align:center;
}

.icon-circle{
    width:56px;
    height:56px;
    background:var(--orange);
    color:#fff;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
    margin:0 auto 12px;
}

.price-box{
    background:#fff7ed;
    border:1px solid #fed7aa;
    padding:12px;
    border-radius:14px;
    margin:12px 0;
}

.price-amount{
    font-size:1.6rem;
    font-weight:800;
    color:#c2410c;
}

.btn-pay{
    background:var(--navy);
    color:#fff;
    padding:10px 18px;
    border-radius:10px;
    font-weight:700;
    border:none;
}

.btn-cancel{
    background:#e5e7eb;
    padding:10px 18px;
    border-radius:10px;
    font-weight:600;
    border:none;
}

/* ===== MOBILE ===== */
@media(max-width:900px){
    .market-wrapper{grid-template-columns:1fr}
    .lead-card{flex-direction:column;align-items:flex-start;gap:10px}
    .view-btn{width:100%}
}
</style>

<form method="POST" action="{{ route('search_customer_post') }}">
@csrf

<div class="market-wrapper">

    <!-- FILTER -->
    <div class="filter-panel">
        <h5>Filter by Category</h5>
        @foreach($work_types as $work)
            <div class="filter-item">
                <input type="checkbox" name="category[]" value="{{ $work->id }}"
                    {{ !empty($filters['category']) && in_array($work->id,$filters['category']) ? 'checked':'' }}>
                {{ $work->projecttype_name }}
            </div>
        @endforeach
        <button class="apply-btn">Apply</button>
    </div>

    <!-- RESULTS -->
    <div>

        <div class="page-title">Lead Marketplace</div>

        <div class="search-bar">
            <select name="state">
                <option value="">Select State</option>
                @foreach($states as $st)
                    <option value="{{ $st->id }}" {{ ($filters['state'] ?? '') == $st->id ? 'selected':'' }}>
                        {{ $st->name }}
                    </option>
                @endforeach
            </select>

            <button class="search-btn">Search</button>
            <button type="button" class="clear-btn"
                onclick="window.location='{{ route('search_customer') }}'">
                Clear
            </button>
        </div>

        <div class="fw-semibold mb-2">{{ count($projects) }} Leads</div>

        @forelse($projects as $proj)
        <div class="lead-card">
            <div>
                <div class="lead-title">
                    {{ $proj->title }}
                    <span class="badge-type">{{ $proj->projecttype_name }}</span>
                </div>
                <div class="lead-meta">
                    📍 {{ $proj->citiesname }}, {{ $proj->regionsname }}
                </div>
                <div class="budget-chip">
                    💰 {{ $proj->budget_range_name }}
                </div>
            </div>

            <button class="view-btn"
                onclick="handleProjectView({{ $proj->id }}, this)">
                Unlock →
            </button>
        </div>
        @empty
            <div class="alert alert-warning">No Leads Found</div>
        @endforelse

    </div>
</div>
</form>

<!-- PAYMENT MODAL -->
<div class="modal fade" id="paymentModal" tabindex="-1">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content premium-modal">

    <div class="icon-circle">🔒</div>
    <h5 class="fw-bold">Unlock Lead</h5>
    <p class="text-muted small">View contact & project info</p>

    <div class="price-box">
        <div class="price-amount">₹99</div>
        <small class="text-muted">One-time access</small>
    </div>

    <input type="hidden" id="selectedProjectId">

    <div class="d-flex justify-content-center gap-2 mt-3">
        <button class="btn-cancel" data-bs-dismiss="modal">Later</button>
        <button class="btn-pay" id="btnPayNow">Unlock</button>
    </div>

</div>
</div>
</div>

<!-- PROJECT DETAILS MODAL -->
<div class="modal fade" id="projectModal" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content premium-modal">
    <h4 class="fw-bold mb-3" id="projectTitle"></h4>
    <div id="projectDetails"></div>
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
          Please login or register to unlock leads.
        </p>

        <a href="{{ route('login_register') }}" class="btn btn-primary w-100 mb-2">
          Login
        </a>

        <a href="{{ route('login_register') }}" class="btn btn-outline-secondary w-100">
          Register
        </a>
      </div>

    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// function handleProjectView(projectId, btn){
//     btn.disabled = true;
//     btn.innerText = "Checking...";

//     $.post("{{ route('project.interest.check') }}", {
//         _token: "{{ csrf_token() }}",
//         project_id: projectId
//     }).done(res => {

//         btn.disabled = false;
//         btn.innerText = "Unlock →";

//         if(res.payment_required){
//             $("#selectedProjectId").val(projectId);
//             new bootstrap.Modal(document.getElementById("paymentModal")).show();
//         }else{
//             loadProjectDetails(projectId);
//         }
//     }).fail(()=>{
//         btn.disabled = false;
//         btn.innerText = "Unlock →";
//         alert("Something went wrong");
//     });
// }
function handleProjectView(projectId, btn){
    btn.disabled = true;
    btn.innerText = "Checking...";

    $.ajax({
        url: "{{ route('project.interest.check') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            project_id: projectId
        },
        success: function(res){
            btn.disabled = false;
            btn.innerText = "Unlock →";

            if(res.payment_required){
                $("#selectedProjectId").val(projectId);
                new bootstrap.Modal(
                    document.getElementById("paymentModal")
                ).show();
            }else{
                loadProjectDetails(projectId);
            }
        },
        error: function(xhr){
            btn.disabled = false;
            btn.innerText = "Unlock →";

            // ✅ UNAUTHORIZED → LOGIN / REGISTER MODAL
            if(xhr.status === 401){
                new bootstrap.Modal(
                    document.getElementById("authModal")
                ).show();
            }else{
                alert("Something went wrong. Please try again.");
            }
        }
    });
}

$("#btnPayNow").on("click", function(){
    let id = $("#selectedProjectId").val();
    bootstrap.Modal.getInstance(document.getElementById("paymentModal")).hide();
    setTimeout(() => loadProjectDetails(id), 300);
});

function loadProjectDetails(id){
    $("#projectTitle").text("Loading...");
    $("#projectDetails").html("Loading...");

    $.get("{{ route('project.details.ajax') }}", { id:id }, res => {

        $("#projectTitle").text(res.title);
        $("#projectDetails").html(`
            <p><b>📍 Location:</b> ${res.city}, ${res.region}, ${res.state}</p>
            <p><b>💰 Budget:</b> ${res.budget}</p>
            <p><b>👤 Contact:</b> ${res.contact}</p>
            <p><b>📞 Mobile:</b> ${res.mobile}</p>
            <p><b>📝 Description:</b><br>${res.description}</p>
        `);

        new bootstrap.Modal(document.getElementById("projectModal")).show();
    });
}
</script>

@endsection
