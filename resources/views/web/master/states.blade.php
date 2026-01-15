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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>State Name</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($states as $state)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $state->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
