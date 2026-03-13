{{-- resources/views/web/employers/pqc_list.blade.php --}}
@extends('layouts.employerapp')

@section('title', 'PQC List')

@section('content')
<div class="container-fluid mt-4">

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
        <div>
            <h4 class="fw-bold mb-0">PQC Submissions</h4>
            <div class="text-muted small">Project ID: {{ $projectId }}</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('boq_rfq_bids', ['projectId' => $projectId]) }}" class="btn btn-primary">
                BOQ → RFQ → Bids
            </a>

            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                ← Back
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-3" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
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
                            @php
                                $pqcJson = '';

                                if (!empty($r->pqc_data)) {
                                    if (is_array($r->pqc_data) || is_object($r->pqc_data)) {
                                        $pqcJson = json_encode($r->pqc_data, JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_HEX_TAG);
                                    } else {
                                        $pqcJson = $r->pqc_data;
                                    }
                                }

                                $status = strtolower($r->status ?? 'na');
                                $acceptStatus = strtolower($r->accept_status ?? 'pending');
                            @endphp

                            <tr>
                                <td>{{ $i + 1 }}</td>

                                <td>
                                    <div class="fw-semibold">{{ $r->vendor_company ?? '-' }}</div>
                                    <div class="text-muted small">{{ $r->vendor_name ?? '-' }}</div>
                                </td>

                                <td>{{ $r->vendor_mobile ?? '-' }}</td>

                                <td>
                                    @if($status === 'submitted')
                                        <span class="badge bg-success">Submitted</span>
                                    @elseif($status === 'draft')
                                        <span class="badge bg-warning text-dark">Draft</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($status) }}</span>
                                    @endif
                                </td>

                                <td>
                                    @if(!empty($r->company_profile_path))
                                        <a href="{{ asset('storage/' . $r->company_profile_path) }}"
                                           target="_blank"
                                           class="btn btn-sm btn-outline-success">
                                            View File
                                        </a>
                                    @else
                                        <span class="text-muted small">Not uploaded</span>
                                    @endif
                                </td>

                                <td>
                                    @if(!empty($r->pqc_data))
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary viewPqcBtn"
                                                data-bs-toggle="modal"
                                                data-bs-target="#pqcModal"
                                                data-vendor="{{ $r->vendor_company ?? $r->vendor_name ?? 'Vendor' }}"
                                                data-pqc="{{ e($pqcJson) }}">
                                            View PQC
                                        </button>
                                    @else
                                        <span class="text-muted small">Not submitted</span>
                                    @endif
                                </td>

                                <td class="text-muted small">
                                    {{ !empty($r->created_at) ? \Carbon\Carbon::parse($r->created_at)->format('d M Y, h:i A') : '-' }}
                                </td>

                                <td>
                                    <div class="mb-2">
                                        @if($acceptStatus === 'accepted')
                                            <span class="badge bg-success">Accepted</span>
                                        @elseif($acceptStatus === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-secondary">Pending</span>
                                        @endif
                                    </div>

                                    @if($acceptStatus !== 'accepted')
                                        <form action="{{ route('employer.pqc.accept', $r->id) }}"
                                              method="POST"
                                              class="acceptForm d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                ✅ Accept Vendor
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-sm btn-success" disabled>
                                            ✅ Accepted
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No PQC submissions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- PQC Modal --}}
<div class="modal fade" id="pqcModal" tabindex="-1" aria-labelledby="pqcModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold mb-0" id="pqcModalLabel">PQC Details</h5>
                    <div class="text-muted small" id="pqcVendorName"></div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div id="pqcRenderWrap">
                    <div class="text-center py-4 text-muted">Loading PQC details...</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- If Bootstrap JS already loaded in layout, then remove below line --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const pqcModal = document.getElementById('pqcModal');
    const wrap = document.getElementById('pqcRenderWrap');
    const vendorNameEl = document.getElementById('pqcVendorName');

    function safe(v) {
        if (v === null || v === undefined || v === '' || v === 'null') return '—';
        return String(v);
    }

    function escapeHtml(text) {
        if (text === null || text === undefined) return '—';
        const div = document.createElement('div');
        div.textContent = String(text);
        return div.innerHTML;
    }

    function parseSmart(raw) {
        if (!raw) return null;

        let s = String(raw).trim();

        try {
            let parsed = JSON.parse(s);
            if (typeof parsed === 'string') {
                parsed = JSON.parse(parsed);
            }
            return parsed;
        } catch (e1) {
            try {
                s = s.replace(/&quot;/g, '"')
                     .replace(/&#34;/g, '"')
                     .replace(/&#39;/g, "'")
                     .replace(/&amp;/g, '&');
                let parsed = JSON.parse(s);
                if (typeof parsed === 'string') {
                    parsed = JSON.parse(parsed);
                }
                return parsed;
            } catch (e2) {
                return null;
            }
        }
    }

    function card(title, inner) {
        return `
            <div class="card border-0 shadow-sm rounded-4 mb-3">
                <div class="card-header bg-white border-0 pb-0">
                    <h6 class="fw-bold mb-0">${escapeHtml(title)}</h6>
                </div>
                <div class="card-body pt-3">
                    ${inner}
                </div>
            </div>
        `;
    }

    function twoColTable(rows) {
        const trs = rows.map(r => `
            <tr>
                <th style="width:32%" class="text-muted">${escapeHtml(r.k)}</th>
                <td>${escapeHtml(safe(r.v))}</td>
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

    function simpleTable(headers, bodyRows) {
        return `
            <div class="table-responsive">
                <table class="table table-sm table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            ${headers.map(h => `<th>${escapeHtml(h)}</th>`).join('')}
                        </tr>
                    </thead>
                    <tbody>
                        ${
                            bodyRows.length
                            ? bodyRows.map(cols => `
                                <tr>
                                    ${cols.map(c => `<td>${escapeHtml(safe(c))}</td>`).join('')}
                                </tr>
                            `).join('')
                            : `<tr><td colspan="${headers.length}" class="text-center text-muted">No data</td></tr>`
                        }
                    </tbody>
                </table>
            </div>
        `;
    }

    function renderPqc(p) {
        const companyBlock = twoColTable([
            { k: 'Company Name', v: p.company_name },
            { k: 'Establishment Year', v: p.establishment_year },
            { k: 'Registered Office', v: p.address?.registered_office },
            { k: 'Warehouse Address', v: p.address?.warehouse },
        ]);

        const staffBlock = twoColTable([
            { k: 'Project Managers', v: p.org_capability?.project_managers },
            { k: 'Supervisors', v: p.org_capability?.supervisors },
            { k: 'Engineers', v: p.org_capability?.engineers },
            { k: 'Skilled Labour', v: p.org_capability?.skilled_labour },
            { k: 'Unskilled Labour', v: p.org_capability?.unskilled_labour },
        ]);

        const fin = p.financials || {};
        const financialBlock = simpleTable(
            ['Financial Year', 'Value'],
            [
                ['2022-2023', fin['2022_2023'] ?? fin['2022-2023']],
                ['2021-2022', fin['2021_2022'] ?? fin['2021-2022']],
                ['2020-2021', fin['2020_2021'] ?? fin['2020-2021']],
            ]
        );

        const completed = Array.isArray(p.completed_projects) ? p.completed_projects : [];
        const completedBlock = simpleTable(
            ['#', 'Client Name', 'Project Name', 'Location', 'Scope'],
            completed.map((x, i) => [
                i + 1,
                x.client_name,
                x.project_name,
                x.location,
                x.scope_details
            ])
        );

        return `
            <div class="row g-3">
                <div class="col-md-6">
                    ${card('Company Details', companyBlock)}
                </div>

                <div class="col-md-6">
                    ${card('Staff Strength & Proposed Team', staffBlock)}
                </div>

                <div class="col-12">
                    ${card('Financial Capacity', financialBlock)}
                </div>

                <div class="col-12">
                    ${card('Completed Projects', completedBlock)}
                </div>
            </div>
        `;
    }

    if (pqcModal) {
        pqcModal.addEventListener('show.bs.modal', function (event) {
            const btn = event.relatedTarget;
            if (!btn) return;

            const vendor = btn.getAttribute('data-vendor') || 'Vendor';
            const raw = btn.getAttribute('data-pqc') || '';

            vendorNameEl.textContent = vendor;

            const obj = parseSmart(raw);

            if (!obj || typeof obj !== 'object') {
                wrap.innerHTML = `<div class="alert alert-danger mb-0">Invalid PQC data</div>`;
                return;
            }

            wrap.innerHTML = renderPqc(obj);
        });
    }

    document.querySelectorAll('.acceptForm').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            Swal.fire({
                title: 'Accept this vendor?',
                text: 'This vendor will be marked as accepted for this project.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>
@endpush