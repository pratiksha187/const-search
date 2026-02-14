@extends('layouts.vendorapp')

@section('title','Lead History')

@section('content')

<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --bg:#f5f7fb;
}

body{
    background:var(--bg);
}

/* PAGE HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.page-header h4{
    font-weight:800;
    color:var(--navy);
}

/* SUMMARY CARDS */
.summary-card{
    background:#fff;
    border-radius:14px;
    padding:18px;
    box-shadow:0 6px 18px rgba(0,0,0,.05);
    transition:.2s;
}

.summary-card:hover{
    transform:translateY(-3px);
}

.summary-title{
    font-size:13px;
    color:#6b7280;
}

.summary-value{
    font-size:22px;
    font-weight:800;
}

/* TABLE CARD */
.table-card{
    background:#fff;
    border-radius:16px;
    box-shadow:0 8px 25px rgba(0,0,0,.06);
    overflow:hidden;
}

/* TABLE */
.table thead{
    background:#f9fafb;
}

.table th{
    font-weight:700;
    font-size:14px;
    color:#374151;
}

.table td{
    font-size:14px;
}

/* BADGES */
.badge-soft-success{
    background:#ecfdf5;
    color:#047857;
}

.badge-soft-warning{
    background:#fff7ed;
    color:#c2410c;
}

.badge-soft-danger{
    background:#fef2f2;
    color:#b91c1c;
}

.badge-soft-secondary{
    background:#f3f4f6;
    color:#374151;
}

/* SEARCH */
.search-box input{
    border-radius:10px;
}
</style>

<div class="container-fluid mt-4">

    <!-- HEADER -->
    <div class="page-header">
        <h4>Lead History</h4>

        <form method="GET" class="d-flex search-box">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control me-2"
                   placeholder="Search by customer or status">
            <button class="btn btn-dark px-4">Search</button>
        </form>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="summary-card">
                <div class="summary-title">Total Leads</div>
                <div class="summary-value text-dark">
                    {{ $leads->total() }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card">
                <div class="summary-title">Accepted</div>
                <div class="summary-value text-success">
                    {{ $leads->where('action_status','accepted')->count() }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card">
                <div class="summary-title">Pending</div>
                <div class="summary-value text-warning">
                    {{ $leads->where('action_status','pending')->count() }}
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="summary-card">
                <div class="summary-title">Unread</div>
                <div class="summary-value text-danger">
                    {{ $leads->where('is_read',0)->count() }}
                </div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-card">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Vendor</th>
                        <th>Status</th>
                        <th>Read</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($leads as $index => $lead)
                    <tr>
                        <td>{{ $leads->firstItem() + $index }}</td>

                        <td>
                            <strong>{{ $lead->customer_name }}</strong>
                        </td>

                        <td>{{ $lead->vendor_name ?? '—' }}</td>

                        <td>
                            @if($lead->action_status === 'accepted')
                                <span class="badge badge-soft-success px-3 py-2">
                                    Accepted
                                </span>
                            @elseif($lead->action_status === 'pending')
                                <span class="badge badge-soft-warning px-3 py-2">
                                    Pending
                                </span>
                            @else
                                <span class="badge badge-soft-secondary px-3 py-2">
                                    {{ ucfirst($lead->action_status) }}
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($lead->is_read)
                                <span class="badge badge-soft-success px-3 py-2">
                                    Read
                                </span>
                            @else
                                <span class="badge badge-soft-danger px-3 py-2">
                                    Unread
                                </span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-5">
                            No lead history found
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4 d-flex justify-content-end">
        {{ $leads->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection
