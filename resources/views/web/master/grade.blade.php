@extends('layouts.adminapp')

@section('title','Grade Master')

@section('content')

<div class="container-fluid mt-4">

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Grade Master</h5>
            <button class="btn btn-primary btn-sm"
                    data-bs-toggle="modal"
                    data-bs-target="#addGradeModal">
                + Add Grade
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
                        <th>Grade Name</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grades as $key => $grade)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $grade->grade_name }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editGrade{{ $grade->id }}">
                                Edit
                            </button>

                            <a href="{{ route('grade.delete',$grade->id) }}"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this grade?')">
                               Delete
                            </a>
                        </td>
                    </tr>

                    <!-- EDIT MODAL -->
                    <div class="modal fade" id="editGrade{{ $grade->id }}">
                        <div class="modal-dialog">
                            <form method="POST"
                                  action="{{ route('grade.update',$grade->id) }}">
                                @csrf
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>Edit Grade</h5>
                                        <button type="button"
                                                class="btn-close"
                                                data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="text"
                                               name="grade_name"
                                               class="form-control"
                                               value="{{ $grade->grade_name }}"
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
<div class="modal fade" id="addGradeModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('grade.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Add Grade</h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text"
                           name="grade_name"
                           class="form-control"
                           placeholder="Ex: Fe 500, IS 2062, ASTM A36"
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
