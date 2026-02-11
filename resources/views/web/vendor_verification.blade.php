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
                    <th>Document Status</th>
                    <th>Vendor Status</th>
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

                        {{-- Document Status --}}
                        <td>
                            @if($vendor->requerd_documnet_approve == 1)
                                <span class="badge bg-success">Approved</span>
                            @elseif($vendor->requerd_documnet_approve == 2)
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>

                        {{-- Vendor Status --}}
                        <td>
                            @if($vendor->status == 'approved')
                                <span class="badge bg-primary">Active</span>
                            @else
                                <span class="badge bg-secondary">Not Approved</span>
                            @endif
                        </td>

                        {{-- ACTION --}}
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                    Action
                                </button>

                                <ul class="dropdown-menu">
                                    <li> <a class="dropdown-item" href="{{ route('admin.vendorsapproved', $vendor->id) }}"> <i class="bi bi-eye"></i> View </a> </li>
                                    {{-- Accept Document --}}
                                    @if($vendor->requerd_documnet_approve != 1)
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

                                    {{-- Accept Vendor --}}
                                    @if($vendor->requerd_documnet_approve == 1 && $vendor->status != 'approved')
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

                                    {{-- Delete --}}
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


{{-- DOCUMENT MODAL --}}
<div class="modal fade" id="acceptDocumentModal" tabindex="-1">
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
                    Approve this vendor's documents?
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-success">
                        Approve
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>


{{-- VENDOR MODAL --}}
<div class="modal fade" id="acceptVendorModal" tabindex="-1">
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
                    Approve this vendor for platform access?
                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Approve Vendor
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

    // Activate DataTable
    $('#vendorsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        responsive: true,
        ordering: true,
        searching: true,
        paging: true,
        info: true,
        language: {
            search: "Search Vendor:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ vendors"
        }
    });

    // Document route
    $('#acceptDocumentModal').on('show.bs.modal', function (event) {
        let vendorId = $(event.relatedTarget).data('id');
        $('#acceptDocumentForm')
            .attr('action', '/admin/vendors/document-approve/' + vendorId);
    });

    // Vendor route
    $('#acceptVendorModal').on('show.bs.modal', function (event) {
        let vendorId = $(event.relatedTarget).data('id');
        $('#acceptVendorForm')
            .attr('action', '/admin/vendors/vendor-approve/' + vendorId);
    });

    // SweetAlert Delete
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

</script>
<script>
$(function () {

    // Set document route
    $('#acceptDocumentModal').on('show.bs.modal', function (event) {
        let vendorId = $(event.relatedTarget).data('id');
        $('#acceptDocumentForm')
            .attr('action', '/admin/vendors/document-approve/' + vendorId);
    });

    // Set vendor route
    $('#acceptVendorModal').on('show.bs.modal', function (event) {
        let vendorId = $(event.relatedTarget).data('id');
        $('#acceptVendorForm')
            .attr('action', '/admin/vendors/vendor-approve/' + vendorId);
    });

    // SweetAlert Delete
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
</script>

@endsection
