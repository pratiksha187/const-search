@extends('layouts.adminapp')

@section('title','Vendor Details')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="fw-bold mb-3">{{ strtoupper($vendor->name) }}</h4>

            <div class="row g-3 small">

                <div class="col-md-6">
                    <strong>Business Name:</strong> {{ $vendor->business_name }}
                </div>

                <div class="col-md-6">
                    <strong>Mobile:</strong> {{ $vendor->mobile }}
                </div>

                <div class="col-md-6">
                    <strong>Email:</strong> {{ $vendor->email }}
                </div>

                <div class="col-md-6">
                    <strong>Work Type:</strong> {{ $vendor->work_type_name  }}
                </div>

                <div class="col-md-6">
                    <strong>Experience:</strong> {{ $vendor->experience_years }} years
                </div>

                <div class="col-md-6">
                    <strong>Status:</strong>
                    <span class="badge {{ $vendor->status === 'verified' ? 'bg-success' : 'bg-warning text-dark' }}">
                        {{ ucfirst($vendor->status) }}
                    </span>
                </div>

                <div class="col-md-6">
                    <strong>Joined On:</strong>
                    {{ \Carbon\Carbon::parse($vendor->created_at)->format('d M Y, h:i A') }}
                </div>

            </div>

            <a href="{{ route('admin.vendors.index') }}"
               class="btn btn-secondary mt-4">
                ← Back
            </a>

        </div>
    </div>

</div>
@endsection
