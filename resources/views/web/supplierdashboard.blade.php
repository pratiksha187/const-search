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
/* WELCOME */
.dashboard-welcome{
    margin-bottom:30px;
}

.dashboard-welcome h2{
    font-weight:700;
    color:#0f172a;
    margin-bottom:6px;
}

.dashboard-welcome h2 span{
    color:#0f172a;
}

.dashboard-welcome p{
    color:#64748b;
    margin:0;
    font-size:15px;
}

/* STAT CARDS */
.dashboard-stats .stat-box{
    background:#fff;
    border-radius:18px;
    padding:22px;
    display:flex;
    align-items:center;
    gap:16px;
    height:100%;
    min-height:120px;
    box-shadow:0 10px 28px rgba(15,23,42,.08);
    transition:.25s;
}


.dashboard-stats .stat-box:hover{
    transform:translateY(-4px);
}

/* ICON */

.stat-box .icon{
    width:56px;
    height:56px;
    min-width:56px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
}

.icon.blue{ background:#3b82f6; }
.icon.orange{ background:#f97316; }
.icon.purple{ background:#8b5cf6; }
.icon.green{ background:#10b981; }

/* INFO */
.stat-info{
    display:flex;
    flex-direction:column;
    justify-content:center;
}

.stat-info span{
    font-size:13px;
    font-weight:500;
}


.stat-info h3{
    margin:0;
    font-weight:800;
    font-size:30px;
    color:#0f172a;
}

.stat-info small{
    font-size:13px;
}

.stat-info .positive{
    color:#16a34a;
}

.stat-info .info{
    color:#2563eb;
}

.stat-info .muted{
    color:#64748b;
}

/* MOBILE */
@media(max-width:768px){
    .stat-info h3{
        font-size:26px;
    }
}

@media(max-width:768px){
    .dashboard-stats .stat-box{
        padding:18px;
        min-height:auto;
    }
}

/* CARD */
.card-box{
    background:#fff;
    border-radius:20px;
    padding:24px;
    box-shadow:0 14px 40px rgba(15,23,42,.08);
}

/* HEADER */
.card-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:18px;
}

.card-header h5{
    font-weight:700;
}

.view-all{
    color:#2563eb;
    font-weight:600;
    text-decoration:none;
}

/* ENQUIRY */
.enquiry-item{
    border:1px solid #e5e7eb;
    border-radius:16px;
    padding:20px;
    margin-bottom:16px;
}

.enquiry-item.active{
    border-left:4px solid #2563eb;
    background:#f8fbff;
}

.enquiry-item h6{
    font-weight:700;
    margin-bottom:4px;
}

.muted{
    color:#64748b;
    font-size:14px;
}

/* BADGES */
.badge{
    font-size:11px;
    padding:4px 10px;
    border-radius:999px;
    margin-left:8px;
}

.badge.new{
    background:#ffedd5;
    color:#f97316;
}

.badge.urgent{
    background:#e0f2fe;
    color:#2563eb;
}

/* META */
.enquiry-meta{
    display:flex;
    gap:18px;
    margin:10px 0;
    font-size:14px;
    color:#475569;
}

.details{
    font-size:14px;
    margin-bottom:14px;
}

/* ACTIONS */
.actions{
    display:grid;
    grid-template-columns:1fr auto auto;
    gap:10px;
}

.btn-primary{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    border:none;
}

.btn-call{
    background:#16a34a;
    color:#fff;
    border:none;
}

.btn-whatsapp{
    background:#22c55e;
    color:#fff;
    border:none;
}

/* PROFILE */
.progress-info{
    display:flex;
    justify-content:space-between;
    align-items:end;
    margin-bottom:10px;
}

.progress{
    height:8px;
    border-radius:10px;
    background:#e5e7eb;
    margin-bottom:18px;
}

.progress-bar{
    background:#2563eb;
    border-radius:10px;
}

/* CHECKLIST */
.profile-checklist{
    list-style:none;
    padding:0;
    margin:0;
}

.profile-checklist li{
    display:flex;
    align-items:center;
    gap:10px;
    padding:10px 12px;
    border-radius:10px;
    border:1px dashed #cbd5e1;
    margin-bottom:10px;
    font-size:14px;
}

.profile-checklist li.done{
    background:#f0fdf4;
    border:none;
    color:#15803d;
}

.profile-checklist i{
    font-size:16px;
}

/* BUTTON */
.btn-success{
    background:#10b981;
    border:none;
    font-weight:600;
}

</style>

<div class="dashboard-wrapper">
<div class="main-card">

    {{-- HEADER --}}
   

<div class="dashboard-welcome">
    <h2>Welcome back, <span>{{ $supplierName }}!</span> 👋</h2>
    <p>Here's what's happening with your business today</p>
</div>

    {{-- STATS --}}
   <div class="row g-4 dashboard-stats">
    <!-- Card 1 -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-box">
            <div class="icon blue">
                <i class="bi bi-chat-dots"></i>
            </div>
            <div class="stat-info">
                <span>Total Enquiries</span>
                <h3>{{$supplier_enquiries}}</h3>
                <small class="positive">+6 this week</small>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-box">
            <div class="icon orange">
                <i class="bi bi-clock"></i>
            </div>
            <div class="stat-info">
                <span>Active Enquiries</span>
                <h3>{{$supplier_enquiries}}</h3>
                <small class="muted">Awaiting response</small>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-box">
            <div class="icon purple">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div class="stat-info">
                <span>Quotes Sent</span>
                <h3>0</h3>
                <small class="info">50% response rate</small>
            </div>
        </div>
    </div>

    <!-- Card 4 -->
    <div class="col-xl-3 col-md-6">
        <div class="stat-box">
            <div class="icon green">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-info">
                <span>Orders Converted</span>
                <h3>0</h3>
                <small class="positive">₹28.5L total value</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mt-2">

    @foreach($supp_enq_data as $enquiry)
    <div class="col-xl-6 col-lg-6 col-md-12">

        <div class="enquiry-item {{ $enquiry->status === null ? 'active' : '' }}">
            <div class="enquiry-left">

                {{-- Header --}}
                <h6>
                    Customer #{{ $enquiry->name }}
                    @if($enquiry->status === null)
                        <!-- <span class="badge new">New</span> -->
                    @elseif($enquiry->status === 'quoted')
                        <span class="badge bg-success">Quoted</span>
                    @endif
                </h6>

                {{-- Specs --}}
                <p class="muted">{{ $enquiry->specs ?? 'Project Enquiry' }}</p>

                {{-- Meta --}}
                <div class="enquiry-meta">
                    <span>
                        <i class="bi bi-geo-alt"></i>
                        {{ $enquiry->delivery_location }}
                    </span>
                    <span>
                        <i class="bi bi-box"></i>
                        Category ID: {{ $enquiry->category }}
                    </span>
                </div>

                {{-- Details --}}
                <p class="details">
                    <strong>Quantity:</strong> {{ number_format($enquiry->quantity) }} |
                    <strong>Payment:</strong> {{ ucfirst($enquiry->payment_preference) }}
                </p>

                {{-- Actions --}}
                <div class="actions">
                    <a href="" class="btn btn-primary">Send Quote</a>

                    @if($enquiry->status === 'quoted')
                        <button class="btn btn-call">
                            <i class="bi bi-telephone"></i> Call
                        </button>
                        <button class="btn btn-whatsapp">
                            <i class="bi bi-whatsapp"></i> WhatsApp
                        </button>
                    @else
                        <small class="text-muted">
                            Contact details visible after acceptance
                        </small>
                    @endif
                </div>

            </div>
        </div>

    </div>
    @endforeach

</div>


</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- <script>
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
</script> -->

@endsection
