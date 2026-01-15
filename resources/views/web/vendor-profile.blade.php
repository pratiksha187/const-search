@extends('layouts.custapp')
@section('title','Vendor Profile')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
:root{
    --primary:#6c7cf7;
    --primary-dark:#4f6ef7;
    --success:#22c55e;
    --bg:#f5f7fb;
    --card:#ffffff;
    --border:#e5e7eb;
    --text:#0f172a;
}

body{
    font-family:'Inter',sans-serif;
    background:var(--bg);
}

/* ===== HEADER ===== */
.profile-header{
    background:linear-gradient(135deg,#6c7cf7,#7c6fd6);
    color:#fff;
    padding:32px 40px;
    border-radius:16px;
    margin-bottom:30px;
    position:relative;
}

.profile-header h1{
    font-size:32px;
    font-weight:800;
    margin-bottom:6px;
}

.profile-sub{
    font-size:16px;
    opacity:.9;
}

.profile-location{
    margin-top:10px;
    font-size:15px;
}

.verified-badge{
    position:absolute;
    right:30px;
    top:30px;
    background:#22c55e;
    color:#fff;
    font-weight:600;
    padding:8px 14px;
    border-radius:10px;
    font-size:14px;
}

/* ===== CARDS ===== */
.profile-card{
    background:var(--card);
    border:1px solid var(--border);
    border-radius:16px;
    padding:22px 24px;
    margin-bottom:20px;
}

.profile-card h4{
    font-size:22px;
    font-weight:700;
    margin-bottom:14px;
}

/* ===== LIST ===== */
.check-list{
    list-style:none;
    padding:0;
    margin:0;
}

.check-list li{
    margin-bottom:10px;
    font-size:15px;
}

.check-list li i{
    color:var(--success);
    margin-right:8px;
}

/* ===== RIGHT PANEL ===== */
.side-box{
    background:#fff;
    border:1px solid var(--border);
    border-radius:16px;
    padding:22px;
    margin-bottom:20px;
}

.side-box h5{
    font-size:20px;
    font-weight:700;
    margin-bottom:14px;
}

.value-text{
    font-size:18px;
    font-weight:700;
}

.btn-interest{
    width:100%;
    background:var(--primary);
    color:#fff;
    border:none;
    padding:14px;
    border-radius:14px;
    font-weight:700;
    font-size:16px;
}

.btn-interest:hover{
    background:var(--primary-dark);
}

.note-box{
    border:2px solid var(--primary);
    border-radius:14px;
    padding:16px;
    font-size:14px;
    color:#475569;
    background:#f8fafc;
}
</style>

@section('content')
<div class="container my-4">

    <!-- HEADER -->
    <div class="profile-header">
        <span class="verified-badge"><i class="bi bi-check-circle-fill"></i> Verified Vendor</span>

        <h1>{{ $vendor->company_name ?? 'R.K. Infra Pvt Ltd' }}</h1>
        <div class="profile-sub">{{ $vendor->work_type ?? 'Civil & Infra Contractor' }}</div>

        <div class="profile-location">
            📍 Operating in: {{ $vendor->statename ?? 'Mumbai' }} – {{ $vendor->regionname ?? 'Raigad' }}
        </div>
    </div>

    <div class="row g-4">

        <!-- LEFT CONTENT -->
        <div class="col-lg-8">

            <!-- ABOUT -->
            <div class="profile-card">
                <h4>About</h4>
                <p class="mb-0">
                    {{ $vendor->about ?? 'We are a civil and infrastructure contracting firm with experience in roads, drainage and RCC works for private and government projects.' }}
                </p>
            </div>

            <!-- SERVICES -->
            <div class="profile-card">
                <h4>Services</h4>
                <ul class="check-list">
                    @foreach(explode(',', $vendor->work_subtype_data ?? '') as $service)
                        <li><i class="bi bi-check-lg"></i> {{ trim($service) }}</li>
                    @endforeach
                </ul>
            </div>

            <!-- EXPERIENCE -->
            <div class="profile-card">
                <h4>Experience & Work Type</h4>
                <ul class="check-list">
                    <li><i class="bi bi-check-lg"></i> {{ $vendor->experience_years ?? '10+' }} years in execution</li>
                    <li><i class="bi bi-check-lg"></i> Govt + Private projects</li>
                    <li><i class="bi bi-check-lg"></i> Industrial & residential layouts</li>
                </ul>
            </div>

        </div>

        <!-- RIGHT PANEL -->
        <div class="col-lg-4">

            <!-- PROJECT CAPACITY -->
            <div class="side-box">
                <h5>Project Capacity</h5>
                <div class="mb-3">
                    <div class="text-muted">Minimum project value</div>
                    <div class="value-text">₹{{ $vendor->min_project_value ?? '25 Lakhs' }}</div>
                </div>

                <div class="mb-3">
                    <div class="text-muted">Maximum project value</div>
                    <div class="value-text">₹{{ $vendor->max_project_value ?? '25 Crores' }}</div>
                </div>

                <div>
                    <div class="text-muted">Team size</div>
                    <div class="value-text">{{ $vendor->team_size_data ?? '30–50' }}</div>
                </div>
            </div>

            <!-- CTA -->
            <button class="btn-interest mb-3"
                onclick="handleInterested({{ $vendor->id }})">
                Show Interest
            </button>

            <!-- NOTE -->
            <div class="note-box">
                <strong>Note:</strong>
                Contact details will be shared only after the vendor accepts your enquiry.
                This ensures quality connections for both parties.
            </div>

        </div>

    </div>
</div>
@endsection
