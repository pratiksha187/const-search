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
    border-radius:16px;
    padding:28px;
    border:1px solid var(--border);
}

/* HEADER */
.dashboard-header{
    margin-bottom:30px;
}

.dashboard-header h2{
    font-size:24px;
    font-weight:700;
    color:var(--navy);
    margin-bottom:6px;
}

.dashboard-header p{
    color:var(--muted);
    font-size:14px;
}

/* KPI */
.kpi-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:14px;
    padding:18px;
    display:flex;
    align-items:center;
    gap:14px;
    transition:.2s;
}

.kpi-card:hover{
    box-shadow:0 4px 14px rgba(0,0,0,.08);
}

.kpi-icon{
    width:44px;
    height:44px;
    border-radius:12px;
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
}

.kpi-label{
    font-size:13px;
    color:var(--muted);
}

/* SECTION CARD */
.section-card{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:22px;
}

.section-title{
    font-size:15px;
    font-weight:700;
    color:var(--navy);
    margin-bottom:18px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}

/* PROJECT LIST */
.project-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px 0;
    border-bottom:1px dashed var(--border);
}

.project-row:last-child{
    border-bottom:none;
}

.project-row:hover{
    background:#f9fafb;
    border-radius:10px;
    padding-left:10px;
    padding-right:10px;
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
    font-size:11px;
    font-weight:600;
    padding:5px 12px;
    border-radius:999px;
}

.status-pending{background:#fff7ed;color:#9a3412;}
.status-active{background:#ecfdf5;color:#065f46;}
.status-review{background:#eff6ff;color:#1e40af;}

/* CHART */
.chart-wrap{
    height:260px;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* VENDORS */
.vendor-row{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:16px 0;
    border-bottom:1px dashed var(--border);
}

.vendor-row:last-child{
    border-bottom:none;
}

.vendor-row:hover{
    background:#f9fafb;
    border-radius:10px;
    padding-left:10px;
    padding-right:10px;
}

.vendor-name{
    font-weight:600;
    color:var(--text);
}

.vendor-type{
    font-size:13px;
    color:var(--muted);
}

/* BUTTON */
.btn-view{
    border:1px solid var(--orange);
    background:#fff;
    color:var(--orange);
    font-size:13px;
    font-weight:600;
    padding:6px 16px;
    border-radius:8px;
}

.btn-view:hover{
    background:var(--orange);
    color:#fff;
}

.dashboard-content {
    margin-top: 54px;
    padding: 30px;
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
        <p>Overview of your projects, vendors and activities</p>
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
                    <div class="kpi-label">Shortlist Vendors</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card">
                <div class="kpi-icon"><i class="bi bi-truck"></i></div>
                <div>
                    <div class="kpi-value">{{ $count_suppliers ?? 0 }}</div>
                    <div class="kpi-label">Suppliers History</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card">
                <div class="kpi-icon"><i class="bi bi-heart"></i></div>
                <div>
                    <div class="kpi-value">{{ $count_customer_interests_data ?? 0 }}</div>
                    <div class="kpi-label">Vendor History</div>
                </div>
            </div>
        </div>
    </div>

    <!-- PROJECT + CHART -->
    <div class="row g-4 mb-4">
        <div class="col-lg-7">
            <div class="section-card">
                <div class="section-title">Recent Projects</div>

                @forelse($post_data as $post)
                    <div class="project-row">
                        <div>
                            <div class="project-name">{{ $post->title }}</div>
                            <div class="project-location">
                                {{ $post->city }}, {{ $post->region }}
                            </div>
                        </div>
                        <span class="status status-pending">Submitted</span>
                    </div>
                @empty
                    <div class="text-center text-muted py-4">
                        No projects posted yet
                    </div>
                @endforelse
            </div>
        </div>

        <div class="col-lg-5">
            <div class="section-card">
                <div class="section-title">Activity Overview</div>
                <div class="chart-wrap">
                    <canvas id="progressChart"></canvas>
                </div>
                <div class="text-center mt-3">
                   
                    <small class="text-muted">Total Activities</small>
                </div>
            </div>
        </div>
    </div>

    <!-- VENDORS -->
    <div class="section-card">
        <div class="section-title">Recommended Vendors</div>

        @forelse($vendor_data as $vendor)
            <div class="vendor-row">
                <div>
                    <div class="vendor-name">
                        {{ $vendor->company_name ?? $vendor->business_name ?? $vendor->name }}
                    </div>
                    <div class="vendor-type">Verified Construction Vendor</div>
                </div>

                <a href="#" class="btn-view">View</a>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                No vendors recommended yet
            </div>
        @endforelse
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const chartData = {
    posts: {{ $count_post_data ?? 0 }},
    vendors: {{ $count_vendor_data ?? 0 }},
    suppliers: {{ $count_suppliers ?? 0 }},
    interests: {{ $count_customer_interests_data ?? 0 }},
};

new Chart(document.getElementById('progressChart'), {
    type: 'doughnut',
    data: {
        labels: ['Posts','Vendors','Suppliers','Interests'],
        datasets: [{
            data: [
                chartData.posts,
                chartData.vendors,
                chartData.suppliers,
                chartData.interests
            ],
            backgroundColor: ['#2563eb','#16a34a','#f59e0b','#dc2626'],
            borderWidth: 0
        }]
    },
    options: {
        cutout: '70%',
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

@endsection
