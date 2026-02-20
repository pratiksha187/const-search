@extends('layouts.employerapp')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'High-level view of procurement activity')

@section('content')
    <h4 class="mb-1">Welcome, {{ session('employer_name') }}</h4>
    <p class="smallmuted mb-0">{{ session('employer_email') }}</p>

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
@endsection
