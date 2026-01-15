@extends('layouts.adminapp')
@section('title','Region Master')

@section('content')
<div class="container mt-4">

    <h4 class="mb-3">Region Master</h4>

    {{-- ADD REGION --}}
    <div class="card mb-4">
        <div class="card-body">
            <form method="POST" action="{{ route('regions.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <select name="state_id" class="form-select" required>
                            <option value="">Select State</option>
                            @foreach($states as $state)
                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Region Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">Add Region</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- REGION LIST --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>State</th>
                        <th>Region</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($regions as $region)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $region->state_name }}</td>
                            <td>{{ $region->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
