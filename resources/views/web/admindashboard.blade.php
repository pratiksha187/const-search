@extends('layouts.adminapp')

@section('title', 'Dashboard | ConstructKaro')

@section('content')

<style>
:root {
    --navy: #1c2c3e;
    --orange: #f25c05;
    --bg: #f5f7fb;
}

/* PAGE */
body {
    background: var(--bg);
}

/* MAIN WRAPPER */
.dashboard-wrapper {
    max-width: 1630px;
    margin: 30px auto;
    padding: 0 15px;
}

/* MASTER CARD */
.dashboard-card {
    background: #fff;
    border-radius: 28px;
    padding: 30px;
    box-shadow: 0 30px 80px rgba(0,0,0,0.10);
    border: 1px solid #e5e7eb;
}

/* HEADER */
.dashboard-header {
    padding-bottom: 20px;
    border-bottom: 1px solid #eef1f6;
    margin-bottom: 25px;
}

.welcome-title {
    font-weight: 800;
    font-size: 28px;
    color: var(--navy);
}

.welcome-sub {
    color: #6b7280;
    font-size: 14px;
}

/* KPI CARDS */
.kpi-card {
    background: #f9fafb;
    border-radius: 18px;
    padding: 22px;
    display: flex;
    gap: 14px;
    align-items: center;
    border: 1px solid #eef1f6;
}

.kpi-icon {
    width: 48px;
    height: 48px;
    background: #eaf2ff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--navy);
}

.kpi-value {
    font-size: 26px;
    font-weight: 800;
    margin: 0;
    color: var(--navy);
}

.kpi-label {
    font-size: 14px;
    color: #6b7280;
}

/* DATA CARDS */
.data-card {
    background: #ffffff;
    padding: 24px;
    border-radius: 22px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    border: 1px solid #eef1f6;
}

.section-title {
    font-size: 18px;
    font-weight: 800;
    margin-bottom: 20px;
    color: var(--navy);
}

/* ITEMS */
.project-item, .vendor-item {
    padding: 14px 0;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px solid #eef1f6;
}

.project-item:last-child,
.vendor-item:last-child {
    border-bottom: none;
}

/* STATUS */
.badge-status {
    padding: 4px 12px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 700;
}

.bg-warning-light { background:#fff3cd; color:#8a6d3b;}
.bg-success-light { background:#d4edda; color:#155724;}
.bg-info-light { background:#d1ecf1; color:#0c5460;}

/* BUTTON */
.btn-view {
    border: 1px solid var(--orange);
    color: var(--orange);
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
}

.btn-view:hover {
    background: var(--orange);
    color: #fff;
}

/* CHART */
.chart-card {
    background: #ffffff;
    border-radius: 22px;
    padding: 22px;
    border: 1px solid #eef1f6;
    height: 100%;
}
#progressChart {
    height: 320px !important;
}
.dashboard-content {
    margin-top: 62px;
    padding: 14px;
}
</style>

<div class="dashboard-wrapper">

    <!-- 🔥 MASTER DASHBOARD CARD -->
    <div class="dashboard-card">

        <!-- HEADER -->
        <div class="dashboard-header">
            <h3 class="welcome-title">
                Hi Admin 👋
            </h3>
            <p class="welcome-sub">
                Track your leads, bids and projects at a glance.
            </p>
        </div>

        <!-- KPI ROW -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <a href="{{ route('projectslist') }}" class="text-decoration-none text-dark">
                    <div class="kpi-card">
                        <div class="kpi-icon"><i class="bi bi-folder"></i></div>
                        <div>
                            <p class="kpi-value">{{ $count_post_data }}</p>
                            <p class="kpi-label">Total Projects</p>
                        </div>
                    </div>
                </a>

            </div>

            <div class="col-md-3">
                  <a href="{{ route('admin.vendors.index') }}" class="text-decoration-none text-dark">
                <div class="kpi-card">
                  
                    <div class="kpi-icon"><i class="bi bi-people"></i></div>
                    <div>
                        <p class="kpi-value">{{ $count_vendor_data  }}</p>
                        <p class="kpi-label">Connected Vendors</p>
                    </div>
                   
                </div>
                 </a>
            </div>

            <div class="col-md-3">
                <a href="{{ route('admin.suppliers.index') }}" class="text-decoration-none text-dark">
                <div class="kpi-card">
                    <div class="kpi-icon"><i class="bi bi-receipt"></i></div>
                    <div>
                        <p class="kpi-value">{{ $count_supplier_reg }}</p>
                        <p class="kpi-label">Connected Suppliers</p>
                    </div>
                </div>
                 </a>
            </div>

            <div class="col-md-3">
                <div class="kpi-card">
                    <div class="kpi-icon"><i class="bi bi-bell"></i></div>
                    <div>
                        <p class="kpi-value">{{ $notifications ?? 2 }}</p>
                        <p class="kpi-label">Notifications</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- PROJECTS + CHART -->
        <!-- <div class="row g-4">

            <div class="col-lg-8">
                <div class="data-card">
                    <h6 class="section-title">Recent Projects 🏗️</h6>

                    <div class="project-item">
                        <div>
                            <strong>Industrial Shed at Chakan</strong><br>
                            <small class="text-muted">📍 Pune</small>
                        </div>
                        <span class="badge-status bg-warning-light">Pending</span>
                    </div>

                    <div class="project-item">
                        <div>
                            <strong>Residential Bungalow – Nashik</strong><br>
                            <small class="text-muted">📍 Nashik</small>
                        </div>
                        <span class="badge-status bg-success-light">Active</span>
                    </div>

                    <div class="project-item">
                        <div>
                            <strong>Office Interior – Baner</strong><br>
                            <small class="text-muted">📍 Pune</small>
                        </div>
                        <span class="badge-status bg-info-light">Under Review</span>
                    </div>

                    <a href="#" class="text-primary small fw-bold mt-2 d-inline-block">
                        View all projects ➜
                    </a>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="chart-card">
                    <h6 class="section-title">Project Status Overview</h6>
                    <canvas id="progressChart"></canvas>
                </div>
            </div>

        </div> -->

        <!-- VENDORS -->
        <!-- <div class="data-card mt-4">
            <h6 class="section-title">Recommended Vendors ⭐</h6>

            <div class="vendor-item">
                <div>
                    <strong>Shreeyash Construction Pvt Ltd</strong><br>
                    <small class="text-muted">PEB / Industrial Contractor</small>
                </div>
                <button class="btn-view">View</button>
            </div>

            <div class="vendor-item">
                <div>
                    <strong>DesignArc Architects</strong><br>
                    <small class="text-muted">Architect / Planning</small>
                </div>
                <button class="btn-view">View</button>
            </div>

            <div class="vendor-item">
                <div>
                    <strong>Urban Interiors</strong><br>
                    <small class="text-muted">Interior Designer</small>
                </div>
                <button class="btn-view">View</button>
            </div>
        </div> -->

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('progressChart'), {
    type: 'doughnut',
    data: {
        labels: ['Submitted', 'Shortlisted', 'Quotes', 'Selection'],
        datasets: [{
            data: [90, 40, 20, 10],
            backgroundColor: ['#1A73E8','#34A853','#FBBC05','#D93025'],
            borderWidth: 0
        }]
    },
    options: {
        maintainAspectRatio: false,
        cutout: "65%",
        plugins: { legend: { display: false } }
    }
});
</script>

@endsection
