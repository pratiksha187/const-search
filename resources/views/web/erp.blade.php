<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>ConstructKaro ERP • Procurement Prototype</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    :root{
      --navy:#1c2c3e;
      --orange:#f25c05;
      --bg:#f6f8fb;
      --card:#ffffff;
      --muted:#64748b;
      --line:#e5e7eb;
    }
    body{ background:var(--bg); font-family:system-ui,-apple-system,Segoe UI,Roboto,Inter,Arial,sans-serif; }
    .app{
      display:grid;
      grid-template-columns: 280px 1fr;
      min-height:100vh;
    }
    .sidebar{
      background:linear-gradient(180deg, rgba(28,44,62,1), rgba(15,23,42,1));
      color:#fff;
      padding:18px 14px;
      position:sticky; top:0; height:100vh;
      overflow:auto;
    }
    .brand{
      display:flex; align-items:center; gap:10px;
      padding:10px 10px; border-radius:14px;
      background:rgba(255,255,255,.06);
      margin-bottom:16px;
    }
    .brand .logo{
      width:38px; height:38px; border-radius:12px;
      background:rgba(242,92,5,.18);
      display:flex; align-items:center; justify-content:center;
      border:1px solid rgba(242,92,5,.35);
    }
    .nav-pill{
      display:flex; align-items:center; justify-content:space-between;
      gap:10px; padding:10px 12px; border-radius:14px;
      color:#e2e8f0; text-decoration:none;
      margin:6px 0;
      background:transparent;
      border:1px solid rgba(255,255,255,.06);
      transition:.15s ease;
      cursor:pointer;
    }
    .nav-pill:hover{ background:rgba(255,255,255,.07); }
    .nav-pill.active{
      background:rgba(242,92,5,.14);
      border-color: rgba(242,92,5,.35);
      color:#fff;
    }
    .nav-pill .left{ display:flex; align-items:center; gap:10px; }
    .nav-pill small{
      background:rgba(255,255,255,.10);
      border:1px solid rgba(255,255,255,.12);
      padding:2px 8px; border-radius:99px;
      font-size:11px;
    }
    .content{
      padding:18px 18px 40px;
    }
    .topbar{
      background:var(--card);
      border:1px solid var(--line);
      border-radius:18px;
      padding:14px 16px;
      display:flex; align-items:center; justify-content:space-between; gap:12px;
      box-shadow:0 10px 30px rgba(2,6,23,.06);
      position:sticky; top:12px; z-index:5;
    }
    .title h5{ margin:0; color:var(--navy); font-weight:800; }
    .title .sub{ color:var(--muted); font-size:13px; }
    .chip{
      display:inline-flex; align-items:center; gap:8px;
      padding:8px 12px; border-radius:999px;
      border:1px solid var(--line);
      background:#fff;
      color:var(--navy);
      font-weight:600; font-size:13px;
    }
    .chip .dot{
      width:8px; height:8px; border-radius:99px; background:var(--orange);
      box-shadow:0 0 0 4px rgba(242,92,5,.15);
    }
    .cardx{
      background:var(--card);
      border:1px solid var(--line);
      border-radius:18px;
      box-shadow:0 10px 30px rgba(2,6,23,.06);
    }
    .kpi{
      padding:16px;
    }
    .kpi .label{ color:var(--muted); font-size:12px; font-weight:700; }
    .kpi .value{ color:var(--navy); font-size:22px; font-weight:900; margin-top:6px; }
    .kpi .hint{ color:var(--muted); font-size:12px; margin-top:6px; }
    .btn-ck{
      background:var(--orange); border:none; color:#fff;
      border-radius:14px; padding:10px 14px; font-weight:800;
    }
    .btn-ck:hover{ background:#e65200; color:#fff; }
    .btn-soft{
      background:#fff; border:1px solid var(--line); color:var(--navy);
      border-radius:14px; padding:10px 14px; font-weight:800;
    }
    .stepbar{
      display:flex; flex-wrap:wrap; gap:10px;
      margin-top:14px;
    }
    .step{
      display:flex; align-items:center; gap:10px;
      padding:10px 12px;
      border-radius:16px;
      border:1px dashed #dbe3ef;
      background:#fff;
      cursor:pointer;
      user-select:none;
    }
    .step .num{
      width:28px; height:28px; border-radius:12px;
      background:rgba(28,44,62,.08);
      display:flex; align-items:center; justify-content:center;
      font-weight:900; color:var(--navy);
    }
    .step.done{ border-style:solid; border-color: rgba(16,185,129,.25); }
    .step.done .num{ background:rgba(16,185,129,.14); }
    .step.active{
      border-style:solid;
      border-color: rgba(242,92,5,.35);
      box-shadow:0 12px 30px rgba(242,92,5,.12);
    }
    .table thead th{
      font-size:12px; text-transform:uppercase; letter-spacing:.02em;
      color:var(--muted);
      background:#f8fafc !important;
    }
    .badge-soft{
      background:rgba(28,44,62,.08);
      border:1px solid rgba(28,44,62,.12);
      color:var(--navy);
      border-radius:999px;
      padding:6px 10px;
      font-weight:800;
    }
    .badge-ok{
      background:rgba(16,185,129,.14);
      border:1px solid rgba(16,185,129,.25);
      color:#065f46;
    }
    .badge-warn{
      background:rgba(245,158,11,.14);
      border:1px solid rgba(245,158,11,.25);
      color:#92400e;
    }
    .badge-danger{
      background:rgba(239,68,68,.12);
      border:1px solid rgba(239,68,68,.22);
      color:#991b1b;
    }
    .section{ display:none; }
    .section.active{ display:block; }
    .hintbox{
      background:linear-gradient(135deg, rgba(242,92,5,.14), rgba(255,255,255,1));
      border:1px solid rgba(242,92,5,.22);
      border-radius:18px;
      padding:14px 16px;
    }
    .form-control, .form-select{ border-radius:14px; }
    .modal-content{ border-radius:18px; }
    .smallmuted{ color:var(--muted); font-size:13px; }
    .divider{ height:1px; background:var(--line); margin:14px 0; }
  </style>
</head>

<body>
<div class="app">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="brand">
      <div class="logo"><i class="bi bi-box-seam-fill" style="color:var(--orange)"></i></div>
      <div>
        <div style="font-weight:900; line-height:1;">ConstructKaro ERP</div>
        <div style="opacity:.8; font-size:12px;">Procurement Prototype</div>
      </div>
    </div>

    <div class="small" style="opacity:.85; margin:8px 6px 10px;">MAIN</div>

    <a class="nav-pill active" data-nav="dash">
      <div class="left"><i class="bi bi-speedometer2"></i> Dashboard</div>
      <small>Live</small>
    </a>

    <a class="nav-pill" data-nav="projects">
      <div class="left"><i class="bi bi-building"></i> Projects</div>
      <small id="projCount">2</small>
    </a>

    <a class="nav-pill" data-nav="sourcing">
      <div class="left"><i class="bi bi-clipboard2-data"></i> BOQ → RFQ → Bids</div>
      <small>Flow</small>
    </a>

    <a class="nav-pill" data-nav="po">
      <div class="left"><i class="bi bi-receipt-cutoff"></i> PO / GRN / Invoice</div>
      <small>3-way</small>
    </a>

    <div class="small" style="opacity:.85; margin:14px 6px 10px;">ADMIN</div>

    <a class="nav-pill" data-nav="vendors">
      <div class="left"><i class="bi bi-people"></i> Vendor Network</div>
      <small>6</small>
    </a>

    <a class="nav-pill" data-nav="settings">
      <div class="left"><i class="bi bi-gear"></i> Users & Roles</div>
      <small>RBAC</small>
    </a>

    <div class="divider"></div>
    <div class="smallmuted px-2">
      Tip: Click the "Flow Steps" chips inside <b>BOQ → RFQ → Bids</b> to simulate how your platform works.
    </div>
  </aside>

  <!-- CONTENT -->
  <main class="content">

    <!-- TOPBAR -->
    <div class="topbar">
      <div class="title">
        <h5 id="pageTitle">Dashboard</h5>
        <div class="sub" id="pageSub">High-level view of procurement activity</div>
      </div>
      <div class="d-flex align-items-center gap-2 flex-wrap">
        <span class="chip"><span class="dot"></span> Pro Plan • ₹3,000/user/mo</span>
        <button class="btn-soft" data-bs-toggle="modal" data-bs-target="#helpModal">
          <i class="bi bi-question-circle"></i> How this works
        </button>
        <button class="btn-ck" id="quickStartBtn">
          <i class="bi bi-lightning-charge"></i> Quick Start Demo
        </button>
      </div>
    </div>

    <!-- DASH -->
    <section class="section active mt-3" id="sec-dash">
      <div class="row g-3">
        <div class="col-lg-3 col-md-6">
          <div class="cardx kpi">
            <div class="label">Active Projects</div>
            <div class="value" id="kpiProjects">2</div>
            <div class="hint">Civil + Industrial</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="cardx kpi">
            <div class="label">Open RFQs</div>
            <div class="value" id="kpiRfqs">1</div>
            <div class="hint">Waiting for bids</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="cardx kpi">
            <div class="label">Bids Received</div>
            <div class="value" id="kpiBids">8</div>
            <div class="hint">Across 3 vendors</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="cardx kpi">
            <div class="label">Estimated Savings</div>
            <div class="value" id="kpiSavings">₹1.42L</div>
            <div class="hint">Compared to last rate</div>
          </div>
        </div>

        <div class="col-lg-8">
          <div class="cardx p-3">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
              <div>
                <h6 class="mb-0" style="font-weight:900;color:var(--navy)">Today's Procurement Activity</h6>
                <div class="smallmuted">What changed since last login</div>
              </div>
              <button class="btn-ck" onclick="go('sourcing'); setStep(1);">
                <i class="bi bi-arrow-right"></i> Continue RFQ Flow
              </button>
            </div>
            <div class="divider"></div>

            <div class="row g-3">
              <div class="col-md-6">
                <div class="hintbox">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge-soft badge-warn"><i class="bi bi-clock-history"></i> Pending</span>
                    <b>RFQ #RFQ-1021</b>
                  </div>
                  <div class="smallmuted">BOQ uploaded for "Warehouse Flooring RCC".</div>
                  <div class="smallmuted">3 vendors invited • 8 bids received.</div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="hintbox">
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge-soft badge-ok"><i class="bi bi-check2-circle"></i> Approved</span>
                    <b>PO #PO-7788</b>
                  </div>
                  <div class="smallmuted">Steel TMT purchase approved by Director.</div>
                  <div class="smallmuted">GRN pending at site store.</div>
                </div>
              </div>
            </div>

            <div class="divider"></div>
            <div class="smallmuted">
              This prototype simulates your SaaS flow: <b>BOQ → RFQ → Bids → Comparison → PO → GRN → Invoice</b>.
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="cardx p-3">
            <h6 class="mb-1" style="font-weight:900;color:var(--navy)">Quick Actions</h6>
            <div class="smallmuted mb-3">One-click actions MSMEs need</div>

            <div class="d-grid gap-2">
              <button class="btn-soft" onclick="go('projects')"><i class="bi bi-plus-circle"></i> Create Project</button>
              <button class="btn-soft" onclick="go('sourcing'); setStep(1);"><i class="bi bi-upload"></i> Upload BOQ</button>
              <button class="btn-soft" onclick="go('sourcing'); setStep(3);"><i class="bi bi-megaphone"></i> Invite Vendors</button>
              <button class="btn-soft" onclick="go('po')"><i class="bi bi-receipt"></i> Create Purchase Order</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- PROJECTS -->
    <section class="section mt-3" id="sec-projects">
      <div class="cardx p-3">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
          <div>
            <h6 class="mb-0" style="font-weight:900;color:var(--navy)">Projects</h6>
            <div class="smallmuted">Every RFQ and PO is tagged to a project</div>
          </div>
          <button class="btn-ck" data-bs-toggle="modal" data-bs-target="#projectModal">
            <i class="bi bi-plus"></i> New Project
          </button>
        </div>
        <div class="divider"></div>

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>Project</th>
                <th>Type</th>
                <th>Location</th>
                <th>Budget</th>
                <th>Status</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>
            <tbody id="projectTable">
              <tr>
                <td><b>CK • Warehouse RCC Flooring</b><div class="smallmuted">Proj-2001</div></td>
                <td>Industrial</td>
                <td>Pune</td>
                <td>₹68,00,000</td>
                <td><span class="badge-soft badge-warn">Active</span></td>
                <td class="text-end">
                  <button class="btn-soft btn-sm" onclick="go('sourcing'); setProject('CK • Warehouse RCC Flooring'); setStep(1);">
                    Open Procurement
                  </button>
                </td>
              </tr>
              <tr>
                <td><b>CK • Residential Builder Purchase</b><div class="smallmuted">Proj-2002</div></td>
                <td>Builder</td>
                <td>Thane</td>
                <td>₹1,20,00,000</td>
                <td><span class="badge-soft">Planning</span></td>
                <td class="text-end">
                  <button class="btn-soft btn-sm" onclick="go('sourcing'); setProject('CK • Residential Builder Purchase'); setStep(1);">
                    Open Procurement
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </div>
    </section>

    <!-- SOURCING FLOW -->
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

    <!-- PO / GRN / INVOICE -->
    <section class="section mt-3" id="sec-po">
      <div class="cardx p-3">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
          <div>
            <h6 class="mb-0" style="font-weight:900;color:var(--navy)">PO / GRN / Invoice Matching</h6>
            <div class="smallmuted">Basic construction procurement controls (MSME friendly)</div>
          </div>
          <div class="d-flex gap-2">
            <button class="btn-soft" onclick="toast('PO approved (demo).')"><i class="bi bi-check2-circle"></i> Approve PO</button>
            <button class="btn-ck" onclick="toast('GRN created (demo).')"><i class="bi bi-box-arrow-in-down"></i> Create GRN</button>
          </div>
        </div>
        <div class="divider"></div>

        <div class="row g-3">
          <div class="col-lg-6">
            <div class="hintbox">
              <b>Purchase Order (PO-7788)</b>
              <div class="smallmuted">Vendor: <b id="poVendor">Shree RCC Works</b> • Project: <b id="poProject">CK • Warehouse RCC Flooring</b></div>
              <div class="divider"></div>
              <div class="table-responsive">
                <table class="table align-middle mb-0">
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Qty</th>
                      <th>Rate</th>
                      <th>Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr><td>RCC M20 (Labour + Shuttering)</td><td>120</td><td>₹1,850</td><td>₹2,22,000</td></tr>
                    <tr><td>Rebar fixing</td><td>120</td><td>₹390</td><td>₹46,800</td></tr>
                    <tr><td>Surface finishing</td><td>120</td><td>₹210</td><td>₹25,200</td></tr>
                  </tbody>
                </table>
              </div>
              <div class="divider"></div>
              <div class="d-flex justify-content-between">
                <span class="smallmuted">PO Total</span>
                <b>₹2,94,000</b>
              </div>
            </div>
          </div>

          <div class="col-lg-6">
            <div class="cardx p-3">
              <h6 class="mb-1" style="font-weight:900;color:var(--navy)">3-Way Match</h6>
              <div class="smallmuted">PO ↔ GRN ↔ Invoice</div>
              <div class="divider"></div>

              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <b>GRN</b><div class="smallmuted">Received at site store</div>
                </div>
                <span class="badge-soft badge-warn">Pending</span>
              </div>
              <div class="divider"></div>
              <div class="d-flex justify-content-between align-items-center">
                <div>
                  <b>Invoice</b><div class="smallmuted">Vendor submitted invoice</div>
                </div>
                <span class="badge-soft">Not uploaded</span>
              </div>

              <div class="divider"></div>
              <div class="d-grid gap-2">
                <button class="btn-soft" onclick="toast('Invoice uploaded (demo).')"><i class="bi bi-file-earmark-arrow-up"></i> Upload Invoice</button>
                <button class="btn-ck" onclick="toast('Payment approved (demo).')"><i class="bi bi-cash-stack"></i> Approve Payment</button>
              </div>

              <div class="divider"></div>
              <div class="smallmuted">
                <b>MSME-friendly:</b> simple approvals + clear audit trail without heavy SAP complexity.
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

    <!-- VENDORS -->
    <section class="section mt-3" id="sec-vendors">
      <div class="cardx p-3">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
          <div>
            <h6 class="mb-0" style="font-weight:900;color:var(--navy)">Vendor Network</h6>
            <div class="smallmuted">Where buyers find vendors (ConstructKaro advantage)</div>
          </div>
          <button class="btn-ck" onclick="toast('Vendor invited to platform (demo).')"><i class="bi bi-person-plus"></i> Add Vendor</button>
        </div>
        <div class="divider"></div>

        <div class="table-responsive">
          <table class="table align-middle mb-0">
            <thead>
              <tr>
                <th>Vendor</th>
                <th>Category</th>
                <th>Location</th>
                <th>Verified</th>
                <th>Rating</th>
                <th class="text-end">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><b>Shree RCC Works</b><div class="smallmuted">GST + PAN on file</div></td>
                <td>RCC Flooring</td><td>Pune</td>
                <td><span class="badge-soft badge-ok">Yes</span></td>
                <td>4.6</td>
                <td class="text-end"><button class="btn-soft btn-sm" onclick="toast('Vendor profile opened (demo).')">View</button></td>
              </tr>
              <tr>
                <td><b>Metro Build Services</b><div class="smallmuted">Experience: 8 yrs</div></td>
                <td>RCC Flooring</td><td>Mumbai</td>
                <td><span class="badge-soft badge-ok">Yes</span></td>
                <td>4.4</td>
                <td class="text-end"><button class="btn-soft btn-sm" onclick="toast('Vendor profile opened (demo).')">View</button></td>
              </tr>
              <tr>
                <td><b>Budget Civil Team</b><div class="smallmuted">Basic docs pending</div></td>
                <td>RCC Flooring</td><td>Thane</td>
                <td><span class="badge-soft badge-warn">In Review</span></td>
                <td>4.0</td>
                <td class="text-end"><button class="btn-soft btn-sm" onclick="toast('Verification requested (demo).')">Request Docs</button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- SETTINGS -->
    <section class="section mt-3" id="sec-settings">
      <div class="cardx p-3">
        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
          <div>
            <h6 class="mb-0" style="font-weight:900;color:var(--navy)">Users & Roles (Billing logic)</h6>
            <div class="smallmuted">Charge only for "action users" — keep view-only free</div>
          </div>
          <button class="btn-ck" onclick="toast('User created (demo).')"><i class="bi bi-person-plus"></i> Add User</button>
        </div>
        <div class="divider"></div>

        <div class="row g-3">
          <div class="col-lg-7">
            <div class="table-responsive">
              <table class="table align-middle mb-0">
                <thead>
                  <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Type</th>
                    <th>Billing</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><b>Admin</b><div class="smallmuted">owner@company.in</div></td>
                    <td>Admin</td>
                    <td>Action User</td>
                    <td><span class="badge-soft badge-ok">Paid</span></td>
                    <td class="text-end"><button class="btn-soft btn-sm" onclick="toast('Permissions opened (demo).')">Permissions</button></td>
                  </tr>
                  <tr>
                    <td><b>Procurement Head</b><div class="smallmuted">proc@company.in</div></td>
                    <td>Procurement</td>
                    <td>Action User</td>
                    <td><span class="badge-soft badge-ok">Paid</span></td>
                    <td class="text-end"><button class="btn-soft btn-sm" onclick="toast('Permissions opened (demo).')">Permissions</button></td>
                  </tr>
                  <tr>
                    <td><b>Store Keeper</b><div class="smallmuted">store@company.in</div></td>
                    <td>Store</td>
                    <td>Action User</td>
                    <td><span class="badge-soft badge-ok">Paid</span></td>
                    <td class="text-end"><button class="btn-soft btn-sm" onclick="toast('Permissions opened (demo).')">Permissions</button></td>
                  </tr>
                  <tr>
                    <td><b>Site Engineer</b><div class="smallmuted">site@company.in</div></td>
                    <td>Viewer</td>
                    <td>View-Only</td>
                    <td><span class="badge-soft">Free</span></td>
                    <td class="text-end"><button class="btn-soft btn-sm" onclick="toast('Viewer role set (demo).')">Set Role</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="hintbox">
              <b>Recommended billing rules</b>
              <div class="divider"></div>
              <div class="smallmuted">
                • Charge only for <b>Action Users</b> (create/approve PO, RFQ, bids).<br/>
                • Keep <b>View-only</b> users free (site team).<br/>
                • Minimum billing: <b>3 users</b> (₹9,000/month + GST).<br/>
                • Add fair-use limits: RFQs/month, BOQ lines/month, storage.
              </div>
            </div>
          </div>
        </div>

      </div>
    </section>

  </main>
</div>

<!-- Help Modal -->
<div class="modal fade" id="helpModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" style="font-weight:900;color:var(--navy)">How your procurement platform works</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="smallmuted">
          <b>Flow:</b> BOQ Upload → RFQ → Invite Vendors → Collect Bids → Compare → Select Winner → Generate PO → GRN → Invoice Matching.<br/><br/>
          <b>MSME-friendly:</b> simple approvals, clear comparisons, and vendor discovery built-in (ConstructKaro network).
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn-soft" data-bs-dismiss="modal">Close</button>
        <button class="btn-ck" data-bs-dismiss="modal" onclick="go('sourcing'); setStep(1);">Start Demo</button>
      </div>
    </div>
  </div>
</div>

<!-- Create Project Modal -->
<div class="modal fade" id="projectModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" style="font-weight:900;color:var(--navy)">Create Project (Demo)</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label class="form-label smallmuted">Project Name</label>
        <input class="form-control mb-2" id="newProjName" placeholder="e.g., MIDC Shed Procurement"/>
        <label class="form-label smallmuted">Type</label>
        <select class="form-select mb-2" id="newProjType">
          <option>Industrial</option>
          <option>Builder</option>
          <option>Contractor</option>
        </select>
        <label class="form-label smallmuted">Location</label>
        <input class="form-control" id="newProjLoc" placeholder="e.g., Pune"/>
      </div>
      <div class="modal-footer">
        <button class="btn-soft" data-bs-dismiss="modal">Cancel</button>
        <button class="btn-ck" data-bs-dismiss="modal" onclick="addProject()">Create</button>
      </div>
    </div>
  </div>
</div>

<!-- Toast -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
  <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <strong class="me-auto">ConstructKaro ERP</strong>
      <small>Demo</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
    </div>
    <div class="toast-body" id="toastMsg">Done.</div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // ---------- STATE ----------
  const state = {
    nav: "dash",
    step: 1,
    project: "CK • Warehouse RCC Flooring",
    invited: new Set(),
    bids: [
      {vendor:"Shree RCC Works", item:"RCC M20 Labour", rate:1850, terms:"30% adv", status:"Submitted"},
      {vendor:"Metro Build Services", item:"RCC M20 Labour", rate:1920, terms:"Bill-to-bill", status:"Submitted"},
      {vendor:"Budget Civil Team", item:"RCC M20 Labour", rate:1760, terms:"40% adv", status:"Flagged"},
      {vendor:"Shree RCC Works", item:"Rebar Fixing", rate:390, terms:"30% adv", status:"Submitted"},
      {vendor:"Metro Build Services", item:"Rebar Fixing", rate:410, terms:"Bill-to-bill", status:"Submitted"},
      {vendor:"Budget Civil Team", item:"Rebar Fixing", rate:340, terms:"40% adv", status:"Flagged"},
      {vendor:"Shree RCC Works", item:"Finishing", rate:210, terms:"30% adv", status:"Submitted"},
      {vendor:"Metro Build Services", item:"Finishing", rate:235, terms:"Bill-to-bill", status:"Submitted"}
    ],
    vendors: [
      {name:"Shree RCC Works", rating:4.6, response:"2 hrs"},
      {name:"Metro Build Services", rating:4.4, response:"5 hrs"},
      {name:"Budget Civil Team", rating:4.0, response:"1 day"},
    ],
    compare: [
      {vendor:"Shree RCC Works", total: 294000, timeline:"12 days", quality:"Good past work", score:88},
      {vendor:"Metro Build Services", total: 312500, timeline:"10 days", quality:"Strong team", score:86},
      {vendor:"Budget Civil Team", total: 268000, timeline:"15 days", quality:"Docs pending", score:72},
    ],
    winner: null
  };

  // ---------- NAV ----------
  const navLinks = document.querySelectorAll(".nav-pill");
  navLinks.forEach(a=>{
    a.addEventListener("click", ()=>{
      navLinks.forEach(x=>x.classList.remove("active"));
      a.classList.add("active");
      go(a.dataset.nav);
    });
  });

  function go(key){
    state.nav = key;
    document.querySelectorAll(".section").forEach(s=>s.classList.remove("active"));
    document.getElementById("sec-"+key).classList.add("active");

    const meta = {
      dash: ["Dashboard","High-level view of procurement activity"],
      projects: ["Projects","Organize procurement project-wise"],
      sourcing: ["BOQ → RFQ → Bids","Simulate sourcing & bidding like Ariba"],
      po: ["PO / GRN / Invoice","Simple 3-way match controls"],
      vendors: ["Vendor Network","Find and invite verified vendors"],
      settings: ["Users & Roles","Define paid 'action users' vs free viewers"]
    };
    document.getElementById("pageTitle").innerText = meta[key][0];
    document.getElementById("pageSub").innerText = meta[key][1];

    if(key==="sourcing") renderAll();
  }

  // ---------- FLOW STEPS ----------
  function setStep(n){
    state.step = n;
    for(let i=1;i<=5;i++){
      const el = document.getElementById("step"+i);
      el.classList.remove("active");
    }
    document.getElementById("step"+n).classList.add("active");

    // panels
    for(let i=1;i<=5;i++){
      document.getElementById("panel"+i).style.display = (i===n) ? "block" : "none";
    }
  }

  function markDone(n){
    document.getElementById("step"+n).classList.add("done");
  }

  function nextStep(){
    const n = Math.min(5, state.step+1);
    setStep(n);
  }

  function resetFlow(){
    for(let i=1;i<=5;i++){
      document.getElementById("step"+i).classList.remove("done","active");
      document.getElementById("panel"+i).style.display = "none";
    }
    state.invited = new Set();
    state.winner = null;
    document.getElementById("winnerName").innerText = "Not selected";
    document.getElementById("winnerSavings").innerText = "—";
    document.getElementById("invitedCount").innerText = "0";
    document.getElementById("invitedList").innerHTML = "";
    setStep(1);
    renderAll();
  }

  // ---------- PROJECT ----------
  function setProject(name){
    state.project = name;
    document.getElementById("currentProject").innerText = name;
    document.getElementById("poProject").innerText = name;
  }

  // ---------- BOQ VIEW ----------
  function showBOQ(){
    toast("Sample BOQ opened (demo). Scroll below in your mind 😄");
  }

  // ---------- VENDORS INVITE ----------
  function renderVendorInvites(){
    const tbody = document.getElementById("vendorInviteTable");
    tbody.innerHTML = "";
    state.vendors.forEach(v=>{
      const invited = state.invited.has(v.name);
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><b>${v.name}</b><div class="smallmuted">Category match: ${document.getElementById("catSelect")?.value || "RCC Flooring"}</div></td>
        <td>${v.rating}</td>
        <td>${v.response}</td>
        <td class="text-end">
          <button class="btn ${invited ? "btn-soft" : "btn-ck"} btn-sm" onclick="toggleInvite('${v.name}')">
            ${invited ? "Invited" : "Invite"}
          </button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  function toggleInvite(name){
    if(state.invited.has(name)) state.invited.delete(name);
    else state.invited.add(name);

    document.getElementById("invitedCount").innerText = state.invited.size.toString();
    const list = document.getElementById("invitedList");
    list.innerHTML = "";
    Array.from(state.invited).forEach(x=>{
      const li = document.createElement("li");
      li.textContent = x;
      list.appendChild(li);
    });

    renderVendorInvites();
  }

  // ---------- BIDS ----------
  function renderBids(){
    const tbody = document.getElementById("bidTable");
    tbody.innerHTML = "";
    state.bids.forEach(b=>{
      const badge = b.status==="Flagged"
        ? `<span class="badge-soft badge-danger">Flagged</span>`
        : `<span class="badge-soft badge-ok">Submitted</span>`;
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><b>${b.vendor}</b></td>
        <td>${b.item}</td>
        <td><b>₹${b.rate.toLocaleString("en-IN")}</b></td>
        <td>${b.terms}</td>
        <td>${badge}</td>
      `;
      tbody.appendChild(tr);
    });

    document.getElementById("vendorsResponded").innerText = "3";
    document.getElementById("missingItems").innerText = "0";
    document.getElementById("flaggedRates").innerText = "1";
  }

  function simulateBid(){
    const v = ["Shree RCC Works","Metro Build Services","Budget Civil Team"][Math.floor(Math.random()*3)];
    const item = ["RCC M20 Labour","Rebar Fixing","Finishing"][Math.floor(Math.random()*3)];
    const base = item==="RCC M20 Labour" ? 1850 : item==="Rebar Fixing" ? 390 : 210;
    const variance = Math.floor((Math.random()*140) - 70);
    const rate = Math.max(1, base + variance);
    const status = (variance < -55) ? "Flagged" : "Submitted";
    state.bids.unshift({vendor:v, item, rate, terms:"Bill-to-bill", status});
    renderBids();
    toast("New bid received (demo).");
  }

  // ---------- COMPARE ----------
  function renderCompare(){
    const tbody = document.getElementById("compareTable");
    tbody.innerHTML = "";
    state.compare.forEach(c=>{
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td><b>${c.vendor}</b></td>
        <td><b>₹${c.total.toLocaleString("en-IN")}</b></td>
        <td>${c.timeline}</td>
        <td>${c.quality}</td>
        <td><span class="badge-soft">${c.score}</span></td>
        <td class="text-end">
          <button class="btn-soft btn-sm" onclick="pick('${c.vendor}')">Select</button>
        </td>
      `;
      tbody.appendChild(tr);
    });
  }

  function pick(vendor){
    state.winner = vendor;
    const best = state.compare.find(x=>x.vendor===vendor);
    const baseline = 312500;
    const savings = baseline - best.total;
    document.getElementById("winnerName").innerText = vendor;
    document.getElementById("winnerSavings").innerText = (savings>0 ? "₹"+savings.toLocaleString("en-IN") : "₹0");
    document.getElementById("poVendor").innerText = vendor;
    toast("Winner selected (demo).");
  }

  function selectWinner(){
    const sorted = [...state.compare].sort((a,b)=> b.score - a.score);
    pick(sorted[0].vendor);
  }

  // ---------- PROJECT ADD ----------
  function addProject(){
    const name = document.getElementById("newProjName").value || "New Project";
    const type = document.getElementById("newProjType").value;
    const loc  = document.getElementById("newProjLoc").value || "—";

    const tbody = document.getElementById("projectTable");
    const tr = document.createElement("tr");
    tr.innerHTML = `
      <td><b>${name}</b><div class="smallmuted">Proj-${Math.floor(Math.random()*9000+1000)}</div></td>
      <td>${type}</td>
      <td>${loc}</td>
      <td>₹—</td>
      <td><span class="badge-soft">Planning</span></td>
      <td class="text-end">
        <button class="btn-soft btn-sm" onclick="go('sourcing'); setProject('${name.replace(/'/g,"")}'); setStep(1);">Open Procurement</button>
      </td>
    `;
    tbody.prepend(tr);

    const n = parseInt(document.getElementById("kpiProjects").innerText,10) + 1;
    document.getElementById("kpiProjects").innerText = n.toString();
    document.getElementById("projCount").innerText = n.toString();
    toast("Project created (demo).");
  }

  // ---------- TOAST ----------
  function toast(msg){
    document.getElementById("toastMsg").innerText = msg;
    const t = new bootstrap.Toast(document.getElementById("liveToast"));
    t.show();
  }

  // ---------- QUICK START ----------
  document.getElementById("quickStartBtn").addEventListener("click", ()=>{
    go("sourcing");
    setStep(1);
    markDone(1);
    setStep(2);
    markDone(2);
    setStep(3);
    state.invited = new Set(["Shree RCC Works","Metro Build Services","Budget Civil Team"]);
    document.getElementById("invitedCount").innerText = "3";
    const list = document.getElementById("invitedList");
    list.innerHTML = "<li>Shree RCC Works</li><li>Metro Build Services</li><li>Budget Civil Team</li>";
    markDone(3);
    setStep(4);
    markDone(4);
    setStep(5);
    renderAll();
    toast("Quick demo loaded. Now click Select Winner.");
  });

  function renderAll(){
    document.getElementById("currentProject").innerText = state.project;
    document.getElementById("poProject").innerText = state.project;
    renderVendorInvites();
    renderBids();
    renderCompare();
  }

  // init
  renderAll();
</script>

</body>
</html>
