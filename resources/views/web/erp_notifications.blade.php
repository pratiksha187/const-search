@extends('layouts.vendorapp')

@section('title','ERP Notifications')

@section('content')

<style>
.page-wrap{
    max-width:1200px;
    margin:0 auto;
}

.page-title{
    font-weight:800;
    letter-spacing:.5px;
}

.subtext{
    color:#64748b;
    font-size:14px;
}

.card-modern{
    border-radius:16px;
    border:none;
    box-shadow:0 10px 30px rgba(0,0,0,.05);
}

.table thead th{
    font-size:13px;
    text-transform:uppercase;
    letter-spacing:.5px;
    color:#64748b;
}

.action-btn{
    font-size:12px;
    font-weight:600;
    padding:6px 12px;
}

.btn-profile{
    border:1px solid #0d6efd;
    color:#0d6efd;
}

.btn-profile:hover{
    background:#0d6efd;
    color:#fff;
}

.btn-pqc{
    border:1px solid #198754;
    color:#198754;
}

.btn-pqc:hover{
    background:#198754;
    color:#fff;
}

.btn-view{
    border:1px solid #212529;
    color:#212529;
}

.btn-view:hover{
    background:#212529;
    color:#fff;
}

.badge-soft{
    background:#fff7ed;
    border:1px solid #fed7aa;
    color:#9a3412;
    font-weight:700;
    padding:6px 12px;
    border-radius:50px;
    font-size:12px;
}
</style>

<div class="container-fluid px-4 page-wrap">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
        <div>
            <div class="d-flex align-items-center gap-3">
                <h3 class="page-title mb-0">ERP Notifications</h3>
                <span class="badge-soft">Total: {{ $notifications->count() }}</span>
            </div>
            <div class="subtext mt-1">
                Upload Company Profile & PQC to respond faster.
            </div>
        </div>

        <a href="{{ route('vendordashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    {{-- TABLE CARD --}}
    <div class="card card-modern">
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th width="220">Title</th>
                            <th>Message</th>
                            <th width="180">Date</th>
                            <th width="280" class="text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($notifications as $index => $n)
                        <tr>

                            <td class="fw-semibold">
                                {{ $index+1 }}
                            </td>

                            <td>
                                <div class="fw-bold">
                                    {{'ERP Notification' }}
                                </div>
                                <small class="text-muted">
                                    ID: {{ $n->id }}
                                </small>
                            </td>

                            <td style="max-width:450px;">
                                {{ \Illuminate\Support\Str::limit($n->message, 120) }}
                            </td>

                            <td>
                                <div class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($n->created_at)->format('d M Y') }}
                                </div>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($n->created_at)->format('h:i A') }}
                                </small>
                            </td>

                            <td class="text-center">

                                <div class="d-flex justify-content-center gap-2 flex-wrap">

                                    {{-- Upload Company Profile --}}
                                    <button class="btn btn-profile action-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#uploadDocsModal"
                                            data-notification-id="{{ $n->id }}"
                                            data-type="company">
                                        📤 Profile
                                    </button>

                                    {{-- Upload PQC --}}
                                    <button class="btn btn-pqc action-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#uploadDocsModal"
                                            data-notification-id="{{ $n->id }}"
                                            data-type="pqc">
                                        📎 PQC
                                    </button>

                                    {{-- View Full Message --}}
                                    <button class="btn btn-view action-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#viewMessageModal"
                                            data-title=""
                                            data-message="{{ $n->message }}">
                                        👁 View
                                    </button>

                                </div>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                No notifications found.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>

{{-- ================= UPLOAD MODAL ================= --}}
<div class="modal fade" id="uploadDocsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST"
              action="{{ route('vendor.erp_notifications.upload_docs') }}"
              enctype="multipart/form-data"
              class="modal-content rounded-4">
            @csrf

            <input type="hidden" name="notification_id" id="doc_notification_id">
            <input type="hidden" name="doc_type" id="doc_type">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="uploadTitle">
                    Upload Document
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label fw-semibold">Select File</label>
                    <input type="file"
                           name="document_file"
                           class="form-control"
                           required>
                </div>

            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    Cancel
                </button>
                <button class="btn btn-primary">
                    <i class="bi bi-cloud-upload"></i> Upload
                </button>
            </div>

        </form>
    </div>
</div>

{{-- ================= VIEW MESSAGE MODAL ================= --}}
<div class="modal fade" id="viewMessageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="vm_title">Message</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="p-3 bg-light rounded-3">
                    <div id="vm_message" style="white-space:pre-line;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function(){

    const uploadModal = document.getElementById('uploadDocsModal');

    uploadModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const nid  = button.getAttribute('data-notification-id');
        const type = button.getAttribute('data-type');

        document.getElementById('doc_notification_id').value = nid;
        document.getElementById('doc_type').value = type;

        document.getElementById('uploadTitle').innerText =
            (type === 'company') ? "Upload Company Profile" : "Upload PQC File";
    });

    const viewModal = document.getElementById('viewMessageModal');

    viewModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        document.getElementById('vm_title').innerText =
            button.getAttribute('data-title');

        document.getElementById('vm_message').innerText =
            button.getAttribute('data-message');
    });

});
</script>

@endsection