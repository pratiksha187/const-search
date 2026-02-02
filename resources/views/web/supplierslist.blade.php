@extends('layouts.adminapp')

@section('title','All Suppliers list')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold mb-0">All Suppliers</h4>

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

            <table id="supTable" class="table table-bordered table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Supplier Name</th>
                        <th>Company</th>
                        <th>Contact</th>   
                        <th>Status</th>
                        <th>Joined On</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($supplierslist as $index => $suppliers)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td>
                                <strong>{{ strtoupper($suppliers->contact_person) }}</strong>
                            </td>

                            <td>
                                {{ $suppliers->shop_name ?? '—' }}
                            </td>

                            <td>
                                {{ $suppliers->mobile }}<br>
                                <small class="text-muted">{{ $suppliers->email }}</small>
                            </td>

                          

                            <td>
                                @if($suppliers->status === 'verified')
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($suppliers->created_at)->format('d M Y') }}
                            </td>

                            <td>
                                <a href="{{ route('admin.suppliers.show', $suppliers->id) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    View
                                </a>
                                <button class="btn btn-sm btn-outline-danger ms-1 deleteSupplier"
                                    data-id="{{ $suppliers->id }}">
                                    Delete
                                </button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>
</div>

{{-- ================= DATATABLE CSS ================= --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

{{-- ================= SCRIPTS ================= --}}
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

    let table = $('#supTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        responsive: true,
        ordering: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Suppliers',
                className: 'd-none',
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: 'pdfHtml5',
                title: 'Suppliers',
                orientation: 'landscape',
                pageSize: 'A4',
                className: 'd-none',
                exportOptions: { columns: ':not(:last-child)' }
            }
        ]
    });

    $('#exportExcel').click(() => table.button('.buttons-excel').trigger());
    $('#exportPdf').click(() => table.button('.buttons-pdf').trigger());
});
</script>
<script>
$(document).on('click', '.deleteSupplier', function () {

    let btn = $(this);
    let supplierId = btn.data('id');
    let table = $('#supTable').DataTable();

    if (!confirm('Are you sure you want to delete this supplier?')) return;

    $.ajax({
        url: "{{ url('admin/suppliers') }}/" + supplierId,
        type: 'DELETE',
        data: {
            _token: "{{ csrf_token() }}"
        },
        success: function (res) {
            if (res.status) {
                // remove row smoothly
                table
                    .row(btn.closest('tr'))
                    .remove()
                    .draw();

                alert(res.message);
            }
        },
        error: function () {
            alert('Something went wrong!');
        }
    });
});
</script>

@endsection
