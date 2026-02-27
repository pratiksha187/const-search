@extends('layouts.employerapp')

@section('title', 'Users & Roles')

@section('content')

<section class="section mt-4">

<div class="card shadow-sm border-0 rounded-4">

    {{-- Header --}}
    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
        <div>
            <h5 class="fw-bold mb-1 text-dark">Users & Roles</h5>
            <small class="text-muted">
                Charge only for <strong>Action Users</strong> — keep View-only free
            </small>
        </div>

        <button class="btn btn-primary rounded-pill px-4"
                data-bs-toggle="modal"
                data-bs-target="#addUserModal">
            <i class="bi bi-person-plus"></i> Add User
        </button>
    </div>

    {{-- Table --}}
    <div class="card-body">

        <div class="table-responsive">
            <table class="table align-middle table-hover">
                <thead class="table-light">
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Type</th>
                    <th>Billing</th>
                    <th class="text-end">Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <div class="fw-semibold">{{ $user->name }}</div>
                        <small class="text-muted">{{ $user->email }}</small>
                    </td>

                    <td>
                        <span class="badge bg-secondary-subtle text-dark px-3 py-2">
                            {{ $user->role }}
                        </span>
                    </td>

                    <td>
                        @if($user->user_type == 'action')
                            <span class="badge bg-success-subtle text-success px-3 py-2">
                                Action User
                            </span>
                        @else
                            <span class="badge bg-light text-dark px-3 py-2">
                                View Only
                            </span>
                        @endif
                    </td>

                    <td>
                        @if($user->is_paid)
                            <span class="badge bg-success px-3 py-2">
                                Paid
                            </span>
                        @else
                            <span class="badge bg-light text-dark px-3 py-2">
                                Free
                            </span>
                        @endif
                    </td>

                    <td class="text-end">
                        <form action="{{ route('employer.users.delete',$user->id) }}"
                              method="POST"
                              class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger rounded-pill">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        No users added yet.
                    </td>
                </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

</section>

{{-- Add User Modal --}}
<div class="modal fade" id="addUserModal" tabindex="-1">
<div class="modal-dialog modal-lg">
<div class="modal-content rounded-4 border-0 shadow">

    <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>

    <form action="{{ route('employer.users.store') }}" method="POST">
        @csrf

        <div class="modal-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control rounded-3" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control rounded-3" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select rounded-3">
                        <option>Admin</option>
                        <option>Procurement</option>
                        <option>Store</option>
                        <option>Viewer</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">User Type</label>
                    <select name="user_type" class="form-select rounded-3">
                        <option value="action">Action User</option>
                        <option value="view">View Only</option>
                    </select>
                </div>

            </div>
        </div>

        <div class="modal-footer border-0">
            <button type="submit" class="btn btn-primary rounded-pill px-4">
                Save User
            </button>
        </div>
    </form>

</div>
</div>
</div>

@endsection