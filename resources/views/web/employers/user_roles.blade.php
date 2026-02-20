 @extends('layouts.employerapp')

@section('title', 'Users & Roles')

@section('page-title', 'Users & Roles')
@section('page-subtitle', 'Define paid action users vs free viewers')

@section('content')
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

    @endsection