@extends('layouts.adminapp')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Interested / Talk Requests</h5>

            {{-- 🔎 Search --}}
            <form method="GET" class="d-flex">
                <input type="text" name="search" 
                       class="form-control form-control-sm me-2" 
                       placeholder="Search vendor..." 
                       value="{{ request('search') }}">
                <button class="btn btn-light btn-sm">Search</button>
            </form>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Vendor</th>
                            <th>Company</th>
                            <th>Contact</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Lead Balance</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($requests as $index => $row)
                        <tr>
                            <td>{{ $requests->firstItem() + $index }}</td>

                            <td>
                                <strong>{{ $row->name }}</strong><br>
                                <small class="text-muted">{{ $row->email }}</small>
                            </td>

                            <td>
                                {{ $row->company_name ?? $row->business_name }}
                            </td>

                            <td>
                                {{ $row->mobile }}
                            </td>

                            <td>
                                {{ $row->message }} <br>
                                <small class="text-muted">
                                    Call: {{ $row->call_time ?? '—' }}
                                </small>
                            </td>

                            <td>
                                @if($row->status == 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($row->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge bg-info">
                                    {{ $row->lead_balance }}
                                </span>
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($row->created_at)->format('d M Y h:i A') }}
                            </td>

                            <td>
                                <form method="POST" action="{{ route('admin.talk.status.update') }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $row->id }}">

                                    <select name="status" 
                                            class="form-select form-select-sm"
                                            onchange="this.form.submit()">

                                        <option value="pending" {{ $row->status=='pending'?'selected':'' }}>Pending</option>
                                        <option value="approved" {{ $row->status=='approved'?'selected':'' }}>Approve</option>
                                        <option value="rejected" {{ $row->status=='rejected'?'selected':'' }}>Reject</option>
                                    </select>
                                </form>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted">
                                No requests found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- ✅ Pagination --}}
            <div class="mt-3">
                {{ $requests->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
