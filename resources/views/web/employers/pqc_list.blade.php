{{-- resources/views/web/employers/pqc_list.blade.php --}}
@extends('layouts.employerapp')

@section('title', 'PQC List')

@section('content')
<div class="container-fluid mt-4">

  <div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h4 class="fw-bold mb-0">PQC Submissions</h4>
    <div class="text-muted small">Project ID: {{ $projectId }}</div>
  </div>

  <div class="d-flex gap-2">
    {{-- ✅ BOQ/RFQ/BIDS PAGE BUTTON --}}
    <a href="{{ route('boq_rfq_bids', ['projectId' => $projectId]) }}"
       class="btn btn-primary">
      BOQ → RFQ → Bids
    </a>

    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">← Back</a>
  </div>
</div>

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Vendor</th>
              <th>Mobile</th>
              <th>Status</th>
              <th>Company Profile</th>
              <th>PQC</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($rows as $i => $r)
              <tr>
                <td>{{ $i+1 }}</td>

                <td>
                  <div class="fw-semibold">{{ $r->vendor_company ?? '-' }}</div>
                  <div class="text-muted small">{{ $r->vendor_name ?? '-' }}</div>
                </td>

                <td>{{ $r->vendor_mobile ?? '-' }}</td>

                <td>
                  <span class="badge
                    @if(($r->status ?? '') === 'submitted') bg-success
                    @elseif(($r->status ?? '') === 'draft') bg-warning text-dark
                    @else bg-secondary
                    @endif
                  ">
                    {{ ucfirst($r->status ?? 'na') }}
                  </span>
                </td>

                <td>
                  @if(!empty($r->company_profile_path))
                    <a class="btn btn-sm btn-outline-success"
                       href="{{ asset('storage/'.$r->company_profile_path) }}"
                       target="_blank">
                      View File
                    </a>
                  @else
                    <span class="text-muted small">Not uploaded</span>
                  @endif
                </td>

                <td>
                  @if(!empty($r->pqc_data))
                    <button type="button"
                            class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#pqcModal"
                            data-vendor="{{ $r->vendor_company ?? $r->vendor_name }}"
                            data-pqc='@json($r->pqc_data)'>
                    View PQC
                    </button>
                  @else
                    <span class="text-muted small">Not submitted</span>
                  @endif
                </td>

                <td class="text-muted small">
                  {{ \Carbon\Carbon::parse($r->created_at)->format('d M Y, h:i A') }}
                </td>
                <td>
  {{-- show current accept status --}}
  <div class="mb-1">
    <span class="badge 
      @if(($r->accept_status ?? 'pending') === 'accepted') bg-success
      @elseif(($r->accept_status ?? 'pending') === 'rejected') bg-danger
      @else bg-secondary
      @endif">
      {{ ucfirst($r->accept_status ?? 'pending') }}
    </span>
  </div>

  {{-- Accept button only if not accepted --}}
  @if(($r->accept_status ?? 'pending') !== 'accepted')
    <form action="{{ route('employer.pqc.accept', $r->id) }}" method="POST" class="acceptForm d-inline">
      @csrf
      <button type="submit" class="btn btn-sm btn-success">
        ✅ Accept Vendor
      </button>
    </form>
  @else
    <button class="btn btn-sm btn-success" disabled>✅ Accepted</button>
  @endif
</td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">No PQC submissions found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

    </div>
  </div>

</div>

{{-- PQC Modal --}}
<div class="modal fade" id="pqcModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content rounded-4">
      <div class="modal-header">
        <div>
          <h5 class="modal-title fw-bold mb-0">PQC Details</h5>
          <div class="text-muted small" id="pqcVendorName"></div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <div id="pqcRenderWrap"></div>
      </div>
    </div>
  </div>
</div>

{{-- Bootstrap --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

  const pqcModal = document.getElementById('pqcModal');
  const wrap = document.getElementById('pqcRenderWrap');

  function safe(v){
    if (v === null || v === undefined || v === '' || v === 'null') return '—';
    return String(v);
  }

  function parseSmart(raw){
    if (!raw) return null;
    let s = String(raw).trim();

    try {
      let v = JSON.parse(s);
      if (typeof v === 'string') v = JSON.parse(v);
      return v;
    } catch (e) {
      try {
        s = s.replace(/\\"/g, '"');
        return JSON.parse(s);
      } catch (e2) {
        return null;
      }
    }
  }

  function card(title, inner){
    return `
      <div class="card border-0 shadow-sm rounded-4 mb-3">
        <div class="card-header bg-white border-0 pb-0">
          <h6 class="fw-bold mb-0">${title}</h6>
        </div>
        <div class="card-body pt-3">
          ${inner}
        </div>
      </div>
    `;
  }

  function twoColTable(rows){
    const trs = rows.map(r => `
      <tr>
        <th style="width:32%" class="text-muted">${r.k}</th>
        <td>${safe(r.v)}</td>
      </tr>
    `).join('');
    return `
      <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle mb-0">
          <tbody>${trs}</tbody>
        </table>
      </div>
    `;
  }

  function simpleTable(headers, bodyRows){
    return `
      <div class="table-responsive">
        <table class="table table-sm table-bordered align-middle">
          <thead class="table-light">
            <tr>${headers.map(h => `<th>${h}</th>`).join('')}</tr>
          </thead>
          <tbody>
            ${bodyRows.length ? bodyRows.map(cols => `
              <tr>${cols.map(c => `<td>${safe(c)}</td>`).join('')}</tr>
            `).join('') : `<tr><td colspan="${headers.length}" class="text-center text-muted">No data</td></tr>`}
          </tbody>
        </table>
      </div>
    `;
  }

  function renderPqc(p){
    // ---------- Company & Contact ----------
    const companyBlock = twoColTable([
      {k:'Company Name', v:p.company_name},
      {k:'Establishment Year', v:p.establishment_year},
      {k:'Registered Office', v:p.address?.registered_office},
      {k:'Warehouse Address', v:p.address?.warehouse},
    ]);

  
    // ---------- Org Capability / Proposed Team ----------
    const staffBlock = twoColTable([
      {k:'Org: Project Managers', v:p.org_capability?.project_managers},
      {k:'Org: Supervisors', v:p.org_capability?.supervisors},
     
    ]);

    // ---------- Financials ----------
    const fin = p.financials || {};
    const financialBlock = simpleTable(
      ['Financial Year', 'Value'],
      [
        ['2022-2023', fin['2022_2023'] ?? fin['2022-2023']],
        ['2021-2022', fin['2021_2022'] ?? fin['2021-2022']],
        ['2020-2021', fin['2020_2021'] ?? fin['2020-2021']],
      ]
    );

    // ---------- Completed Projects ----------
    const completed = Array.isArray(p.completed_projects) ? p.completed_projects : [];
    const completedBlock = simpleTable(
      ['#','Client Name','Project Name','Location','Scope'],
      completed.map((x,i)=>[
        i+1,
        x.client_name,
        x.project_name,
        x.location,
        x.scope_details
      ])
    );

  

    // ---------- Layout ----------
    return `
      <div class="row g-3">
        <div class="col-md-6">${card('Company Details', companyBlock)}</div>
       
        <div class="col-12">${card('Staff Strength & Proposed Team', staffBlock)}</div>

        <div class="col-12">${card('Financial Capacity', financialBlock)}</div>

        <div class="col-12">${card('Completed Projects', completedBlock)}</div>

       
      </div>
    `;
  }

  pqcModal?.addEventListener('show.bs.modal', function (event) {
    const btn = event.relatedTarget;
    const vendor = btn.getAttribute('data-vendor') || '';
    const raw = btn.getAttribute('data-pqc') || '';

    document.getElementById('pqcVendorName').textContent = vendor;

    const obj = parseSmart(raw);
    if (!obj) {
      wrap.innerHTML = `<div class="alert alert-danger">Invalid PQC data</div>`;
      return;
    }

    wrap.innerHTML = renderPqc(obj);
  });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.acceptForm').forEach(form=>{
    form.addEventListener('submit', function(e){
      e.preventDefault();

      Swal.fire({
        title: 'Accept this vendor?',
        text: 'This vendor will be marked as accepted for this project.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Accept',
        cancelButtonText: 'Cancel'
      }).then((result)=>{
        if(result.isConfirmed){
          form.submit();
        }
      });
    });
  });
});
</script>
@endsection