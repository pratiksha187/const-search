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
.dashboard-header{
    font-size:24px;
    font-weight:700;
    color:var(--navy);
    margin-bottom:22px;
}
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
.dashboard-content {
    padding: 25px;
    padding-top: 9px !important;
    min-height: 85vh;
}
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
}
.section p{
    font-size:13px;
    color:var(--muted);
}
.actions{
    display:flex;
    gap:12px;
    margin-top:10px;
}
.chart-box{
    border:1px solid var(--border);
    border-radius:12px;
    padding:16px;
    background:#fff;
}
@media(max-width:992px){
    .stats-grid{grid-template-columns:1fr;}
}
</style>

<div class="dashboard-wrapper">
<div class="main-card">

    {{-- HEADER --}}
    <div class="dashboard-header">
        Welcome, {{ Session::get('user_name') ?? 'Supplier' }}
    </div>

    {{-- STATS --}}
    <div class="stats-grid">
        <div class="stat-box">
            <div class="stat-value">{{ $productCount }}</div>
            <div class="stat-label">Products Listed</div>
        </div>

        <div class="stat-box">
            <div class="stat-value">₹ {{ number_format($avgPrice ?? 0,2) }}</div>
            <div class="stat-label">Average Product Price</div>
        </div>

        <div class="stat-box">
            <div class="stat-value">₹ {{ number_format($latestProduct ?? 0,2) }}</div>
            <div class="stat-label">Latest Product Price</div>
        </div>
    </div>

    {{-- STORE & PRODUCTS --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="section h-100">
                <h5>Store Setup</h5>
                <p>Manage store details, service areas, timings and KYC documents.</p>
                <div class="actions">
                    <a href="{{ route('suppliers.profile') }}"
                       class="btn"
                       style="background:var(--orange);color:#fff;">
                        Manage Store
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="section h-100">
                <h5>Product Management</h5>
                <p>Add materials, manage pricing, stock and categories.</p>
                <div class="actions">
                    <a href="{{ route('addproducts') }}"
                       class="btn"
                       style="background:var(--navy);color:#fff;">
                        Add Product
                    </a>
                    <a href="{{ route('myproducts') }}"
                       class="btn btn-outline-secondary">
                        View Products
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ANALYTICS --}}
    <div class="section">
        <h5>Product Analytics</h5>
        <p>Products added and category distribution.</p>

        <div class="row g-4 mt-2">
            <div class="col-md-8">
                <div class="chart-box">
                    <strong>Products Added (Last 7 Days)</strong>
                    <canvas id="productChart" height="120"></canvas>
                </div>
            </div>

            <div class="col-md-4">
                <div class="chart-box">
                    <strong>Category Distribution</strong>
                    <canvas id="categoryChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
/* PRODUCTS ADDED – LINE CHART */
new Chart(document.getElementById('productChart'), {
    type: 'line',
    data: {
        labels: @json($labels),
        datasets: [{
            data: @json($values),
            label: 'Products Added',
            borderColor: '#f25c05',
            backgroundColor: 'rgba(242,92,5,.15)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        }
    }
});

/* CATEGORY DISTRIBUTION – DONUT */
new Chart(document.getElementById('categoryChart'), {
    type: 'doughnut',
    data: {
        labels: @json($categoryLabels),
        datasets: [{
            data: @json($categoryCounts),
            backgroundColor: [
                '#f25c05',
                '#3b82f6',
                '#22c55e',
                '#facc15',
                '#8b5cf6'
            ]
        }]
    },
    options: {
        cutout: '65%',
        plugins: { legend: { position: 'bottom' } }
    }
});
</script>

@endsection
