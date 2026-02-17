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

            {{-- ✅ Search Bar (Client-side) --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text"
                           id="gradeSearch"
                           class="form-control"
                           placeholder="Search grade name...">
                </div>
            </div>

            <table class="table table-bordered table-hover align-middle" id="gradeTable">
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
                        <td class="grade-text">{{ $grade->grade_name }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editGradeModal{{ $grade->id }}">
                                Edit
                            </button>

                            <a href="{{ route('grade.delete',$grade->id) }}"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this grade?')">
                               Delete
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>

{{-- ✅ EDIT MODALS (outside table for clean HTML) --}}
@foreach($grades as $grade)
<div class="modal fade" id="editGradeModal{{ $grade->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('grade.update',$grade->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text"
                           name="grade_name"
                           class="form-control"
                           value="{{ $grade->grade_name }}"
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

<!-- ADD MODAL -->
<div class="modal fade" id="addGradeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('grade.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Grade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text"
                           name="grade_name"
                           class="form-control"
                           placeholder="Ex: Fe 500, IS 2062, ASTM A36"
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

{{-- ✅ Search JS --}}
<script>
document.getElementById('gradeSearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();

    document.querySelectorAll('#gradeTable tbody tr').forEach(function(row){
        const text = row.querySelector('.grade-text')?.innerText.toLowerCase() || '';
        row.style.display = text.includes(value) ? '' : 'none';
    });
});
</script>

@endsection
