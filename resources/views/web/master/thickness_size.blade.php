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

            {{-- ✅ Search Bar (client-side) --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text"
                           id="sizeSearch"
                           class="form-control"
                           placeholder="Search thickness / size...">
                </div>
            </div>

            <table class="table table-bordered table-hover align-middle" id="sizeTable">
                <thead class="table-light">
                    <tr>
                        <th width="60">#</th>
                        <th>Thickness / Size</th>
                        <th width="160">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sizes as $key => $size)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="size-text">{{ $size->thickness_size }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#editSizeModal{{ $size->id }}">
                                Edit
                            </button>

                            <a href="{{ route('thickness.size.delete',$size->id) }}"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Delete this size?')">
                               Delete
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">No records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</div>

{{-- ✅ EDIT MODALS (outside table) --}}
@foreach($sizes as $size)
<div class="modal fade" id="editSizeModal{{ $size->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('thickness.size.update',$size->id) }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Thickness / Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text"
                           name="thickness_size"
                           class="form-control"
                           value="{{ $size->thickness_size }}"
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
<div class="modal fade" id="addSizeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('thickness.size.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Thickness / Size</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="text"
                           name="thickness_size"
                           class="form-control"
                           placeholder="Ex: 0.35–0.50 mm, 6–12 mm"
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

{{-- ✅ Search JS (client-side filter) --}}
<script>
document.getElementById('sizeSearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();

    document.querySelectorAll('#sizeTable tbody tr').forEach(function(row){
        const text = row.querySelector('.size-text')?.innerText.toLowerCase() || '';
        row.style.display = text.includes(value) ? '' : 'none';
    });
});
</script>

@endsection
