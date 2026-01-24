@extends('layouts.suppliersapp')

@section('title', 'Enquiries Inbox | ConstructKaro')

@section('content')

<style>
:root{
    --primary:#2563eb;
    --primary-dark:#1d4ed8;
    --muted:#6b7280;
    --border:#e5e7eb;
    --card:#ffffff;
    --bg:#f8fafc;
}

/* PAGE */
.page-wrapper{
    background:linear-gradient(180deg,#f8fafc,#f1f5f9);
    min-height:100vh;
    padding:24px 0;
}

/* HEADER */
.page-header h2{font-size:26px;font-weight:700}
.page-header p{color:var(--muted);margin-top:6px}

/* TABS */
.tabs{display:flex;gap:10px;margin:22px 0 18px}
.tab{
    padding:7px 16px;
    border-radius:10px;
    font-size:13px;
    background:#fff;
    border:1px solid var(--border);
    color:var(--muted);
    cursor:pointer;
}
.tab.active{background:var(--primary);color:#fff;border-color:var(--primary)}

/* CARD */
.enquiry-card{
    background:var(--card);
    border-radius:14px;
    border:1px solid var(--border);
    padding:16px 18px;
    margin-bottom:14px;
}

/* HEADER ROW */
.enquiry-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:10px}
.enquiry-title{font-size:15px;font-weight:700}
.enquiry-sub{font-size:12px;color:var(--muted)}
.status-pill{
    font-size:11px;
    padding:5px 12px;
    border-radius:999px;
    font-weight:600;
    background:#eef2ff;
    color:#4338ca;
}

/* GRID */
.meta-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:12px;
    margin-bottom:10px
}
.meta-item span{font-size:11px;color:var(--muted)}
.meta-item strong{font-size:13px}

/* SPECS */
.specs-box{
    background:#f9fafb;
    border:1px dashed var(--border);
    border-radius:8px;
    padding:8px 10px;
    font-size:12px;
    margin-bottom:10px;
}

/* FOOTER */
.enquiry-footer{
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.enquiry-footer small{font-size:11px;color:var(--muted)}
.attachment-link{font-size:12px;color:var(--primary);margin-left:10px}

/* BUTTON */
.btn-quote{
    background:linear-gradient(135deg,var(--primary),var(--primary-dark));
    color:#fff;
    border:none;
    padding:7px 16px;
    border-radius:8px;
    font-size:12px;
    font-weight:600;
    cursor:pointer;
}

/* TABS */
.tab-panel{display:none}
.tab-panel.active{display:block}

@media(max-width:992px){
    .meta-grid{grid-template-columns:1fr 1fr}
}
</style>

<div class="page-wrapper">
<div class="container">

<!-- HEADER -->
<div class="page-header">
    <h2>Enquiries Inbox</h2>
    <p>Manage and respond to customer enquiries</p>
</div>

<!-- TABS -->
<div class="tabs">
    <button class="tab active" data-tab="new">
        New ({{ $newEnquiries->count() }})
    </button>
    <button class="tab" data-tab="quoted">
        Quoted ({{ $quotedEnquiries->count() }})
    </button>
</div>

<!-- ================= NEW ENQUIRIES ================= -->
<div class="tab-panel active" data-content="new">
@forelse($newEnquiries as $enquiry)
<div class="enquiry-card">

    <div class="enquiry-top">
        <div>
            <div class="enquiry-title">{{ $enquiry->shop_name }}</div>
            <div class="enquiry-sub">
                {{ $enquiry->contact_person }} • {{ $enquiry->mobile }}
            </div>
        </div>
        <span class="status-pill">New</span>
    </div>

    <div class="meta-grid">
        <div class="meta-item">
            <span>Category</span>
            <strong>{{ $enquiry->material_categories_name }}</strong>
        </div>
        <div class="meta-item">
            <span>Quantity</span>
            <strong>{{ $enquiry->quantity }}</strong>
        </div>
        <div class="meta-item">
            <span>Payment</span>
            <strong>{{ ucfirst($enquiry->payment_preference) }}</strong>
        </div>
        <div class="meta-item">
            <span>Delivery</span>
            <strong>{{ $enquiry->delivery_location }}</strong>
        </div>
    </div>

    <div class="specs-box">
        <strong>Specs:</strong> {{ $enquiry->specs ?: '-' }}
    </div>

    <div class="enquiry-footer">
        <div>
            <small>{{ \Carbon\Carbon::parse($enquiry->created_at)->diffForHumans() }}</small>
            @php
                $files = $enquiry->attachments;

                // First decode
                if (is_string($files)) {
                    $files = json_decode($files, true);
                }

                // If still string (double encoded), decode again
                if (is_string($files)) {
                    $files = json_decode($files, true);
                }

                // Final safety
                if (!is_array($files)) {
                    $files = [];
                }
            @endphp
            @foreach($files as $file)
    <a href="{{ asset('storage/'.$file) }}"
       target="_blank"
       class="attachment-link">
        📎 File
    </a>
    @endforeach
        </div>

        <button
            class="btn-quote open-quote-modal"
            data-enquiry-id="{{ $enquiry->id }}"
            data-category="{{ $enquiry->material_categories_name }}"
            data-quantity="{{ $enquiry->quantity }}">
            Send Quote
        </button>
    </div>

</div>
@empty
<p class="text-muted">No new enquiries.</p>
@endforelse
</div>

<!-- ================= QUOTED ================= -->
<div class="tab-panel" data-content="quoted">
@forelse($quotedEnquiries as $enquiry)
<div class="enquiry-card">

    <div class="enquiry-top">
        <div>
            <div class="enquiry-title">{{ $enquiry->shop_name }}</div>
            <div class="enquiry-sub">
                {{ $enquiry->contact_person }} • {{ $enquiry->mobile }}
            </div>
        </div>
        <span class="status-pill" style="background:#ecfeff;color:#0369a1">
            Quoted
        </span>
    </div>

    <div class="meta-grid">
        <div class="meta-item">
            <span>Category</span>
            <strong>{{ $enquiry->material_categories_name }}</strong>
        </div>
        <div class="meta-item">
            <span>Quantity</span>
            <strong>{{ $enquiry->quantity }}</strong>
        </div>
        <div class="meta-item">
            <span>Delivery</span>
            <strong>{{ $enquiry->delivery_location }}</strong>
        </div>
    </div>

    <div class="specs-box">
        <strong>Specs:</strong> {{ $enquiry->specs ?: '-' }}
    </div>

    <div class="enquiry-footer">
        <small>Quoted {{ \Carbon\Carbon::parse($enquiry->updated_at)->diffForHumans() }}</small>
        <span class="text-success fw-semibold">Quote Sent ✔</span>
    </div>

</div>
@empty
<p class="text-muted">No quoted enquiries.</p>
@endforelse
</div>

</div>
</div>

<!-- ================= SEND QUOTE MODAL ================= -->
<div class="modal fade" id="sendQuoteModal" tabindex="-1">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">

<form method="POST" action="{{ route('supplier.sendQuote') }}" enctype="multipart/form-data">
@csrf
<input type="hidden" name="enquiry_id" id="quote_enquiry_id">

<div class="modal-header">
    <h5 class="modal-title fw-bold">Send Quotation</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<div class="row g-3">

<div class="col-md-6">
    <label class="form-label">Category</label>
    <input type="text" id="quote_category" class="form-control" disabled>
</div>

<div class="col-md-6">
    <label class="form-label">Quantity</label>
    <input type="text" id="quote_quantity" class="form-control" disabled>
</div>

<div class="col-md-6">
    <label class="form-label">Price</label>
    <input type="text" name="price" class="form-control" required>
</div>

<div class="col-md-6">
    <label class="form-label">Delivery Time</label>
    <input type="text" name="delivery_time" class="form-control" required>
</div>

<div class="col-md-12">
    <label class="form-label">Notes</label>
    <textarea name="notes" class="form-control" rows="3"></textarea>
</div>

<div class="col-md-12">
    <label class="form-label">Upload Quote</label>
    <input type="file" name="quote_file" class="form-control">
</div>

</div>
</div>

<div class="modal-footer">
    <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
    <button class="btn btn-primary">Send Quote</button>
</div>

</form>

</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = new bootstrap.Modal(document.getElementById('sendQuoteModal'));

    document.querySelectorAll('.open-quote-modal').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('quote_enquiry_id').value = this.dataset.enquiryId;
            document.getElementById('quote_category').value   = this.dataset.category;
            document.getElementById('quote_quantity').value   = this.dataset.quantity;
            modal.show();
        });
    });

    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function () {
            document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            document.querySelector('.tab-panel[data-content="'+this.dataset.tab+'"]').classList.add('active');
        });
    });

});
</script>

@endsection
