@extends('layouts.adminapp')

@section('title','Whight Master')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Whight Master</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addWhightModal">
                + Add Whight
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
                        <th>Whight Name</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($Whights as $key => $Whight)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $Whight->name }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editWhight{{ $Whight->id }}">
                                Edit
                            </button>

                            <a href="{{ route('whight.delete',$Whight->id) }}"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this Whight?')">
                               Delete
                            </a>
                        </td>
                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editWhight{{ $Whight->id }}">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ route('whight.update',$Whight->id) }}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Whight</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text" name="name"
                                               class="form-control"
                                               value="{{ $Whight->name }}" required>
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
<div class="modal fade" id="addWhightModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('whight.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Whight</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control"
                           placeholder="Enter Whight (Kg, Sq Ft, Piece...)" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
