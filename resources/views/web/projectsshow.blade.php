@extends('layouts.adminapp')

@section('title','Project Details')

@section('content')
<div class="container mt-4">

    <div class="card shadow-sm">
        <div class="card-body">

            <h4 class="fw-bold mb-3">{{ strtoupper($project->title) }}</h4>

            <div class="row g-3 small">

                <div class="col-md-6">
                    <strong>Contact Name:</strong> {{ $project->contact_name }}
                </div>

                <div class="col-md-6">
                    <strong>Mobile:</strong> {{ $project->mobile }}
                </div>

                <div class="col-md-6">
                    <strong>Email:</strong> {{ $project->email }}
                </div>

                <div class="col-md-6">
                    <strong>Work Type ID:</strong> {{ $project->work_type_id }}
                </div>

                <div class="col-md-6">
                    <strong>Location:</strong>
                    {{ $project->state }}, {{ $project->region }}, {{ $project->city }}
                </div>

                <div class="col-md-6">
                    <strong>Posted On:</strong>
                    {{ \Carbon\Carbon::parse($project->created_at)->format('d M Y, h:i A') }}
                </div>

                <div class="col-12">
                    <strong>Description:</strong>
                    <p class="mt-1">{{ $project->description }}</p>
                </div>

            </div>

            <a href="{{route('projectslist')}}"
               class="btn btn-secondary mt-4">
                ← Back
            </a>

        </div>
    </div>

</div>
@endsection
