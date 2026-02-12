@extends('layouts.adminapp')

@section('title','Vendor Agreement Management')

@section('content')

<link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<style>
.page-wrapper{
    background:#f1f5f9;
    padding:40px 0;
}

.main-card{
    max-width:1200px;
    margin:auto;
    background:#ffffff;
    padding:30px;
    border-radius:18px;
    box-shadow:0 20px 50px rgba(15,23,42,.08);
}

.page-title{
    font-size:22px;
    font-weight:700;
    margin-bottom:25px;
    color:#0f172a;
}

.table thead{
    background:#f8fafc;
}

.table th{
    font-size:13px;
    text-transform:uppercase;
    color:#64748b;
    font-weight:600;
}

.status-pill{
    font-size:12px;
    font-weight:600;
    padding:6px 14px;
    border-radius:20px;
}

.status-accepted{
    background:#dcfce7;
    color:#166534;
}

.status-not{
    background:#fee2e2;
    color:#991b1b;
}

.action-btn{
    font-size:13px;
    padding:6px 12px;
    border-radius:8px;
}

.dataTables_wrapper .dataTables_paginate .page-link{
    border-radius:8px !important;
}
</style>

<div class="page-wrapper">

    <div class="main-card">

        <div class="page-title">
            Vendor Agreement Management
        </div>

        <div class="table-responsive">

            <table id="vendorAgreementTable"
                   class="table table-hover align-middle w-100">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Vendor</th>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Status</th>
                        <th>Agreement</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($vendors as $index => $vendor)
                    <tr>

                        <td>{{ $index + 1 }}</td>

                        <td>
                            <strong>{{ $vendor->name }}</strong><br>
                            <small class="text-muted">
                                {{ $vendor->email }}
                            </small>
                        </td>

                        <td>{{ $vendor->company_name ?? '—' }}</td>

                        <td>{{ $vendor->mobile }}</td>

                        {{-- Vendor Status --}}
                        <td>
                            @if($vendor->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>

                        {{-- Agreement Status --}}
                        <td>
                            @if($vendor->custntructkaro_agreement_file)
                                <span class="status-pill status-accepted">
                                    Agreement Added
                                </span>
                            @else
                                <span class="status-pill status-not">
                                    Not Added
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td>

                            @if($vendor->custntructkaro_agreement_file)

                                {{-- View --}}
                                <a href="{{ asset('storage/'.$vendor->custntructkaro_agreement_file) }}"
                                   target="_blank"
                                   class="btn btn-success btn-sm action-btn">
                                    <i class="bi bi-eye"></i> View
                                </a>

                                {{-- Update --}}
                                <a href="{{ route('admin.vendor.agreement', $vendor->id) }}"
                                   class="btn btn-warning btn-sm action-btn">
                                    <i class="bi bi-pencil"></i> Update
                                </a>

                            @else

                                {{-- Add --}}
                                <a href="{{ route('admin.vendor.agreement', $vendor->id) }}"
                                   class="btn btn-primary btn-sm action-btn">
                                    <i class="bi bi-plus-circle"></i> Add Agreement
                                </a>

                            @endif

                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function () {

    $('#vendorAgreementTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        responsive: true,
        ordering: true,
        columnDefs: [
            { orderable: false, targets: 6 } // Disable sorting on Action column
        ]
    });

});
</script>

@endsection
