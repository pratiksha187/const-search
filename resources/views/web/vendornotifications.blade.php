@extends('layouts.vendorapp')

@section('title','Notifications')

@section('content')
<div class="container">

    <h4 class="mb-4 fw-bold">Customer Interest Notifications</h4>

    @forelse($notifications as $note)
        <div class="card mb-3 shadow-sm border-0">
            <div class="card-body d-flex justify-content-between align-items-start">

                {{-- LEFT INFO --}}
                <div>
                    <h6 class="fw-bold mb-1">
                        {{ $note->customer_name  }}
                    </h6>

                    <p class="mb-1 text-muted small">
                        <i class="bi bi-telephone-fill me-1"></i>
                        {{ $note->mobile }}
                    </p>

                    <p class="mb-1 text-muted small">
                        <i class="bi bi-envelope-fill me-1"></i>
                        {{ $note->email }}
                    </p>

                    <small class="text-secondary">
                        <i class="bi bi-clock me-1"></i>
                        {{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}
                    </small>
                </div>

                {{-- RIGHT ACTION --}}
                <div class="text-end">

                    {{-- STATUS BADGE --}}
                    @if($note->action_status === 'accepted')
                        <span class="badge bg-success mb-2">Accepted</span>
                    @elseif($note->action_status === 'rejected')
                        <span class="badge bg-danger mb-2">Rejected</span>
                    @else
                        <span class="badge bg-warning text-dark mb-2">Pending</span>
                    @endif

                    {{-- ACTION DROPDOWN --}}
                    @if($note->action_status === 'pending')
                        <div class="dropdown">
                            <button class="btn btn-outline-primary btn-sm dropdown-toggle"
                                data-bs-toggle="dropdown">
                                Take Action
                            </button>

                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item text-success"
                                       href="#"
                                       onclick="handleAction({{ $note->id }}, 'accepted')">
                                       ✅ Accept
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger"
                                       href="#"
                                       onclick="handleAction({{ $note->id }}, 'rejected')">
                                       ❌ Reject
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    @empty
        <div class="text-center text-muted mt-5">
            No notifications found
        </div>
    @endforelse

</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function handleAction(notificationId, action) {

    Swal.fire({
        title: action === 'accepted' ? 'Accept Vendor?' : 'Reject Vendor?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes',
    }).then((result) => {

        if (!result.isConfirmed) return;

        fetch("{{ route('customer.notification.action') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                notification_id: notificationId,
                action: action
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Done', 'Action updated successfully', 'success')
                    .then(() => location.reload());
            }
        });
    });
}
</script>
