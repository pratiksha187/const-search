 @extends('layouts.employerapp')

@section('title', 'Vendor Network')

@section('page-title', 'Vendor Network')
@section('page-subtitle', 'Find and invite verified vendors')

@section('content')
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
    @endsection