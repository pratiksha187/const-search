@extends('layouts.employerapp')

@section('title', 'BOQ → RFQ → Bids')
@section('page-title', 'BOQ → RFQ → Bids')
@section('page-subtitle', 'Simulate sourcing & bidding like Ariba')

@section('content')

<style>
  .step.active { border: 2px solid var(--orange); }
  .step.done .num { background: #16a34a; color:#fff; }
  .hintbox{ background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:14px; }
  .divider{ height:1px; background:#e5e7eb; margin:14px 0; }
  .invite-btn.invited{
    background:#16a34a !important;
    border-color:#16a34a !important;
    color:#fff !important;
    pointer-events:none;
  }
</style>

<section class="section mt-3" id="sec-sourcing">
  <div class="cardx p-3">

    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
      <div>
        <h6 class="mb-0" style="font-weight:900;color:var(--navy)">BOQ → RFQ → Bidding</h6>

        <div class="smallmuted">
          Project:
          <b id="currentProject">{{ $project->title ?? $project->name ?? 'Project' }}</b>
          <span class="ms-2 text-muted">(#{{ $project->id ?? '-' }})</span>
        </div>

        <div class="smallmuted">
          RFQ ID: <b id="rfqIdText">{{ $rfq->id ?? 'Not created' }}</b>
        </div>
      </div>

      <div class="d-flex gap-2">
        <button type="button" class="btn-soft" onclick="resetFlow()">
          <i class="bi bi-arrow-counterclockwise"></i> Reset Demo
        </button>
        <button type="button" class="btn-ck" onclick="nextStep()">
          <i class="bi bi-arrow-right"></i> Next Step
        </button>
      </div>
    </div>

    <div class="stepbar mt-3">
      <div class="step active" id="step1" onclick="setStep(1)">
        <div class="num">1</div>
        <div><b>Upload BOQ</b><div class="smallmuted">Excel / CSV / Manual</div></div>
      </div>
      <div class="step" id="step2" onclick="setStep(2)">
        <div class="num">2</div>
        <div><b>Create RFQ</b><div class="smallmuted">Scope + timeline</div></div>
      </div>
      <div class="step" id="step3" onclick="setStep(3)">
        <div class="num">3</div>
        <div><b>Invite Vendors</b><div class="smallmuted">Accepted vendors</div></div>
      </div>
      <div class="step" id="step4" onclick="setStep(4)">
        <div class="num">4</div>
        <div><b>Collect Bids</b><div class="smallmuted">Rates + terms</div></div>
      </div>
      <div class="step" id="step5" onclick="setStep(5)">
        <div class="num">5</div>
        <div><b>Compare & Select</b><div class="smallmuted">Rate analysis</div></div>
      </div>
    </div>

    <div class="divider"></div>

    {{-- STEP 1 --}}
    <div id="panel1">
      <div class="row g-3">

        <div class="col-lg-12">
          <div class="hintbox">
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="badge-soft"><i class="bi bi-upload"></i> BOQ Upload</span>
              <span class="smallmuted">Upload BOQ & save to DB</span>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label smallmuted">BOQ Type</label>
                  <input class="form-control" id="boqType" name="boqType" value="" />
                <!-- <select class="form-select" id="boqType">
                  <option value="RCC Flooring BOQ">RCC Flooring BOQ</option>
                  <option value="Steel & TMT BOQ">Steel & TMT BOQ</option>
                  <option value="MEP Procurement BOQ">MEP Procurement BOQ</option>
                </select> -->
              </div>

              <div class="col-md-6">
                <label class="form-label smallmuted">Upload File</label>
                <input class="form-control" type="file" id="boqFile" name="boq_file" accept=".csv,.xls,.xlsx">
                <div class="smallmuted mt-1">Allowed: .csv, .xls, .xlsx</div>
              </div>

              <div class="col-12 mt-2" id="existingBoqBox" style="display:none;">
                <div class="hintbox">
                  <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                      <div class="fw-semibold" style="color:var(--navy)">Existing BOQ Found ✅</div>
                      <div class="smallmuted">
                        File: <b id="existingBoqName">-</b><br>
                        Path: <span id="existingBoqPath">-</span><br>
                        Items: <b id="existingBoqItems">0</b> • Uploaded: <span id="existingBoqTime">-</span>
                      </div>
                    </div>

                    <div class="d-flex gap-2">
                      <a class="btn btn-sm btn-outline-primary" id="existingBoqDownload" href="#" target="_blank">
                        <i class="bi bi-download"></i> Download
                      </a>
                      <button type="button" class="btn btn-sm btn-outline-secondary" onclick="loadExistingBoq()">
                        <i class="bi bi-arrow-repeat"></i> Refresh
                      </button>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <div class="mt-3 d-flex gap-2 flex-wrap">
              <button type="button" class="btn-ck" onclick="uploadBoq(event)">
                <i class="bi bi-check2"></i> Confirm BOQ Upload
              </button>
            </div>
          </div>
        </div>

        
      </div>
    </div>

    {{-- STEP 2 --}}
    <div id="panel2" style="display:none;">
      <div class="row g-3">

        <div class="col-12" id="existingRfqBox" style="display:none;">
          <div class="hintbox">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
              <div>
                <div class="fw-semibold" style="color:var(--navy)">Existing RFQ Found ✅</div>
                <div class="smallmuted">
                  RFQ ID: <b id="existingRfqId">-</b> (<span id="existingRfqNo">-</span>)<br>
                  Title: <span id="existingRfqTitle">-</span><br>
                  Deadline: <span id="existingRfqDeadline">-</span><br>
                  Terms: <span id="existingRfqTerms">-</span><br>
                  Status: <b id="existingRfqStatus">-</b><br>
                  Created: <span id="existingRfqTime">-</span>
                </div>
              </div>

              <div class="d-flex gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="loadExistingRfq()">
                  <i class="bi bi-arrow-repeat"></i> Refresh
                </button>
                <button type="button" class="btn btn-sm btn-success" onclick="useExistingRfqAndContinue()">
                  <i class="bi bi-arrow-right"></i> Continue
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-12">
          <div class="hintbox">
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="badge-soft"><i class="bi bi-clipboard2-plus"></i> Create RFQ</span>
              <span class="smallmuted">Creates RFQ in DB</span>
            </div>

            <div class="row g-2">
              <div class="col-md-6">
                <label class="form-label smallmuted">RFQ Title</label>
                <input class="form-control" id="rfqTitle" value="Warehouse RCC Flooring – BOQ Based" />
              </div>
              <div class="col-md-3">
                <label class="form-label smallmuted">Bid Deadline</label>
                <input class="form-control" id="rfqDeadline" type="date" />
              </div>
              <div class="col-md-3">
                <label class="form-label smallmuted">Payment Terms</label>
                <select class="form-select" id="rfqTerms">
                  <option>30% Advance, Bill-to-Bill</option>
                  <option>Bill-to-Bill (No advance)</option>
                  <option>Milestone Based</option>
                </select>
              </div>
            </div>

            <div class="mt-3 d-flex gap-2 flex-wrap">
              <button type="button" class="btn-ck" onclick="createRfq()">
                <i class="bi bi-check2"></i> Create RFQ
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="cardx p-3">
            <h6 class="mb-1" style="font-weight:900;color:var(--navy)">RFQ Summary</h6>
            <div class="smallmuted">
              RFQ ID: <b id="rfqIdSide">{{ $rfq->id ?? 'Not created' }}</b><br/>
              Vendors invited: <b id="invitedCount">0</b>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- STEP 3 --}}
    <div id="panel3" style="display:none;">
      <div class="row g-3">
        <div class="col-lg-12">
          <div class="hintbox">
            <div class="d-flex align-items-center gap-2 mb-2">
              <span class="badge-soft"><i class="bi bi-people"></i> Invite Vendors</span>
              <span class="smallmuted">Only accepted vendors</span>
            </div>

            <div class="divider"></div>

            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr>
                    <th>Vendor</th>
                    <th class="text-end">Invite</th>
                  </tr>
                </thead>
                <tbody id="vendorInviteTable">
                  <tr><td colspan="2" class="text-muted">Open step to load vendors…</td></tr>
                </tbody>
              </table>
            </div>

            <div class="mt-3 d-flex gap-2 flex-wrap">
              <button type="button" class="btn-ck" onclick="markDone(3); nextStep();">
                <i class="bi bi-send"></i> Next
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>

    {{-- STEP 4 --}}
    <!-- <div id="panel4" style="display:none;">
      <div class="hintbox">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
          <div class="d-flex align-items-center gap-2">
            <span class="badge-soft"><i class="bi bi-cash-coin"></i> Bidding Room</span>
            <span class="smallmuted">Simulate bid → saved</span>
          </div>
          <button type="button" class="btn-soft" onclick="simulateBid()">
            <i class="bi bi-plus-circle"></i> Simulate Bid
          </button>
        </div>

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>Vendor</th>
                <th>Total Quote</th>
                <th>Timeline</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="bidTable">
              <tr><td colspan="4" class="text-muted">No bids yet.</td></tr>
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          <button type="button" class="btn-ck" onclick="markDone(4); nextStep();">
            <i class="bi bi-check2"></i> Next
          </button>
        </div>
      </div>
    </div> -->
    <div id="panel4" style="display:none;">
      <div class="hintbox">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
          <div class="d-flex align-items-center gap-2">
            <span class="badge-soft"><i class="bi bi-cash-coin"></i> Bidding Room</span>
            <span class="smallmuted">Vendor uploaded replies</span>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>Vendor</th>
                <th>Reply File</th>
                <th>Reply Date</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody id="bidTable">
              <tr><td colspan="4" class="text-muted">No bids yet.</td></tr>
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          <button type="button" class="btn-ck" onclick="markDone(4); nextStep();">
            <i class="bi bi-check2"></i> Next
          </button>
        </div>
      </div>
    </div>

    {{-- STEP 5 --}}
 <div id="panel5" style="display:none;">
  <div class="hintbox">
    <div class="table-responsive">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th>Vendor</th>
            <th>Total Quote</th>
            <th>Timeline</th>
            <th>Status</th>
            <th class="text-end">Action</th>
          </tr>
        </thead>
        <tbody id="compareTable">
          <tr><td colspan="5" class="text-muted">No bids.</td></tr>
        </tbody>
      </table>
    </div>

    <div class="divider"></div>
    <div class="smallmuted">
      Winner: <b id="winnerName">Not selected</b>
    </div>
  </div>
</div>

  </div>
</section>
<script>
let currentStep = 1;
const totalSteps = 5;
const doneSteps = new Set();

const PROJECT_ID = {{ (int)($project->id ?? 0) }};
let CURRENT_RFQ_ID = {{ (int)($rfq->id ?? 0) }};
const CSRF_TOKEN = "{{ csrf_token() }}";

// ROUTES
const URL_ACCEPTED_VENDORS = "{{ route('employer.accepted.vendors', ['projectId' => $project->id]) }}";
const URL_CREATE_RFQ       = "{{ route('employer.rfq.create') }}";
const URL_INVITE_VENDOR    = "{{ route('employer.rfq.invite') }}";
const URL_BOQ_UPLOAD       = "{{ route('employer.boq.upload') }}";
const URL_BOQ_LATEST       = "{{ route('employer.boq.latest', ['projectId' => $project->id]) }}";
const URL_RFQ_LATEST       = "{{ route('employer.rfq.latest', ['projectId' => $project->id]) }}";

// dynamic urls
function urlInvited(rfqId) {
    return `/rfq/${rfqId}/invited`;
}

function urlBids(rfqId) {
    return `/rfq/${rfqId}/bids`;
}

function urlCompare(rfqId) {
    return `/rfq/${rfqId}/compare`;
}

function toast(msg){
    console.log(msg);
}

function escapeHtml(value){
    return String(value ?? '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');
}

function jsEscape(value){
    return String(value ?? '')
        .replace(/\\/g, '\\\\')
        .replace(/'/g, "\\'")
        .replace(/"/g, '\\"');
}

async function safeJson(res){
    const text = await res.text();
    try {
        return JSON.parse(text);
    } catch (e) {
        console.error('Invalid JSON response:', text);
        throw new Error('Server returned invalid JSON');
    }
}

function showPanel(step){
    for(let i = 1; i <= totalSteps; i++){
        const panel = document.getElementById('panel' + i);
        if(panel) panel.style.display = (i === step) ? 'block' : 'none';

        const stepEl = document.getElementById('step' + i);
        if(stepEl) stepEl.classList.toggle('active', i === step);
    }

    if(step === 2) loadExistingRfq();
    if(step === 3) loadAcceptedVendors();
    if(step === 4) loadVendorReplies();
    if(step === 5) loadCompareReplies();
}

function setStep(step){
    currentStep = Math.max(1, Math.min(totalSteps, step));
    showPanel(currentStep);
}

function nextStep(){
    if(currentStep < totalSteps){
        currentStep++;
        showPanel(currentStep);
    }
}

function resetFlow(){
    doneSteps.clear();
    currentStep = 1;

    for(let i = 1; i <= totalSteps; i++){
        document.getElementById('step' + i)?.classList.remove('done');
    }

    showPanel(1);
}

function markDone(step){
    doneSteps.add(step);
    document.getElementById('step' + step)?.classList.add('done');
}

// ================= STEP 1 : LOAD EXISTING BOQ =================
async function loadExistingBoq(){
    const box = document.getElementById('existingBoqBox');
    if(!box) return;

    try {
        const res = await fetch(URL_BOQ_LATEST, {
            headers: { 'Accept': 'application/json' }
        });

        const data = await safeJson(res);

        if(data.ok && data.exists){
            const b = data.boq || {};
            document.getElementById('existingBoqName').innerText  = b.original_name || 'BOQ File';
            document.getElementById('existingBoqPath').innerText  = b.file_path || '-';
            document.getElementById('existingBoqItems').innerText = b.total_items ?? 0;
            document.getElementById('existingBoqTime').innerText  = b.created_at || '-';
            document.getElementById('existingBoqDownload').href   = b.file_url || '#';
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    } catch (error) {
        console.error(error);
        box.style.display = 'none';
    }
}

// ================= STEP 1 : UPLOAD BOQ =================
async function uploadBoq(e){
    if(e) e.preventDefault();

    const file = document.getElementById('boqFile')?.files?.[0];
    const boq_type = document.getElementById('boqType')?.value || null;

    if(!file){
        alert('Please select BOQ file');
        return;
    }

    const fd = new FormData();
    fd.append('project_id', PROJECT_ID);
    fd.append('boq_type', boq_type);
    fd.append('boq_file', file);

    try {
        const res = await fetch(URL_BOQ_UPLOAD, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: fd
        });

        const data = await safeJson(res);

        if(res.status === 422){
            alert(data.errors?.boq_file?.[0] || data.message || 'Validation error');
            return;
        }

        if(data.ok){
            await loadExistingBoq();
            alert(`BOQ saved ✅ Items: ${data.total_items ?? 0}`);
            markDone(1);
            nextStep();
        } else {
            alert(data.message || 'BOQ upload failed');
        }
    } catch (error) {
        console.error(error);
        alert('BOQ upload failed');
    }
}

// ================= STEP 2 : LOAD EXISTING RFQ =================
async function loadExistingRfq(){
    const box = document.getElementById('existingRfqBox');
    if(!box) return;

    try {
        const res = await fetch(URL_RFQ_LATEST, {
            headers: { 'Accept': 'application/json' }
        });

        const data = await safeJson(res);

        if(data.ok && data.exists){
            const r = data.rfq || {};

            document.getElementById('existingRfqId').innerText       = r.id ?? '-';
            document.getElementById('existingRfqNo').innerText       = r.rfq_no ?? '-';
            document.getElementById('existingRfqTitle').innerText    = r.title ?? '-';
            document.getElementById('existingRfqDeadline').innerText = r.bid_deadline ?? '-';
            document.getElementById('existingRfqTerms').innerText    = r.payment_terms ?? '-';
            document.getElementById('existingRfqStatus').innerText   = r.status ?? '-';
            document.getElementById('existingRfqTime').innerText     = r.created_at ?? '-';

            CURRENT_RFQ_ID = r.id ?? 0;
            document.getElementById('rfqIdText').innerText = CURRENT_RFQ_ID || 'Not created';
            document.getElementById('rfqIdSide').innerText = CURRENT_RFQ_ID || 'Not created';

            box.style.display = 'block';
            await refreshInvitedList();
        } else {
            box.style.display = 'none';
        }
    } catch (error) {
        console.error(error);
        box.style.display = 'none';
    }
}

function useExistingRfqAndContinue(){
    if(!CURRENT_RFQ_ID){
        alert('No RFQ found. Please create RFQ first.');
        return;
    }

    markDone(2);
    nextStep();
}

// ================= STEP 2 : CREATE RFQ =================
async function createRfq(){
    const title = document.getElementById('rfqTitle')?.value?.trim();
    const deadline = document.getElementById('rfqDeadline')?.value || null;
    const payment_terms = document.getElementById('rfqTerms')?.value || null;

    if(!title){
        alert('Please enter RFQ Title');
        return;
    }

    try {
        const res = await fetch(URL_CREATE_RFQ, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                project_id: PROJECT_ID,
                title,
                deadline,
                payment_terms
            })
        });

        const data = await safeJson(res);

        if(res.status === 422){
            alert(data.errors?.title?.[0] || data.message || 'Validation error');
            return;
        }

        if(data.ok){
            CURRENT_RFQ_ID = data.rfq_id;
            document.getElementById('rfqIdText').innerText = CURRENT_RFQ_ID;
            document.getElementById('rfqIdSide').innerText = CURRENT_RFQ_ID;

            await loadExistingRfq();
            markDone(2);
            nextStep();
        } else {
            alert(data.message || 'RFQ create failed');
        }
    } catch (error) {
        console.error(error);
        alert('RFQ create failed');
    }
}

// ================= STEP 3 : LOAD ACCEPTED VENDORS =================
async function loadAcceptedVendors(){
    const tbody = document.getElementById('vendorInviteTable');
    if(!tbody) return;

    tbody.innerHTML = `<tr><td colspan="2" class="text-muted">Loading...</td></tr>`;

    try {
        const res = await fetch(URL_ACCEPTED_VENDORS, {
            headers: { 'Accept': 'application/json' }
        });

        const data = await safeJson(res);

        if(!data.ok){
            tbody.innerHTML = `<tr><td colspan="2" class="text-danger">Failed to load vendors</td></tr>`;
            return;
        }

        const vendors = data.vendors || [];

        if(!vendors.length){
            tbody.innerHTML = `<tr><td colspan="2" class="text-muted">No accepted vendors yet.</td></tr>`;
            return;
        }

        let invitedMap = {};

        if(CURRENT_RFQ_ID){
            try {
                const invitedRes = await fetch(urlInvited(CURRENT_RFQ_ID), {
                    headers: { 'Accept': 'application/json' }
                });

                const invitedData = await safeJson(invitedRes);

                if(invitedData.ok){
                    (invitedData.vendors || []).forEach(v => {
                        invitedMap[v.id] = true;
                    });
                }
            } catch (e) {
                console.warn('Could not load invited vendors');
            }
        }

        tbody.innerHTML = '';

        vendors.forEach(v => {
            const name = v.company_name || v.name || 'Vendor';
            const mobile = v.mobile || '';
            const isInvited = !!invitedMap[v.id];

            tbody.innerHTML += `
                <tr>
                    <td>
                        <div class="fw-semibold">${escapeHtml(name)}</div>
                        <div class="text-muted small">${escapeHtml(mobile)}</div>
                    </td>
                    <td class="text-end">
                        <button
                            type="button"
                            class="btn btn-sm ${isInvited ? 'btn-success' : 'btn-primary'}"
                            id="invite-btn-${v.id}"
                            onclick="inviteVendor(${v.id}, '${jsEscape(name)}')"
                            ${isInvited ? 'disabled' : ''}>
                            ${isInvited ? 'Invited' : 'Invite'}
                        </button>
                    </td>
                </tr>
            `;
        });

        await refreshInvitedList();

    } catch (error) {
        console.error(error);
        tbody.innerHTML = `<tr><td colspan="2" class="text-danger">Failed to load vendors</td></tr>`;
    }
}

// ================= STEP 3 : INVITE VENDOR =================
async function inviteVendor(vendorId, vendorName){
    if(!CURRENT_RFQ_ID){
        alert('First create RFQ in Step 2');
        return;
    }

    const btn = document.getElementById(`invite-btn-${vendorId}`);
    if(btn){
        btn.disabled = true;
        btn.innerText = 'Inviting...';
    }

    try {
        const res = await fetch(URL_INVITE_VENDOR, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                rfq_id: CURRENT_RFQ_ID,
                vendor_id: vendorId
            })
        });

        const data = await safeJson(res);

        if(data.ok){
            if(btn){
                btn.innerText = 'Invited';
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-success');
                btn.disabled = true;
            }

            await refreshInvitedList();
            alert(data.message || `${vendorName} invited successfully`);
        } else {
            if(btn){
                btn.disabled = false;
                btn.innerText = 'Invite';
            }
            alert(data.message || 'Invite failed');
        }
    } catch (error) {
        console.error(error);
        if(btn){
            btn.disabled = false;
            btn.innerText = 'Invite';
        }
        alert('Invite failed');
    }
}

async function refreshInvitedList(){
    const ul = document.getElementById('invitedList');
    const countEl = document.getElementById('invitedCount');

    if(!CURRENT_RFQ_ID){
        if(countEl) countEl.innerText = 0;
        if(ul) ul.innerHTML = '';
        return;
    }

    try {
        const res = await fetch(urlInvited(CURRENT_RFQ_ID), {
            headers: { 'Accept': 'application/json' }
        });

        const data = await safeJson(res);

        if(!data.ok) return;

        const vendors = data.vendors || [];

        if(countEl) countEl.innerText = vendors.length;

        if(ul){
            ul.innerHTML = vendors.length
                ? vendors.map(v => `<li>${escapeHtml(v.company_name || v.name || 'Vendor')}</li>`).join('')
                : '<li class="text-muted">No vendors invited yet.</li>';
        }
    } catch (error) {
        console.error(error);
    }
}

// ================= STEP 4 : LOAD VENDOR REPLIES =================
async function loadVendorReplies() {
    const tbody = document.getElementById('bidTable');
    if(!tbody) return;

    tbody.innerHTML = `<tr><td colspan="4" class="text-muted">Loading...</td></tr>`;

    try {
        const res = await fetch(`/employer/projects/${PROJECT_ID}/rfq-replies`);
        const data = await safeJson(res);

        if (!data.ok || !data.rows.length) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-muted">No vendor replies yet.</td></tr>`;
            return;
        }

        tbody.innerHTML = data.rows.map(row => `
            <tr>
                <td>
                    <div class="fw-semibold">${escapeHtml(row.company_name ?? row.name ?? 'Vendor')}</div>
                    <small class="text-muted">${escapeHtml(row.mobile ?? '')}</small>
                </td>
                <td>
                    ${
                        row.reply_file
                        ? `<a href="/storage/${row.reply_file}" target="_blank" class="btn btn-sm btn-outline-primary">View Reply</a>`
                        : `<span class="text-muted">No file</span>`
                    }
                </td>
                <td>${row.replied_at ?? '-'}</td>
                <td>
                    <span class="badge ${row.status === 'replied' ? 'bg-success' : 'bg-secondary'}">
                        ${row.status ?? 'pending'}
                    </span>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        console.error(error);
        tbody.innerHTML = `<tr><td colspan="4" class="text-danger">Failed to load vendor replies.</td></tr>`;
    }
}

// ================= STEP 5 : LOAD COMPARE =================
async function loadCompareReplies() {
    const tbody = document.getElementById('compareTable');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="5" class="text-muted">Loading...</td></tr>`;

    try {
        const res = await fetch(`/employer/projects/${PROJECT_ID}/compare-vendor-replies`);
        const data = await safeJson(res);

        if (!data.ok || !data.rows || !data.rows.length) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-muted">No bids found.</td></tr>`;
            return;
        }

        tbody.innerHTML = data.rows.map(row => `
            <tr>
                <td>
                    <div class="fw-semibold">${escapeHtml(row.company_name ?? row.name ?? 'Vendor')}</div>
                    <small class="text-muted">${escapeHtml(row.mobile ?? '')}</small>
                </td>
                <td>₹${Number(row.total_quote || 0).toLocaleString('en-IN')}</td>
                <td>${row.delivery_timeline ?? '-'}</td>
                <td>
                    <span class="badge ${row.status === 'replied' ? 'bg-success' : 'bg-secondary'}">
                        ${row.status ?? 'pending'}
                    </span>
                </td>
                <td class="text-end">
                    <button type="button"
                            class="btn btn-sm ${row.selected_vendor == 1 ? 'btn-success' : 'btn-outline-primary'}"
                            onclick="selectWinner(${row.id}, '${jsEscape(row.company_name ?? row.name ?? 'Vendor')}')">
                        ${row.selected_vendor == 1 ? 'Selected' : 'Select'}
                    </button>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        console.error(error);
        tbody.innerHTML = `<tr><td colspan="5" class="text-danger">Failed to load compare data.</td></tr>`;
    }
}

// ================= STEP 5 : SELECT WINNER =================
async function selectWinner(replyId, vendorName){
    try {
        const res = await fetch(`/employer/projects/${PROJECT_ID}/select-winner`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF_TOKEN,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                reply_id: replyId
            })
        });

        const data = await safeJson(res);

        if(data.ok){
            document.getElementById('winnerName').innerText = vendorName;
            await loadCompareReplies();
            alert(data.message || 'Winner selected successfully');
        } else {
            alert(data.message || 'Failed to select winner');
        }
    } catch (error) {
        console.error(error);
        alert('Failed to select winner');
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    showPanel(1);
    await loadExistingBoq();

    if(CURRENT_RFQ_ID){
        await refreshInvitedList();
    }
});
</script>
<!-- <script>
let currentStep = 1;
const totalSteps = 5;
const doneSteps = new Set();

const PROJECT_ID = {{ (int)($project->id ?? 0) }};
let CURRENT_RFQ_ID = {{ (int)($rfq->id ?? 0) }};

const CSRF_TOKEN = "{{ csrf_token() }}";

// ROUTES
const URL_ACCEPTED_VENDORS = "{{ route('employer.accepted.vendors', ['projectId' => $project->id]) }}";
const URL_CREATE_RFQ       = "{{ route('employer.rfq.create') }}";
const URL_INVITE_VENDOR    = "{{ route('employer.rfq.invite') }}";
const URL_BOQ_UPLOAD       = "{{ route('employer.boq.upload') }}";
const URL_BOQ_LATEST       = "{{ route('employer.boq.latest', ['projectId' => $project->id]) }}";
const URL_RFQ_LATEST       = "{{ route('employer.rfq.latest', ['projectId' => $project->id]) }}";

// IMPORTANT:
// make sure these routes exist exactly in web.php
// function urlInvited(rfqId) { return `/rfq/${rfqId}/invited`; }
function urlBids(rfqId)    { return `/rfq/${rfqId}/bids`; }
function urlCompare(rfqId) { return `/rfq/${rfqId}/compare`; }

function showPanel(step){
  for(let i = 1; i <= totalSteps; i++){
    const panel = document.getElementById('panel' + i);
    if(panel) panel.style.display = (i === step) ? 'block' : 'none';

    const stepEl = document.getElementById('step' + i);
    if(stepEl) stepEl.classList.toggle('active', i === step);
  }

  if(step === 2) loadExistingRfq();
  if(step === 3) loadAcceptedVendors();
  if(step === 4) loadBids();
  if(step === 5) loadCompare();
}

function setStep(step){
  currentStep = Math.max(1, Math.min(totalSteps, step));
  showPanel(currentStep);
}

function nextStep(){
  if(currentStep < totalSteps){
    currentStep++;
    showPanel(currentStep);
  }
}

function resetFlow(){
  doneSteps.clear();
  currentStep = 1;
  for(let i = 1; i <= totalSteps; i++){
    document.getElementById('step' + i)?.classList.remove('done');
  }
  showPanel(1);
}

function markDone(step){
  doneSteps.add(step);
  document.getElementById('step' + step)?.classList.add('done');
}

async function safeJson(res){
  const text = await res.text();
  try {
    return JSON.parse(text);
  } catch (e) {
    console.error('Non-JSON response:', text);
    throw new Error('Server returned invalid response');
  }
}

// STEP 1: Existing BOQ
async function loadExistingBoq(){
  const box = document.getElementById('existingBoqBox');
  if(!box) return;

  try {
    const res = await fetch(URL_BOQ_LATEST, {
      headers: { 'Accept':'application/json' }
    });

    const data = await safeJson(res);

    if(data.ok && data.exists){
      const b = data.boq || {};
      document.getElementById('existingBoqName').innerText  = b.original_name || 'BOQ File';
      document.getElementById('existingBoqPath').innerText  = b.file_path || '-';
      document.getElementById('existingBoqItems').innerText = b.total_items ?? 0;
      document.getElementById('existingBoqTime').innerText  = b.created_at || '-';
      document.getElementById('existingBoqDownload').href   = b.file_url || '#';
      box.style.display = 'block';
    } else {
      box.style.display = 'none';
    }
  } catch (error) {
    console.error(error);
    box.style.display = 'none';
  }
}

// STEP 1: Upload BOQ
async function uploadBoq(e){
  if(e) e.preventDefault();

  const file = document.getElementById('boqFile')?.files?.[0];
  const boq_type = document.getElementById('boqType')?.value || null;

  if(!file){
    alert('Please select BOQ file');
    return;
  }

  const fd = new FormData();
  fd.append('project_id', PROJECT_ID);
  fd.append('boq_type', boq_type);
  fd.append('boq_file', file);

  try {
    const res = await fetch(URL_BOQ_UPLOAD, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'Accept': 'application/json'
      },
      body: fd
    });

    const data = await safeJson(res);

    if(res.status === 422){
      alert(data.errors?.boq_file?.[0] || data.message || 'Validation error');
      return;
    }

    if(data.ok){
      await loadExistingBoq();
      alert(`BOQ saved ✅ Items: ${data.total_items ?? 0}`);
      markDone(1);
      nextStep();
    } else {
      alert(data.message || 'BOQ upload failed');
    }
  } catch (error) {
    console.error(error);
    alert('BOQ upload failed');
  }
}

// STEP 2: Existing RFQ
async function loadExistingRfq(){
  const box = document.getElementById('existingRfqBox');
  if(!box) return;

  try {
    const res = await fetch(URL_RFQ_LATEST, {
      headers: { 'Accept':'application/json' }
    });

    const data = await safeJson(res);

    if(data.ok && data.exists){
      const r = data.rfq || {};

      document.getElementById('existingRfqId').innerText       = r.id ?? '-';
      document.getElementById('existingRfqNo').innerText       = r.rfq_no ?? '-';
      document.getElementById('existingRfqTitle').innerText    = r.title ?? '-';
      document.getElementById('existingRfqDeadline').innerText = r.bid_deadline ?? '-';
      document.getElementById('existingRfqTerms').innerText    = r.payment_terms ?? '-';
      document.getElementById('existingRfqStatus').innerText   = r.status ?? '-';
      document.getElementById('existingRfqTime').innerText     = r.created_at ?? '-';

      CURRENT_RFQ_ID = r.id ?? 0;
      document.getElementById('rfqIdText').innerText = CURRENT_RFQ_ID || 'Not created';
      document.getElementById('rfqIdSide').innerText = CURRENT_RFQ_ID || 'Not created';

      box.style.display = 'block';
      await refreshInvitedList();
    } else {
      box.style.display = 'none';
    }
  } catch (error) {
    console.error(error);
    box.style.display = 'none';
  }
}

function useExistingRfqAndContinue(){
  if(!CURRENT_RFQ_ID){
    alert('No RFQ found. Please create RFQ first.');
    return;
  }

  markDone(2);
  nextStep();
}

// STEP 2: Create RFQ
async function createRfq(){
  const title = document.getElementById('rfqTitle')?.value?.trim();
  const deadline = document.getElementById('rfqDeadline')?.value || null;
  const payment_terms = document.getElementById('rfqTerms')?.value || null;

  if(!title){
    alert('Please enter RFQ Title');
    return;
  }

  try {
    const res = await fetch(URL_CREATE_RFQ, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'Accept': 'application/json'
      },
      body: JSON.stringify({
        project_id: PROJECT_ID,
        title,
        deadline,
        payment_terms
      })
    });

    const data = await safeJson(res);

    if(res.status === 422){
      alert(data.errors?.title?.[0] || data.message || 'Validation error');
      return;
    }

    if(data.ok){
      CURRENT_RFQ_ID = data.rfq_id;
      document.getElementById('rfqIdText').innerText = CURRENT_RFQ_ID;
      document.getElementById('rfqIdSide').innerText = CURRENT_RFQ_ID;

      await loadExistingRfq();
      markDone(2);
      nextStep();
    } else {
      alert(data.message || 'RFQ create failed');
    }
  } catch (error) {
    console.error(error);
    alert('RFQ create failed');
  }
}

// STEP 3: Load accepted vendors
async function loadAcceptedVendors(){
  const tbody = document.getElementById('vendorInviteTable');
  tbody.innerHTML = `<tr><td colspan="2" class="text-muted">Loading...</td></tr>`;

  try {
    const res = await fetch(URL_ACCEPTED_VENDORS, {
      headers: { 'Accept':'application/json' }
    });

    const data = await safeJson(res);

    if(!data.ok){
      tbody.innerHTML = `<tr><td colspan="2" class="text-danger">Failed to load vendors</td></tr>`;
      return;
    }

    const vendors = data.vendors || [];

    if(!vendors.length){
      tbody.innerHTML = `<tr><td colspan="2" class="text-muted">No accepted vendors yet.</td></tr>`;
      return;
    }

    let invitedMap = {};
    try {
      const invitedRes = await fetch(urlInvited(CURRENT_RFQ_ID), {
        headers: { 'Accept':'application/json' }
      });
      const invitedData = await safeJson(invitedRes);
      if(invitedData.ok){
        (invitedData.vendors || []).forEach(v => {
          invitedMap[v.id] = true;
        });
      }
    } catch (e) {
      console.warn('Could not load invited vendors map');
    }

    tbody.innerHTML = '';

    vendors.forEach(v => {
      const name = v.company_name || v.name || 'Vendor';
      const mobile = v.mobile || '';
      const isInvited = !!invitedMap[v.id];

      tbody.innerHTML += `
        <tr>
          <td>
            <div class="fw-semibold">${escapeHtml(name)}</div>
            <div class="text-muted small">${escapeHtml(mobile)}</div>
          </td>
          <td class="text-end">
            <button
              type="button"
              class="btn btn-sm ${isInvited ? 'btn-success invited' : 'btn-primary'} invite-btn"
              id="invite-btn-${v.id}"
              onclick="inviteVendor(${v.id}, '${jsEscape(name)}')"
              ${isInvited ? 'disabled' : ''}>
              ${isInvited ? 'Invited' : 'Invite'}
            </button>
          </td>
        </tr>
      `;
    });

    await refreshInvitedList();

  } catch (error) {
    console.error(error);
    tbody.innerHTML = `<tr><td colspan="2" class="text-danger">Failed to load vendors</td></tr>`;
  }
}

// STEP 3: Invite vendor
async function inviteVendor(vendorId, vendorName){
  if(!CURRENT_RFQ_ID){
    alert('First create RFQ in Step 2');
    return;
  }

  const btn = document.getElementById(`invite-btn-${vendorId}`);
  if(btn){
    btn.disabled = true;
    btn.innerText = 'Inviting...';
  }

  try {
    const res = await fetch(URL_INVITE_VENDOR, {
      method:'POST',
      headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN': CSRF_TOKEN,
        'Accept':'application/json'
      },
      body: JSON.stringify({
        rfq_id: CURRENT_RFQ_ID,
        vendor_id: vendorId
      })
    });

    const data = await safeJson(res);

    if(!res.ok){
      if(btn){
        btn.disabled = false;
        btn.innerText = 'Invite';
      }
      alert(data.message || 'Invite failed');
      return;
    }

    if(data.ok){
      if(btn){
        btn.innerText = 'Invited';
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-success', 'invited');
        btn.disabled = true;
      }

      await refreshInvitedList();
      document.getElementById('invitedCount').innerText =
        document.querySelectorAll('#invitedList li').length;

      alert(data.message || `${vendorName} invited successfully`);
    } else {
      if(btn){
        btn.disabled = false;
        btn.innerText = 'Invite';
      }
      alert(data.message || 'Invite failed');
    }
  } catch (error) {
    console.error(error);
    if(btn){
      btn.disabled = false;
      btn.innerText = 'Invite';
    }
    alert('Invite failed. Check console.');
  }
}

async function refreshInvitedList(){
  if(!CURRENT_RFQ_ID){
    document.getElementById('invitedCount').innerText = 0;
    document.getElementById('invitedList').innerHTML = '';
    return;
  }

  try {
    const res = await fetch(urlInvited(CURRENT_RFQ_ID), {
      headers: { 'Accept':'application/json' }
    });

    const data = await safeJson(res);

    if(!data.ok) return;

    const vendors = data.vendors || [];
    document.getElementById('invitedCount').innerText = vendors.length;

    const ul = document.getElementById('invitedList');
    ul.innerHTML = vendors.length
      ? vendors.map(v => `<li>${escapeHtml(v.company_name || v.name || 'Vendor')}</li>`).join('')
      : '<li class="text-muted">No vendors invited yet.</li>';

  } catch (error) {
    console.error(error);
  }
}

/* STEP 4/5 placeholder */
async function simulateBid(){
  alert('simulateBid() keep your existing code');
}

async function loadBids(){
  // keep your existing code here
}

async function loadCompare(){
  // keep your existing code here
}

function setWinner(name){
  document.getElementById('winnerName').innerText = name;
}

function escapeHtml(value){
  return String(value ?? '')
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');
}

function jsEscape(value){
  return String(value ?? '')
    .replace(/\\/g, '\\\\')
    .replace(/'/g, "\\'")
    .replace(/"/g, '\\"');
}

document.addEventListener('DOMContentLoaded', async () => {
  showPanel(1);
  await loadExistingBoq();

  if(CURRENT_RFQ_ID){
    await refreshInvitedList();
  }
});
</script>
<script>
  async function loadVendorReplies() {
    const tbody = document.getElementById('bidTable');
    tbody.innerHTML = `<tr><td colspan="4" class="text-muted">Loading...</td></tr>`;

    const res = await fetch(`/employer/projects/${PROJECT_ID}/rfq-replies`);
    const data = await res.json();

    if (!data.ok || !data.rows.length) {
        tbody.innerHTML = `<tr><td colspan="4" class="text-muted">No vendor replies yet.</td></tr>`;
        return;
    }

    tbody.innerHTML = data.rows.map(row => `
        <tr>
            <td>
                <div class="fw-semibold">${row.company_name ?? row.name ?? 'Vendor'}</div>
                <small class="text-muted">${row.mobile ?? ''}</small>
            </td>
            <td>
                ${
                    row.reply_file
                    ? `<a href="/storage/${row.reply_file}" target="_blank" class="btn btn-sm btn-outline-primary">View Reply</a>`
                    : `<span class="text-muted">No file</span>`
                }
            </td>
            <td>${row.replied_at ?? '-'}</td>
            <td>
                <span class="badge ${row.status === 'replied' ? 'bg-success' : 'bg-secondary'}">
                    ${row.status ?? 'pending'}
                </span>
            </td>
        </tr>
    `).join('');
}

function showPanel(step){
  for(let i=1; i<=5; i++){
    const panel = document.getElementById('panel'+i);
    if(panel) panel.style.display = (i === step) ? 'block' : 'none';
    const stepEl = document.getElementById('step'+i);
    if(stepEl) stepEl.classList.toggle('active', i === step);
  }

  if(step === 4){
    loadVendorReplies();
  }
}



async function loadCompareReplies() {
    const tbody = document.getElementById('compareTable');
    if (!tbody) return;

    tbody.innerHTML = `<tr><td colspan="5" class="text-muted">Loading...</td></tr>`;

    try {
        const res = await fetch(`/employer/projects/${PROJECT_ID}/compare-vendor-replies`);
        const data = await res.json();

        if (!data.ok || !data.rows || !data.rows.length) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-muted">No bids found.</td></tr>`;
            return;
        }

        tbody.innerHTML = data.rows.map(row => `
            <tr>
                <td>
                    <div class="fw-semibold">${row.company_name ?? row.name ?? 'Vendor'}</div>
                    <small class="text-muted">${row.mobile ?? ''}</small>
                </td>
                <td>₹${Number(row.total_quote || 0).toLocaleString('en-IN')}</td>
                <td>${row.delivery_timeline ?? '-'}</td>
                <td>
                    <span class="badge ${row.status === 'replied' ? 'bg-success' : 'bg-secondary'}">
                        ${row.status ?? 'pending'}
                    </span>
                </td>
                <td class="text-end">
                    <button type="button"
                            class="btn btn-sm ${row.selected_vendor == 1 ? 'btn-success' : 'btn-outline-primary'}"
                            onclick="selectWinner(${row.id}, '${(row.company_name ?? row.name ?? 'Vendor').replace(/'/g, "\\'")}')">
                        ${row.selected_vendor == 1 ? 'Selected' : 'Select'}
                    </button>
                </td>
            </tr>
        `).join('');
    } catch (error) {
        tbody.innerHTML = `<tr><td colspan="5" class="text-danger">Failed to load compare data.</td></tr>`;
    }
}

function showPanel(step){
  for(let i=1; i<=5; i++){
    const panel = document.getElementById('panel'+i);
    if(panel) panel.style.display = (i === step) ? 'block' : 'none';

    const stepEl = document.getElementById('step'+i);
    if(stepEl) stepEl.classList.toggle('active', i === step);
  }

  if(step === 4){
    loadVendorReplies();
  }

  if(step === 5){
    loadCompareReplies();
  }
}
</script> -->


@endsection