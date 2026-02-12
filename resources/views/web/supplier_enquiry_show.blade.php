@extends($layout)

@section('title', 'Enquiry Details')

@section('content')

<style>
    :root{
        --navy:#1c2c3e;
        --orange:#f25c05;
        --border:#e6ebf2;
        --muted:#64748b;
        --text:#0f172a;
    }

    .card-box{
        background:#fff;
        border:1px solid var(--border);
        border-radius:18px;
        padding:18px;
        box-shadow:0 16px 34px rgba(15,23,42,.06);
    }

    .page-title{
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:8px;
    }

    .page-title h3{
        margin:0;
        font-weight:900;
        color:var(--text);
    }

    .top-pill{
        background:#f1f5f9;
        border:1px solid #e2e8f0;
        color:#0f172a;
        font-weight:900;
        border-radius:999px;
        padding:8px 12px;
        font-size:12px;
        white-space:nowrap;
    }

    .info-grid{
        background:#fbfdff;
        border:1px solid var(--border);
        border-radius:16px;
        padding:14px;
    }

    .info-item strong{ color:#0f172a; }

    .section-title{
        font-weight:900;
        margin:18px 0 10px;
        display:flex;
        align-items:center;
        gap:10px;
        color:#0f172a;
    }

    .badge-soft{
        background:#fff7ed;
        border:1px solid #fed7aa;
        color:#9a3412;
        font-weight:900;
        border-radius:999px;
        padding:7px 10px;
        font-size:12px;
    }

    .table{
        border-color:#eef2f7 !important;
    }

    .table thead th{
        font-weight:900;
        font-size:13px;
        white-space:nowrap;
    }

    .table tbody td{
        vertical-align:middle;
    }

    .loc-pill{
        display:inline-flex;
        align-items:center;
        gap:6px;
        padding:7px 10px;
        border-radius:999px;
        background:#eef2ff;
        border:1px solid #e0e7ff;
        color:#3730a3;
        font-weight:900;
        font-size:12px;
    }

    .status-badge{
        font-weight:900;
        border-radius:999px;
        padding:7px 10px;
        font-size:12px;
        display:inline-block;
    }
    .st-pending{ background:#fff7ed; border:1px solid #fed7aa; color:#9a3412; }
    .st-accepted{ background:#ecfdf5; border:1px solid #bbf7d0; color:#166534; }
    .st-rejected{ background:#fff1f2; border:1px solid #fecdd3; color:#9f1239; }

    .totals-bar{
        margin-top:10px;
        padding:12px 14px;
        background:#f8fafc;
        border:1px solid var(--border);
        border-radius:16px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        gap:10px;
        flex-wrap:wrap;
        font-weight:900;
    }

    .btn-back{
        border-radius:12px;
        font-weight:900;
    }

    .empty-box{
        padding:16px;
        border:1px dashed #cbd5e1;
        border-radius:16px;
        color:var(--muted);
        text-align:center;
        background:#fbfdff;
    }
</style>

<div class="card-box">

    <!-- शीर्ष -->
    <div class="page-title">
        <h3>📦 Enquiry Details</h3>

        <span class="top-pill">
            Enquiry #{{ $enquiry->id }}
        </span>
    </div>

    <div class="text-muted mb-3">
        Supplier: <strong>{{ $enquiry->shop_name ?? 'Supplier' }}</strong><br>
        Supplier Mobile: <strong>{{ $enquiry->mobile ?? 'Supplier' }}</strong>
    </div>

    <!-- Info -->
    <div class="info-grid mb-3">
        <div class="row g-3">
            <div class="col-md-6 info-item">
                <strong>Delivery Location</strong><br>
                <span class="loc-pill">
                    <i class="bi bi-geo-alt"></i>
                    {{ $enquiry->delivery_location ?? '-' }}
                </span>
            </div>
            <div class="col-md-6 info-item">
                <strong>Required By</strong><br>
                {{ $enquiry->required_by ?? 'Not specified' }}
            </div>
        </div>
    </div>

    <!-- Selected Products -->
    <h5 class="section-title">Selected Products</h5>

    <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Specification</th>
                    <th>Brand</th>
                    <th width="80" class="text-center">Qty</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->category ?? '-' }}</td>
                    <td class="fw-bold">{{ $item->product ?? '-' }}</td>
                    <td>{{ $item->spec ?? '-' }}</td>
                    <td>{{ $item->brand ?? '-' }}</td>
                    <td class="fw-bold text-center">{{ $item->qty ?? 0 }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-3">No products found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Quotations -->
    <h5 class="section-title">
        Supplier Quotations
        @if(isset($quotes) && $quotes->count())
            <span class="badge-soft">{{ $quotes->count() }} rows</span>
        @endif
    </h5>

    @if(!isset($quotes) || $quotes->count() == 0)
        <div class="empty-box">
            ⏳ Awaiting Supplier Quotation
        </div>
    @else

        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width:70px;">#</th>
                        <th>Supplier</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Specification</th>
                        <th>Brand</th>
                        <th class="text-end" style="width:110px;">Rate</th>
                        <th class="text-center" style="width:80px;">Qty</th>
                        <th class="text-center" style="width:90px;">GST %</th>
                        <th class="text-end" style="width:130px;">Total</th>
                        <th style="width:120px;">Status</th>
                        <th>Remarks</th>
                    </tr>
                </thead>

                <tbody>
                    @php $grand = 0; @endphp

                    @foreach($quotes as $k => $q)
                        @php $grand += (float)($q->total ?? 0); @endphp
                        <tr>
                            <td class="fw-bold">{{ $k+1 }}</td>

                            <td class="fw-bold">
                                {{ $q->supplier_name ?? ('Supplier #'.$q->supplier_id) }}
                            </td>

                            <td>{{ $q->category ?? '-' }}</td>
                            <td class="fw-bold">{{ $q->product ?? '-' }}</td>
                            <td>{{ $q->spec ?? '-' }}</td>
                            <td>{{ $q->brand ?? '-' }}</td>

                            <td class="text-end fw-bold">₹ {{ number_format($q->rate ?? 0, 2) }}</td>
                            <td class="text-center fw-bold">{{ $q->qty ?? 0 }}</td>
                            <td class="text-center">{{ $q->gst_percent ?? 0 }}</td>
                            <td class="text-end fw-bold">₹ {{ number_format($q->total ?? 0, 2) }}</td>

                           <td>
    @php $st = strtolower($q->status ?? 'pending'); @endphp

    @if($st === 'accepted')
        <span class="status-badge st-accepted">Accepted</span>
    @elseif($st === 'rejected')
        <span class="status-badge st-rejected">Rejected</span>
    @else
        <span class="status-badge st-pending">Pending</span>
    @endif

    {{-- ✅ actions only when pending + customer login --}}
    @if(Session::get('customer_id') && $st === 'pending')
        <div class="d-flex gap-2 mt-2">
            <form method="POST" action="{{ route('quotation.accept', $q->id) }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-success fw-bold"
                        onclick="return confirm('Approve this quotation and place order?')">
                    Approve
                </button>
            </form>

            <form method="POST" action="{{ route('quotation.reject', $q->id) }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger fw-bold"
                        onclick="return confirm('Reject this quotation?')">
                    Reject
                </button>
            </form>
        </div>
    @endif
</td>


                            <td>{{ $q->remarks ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="totals-bar">
            <div>Total Quotation Rows: {{ $quotes->count() }}</div>
            <div>Grand Total: ₹ {{ number_format($grand, 2) }}</div>
        </div>

    @endif

    <!-- Footer -->
    <div class="mt-4 d-flex gap-3 align-items-center flex-wrap">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-back">
            ← Back
        </a>
    </div>

</div>

@endsection
