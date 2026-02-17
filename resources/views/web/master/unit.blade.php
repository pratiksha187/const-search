@extends('layouts.adminapp')

@section('title','Unit Master')

@section('content')
<div class="container-fluid mt-4">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Unit Master</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUnitModal">
                + Add Unit
            </button>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- ✅ Search Bar (no controller change) --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="unitSearch" class="form-control" placeholder="Search unit name...">
                </div>
            </div>

            <table class="table table-bordered table-hover align-middle" id="unitTable">
                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Unit Name</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($units as $key => $unit)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="unit-name">{{ $unit->unitname }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editUnitModal{{ $unit->id }}">
                                Edit
                            </button>

                            <a href="{{ route('unit.delete',$unit->id) }}"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this unit?')">
                               Delete
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">No units found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

{{-- ✅ EDIT MODALS (outside table) --}}
@foreach($units as $unit)
<div class="modal fade" id="editUnitModal{{ $unit->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('unit.update',$unit->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text"
                           name="unitname"
                           class="form-control"
                           value="{{ $unit->unitname }}"
                           required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach

{{-- ✅ ADD MODAL --}}
<div class="modal fade" id="addUnitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('unit.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text"
                           name="unitname"
                           class="form-control"
                           placeholder="Enter unit (Kg, Sq Ft, Piece...)"
                           required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ✅ Simple Search JS (client-side) --}}
<script>
document.getElementById('unitSearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();
    document.querySelectorAll('#unitTable tbody tr').forEach(function(row){
        const name = row.querySelector('.unit-name')?.innerText.toLowerCase() || '';
        row.style.display = name.includes(value) ? '' : 'none';
    });
});
</script>
@endsection
