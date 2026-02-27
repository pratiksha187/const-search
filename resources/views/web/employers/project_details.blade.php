@extends('layouts.employerapp')

@section('content')

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
                        {{ $project->client_name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <strong>Client Mobile</strong>
                    <div class="text-muted">
                        {{ $project->client_mobile ?? '-' }}
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

        <form action="{{ route('employer.projects.sendSelectedMail') }}" method="POST">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0">
                    Matched Vendors ({{ $vendors->count() }})
                </h5>

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
                            <th>Lead Balance</th>
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
                                    {{ $vendor->email }}
                                </div>
                            </td>

                            <td>
                                {{ $vendor->contact_person_name ?? $vendor->name ?? '-' }}
                                <div class="small text-muted">
                                    {{ $vendor->mobile }}
                                </div>
                            </td>

                            <td>
                                {{ $vendor->experience_years ?? 0 }} Years
                            </td>

                            <td>
                                {{ $vendor->team_size ?? '-' }}
                            </td>

                            <td>
                                {{ $vendor->lead_balance ?? 0 }}
                            </td>

                            <td>
                                <span class="badge 
                                    @if($vendor->status == 'approved') bg-success
                                    @elseif($vendor->status == 'pending') bg-warning text-dark
                                    @else bg-secondary
                                    @endif">
                                    {{ ucfirst($vendor->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
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
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.vendorCheckbox');
    checkboxes.forEach(cb => cb.checked = this.checked);
});
</script>
@endsection