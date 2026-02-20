@extends('layouts.adminapp')
@section('title','Employers List')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4 class="mb-0">Employers</h4>
        <a href="{{ route('admin.employers.create') }}" class="btn btn-primary btn-sm">
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
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employers as $i => $emp)
                            <tr>
                                <td>{{ $i+1 }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $emp->name }}</div>
                                    <div class="text-muted small">{{ $emp->email }}</div>
                                </td>

                                <td>
                                    <div class="fw-semibold">{{ $emp->company_name }}</div>
                                    <div class="text-muted small">{{ $emp->city ?? '-' }}, {{ $emp->state ?? '-' }}</div>
                                </td>

                                <td>
                                    <div class="small"><i class="bi bi-telephone me-1"></i>{{ $emp->mobile ?? '-' }}</div>
                                    <div class="small text-muted"><i class="bi bi-envelope me-1"></i>{{ $emp->company_email ?? '-' }}</div>
                                </td>

                                <td>
                                    @if($emp->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>

                                <td class="text-end">
                                    {{-- Toggle --}}
                                    <form action="{{ route('admin.employers.toggle', $emp->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-outline-dark btn-sm" type="submit">
                                            <i class="bi bi-arrow-repeat"></i>
                                            {{ $emp->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>

                                    {{-- Delete --}}
                                    <form action="{{ route('admin.employers.destroy', $emp->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this employer?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm" type="submit">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
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

{{-- Simple search (no DataTables needed) --}}
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
