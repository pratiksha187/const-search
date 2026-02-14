@extends('layouts.custapp')

@section('title','Vendor Notifications')

@section('content')

<link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<style>
.page-wrapper{
    background:#f1f5f9;
    padding:40px 0;
}

.main-card{
    max-width:1428px;
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

.unread-row{
    background:#f0f9ff !important;
}

.status-pill{
    padding:6px 14px;
    border-radius:20px;
    font-size:12px;
    font-weight:600;
}

.status-pending{
    background:#fef3c7;
    color:#92400e;
}

.status-accepted{
    background:#dcfce7;
    color:#166534;
}

.status-rejected{
    background:#fee2e2;
    color:#991b1b;
}

.dataTables_wrapper .dataTables_paginate .page-link{
    border-radius:8px !important;
}
</style>

<div class="page-wrapper">
<div class="main-card">

<div class="page-title">
    Vendor Interest Notifications
</div>

<div class="table-responsive">
<table id="notificationTable" class="table table-hover align-middle">

<thead class="table-light">
<tr>
    <th>#</th>
    <th>Vendor</th>
    <th>Mobile</th>
    <th>Lead Type</th>
    <th>Credits</th>
    <th>Status</th>
    <th>Received</th>
    <th width="200">Action</th>
</tr>
</thead>

<tbody>
@foreach($notifications as $note)

<tr class="{{ $note->is_read == 0 ? 'unread-row' : '' }}">

<td>{{ $loop->iteration }}</td>

<td>
    <strong>{{ $note->vendor_name ?? $note->name }}</strong><br>
    <small class="text-muted">
        {{ $note->company_name ?? '' }}
    </small>
</td>

<td>{{ $note->mobile }}</td>

<td>
    <span class="badge bg-info text-dark">
        {{ ucfirst($note->lead_type ?? '—') }}
    </span>
</td>

<td>{{ $note->credits_used ?? 0 }}</td>

<td>
    @if($note->action_status === 'accepted')
        <span class="status-pill status-accepted">Accepted</span>
    @elseif($note->action_status === 'rejected')
        <span class="status-pill status-rejected">Rejected</span>
    @else
        <span class="status-pill status-pending">Pending</span>
    @endif
</td>

<td>{{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}</td>

<td>
<div class="d-flex gap-2">

{{-- VIEW BUTTON --}}
<button class="btn btn-outline-primary btn-sm view-btn"
        data-id="{{ $note->id }}"
        data-bs-toggle="modal"
        data-bs-target="#viewModal{{ $note->id }}">
    View
</button>

{{-- ACCEPT / REJECT --}}
@if($note->action_status === 'pending')

<button type="button"
        class="btn btn-success btn-sm action-btn"
        data-id="{{ $note->id }}"
        data-action="accepted">
    Accept
</button>

<button type="button"
        class="btn btn-outline-danger btn-sm action-btn"
        data-id="{{ $note->id }}"
        data-action="rejected">
    Reject
</button>

@endif

</div>
</td>

</tr>

@endforeach
</tbody>

</table>
</div>

</div>
</div>

{{-- ================= MODALS ================= --}}
@foreach($notifications as $note)

<div class="modal fade" id="viewModal{{ $note->id }}" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header">
    <h5 class="modal-title">Vendor Full Details</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">

<div class="row g-3">

<div class="col-md-6">
<label class="fw-bold text-muted small">Vendor Name</label>
<div>{{ $note->vendor_name ?? $note->name }}</div>
</div>

<div class="col-md-6">
<label class="fw-bold text-muted small">Company</label>
<div>{{ $note->company_name ?? '—' }}</div>
</div>

<div class="col-md-6">
<label class="fw-bold text-muted small">Mobile</label>
<div>{{ $note->mobile }}</div>
</div>

<div class="col-md-6">
<label class="fw-bold text-muted small">Email</label>
<div>{{ $note->email }}</div>
</div>

<div class="col-md-6">
<label class="fw-bold text-muted small">Location</label>
<div>{{ $note->location ?? '—' }}</div>
</div>

<div class="col-md-6">
<label class="fw-bold text-muted small">Credits Used</label>
<div>{{ $note->credits_used ?? 0 }}</div>
</div>

<div class="col-md-12">
<label class="fw-bold text-muted small">Description</label>
<div>{{ $note->description ?? 'No description' }}</div>
</div>
<!-- 
<div class="col-md-12">
<label class="fw-bold text-muted small">Agreement</label>
@if(!empty($note->custntructkaro_agreement_file))
    <a href="{{ asset('storage/'.$note->custntructkaro_agreement_file) }}"
       target="_blank"
       class="btn btn-sm btn-success">
       View Agreement
    </a>
@else
    <span class="text-danger">Not Uploaded</span>
@endif
</div> -->

</div>
</div>

<div class="modal-footer">
<button type="button"
        class="btn btn-secondary"
        data-bs-dismiss="modal">
Close
</button>
</div>

</div>
</div>
</div>

@endforeach


{{-- ================= SCRIPTS ================= --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(function () {

    // DataTable
    $('#notificationTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        responsive: true,
        order: [[0, 'desc']],
        columnDefs: [
            { orderable: false, targets: 7 }
        ]
    });

    // Accept / Reject Confirmation
    $('.action-btn').click(function(){

        let id = $(this).data('id');
        let action = $(this).data('action');

        Swal.fire({
            title: 'Are you sure?',
            text: "You want to " + action + " this vendor?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {

            if(result.isConfirmed){

                $('<form>', {
                    "method": "POST",
                    "action": "{{ route('customer.notification.action') }}"
                })
                .append('@csrf')
                .append('<input type="hidden" name="notification_id" value="'+id+'">')
                .append('<input type="hidden" name="action" value="'+action+'">')
                .appendTo('body')
                .submit();
            }
        });

    });

});
</script>

@endsection
