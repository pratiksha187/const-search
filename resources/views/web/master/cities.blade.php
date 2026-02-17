@extends('layouts.adminapp')
@section('title','City Master')

@section('content')
<div class="container mt-4">

    <h4 class="mb-3">City Master</h4>

    {{-- ADD CITY --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('cities.store') }}">
                @csrf
                <div class="row">

                    <div class="col-md-3">
                        <label class="form-label">State</label>
                        <select id="state" class="form-select" required>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Region</label>
                        <select name="region_id" id="region" class="form-select" required>
                            <option value="">Select Region</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">City Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Add City</button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- CITY LIST --}}
    <div class="card">
        <div class="card-body">

            {{-- ✅ Search Bar --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text"
                           id="citySearch"
                           class="form-control"
                           placeholder="Search state / region / city...">
                </div>
            </div>

            <table class="table table-bordered align-middle" id="cityTable">
                <thead>
                    <tr>
                        <th width="80">#</th>
                        <th>State</th>
                        <th>Region</th>
                        <th>City</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cities as $city)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="state-text">{{ $city->state_name }}</td>
                            <td class="region-text">{{ $city->region_name }}</td>
                            <td class="city-text">{{ $city->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

{{-- CASCADING JS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
/* ✅ Cascading: State -> Regions */
$('#state').change(function () {
    let stateId = $(this).val();
    if (!stateId) {
        $('#region').html('<option value="">Select Region</option>');
        return;
    }

    $('#region').html('<option value="">Loading...</option>');

    $.get("{{ route('regions.byState', ':id') }}".replace(':id', stateId), function (data) {
        let html = '<option value="">Select Region</option>';
        data.forEach(function (r) {
            html += `<option value="${r.id}">${r.name}</option>`;
        });
        $('#region').html(html);
    });
});

/* ✅ Search Filter (State/Region/City) */
document.getElementById('citySearch').addEventListener('keyup', function () {
    const value = this.value.toLowerCase();

    document.querySelectorAll('#cityTable tbody tr').forEach(function(row){
        const state  = row.querySelector('.state-text')?.innerText.toLowerCase() || '';
        const region = row.querySelector('.region-text')?.innerText.toLowerCase() || '';
        const city   = row.querySelector('.city-text')?.innerText.toLowerCase() || '';

        row.style.display = (state.includes(value) || region.includes(value) || city.includes(value)) ? '' : 'none';
    });
});
</script>

@endsection
