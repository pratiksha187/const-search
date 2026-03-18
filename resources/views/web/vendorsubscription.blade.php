@extends('layouts.vendorapp')

@section('title','Credits Packages | ConstructKaro')

@section('content')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
:root{
    --ck-primary:#1c2c3e;
    --ck-secondary:#f25c05;
    --ck-secondary-dark:#da5104;
    --ck-blue:#2563eb;
    --ck-green:#16a34a;
    --ck-purple:#5b47ea;
    --ck-red:#e62929;
    --ck-black:#0b1220;
    --ck-white:#ffffff;
    --ck-bg:#eef3f8;
    --ck-card:#ffffff;
    --ck-border:#dde5ee;
    --ck-text:#0f172a;
    --ck-muted:#64748b;
    --ck-gold:#f5b31f;
    --ck-shadow:0 12px 30px rgba(15,23,42,.08);
    --ck-shadow-lg:0 22px 48px rgba(15,23,42,.12);
}

body{
    background:
        radial-gradient(circle at top right, rgba(242,92,5,.06), transparent 20%),
        radial-gradient(circle at top left, rgba(37,99,235,.06), transparent 24%),
        linear-gradient(180deg,#f7fafc 0%, #eef3f8 100%);
    color:var(--ck-text);
}

.lead-page{
    max-width:1320px;
    margin:28px auto 80px;
    padding:0 14px;
}

/* ===================== HERO ===================== */
.subscription-hero{
    position:relative;
    overflow:hidden;
    border-radius:26px;
    padding:26px 26px;
    margin-bottom:22px;
    background:
        linear-gradient(rgba(255,255,255,.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,.04) 1px, transparent 1px),
        radial-gradient(circle at top center, rgba(242,92,5,.18), transparent 30%),
        linear-gradient(135deg, #0f1d33 0%, #11284b 45%, #091221 100%);
    background-size:28px 28px, 28px 28px, auto, auto;
    box-shadow:var(--ck-shadow-lg);
    color:#fff;
}
.subscription-hero::after{
    content:"";
    position:absolute;
    width:220px;
    height:220px;
    right:-70px;
    top:-70px;
    background:radial-gradient(circle, rgba(242,92,5,.22), transparent 65%);
    border-radius:50%;
}
.subscription-hero-content{
    position:relative;
    z-index:2;
}
.subscription-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.10);
    padding:8px 14px;
    border-radius:999px;
    font-size:11px;
    font-weight:900;
    letter-spacing:1px;
    margin-bottom:12px;
}
.subscription-badge i{
    color:var(--ck-secondary);
}
.subscription-hero h2{
    margin:0 0 8px;
    font-size:30px;
    line-height:1.15;
    font-weight:900;
    max-width:700px;
}
.subscription-hero p{
    margin:0;
    font-size:13px;
    line-height:1.7;
    color:#d8e1ef;
    max-width:680px;
}

/* ===================== TOP BAR CARDS ===================== */
.top-info-grid{
    display:grid;
    grid-template-columns:1.2fr .8fr;
    gap:16px;
    margin-bottom:20px;
}

.info-card{
    background:rgba(255,255,255,.78);
    backdrop-filter:blur(10px);
    border:1px solid rgba(221,229,238,.85);
    border-radius:18px;
    padding:16px 18px;
    box-shadow:var(--ck-shadow);
}

.invoice-box{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
}
.invoice-box h6{
    margin:0 0 4px;
    font-size:16px;
    font-weight:900;
    color:var(--ck-text);
}
.invoice-box p{
    margin:0;
    color:var(--ck-muted);
    font-size:12px;
}
.invoice-btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    background:var(--ck-black);
    color:#fff;
    text-decoration:none;
    padding:11px 14px;
    border-radius:12px;
    font-weight:800;
    font-size:13px;
    white-space:nowrap;
    transition:.25s ease;
}
.invoice-btn:hover{
    transform:translateY(-2px);
    background:var(--ck-secondary);
    color:#fff;
}

.bonus-mini{
    display:flex;
    align-items:center;
    gap:12px;
}
.bonus-icon{
    width:44px;
    height:44px;
    border-radius:14px;
    background:linear-gradient(135deg,#fff3e7,#ffe2c8);
    color:var(--ck-secondary);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    flex-shrink:0;
}
.bonus-mini h6{
    margin:0 0 4px;
    font-size:15px;
    font-weight:900;
}
.bonus-mini p{
    margin:0;
    color:var(--ck-muted);
    font-size:12px;
    line-height:1.6;
}

/* ===================== FREE LEADS ===================== */
.free-leads-box{
    background:linear-gradient(135deg,#ebf8ff,#f7fcff);
    border:1px solid #cfeeff;
    border-radius:22px;
    padding:20px;
    margin-bottom:28px;
    box-shadow:var(--ck-shadow);
}
.free-leads-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:16px;
    margin-bottom:16px;
    flex-wrap:wrap;
}
.free-leads-title h5{
    margin:0 0 6px;
    font-size:24px;
    font-weight:900;
}
.free-leads-title p{
    margin:0;
    color:var(--ck-muted);
    font-size:13px;
}
.free-leads-note{
    background:#fff;
    border:1px solid #dbeafe;
    border-radius:12px;
    padding:8px 12px;
    color:#1d4ed8;
    font-weight:700;
    font-size:11px;
}

.free-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:16px;
}

.free-card{
    background:#fff;
    border:1px solid var(--ck-border);
    border-radius:18px;
    padding:18px;
    text-align:center;
    transition:.25s ease;
    box-shadow:0 10px 24px rgba(15,23,42,.04);
}
.free-card:hover{
    transform:translateY(-4px);
    box-shadow:0 18px 30px rgba(15,23,42,.08);
}
.free-card-icon{
    width:46px;
    height:46px;
    margin:0 auto 10px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:18px;
    background:#f8fafc;
}
.free-card h6{
    font-size:16px;
    font-weight:900;
    margin-bottom:4px;
}
.free-card p{
    color:var(--ck-muted);
    font-size:12px;
    margin-bottom:10px;
}
.free-btn{
    display:inline-block;
    margin-top:6px;
    padding:10px 18px;
    border-radius:999px;
    background:var(--ck-blue);
    border:none;
    color:#fff;
    font-weight:800;
    font-size:12px;
    text-decoration:none;
    cursor:pointer;
    transition:.25s ease;
}
.free-btn:hover{
    background:#1e4fd6;
}
.free-btn.disabled{
    background:#cbd5f5;
    color:#64748b;
    cursor:not-allowed;
}
.upload-box{
    margin-top:14px;
    text-align:left;
}

/* ===================== HEADING ===================== */
.page-head{
    text-align:center;
    margin:6px 0 20px;
}
.page-head h3{
    margin:0 0 8px;
    font-size:26px;
    line-height:1.25;
    font-weight:900;
    color:var(--ck-text);
    max-width:760px;
    margin-left:auto;
    margin-right:auto;
}
.page-head p{
    margin:0;
    color:var(--ck-muted);
    font-size:13px;
}

/* ===================== PACKS GRID ===================== */
.packs-grid{
    display:grid;
    grid-template-columns:repeat(3, minmax(0, 1fr));
    gap:18px;
}

.credit-pack{
    position:relative;
    background:rgba(255,255,255,.9);
    backdrop-filter:blur(10px);
    border:1px solid rgba(221,229,238,.92);
    border-radius:20px;
    padding:18px 16px 16px;
    box-shadow:var(--ck-shadow);
    transition:.25s ease;
    overflow:hidden;
}
.credit-pack:hover{
    transform:translateY(-5px);
    box-shadow:var(--ck-shadow-lg);
}

.credit-pack::before{
    content:"";
    position:absolute;
    left:0;
    top:0;
    width:100%;
    height:4px;
    background:var(--pack-accent, #ddd);
}

.pack-top{
    display:flex;
    flex-direction:column;
    gap:14px;
}

.pack-head-row{
    display:flex;
    justify-content:space-between;
    gap:12px;
    align-items:flex-start;
}

.pack-left{
    display:flex;
    flex-direction:column;
    gap:7px;
}

.pack-badge{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:6px 12px;
    border-radius:999px;
    font-weight:900;
    font-size:11px;
    width:max-content;
}
.pack-badge .dot{
    width:8px;
    height:8px;
    border-radius:50%;
    background:currentColor;
    box-shadow:0 0 0 4px rgba(0,0,0,.05);
}

.pack-subtitle{
    font-size:11px;
    color:var(--ck-muted);
    margin-top:-2px;
    line-height:1.5;
}

.pack-price-block{
    text-align:right;
    min-width:110px;
}
.pack-price{
    font-size:22px;
    line-height:1.1;
    font-weight:900;
    color:var(--ck-text);
}
.pack-credits{
    margin-top:4px;
    font-size:12px;
    font-weight:800;
    color:var(--ck-muted);
}

.pack-points{
    margin:0;
    padding-left:0;
    list-style:none;
    display:flex;
    flex-direction:column;
    gap:9px;
    color:#334155;
}
.pack-points li{
    display:flex;
    align-items:flex-start;
    gap:8px;
    font-size:12px;
    line-height:1.55;
}
.pack-points i{
    margin-top:2px;
    font-size:14px;
}

.pack-footer{
    margin-top:14px;
    border-top:1px solid #edf2f7;
    padding-top:12px;
}

.gst-box{
    display:grid;
    gap:3px;
    margin-bottom:12px;
}
.gst-row{
    display:flex;
    justify-content:space-between;
    gap:10px;
    font-size:12px;
}
.gst-row span:first-child{
    color:var(--ck-muted);
}
.gst-row span:last-child{
    font-weight:800;
    color:var(--ck-text);
}

.pack-btn{
    width:100%;
    border:none;
    border-radius:14px;
    padding:13px 14px;
    font-size:14px;
    font-weight:900;
    color:#fff;
    transition:.25s ease;
}
.pack-btn:hover{
    transform:translateY(-1px);
    filter:brightness(1.03);
}

.most-popular,
.premium-tag{
    position:absolute;
    top:12px;
    right:12px;
    color:#fff;
    padding:6px 10px;
    border-radius:999px;
    font-size:9px;
    font-weight:900;
    display:flex;
    align-items:center;
    gap:5px;
    box-shadow:0 8px 18px rgba(0,0,0,.10);
}

.year-free-box{
    display:flex;
    align-items:center;
    gap:8px;
    background:#fff6df;
    color:#9a6500;
    border:1px solid #f5d48d;
    padding:9px 10px;
    border-radius:12px;
    font-size:11px;
    font-weight:800;
    margin-top:2px;
}

/* color themes */
.pack-green{
    --pack-accent:#22c55e;
}
.pack-green .pack-badge{
    background:#dcfce7;
    color:#16a34a;
}
.pack-green .pack-btn{
    background:#059669;
}

.pack-blue{
    --pack-accent:#60a5fa;
}
.pack-blue .pack-badge{
    background:#dbeafe;
    color:#2563eb;
}
.pack-blue .pack-btn{
    background:#2563eb;
}

.pack-purple{
    --pack-accent:#8b5cf6;
}
.pack-purple .pack-badge{
    background:#ede9fe;
    color:#7c3aed;
}
.pack-purple .pack-btn{
    background:#4f46e5;
}
.most-popular{
    background:#4f46e5;
}

.pack-red{
    --pack-accent:#f87171;
}
.pack-red .pack-badge{
    background:#fee2e2;
    color:#ef4444;
}
.pack-red .pack-btn{
    background:#dc2626;
}

.pack-dark{
    --pack-accent:#94a3b8;
}
.pack-dark .pack-badge{
    background:#e2e8f0;
    color:#334155;
}
.pack-dark .pack-btn{
    background:#0f172a;
}

.pack-premium{
    --pack-accent:#f5b31f;
    background:
        radial-gradient(circle at top right, rgba(245,179,31,.14), transparent 24%),
        linear-gradient(180deg,#fffdf8 0%, #ffffff 100%);
    border:1px solid rgba(245,179,31,.55);
}
.pack-premium .pack-badge{
    background:#fff4cf;
    color:#a86800;
}
.pack-premium .pack-btn{
    background:linear-gradient(180deg,#ff9b2f 0%, #f25c05 100%);
}
.premium-tag{
    background:linear-gradient(180deg,#ffb545 0%, #f25c05 100%);
}

/* full width premium */
.credit-pack.full-width{
    grid-column:1 / -1;
}

/* notes */
.small-note{
    text-align:center;
    color:var(--ck-muted);
    margin-top:20px;
    font-size:12px;
    line-height:1.8;
}

.swal-download-btn{
    display:inline-block;
    margin-top:12px;
    padding:10px 18px;
    border-radius:12px;
    background:#0f172a;
    color:#fff !important;
    font-weight:800;
    text-decoration:none;
}
.swal-download-btn:hover{
    background:#f25c05;
    color:#fff !important;
}

@media(max-width:1100px){
    .packs-grid{
        grid-template-columns:repeat(2, minmax(0, 1fr));
    }
}

@media(max-width:992px){
    .top-info-grid{
        grid-template-columns:1fr;
    }
    .packs-grid{
        grid-template-columns:1fr;
    }
    .credit-pack.full-width{
        grid-column:auto;
    }
    .subscription-hero h2{
        font-size:28px;
    }
    .page-head h3{
        font-size:24px;
    }
}

@media(max-width:768px){
    .lead-page{
        margin:22px auto 60px;
    }
    .subscription-hero{
        padding:22px 16px;
        border-radius:22px;
    }
    .subscription-hero h2{
        font-size:22px;
    }
    .subscription-hero p{
        font-size:12px;
    }
    .invoice-box{
        flex-direction:column;
        align-items:flex-start;
    }
    .invoice-btn{
        width:100%;
        justify-content:center;
    }
    .free-leads-box{
        padding:18px 14px;
        border-radius:18px;
    }
    .free-leads-title h5{
        font-size:20px;
    }
    .free-grid{
        grid-template-columns:1fr;
    }
    .page-head h3{
        font-size:20px;
    }
    .page-head p{
        font-size:12px;
    }
    .credit-pack{
        padding:18px 14px 14px;
        border-radius:18px;
    }
    .pack-head-row{
        flex-direction:column;
    }
    .pack-price-block{
        text-align:left;
        min-width:auto;
    }
    .pack-price{
        font-size:22px;
    }
    .pack-points li{
        font-size:12px;
    }
    .pack-btn{
        font-size:14px;
        padding:13px 13px;
    }
}
</style>

<div class="lead-page">

    <div class="subscription-hero">
        <div class="subscription-hero-content">
            <div class="subscription-badge">
                <i class="bi bi-stars"></i>
                CREDIT ACCESS PLANS
            </div>
            <h2>Unlock Better Projects. Get More Leads. Grow Faster.</h2>
            <p>
                Choose the right access plan for your business and unlock verified construction leads based on your project size, bidding capacity, and long-term growth goals.
            </p>
        </div>
    </div>

    <div class="top-info-grid">
        <div class="info-card">
            <div class="invoice-box">
                <div>
                    <h6>Invoice History</h6>
                    <p>View and download all your previous invoices from one place.</p>
                </div>

                <a href="{{ route('vendor.invoices') }}" class="invoice-btn">
                    <i class="bi bi-receipt"></i> View All Invoices
                </a>
            </div>
        </div>

        <div class="info-card">
            <div class="bonus-mini">
                <div class="bonus-icon">
                    <i class="bi bi-lightning-charge-fill"></i>
                </div>
                <div>
                    <h6>Faster Lead Access</h6>
                    <p>Higher packs help you unlock more projects and bid more consistently.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="free-leads-box">
        <div class="free-leads-head">
            <div class="free-leads-title">
                <h5>🎁 Earn Free Leads!</h5>
                <p>Share on social media and upload proof to get 1 free verified lead.</p>
            </div>
            <div class="free-leads-note">
                Social screenshot required for approval
            </div>
        </div>

        <div class="free-grid">
            <div class="free-card">
                <div class="free-card-icon">📸</div>
                <h6>Instagram</h6>
                <p>Add a story and tag us</p>

                @if(in_array('instagram', $freeLeadPlatforms))
                    <button class="free-btn disabled" disabled>Already Applied</button>
                    <div class="text-success small fw-semibold mt-2">✔ Screenshot already submitted</div>
                @else
                    <button class="free-btn" onclick="toggleUpload('instagram')">Claim Free Lead</button>

                    <form class="upload-box d-none"
                          id="upload-instagram"
                          method="POST"
                          enctype="multipart/form-data"
                          action="{{ route('vendor.freelead.upload') }}">
                        @csrf
                        <input type="hidden" name="platform" value="instagram">
                        <label class="form-label small fw-semibold mt-2">Upload Screenshot</label>
                        <input type="file" name="screenshot" class="form-control mb-2" required accept="image/*">
                        <button class="btn btn-success btn-sm w-100">Submit Screenshot</button>
                    </form>
                @endif
            </div>

            <div class="free-card">
                <div class="free-card-icon">👍</div>
                <h6>Facebook</h6>
                <p>Share on Facebook</p>

                @if(in_array('facebook', $freeLeadPlatforms))
                    <button class="free-btn disabled" disabled>Already Applied</button>
                    <div class="text-success small fw-semibold mt-2">✔ Screenshot already submitted</div>
                @else
                    <button class="free-btn" onclick="toggleUpload('facebook')">Claim Free Lead</button>

                    <form class="upload-box d-none"
                          id="upload-facebook"
                          method="POST"
                          enctype="multipart/form-data"
                          action="{{ route('vendor.freelead.upload') }}">
                        @csrf
                        <input type="hidden" name="platform" value="facebook">
                        <label class="form-label small fw-semibold mt-2">Upload Screenshot</label>
                        <input type="file" name="screenshot" class="form-control mb-2" required accept="image/*">
                        <button class="btn btn-success btn-sm w-100">Submit Screenshot</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="page-head">
        <h3>Choose the right access pack for your growth stage</h3>
        <p>Credits do not expire. Credits are non-refundable.</p>
    </div>

    <div class="packs-grid">

        <div class="credit-pack pack-green">
            <div class="pack-top">
                <div class="pack-head-row">
                    <div class="pack-left">
                        <div class="pack-badge"><span class="dot"></span> Trial Access</div>
                        <div class="pack-subtitle">Good for testing the platform</div>
                    </div>

                    <div class="pack-price-block">
                        <div class="pack-price">₹199</div>
                        <div class="pack-credits">30 credits</div>
                    </div>
                </div>

                <ul class="pack-points">
                    <li><i class="bi bi-check2"></i> Unlock 1 small project</li>
                    <li><i class="bi bi-check2"></i> Ideal for first-time users</li>
                </ul>

                <div class="pack-footer">
                    <div class="gst-box">
                        <div class="gst-row"><span>GST (18%)</span><span>₹35.82</span></div>
                        <div class="gst-row"><span>Total</span><span>₹234.82</span></div>
                    </div>

                    <button class="pack-btn buy-credit-btn"
                            data-plan="trial"
                            data-amount="199"
                            data-credits="30"
                            data-gst="18"
                            data-cust="{{ $vendor_id }}">
                        Get Trial Access
                    </button>
                </div>
            </div>
        </div>

        <div class="credit-pack pack-blue">
            <div class="pack-top">
                <div class="pack-head-row">
                    <div class="pack-left">
                        <div class="pack-badge"><span class="dot"></span> Starter Access</div>
                        <div class="pack-subtitle">For early regular users</div>
                    </div>

                    <div class="pack-price-block">
                        <div class="pack-price">₹399</div>
                        <div class="pack-credits">70 credits</div>
                    </div>
                </div>

                <ul class="pack-points">
                    <li><i class="bi bi-check2"></i> Unlock 2 small projects</li>
                    <li><i class="bi bi-check2"></i> Or save for 1 mid-size project</li>
                </ul>

                <div class="pack-footer">
                    <div class="gst-box">
                        <div class="gst-row"><span>GST (18%)</span><span>₹71.82</span></div>
                        <div class="gst-row"><span>Total</span><span>₹470.82</span></div>
                    </div>

                    <button class="pack-btn buy-credit-btn"
                            data-plan="starter"
                            data-amount="399"
                            data-credits="70"
                            data-gst="18"
                            data-cust="{{ $vendor_id }}">
                        Get Starter Access
                    </button>
                </div>
            </div>
        </div>

        <div class="credit-pack pack-purple">
            <div class="most-popular"><span>⭐</span> Most Popular</div>

            <div class="pack-top">
                <div class="pack-head-row">
                    <div class="pack-left">
                        <div class="pack-badge"><span class="dot"></span> Builder Access</div>
                        <div class="pack-subtitle">Balanced for working contractors</div>
                    </div>

                    <div class="pack-price-block">
                        <div class="pack-price">₹799</div>
                        <div class="pack-credits">160 credits</div>
                    </div>
                </div>

                <ul class="pack-points">
                    <li><i class="bi bi-check2"></i> Unlock 5 small projects</li>
                    <li><i class="bi bi-check2"></i> Or 1 mid-size project (₹5L–₹25L)</li>
                    <li><i class="bi bi-check2"></i> Credits can be used flexibly</li>
                </ul>

                <div class="pack-footer">
                    <div class="gst-box">
                        <div class="gst-row"><span>GST (18%)</span><span>₹143.82</span></div>
                        <div class="gst-row"><span>Total</span><span>₹942.82</span></div>
                    </div>

                    <button class="pack-btn buy-credit-btn"
                            data-plan="builder"
                            data-amount="799"
                            data-credits="160"
                            data-gst="18"
                            data-cust="{{ $vendor_id }}">
                        Get Builder Access
                    </button>
                </div>
            </div>
        </div>

        <div class="credit-pack pack-red">
            <div class="pack-top">
                <div class="pack-head-row">
                    <div class="pack-left">
                        <div class="pack-badge"><span class="dot"></span> Pro Access</div>
                        <div class="pack-subtitle">For larger and more serious projects</div>
                    </div>

                    <div class="pack-price-block">
                        <div class="pack-price">₹1,499</div>
                        <div class="pack-credits">320 credits</div>
                    </div>
                </div>

                <ul class="pack-points">
                    <li><i class="bi bi-check2"></i> Unlock 2 mid-size projects</li>
                    <li><i class="bi bi-check2"></i> Or 1 large project (₹25L–₹1Cr)</li>
                </ul>

                <div class="pack-footer">
                    <div class="gst-box">
                        <div class="gst-row"><span>GST (18%)</span><span>₹269.82</span></div>
                        <div class="gst-row"><span>Total</span><span>₹1,768.82</span></div>
                    </div>

                    <button class="pack-btn buy-credit-btn"
                            data-plan="pro"
                            data-amount="1499"
                            data-credits="320"
                            data-gst="18"
                            data-cust="{{ $vendor_id }}">
                        Get Pro Access
                    </button>
                </div>
            </div>
        </div>

        <div class="credit-pack pack-dark">
            <div class="pack-top">
                <div class="pack-head-row">
                    <div class="pack-left">
                        <div class="pack-badge"><span class="dot"></span> Power Access</div>
                        <div class="pack-subtitle">For active users and higher bidding frequency</div>
                    </div>

                    <div class="pack-price-block">
                        <div class="pack-price">₹2,999</div>
                        <div class="pack-credits">700 credits</div>
                    </div>
                </div>

                <ul class="pack-points">
                    <li><i class="bi bi-check2"></i> Unlock multiple large projects</li>
                    <li><i class="bi bi-check2"></i> Best for active contractors & MSMEs</li>
                </ul>

                <div class="pack-footer">
                    <div class="gst-box">
                        <div class="gst-row"><span>GST (18%)</span><span>₹539.82</span></div>
                        <div class="gst-row"><span>Total</span><span>₹3,538.82</span></div>
                    </div>

                    <button class="pack-btn buy-credit-btn"
                            data-plan="power"
                            data-amount="2999"
                            data-credits="700"
                            data-gst="18"
                            data-cust="{{ $vendor_id }}">
                        Get Power Access
                    </button>
                </div>
            </div>
        </div>

        <div class="credit-pack pack-premium full-width">
            <div class="premium-tag"><span>👑</span> Premium Growth Pack</div>

            <div class="pack-top">
                <div class="pack-head-row">
                    <div class="pack-left">
                        <div class="pack-badge"><span class="dot"></span> Enterprise Access</div>
                        <div class="pack-subtitle">Best for scaling firms and serious monthly bidding</div>
                    </div>

                    <div class="pack-price-block">
                        <div class="pack-price">₹20,000</div>
                        <div class="pack-credits">5,000 credits</div>
                    </div>
                </div>

                <ul class="pack-points">
                    <li><i class="bi bi-check2"></i> Best for serious contractors and growing firms</li>
                    <li><i class="bi bi-check2"></i> High-value project access across categories</li>
                    <li><i class="bi bi-check2"></i> Ideal for consistent bidding and long-term use</li>
                    <li><i class="bi bi-check2"></i> Premium visibility support for 1 year</li>
                </ul>

                <div class="year-free-box">
                    <i class="bi bi-gift-fill"></i>
                    1 Year Free Lead Access Included
                </div>

                <div class="pack-footer">
                    <div class="gst-box">
                        <div class="gst-row"><span>GST (18%)</span><span>₹3,600.00</span></div>
                        <div class="gst-row"><span>Total</span><span>₹23,600.00</span></div>
                    </div>

                    <button class="pack-btn buy-credit-btn"
                            data-plan="enterprise"
                            data-amount="20000"
                            data-credits="5000"
                            data-gst="18"
                            data-cust="{{ $vendor_id }}">
                        Get Enterprise Access
                    </button>
                </div>
            </div>
        </div>

    </div>

    <div class="small-note">
        Credits do not expire.<br>
        Credits are non-refundable.<br>
        Enterprise pack includes 1 year free lead access and premium growth support.
    </div>
</div>

<script>
function toggleUpload(platform){
    document.querySelectorAll('.upload-box').forEach(el => el.classList.add('d-none'));
    document.getElementById('upload-'+platform).classList.remove('d-none');
}
</script>

<script>
$(document).on('click', '.buy-credit-btn', function () {

    const amount  = $(this).data('amount');
    const plan    = $(this).data('plan');
    const credits = $(this).data('credits');
    const custId  = $(this).data('cust');

    $.post("{{ route('razorpay.createOrder') }}", {
        _token: "{{ csrf_token() }}",
        amount: amount,
        plan: plan,
        cust_id: custId,
        credits: credits
    }, function (res) {

        if (!res.success) {
            Swal.fire('Error', 'Order failed', 'error');
            return;
        }

        const options = {
            key: res.key,
            amount: res.razor_amount,
            currency: "INR",
            name: "ConstructKaro",
            description: plan + " credits pack",
            order_id: res.order_id,
            handler: function (response) {

                $.post("{{ route('razorpay.verify') }}", {
                    _token: "{{ csrf_token() }}",
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_signature: response.razorpay_signature,
                    plan: plan,
                    amount: amount,
                    credits: credits
                }, function (v) {

                    if (v.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Payment Successful',
                            html: `
                                <p>Credits added successfully.</p>
                                ${v.invoice_url ? `<a href="${v.invoice_url}" target="_blank" class="swal-download-btn">Download Invoice</a>` : ''}
                            `,
                            confirmButtonText: 'OK'
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 2500);

                    } else {
                        Swal.fire('Error', v.message || 'Verification failed', 'error');
                    }

                }).fail(function (xhr) {
                    console.log(xhr.responseText);
                    Swal.fire('Error', 'Verification request failed', 'error');
                });
            },
            theme: {
                color: "#f25c05"
            }
        };

        const rzp = new Razorpay(options);
        rzp.open();

    }).fail(function (xhr) {
        console.log(xhr.responseText);
        Swal.fire('Error', 'Create order failed', 'error');
    });
});
</script>

@endsection
