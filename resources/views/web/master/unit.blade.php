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

            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Unit Name</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($units as $key => $unit)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $unit->unitname }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editUnit{{ $unit->id }}">
                                Edit
                            </button>

                            <a href="{{ route('unit.delete',$unit->id) }}"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this unit?')">
                               Delete
                            </a>
                        </td>
                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editUnit{{ $unit->id }}">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('unit.update',$unit->id) }}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Unit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="unitname"
                                               class="form-control"
                                               value="{{ $unit->unitname }}" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

<!-- ADD MODAL -->
<div class="modal fade" id="addUnitModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('unit.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="unitname" class="form-control"
                           placeholder="Enter unit (Kg, Sq Ft, Piece...)" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
