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

        @foreach([
            'pan_card_file' => 'PAN Card',
            'gst_certificate_file' => 'GST Certificate',
            'aadhaar_card_file' => 'Aadhaar Card',
            'certificate_of_incorporation_file' => 'Company Profile',
            'msme_file' => 'MSME Certificate',
            'cancelled_cheque_file' => 'Cancelled Cheque',
            'pf_documents_file' => 'PF Document',
            'esic_documents_file' => 'ESIC Document'
        ] as $field => $label)

            @if(!empty($vendor->$field))
            <div class="col-md-4">
                <a href="{{ asset('storage/'.$vendor->$field) }}"
                   target="_blank"
                   class="doc-link">
                    <i class="bi bi-file-earmark-pdf"></i> {{ $label }}
                </a>
            </div>
            @endif

        @endforeach

    </div>
</div>

{{-- ================= Work Complited Photo ================= --}}
@if(
    $vendor->work_completion_certificates_file1 ||
    $vendor->work_completion_certificates_file2 ||
    $vendor->work_completion_certificates_file3
)
<div class="profile-card">
    <div class="section-title">Work Completion Certificates</div>

    <div class="row g-3">

        @if($vendor->work_completion_certificates_file1)
        <div class="col-md-4">
            <img src="{{ asset('storage/'.$vendor->work_completion_certificates_file1) }}"
                 class="img-fluid rounded border"
                 style="height:180px;object-fit:cover;width:100%;">
        </div>
        @endif

        @if($vendor->work_completion_certificates_file2)
        <div class="col-md-4">
            <img src="{{ asset('storage/'.$vendor->work_completion_certificates_file2) }}"
                 class="img-fluid rounded border"
                 style="height:180px;object-fit:cover;width:100%;">
        </div>
        @endif

        @if($vendor->work_completion_certificates_file3)
        <div class="col-md-4">
            <img src="{{ asset('storage/'.$vendor->work_completion_certificates_file3) }}"
                 class="img-fluid rounded border"
                 style="height:180px;object-fit:cover;width:100%;">
        </div>
        @endif

    </div>
</div>
@endif


{{-- ================= COMPANY LOGO ================= --}}
@if($vendor->company_logo)
<div class="profile-card">
    <div class="section-title">Company Logo</div>
    <img src="{{ asset('storage/'.$vendor->company_logo) }}" class="logo-preview">
</div>
@endif

@endsection
