@extends('layouts.vendorapp')

@section('title','Credits Packages | ConstructKaro')

@section('content')
<style>
:root{
    --ck-primary:#1c2c3e;
    --ck-secondary:#f25c05;
    --ck-bg:#f6f8fb;
    --ck-card:#ffffff;
    --ck-text:#0f172a;
    --ck-muted:#64748b;
    --ck-border:#e5e7eb;
    --ck-success:#16a34a;
}

body{
    background:var(--ck-bg);
}

.invoice-history-page{
    max-width:1200px;
    margin:36px auto 80px;
    padding:0 14px;
}

.invoice-history-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
    margin-bottom:24px;
}

.invoice-history-head h2{
    margin:0 0 6px;
    font-size:30px;
    font-weight:900;
    color:var(--ck-text);
}

.invoice-history-head p{
    margin:0;
    color:var(--ck-muted);
    font-size:15px;
}

.invoice-summary-card{
    background:linear-gradient(135deg,#fff7ed,#ffffff);
    border:1px solid #fed7aa;
    border-radius:18px;
    padding:18px 20px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:16px;
    margin-bottom:24px;
    flex-wrap:wrap;
}

.invoice-summary-card strong{
    color:var(--ck-text);
    font-size:18px;
}

.invoice-summary-card span{
    color:var(--ck-muted);
    font-size:14px;
}

.invoice-table-wrap{
    background:var(--ck-card);
    border:1px solid var(--ck-border);
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 12px 30px rgba(15,23,42,.05);
}

.invoice-table{
    width:100%;
    border-collapse:collapse;
}

.invoice-table thead th{
    background:#f8fafc;
    color:#334155;
    font-size:13px;
    font-weight:800;
    text-transform:uppercase;
    letter-spacing:.6px;
    padding:16px 18px;
    border-bottom:1px solid var(--ck-border);
    white-space:nowrap;
}

.invoice-table tbody td{
    padding:18px;
    border-bottom:1px solid #eef2f7;
    font-size:15px;
    color:#1e293b;
    vertical-align:middle;
}

.invoice-table tbody tr:hover{
    background:#fcfcfd;
}

.invoice-no{
    font-weight:800;
    color:var(--ck-primary);
}

.invoice-plan{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 12px;
    border-radius:999px;
    background:#eff6ff;
    color:#2563eb;
    font-size:12px;
    font-weight:800;
    text-transform:capitalize;
}

.invoice-method{
    display:inline-flex;
    align-items:center;
    gap:6px;
    color:#0f172a;
    font-weight:700;
}

.invoice-amount{
    font-weight:800;
    color:#0f172a;
}

.invoice-date{
    color:var(--ck-muted);
    font-weight:600;
}

.invoice-status{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:6px 12px;
    border-radius:999px;
    background:#dcfce7;
    color:#166534;
    font-size:12px;
    font-weight:800;
    text-transform:capitalize;
}

.download-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:10px 16px;
    border-radius:12px;
    background:#0f172a;
    color:#fff;
    text-decoration:none;
    font-size:14px;
    font-weight:800;
    transition:.25s ease;
    white-space:nowrap;
}

.download-btn:hover{
    background:var(--ck-secondary);
    color:#fff;
}

.empty-invoice-box{
    background:#fff;
    border:1px dashed #cbd5e1;
    border-radius:20px;
    padding:50px 24px;
    text-align:center;
    color:var(--ck-muted);
}

.empty-invoice-box h5{
    font-size:22px;
    font-weight:900;
    color:#0f172a;
    margin-bottom:10px;
}

.empty-invoice-box p{
    margin:0;
    font-size:15px;
}

.mobile-invoice-cards{
    display:none;
}

@media(max-width:900px){
    .invoice-table-wrap{
        display:none;
    }

    .mobile-invoice-cards{
        display:grid;
        gap:14px;
    }

    .mobile-invoice-card{
        background:#fff;
        border:1px solid var(--ck-border);
        border-radius:18px;
        padding:18px;
        box-shadow:0 10px 24px rgba(15,23,42,.05);
    }

    .mobile-invoice-top{
        display:flex;
        align-items:flex-start;
        justify-content:space-between;
        gap:12px;
        margin-bottom:12px;
    }

    .mobile-invoice-card h6{
        margin:0 0 8px;
        font-size:17px;
        font-weight:900;
        color:#0f172a;
    }

    .mobile-meta{
        display:grid;
        gap:8px;
        margin-bottom:14px;
    }

    .mobile-meta span{
        font-size:14px;
        color:#475569;
    }

    .download-btn{
        width:100%;
        justify-content:center;
    }
}
</style>

<div class="invoice-history-page">

    <div class="invoice-history-head">
        <div>
            <h2>Invoice History</h2>
            <p>View all your previous invoices and download them anytime.</p>
        </div>

        <a href="{{ url()->previous() }}" class="download-btn">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    @if($invoices->count() > 0)
        <div class="invoice-summary-card">
            <div>
                <strong>{{ $invoices->count() }} Invoice{{ $invoices->count() > 1 ? 's' : '' }}</strong><br>
                <span>All successful payment invoices for your account</span>
            </div>
        </div>

        <div class="invoice-table-wrap">
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Invoice No</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th style="text-align:right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>
                                <span class="invoice-no">
                                    {{ $invoice->invoice_no ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="invoice-plan">
                                    {{ $invoice->plan ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="invoice-amount">
                                    ₹{{ number_format((float) $invoice->amount, 2) }}
                                </span>
                            </td>
                            <td>
                                <span class="invoice-method">
                                    <i class="bi bi-credit-card"></i>
                                    {{ $invoice->payment_method ?? 'Razorpay' }}
                                </span>
                            </td>
                            <td>
                                <span class="invoice-date">
                                    {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') : '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="invoice-status">
                                    {{ $invoice->status ?? 'success' }}
                                </span>
                            </td>
                            <td style="text-align:right;">
                                <a href="{{ route('invoice.download', $invoice->payment_id) }}" class="download-btn">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mobile-invoice-cards">
            @foreach($invoices as $invoice)
                <div class="mobile-invoice-card">
                    <div class="mobile-invoice-top">
                        <div>
                            <h6>{{ $invoice->invoice_no ?? 'N/A' }}</h6>
                            <span class="invoice-plan">{{ $invoice->plan ?? 'N/A' }}</span>
                        </div>
                        <span class="invoice-status">{{ $invoice->status ?? 'success' }}</span>
                    </div>

                    <div class="mobile-meta">
                        <span><strong>Amount:</strong> ₹{{ number_format((float) $invoice->amount, 2) }}</span>
                        <span><strong>Method:</strong> {{ $invoice->payment_method ?? 'Razorpay' }}</span>
                        <span><strong>Date:</strong> {{ $invoice->invoice_date ? \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') : '-' }}</span>
                    </div>

                    <a href="{{ route('invoice.download', $invoice->payment_id) }}" class="download-btn">
                        <i class="bi bi-download"></i> Download Invoice
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="empty-invoice-box">
            <h5>No invoices found</h5>
            <p>Your payment invoices will appear here after successful purchases.</p>
        </div>
    @endif

</div>
@endsection