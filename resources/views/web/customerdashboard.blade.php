@extends('layouts.custapp')

@section('title', 'Dashboard | ConstructKaro')

@section('content')

<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --bg:#f4f6f9;
    --border:#e5e7eb;
    --text:#374151;
    --muted:#6b7280;
}

/* PAGE */
body{
    background:var(--bg);
    font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
}

/* WRAPPER */
.dashboard-wrapper{
    max-width:1400px;
    margin:30px auto;
    padding:0 16px;
}

/* MAIN CARD */
.dashboard-card{
    background:#fff;
    border-radius:14px;
    padding:28px;
    border:1px solid var(--border);
}

/* HEADER */
.dashboard-header{
    margin-bottom:28px;
}

.dashboard-header h2{
    font-size:24px;
    font-weight:700;
    color:var(--navy);
    margin-bottom:4px;
}

.dashboard-header p{
    color:var(--muted);
    font-size:14px;
}

/* KPI */
.kpi-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:12px;
    padding:18px;
    display:flex;
    align-items:center;
    gap:14px;
}

.kpi-icon{
    width:42px;
    height:42px;
    border-radius:10px;
    background:#f3f4f6;
    display:flex;
    align-items:center;
    justify-content:center;
    color:var(--navy);
    font-size:18px;
}

.kpi-value{
    font-size:22px;
    font-weight:700;
    color:var(--navy);
    line-height:1;
}

.kpi-label{
    font-size:13px;
    color:var(--muted);
}

/* SECTIONS */
.section-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:12px;
    padding:20px;
}

.section-title{
    font-size:16px;
    font-weight:700;
    color:var(--navy);
    margin-bottom:16px;
}

/* PROJECTS */
.project-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:12px 0;
    border-bottom:1px solid var(--border);
}

.project-row:last-child{
    border-bottom:none;
}

.project-name{
    font-weight:600;
    color:var(--text);
}

.project-location{
    font-size:12px;
    color:var(--muted);
}

/* STATUS */
.status{
    font-size:12px;
    font-weight:600;
    padding:4px 10px;
    border-radius:20px;
}

.status-pending{background:#fff7ed;color:#9a3412;}
.status-active{background:#ecfdf5;color:#065f46;}
.status-review{background:#eff6ff;color:#1e40af;}

/* CHART */
.chart-wrap{
    height:260px;
}

/* VENDORS */
.vendor-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 0;
    border-bottom:1px solid var(--border);
}

.vendor-row:last-child{
    border-bottom:none;
}

.vendor-name{
    font-weight:600;
    color:var(--text);
}

.vendor-type{
    font-size:13px;
    color:var(--muted);
}

.btn-view{
    border:1px solid var(--orange);
    background:#fff;
    color:var(--orange);
    font-size:13px;
    font-weight:600;
    padding:6px 14px;
    border-radius:6px;
}

.btn-view:hover{
    background:var(--orange);
    color:#fff;
}

/* MOBILE */
@media(max-width:768px){
    .dashboard-card{padding:20px;}
}
</style>

<div class="dashboard-wrapper">
<div class="dashboard-card">

    <!-- HEADER -->
    <div class="dashboard-header">
        <h2>Welcome, {{ $cust_data->name ?? 'Customer' }}</h2>
        <p>Overview of your projects, vendors and quotations</p>
    </div>

    <!-- KPI -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="kpi-card">
                <div class="kpi-icon"><i class="bi bi-folder"></i></div>
                <div>
                    <div class="kpi-value">{{ $count_post_data }}</div>
                    <div class="kpi-label">My Posts</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card">
                <div class="kpi-icon"><i class="bi bi-people"></i></div>
                <div>
                    <div class="kpi-value">{{ $count_vendor_data }}</div>
                    <div class="kpi-label">Connected Vendors</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card">
                <div class="kpi-icon"><i class="bi bi-receipt"></i></div>
                <div>
                    <div class="kpi-value">{{ $count_suppliers ?? 0 }}</div>
                    <div class="kpi-label">Total Suppliers</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card">
                <div class="kpi-icon"><i class="bi bi-bell"></i></div>
                <div>
                    <div class="kpi-value">{{ $vendor_interests ?? 0 }}</div>
                    <div class="kpi-label">Interests Vendor</div>
                </div>
            </div>
        </div>
    </div>

    <!-- PROJECT + CHART -->
    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="section-card">
                <div class="section-title">Recent Projects</div>

                <div class="project-row">
                    <div>
                        <div class="project-name">Industrial Shed at Chakan</div>
                        <div class="project-location">Pune</div>
                    </div>
                    <span class="status status-pending">Pending</span>
                </div>

                <div class="project-row">
                    <div>
                        <div class="project-name">Residential Bungalow – Nashik</div>
                        <div class="project-location">Nashik</div>
                    </div>
                    <span class="status status-active">Active</span>
                </div>

                <div class="project-row">
                    <div>
                        <div class="project-name">Office Interior – Baner</div>
                        <div class="project-location">Pune</div>
                    </div>
                    <span class="status status-review">Under Review</span>
                </div>

            </div>
        </div>

        <div class="col-lg-5">
            <div class="section-card">
                <div class="section-title">Project Status</div>
                <div class="chart-wrap">
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- VENDORS -->
    <div class="section-card">
        <div class="section-title">Recommended Vendors</div>

        <div class="vendor-row">
            <div>
                <div class="vendor-name">Shreeyash Construction Pvt Ltd</div>
                <div class="vendor-type">PEB / Industrial Contractor</div>
            </div>
            <button class="btn-view">View</button>
        </div>

        <div class="vendor-row">
            <div>
                <div class="vendor-name">DesignArc Architects</div>
                <div class="vendor-type">Architect / Planning</div>
            </div>
            <button class="btn-view">View</button>
        </div>

        <div class="vendor-row">
            <div>
                <div class="vendor-name">Urban Interiors</div>
                <div class="vendor-type">Interior Designer</div>
            </div>
            <button class="btn-view">View</button>
        </div>
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('progressChart'), {
    type: 'doughnut',
    data: {
        labels: ['Submitted','Shortlisted','Quotes','Selected'],
        datasets: [{
            data: [12,6,4,2],
            backgroundColor: ['#2563eb','#16a34a','#facc15','#dc2626'],
            borderWidth:0
        }]
    },
    options:{
        cutout:'70%',
        plugins:{ legend:{display:false} },
        maintainAspectRatio:false
    }
});
</script>

@endsection
