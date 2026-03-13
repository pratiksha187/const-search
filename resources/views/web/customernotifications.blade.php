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
<!-- @foreach($notifications as $note)

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

@endforeach -->

@foreach($notifications as $note)
<div class="modal fade" id="viewModal{{ $note->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Vendor Full Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="row g-3">

                    {{-- Basic Details --}}
                    <div class="col-12">
                        <h6 class="border-bottom pb-2 mb-3">Basic Details</h6>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Vendor ID</label>
                        <div>{{ $note->vendor_reg_id ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Vendor UID</label>
                        <div>{{ $note->vendor_uid ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Vendor Name</label>
                        <div>{{ $note->name ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Mobile</label>
                        <div>{{ $note->mobile ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Email</label>
                        <div>{{ $note->email ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Status</label>
                        <div>{{ $note->vendor_status ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Business Name</label>
                        <div>{{ $note->business_name ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Company Name</label>
                        <div>{{ $note->company_name ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Entity Type</label>
                        <div>{{ $note->entity_type ?? '—' }}</div>
                    </div>

                    <div class="col-md-12">
                        <label class="fw-bold text-muted small">Remarks</label>
                        <div>{{ $note->remarks ?? '—' }}</div>
                    </div>

                    {{-- Work Details --}}
                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2 mb-3">Work Details</h6>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Work Type ID</label>
                        <div>{{ $note->work_type_id ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Work Subtype ID</label>
                        <div>{{ $note->work_subtype_id ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Primary Type</label>
                        <div>{{ $note->primary_type ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Experience Years</label>
                        <div>{{ $note->experience_years ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Years in Business</label>
                        <div>{{ $note->years_in_business ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Team Size</label>
                        <div>{{ $note->team_size ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Min Project Value</label>
                        <div>{{ $note->min_project_value ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Minimum Order Cost</label>
                        <div>{{ $note->minimum_order_cost ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Description</label>
                        <div>{{ $note->description ?? '—' }}</div>
                    </div>

                    {{-- Location Details --}}
                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2 mb-3">Location Details</h6>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">State</label>
                        <div>{{ $note->state ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Region</label>
                        <div>{{ $note->region ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">City</label>
                        <div>{{ $note->city ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Registered Address</label>
                        <div>{{ $note->registered_address ?? '—' }}</div>
                    </div>

                    {{-- Compliance Details --}}
                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2 mb-3">Compliance Details</h6>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">GST Number</label>
                        <div>{{ $note->gst_number ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">PAN Number</label>
                        <div>{{ $note->pan_number ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">TAN Number</label>
                        <div>{{ $note->tan_number ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Aadhar Card No</label>
                        <div>{{ $note->aadhar_card_no ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">CIN No</label>
                        <div>{{ $note->cin_no ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">LPIN No</label>
                        <div>{{ $note->lpin_no ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Partnership Deed No</label>
                        <div>{{ $note->partnershipdeed_no ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">ESIC Number</label>
                        <div>{{ $note->esic_number ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">PF Code</label>
                        <div>{{ $note->pf_code ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">MSME Registered</label>
                        <div>{{ $note->msme_registered ?? '—' }}</div>
                    </div>

                    {{-- Contact Person --}}
                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2 mb-3">Contact Person</h6>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold text-muted small">Contact Person Name</label>
                        <div>{{ $note->contact_person_name ?? '—' }}</div>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold text-muted small">Contact Person Designation</label>
                        <div>{{ $note->contact_person_designation ?? '—' }}</div>
                    </div>

                    {{-- Banking Details --}}
                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2 mb-3">Banking Details</h6>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Bank Name</label>
                        <div>{{ $note->bank_name ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Account Number</label>
                        <div>{{ $note->account_number ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">IFSC Code</label>
                        <div>{{ $note->ifsc_code ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Account Type</label>
                        <div>{{ $note->account_type ?? '—' }}</div>
                    </div>

                    {{-- Delivery / Credit --}}
                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2 mb-3">Delivery / Credit Details</h6>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Credit Days</label>
                        <div>{{ $note->credit_days ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Delivery Type</label>
                        <div>{{ $note->delivery_type ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Delivery Days</label>
                        <div>{{ $note->delivery_days ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Lead Balance</label>
                        <div>{{ $note->lead_balance ?? '0' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Open Time</label>
                        <div>{{ $note->open_time ?? '—' }}</div>
                    </div>

                    <div class="col-md-3">
                        <label class="fw-bold text-muted small">Close Time</label>
                        <div>{{ $note->close_time ?? '—' }}</div>
                    </div>

                    {{-- Agreement Details --}}
                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2 mb-3">Agreement Details</h6>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Agreement Accepted At</label>
                        <div>{{ $note->agreement_accepted_at ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Agreement Version</label>
                        <div>{{ $note->agreement_version ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Agreement IP</label>
                        <div>{{ $note->agreement_ip ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Agreement Device Type</label>
                        <div>{{ $note->agreement_device_type ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Agreement Browser</label>
                        <div>{{ $note->agreement_browser ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Vendor Reg Person</label>
                        <div>{{ $note->vendor_reg_person ?? '—' }}</div>
                    </div>

                    <div class="col-md-12">
                        <label class="fw-bold text-muted small">Agreement User Agent</label>
                        <div style="word-break: break-word;">{{ $note->agreement_user_agent ?? '—' }}</div>
                    </div>

                    {{-- Files --}}
                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2 mb-3">Uploaded Files</h6>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">MSME File</label>
                        <div>
                            @if(!empty($note->msme_file))
                                <a href="{{ asset('storage/' . $note->msme_file) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Cancelled Cheque</label>
                        <div>
                            @if(!empty($note->cancelled_cheque_file))
                                <a href="{{ asset('storage/' . $note->cancelled_cheque_file) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">PAN Card File</label>
                        <div>
                            @if(!empty($note->pan_card_file))
                                <a href="{{ asset('storage/' . $note->pan_card_file) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">GST Certificate</label>
                        <div>
                            @if(!empty($note->gst_certificate_file))
                                <a href="{{ asset('storage/' . $note->gst_certificate_file) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Aadhaar Card File</label>
                        <div>
                            @if(!empty($note->aadhaar_card_file))
                                <a href="{{ asset('storage/' . $note->aadhaar_card_file) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Certificate of Incorporation</label>
                        <div>
                            @if(!empty($note->certificate_of_incorporation_file))
                                <a href="{{ asset('storage/' . $note->certificate_of_incorporation_file) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Work Completion Certificate 1</label>
                        <div>
                            @if(!empty($note->work_completion_certificates_file1))
                                <a href="{{ asset('storage/' . $note->work_completion_certificates_file1) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Work Completion Certificate 2</label>
                        <div>
                            @if(!empty($note->work_completion_certificates_file2))
                                <a href="{{ asset('storage/' . $note->work_completion_certificates_file2) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Work Completion Certificate 3</label>
                        <div>
                            @if(!empty($note->work_completion_certificates_file3))
                                <a href="{{ asset('storage/' . $note->work_completion_certificates_file3) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">PF Documents</label>
                        <div>
                            @if(!empty($note->pf_documents_file))
                                <a href="{{ asset('storage/' . $note->pf_documents_file) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">ESIC Documents</label>
                        <div>
                            @if(!empty($note->esic_documents_file))
                                <a href="{{ asset('storage/' . $note->esic_documents_file) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Company Logo</label>
                        <div>
                            @if(!empty($note->company_logo))
                                <a href="{{ asset('storage/' . $note->company_logo) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold text-muted small">ConstructKaro Agreement File</label>
                        <div>
                            @if(!empty($note->custntructkaro_agreement_file))
                                <a href="{{ asset('storage/' . $note->custntructkaro_agreement_file) }}" target="_blank">View File</a>
                            @else
                                —
                            @endif
                        </div>
                    </div>

                    {{-- Meta --}}
                    <div class="col-12 mt-3">
                        <h6 class="border-bottom pb-2 mb-3">Meta</h6>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Required Document Approve</label>
                        <div>{{ $note->requerd_documnet_approve ?? '0' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Vendor Created At</label>
                        <div>{{ $note->vendor_created_at ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Vendor Updated At</label>
                        <div>{{ $note->vendor_updated_at ?? '—' }}</div>
                    </div>

                    <div class="col-md-4">
                        <label class="fw-bold text-muted small">Credit Expiry At</label>
                        <div>{{ $note->credit_expiry_at ?? '—' }}</div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
