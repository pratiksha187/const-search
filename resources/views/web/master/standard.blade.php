@extends('layouts.adminapp')

@section('title','Standard Master')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Standard Master</h5>
            <button class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#addStandardModal">
                + Add Standard
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
                        <th>Standard Name</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($standards as $key => $standard)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $standard->standard_name }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editStandard{{ $standard->id }}">
                                Edit
                            </button>

                            <a href="{{ route('standard.delete',$standard->id) }}"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this standard?')">
                               Delete
                            </a>
                        </td>
                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editStandard{{ $standard->id }}">
                        <div class="modal-dialog">
                            <form method="POST"
                                  action="{{ route('standard.update',$standard->id) }}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Standard</h5>
                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text"
                                               name="standard_name"
                                               class="form-control"
                                               value="{{ $standard->standard_name }}"
                                               required>
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
<div class="modal fade" id="addStandardModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('standard.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Standard</h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text"
                           name="standard_name"
                           class="form-control"
                           placeholder="Ex: IS 2062, ASTM A36, EN 10025"
                           required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
