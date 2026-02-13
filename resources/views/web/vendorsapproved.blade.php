@extends('layouts.adminapp')

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
    font-size:16px;
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
</style>

{{-- ================= HEADER ================= --}}
<div class="profile-card d-flex justify-content-between align-items-center">
    <div>
        <h3>{{ $vendor->company_name }}</h3>
        <div class="text-muted">{{ $vendor->work_type_name }}</div>

        <span class="badge {{ $vendor->status == 'approved' ? 'bg-success' : 'bg-warning' }}">
            {{ ucfirst($vendor->status) }}
        </span>

        @if($vendor->agreement_accepted_at)
            <span class="badge bg-success">Agreement Accepted</span>
        @endif
    </div>

    <div>
        <span class="badge bg-info">
            {{ $vendor->lead_balance }} Credit Points
        </span>
    </div>
</div>

{{-- ================= BASIC INFORMATION ================= --}}
<div class="profile-card">
    <div class="section-title">Basic Information</div>
    <div class="row g-3">
        <div class="col-md-4"><div class="label">Name</div><div class="value">{{ $vendor->name }}</div></div>
        <div class="col-md-4"><div class="label">Mobile</div><div class="value">{{ $vendor->mobile }}</div></div>
        <div class="col-md-4"><div class="label">Email</div><div class="value">{{ $vendor->email }}</div></div>
        <div class="col-md-4"><div class="label">Designation</div><div class="value">{{ $vendor->contact_person_designation }}</div></div>
        
        <div class="col-md-4"><div class="label">Business Name</div><div class="value">{{ $vendor->business_name }}</div></div>
        <div class="col-md-4"><div class="label">Experience</div><div class="value">{{ $vendor->experiance }}</div></div>
        <div class="col-md-4"><div class="label">Team Size</div><div class="value">{{ $vendor->team_size_data }}</div></div>
        <div class="col-md-4"><div class="label">Minimum Project Value</div><div class="value">₹ {{ $vendor->min_project_value }}</div></div>
    </div>
</div>

{{-- ================= LOCATION DETAILS ================= --}}
<div class="profile-card">
    <div class="section-title">Location Details</div>
    <div class="row g-3">
        <div class="col-md-4"><div class="label">State</div><div class="value">{{ $vendor->statename }}</div></div>
        <div class="col-md-4"><div class="label">Region</div><div class="value">{{ $vendor->regionname }}</div></div>
        <div class="col-md-4"><div class="label">City</div><div class="value">{{ $vendor->cityname }}</div></div>
        <div class="col-md-12">
            <div class="label">Registered Address</div>
            <div class="value">{!! nl2br(e($vendor->registered_address)) !!}</div>
        </div>
    </div>
</div>

{{-- ================= COMPANY & ENTITY DETAILS ================= --}}
<div class="profile-card">
    <div class="section-title">Company Details</div>
    <div class="row g-3">
        <div class="col-md-4"><div class="label">Company Name</div><div class="value">{{ $vendor->company_name }}</div></div>

        <div class="col-md-4"><div class="label">Entity Type</div><div class="value">{{ $vendor->entity_type_name }}</div></div>
        <div class="col-md-4"><div class="label">GST Number</div><div class="value">{{ $vendor->gst_number ?? '-' }}</div></div>
        <div class="col-md-4"><div class="label">MSME Registered</div><div class="value">{{ ucfirst($vendor->msme_registered) }}</div></div>
    </div>
</div>

{{-- ================= COMPLIANCE ================= --}}
<div class="profile-card">
    <div class="section-title">Compliance</div>
    <div class="row g-3">
        <div class="col-md-4"><div class="label">PAN</div><div class="value">{{ $vendor->pan_number }}</div></div>
        <div class="col-md-4"><div class="label">TAN</div><div class="value">{{ $vendor->tan_number }}</div></div>
        <div class="col-md-4"><div class="label">PF Code</div><div class="value">{{ $vendor->pf_code }}</div></div>
        <div class="col-md-4"><div class="label">ESIC</div><div class="value">{{ $vendor->esic_number }}</div></div>
    </div>
</div>

{{-- ================= BANK DETAILS ================= --}}
<div class="profile-card">
    <div class="section-title">Bank Details</div>
    <div class="row g-3">
        <div class="col-md-4"><div class="label">Bank Name</div><div class="value">{{ $vendor->bank_name }}</div></div>
        <div class="col-md-4"><div class="label">Account Number</div><div class="value">{{ $vendor->account_number }}</div></div>
        <div class="col-md-4"><div class="label">IFSC</div><div class="value">{{ $vendor->ifsc_code }}</div></div>
        <div class="col-md-4"><div class="label">Account Type</div><div class="value">{{ $vendor->atname }}</div></div>
    </div>
</div>

{{-- ================= AGREEMENT DETAILS ================= --}}
<div class="profile-card">
    <div class="section-title">Agreement Details</div>
    <div class="row g-3">
        <div class="col-md-4"><div class="label">Accepted At</div><div class="value">{{ $vendor->agreement_accepted_at }}</div></div>
        <div class="col-md-4"><div class="label">IP Address</div><div class="value">{{ $vendor->agreement_ip }}</div></div>
        <div class="col-md-4"><div class="label">Browser</div><div class="value">{{ $vendor->agreement_browser }}</div></div>
        <div class="col-md-4"><div class="label">Device</div><div class="value">{{ $vendor->agreement_device_type }}</div></div>
    </div>
</div>

{{-- ================= DOCUMENTS ================= --}}
<div class="profile-card">
    <div class="section-title">Documents</div>
    <div class="row g-3">
        @foreach([
            'pan_card_file' => 'PAN Card',
            'gst_certificate_file' => 'GST Certificate',
            'aadhaar_card_file' => 'Aadhaar Card',
            'certificate_of_incorporation_file' => 'Company Profile',
            'cancelled_cheque_file' => 'Cancelled Cheque',
            'pf_documents_file' => 'PF Document',
            'esic_documents_file' => 'ESIC Document'
        ] as $field => $label)
            @if(!empty($vendor->$field))
                <div class="col-md-4">
                    <a href="{{ asset('storage/'.$vendor->$field) }}" target="_blank">
                        {{ $label }}
                    </a>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- ================= WORK PHOTOS ================= --}}
@if($vendor->work_completion_certificates_file1 || $vendor->work_completion_certificates_file2)
<div class="profile-card">
    <div class="section-title">Work Completion Photos</div>
    <div class="row g-3">
        @foreach(['work_completion_certificates_file1','work_completion_certificates_file2'] as $photo)
            @if($vendor->$photo)
            <div class="col-md-4">
                <img src="{{ asset('storage/'.$vendor->$photo) }}"
                     class="img-fluid rounded border"
                     style="height:200px;object-fit:cover;width:100%;">
            </div>
            @endif
        @endforeach
    </div>
</div>
@endif

{{-- ================= COMPANY LOGO ================= --}}
@if($vendor->company_logo)
<div class="profile-card">
    <div class="section-title">Company Logo</div>
    <img src="{{ asset('storage/'.$vendor->company_logo) }}"
         style="max-height:120px;">
</div>
@endif

{{-- ================= DESCRIPTION ================= --}}
<div class="profile-card">
    <div class="section-title">Vendor Description</div>

    @if($vendor->description)
        <div class="mb-3">
            {!! nl2br(e($vendor->description)) !!}
        </div>
    @endif

    <form action="{{ route('admin.vendor.updateDescription', $vendor->id) }}" method="POST">
        @csrf
        <textarea name="description" class="form-control mb-3" rows="4">{{ old('description', $vendor->description) }}</textarea>
        <button class="btn btn-primary">Update Description</button>
    </form>
</div>

@endsection
