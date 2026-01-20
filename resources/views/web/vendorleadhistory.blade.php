@extends('layouts.vendorapp')

@section('title','Lead History')

@section('content')

<div class="container-fluid mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">Lead History</h4>

        <!-- SEARCH -->
        <form method="GET" class="d-flex">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control me-2"
                   placeholder="Search by name / status">
            <button class="btn btn-primary">Search</button>
        </form>
    </div>

    <!-- TABLE CARD -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Customer ID</th>
                        <th>Vendor Name</th>
                        <th>Status</th>
                        <th>Read</th>
                        
                    </tr>
                </thead>

                <tbody>
                @forelse($leads as $index => $lead)
                    <tr>
                        <td>{{ $leads->firstItem() + $index }}</td>

                        <td>{{ $lead->customer_name }}</td>

                        <td>
                            {{ $lead->vendor_name ?? '—' }}
                        </td>

                        <td>
                            @if($lead->action_status === 'accepted')
                                <span class="badge bg-success">Accepted</span>
                            @elseif($lead->action_status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($lead->action_status) }}</span>
                            @endif
                        </td>

                        <td>
                            @if($lead->is_read)
                                <span class="badge bg-success">Read</span>
                            @else
                                <span class="badge bg-danger">Unread</span>
                            @endif
                        </td>

                        
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No lead history found
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

    <!-- PAGINATION -->
    <div class="mt-3 d-flex justify-content-end">
        {{ $leads->links('pagination::bootstrap-5') }}
    </div>

</div>

@endsection
