@extends('layouts.adminapp')
@section('title','State Master')

@section('content')
<div class="container mt-4">

    <h4 class="mb-3">State Master</h4>

    {{-- ADD STATE --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('states.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">State Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Add State</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- STATE LIST --}}
    <div class="card">
        <div class="card-body">

            {{-- ✅ Search Bar --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text"
                           id="stateSearch"
                           class="form-control"
                           placeholder="Search state name...">
                </div>
            </div>

            <table class="table table-bordered align-middle" id="stateTable">
                <thead>
                    <tr>
                        <th width="80">#</th>
                        <th>State Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($states as $state)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="state-text">{{ $state->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

{{-- ✅ Search JS --}}
<script>
document.getElementById('stateSearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();

    document.querySelectorAll('#stateTable tbody tr').forEach(function(row){
        const text = row.querySelector('.state-text')?.innerText.toLowerCase() || '';
        row.style.display = text.includes(value) ? '' : 'none';
    });
});
</script>
@endsection
