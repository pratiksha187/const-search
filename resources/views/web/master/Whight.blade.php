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

            {{-- ✅ Search Bar (Client-side) --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text"
                           id="whightSearch"
                           class="form-control"
                           placeholder="Search whight name...">
                </div>
            </div>

            <table class="table table-bordered table-hover align-middle" id="whightTable">
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
                        <td class="whight-text">{{ $Whight->name }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editWhightModal{{ $Whight->id }}">
                                Edit
                            </button>

                            <a href="{{ route('whight.delete',$Whight->id) }}"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this Whight?')">
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
@foreach($Whights as $Whight)
<div class="modal fade" id="editWhightModal{{ $Whight->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('whight.update',$Whight->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Whight</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name"
                           class="form-control"
                           value="{{ $Whight->name }}" required>
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
<div class="modal fade" id="addWhightModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('whight.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Whight</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" class="form-control"
                           placeholder="Enter Whight (Kg, Sq Ft, Piece...)" required>
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
document.getElementById('whightSearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();

    document.querySelectorAll('#whightTable tbody tr').forEach(function(row){
        const text = row.querySelector('.whight-text')?.innerText.toLowerCase() || '';
        row.style.display = text.includes(value) ? '' : 'none';
    });
});
</script>

@endsection
