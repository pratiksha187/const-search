@extends('layouts.vendorapp')

@section('title','ERP Notifications')

@section('content')

@php


$mergedNotifications = collect($notifications ?? [])->map(function ($item) {
    $item->source = 'email';
    return $item;
})->merge(
    collect($rfqInviteNotifications ?? [])->map(function ($item) {
        $item->source = 'rfq';
        return $item;
    })
);

$allNotifications = $mergedNotifications
    ->groupBy(function ($item) {
        return $item->project_id; // ✅ same project = one row
    })
    ->map(function ($group) {

        $emailItem = $group->firstWhere('source', 'email');
        $rfqItem   = $group->firstWhere('source', 'rfq');

        return (object) [
            'notification_id' => $emailItem->id ?? null,   // project_vendor_emails.id
            'rfq_row_id'      => $rfqItem->id ?? null,     // rfq_vendor_invites.id
            'id'              => $emailItem->id ?? ($rfqItem->id ?? null),

            'project_id'      => $emailItem->project_id ?? ($rfqItem->project_id ?? null),
            'rfq_id'          => $rfqItem->rfq_id ?? null,
            'boq_file'        => $rfqItem->boq_file ?? null,

            'message'         => $emailItem->message ?? 'You have received a new RFQ invitation from employer.',
            'created_at'      => $rfqItem->created_at ?? $emailItem->created_at ?? null,

            'has_email'       => (bool) $emailItem,
            'has_rfq'         => (bool) $rfqItem,
        ];
    })
    ->sortByDesc('created_at')
    ->values();
@endphp


<style>
.page-wrap{max-width:1200px;margin:0 auto;}
.page-title{font-weight:800;letter-spacing:.5px;}
.subtext{color:#64748b;font-size:14px;}
.card-modern{border-radius:16px;border:none;box-shadow:0 10px 30px rgba(0,0,0,.05);}
.table thead th{font-size:13px;text-transform:uppercase;letter-spacing:.5px;color:#64748b;}
.action-btn{font-size:12px;font-weight:600;padding:6px 12px;}
.btn-profile{border:1px solid #0d6efd;color:#0d6efd;}
.btn-profile:hover{background:#0d6efd;color:#fff;}
.btn-pqc{border:1px solid #198754;color:#198754;}
.btn-pqc:hover{background:#198754;color:#fff;}
.btn-view{border:1px solid #212529;color:#212529;}
.btn-view:hover{background:#212529;color:#fff;}
.badge-soft{background:#fff7ed;border:1px solid #fed7aa;color:#9a3412;font-weight:700;padding:6px 12px;border-radius:50px;font-size:12px;}
.badge-rfq{background:#ecfeff;border:1px solid #a5f3fc;color:#155e75;font-weight:700;padding:4px 10px;border-radius:50px;font-size:11px;}
</style>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container-fluid px-4 page-wrap">

    <div class="d-flex justify-content-between align-items-start flex-wrap mb-4">
        <div>
            <div class="d-flex align-items-center gap-3">
                <h3 class="page-title mb-0">ERP Notifications</h3>
                <span class="badge-soft">Total: {{ $allNotifications->count() }}</span>
            </div>
            <div class="subtext mt-1">Upload Company Profile & PQC to respond faster.</div>
        </div>

        <a href="{{ route('vendordashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

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
            <th width="320" class="text-center">Actions</th>
        </tr>
    </thead>

    <tbody>
    @forelse($allNotifications as $index => $n)
        <tr>
            <td class="fw-semibold">{{ $index + 1 }}</td>

            <td>
                <div class="fw-bold">ERP Notification</div>
                <small class="text-muted">
                    ID: {{ $n->id }}
                    | Project ID: {{ $n->project_id ?? '-' }}
                    @if(!empty($n->rfq_id))
                        | RFQ ID: {{ $n->rfq_id }}
                    @endif
                </small>
            </td>

            <td style="max-width:450px;">
                @if($n->has_rfq)
                    <div class="mb-1">
                        <span class="badge-rfq">RFQ Invite</span>
                    </div>
                @endif

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

                    {{-- Profile / PQC --}}
                    @if(!empty($n->notification_id))
                        <button class="btn btn-profile action-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#uploadDocsModal"
                                data-notification-id="{{ $n->notification_id }}"
                                data-project-id="{{ $n->project_id ?? '' }}"
                                data-type="company">
                            📤 Profile
                        </button>

                        <button class="btn btn-pqc action-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#uploadDocsModal"
                                data-notification-id="{{ $n->notification_id }}"
                                data-project-id="{{ $n->project_id ?? '' }}"
                                data-type="pqc">
                            📎 PQC
                        </button>
                    @endif

                    {{-- BOQ Download --}}
                    @if($n->has_rfq && !empty($n->boq_file))
                        <a href="{{ asset('storage/' . $n->boq_file) }}"
                           target="_blank"
                           class="btn btn-outline-success action-btn">
                            📥 BOQ
                        </a>
                    @endif

                    {{-- Upload Reply --}}
                    @if($n->has_rfq)
                        <button class="btn btn-outline-warning action-btn"
                                data-bs-toggle="modal"
                                data-bs-target="#uploadBoqReplyModal"
                                data-rfq-id="{{ $n->rfq_id }}"
                                data-project-id="{{ $n->project_id ?? '' }}"
                                data-boq-file="{{ $n->boq_file ?? '' }}">
                            ⬆ Upload
                        </button>
                    @endif

                    {{-- View Message --}}
                    <button class="btn btn-view action-btn"
                            data-bs-toggle="modal"
                            data-bs-target="#viewMessageModal"
                            data-title="ERP Notification"
                            data-message="{{ $n->has_rfq && $n->has_email 
                                ? $n->message . "\n\nRFQ Invitation available. RFQ ID: " . $n->rfq_id 
                                : ($n->has_rfq 
                                    ? "You have received a new RFQ invitation from employer. RFQ ID: " . $n->rfq_id 
                                    : $n->message) }}">
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

{{-- ================= UPLOAD DOCS MODAL ================= --}}
<div class="modal fade" id="uploadDocsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <form method="POST"
              id="pqcMainForm"
              action="{{ route('vendor.pqc.save') }}"
              enctype="multipart/form-data"
              class="modal-content rounded-4">
            @csrf

            <input type="hidden" name="notification_id" id="doc_notification_id">
            <input type="hidden" name="doc_type" id="doc_type">
            <input type="hidden" name="project_id" id="doc_project_id">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="uploadTitle">Upload Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- COMPANY WRAP --}}
                <div id="companyUploadWrap" class="d-none">
                    <div id="companyUploadedAlert" class="alert alert-success d-none">
                        <div class="fw-bold">Company Profile Already Uploaded ✅</div>
                        <div class="small" id="companyUploadedText"></div>
                        <div class="mt-2" id="companyUploadedLinkWrap"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Select Company Profile File</label>
                        <input type="file"
                               name="document_file"
                               class="form-control"
                               id="companyFileInput"
                               accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text">Upload PDF/JPG/PNG as per requirement.</div>
                    </div>
                </div>

                {{-- PQC WRAP --}}
                <div id="pqcFormWrap" class="d-none">

                    <div class="alert alert-light border mb-3">
                        <div class="fw-bold">PQC / Pre-Qualification Form</div>
                        <div class="small text-muted">Fill all details. You can add multiple projects below.</div>
                    </div>

                    <div class="accordion" id="pqcAcc">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="h1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#c1">
                                    1–5 Company & Contact Details
                                </button>
                            </h2>
                            <div id="c1" class="accordion-collapse collapse show" data-bs-parent="#pqcAcc">
                                <div class="accordion-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">1. Company Name</label>
                                            <input type="text" class="form-control" name="pqc[company_name]">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">2. Establishment Year</label>
                                            <input type="number" class="form-control" name="pqc[establishment_year]">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Registered Office</label>
                                            <textarea class="form-control" rows="2" name="pqc[address][registered_office]"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Warehouse Address</label>
                                            <textarea class="form-control" rows="2" name="pqc[address][warehouse]"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="h2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c2">
                                    6–7 Staff Strength & Proposed Team
                                </button>
                            </h2>
                            <div id="c2" class="accordion-collapse collapse" data-bs-parent="#pqcAcc">
                                <div class="accordion-body">
                                    <div class="row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Project Managers</label>
                                            <input type="number" class="form-control" name="pqc[org_capability][project_managers]">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Supervisors</label>
                                            <input type="number" class="form-control" name="pqc[org_capability][supervisors]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="h3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c3">
                                    8–11 Equipment, Partners, Labour & Financial
                                </button>
                            </h2>
                            <div id="c3" class="accordion-collapse collapse" data-bs-parent="#pqcAcc">
                                <div class="accordion-body">
                                    <div class="mb-3">
                                        <label class="form-label">Infrastructure / Equipment / Machinery details</label>
                                        <textarea class="form-control" rows="3" name="pqc[infrastructure_details]"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="h4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c4">
                                    12 Completed Projects
                                </button>
                            </h2>
                            <div id="c4" class="accordion-collapse collapse" data-bs-parent="#pqcAcc">
                                <div class="accordion-body">
                                    <div id="completedProjectsWrap"></div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="addCompletedProjectBtn">
                                        + Add Completed Project
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="h5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#c5">
                                    13 Work In Hand
                                </button>
                            </h2>
                            <div id="c5" class="accordion-collapse collapse" data-bs-parent="#pqcAcc">
                                <div class="accordion-body">
                                    <div id="workInHandWrap"></div>
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="addWorkInHandBtn">
                                        + Add Work In Hand
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div id="alreadySubmittedAlert" class="alert alert-warning d-none mt-3">
                    <div class="fw-bold">Already Submitted ✅</div>
                    <div class="small" id="alreadySubmittedText"></div>
                </div>

            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check2-circle"></i> Submit
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

{{-- ================= UPLOAD BOQ REPLY MODAL ================= --}}
<div class="modal fade" id="uploadBoqReplyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="POST"
              action="{{ route('vendor.boq.reply.upload') }}"
              enctype="multipart/form-data"
              class="modal-content rounded-4">
            @csrf

            <input type="hidden" name="rfq_id" id="reply_rfq_id">
            <input type="hidden" name="project_id" id="reply_project_id">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Upload BOQ Reply File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3 p-3 border rounded-3 bg-light">
                    <div class="fw-semibold mb-2">Employer BOQ File</div>
                    <div id="employerBoqDownloadWrap"><span class="text-muted">No BOQ file available.</span></div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Upload Your Reply File</label>
                    
                        <input type="file" name="reply_file" class="form-control"
                        accept=".pdf,.xls,.xlsx,.csv,.txt,.jpg,.jpeg,.png" required>
                    <div class="form-text">Allowed: PDF, Excel, CSV, Image</div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Total Quote</label>
                    <input type="number" step="0.01" name="total_quote" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Delivery Timeline</label>
                    <input type="text" name="delivery_timeline" class="form-control" placeholder="e.g. 15 Days" required>
                </div>
            </div>

            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary"><i class="bi bi-upload"></i> Upload</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

  // ================= VIEW MESSAGE MODAL =================
  const viewModal = document.getElementById('viewMessageModal');
  viewModal?.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;
    document.getElementById('vm_title').innerText   = btn.getAttribute('data-title') || 'Message';
    document.getElementById('vm_message').innerText = btn.getAttribute('data-message') || '';
  });

  // ================= UPLOAD BOQ REPLY MODAL =================
  const boqReplyModal = document.getElementById('uploadBoqReplyModal');
  boqReplyModal?.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;

    const rfqId = btn.getAttribute('data-rfq-id');
    const pid   = btn.getAttribute('data-project-id');
    const boq   = btn.getAttribute('data-boq-file');

    document.getElementById('reply_rfq_id').value = rfqId || '';
    document.getElementById('reply_project_id').value = pid || '';

    const wrap = document.getElementById('employerBoqDownloadWrap');
    if (boq) {
      wrap.innerHTML = `<a href="{{ asset('storage') }}/${boq}" target="_blank" class="btn btn-sm btn-outline-success">Download BOQ</a>`;
    } else {
      wrap.innerHTML = `<span class="text-muted">No BOQ file available.</span>`;
    }
  });

  // ================= UPLOAD DOCS MODAL =================
  const uploadModal  = document.getElementById('uploadDocsModal');
  const companyWrap  = document.getElementById('companyUploadWrap');
  const pqcWrap      = document.getElementById('pqcFormWrap');

  const hidNid  = document.getElementById('doc_notification_id');
  const hidType = document.getElementById('doc_type');
  const hidPid  = document.getElementById('doc_project_id');

  const companyUploadedAlert    = document.getElementById('companyUploadedAlert');
  const companyUploadedText     = document.getElementById('companyUploadedText');
  const companyUploadedLinkWrap = document.getElementById('companyUploadedLinkWrap');
  const companyFileInput        = document.getElementById('companyFileInput');

  const alertBox  = document.getElementById('alreadySubmittedAlert');
  const alertText = document.getElementById('alreadySubmittedText');

  const completedWrap = document.getElementById('completedProjectsWrap');
  const workWrap      = document.getElementById('workInHandWrap');

  let completedIndex = 0;
  let workIndex = 0;

  function setCompanyDisabled(disabled){ if (companyFileInput) companyFileInput.disabled = disabled; }
  function setPqcDisabled(disabled){
    if (!pqcWrap) return;
    pqcWrap.querySelectorAll('input, textarea, select, button').forEach(el => el.disabled = disabled);
  }

  function resetCompanyUI(){
    companyUploadedAlert?.classList.add('d-none');
    if (companyUploadedText) companyUploadedText.innerHTML = '';
    if (companyUploadedLinkWrap) companyUploadedLinkWrap.innerHTML = '';
    if (companyFileInput) companyFileInput.value = '';
    setCompanyDisabled(false);
  }

  function resetPqcForm(){
    if (!pqcWrap) return;
    pqcWrap.querySelectorAll('input[type="text"], input[type="number"], input[type="email"], textarea').forEach(el => el.value = '');
    pqcWrap.querySelectorAll('select').forEach(el => el.value = '');
  }

  function resetDynamicBlocks(){
    completedWrap && (completedWrap.innerHTML = '');
    workWrap && (workWrap.innerHTML = '');
    completedIndex = 0;
    workIndex = 0;
  }

  function setField(name, value){
    const el = uploadModal.querySelector(`[name="${name}"]`);
    if (el) el.value = value ?? '';
  }

  // NOTE: Your dynamic blocks are already in your script.
  // Keep them if you want. Here we only keep prefill logic minimal.
  function prefillPqc(data){
    setField('pqc[company_name]', data.company_name);
    setField('pqc[establishment_year]', data.establishment_year);
  }

  uploadModal?.addEventListener('show.bs.modal', async function (event) {

    const button = event.relatedTarget;

    const nid  = button?.getAttribute('data-notification-id');
    const type = button?.getAttribute('data-type');
    const pid  = button?.getAttribute('data-project-id');

    if (!nid) { alert('Notification ID missing in button'); return; }
    if (!type) { alert('Doc type missing in button'); return; }

    hidNid.value  = nid;
    hidType.value = type;
    hidPid.value  = pid || '';

    alertBox?.classList.add('d-none');
    if (alertText) alertText.innerHTML = '';
    resetCompanyUI();
    setPqcDisabled(false);

    if (type === 'company') {
      document.getElementById('uploadTitle').innerText = "Upload Company Profile";
      companyWrap.classList.remove('d-none');
      pqcWrap.classList.add('d-none');
    } else {
      document.getElementById('uploadTitle').innerText = "PQC / Pre-Qualification Form";
      pqcWrap.classList.remove('d-none');
      companyWrap.classList.add('d-none');
      resetPqcForm();
      resetDynamicBlocks();
    }

    const url = `{{ route('vendor.pqc.check') }}?notification_id=${encodeURIComponent(nid)}&doc_type=${encodeURIComponent(type)}`;
    const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }});
    const data = await res.json();

    if (type === 'company') {
      if (data.exists && data.company_profile_path) {
        companyUploadedAlert.classList.remove('d-none');
        companyUploadedText.innerHTML = `Status: <b>${data.status}</b><br>Uploaded at: ${data.created_at ?? '-'}`;
        const fileUrl = `{{ asset('storage') }}/${data.company_profile_path}`;
        companyUploadedLinkWrap.innerHTML = `<a href="${fileUrl}" target="_blank" class="btn btn-sm btn-outline-success">View / Download</a>`;
        if (data.status === 'submitted') setCompanyDisabled(true);
      }
      return;
    }

    if (data.exists) {
      alertBox.classList.remove('d-none');
      alertText.innerHTML = `Status: <b>${data.status}</b><br>Created at: ${data.created_at ?? '-'}`;
      if (data.pqc_data) prefillPqc(data.pqc_data);
      if (data.status === 'submitted') setPqcDisabled(true);
    }
  });

});




</script>

@endsection