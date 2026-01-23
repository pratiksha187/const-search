@extends('layouts.custapp')

@section('title', 'Customer Dashboard | ConstructKaro')

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

/* HEADER */
.dashboard-header-row{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:24px;
    margin-bottom:28px;
}

.dashboard-header-left h2{
    font-size:28px;
    font-weight:900;
    margin-bottom:4px;
}

.dashboard-header-left p{
    font-size:14px;
    color:var(--muted);
    margin-bottom:6px;
}

.how-it-works-link{
    font-size:16px;
    font-weight:700;
    color:var(--blue);
    text-decoration:none;
}
.how-it-works-link:hover{
    text-decoration:underline;
}

.dashboard-header-right{
    display:flex;
    align-items:center;
}

.header-badge{
    background:#ecfeff;
    color:#0369a1;
    font-size:13px;
    font-weight:700;
    padding:8px 16px;
    border-radius:999px;
    display:flex;
    align-items:center;
    gap:8px;
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
}
.kpi-value{
    font-size:26px;
    font-weight:900;
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
    padding:22px 26px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:28px;
    margin-bottom:28px;
    box-shadow:0 8px 24px rgba(15,23,42,0.04);
}

.pc-left{
    display:flex;
    align-items:center;
    gap:16px;
}

.pc-icon{
    width:56px;
    height:56px;
    border-radius:16px;
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
}

.pc-left h4{
    font-weight:800;
    margin-bottom:4px;
}
.pc-left p{
    font-size:14px;
    color:var(--muted);
    margin:0;
}

.pc-right{
    min-width:260px;
    text-align:right;
}

.pc-percent{
    font-size:30px;
    font-weight:900;
    color:var(--orange);
    margin-bottom:6px;
}

.progress{
    height:8px;
    background:#eef2f7;
    border-radius:10px;
    overflow:hidden;
    width: 880px;
}
.progress-bar{
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
}

.pc-btn{
    display:inline-block;
    margin-top:10px;
    padding:8px 18px;
    border-radius:22px;
    background:var(--orange);
    color:#fff;
    font-size:13px;
    font-weight:700;
    text-decoration:none;
}
.pc-btn:hover{
    background:#e45703;
    color:#fff;
}

.pc-done{
    margin-top:10px;
    font-size:13px;
    font-weight:700;
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
    font-weight:700;
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
}

.kpi-link:hover{
    border-color:#2563eb;
    box-shadow:0 12px 30px rgba(37,99,235,.15);
    transform: translateY(-2px);
    transition:.25s;
}
.dashboard-header-right{
    display:flex;
    align-items:center;
    gap:14px;
}

/* Badge */
.header-badge{
    display:flex;
    align-items:center;
    gap:6px;
    padding:8px 14px;
    background:#ecfeff;
    color:#0369a1;
    border-radius:999px;
    font-size:13px;
    font-weight:600;
    white-space:nowrap;
}

/* Button */
.pc-btn{
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:10px 18px;
    background:#f25c05;
    color:#fff;
    font-size:14px;
    font-weight:700;
    border-radius:999px;
    text-decoration:none;
    transition:.2s;
}

.pc-btn:hover{
    background:#d94f04;
    color:#fff;
}

</style>

<div class="dashboard-wrap">

    <!-- HEADER -->
    <div class="dashboard-header-row">
        <div class="dashboard-header-left">
            <h2>Welcome, {{ $cust_data->name ?? 'Customer' }} 👋</h2>
            <p>Overview of your projects, vendors and activities</p>

            <a href="javascript:void(0)"
               class="how-it-works-link"
               data-bs-toggle="modal"
               data-bs-target="#howItWorksModal">
                How it works?
            </a>
        </div>

        <div class="dashboard-header-right">

            <div class="header-badge">
                <i class="bi bi-shield-check"></i>
                Verified vendors get more leads
            </div>

            <a href="{{ route('myposts') }}" class="pc-btn">
                <i class="bi bi-plus-circle"></i>
                Post Project
            </a>

        </div>

    </div>

    <!-- KPI ROW -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="kpi-card">
                <div>
                    <div class="kpi-title">My Posts</div>
                    <div class="kpi-value">{{ $count_post_data }}</div>
                    <div class="kpi-sub">My all data</div>
                </div>
                <div class="kpi-icon orange"><i class="bi bi-briefcase-fill"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <a href="" class="text-decoration-none text-dark">
                <div class="kpi-card">
                    <div>
                        <div class="kpi-title">All Vendors</div>
                        <div class="kpi-value">{{ $count_vendor_data }}</div>
                        <div class="kpi-sub">Under review</div>
                    </div>
                    <div class="kpi-icon blue"><i class="bi bi-file-earmark-text"></i></div>
                </div>
            </a>
        </div>

    
        <div class="col-md-3">
            <div class="kpi-card">
                <div>
                    <div class="kpi-title">Suppliers Count</div>
                    <div class="kpi-value">{{$count_supplier_reg}}</div>
                    <div class="kpi-sub">Profile based</div>
                </div>
                <div class="kpi-icon gold"><i class="bi bi-archive"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card">
                <div>
                    <div class="kpi-title">Intrested Vendor Count</div>
                    <div class="kpi-value">{{ $count_customer_interests }}</div>
                    <div class="kpi-sub">Profile based</div>
                </div>
                <div class="kpi-icon gold"><i class="bi bi-star-fill"></i></div>
            </div>
        </div>
    </div>

    <!-- OPPORTUNITIES -->
    <div class="card">
        <div class="card-title">
            <span>New Vendors</span>
            <a href="{{ route('search_vendor') }}" class="btn btn-sm btn-outline-primary">
                View All Projects
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Vendor Name</th>
                        <th>Location</th>
                        <th>Posted</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($vendor_data->take(6) as $vendor)
                
                    <tr>
                        <td><strong>{{ $vendor->business_name }}</strong></td>
                        <td> {{ $vendor->statename }}, {{ $vendor->regionname }},{{ $vendor->cityname }}</td>
                        <td>{{ \Carbon\Carbon::parse($vendor->created_at)->diffForHumans() }}</td>
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
