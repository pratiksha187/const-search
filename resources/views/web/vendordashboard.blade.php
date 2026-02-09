@extends('layouts.vendorapp')

@section('title', 'Vendor Dashboard | ConstructKaro')

@section('content')

<style>
:root{
    --orange:#f25c05;
    --blue:#2563eb;
    --green:#16a34a;
    --gold:#f59e0b;
    --text:#0f172a;
    --muted:#64748b;
    --border:#e5e7eb;
    --bg:#f6f8fb;
}

body{ background:var(--bg); }

/* PAGE */
.dashboard-wrap{
    max-width:1450px;
    margin:24px auto 40px;
    padding:0 16px;
}

/* Small white card wrapper */
.card-soft{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:18px 20px;
    height:100%;
    box-shadow:0 8px 22px rgba(15,23,42,0.04);
}

/* HEADER */
.dash-hero h2{
    font-size:26px;
    font-weight:900;
    margin-bottom:4px;
}
.dash-hero p{
    font-size:14px;
    color:var(--muted);
    margin-bottom:6px;
}
.how-it-works-link{
    font-size:14px;
    font-weight:800;
    color:var(--blue);
    text-decoration:none;
}
.how-it-works-link:hover{ text-decoration:underline; }

.header-badge{
    background:#ecfeff;
    color:#0369a1;
    font-size:13px;
    font-weight:800;
    padding:8px 14px;
    border-radius:999px;
    display:flex;
    align-items:center;
    gap:8px;
    white-space:nowrap;
}

/* KPI */
.kpi-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    height:100%;
    transition:all .25s ease;
}
.kpi-card:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 28px rgba(15,23,42,0.06);
}
.kpi-title{
    font-size:12px;
    text-transform:uppercase;
    color:var(--muted);
    letter-spacing:.5px;
}
.kpi-value{
    font-size:26px;
    font-weight:900;
    color:var(--text);
}
.kpi-sub{
    font-size:12px;
    color:var(--muted);
}
.kpi-icon{
    width:44px;
    height:44px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
}
.orange{background:#f97316;}
.blue{background:#2563eb;}
.green{background:#16a34a;}
.gold{background:#f59e0b;}

/* PROFILE COMPLETION */
.profile-complete-card{
    background:linear-gradient(135deg,#fff7ed,#ffffff);
    border:1px solid var(--border);
    border-radius:20px;
    padding:20px 22px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:18px;
    margin-bottom:18px;
    box-shadow:0 8px 24px rgba(15,23,42,0.04);
}

.pc-left{
    display:flex;
    align-items:center;
    gap:14px;
}
.pc-icon{
    width:54px;
    height:54px;
    border-radius:16px;
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:24px;
}
.pc-left h4{
    font-weight:900;
    margin-bottom:4px;
}
.pc-left p{
    font-size:13px;
    color:var(--muted);
    margin:0;
}

.pc-right{
    min-width:260px;
    max-width:420px;
    width:100%;
    text-align:right;
}
.pc-percent{
    font-size:26px;
    font-weight:900;
    color:var(--orange);
    margin-bottom:8px;
}
.progress{
    height:8px;
    background:#eef2f7;
    border-radius:10px;
    overflow:hidden;
    width: 100%;
}
.progress-bar{
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
    transition: width .6s ease;
}
.pc-done{
    margin-top:10px;
    font-size:13px;
    font-weight:800;
    color:var(--green);
}

/* CARD */
.card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:20px;
    margin-bottom:20px;
}
.card-title{
    font-size:16px;
    font-weight:900;
    margin-bottom:14px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* TABLE */
.table th{
    font-size:12px;
    text-transform:uppercase;
    color:var(--muted);
    letter-spacing:.4px;
}

/* ===================== */
/* CREDITS CARD (V2)      */
/* ===================== */
.credits-card-v2{
    background: radial-gradient(900px 420px at 20% 0%, #233b5b 0%, #0f243b 45%, #0a1b2f 100%);
    border-radius:18px;
    padding:18px 18px 16px;
    color:#fff;
    box-shadow:0 14px 34px rgba(2,10,25,.22);
    border:1px solid rgba(255,255,255,.08);
    height:100%;
}

.credit-icon-v2{
    width:38px;
    height:38px;
    border-radius:14px;
    background: linear-gradient(135deg, #ff3d7f, #ff7aa8);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:16px;
}

.credits-title-v2{
    font-weight:900;
    font-size:18px;
    line-height:1.1;
}
.credits-sub-v2{
    font-size:12px;
    color:rgba(255,255,255,.72);
    margin-top:2px;
}

.credits-count{ text-align:right; }
.credits-number-v2{
    font-size:44px;
    font-weight:900;
    line-height:1;
}
.credits-available{
    font-size:12px;
    color:rgba(255,255,255,.72);
    margin-top:2px;
}

.credits-divider-v2{
    height:1px;
    background:rgba(255,255,255,.14);
    margin:12px 0 12px;
}

.credits-unlock-title{
    font-size:12px;
    color:rgba(255,255,255,.72);
    margin-bottom:8px;
}

.credits-points .point{
    display:flex;
    align-items:center;
    gap:10px;
    margin:6px 0;
    font-size:14px;
    color:rgba(255,255,255,.92);
}
.credits-points i{
    color:#22c55e;
    font-size:16px;
}

.credits-actions-v2{
    display:flex;
    gap:10px;
    margin-top:12px;
}

.btn-credits-primary-v2{
    flex:1;
    background:#4f46e5;
    border:none;
    color:#fff;
    font-weight:900;
    padding:12px 14px;
    border-radius:14px;
}
.btn-credits-primary-v2:hover{ filter:brightness(.95); color:#fff; }

.btn-credits-outline-v2{
    flex:1;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.22);
    color:#fff;
    font-weight:900;
    padding:12px 14px;
    border-radius:14px;
}
.btn-credits-outline-v2:hover{ background:rgba(255,255,255,.10); color:#fff; }

@media(max-width: 992px){
    .credits-actions-v2{ flex-direction:column; }
    .header-badge{ margin-top:6px; }
    .pc-right{ text-align:left; }
}
</style>

<div class="dashboard-wrap">

@php
    // Replace with DB value when ready
    $credits = $credits ?? 70;
    $smallProjects = floor($credits / 35);
@endphp

    <!-- TOP ROW: HEADER + CREDITS -->
    <div class="row g-3 align-items-stretch mb-4">

        <!-- LEFT -->
        <div class="col-lg-7">
            <div class="card-soft dash-hero">
                <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                    <div>
                        <h2>Hi {{ $vendor->name }} 👋</h2>
                        <p>Track your leads, bids and projects at a glance</p>

                        <a href="javascript:void(0)"
                           class="how-it-works-link"
                           data-bs-toggle="modal"
                           data-bs-target="#howItWorksModal">
                            How it works?
                        </a>
                    </div>

                    <div class="header-badge">
                        <i class="bi bi-shield-check"></i>
                        Verified Vendor get more leads
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-lg-5">
            <div class="credits-card-v2">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="d-flex align-items-center gap-2">
                        <div class="credit-icon-v2">
                            <i class="bi bi-ticket-perforated-fill"></i>
                        </div>
                        <div>
                            <div class="credits-title-v2">Your Access Credits</div>
                            <div class="credits-sub-v2">Use credits to unlock projects</div>
                        </div>
                    </div>

                    <div class="credits-count">
                        <div class="credits-number-v2">{{ $credits }}</div>
                        <div class="credits-available">credits available</div>
                    </div>
                </div>

                <div class="credits-divider-v2"></div>

                <div class="credits-unlock">
                    <div class="credits-unlock-title">With your credits, you can unlock:</div>
                    <div class="credits-points">
                        <div class="point">
                            <i class="bi bi-check2-circle"></i>
                            <span><strong>{{ max(1,$smallProjects) }}</strong> small projects</span>
                        </div>
                        <div class="point">
                            <i class="bi bi-check2-circle"></i>
                            <span>OR save for a mid-size project</span>
                        </div>
                    </div>
                </div>

                <div class="credits-actions-v2">
                    <a href="{{ route('search_customer') }}" class="btn btn-credits-primary-v2">
                        <i class="bi bi-search me-2"></i> Browse Projects
                    </a>

                    <a href="#" class="btn btn-credits-outline-v2">
                        <i class="bi bi-plus-lg me-2"></i> Add Credits
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- KPI ROW -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="kpi-card">
                <div>
                    <div class="kpi-title">Active Leads</div>
                    <div class="kpi-value">{{ $ActiveLeads }}</div>
                    <div class="kpi-sub">Open opportunities</div>
                </div>
                <div class="kpi-icon orange"><i class="bi bi-briefcase-fill"></i></div>
            </div>
        </div>

        <div class="col-md-4">
            <a href="{{ route('vendorleadhistory') }}" class="text-decoration-none text-dark">
                <div class="kpi-card">
                    <div>
                        <div class="kpi-title">Lead History</div>
                        <div class="kpi-value">{{ $BidsSubmitted ?? 0 }}</div>
                        <div class="kpi-sub">Under review</div>
                    </div>
                    <div class="kpi-icon blue"><i class="bi bi-file-earmark-text"></i></div>
                </div>
            </a>
        </div>

        <div class="col-md-4">
            <div class="kpi-card">
                <div>
                    <div class="kpi-title">Rating</div>
                    <div class="kpi-value">0.0</div>
                    <div class="kpi-sub">Profile based</div>
                </div>
                <div class="kpi-icon gold"><i class="bi bi-star-fill"></i></div>
            </div>
        </div>
    </div>

    <!-- PROFILE COMPLETION -->
    <div class="profile-complete-card">
        <div class="pc-left">
            <div class="pc-icon">
                <i class="bi bi-person-check-fill"></i>
            </div>
            <div>
                <h4 class="mb-1">Complete Your Profile</h4>
                <p>Higher profile completion increases trust & visibility</p>
            </div>
        </div>

        <div class="pc-right">
            <div class="pc-percent">{{ $profilePercent }}%</div>

            <div class="progress">
                <div class="progress-bar" style="width: {{ $profilePercent }}%"></div>
            </div>

            @if($profilePercent >= 100)
                <div class="pc-done">✅ Profile Fully Completed</div>
            @endif
        </div>
    </div>

    <!-- OPPORTUNITIES -->
    <div class="card">
        <div class="card-title">
            <span>New Opportunities</span>
            <a href="{{ route('search_customer') }}" class="btn btn-sm btn-outline-primary">
                View All Projects
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Project</th>
                        <th>Location</th>
                        <th>Posted</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($projects->take(6) as $project)
                    <tr>
                        <td><strong>{{ $project->title }}</strong></td>
                        <td>{{ $project->statename }}, {{ $project->regionname }}, {{ $project->cityname }}</td>
                        <td>{{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            No opportunities available
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
