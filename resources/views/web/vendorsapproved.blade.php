@extends('layouts.adminapp') {{-- your sidebar layout --}}

@section('title','Vendor Profile')

@section('content')

<style>
.profile-card{
    background:#fff;
    border-radius:18px;
    padding:24px;
    margin-bottom:24px;
    box-shadow:0 10px 30px rgba(0,0,0,.06);
}
.section-title{
    font-size:15px;
    font-weight:700;
    color:#1c2c3e;
    margin-bottom:16px;
    border-bottom:1px solid #e5e7eb;
    padding-bottom:8px;
}
.label{
    font-size:12px;
    font-weight:600;
    color:#64748b;
}
.value{
    font-size:14px;
    font-weight:500;
    color:#0f172a;
}
.status-badge{
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}
.status-pending{ background:#fff7ed; color:#c2410c; }
.status-approved{ background:#ecfdf5; color:#047857; }
.doc-link{
    display:inline-flex;
    align-items:center;
    gap:6px;
    font-size:14px;
    font-weight:600;
    color:#2563eb;
    text-decoration:none;
}
.doc-link:hover{ text-decoration:underline; }
.logo-preview{
    max-height:120px;
    border-radius:12px;
    border:1px solid #e5e7eb;
    padding:6px;
}
</style>

{{-- ================= HEADER ================= --}}
<div class="profile-card d-flex align-items-center justify-content-between">
    <div>
        <h3 class="mb-1">{{ $vendor->company_name }}</h3>
        <div class="text-muted">{{ $vendor->work_type_name }}</div>
    </div>

    <span class="status-badge status-{{ $vendor->status }}">
        {{ ucfirst($vendor->status) }}
    </span>
</div>

{{-- ================= BASIC INFO ================= --}}
<div class="profile-card">
    <div class="section-title">Basic Information</div>

    <div class="row g-3">
        <div class="col-md-4"><div class="label">Name</div><div class="value">{{ $vendor->name }}</div></div>
        <div class="col-md-4"><div class="label">Mobile</div><div class="value">{{ $vendor->mobile }}</div></div>
        <div class="col-md-4"><div class="label">Email</div><div class="value">{{ $vendor->email }}</div></div>
        <div class="col-md-4"><div class="label">Business Name</div><div class="value">{{ $vendor->business_name }}</div></div>
        <div class="col-md-4"><div class="label">Experience</div><div class="value">{{ $vendor->experience_years }} Years</div></div>
        <div class="col-md-4"><div class="label">Team Size</div><div class="value">{{ $vendor->team_size }}</div></div>
    </div>
</div>

{{-- ================= WORK DETAILS ================= --}}
<div class="profile-card">
    <div class="section-title">Work & Project Details</div>

    <div class="row g-3">
        <div class="col-md-4"><div class="label">Minimum Project Value</div><div class="value">₹ {{ $vendor->min_project_value }}</div></div>
        <div class="col-md-4"><div class="label">Entity Type</div><div class="value">{{ $vendor->entity_type }}</div></div>
        <div class="col-md-4"><div class="label">MSME Registered</div><div class="value">{{ ucfirst($vendor->msme_registered) }}</div></div>
    </div>
</div>

{{-- ================= ADDRESS ================= --}}
<div class="profile-card">
    <div class="section-title">Registered Address</div>
    <div class="value">{!! nl2br(e($vendor->registered_address)) !!}</div>
</div>

{{-- ================= COMPLIANCE ================= --}}
<div class="profile-card">
    <div class="section-title">Compliance Details</div>

    <div class="row g-3">
        <div class="col-md-4"><div class="label">PAN</div><div class="value">{{ $vendor->pan_number }}</div></div>
        <div class="col-md-4"><div class="label">TAN</div><div class="value">{{ $vendor->tan_number }}</div></div>
        <div class="col-md-4"><div class="label">PF Code</div><div class="value">{{ $vendor->pf_code }}</div></div>
        <div class="col-md-4"><div class="label">ESIC Number</div><div class="value">{{ $vendor->esic_number }}</div></div>
       
    </div>
</div>

{{-- ================= DOCUMENTS ================= --}}
<div class="profile-card">
    <div class="section-title">Uploaded Documents</div>

    <div class="row g-3">
        @if($vendor->pan_card_file)
        <div class="col-md-4">
            <a href="{{ asset($vendor->pan_card_file) }}" target="_blank" class="doc-link">
                <i class="bi bi-file-earmark-pdf"></i> PAN Card
            </a>
        </div>
        @endif

        @if($vendor->gst_certificate_file)
        <div class="col-md-4">
            <a href="{{ asset($vendor->gst_certificate_file) }}" target="_blank" class="doc-link">
                <i class="bi bi-file-earmark-pdf"></i> GST Certificate
            </a>
        </div>
        @endif

        @if($vendor->aadhaar_card_file)
        <div class="col-md-4">
            <a href="{{ asset($vendor->aadhaar_card_file) }}" target="_blank" class="doc-link">
                <i class="bi bi-file-earmark-pdf"></i> Aadhaar Card
            </a>
        </div>
        @endif

        @if($vendor->certificate_of_incorporation_file)
        <div class="col-md-4">
            <a href="{{ asset($vendor->certificate_of_incorporation_file) }}" target="_blank" class="doc-link">
                <i class="bi bi-file-earmark-pdf"></i> Incorporation Certificate
            </a>
        </div>
        @endif

        @if($vendor->msme_file)
        <div class="col-md-4">
            <a href="{{ asset($vendor->msme_file) }}" target="_blank" class="doc-link">
                <i class="bi bi-file-earmark-pdf"></i> MSME Certificate
            </a>
        </div>
        @endif


        @if($vendor->cancelled_cheque_file)
        <div class="col-md-4">
            <a href="{{ asset($vendor->cancelled_cheque_file) }}" target="_blank" class="doc-link">
                <i class="bi bi-file-earmark-pdf"></i> Cancelled_Cheque
            </a>
        </div>
        @endif
        
        
    </div>
</div>

{{-- ================= COMPANY LOGO ================= --}}
@if($vendor->company_logo)
<div class="profile-card">
    <div class="section-title">Company Logo</div>
    <img src="{{ asset($vendor->company_logo) }}" class="logo-preview">
</div>
@endif

@endsection
