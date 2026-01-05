@extends('layouts.adminapp')

@section('title','Thickness / Size Master')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Thickness / Size Master</h5>
            <button class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#addSizeModal">
                + Add Size
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
                        <th>Thickness / Size</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sizes as $key => $size)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $size->thickness_size }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editSize{{ $size->id }}">
                                Edit
                            </button>

                            <a href="{{ route('thickness.size.delete',$size->id) }}"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this size?')">
                               Delete
                            </a>
                        </td>
                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editSize{{ $size->id }}">
                        <div class="modal-dialog">
                            <form method="POST"
                                  action="{{ route('thickness.size.update',$size->id) }}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Thickness / Size</h5>
                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text"
                                               name="thickness_size"
                                               class="form-control"
                                               value="{{ $size->thickness_size }}"
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
<div class="modal fade" id="addSizeModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('thickness.size.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Thickness / Size</h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text"
                           name="thickness_size"
                           class="form-control"
                           placeholder="Ex: 0.35–0.50 mm, 6–12 mm"
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
