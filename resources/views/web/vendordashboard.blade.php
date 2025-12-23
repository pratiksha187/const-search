@extends('layouts.vendorapp')

@section('title', 'Vendor Dashboard | ConstructKaro')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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

/* PAGE WRAPPER */
.dashboard-wrap{
    max-width:1450px;
    margin:25px auto 50px;
    padding:0 16px;
}

/* HEADER */
.dashboard-header{
    margin-bottom:26px;
}
.dashboard-header h2{
    font-size:28px;
    font-weight:800;
    color:var(--text);
}
.dashboard-header p{
    color:var(--muted);
    font-size:14px;
}

/* KPI CARDS */
.kpi-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:18px;
    margin-bottom:30px;
}
.kpi-card{
    background:#fff;
    border-radius:14px;
    padding:20px;
    border:1px solid var(--border);
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.kpi-title{
    font-size:12px;
    text-transform:uppercase;
    color:var(--muted);
}
.kpi-value{
    font-size:24px;
    font-weight:800;
}
.kpi-sub{
    font-size:12px;
    color:var(--muted);
}
.kpi-icon{
    width:44px;
    height:44px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:18px;
}
.orange{background:#f97316;}
.blue{background:#2563eb;}
.green{background:#16a34a;}
.gold{background:#f59e0b;}

/* MAIN GRID */
.main-grid{
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:24px;
}

/* CARD */
.card{
    background:#fff;
    border-radius:14px;
    border:1px solid var(--border);
    padding:22px;
    margin-bottom:24px;
}
.card-title{
    font-size:17px;
    font-weight:700;
    margin-bottom:14px;
}

/* OPPORTUNITIES */
.opportunity{
    border:1px solid var(--border);
    border-radius:12px;
    padding:14px 16px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:12px;
}
.opportunity h6{
    margin:0;
    font-weight:700;
}
.opportunity small{
    color:var(--muted);
}
.btn-interest{
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
    color:#fff;
    border:none;
    padding:8px 18px;
    border-radius:20px;
    font-size:13px;
    font-weight:700;
}

/* QUICK ACTIONS */
.quick-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:12px;
}
.quick-btn{
    border:1px solid var(--border);
    border-radius:10px;
    padding:12px;
    text-align:center;
    font-size:13px;
    font-weight:700;
    background:#f9fafb;
}

/* ACTIVITY */
.activity{
    font-size:13px;
    color:var(--muted);
    margin-bottom:8px;
}
.dot{
    display:inline-block;
    width:7px;
    height:7px;
    border-radius:50%;
    margin-right:8px;
}
.dot-blue{background:#2563eb;}
.dot-green{background:#16a34a;}
.dot-orange{background:#f97316;}

/* PROGRESS */
.progress{
    height:8px;
    background:#e5e7eb;
    border-radius:10px;
    overflow:hidden;
}
.progress-bar{
    width:65%;
    height:100%;
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
}

@media(max-width:1200px){
    .kpi-grid{grid-template-columns:repeat(2,1fr);}
    .main-grid{grid-template-columns:1fr;}
}
</style>

<div class="dashboard-wrap">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h2>Hi {{ Session::get('user_name') }} 👋</h2>
        <p>Track your leads, bids and projects at a glance</p>
    </div>

    <!-- KPI -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div>
                <div class="kpi-title">Active Leads</div>
                <div class="kpi-value">{{ $ActiveLeads }}</div>
                <div class="kpi-sub">Open opportunities</div>
            </div>
            <div class="kpi-icon orange"><i class="bi bi-briefcase-fill"></i></div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-title">Bids Submitted</div>
                <div class="kpi-value">12</div>
                <div class="kpi-sub">Under review</div>
            </div>
            <div class="kpi-icon blue"><i class="bi bi-file-earmark-text"></i></div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-title">Projects Won</div>
                <div class="kpi-value">04</div>
                <div class="kpi-sub">Converted deals</div>
            </div>
            <div class="kpi-icon green"><i class="bi bi-check-circle-fill"></i></div>
        </div>

        <div class="kpi-card">
            <div>
                <div class="kpi-title">Rating</div>
                <div class="kpi-value">0.0</div>
                <div class="kpi-sub">Profile based</div>
            </div>
            <div class="kpi-icon gold"><i class="bi bi-star-fill"></i></div>
        </div>
    </div>

    <!-- MAIN -->
    <div class="main-grid">

        <!-- LEFT -->
        <div class="card">
            <div class="card-title">New Opportunities</div>

            @forelse($projects as $project)
                <div class="opportunity">
                    <div>
                        <h6>{{ $project->title }}</h6>
                        <small>{{ $project->city ?? 'City' }}, {{ $project->state ?? 'State' }}</small><br>
                        <small>Posted {{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</small>
                    </div>
                    <button class="btn-interest">Interested</button>
                </div>
            @empty
                <div class="text-muted">No opportunities available</div>
            @endforelse
        </div>

        <!-- RIGHT -->
        <div>

            <div class="card">
                <div class="card-title">Leads Overview</div>
                <canvas id="leadsPieChart" height="240"></canvas>
            </div>

            <div class="card">
                <div class="card-title">Quick Actions</div>
                <div class="quick-grid">
                    <a href="#" class="quick-btn">Complete Profile</a>
                    <a href="{{ route('search_customer') }}" class="quick-btn">View Leads</a>
                    <a href="#" class="quick-btn">Upload Documents</a>
                    <a href="#" class="quick-btn">Subscription</a>
                </div>
            </div>

            <div class="card">
                <div class="card-title">Recent Activity</div>
                <div class="activity"><span class="dot dot-blue"></span>Lead viewed</div>
                <div class="activity"><span class="dot dot-green"></span>Bid submitted</div>
                <div class="activity"><span class="dot dot-orange"></span>Profile pending</div>
            </div>

            <div class="card">
                <div class="card-title">Profile Completion 65%</div>
                <div class="progress"><div class="progress-bar"></div></div>
                <small class="text-muted d-block mt-2">
                    Complete profile to unlock more leads
                </small>
            </div>

        </div>
    </div>

</div>

<script>
new Chart(document.getElementById('leadsPieChart'),{
    type:'doughnut',
    data:{
        labels:['Active Leads','Bids Submitted','Projects Won'],
        datasets:[{
            data:[{{ $ActiveLeads }},12,4],
            backgroundColor:['#f97316','#2563eb','#16a34a'],
            borderWidth:2,
            borderColor:'#fff'
        }]
    },
    options:{
        cutout:'60%',
        plugins:{legend:{position:'bottom'}}
    }
});
</script>

@endsection
