 @extends('layouts.employerapp')

@section('title', 'BOQ → RFQ → Bids')

@section('page-title', 'BOQ → RFQ → Bids')
@section('page-subtitle', 'Simulate sourcing & bidding like Ariba')

@section('content')
<style>
    .step.active { border: 2px solid var(--orange); }
.step.done .num { background: #16a34a; color:#fff; }

</style>
 <section class="section mt-3" id="sec-sourcing">
      <div class="cardx p-3">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
          <div>
            <h6 class="mb-0" style="font-weight:900;color:var(--navy)">BOQ → RFQ → Bidding</h6>
            <div class="smallmuted">Project: <b id="currentProject">CK • Warehouse RCC Flooring</b></div>
          </div>
          <div class="d-flex gap-2">
            <button class="btn-soft" onclick="resetFlow()"><i class="bi bi-arrow-counterclockwise"></i> Reset Demo</button>
            <button class="btn-ck" onclick="nextStep()"><i class="bi bi-arrow-right"></i> Next Step</button>
          </div>
        </div>

        <div class="stepbar">
          <div class="step active" id="step1" onclick="setStep(1)">
            <div class="num">1</div>
            <div>
              <b>Upload BOQ</b><div class="smallmuted">Excel / CSV / Manual</div>
            </div>
          </div>
          <div class="step" id="step2" onclick="setStep(2)">
            <div class="num">2</div>
            <div>
              <b>Create RFQ</b><div class="smallmuted">Scope + timeline</div>
            </div>
          </div>
          <div class="step" id="step3" onclick="setStep(3)">
            <div class="num">3</div>
            <div>
              <b>Invite Vendors</b><div class="smallmuted">Verified network</div>
            </div>
          </div>
          <div class="step" id="step4" onclick="setStep(4)">
            <div class="num">4</div>
            <div>
              <b>Collect Bids</b><div class="smallmuted">Rates + terms</div>
            </div>
          </div>
          <div class="step" id="step5" onclick="setStep(5)">
            <div class="num">5</div>
            <div>
              <b>Compare & Select</b><div class="smallmuted">Rate analysis</div>
            </div>
          </div>
        </div>

        <div class="divider"></div>

        <!-- Step panels -->
        <div id="panel1">
          <div class="row g-3">
            <div class="col-lg-7">
              <div class="hintbox">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="badge-soft"><i class="bi bi-upload"></i> BOQ Upload</span>
                  <span class="smallmuted">This becomes your RFQ line items</span>
                </div>
                <div class="row g-2">
                  <div class="col-md-6">
                    <label class="form-label smallmuted">BOQ Type</label>
                    <select class="form-select">
                      <option>RCC Flooring BOQ</option>
                      <option>Steel & TMT BOQ</option>
                      <option>MEP Procurement BOQ</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label smallmuted">Upload File</label>
                    <input class="form-control" type="file" />
                    <div class="smallmuted mt-1">Demo: file not actually uploaded (prototype).</div>
                  </div>
                </div>
                <div class="mt-3 d-flex gap-2 flex-wrap">
                  <button class="btn-ck" onclick="markDone(1); toast('BOQ uploaded (demo).');">
                    <i class="bi bi-check2"></i> Confirm BOQ Upload
                  </button>
                  <button class="btn-soft" onclick="showBOQ()">
                    <i class="bi bi-eye"></i> View Sample BOQ
                  </button>
                </div>
              </div>
            </div>
            <div class="col-lg-5">
              <div class="cardx p-3">
                <h6 class="mb-1" style="font-weight:900;color:var(--navy)">Why this matters (MSME view)</h6>
                <div class="smallmuted">
                  BOQ upload ensures vendors quote on <b>same items</b> → clean comparison → fewer disputes.
                </div>
                <div class="divider"></div>
                <div class="smallmuted">
                  <b>Value you sell:</b><br/>
                  • Standard items & units<br/>
                  • No missing scope<br/>
                  • Faster RFQ creation
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="panel2" style="display:none;">
          <div class="row g-3">
            <div class="col-lg-7">
              <div class="hintbox">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="badge-soft"><i class="bi bi-clipboard2-plus"></i> Create RFQ</span>
                  <span class="smallmuted">Define timeline & terms</span>
                </div>

                <div class="row g-2">
                  <div class="col-md-6">
                    <label class="form-label smallmuted">RFQ Title</label>
                    <input class="form-control" value="Warehouse RCC Flooring – BOQ Based" />
                  </div>
                  <div class="col-md-3">
                    <label class="form-label smallmuted">Bid Deadline</label>
                    <input class="form-control" type="date" />
                  </div>
                  <div class="col-md-3">
                    <label class="form-label smallmuted">Payment Terms</label>
                    <select class="form-select">
                      <option>30% Advance, Bill-to-Bill</option>
                      <option>Bill-to-Bill (No advance)</option>
                      <option>Milestone Based</option>
                    </select>
                  </div>
                </div>

                <div class="mt-3 d-flex gap-2 flex-wrap">
                  <button class="btn-ck" onclick="markDone(2); toast('RFQ created (demo).');">
                    <i class="bi bi-check2"></i> Create RFQ
                  </button>
                  <button class="btn-soft" onclick="toast('Scope sheet exported (demo).')">
                    <i class="bi bi-filetype-pdf"></i> Export Scope Sheet
                  </button>
                </div>
              </div>
            </div>

            <div class="col-lg-5">
              <div class="cardx p-3">
                <h6 class="mb-1" style="font-weight:900;color:var(--navy)">RFQ Summary</h6>
                <div class="smallmuted">
                  RFQ ID: <b>RFQ-1021</b><br/>
                  Items: <b>24</b><br/>
                  Vendors invited: <b id="invitedCount">0</b>
                </div>
                <div class="divider"></div>
                <div class="smallmuted">
                  Next: Invite vendors from ConstructKaro verified network.
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="panel3" style="display:none;">
          <div class="row g-3">
            <div class="col-lg-7">
              <div class="hintbox">
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="badge-soft"><i class="bi bi-people"></i> Invite Vendors</span>
                  <span class="smallmuted">Select verified vendors based on location & category</span>
                </div>

                <div class="row g-2">
                  <div class="col-md-4">
                    <label class="form-label smallmuted">Category</label>
                    <select class="form-select" id="catSelect">
                      <option>RCC Flooring</option>
                      <option>Steel Supply</option>
                      <option>RMC Supply</option>
                      <option>MEP Contractor</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label smallmuted">Location</label>
                    <select class="form-select">
                      <option>Pune</option>
                      <option>Mumbai</option>
                      <option>Thane</option>
                      <option>Navi Mumbai</option>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label smallmuted">Filter</label>
                    <select class="form-select">
                      <option>Verified Only</option>
                      <option>Top Rated</option>
                      <option>Fast Response</option>
                    </select>
                  </div>
                </div>

                <div class="divider"></div>

                <div class="table-responsive">
                  <table class="table align-middle mb-0">
                    <thead>
                      <tr>
                        <th>Vendor</th>
                        <th>Rating</th>
                        <th>Last Response</th>
                        <th class="text-end">Invite</th>
                      </tr>
                    </thead>
                    <tbody id="vendorInviteTable">
                      <!-- injected -->
                    </tbody>
                  </table>
                </div>

                <div class="mt-3 d-flex gap-2 flex-wrap">
                  <button class="btn-ck" onclick="markDone(3); toast('Vendors invited (demo).');">
                    <i class="bi bi-send"></i> Send Invites
                  </button>
                  <button class="btn-soft" onclick="toast('WhatsApp / Email invites sent (demo).')">
                    <i class="bi bi-whatsapp"></i> Notify Vendors
                  </button>
                </div>
              </div>
            </div>

            <div class="col-lg-5">
              <div class="cardx p-3">
                <h6 class="mb-1" style="font-weight:900;color:var(--navy)">Invited Vendors</h6>
                <div class="smallmuted">Selected vendors can bid on the BOQ line items.</div>
                <div class="divider"></div>
                <ul class="smallmuted mb-0" id="invitedList"></ul>
              </div>
            </div>
          </div>
        </div>

        <div id="panel4" style="display:none;">
          <div class="row g-3">
            <div class="col-lg-7">
              <div class="hintbox">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge-soft"><i class="bi bi-cash-coin"></i> Bidding Room</span>
                    <span class="smallmuted">Rates arriving in real-time (demo)</span>
                  </div>
                  <button class="btn-soft" onclick="simulateBid()"><i class="bi bi-plus-circle"></i> Simulate New Bid</button>
                </div>

                <div class="table-responsive">
                  <table class="table align-middle mb-0">
                    <thead>
                      <tr>
                        <th>Vendor</th>
                        <th>Item</th>
                        <th>Quoted Rate</th>
                        <th>Terms</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="bidTable">
                      <!-- injected -->
                    </tbody>
                  </table>
                </div>

                <div class="mt-3 d-flex gap-2 flex-wrap">
                  <button class="btn-ck" onclick="markDone(4); toast('Bids collected (demo).');">
                    <i class="bi bi-check2"></i> Lock Bids
                  </button>
                  <button class="btn-soft" onclick="toast('Clarifications requested (demo).')">
                    <i class="bi bi-chat-dots"></i> Ask Clarification
                  </button>
                </div>

              </div>
            </div>

            <div class="col-lg-5">
              <div class="cardx p-3">
                <h6 class="mb-1" style="font-weight:900;color:var(--navy)">Bid Health</h6>
                <div class="smallmuted">Auto checks for missing items & abnormal pricing.</div>
                <div class="divider"></div>
                <div class="smallmuted">
                  • Missing items: <b id="missingItems">0</b><br/>
                  • Abnormal rates flagged: <b id="flaggedRates">1</b><br/>
                  • Vendors responded: <b id="vendorsResponded">3</b>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div id="panel5" style="display:none;">
          <div class="row g-3">
            <div class="col-lg-8">
              <div class="hintbox">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-2">
                  <div class="d-flex align-items-center gap-2">
                    <span class="badge-soft"><i class="bi bi-bar-chart-line"></i> Bid Comparison</span>
                    <span class="smallmuted">Compare vendor totals and select winner</span>
                  </div>
                  <button class="btn-ck" onclick="selectWinner()"><i class="bi bi-award"></i> Select Winner</button>
                </div>

                <div class="table-responsive">
                  <table class="table align-middle mb-0">
                    <thead>
                      <tr>
                        <th>Vendor</th>
                        <th>Total Quote</th>
                        <th>Delivery / Timeline</th>
                        <th>Quality / Past</th>
                        <th>Score</th>
                        <th class="text-end">Action</th>
                      </tr>
                    </thead>
                    <tbody id="compareTable"></tbody>
                  </table>
                </div>

                <div class="divider"></div>
                <div class="d-flex gap-2 flex-wrap">
                  <button class="btn-soft" onclick="toast('Rate analysis exported (demo).')"><i class="bi bi-download"></i> Export Analysis</button>
                  <button class="btn-soft" onclick="toast('Approval sent to Director (demo).')"><i class="bi bi-shield-check"></i> Send for Approval</button>
                </div>
              </div>
            </div>

            <div class="col-lg-4">
              <div class="cardx p-3">
                <h6 class="mb-1" style="font-weight:900;color:var(--navy)">Winner</h6>
                <div class="smallmuted">Once selected, PO can be generated.</div>
                <div class="divider"></div>
                <div class="smallmuted">
                  Selected: <b id="winnerName">Not selected</b><br/>
                  Expected savings: <b id="winnerSavings">—</b>
                </div>
                <div class="divider"></div>
                <button class="btn-ck w-100" onclick="go('po'); toast('Moving to PO module...');">
                  <i class="bi bi-receipt-cutoff"></i> Generate PO
                </button>
              </div>
            </div>

          </div>
        </div>

      </div>
    </section>
    <script>
  let currentStep = 1;
  const totalSteps = 5;
  const doneSteps = new Set();

  function showPanel(step){
    // hide all panels
    for(let i=1; i<=totalSteps; i++){
      const panel = document.getElementById('panel'+i);
      if(panel) panel.style.display = (i === step) ? 'block' : 'none';

      const stepEl = document.getElementById('step'+i);
      if(stepEl) stepEl.classList.toggle('active', i === step);
    }
  }

  function setStep(step){
    if(step < 1) step = 1;
    if(step > totalSteps) step = totalSteps;
    currentStep = step;
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

    for(let i=1; i<=totalSteps; i++){
      const stepEl = document.getElementById('step'+i);
      if(stepEl) stepEl.classList.remove('done');
    }

    showPanel(1);
    toast('Flow reset (demo).');
  }

  function markDone(step){
    doneSteps.add(step);
    const stepEl = document.getElementById('step'+step);
    if(stepEl) stepEl.classList.add('done');
  }

  // Optional simple toast (if you don't already have one)
  function toast(msg){
    // If you already have toast() in your project, remove this.
    console.log(msg);
  }

  // On page load show only panel1
  document.addEventListener('DOMContentLoaded', () => {
    showPanel(1);
  });
</script>
@endsection