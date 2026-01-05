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

/* PAGE */
.dashboard-wrap{
    max-width:1450px;
    margin:24px auto 40px;
    padding:0 16px;
}

/* HEADER */
.dashboard-header{
    margin-bottom:24px;
}
.dashboard-header h2{
    font-size:26px;
    font-weight:800;
}
.dashboard-header p{
    font-size:14px;
    color:var(--muted);
}

/* KPI */
.kpi-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:14px;
    padding:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    height:100%;
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
    width:42px;
    height:42px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
}
.orange{background:#f97316;}
.blue{background:#2563eb;}
.green{background:#16a34a;}
.gold{background:#f59e0b;}

/* CARD */
.card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:14px;
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
.btn-interest{
    background:var(--orange);
    color:#fff;
    padding:6px 16px;
    border-radius:20px;
    font-size:13px;
    font-weight:700;
    text-decoration:none;
}

/* QUICK */
.quick-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
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
    width:7px;
    height:7px;
    border-radius:50%;
    display:inline-block;
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
}
.progress-bar{
    width:65%;
    height:100%;
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
}
</style>

<div class="dashboard-wrap">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h2>Hi {{ $vendor->name }} 👋</h2>
        <p>Track your leads, bids and projects at a glance</p>
    </div>

    <!-- KPI ROW -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="kpi-card">
                <div>
                    <div class="kpi-title">Active Leads</div>
                    <div class="kpi-value">{{ $ActiveLeads }}</div>
                    <div class="kpi-sub">Open opportunities</div>
                </div>
                <div class="kpi-icon orange"><i class="bi bi-briefcase-fill"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card">
                <div>
                    <div class="kpi-title">Bids Submitted</div>
                    <div class="kpi-value">{{ $BidsSubmitted ?? 0 }}</div>
                    <div class="kpi-sub">Under review</div>
                </div>
                <div class="kpi-icon blue"><i class="bi bi-file-earmark-text"></i></div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card">
                <div>
                    <div class="kpi-title">Projects Won</div>
                    <div class="kpi-value">{{ $ProjectsWon ?? 0 }}</div>
                    <div class="kpi-sub">Converted</div>
                </div>
                <div class="kpi-icon green"><i class="bi bi-check-circle-fill"></i></div>
            </div>
        </div>

        <div class="col-md-3">
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

    <!-- MAIN CONTENT -->
    <div class="row">

        <!-- LEFT -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-title">
                    <span>New Opportunities</span>
                    <a href="{{ route('search_customer') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Project</th>
                                <th>Location</th>
                                <th>Posted</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($projects->take(6) as $project)
                            <tr>
                                <td><strong>{{ $project->title }}</strong></td>
                                <td>{{ $project->city }}, {{ $project->state }}</td>
                                <td>{{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</td>
                                <td class="text-end">
                                    <a href="#" class="btn-interest">Interested</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No opportunities available</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
              <div class="card">
                <div class="card-title">Quick Actions</div>
                <div class="quick-grid">
                    <a href="{{route('vendor.profile')}}" class="quick-btn">Complete Profile</a>
                    <a href="{{ route('search_customer') }}" class="quick-btn">View Leads</a>

                </div>
            </div>
        </div>

        <!-- RIGHT -->
        <div class="col-lg-4">

            <div class="card">
                <div class="card-title">Leads Overview</div>
                <canvas id="leadsPieChart" height="220"></canvas>
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
            data:[{{ $ActiveLeads }},{{ $BidsSubmitted ?? 0 }},{{ $ProjectsWon ?? 0 }}],
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
