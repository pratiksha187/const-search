@extends('layouts.adminapp')

@section('title','All Vendors')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">All Vendors</h4>

        <div>
            <button class="btn btn-outline-success btn-sm" id="exportExcel">
                <i class="bi bi-file-earmark-excel"></i> Excel
            </button>
            <button class="btn btn-outline-danger btn-sm" id="exportPdf">
                <i class="bi bi-file-earmark-pdf"></i> PDF
            </button>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <table id="vendorsTable" class="table table-bordered table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Vendor Name</th>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Category</th>
                        <th>Agreement Accepted</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($vendors as $index => $vendor)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td><strong>{{ strtoupper($vendor->name) }}</strong></td>

                            <td>{{ $vendor->business_name ?? '—' }}</td>

                            <td>
                                {{ $vendor->mobile }}<br>
                                <small class="text-muted">{{ $vendor->email }}</small>
                            </td>

                            <td>{{ $vendor->work_type_name ?? '—' }}</td>
                            <td> @if(!empty($vendor->agreement_accepted_at))
                                    <span class="badge bg-success mt-1">
                                        ✅ Agreement Accepted
                                    </span>
                                @endif</td>
 
                            <td>
                              

                                 @if($vendor->requerd_documnet_approve == '1')
                                    <span class="badge bg-success">Verified</span>
                                @elseif($vendor->requerd_documnet_approve == '2')

                                    <span class="badge bg-danger text-dark">Reject</span>
                                @else
                                <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            {{-- ACTION DROPDOWN --}}
                           <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                        Action
                                    </button>

                                    <ul class="dropdown-menu">

                                        {{-- View --}}
                                        <li>
                                            <a class="dropdown-item"
                                            href="{{ route('admin.vendorsapproved', $vendor->id) }}">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </li>

                                        <li>
                                            <form method="POST"
                                                action="{{ route('vendors.destroy', $vendor->id) }}"
                                                class="deleteVendorForm">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </li>


                                        {{-- Pending only --}}
                                        @if($vendor->requerd_documnet_approve != 1 && $vendor->requerd_documnet_approve != 2)

                                            <li>
                                                <form method="POST"
                                                    action="{{ route('admin.vendors.status', $vendor->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approve">
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="bi bi-check-circle"></i> Approve
                                                    </button>
                                                </form>
                                            </li>

                                            <li>
                                                <form method="POST"
                                                    action="{{ route('admin.vendors.status', $vendor->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="reject">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-x-circle"></i> Reject
                                                    </button>
                                                </form>
                                            </li>

                                        {{-- Already approved --}}
                                        @elseif($vendor->requerd_documnet_approve == 1)
                                            <li>
                                                <span class="dropdown-item text-success fw-semibold">
                                                    <i class="bi bi-check-circle"></i> Approved
                                                </span>
                                            </li>

                                        {{-- Already rejected --}}
                                        @elseif($vendor->requerd_documnet_approve == 2)
                                            <li>
                                                <span class="dropdown-item text-danger fw-semibold">
                                                    <i class="bi bi-x-circle"></i> Rejected
                                                </span>
                                            </li>
                                        @endif

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

{{-- DATATABLE CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
$(function () {
    let table = $('#vendorsTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excelHtml5', className: 'd-none', exportOptions: { columns: ':not(:last-child)' }},
            { extend: 'pdfHtml5', className: 'd-none', exportOptions: { columns: ':not(:last-child)' }}
        ]
    });

    $('#exportExcel').click(() => table.button('.buttons-excel').trigger());
    $('#exportPdf').click(() => table.button('.buttons-pdf').trigger());
});


$.ajax({
    url: '/vendors/' + id,
    type: 'DELETE',   // 🔥 VERY IMPORTANT
    data: {
        _token: '{{ csrf_token() }}'
    },
    success: function(response){
        location.reload();
    }
});

</script>

@endsection
