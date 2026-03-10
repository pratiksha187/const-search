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
            <div class="value" id="kpiProjects">{{$countactiveprojects}}</div>
            <div class="hint">Civil + Industrial</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="cardx kpi">
            <div class="label">Open RFQs</div>
            <div class="value" id="kpiRfqs">{{$countrfqs}}</div>
            <div class="hint">Waiting for bids</div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6">
          <div class="cardx kpi">
            <div class="label">Bids Received</div>
            <div class="value" id="kpiBids">{{$countvendor_boq_replies}}</div>
            <div class="hint">Across vendors</div>
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
                        <div class="smallmuted">Latest live updates from your procurement workflow</div>
                    </div>

                    <a href="{{ route('erpproject') }}" class="btn-ck text-decoration-none">
                        <i class="bi bi-arrow-right"></i> Continue RFQ Flow
                    </a>
                </div>

                <div class="divider"></div>

                <div class="row g-3">

                    {{-- Latest RFQ --}}
                    <div class="col-md-6">
                        <div class="hintbox">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge-soft badge-warn">
                                    <i class="bi bi-clock-history"></i>
                                    {{ $latestRfq && !empty($latestRfq->status) ? ucfirst($latestRfq->status) : 'Pending' }}
                                </span>

                                <b>
                                    @if($latestRfq)
                                        RFQ #{{ $latestRfq->id }}
                                    @else
                                        No RFQ Found
                                    @endif
                                </b>
                            </div>

                            <div class="smallmuted">
                                @if($latestRfq)
                                    BOQ uploaded for
                                    "{{ $latestRfq->title ?? $latestRfq->rfq_title ?? $latestRfq->name ?? 'Untitled RFQ' }}".
                                @else
                                    No RFQ activity available yet.
                                @endif
                            </div>

                            <div class="smallmuted">
                                @if($latestRfq)
                                    {{ $latestRfqVendors }} vendors invited • {{ $latestRfqBids }} bids received.
                                @else
                                    No vendor activity yet.
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Latest PO --}}
                    <div class="col-md-6">
                        <div class="hintbox">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge-soft badge-ok">
                                    <i class="bi bi-check2-circle"></i>
                                    {{ $latestPo && !empty($latestPo->status) ? ucfirst($latestPo->status) : 'Approved' }}
                                </span>

                                <b>
                                    @if($latestPo)
                                        PO #{{ $latestPo->id }}
                                    @else
                                        No PO Found
                                    @endif
                                </b>
                            </div>

                            <div class="smallmuted">
                                @if($latestPo)
                                    {{ $latestPo->title ?? $latestPo->po_title ?? $latestPo->po_number ?? 'Purchase order available' }}.
                                @else
                                    No purchase order available yet.
                                @endif
                            </div>

                            <div class="smallmuted">
                                @if($latestPo)
                                    @if($latestPoGrnCount > 0)
                                        {{ $latestPoGrnCount }} GRN record(s) available.
                                    @else
                                        GRN pending at site store.
                                    @endif
                                @else
                                    No GRN activity available.
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <div class="divider"></div>
                <div class="smallmuted">
                    This live dashboard tracks your flow:
                    <b>BOQ → RFQ → Bids → Comparison → PO → GRN → Invoice</b>.
                </div>
            </div>
        </div>

        <!-- <div class="col-lg-4">
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
        </div> -->
        <div class="col-lg-4">
    <div class="cardx p-3">
        <h6 class="mb-1" style="font-weight:900;color:var(--navy)">Quick Actions</h6>
        <div class="smallmuted mb-3">One-click actions MSMEs need</div>

        <div class="d-grid gap-2">

            <a href="{{ route('erpproject') }}" class="btn-soft text-decoration-none">
                <i class="bi bi-plus-circle"></i> Create Project
            </a>

            <a href="{{ route('erpproject') }}" class="btn-soft text-decoration-none">
                <i class="bi bi-upload"></i> Upload BOQ
            </a>

            <a href="{{ route('erpproject') }}" class="btn-soft text-decoration-none">
                <i class="bi bi-megaphone"></i> Invite Vendors
            </a>

            

        </div>
    </div>
</div>
      </div>
    </section>
@endsection
