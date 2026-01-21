@extends('layouts.adminapp')

@section('title','Free Lead Requests')

@section('content')

<div class="container-fluid">

    
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="fw-bold mb-0">Free Lead Requests</h4>

    <input type="text"
           id="tableSearch"
           class="form-control form-control-sm"
           style="max-width:300px"
           placeholder="Search vendor / mobile / platform / status">
</div>

    <!-- <table class="table table-bordered align-middle"> -->
        <table class="table table-bordered align-middle" id="freeLeadsTable">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Vendor</th>
                <th>Platform</th>
                <th>Screenshot</th>
                <th>Status</th>
                <th width="220">Action</th>
            </tr>
        </thead>
        <tbody  id="freeLeadsBody">

        @forelse($requests as $req)
            <tr>
                <td>{{ $req->id }}</td>
                <td>
                    <strong>{{ $req->company_name }}</strong><br>
                    <small>{{ $req->mobile }}</small>
                </td>
                <td class="text-capitalize">{{ $req->platform }}</td>
                <td>
                    <a href="{{ asset('storage/'.$req->screenshot) }}" target="_blank">
                        <img src="{{ asset('storage/'.$req->screenshot) }}"
                             style="height:60px;border-radius:6px;">
                    </a>
                </td>
                <td>
                    @if($req->status == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($req->status == 'approved')
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
                <td>

@if($req->status === 'pending')

    {{-- APPROVE --}}
    <form method="POST"
          action="{{ route('admin.freeleads.action', $req->id) }}"
          class="d-inline">
        @csrf
        <input type="hidden" name="action" value="approve">
        <button class="btn btn-sm btn-success">
            Approve
        </button>
    </form>

    {{-- REJECT --}}
    <form method="POST"
          action="{{ route('admin.freeleads.action', $req->id) }}"
          class="d-inline">
        @csrf
        <input type="hidden" name="action" value="reject">
        <button class="btn btn-sm btn-danger">
            Reject
        </button>
    </form>

@else
    <em class="text-muted">Action completed</em>
@endif

</td>

            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center text-muted">
                    No free lead requests found
                </td>
            </tr>
        @endforelse

        </tbody>
    </table>
<div class="d-flex justify-content-end mt-3">
    <nav>
        <ul class="pagination pagination-sm" id="pagination"></ul>
    </nav>
</div>

</div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const rowsPerPage = 10;
    const tableBody  = document.getElementById('freeLeadsBody');
    const rows       = Array.from(tableBody.querySelectorAll('tr'));
    const pagination = document.getElementById('pagination');
    const searchInput = document.getElementById('tableSearch');

    let filteredRows = [...rows];
    let currentPage = 1;

    function renderTable() {
        tableBody.innerHTML = '';

        let start = (currentPage - 1) * rowsPerPage;
        let end   = start + rowsPerPage;

        filteredRows.slice(start, end).forEach(row => {
            tableBody.appendChild(row);
        });

        renderPagination();
    }

    function renderPagination() {
        pagination.innerHTML = '';
        let pageCount = Math.ceil(filteredRows.length / rowsPerPage);

        for (let i = 1; i <= pageCount; i++) {
            let li = document.createElement('li');
            li.className = 'page-item ' + (i === currentPage ? 'active' : '');
            li.innerHTML = `<a href="#" class="page-link">${i}</a>`;
            li.addEventListener('click', function (e) {
                e.preventDefault();
                currentPage = i;
                renderTable();
            });
            pagination.appendChild(li);
        }
    }

    searchInput.addEventListener('keyup', function () {
        let term = this.value.toLowerCase();

        filteredRows = rows.filter(row =>
            row.innerText.toLowerCase().includes(term)
        );

        currentPage = 1;
        renderTable();
    });

    renderTable();
});
</script>

@endsection
