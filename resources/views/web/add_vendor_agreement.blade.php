@extends('layouts.adminapp')

@section('title','Add Vendor Agreement')

@section('content')

<style>

.page-wrapper{
    background:#f1f5f9;
    padding:40px 0;
}

.agreement-card{
    max-width:900px;
    margin:auto;
    background:#ffffff;
    padding:35px;
    border-radius:18px;
    box-shadow:0 20px 50px rgba(15,23,42,.08);
}

.page-title{
    font-size:22px;
    font-weight:700;
    margin-bottom:25px;
    color:#0f172a;
}

/* Vendor Summary */
.vendor-box{
    background:#f8fafc;
    border-radius:14px;
    padding:18px;
    margin-bottom:25px;
    border:1px solid #e2e8f0;
}

.vendor-name{
    font-weight:700;
    font-size:16px;
    margin-bottom:4px;
}

.vendor-info{
    font-size:14px;
    color:#64748b;
}

/* Form */
.form-label{
    font-weight:600;
    font-size:14px;
}

.form-control{
    border-radius:10px;
    padding:10px 14px;
}

.submit-btn{
    padding:10px 22px;
    border-radius:10px;
    font-weight:600;
}

</style>

<div class="page-wrapper">

    <div class="agreement-card">

        <div class="page-title">
            Add Agreement for Vendor
        </div>

        {{-- Vendor Summary --}}
        <div class="vendor-box">
            <div class="vendor-name">
                {{ strtoupper($vendor->company_name ?? $vendor->name) }}
            </div>

            <div class="vendor-info">
                <i class="bi bi-person me-1"></i>
                {{ $vendor->name }}
            </div>

            <div class="vendor-info">
                <i class="bi bi-telephone me-1"></i>
                {{ $vendor->mobile }}
            </div>

            <div class="vendor-info">
                <i class="bi bi-envelope me-1"></i>
                {{ $vendor->email }}
            </div>
        </div>

        {{-- Agreement Form --}}
        <form method="POST" 
              action="{{ route('admin.vendor.agreement.store', $vendor->id) }}" 
              enctype="multipart/form-data">
            @csrf

            
            <div class="mb-3">
                <label class="form-label">Upload Agreement (PDF)</label>
                <input type="file" 
                       name="agreement_file" 
                       class="form-control"
                       accept="application/pdf"
                       required>
            </div>

            <div class="mb-3">
                <label class="form-label">Admin Remarks (Optional)</label>
                <textarea name="remarks"
                          class="form-control"
                          rows="3"
                          placeholder="Any internal note..."></textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary submit-btn">
                    Save Agreement
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
