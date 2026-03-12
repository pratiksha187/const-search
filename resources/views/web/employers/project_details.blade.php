@extends('layouts.employerapp')

@section('content')
@if(session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Success</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill text-success" style="font-size:48px;"></i>
                    </div>
                    <h5 class="fw-bold mb-2">Email Sent Successfully</h5>
                    <p class="text-muted mb-0">{{ session('success') }}</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
@endif
<div class="container mt-4">

    {{-- ================= PROJECT HEADER ================= --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-start flex-wrap">

                <div>
                    <h4 class="fw-bold mb-2">
                        {{ $project->name ?? 'Project Name' }}
                    </h4>

                    <span class="badge bg-light text-dark border me-2">
                        {{ $project->code ?? '-' }}
                    </span>

                    @php
                        $statusClass = match($project->status) {
                            'Planning' => 'bg-secondary',
                            'Active' => 'bg-warning text-dark',
                            'Completed' => 'bg-success',
                            'Cancelled' => 'bg-danger',
                            default => 'bg-dark'
                        };
                    @endphp

                    <span class="badge {{ $statusClass }}">
                        {{ $project->status ?? '-' }}
                    </span>
                </div>

                <div class="text-end">
                    <h5 class="fw-bold text-primary mb-0">
                        ₹{{ number_format($project->estimated_budget ?? 0, 2) }}
                    </h5>
                    <small class="text-muted">Estimated Budget</small>
                </div>

            </div>

        </div>
    </div>

    {{-- ================= PROJECT DETAILS ================= --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <strong>Vendor Type</strong>
                    <div class="text-muted">
                        {{ $project->type_name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Location</strong>
                    <div class="text-muted">
                        {{ $project->city_name ?? '-' }},
                        {{ $project->regionname ?? '' }}
                        {{ $project->statename ? ', '.$project->statename : '' }}
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Timeline</strong>
                    <div class="text-muted">
                        {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d M Y') : '-' }}
                        to
                        {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d M Y') : '-' }}
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Client Name</strong>
                    <div class="text-muted">
                        {{ $project->contact_name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Client Mobile</strong>
                    <div class="text-muted">
                        {{ $project->mobile ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Budget Range</strong>
                    <div class="text-muted">
                        {{ $project->budget_range ?? '-' }}
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- ================= MATCHED VENDORS ================= --}}
    <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-body">

            {{-- Search Bar --}}
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="fw-bold mb-0">
                    Matched Vendors ({{ $vendors->total() }})
                </h5>

                <form method="GET" action="" class="d-flex gap-2">
                    <input type="text"
                           name="search"
                           class="form-control form-control-sm"
                           placeholder="Search company / contact / email / mobile"
                           value="{{ request('search') }}"
                           style="min-width:260px;">

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-search"></i> Search
                    </button>

                    @if(request('search'))
                        <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Mail Form --}}
            <form action="{{ route('employer.projects.sendSelectedMail') }}" method="POST">
                @csrf
                <input type="hidden" name="project_id" value="{{ $project->id }}">

                <div class="d-flex justify-content-end mb-3">
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="bi bi-envelope-fill"></i>
                        Send Email to Selected
                    </button>
                </div>

                @if($vendors->count() > 0)

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="40">
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th>Company</th>
                                    <th>Contact</th>
                                    <th>Experience</th>
                                    <th>Team</th>
                                    <!-- <th>Lead Balance</th> -->
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($vendors as $vendor)
                                <tr>
                                    <td>
                                        <input type="checkbox"
                                               name="vendor_ids[]"
                                               value="{{ $vendor->id }}"
                                               class="vendorCheckbox">
                                    </td>

                                    <td>
                                        <strong>{{ $vendor->business_name ?? '-' }}</strong>
                                        <div class="small text-muted">
                                            {{ $vendor->email ?? '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ $vendor->contact_person_name ?? $vendor->name ?? '-' }}
                                        <div class="small text-muted">
                                            {{ $vendor->mobile ?? '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ $vendor->experience_year_name ?? 0 }} Years
                                    </td>

                                    <td>
                                        {{ $vendor->team_size_name ?? '-' }}
                                    </td>
                                    <td>
                                        <span class="badge
                                            @if($vendor->status == 'approved') bg-success
                                            @elseif($vendor->status == 'pending') bg-warning text-dark
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($vendor->status ?? 'unknown') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap gap-2">
                        <div class="text-muted small">
                            Showing {{ $vendors->firstItem() }} to {{ $vendors->lastItem() }} of {{ $vendors->total() }} vendors
                        </div>

                        <div>
                            {{ $vendors->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                @else
                    <div class="text-center text-muted py-4">
                        No Matching Vendors Found
                    </div>
                @endif
            </form>

        </div>
    </div>

</div>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.vendorCheckbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('selectAll');
    if (selectAll) {
        selectAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.vendorCheckbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    }

    @if(session('success'))
        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    @endif
});
</script>
@endsection