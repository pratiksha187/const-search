@extends('layouts.vendorapp')

@section('title', 'All Notifications')

@section('content')

<div class="container">

    <h3 class="fw-bold mb-3">All Notifications</h3>

    @forelse($notifications as $note)
        <div class="card mb-3" style="border-radius: 12px;">
            <div class="card-body">
                <h5 class="fw-bold">{{ $note->title }}</h5>
                <p class="text-muted">{{ $note->message }}</p>
                <small class="text-secondary">
                    {{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}
                </small>
            </div>
        </div>
    @empty
        <p class="text-muted">No notifications available.</p>
    @endforelse

</div>

@endsection
