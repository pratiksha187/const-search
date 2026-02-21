@extends('layouts.adminapp')

@section('title','All Vendors')

@section('content')

<link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<div class="container-fluid mt-4">

    <h4 class="fw-bold mb-4">Vendor Management</h4>

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">

            <table id="vendorsTable"
                   class="table table-striped table-hover align-middle w-100">

                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Vendor</th>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Vendor Status</th>
                    <th>Document Status</th>
                    <th>Documents Uploaded</th>
                    <th>Vendor Added By</th>
                    <th>Profile %</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @foreach($vendors as $index => $vendor)
                    <tr>

                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ strtoupper($vendor->name) }}</strong></td>
                        <td>{{ $vendor->business_name ?? '—' }}</td>
                        <td>{{ $vendor->mobile }}</td>

                        {{-- Vendor Status --}}
                        <td>
                            @if($vendor->status == 'approved')
                                <span class="badge bg-primary">Approved</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>

                        {{-- Document Status --}}
                        <td>
                            @if($vendor->status != 'approved')
                                <span class="badge bg-secondary">
                                    Waiting Vendor Approval
                                </span>
                            @elseif($vendor->requerd_documnet_approve == 1)
                                <span class="badge bg-success">Approved</span>
                            @elseif($vendor->requerd_documnet_approve == 2)
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        {{-- Documents Uploaded (NEW COLUMN) --}}
                        <td>

                        @php
                            $documents = [
                                $vendor->aadhaar_card_file,
                                $vendor->pan_card_file,
                                $vendor->certificate_of_incorporation_file,
                                $vendor->work_completion_certificates_file1,
                                $vendor->work_completion_certificates_file2,
                                $vendor->work_completion_certificates_file3,
                            ];

                            $totalDocs = count($documents);

                            $uploadedDocs = collect($documents)
                                ->filter(function ($doc) {
                                    return !empty($doc) && !str_contains($doc, 'tmp');
                                })
                                ->count();
                        @endphp

                        @if($uploadedDocs == $totalDocs)
                            <span class="badge bg-success">
                                Complete ({{ $uploadedDocs }}/{{ $totalDocs }})
                            </span>

                        @elseif($uploadedDocs > 0)
                            <span class="badge bg-warning text-dark">
                                Partial ({{ $uploadedDocs }}/{{ $totalDocs }})
                            </span>

                        @else
                            <span class="badge bg-danger">
                                Missing (0/{{ $totalDocs }})
                            </span>
                        @endif

                        </td>
                        <td>
                            <select class="form-select form-select-sm vendor-type-select"
                                    data-id="{{ $vendor->id }}">
                                <option value="">Select</option>
                                <option value="D" {{ $vendor->vendor_reg_person  == 'D' ? 'selected' : '' }}>D</option>
                                <option value="S" {{ $vendor->vendor_reg_person  == 'S' ? 'selected' : '' }}>S</option>
                            </select>
                        </td>

                        <td>
                            @php
                                $percent = $vendor->profile_percent ?? 0;
                            @endphp

                            <div class="progress" style="height: 18px;">
                                <div class="progress-bar 
                                    {{ $percent >= 80 ? 'bg-success' : ($percent >= 40 ? 'bg-warning' : 'bg-danger') }}"
                                    role="progressbar"
                                    style="width: {{ $percent }}%;">
                                    {{ $percent }}%
                                </div>
                            </div>
                        </td>
                        {{-- ACTION --}}
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                    Action
                                </button>

                                <ul class="dropdown-menu">

                                    <li>
                                        <a class="dropdown-item"
                                           href="{{ route('admin.vendorsapproved', $vendor->id) }}">
                                            View
                                        </a>
                                    </li>

                                    {{-- 1️⃣ FIRST: Vendor Approve --}}
                                    @if($vendor->status != 'approved')
                                        <li>
                                            <button type="button"
                                                    class="dropdown-item text-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#acceptVendorModal"
                                                    data-id="{{ $vendor->id }}">
                                                Accept Vendor
                                            </button>
                                        </li>
                                    @endif

                                    {{-- 2️⃣ THEN: Document Approve --}}
                                    @if($vendor->status == 'approved' && $vendor->requerd_documnet_approve != 1)
                                        <li>
                                            <button type="button"
                                                    class="dropdown-item text-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#acceptDocumentModal"
                                                    data-id="{{ $vendor->id }}">
                                                Accept Document
                                            </button>
                                        </li>
                                    @endif

                                    <li>
                                        <form method="POST"
                                              action="{{ route('vendors.destroy', $vendor->id) }}"
                                              class="deleteVendorForm">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="dropdown-item text-danger">
                                                Delete
                                            </button>
                                        </form>
                                    </li>

                                </ul>
                            </div>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>


{{-- Vendor Modal --}}
<div class="modal fade" id="acceptVendorModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="acceptVendorForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Approve Vendor</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Approve this vendor?
                </div>
                <div class="modal-footer">
                    <button type="submit"
                            class="btn btn-primary">
                        Approve Vendor
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Document Modal --}}
<div class="modal fade" id="acceptDocumentModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="acceptDocumentForm" method="POST">
                @csrf
                <input type="hidden" name="status" value="approve">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Document</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Approve vendor documents?
                </div>
                <div class="modal-footer">
                    <button type="submit"
                            class="btn btn-success">
                        Approve Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(function () {

    $('#vendorsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        responsive: true
    });

    $('#acceptVendorModal').on('show.bs.modal', function (event) {
        let id = $(event.relatedTarget).data('id');
        $('#acceptVendorForm')
            .attr('action', '/admin/vendors/vendor-approve/' + id);
    });

    $('#acceptDocumentModal').on('show.bs.modal', function (event) {
        let id = $(event.relatedTarget).data('id');
        $('#acceptDocumentForm')
            .attr('action', '/admin/vendors/document-approve/' + id);
    });

    $(document).on('submit', '.deleteVendorForm', function(e) {
        e.preventDefault();
        let form = this;

        Swal.fire({
            title: 'Delete Vendor?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Delete'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

});


$(document).on('change', '.vendor-type-select', function() {

    let vendorId = $(this).data('id');
    let vendor_reg_person = $(this).val();

    $.ajax({
        url: "{{ route('admin.vendor.addedby') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            vendor_id: vendorId,
            vendor_reg_person: vendor_reg_person
        },
        success: function(response) {
            if(response.status){
                Swal.fire({
                    icon: 'success',
                    title: 'Updated!',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        }
    });

});
</script>

@endsection
