@extends('layouts.suppliersapp')

@section('title', 'Lead Marketplace | ConstructKaro')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
    body{background:#f4f6fb}
    .page-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
    .page-title{font-size:22px;font-weight:700;color:#1c2c3e}
    .lead-card{
        background:#fff;border-radius:16px;
        box-shadow:0 10px 30px rgba(0,0,0,.08);
        padding:20px
    }
    .table thead th{
        font-size:12px;text-transform:uppercase;
        color:#64748b;background:#f8fafc;
        border-bottom:1px solid #e5e7eb;white-space:nowrap
    }
    .table tbody td{vertical-align:middle;font-size:14px}
    .customer-box strong{font-size:14px;color:#0f172a}
    .customer-box small{color:#64748b;display:block}
    .badge-status{padding:6px 12px;border-radius:20px;font-size:12px;font-weight:600}
    .badge-pending{background:#fff7ed;color:#c2410c}
    .badge-accepted{background:#ecfdf5;color:#047857}
    .badge-rejected{background:#fef2f2;color:#b91c1c}
    .action-btn{min-width:95px;margin-left:4px}
    .btn-accept{background:#16a34a;border:none}
    .btn-reject{background:#dc2626;border:none}
    .btn-quotation{background:#2563eb;border:none}
</style>

{{-- HEADER --}}
<div class="page-header">
    <div>
        <h1 class="page-title">Lead Marketplace</h1>
        <small class="text-muted">View & manage incoming material enquiries</small>
    </div>
</div>

{{-- TABLE --}}
<div class="lead-card">
    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Material</th>
                    <th>Qty</th>
                    <th>Rate</th>
                    <th>Total</th>
                    <th>Delivery</th>
                    <th>Required By</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allEnquiries as $key => $row)
                    <tr>
                        <td>{{ $key + 1 }}</td>

                        <td class="customer-box">
                            <strong>{{ $row->contact_person }}</strong>
                            <small>{{ $row->shop_name }}</small>
                            <small>{{ $row->mobile }}</small>
                        </td>

                        <td>{{ trim($row->material_categories_name) }}</td>
                        <td>{{ $row->qty }}</td>
                        <td>₹ {{ number_format($row->price) }}</td>
                        <td class="fw-bold">₹ {{ number_format($row->total) }}</td>
                        <td>{{ $row->delivery_location }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->required_by)->format('d M Y') }}</td>
                        <td class="text-capitalize">{{ $row->payment_preference }}</td>

                        <td>
                            @if($row->status === 'pending')
                                <span class="badge-status badge-pending">Pending</span>
                            @elseif($row->status === 'accepted')
                                <span class="badge-status badge-accepted">Accepted</span>
                            @else
                                <span class="badge-status badge-rejected">Rejected</span>
                            @endif
                        </td>

                        <td class="text-end">
                            @if($row->status === 'pending')
                                <button class="btn btn-sm btn-accept text-white action-btn acceptBtn"
                                    data-enquiry-id="{{ $row->enquiry_id }}"
                                    data-supplier-id="{{ $row->supplier_id }}">
                                    Accept
                                </button>

                                <button class="btn btn-sm btn-reject text-white action-btn rejectBtn"
                                    data-enquiry-id="{{ $row->enquiry_id }}"
                                    data-supplier-id="{{ $row->supplier_id }}">
                                    Reject
                                </button>

                            @elseif($row->status === 'accepted')
                                <a href="{{ route('supplier.send.quotation', $row->enquiry_id) }}"
                                   class="btn btn-sm btn-quotation text-white action-btn">
                                    Send Quotation
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center text-muted py-4">
                            No enquiries available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- JS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).on('click', '.acceptBtn', function () {
    let enquiry_id = $(this).data('enquiry-id');
    let supplier_id = $(this).data('supplier-id');

    if (!confirm('Accept this enquiry?')) return;

    $.post("{{ route('supplier.enquiry.accept') }}", {
        _token: $('meta[name="csrf-token"]').attr('content'),
        enquiry_id: enquiry_id,
        supplier_id: supplier_id
    }, function () {
        location.reload();
    });
});

$(document).on('click', '.rejectBtn', function () {
    let enquiry_id = $(this).data('enquiry-id');
    let supplier_id = $(this).data('supplier-id');

    if (!confirm('Reject this enquiry?')) return;

    $.post("{{ route('supplier.enquiry.reject') }}", {
        _token: $('meta[name="csrf-token"]').attr('content'),
        enquiry_id: enquiry_id,
        supplier_id: supplier_id
    }, function () {
        location.reload();
    });
});
</script>

@endsection
