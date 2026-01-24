@extends('layouts.adminapp')

@section('title','All Supplier')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">All Supplier</h4>

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

            <table id="SupplierTable" class="table table-bordered table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Supplier Name</th>
                        <th>Shop Addesss</th>
                        <th>Contact</th>
                        
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($supplier as $index => $sup)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td><strong>{{ strtoupper($sup->shop_name) }}</strong></td>

                            <td>{{ $sup->shop_address ?? '—' }}</td>

                            <td>
                                {{ $sup->mobile }}<br>
                                <small class="text-muted">{{ $sup->email }}</small>
                            </td>

                           
                            <td>
                              

                                 @if($sup->status == '1')
                                    <span class="badge bg-success">Verified</span>
                                @elseif($sup->status == '2')

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
                                        <!-- <li>
                                            <a class="dropdown-item"
                                            href="{{ route('admin.supplierapproved', $sup->id) }}">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                        </li> -->

                                        {{-- Pending only --}}
                                        @if($sup->status != 1 && $sup->status != 2)

                                            <li>
                                                <form method="POST"
                                                    action="{{ route('admin.supplier.status', $sup->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="approve">
                                                    <button type="submit" class="dropdown-item text-success">
                                                        <i class="bi bi-check-circle"></i> Approve
                                                    </button>
                                                </form>
                                            </li>

                                            <li>
                                                <form method="POST"
                                                    action="{{ route('admin.supplier.status', $sup->id) }}">
                                                    @csrf
                                                    <input type="hidden" name="status" value="reject">
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-x-circle"></i> Reject
                                                    </button>
                                                </form>
                                            </li>

                                        {{-- Already approved --}}
                                        @elseif($sup->status == 1)
                                            <li>
                                                <span class="dropdown-item text-success fw-semibold">
                                                    <i class="bi bi-check-circle"></i> Approved
                                                </span>
                                            </li>

                                        {{-- Already rejected --}}
                                        @elseif($sup->status == 2)
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
    let table = $('#SupplierTable').DataTable({
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
</script>
@endsection
