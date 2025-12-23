@extends('layouts.vendorapp')

@section('title', 'Lead Marketplace')

@section('content')

<style>
/* ======================================================
   MODERN UI DESIGN — ConstructKaro Premium
====================================================== */

:root {
    --dark: #1c1f26;
    --navy: #1c2c3e;
    --orange: #ff7a18;
    --orange-dark: #e0670f;
    --blue: #2563eb;
    --green: #22c55e;
    --gray: #6b7280;
    --light: #f4f6fb;
    --border: #e5e7eb;
}

body {
    background: var(--light);
}

/* OUTER WRAPPER */
.lead-wrapper {
    max-width: 1200px;
    margin: auto;
    padding: 25px;
}

/* TITLE + WALLET */
.header-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.page-title {
    font-size: 2rem;
    font-weight: 900;
    color: var(--navy);
}

.wallet-pill {
    padding: 12px 26px;
    background: rgba(255,255,255,0.65);
    backdrop-filter: blur(8px);
    border-radius: 40px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.08);
    border: 1px solid var(--border);
    font-weight: 700;
}

/* NAV TABS */
.market-tabs {
    display: flex;
    gap: 14px;
    margin-bottom: 25px;
}

.market-tab {
    padding: 10px 20px;
    border-radius: 14px;
    background: white;
    border: 1px solid var(--border);
    font-weight: 700;
    cursor: pointer;
    transition: .2s;
}

.market-tab:hover {
    background: #f0f0f0;
}

.market-tab.active {
    background: var(--orange);
    color: white;
    border-color: var(--orange);
}

/* FILTER BOX (Glassmorphism) */
.filter-box {
    background: rgba(255,255,255,0.55);
    backdrop-filter: blur(10px);
    padding: 20px;
    border-radius: 20px;
    border: 1px solid #dddddd70;
    box-shadow: 0 6px 20px rgba(0,0,0,0.06);
    margin-bottom: 25px;
}

/* LEAD CARD (Modern Neumorphism) */
.lead-card {
    background: #ffffff;
    border-radius: 22px;
    padding: 28px;
    margin-bottom: 25px;
    border: 1px solid #e6e6e6;
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    transition: .2s ease;
}

.lead-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 14px 38px rgba(0,0,0,0.10);
}

.lead-title {
    font-size: 1.3rem;
    font-weight: 800;
    color: var(--navy);
}

.lead-info-line {
    color: var(--gray);
    font-size: 0.95rem;
}

/* UNLOCK BUTTON */
.unlock-btn {
    padding: 10px 26px;
    background: linear-gradient(90deg, var(--orange), var(--orange-dark));
    color: white;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    box-shadow: 0 5px 18px rgba(255,122,24,0.3);
    transition: .2s;
}

.unlock-btn:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 24px rgba(255,122,24,0.45);
}

.masked {
    color: #b9bcc3;
    font-style: italic;
    font-weight: 500;
}

/* TAG BADGE */
.lead-badge {
    display: inline-block;
    background: #e8f0fe;
    color: var(--blue);
    padding: 5px 14px;
    font-size: 0.85rem;
    border-radius: 10px;
    font-weight: 700;
}

.separator {
    width: 100%;
    height: 1px;
    background: #eee;
    margin: 15px 0;
}
</style>


<div class="lead-wrapper">

    <!-- HEADER -->
    <div class="header-box">
        <h2 class="page-title">Lead Marketplace</h2>

        <div class="wallet-pill">
            Wallet: <span class="text-success">₹{{ $wallet_balance ?? 500 }}</span>
        </div>
    </div>

    <!-- TABS -->
    <div class="market-tabs">
        <div class="market-tab active">New Leads</div>
        <div class="market-tab">Purchased Leads</div>
    </div>

    <!-- FILTER BOX -->
    <div class="filter-box">
        <form method="POST">
            @csrf

            <div class="row g-3">

                <div class="col-md-4">
                    <label class="fw-bold">Budget Range</label>
                    <select class="form-select">
                        <option>Any</option>
                        <option>Under ₹1 Lac</option>
                        <option>₹1–₹5 Lac</option>
                        <option>₹5–₹25 Lac</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="fw-bold">Work Type</label>
                    <select class="form-select">
                        <option>Any</option>
                        <option>Industrial</option>
                        <option>Residential</option>
                        <option>Interior</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="fw-bold">Location</label>
                    <input type="text" class="form-control" placeholder="City / Area">
                </div>

            </div>

            <button class="btn btn-dark mt-3 px-4">Apply Filters</button>
        </form>
    </div>


    <!-- =============================
         MODERN LEAD CARD
    ============================== -->
    <div class="lead-card">

        <div class="d-flex justify-content-between mb-1">
            <div>
                <div class="lead-title">Industrial Shed Construction</div>
                <div class="lead-info-line">Pune · Maharashtra</div>
            </div>

            <button class="unlock-btn">Unlock Lead — ₹49</button>
        </div>

        <div class="separator"></div>

        <p><strong>Customer Name:</strong> <span class="masked">Hidden until unlocked</span></p>
        <p><strong>Mobile:</strong> <span class="masked">**********</span></p>
        <p><strong>Email:</strong> <span class="masked">********@****</span></p>

        <p class="mt-2"><strong>Work Type:</strong> Industrial Construction</p>
        <p><strong>Budget:</strong> ₹5,00,000</p>
        <p><strong>Date Posted:</strong> 03 Dec 2025</p>

        <span class="lead-badge mt-2">Hot Lead</span>
    </div>

</div>

@endsection
