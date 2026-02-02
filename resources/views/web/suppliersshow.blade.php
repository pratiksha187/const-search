@extends('layouts.adminapp')

@section('title','Vendor Details')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="fw-bold mb-3">{{ strtoupper($supplier->contact_person) }}</h4>

            <div class="row g-3 small">

                <div class="col-md-6">
                    <strong>Business Name:</strong> {{ $supplier->shop_name }}
                </div>

                <div class="col-md-6">
                    <strong>Mobile:</strong> {{ $supplier->mobile }}
                </div>

                <div class="col-md-6">
                    <strong>Email:</strong> {{ $supplier->email }}
                </div>

                
                <div class="col-md-6">
                    <strong>Experience:</strong> {{ $supplier->experiance_year }} years
                </div>

                

                <div class="col-md-6">
                    <strong>Joined On:</strong>
                    {{ \Carbon\Carbon::parse($supplier->created_at)->format('d M Y, h:i A') }}
                </div>

            </div>

            <a href="{{ route('admin.suppliers.index') }}"
               class="btn btn-secondary mt-4">
                ← Back
            </a>

        </div>
    </div>

</div>
@endsection
