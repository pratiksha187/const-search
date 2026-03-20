@extends('layouts.adminapp')

@section('title','All Supplier')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h4 class="fw-bold mb-0">All Supplier</h4>

        <div class="d-flex gap-2">
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

            <div class="row mb-3 g-3">
                <div class="col-md-4">
                    <label for="materialCategoryFilter" class="form-label fw-semibold">Filter by Material Category</label>
                    <select id="materialCategoryFilter" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($materialCategories as $category)
                            <option value="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="statusFilter" class="form-label fw-semibold">Filter by Status</label>
                    <select id="statusFilter" class="form-select">
                        <option value="">All Status</option>
                        <option value="Verified">Verified</option>
                        <option value="Pending">Pending</option>
                        <option value="Reject">Reject</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="resetFilters" class="btn btn-outline-secondary w-100">
                        Reset Filters
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="SupplierTable" class="table table-bordered table-hover align-middle w-100">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Supplier Name</th>
                            <th>Material Category</th>
                            <th>Shop Address</th>
                            <th>Contact</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($supplier as $index => $sup)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <strong>{{ strtoupper($sup->shop_name ?? '—') }}</strong>
                                </td>

                                <td data-category="{{ strtolower($sup->material_category_names ?? '') }}">
    {{ $sup->material_category_names ?? '—' }}
</td>

                                <td>{{ $sup->shop_address ?? '—' }}</td>

                                <td>
                                    {{ $sup->mobile ?? '—' }}<br>
                                    <small class="text-muted">{{ $sup->email ?? '—' }}</small>
                                </td>

                                <td>
                                    @if($sup->status == '1')
                                        <span class="badge bg-success">Verified</span>
                                    @elseif($sup->status == '2')
                                        <span class="badge bg-danger">Reject</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Action
                                        </button>

                                        <ul class="dropdown-menu">
                                            @if($sup->status != 1 && $sup->status != 2)
                                                <li>
                                                    <form method="POST" action="{{ route('admin.supplier.status', $sup->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="status" value="approve">
                                                        <button type="submit" class="dropdown-item text-success">
                                                            <i class="bi bi-check-circle"></i> Approve
                                                        </button>
                                                    </form>
                                                </li>

                                                <li>
                                                    <form method="POST" action="{{ route('admin.supplier.status', $sup->id) }}">
                                                        @csrf
                                                        <input type="hidden" name="status" value="reject">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bi bi-x-circle"></i> Reject
                                                        </button>
                                                    </form>
                                                </li>
                                            @elseif($sup->status == 1)
                                                <li>
                                                    <span class="dropdown-item text-success fw-semibold">
                                                        <i class="bi bi-check-circle"></i> Approved
                                                    </span>
                                                </li>
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
</div>

{{-- DATATABLE CSS --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

{{-- JQUERY + DATATABLE --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

{{-- EXPORT BUTTONS --}}
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
$(document).ready(function () {
    let materialCategoryValue = '';
    let statusValue = '';

    let table = $('#SupplierTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        responsive: true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                className: 'd-none',
                title: 'All Supplier',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdfHtml5',
                className: 'd-none',
                title: 'All Supplier',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }
        ]
    });

    $('#exportExcel').on('click', function () {
        table.button('.buttons-excel').trigger();
    });

    $('#exportPdf').on('click', function () {
        table.button('.buttons-pdf').trigger();
    });

    $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
        if (settings.nTable.id !== 'SupplierTable') {
            return true;
        }

        let rowNode = table.row(dataIndex).node();
        let categoryText = ($(rowNode).find('td:eq(2)').attr('data-category') || '').toLowerCase();
        let statusText   = ($(rowNode).find('td:eq(5)').attr('data-status') || '').toLowerCase();

        let categoryMatch = true;
        let statusMatch = true;

        if (materialCategoryValue !== '') {
            categoryMatch = categoryText.includes(materialCategoryValue);
        }

        if (statusValue !== '') {
            statusMatch = statusText === statusValue;
        }

        return categoryMatch && statusMatch;
    });

    $('#materialCategoryFilter').on('change', function () {
        materialCategoryValue = ($(this).val() || '').toLowerCase();
        table.draw();
    });

    $('#statusFilter').on('change', function () {
        statusValue = ($(this).val() || '').toLowerCase();
        table.draw();
    });

    $('#resetFilters').on('click', function () {
        $('#materialCategoryFilter').val('');
        $('#statusFilter').val('');
        materialCategoryValue = '';
        statusValue = '';
        table.search('').draw();
    });
});
</script>
@endsection