@extends('layouts.suppliersapp')

@section('title', 'Supplier Dashboard | ConstructKaro')

@section('content')

<style>
/* ================= ROOT ================= */
:root {
    --primary: #2563eb;
    --primary-dark: #1d4ed8;
    --success: #16a34a;
    --whatsapp: #22c55e;
    --warning-bg: #fff4e6;
    --warning-text: #f97316;
    --page-bg: #f6f8fc;
    --text-main: #0f172a;
    --text-muted: #64748b;
    --border: #e5e7eb;
}

/* ================= PAGE ================= */
.page-wrapper {
    background: linear-gradient(180deg, #f8fafc, #f1f5f9);
    min-height: 100vh;
    padding: 32px 0;
}

/* ================= HEADER ================= */
.page-header h2 {
    font-size: 26px;
    font-weight: 700;
}

.page-header p {
    color: var(--text-muted);
}

/* ================= TABS ================= */
.tabs {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
}

.tab {
    padding: 8px 18px;
    border-radius: 8px;
    font-size: 14px;
    background: #fff;
    border: 1px solid var(--border);
    color: var(--text-muted);
    cursor: pointer;
    transition: 0.2s;
}

.tab:hover {
    border-color: var(--primary);
    color: var(--primary);
}

.tab.active {
    background: var(--primary);
    color: #fff;
    border-color: var(--primary);
}

/* ================= CARD ================= */
.card {
    background: #fff;
    border-radius: 18px;
    padding: 28px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
    border-top: 4px solid var(--primary);
}

/* ================= CARD HEADER ================= */
.card-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 24px;
}

.card-header h3 {
    font-size: 18px;
    font-weight: 700;
}

.card-header p {
    font-size: 13px;
    color: var(--text-muted);
}

/* ================= BADGE ================= */
.badge {
    padding: 8px 14px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
    background: var(--warning-bg);
    color: var(--warning-text);
}

/* ================= DETAILS ================= */
.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px 48px;
    margin-bottom: 24px;
}

.details-grid span {
    font-size: 12px;
    color: var(--text-muted);
    display: block;
    margin-bottom: 4px;
}

/* ================= NOTES ================= */
.notes {
    background: linear-gradient(135deg, #eff6ff, #f8fbff);
    border: 1px solid #dbeafe;
    border-radius: 12px;
    padding: 18px;
    font-size: 14px;
    margin-bottom: 28px;
}

/* ================= ACTIONS ================= */
.actions {
    display: flex;
    gap: 14px;
}

.btn {
    height: 52px;
    padding: 0 26px;
    border-radius: 12px;
    font-size: 15px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-decoration: none;
}

.btn.primary {
    flex: 1;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
}

.btn.success { background: var(--success); }
.btn.whatsapp { background: var(--whatsapp); }

/* ================= TAB CONTENT ================= */
.tab-panel {
    display: none;
}

.tab-panel.active {
    display: block;
}

/* ================= RESPONSIVE ================= */
@media (max-width: 768px) {
    .details-grid { grid-template-columns: 1fr; }
    .actions { flex-direction: column; }
    .btn { width: 100%; }
}
</style>

<div class="page-wrapper">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Header -->
        <div class="page-header mb-6">
            <h2>Enquiries Inbox</h2>
            <p>Manage and respond to customer enquiries</p>
        </div>

        <!-- Tabs -->
        <div class="tabs">
            <button class="tab active" data-tab="all">All (24)</button>
            <button class="tab" data-tab="active">Active (5)</button>
            <button class="tab" data-tab="quoted">Quoted (12)</button>
            <button class="tab" data-tab="closed">Closed (7)</button>
        </div>

        <!-- TAB CONTENT -->
        <div class="tab-content">

          
            <!-- ACTIVE TAB -->
            <div class="tab-panel active" data-content="all">

                @forelse($enquiries as $enquiry)
                    <div class="card">
                        <div class="card-header">
                            <div>
                                <h3>{{ $enquiry->shop_name }}</h3>
                                <p>Contact: {{ $enquiry->contact_person }} - {{$enquiry->mobile}}</p>
                            </div>
                            <span class="badge">New Enquiry</span>
                        </div>

                        <div class="details-grid">
                            <div><span>Project Type</span>{{ $enquiry->material_categories_name }}</div>
                            <div><span>Delivery Location</span>{{ $enquiry->delivery_location }}</div>
                            <div><span>Material Required</span>{{ $enquiry->quantity }}</div>
                            <div><span>Payment Preference</span>{{ ucfirst($enquiry->payment_preference) }}</div>
                            <div><span>Specs</span>{{ $enquiry->specs }}</div>
                            @if($enquiry->attachments)
                                @php
                                    $attachments = json_decode($enquiry->attachments, true);
                                @endphp
                                <div>
                                    <span>Attachments</span>
                                    @foreach($attachments as $file)
                                        <a href="{{ asset($file) }}" target="_blank">View File</a>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="notes">
                <strong>Created At:</strong> {{ \Carbon\Carbon::parse($enquiry->created_at)->format('d M Y H:i') }}
            </div>


            <div class="actions">
                <button class="btn primary">📄 Send Quote</button>
            </div>
        </div>
    @empty
        <p class="text-sm text-gray-500">No enquiries available.</p>
    @endforelse

</div>


            <!-- QUOTED TAB -->
            <div class="tab-panel" data-content="quoted">
                <p class="text-sm text-gray-500">No quoted enquiries available.</p>
            </div>

            <!-- CLOSED TAB -->
            <div class="tab-panel" data-content="closed">
                <p class="text-sm text-gray-500">No closed enquiries available.</p>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabs = document.querySelectorAll('.tab');
    const panels = document.querySelectorAll('.tab-panel');

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {

            const selected = this.dataset.tab;

            tabs.forEach(t => t.classList.remove('active'));
            panels.forEach(p => p.classList.remove('active'));

            this.classList.add('active');
            document
                .querySelector('.tab-panel[data-content="' + selected + '"]')
                .classList.add('active');
        });
    });

});
</script>

@endsection
