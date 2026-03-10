@extends('layouts.adminapp')
@section('title','Employers List')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4 class="mb-0">Employers Register</h4>
        <a href="{{ route('admin.employers.index') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i> Add Employer
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="row mb-3">
                <div class="col-md-4 ms-auto">
                    <input type="text" id="empSearch" class="form-control form-control-sm"
                           placeholder="Search name / company / email...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="empTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Employer</th>
                            <th>Company</th>
                            <th>Contact</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reg_employee as $i => $emp)
                            <tr>
                                <td>{{ $i + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $emp->full_name }}</div>
                                    <div class="text-muted small">{{ $emp->role_in_org ?? '-' }}</div>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $emp->company_name }}</div>
                                    <div class="text-muted small">
                                        {{ $emp->organization_type ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="small">
                                        <i class="bi bi-telephone me-1"></i>{{ $emp->contact_details ?? '-' }}
                                    </div>
                                </td>

                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewEmployerModal{{ $emp->id }}">
                                        <i class="bi bi-eye me-1"></i> View
                                    </button>
                                </td>
                            </tr>

                            {{-- View Modal --}}
                            <div class="modal fade" id="viewEmployerModal{{ $emp->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content border-0 shadow">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Employer Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="row g-3">

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Full Name</label>
                                                    <div class="fw-semibold">{{ $emp->full_name ?? '-' }}</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Company Name</label>
                                                    <div class="fw-semibold">{{ $emp->company_name ?? '-' }}</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Role In Organization</label>
                                                    <div>{{ $emp->role_in_org ?? '-' }}</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Organization Type</label>
                                                    <div>{{ $emp->organization_type ?? '-' }}</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Project Size</label>
                                                    <div>{{ $emp->project_size ?? '-' }}</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Contact Details</label>
                                                    <div>{{ $emp->contact_details ?? '-' }}</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Looking For</label>
                                                    <div>
                                                        @php
                                                            $lookingFor = [];
                                                            if (!empty($emp->looking_for)) {
                                                                $decoded = json_decode($emp->looking_for, true);
                                                                $lookingFor = is_array($decoded) ? $decoded : [$emp->looking_for];
                                                            }
                                                        @endphp

                                                        @if(!empty($lookingFor))
                                                            {{ implode(', ', $lookingFor) }}
                                                        @else
                                                            -
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Current Challenge</label>
                                                    <div>{{ $emp->current_challenge ?? '-' }}</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Interest Level</label>
                                                    <div>{{ $emp->interest_level ?? '-' }}</div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Created At</label>
                                                    <div>
                                                        {{ !empty($emp->created_at) ? \Carbon\Carbon::parse($emp->created_at)->format('d M Y h:i A') : '-' }}
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="text-muted small">Updated At</label>
                                                    <div>
                                                        {{ !empty($emp->updated_at) ? \Carbon\Carbon::parse($emp->updated_at)->format('d M Y h:i A') : '-' }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    No employers found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('empSearch');
    const table = document.getElementById('empTable');

    input.addEventListener('keyup', function () {
        const filter = input.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
});
</script>
@endsection