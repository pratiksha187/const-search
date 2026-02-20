 @extends('layouts.employerapp')

@section('title', 'PO / GRN / Invoice Matching')

@section('page-title', 'PO / GRN / Invoice Matching')
@section('page-subtitle', 'Simple 3-way match controls')

@section('content')
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
    @endsection