@extends('layouts.suppliersapp')

@section('title','Supplier Dashboard | ConstructKaro')

@section('content')

<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --muted:#64748b;
    --bg:#f4f6f9;
    --card:#ffffff;
    --border:#e5e7eb;
}

body{
    background:var(--bg);
    font-family:system-ui,-apple-system,BlinkMacSystemFont;
}

.dashboard-wrapper{
    max-width:1400px;
    margin:90px auto 40px;
    padding:0 20px;
}

.main-card{
    background:var(--card);
    border:1px solid var(--border);
    border-radius:14px;
    padding:26px;
    box-shadow:0 12px 30px rgba(0,0,0,.06);
}

/* HEADER */
.dashboard-header{
    font-size:24px;
    font-weight:700;
    color:var(--navy);
    margin-bottom:22px;
}

/* STATS */
.stats-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:16px;
    margin-bottom:28px;
}
.stat-box{
    border:1px solid var(--border);
    border-radius:10px;
    padding:16px;
    background:#f9fafb;
}
.stat-value{
    font-size:22px;
    font-weight:700;
    color:var(--navy);
}
.stat-label{
    font-size:13px;
    color:var(--muted);
}

/* SECTION */
.section{
    border:1px solid var(--border);
    border-radius:12px;
    padding:18px;
    margin-bottom:24px;
    background:#fff;
}
.section h5{
    font-size:16px;
    font-weight:700;
    color:var(--navy);
    margin-bottom:4px;
}
.section p{
    font-size:13px;
    color:var(--muted);
    margin-bottom:10px;
}

/* ACTIONS */
.actions{
    display:flex;
    gap:12px;
    margin-top:10px;
}

/* ORDER STATUS */
.status-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:12px;
    margin-top:14px;
}
.status-box{
    text-align:center;
    padding:14px;
    background:#f9fafb;
    border:1px solid var(--border);
    border-radius:10px;
}
.status-box .count{
    font-size:20px;
    font-weight:700;
    color:var(--navy);
}
.status-box .text{
    font-size:12px;
    color:var(--muted);
}

/* CHARTS */
.chart-box{
    border:1px solid var(--border);
    border-radius:12px;
    padding:16px;
    background:#fff;
}

.dashboard-content {
    padding: 25px;
    padding-top: 10px !important;
    min-height: 83vh;
}

/* RESPONSIVE */
@media(max-width:992px){
    .stats-grid{grid-template-columns:1fr;}
    .status-grid{grid-template-columns:1fr 1fr;}
}
</style>

<div class="dashboard-wrapper">

    <div class="main-card">

        <!-- HEADER -->
        <div class="dashboard-header">
            Welcome, {{ Session::get('user_name') ?? 'Supplier' }}
        </div>

        <!-- STATS -->
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-value">12</div>
                <div class="stat-label">New Orders</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">₹ 24,500</div>
                <div class="stat-label">Today’s Earnings</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">58</div>
                <div class="stat-label">Products Listed</div>
            </div>
        </div>

        <!-- STORE + PRODUCT (ROW) -->
        <div class="row g-4 mb-4">

            <div class="col-md-6">
                <div class="section h-100">
                    <h5>Store Setup</h5>
                    <p>Manage store details, service areas, timings and KYC documents.</p>
                    <div class="actions">
                        <button class="btn" style="background:var(--orange);color:#fff;">
                            Manage Store
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="section h-100">
                    <h5>Product Management</h5>
                    <p>Add materials, manage pricing, stock and categories.</p>
                    <div class="actions">
                        <button class="btn btn-success">Add Product</button>
                        <button class="btn btn-outline-secondary">View Products</button>
                    </div>
                </div>
            </div>

        </div>

        <!-- ORDER MANAGEMENT -->
        <div class="section">
            <h5>Order Management</h5>
            <p>Monitor and track order progress.</p>

            <div class="status-grid">
                <div class="status-box">
                    <div class="count">5</div>
                    <div class="text">New</div>
                </div>
                <div class="status-box">
                    <div class="count">3</div>
                    <div class="text">Preparing</div>
                </div>
                <div class="status-box">
                    <div class="count">2</div>
                    <div class="text">Out for Delivery</div>
                </div>
                <div class="status-box">
                    <div class="count">18</div>
                    <div class="text">Completed</div>
                </div>
            </div>
        </div>

        <!-- ANALYTICS -->
        <div class="section">
            <h5>Business Analytics</h5>
            <p>Earnings trend and order distribution.</p>

            <div class="row g-4 mt-2">
                <div class="col-md-8">
                    <div class="chart-box">
                        <strong>Earnings (Last 7 Days)</strong>
                        <canvas id="earningsChart" height="120"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="chart-box">
                        <strong>Order Status</strong>
                        <canvas id="orderChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- EARNINGS -->
        <div class="section">
            <h5>Earnings Dashboard</h5>
            <p>View daily, weekly and monthly earnings reports.</p>
            <button class="btn btn-primary">View Earnings</button>
        </div>

        <!-- DELIVERY -->
        <div class="section">
            <h5>Delivery Workflow</h5>
            <p>Manage delivery lifecycle from accepted to delivered.</p>
            <button class="btn btn-dark">Manage Deliveries</button>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('earningsChart'), {
    type:'line',
    data:{
        labels:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        datasets:[{
            data:[12000,15000,11000,18000,22000,19500,24500],
            borderColor:'#f25c05',
            backgroundColor:'rgba(242,92,5,.15)',
            fill:true,
            tension:.4
        }]
    },
    options:{
        plugins:{legend:{display:false}},
        scales:{y:{ticks:{callback:v=>'₹ '+v}}}
    }
});

new Chart(document.getElementById('orderChart'), {
    type:'doughnut',
    data:{
        labels:['New','Preparing','Out','Completed'],
        datasets:[{
            data:[5,3,2,18],
            backgroundColor:['#f25c05','#facc15','#3b82f6','#22c55e']
        }]
    },
    options:{
        cutout:'65%',
        plugins:{legend:{position:'bottom'}}
    }
});
</script>

@endsection
