@extends('layouts.app')

@section('title', 'Construction Vendor Discovery | ConstructKaro')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* ================= THEME ================= */
:root {
    --orange: #f25c05;
    --orange-light: #ff9731;

    --blue: #2563eb;
    --blue-light: #3b82f6;
    --blue-soft: #e0eaff;

    --navy: #1c2c3e;
    --gray: #6b7484;
    --bg: #f5f7fb;
}

body {
    background: var(--bg);
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
}

/* ================= GENERIC ================= */
.section-wrapper { padding: 70px 0 40px; }
.section-title { font-size: 2rem; font-weight: 800; color: var(--navy); }

.category-box {
    background: white;
    padding: 24px;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    transition: .3s;
}
.category-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0,0,0,0.12);
}
.category-icon {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    background: var(--blue-soft);
    display: flex;
    align-items: center;
    justify-content: center;
}
.category-icon i { color: var(--blue); font-size: 1.4rem; }
.category-title { font-weight: 700; margin-top: 12px; }

/* Feature */
.feature-card {
    padding: 24px;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 12px 35px rgba(0,0,0,0.05);
}
.feature-icon {
    width: 34px;
    height: 34px;
    border-radius: 12px;
    background: var(--blue-soft);
    color: var(--blue);
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Flow */
.flow-card{
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
    transition: 0.3s ease-in-out;
}
.flow-card:hover{
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.12);
}
.flow-icon-circle{
    width: 65px;
    height: 65px;
    border-radius: 50%;
    background: var(--orange);
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 28px;
    color: #fff;
}

/* Lead form */
.lead-card { background: #0f172a; color: #e5e7eb; border-radius: 24px; padding: 30px; }

.lead-input {
    background: #e6ebf4;
    border: 1px solid #334155;
    padding: 10px 16px;
    border-radius: 999px;
    color: #020202;
}
.lead-card button {
    background: var(--blue) !important;
    border-radius: 999px;
    padding: 12px;
    font-size: 1rem;
    color: #fff !important;
}

/* Testimonials */
.testimonial-auto-wrapper { overflow: hidden; position: relative; width: 100%; }
.testimonial-track {
    display: flex;
    gap: 24px;
    width: max-content;
    animation: autoScroll 25s linear infinite;
    padding-bottom: 20px;
}
.testimonial-auto-wrapper:hover .testimonial-track { animation-play-state: paused; }
@keyframes autoScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }
.testimonial-card {
    min-width: 320px;
    max-width: 340px;
    flex: 0 0 auto;
    background: #ffffff;
    border-radius: 20px;
    padding: 26px;
    box-shadow: 0 12px 28px rgba(0,0,0,0.06);
    transition: 0.3s;
}
.testimonial-card:hover { transform: translateY(-6px); box-shadow: 0 18px 40px rgba(0,0,0,0.12); }
.testimonial-avatar {
    width: 60px; height: 60px; border-radius: 50%;
    object-fit: cover; border: 3px solid #3b82f6;
}
.testimonial-rating i { color: #facc15; }

/* Toast */
.colored-toast.swal2-icon-success { background-color: #00b853 !important; }
.colored-toast.swal2-popup { color: #fff !important; font-weight: 600; }

/* ================= HERO (PREMIUM) ================= */
.hero-new{
    position: relative;
    padding: 140px 0 220px; /* extra bottom so overlap feels premium */
    background: radial-gradient(circle at top, #ffffff 8%, #f1f4fa 55%, #e5e9f2 100%);
    overflow: hidden;
}
.hero-new::before{
    content:"";
    position:absolute;
    inset:0;
    background-image:
        linear-gradient(#dce3ef 1px, transparent 1px),
        linear-gradient(90deg, #dce3ef 1px, transparent 1px);
    background-size: 58px 58px;
    opacity: .22;
}
.hero-new::after{
    /* focus glow behind overlap cards (premium touch) */
    content:"";
    position:absolute;
    left:50%;
    bottom:-130px;
    width:560px;
    height:260px;
    transform:translateX(-50%);
    background: radial-gradient(circle, rgba(37,99,235,0.18), transparent 70%);
    z-index: 1;
}

.hero-inner{ position: relative; z-index: 3; }

.hero-badge{
    background: rgba(37,99,235,0.12);
    color: var(--blue);
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 0.85rem;
    font-weight: 600;
    display: inline-flex;
    gap: 8px;
    align-items: center;
}

.hero-title{
    font-size: 2.35rem;
    font-weight: 900;
    color: #1c2c3e;
    line-height: 1.18;
    letter-spacing: .2px;
}
.hero-highlight{ color: var(--orange); }
.hero-highlight-blue{ color: #1669d5ff; }

.hero-subtext{ color: #6b7484; font-size: 1.1rem; max-width: 640px; }

.search-bar-wrapper{
    display:flex;
    align-items:center;
    background:#fff;
    padding: 10px;
    border-radius: 999px;
    box-shadow: 0 18px 55px rgba(0,0,0,0.10);
    border: 1px solid rgba(0,0,0,0.06);
    gap: 16px;
    max-width: 700px;
}
.search-item{
    display:flex;
    align-items:center;
    gap:10px;
    flex:1;
    padding: 10px 18px;
}
.search-location i{ font-size:1.25rem; color: var(--orange); }
.search-item input{
    border:none;
    outline:none;
    flex:1;
    font-size:1rem;
    background:transparent;
    color:#1c2c3e;
}
.divider{ width:1px; height:34px; background: rgba(0,0,0,0.10); }

.dropdown-premium select{
    width: 240px;
    padding: 12px 16px;
    border-radius: 14px;
    border: 1px solid #d4d8e0;
    background: #fff;
    font-size: 1rem;
    transition: 0.3s;
}
.dropdown-premium select:hover{ border-color:#2563eb; box-shadow: 0 0 10px rgba(37,99,235,0.18); }
.dropdown-premium select:focus{ border-color:#2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.22); outline: none; }

.search-btn-final{
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: white;
    padding: 12px 26px;
    border-radius: 999px;
    border: none;
    font-weight: 700;
    box-shadow: 0 10px 25px rgba(37,99,235,0.35);
    display:flex;
    align-items:center;
    gap:8px;
    transition:.25s;
    white-space: nowrap;
}
.search-btn-final:hover{ transform: translateY(-1px); opacity:.95; }

.trusted-pill{
    background:#fff;
    padding: 8px 16px;
    border-radius: 999px;
    font-size: .9rem;
    color:#6b7484;
    box-shadow: 0 10px 18px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
}
.trusted-pill strong{ color:#0f172a; }

.hero-illustration{
    text-align:center;
    animation: floatUpDown 4.5s ease-in-out infinite;
}
/* .hero-img{ width: 92%; max-width: 440px; } */
.hero-img{
    width:100%;
    max-width:440px;
    filter:drop-shadow(0 40px 60px rgba(0,0,0,.15));
}
@keyframes floatUpDown {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
    100% { transform: translateY(0px); }
}

/* ======= OVERLAP CARDS (HALF IN / HALF OUT) ======= */
.hero-overlap-cards{
    position:absolute;
    left:50%;
    bottom:97px; /* half outside */
    transform:translateX(-50%);
    display:flex;
    gap: 22px;
    z-index: 6;
}



.overlap-card:hover{
    transform: translateY(-6px);
    box-shadow:
        0 40px 80px rgba(15,23,42,0.25),
        0 15px 30px rgba(15,23,42,0.12);
}

.card-icon{
    width: 56px;
    height: 56px;
    border-radius: 18px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size: 22px;
    box-shadow: 0 12px 25px rgba(0,0,0,.20);
}

.icon-blue{ background: linear-gradient(135deg, #2563eb, #3b82f6); }
.icon-orange{ background: linear-gradient(135deg, #f25c05, #ff9731); }
.icon-green{ background: linear-gradient(135deg, #16a34a, #22c55e); }

.overlap-card h6{
    margin:0;
    font-weight: 800;
    color: #0f172a;
    font-size: 1rem;
    letter-spacing: .2px;
}
.overlap-card p{
    margin:0;
    font-size: .88rem;
    color: #6b7484;
    line-height: 1.35;
}

.icon-purple{
    background: #eef2ff;
    color: #6366f1;
}

.vendor-row{
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: nowrap; /* 🔥 one line */
}

.category-box{
    min-width: 180px;
    background: #fff;
    border-radius: 18px;
    padding: 30px 20px;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,.05);
}
@media(max-width: 992px){
    .vendor-row{
        overflow-x: auto;
        justify-content: flex-start;
        padding-bottom: 10px;
    }
}

/* subtle floating motion */
@keyframes floatSoft {
    0% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
    100% { transform: translateY(0); }
}
.overlap-card {
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(14px);
    border-radius: 22px;
    height: 180px;
    padding: 20px 22px;
    width: 280px;
    display: flex;
    align-items: center;
    gap: 14px;
    border: 1px solid rgba(255, 255, 255, 0.65);
    box-shadow: 0 30px 60px rgba(15, 23, 42, 0.18), 0 10px 20px rgba(15, 23, 42, 0.08);
    transition: all .35s ease;
}

.category-img {
    width: 150px;
    height: 100px;
    object-fit: contain;
    margin-bottom: 12px;
}



.section-after-hero {
    padding-top: 29px;
}
.hero-overlap-cards {
    position: absolute;
    left: 50%;
    bottom: 11px;
    transform: translateX(-50%);
    display: flex;
    gap: 22px;
    z-index: 6;
}
/* Responsive hero */
@media(max-width: 992px){
    .search-bar-wrapper{
        flex-direction: column;
        border-radius: 24px;
        align-items: stretch;
    }
    .divider{ display:none; }
    .dropdown-premium select{ width: 100%; }
    .search-btn-final{ width: 100%; justify-content:center; }

   
    .section-after-hero{ padding-top: 70px; }
}

/* ================= RESPONSIVE FIXES ONLY ================= */

/* --------- LARGE TABLETS --------- */
@media (max-width: 1200px) {
    .hero-title {
        font-size: 2rem;
    }
    .hero-img {
        max-width: 380px;
    }
}

/* --------- TABLETS --------- */
@media (max-width: 992px) {

    /* HERO */
    .hero-new {
        padding: 100px 0 160px;
    }

    .hero-inner .row {
        text-align: center;
    }

    .hero-illustration {
        margin-top: 30px;
    }

    /* OVERLAP CARDS → STACK */
    .hero-overlap-cards {
        position: static;
        transform: none;
        margin-top: 40px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .overlap-card {
        width: 90%;
        max-width: 360px;
    }

    .section-after-hero {
        padding-top: 40px;
    }

    /* SEARCH BAR */
    .search-bar-wrapper {
        flex-direction: column;
        border-radius: 20px;
        gap: 10px;
    }

    .search-btn-final {
        width: 100%;
        justify-content: center;
    }

    /* VENDOR ROW */
    .vendor-row {
        overflow-x: auto;
        justify-content: flex-start;
        padding-bottom: 10px;
    }
}

/* --------- MOBILE DEVICES --------- */
@media (max-width: 576px) {

    /* HERO TEXT */
    .hero-title {
        font-size: 1.7rem;
        line-height: 1.3;
    }

    .hero-subtext {
        font-size: 1rem;
    }

    /* BADGE */
    .hero-badge {
        font-size: 0.75rem;
    }

    /* TRUST PILLS */
    .trusted-strip {
        justify-content: center;
    }

    /* OVERLAP CARDS */
    .overlap-card {
        height: auto;
        padding: 16px;
        gap: 12px;
    }

    .card-icon {
        width: 48px;
        height: 48px;
        font-size: 20px;
    }

    /* CATEGORY BOX */
    .category-box {
        min-width: 160px;
        padding: 20px 14px;
    }

    /* MATERIAL GRID */
    .category-img {
        width: 100px;
        height: 80px;
    }

    /* FLOW CARDS */
    .flow-card {
        padding: 20px;
    }

    .flow-icon-circle {
        width: 56px;
        height: 56px;
        font-size: 22px;
    }

    /* TESTIMONIAL */
    .testimonial-card {
        min-width: 280px;
    }

    /* LEAD FORM */
    .lead-input {
        font-size: 0.9rem;
    }

    .lead-card {
        padding: 20px;
    }
}

/* --------- EXTRA SMALL --------- */
@media (max-width: 400px) {
    .hero-title {
        font-size: 1.5rem;
    }
}
/* 
:root{
  --ck-navy:#0f172a;
  --ck-orange:#f25c05;
  --ck-bg:#f6f8fb;
  --ck-border:#e5e7eb;
} */

.modal-xl{
  max-width:1200px;
}

/* Header */
.ck-modal-header{
  background:#ffffff;
  border-bottom:1px solid var(--ck-border);
}

.ck-modal-title{
  color:var(--ck-navy);
  font-weight:700;
}

.ck-modal-subtitle{
  color:#64748b;
  font-size:14px;
}

/* Steps */
.ck-step{
  background:#eef2ff;
  color:#1e3a8a;
  font-weight:600;
  border-radius:6px;
  padding:2px 8px;
  font-size:12px;
}

/* Options */
.ck-option{
  border:1px solid var(--ck-border);
  border-radius:14px;
  padding:14px 16px;
  transition:.2s;
  cursor:pointer;
  background:#fff;
}

.ck-option:hover{
  border-color:var(--ck-orange);
  background:#fff7ed;
}

/* Submit */
.ck-submit{
     background:#f79111;
  /* background:var(--ck-orange); */
  border:none;
  border-radius:14px;
  padding:14px;
  font-weight:700;
}
.hero-link{
    margin-top: 24px;
}

.cta-link{
    font-size: 20px;
    font-weight: 600;
    color: #2563eb; /* Brand blue */
    text-decoration: none;
    position: relative;
    padding-bottom: 4px;
    transition: all 0.25s ease;
}

.cta-link::after{
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, #2563eb, #1e40af);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.3s ease;
}

.cta-link:hover{
    color: #1e40af;
}

.cta-link:hover::after{
    transform: scaleX(1);
}

/* .ck-submit:hover{
  background:#fff7ed;
} */
</style>

@if(session('success'))
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    iconColor: 'white',
    customClass: { popup: 'colored-toast' },
    timer: 3000,
    timerProgressBar: true,
    showConfirmButton: false
});
Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
</script>
@endif

<!-- ================= HERO ================= -->
<section class="hero-new">
    <div class="container hero-inner">
        <div class="row align-items-center g-4">

            <!-- LEFT SIDE -->
            <div class="col-lg-7">

                <span class="hero-badge">
                    <i class="bi bi-lightning-charge-fill"></i>
                    India’s Construction Vendor Platform
                </span>

            
                <h1 class="hero-title mt-3">
                    Find <span class="hero-highlight">Verified Vendors</span> & 
                    <span class="hero-highlight-blue">Suppliers</span><br>
                    for All Your Construction Projects.
                    If Still Confused,
                    <span class="hero-highlight-blue">Post Your Project</span> For Free Here
                </h1>

                <div class="hero-link mt-4">
                    <a href="{{ url('/post-project') }}" class="cta-link">
                        Post Your Project Free →
                    </a>
                </div>

                <p class="hero-subtext">
                    Contractors, architects, interior designers, machinery rentals, material suppliers – all in one place.
                </p>

                <!-- HERO SEARCH BAR -->
                

                <div class="trusted-strip d-flex gap-2 mt-4 flex-wrap">
                    <span class="trusted-pill"><i class="bi bi-building"></i> <strong>{{$vendors}}+ Vendors</strong></span>
                    <span class="trusted-pill"><i class="bi bi-geo-alt"></i> <strong> {{$cities}}+ Cities</strong></span>
                    <span class="trusted-pill"><i class="bi bi-clipboard-check"></i> <strong>{{$posts}}+ Projects</strong></span>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-5 d-flex justify-content-center">
                <div class="hero-illustration">
                    <img src="{{ asset('images/vc.png') }}" alt="Project Planet" class="hero-img">
                </div>
            </div>

        </div>
    </div>

  
    <div class="hero-overlap-cards">

        <!-- FIND VENDORS -->
        <a href="{{ route('search_vendor') }}" class="text-decoration-none">
            <div class="overlap-card">
                <div class="card-icon icon-blue">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h6 class="text-dark mb-1">Find Vendors</h6>
                    <p class="mb-1 text-muted">Find vendors near your site</p>
                    <small class="text-success fw-semibold">
                        ✔ Verified • Rated • Trusted
                    </small>
                </div>
            </div>
        </a>

        <!-- FIND SUPPLIERS -->
        <a href="{{ route('supplierserch') }}" class="text-decoration-none">
            <div class="overlap-card">
                <div class="card-icon icon-orange">
                    <i class="bi bi-geo-alt"></i>
                </div>
                <div>
                    <h6 class="text-dark mb-1">Find Suppliers</h6>
                    <p class="mb-1 text-muted">Find suppliers near your site</p>
                    <small class="text-warning fw-semibold">
                        ✔ Best Price • Fast Delivery
                    </small>
                </div>
            </div>
        </a>

        <!-- FIND CUSTOMER -->
        <a href="{{ route('search_customer') }}" class="text-decoration-none">
            <div class="overlap-card">
                <div class="card-icon icon-green">
                    <i class="bi bi-graph-up"></i>
                </div>
                <div>
                    <h6 class="text-dark mb-1">Find Leads</h6>
                    <p class="mb-1 text-muted">Find Leads near your site</p>
                    <small class="text-primary fw-semibold">
                        ✔ Genuine Leads • No Middlemen
                    </small>
                </div>
            </div>
        </a>

        <a href="javascript:void(0)" 
        class="text-decoration-none"
        data-bs-toggle="modal"
        data-bs-target="#comingSoonModal">

            <div class="overlap-card">
                <div class="card-icon icon-purple">
                    <i class="bi bi-kanban"></i>
                </div>
                <div>
                    <h6 class="text-dark mb-1">Business ERP</h6>
                    <p class="mb-1 text-muted">Manage projects, billing & teams</p>
                    <small class="text-secondary fw-semibold">
                        ✔ All-in-One • Smart Control
                    </small>
                </div>
            </div>
        </a>


    </div>


</section>

<!-- add spacing because cards overlap -->
<div class="section-after-hero"></div>

<!-- ================= POPULAR CATEGORIES ================= -->
<section class="section-wrapper py-5">
    <div class="container">

        <h2 class="section-title text-center mb-2">Popular Vendor Categories</h2>
        <p class="text-center text-muted mb-5">
            Find trusted professionals for your construction needs
        </p>

        <div class="vendor-row">

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-building"></i></div>
                <p class="category-title">Building Contractor</p>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-house-heart"></i></div>
                <p class="category-title">Residential Interiors</p>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-rulers"></i></div>
                <p class="category-title">Residential Architect</p>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-building-gear"></i></div>
                <p class="category-title">Industrial Contractor</p>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-gem"></i></div>
                <p class="category-title">Luxury Interiors</p>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-people"></i></div>
                <p class="category-title">Labour Contractor</p>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-buildings"></i></div>
                <p class="category-title">Commercial Architect</p>
            </div>

        </div>

    </div>
</section>



<!-- ================= MATERIALS ================= -->
<section class="section-wrapper py-5" style="background:#f8f9fc;">
    <div class="container">

        <h2 class="section-title text-center mb-2">Construction Materials</h2>
        <p class="text-center text-muted mb-5">
            Order quality materials delivered to your doorstep
        </p>

        <div class="row g-4 justify-content-center text-center">

            <!-- Cement -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/cement.png') }}"
                         class="category-img"
                         alt="Cement">
                    <p class="category-title">Cement</p>
                </div>
            </div>

            <!-- Sand -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/sand.jpg') }}"
                         class="category-img"
                         alt="Sand">
                    <p class="category-title">Sand</p>
                </div>
            </div>

            <!-- Steel -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/steel.jpg') }}"
                         class="category-img"
                         alt="Steel">
                    <p class="category-title">Steel</p>
                </div>
            </div>

            <!-- Bricks -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/bricks.png') }}"
                         class="category-img"
                         alt="Bricks">
                    <p class="category-title">Bricks</p>
                </div>
            </div>

            <!-- Tiles -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/tiles.jpg') }}"
                         class="category-img"
                         alt="Tiles">
                    <p class="category-title">Tiles</p>
                </div>
            </div>

            <!-- Electricals -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/electricals.jpg') }}"
                         class="category-img"
                         alt="Electricals">
                    <p class="category-title">Electricals</p>
                </div>
            </div>

        </div>

    </div>
</section>

<!-- ================= SMART SEARCH TOOL ================= -->
<section class="section-wrapper">
    <div class="container">
        <div class="row g-4 align-items-center">

            <div class="col-lg-5">
                <h2 class="section-title mb-3">Smart vendor search tool</h2>
                <p class="text-muted">
                    ConstructKaro connects you with verified vendors and suppliers using intelligent filters.
                </p>
            </div>

            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon mb-2"><i class="bi bi-clock-history"></i></div>
                            <h6 class="fw-bold">Fast & Reliable</h6>
                            <p class="text-muted small">Get results instantly.</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon mb-2"><i class="bi bi-ui-checks-grid"></i></div>
                            <h6 class="fw-bold">Easy to Use</h6>
                            <p class="text-muted small">No complicated setup.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ================= HOW IT WORKS ================= -->
<section class="section-wrapper py-5">
    <div class="container">

        <h2 class="section-title text-center mb-2">How ConstructKaro Works</h2>
        <p class="text-center text-muted mb-5">Simple 3-step process</p>

        <div class="row g-4 justify-content-center text-center">
            <div class="col-md-4">
                <div class="flow-card p-4 h-100">
                    <div class="flow-icon-circle mx-auto mb-3">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Post Your Requirement</h5>
                    <p class="text-muted small mb-0">Share your construction needs, budget & timeline.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="flow-card p-4 h-100">
                    <div class="flow-icon-circle mx-auto mb-3">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Get Verified Quotes</h5>
                    <p class="text-muted small mb-0">Receive proposals from trusted & verified vendors.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="flow-card p-4 h-100">
                    <div class="flow-icon-circle mx-auto mb-3">
                        <i class="bi bi-send-check"></i>
                    </div>
                    <h5 class="fw-bold text-dark">Hire & Track Work</h5>
                    <p class="text-muted small mb-0">Compare, hire the best vendor & monitor progress online.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ================= LEAD FORM ================= -->
<section class="section-wrapper">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-lg-5">
                <h2 class="section-title">Reduce Your Construction Cost</h2>
                <p class="text-muted">
                    Get matched with the right vendor at the right price — saving you time, money, and effort.
                </p>

                <ul class="list-unstyled mt-3">
                    <li class="mb-2">✔ Verified vendors & suppliers near your site</li>
                    <li class="mb-2">✔ Compare prices without middlemen</li>
                    <li class="mb-2">✔ Faster decisions, better control</li>
                </ul>
            </div>


            <div class="col-lg-7">
                <form action="{{ route('save.leadform') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input class="lead-input w-100" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="col-md-6">
                            <input class="lead-input w-100" name="company_name" placeholder="Company Name">
                        </div>
                        <div class="col-md-6">
                            <input class="lead-input w-100" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="col-md-6">
                            <input class="lead-input w-100" name="email" placeholder="Work Email" required>
                        </div>
                        <div class="col-12">
                            <input class="lead-input w-100" name="requirement" placeholder="Requirement Type" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn w-100 mt-2" style="background:#f25c05;color:#fff;">
                                Submit Details
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</section>

<!-- ================= TESTIMONIALS ================= -->
<section class="section-wrapper">
    <div class="container">

        <h2 class="section-title text-center mb-3">What People Say About Us</h2>
        <p class="text-center text-muted mb-4">
            Trusted by customers, contractors & suppliers across Maharashtra.
        </p>

        @php
            $testimonials = [
                [
                    'name' => 'Vikram Naik',
                    'role' => 'Civil Contractor | Pen, Maharashtra',
                    'text' => 'Getting genuine private bungalow work is very difficult for small contractors. Through ConstructKaro, I received my first bungalow construction lead in Pen, which actually converted into a real project. The lead was clear, the client was genuine, and there was no unnecessary back-and-forth. ConstructKaro helped me get work without running behind brokers, and that made a big difference for my business.',
                    'image' => 'vikram.jpeg',
                    'rating' => 5,
                ],
                [
                    'name' => 'Sanket Asgaonkar',
                    'role' => 'Land Surveyor & Drone Survey Specialist | Raigad',
                    'text' => 'I had the skills and equipment, but getting the right clients for drone survey work was always a challenge. With ConstructKaro, I got a drone survey requirement in Poladpur which matched exactly with my service profile. The platform helped me connect directly with the client, and the project went smoothly.',
                    'image' => 'sanket.jpg',
                    'rating' => 4,
                ],
                [
                    'name' => 'Ivan Maben',
                    'role' => 'Home Owner | Pen, Maharashtra',
                    'text' => 'While planning my bungalow construction at Pen, I didn’t want to depend on local references alone. Through ConstructKaro, I connected with Shreeyash Construction and finalized them for my 4,000 sq.ft bungalow project. The platform helped me take a confident decision.',
                   'image' => 'ivan.jpg',
                   'rating' => 3,
                ],
                [
                    'name' => 'Mohammed Khopoliwala',
                    'role' => 'Owner, Aarwa Plastics | Khopoli',
                    'text' => 'As a supplier, visibility is very important. After registering on ConstructKaro, we started receiving enquiries from contractors and customers we were not reaching earlier. We received multiple orders for plumbing materials and construction chemicals.',
                    'image' => 'mohammed.jpg',
                    'rating' => 5,
                ],
                [
                    'name' => 'Patil Infra & Realtors Pvt. Ltd.',
                    'role' => 'Real Estate Developer | Khopoli',
                    'text' => 'For our ongoing building projects, finding dependable labour contractors on time is always a challenge. Through ConstructKaro, we were able to identify suitable labour contractors quickly, improving our execution efficiency.',
                    'image' => 'patil-infra.jpg',
                    'rating' => 4,
                ],
                [
                    'name' => 'Samiksha Shirke',
                    'role' => 'Home Owner | Nagothane, Maharashtra',
                    'text' => 'I was planning to construct a bungalow and didn’t know how to start. I posted my requirement on ConstructKaro and received genuine responses. One lead converted into actual work and my bungalow construction has started.',
                    'image' => 'samiksha.jpg',
                    'rating' => 4,
                ],
                [
                    'name' => 'Omkar Vidhate',
                    'role' => 'Architect | Pune',
                    'text' => 'After leaving my job, getting independent projects was challenging. Through ConstructKaro, I received architectural planning and interior design work that matched my skills perfectly.',
                     'image' => 'omkar.jpg',
                     'rating' => 3,
                ],
                [
                    'name' => 'Yashshree',
                    'role' => 'Interior Contractor | Pune',
                    'text' => 'Finding serious interior work in a competitive market like Pune is not easy. Through ConstructKaro, I received an interior project in Kharadi that converted into real work. The lead quality was very good.',
                    'image' => 'yashshree.jpg',
                    'rating' => 5,
                ],
            ];
        @endphp

        <div class="testimonial-auto-wrapper">
            <div class="testimonial-track">

                {{-- FIRST SET --}}
                @foreach ($testimonials as $t)
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                       <img 
                            src="{{ asset('images/testo/'.$t['image']) }}" 
                            class="testimonial-avatar"
                            alt="{{ $t['name'] }}"
                        >

                        <div class="ms-3">
                            <p class="testimonial-name mb-0">{{ $t['name'] }}</p>
                            <p class="testimonial-role mb-0">{{ $t['role'] }}</p>
                        </div>
                    </div>

                   
                    <div class="testimonial-rating mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $t['rating'])
                                <i class="bi bi-star-fill text-warning"></i>
                            @else
                                <i class="bi bi-star text-muted"></i>
                            @endif
                        @endfor
                    </div>


                    <p class="text-muted">
                        {{ $t['text'] }}
                    </p>
                </div>
                @endforeach

                

            </div>
        </div>

    </div>
</section>


<!-- LOGIN REQUIRED MODAL -->
<div class="modal fade" id="loginPromptModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:16px; text-align:center;">
            <div class="modal-header bg-warning">
                <h5 class="modal-title fw-bold">Login Required</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Please login or register first to continue!
            </div>
            <div class="modal-footer d-flex justify-content-center gap-3">
                <a href="{{ route('login_register') }}" class="btn btn-primary">Login</a>
            </div>
        </div>
    </div>
</div>
<!-- <div class="modal fade" id="comingSoonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">🚧 Coming Soon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center py-4">
                <div class="mb-3">
                    <i class="bi bi-hourglass-split fs-1 text-warning"></i>
                </div>

                <h6 class="fw-semibold mb-2">Business ERP Module</h6>
                <p class="text-muted mb-0">
                    This powerful ERP feature is currently under development.  
                    It will be available very soon on ConstructKaro.
                </p>
            </div>

            <div class="modal-footer border-0 justify-content-center">
                <button class="btn btn-warning text-white px-4" data-bs-dismiss="modal">
                    OK, Got it
                </button>
            </div>

        </div>
    </div>
</div> -->
<div class="modal fade" id="comingSoonModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content border-0 rounded-4 shadow-lg">

      <!-- HEADER -->
      <div class="modal-header ck-modal-header px-4 py-3">
        <div>
          <div class="d-flex align-items-center gap-2 mb-1">
            <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro" style="height:30px;">
            <h5 class="ck-modal-title mb-0">ERP</h5>
          </div>
          <p class="ck-modal-subtitle mb-0">
            Tendering + Execution • Interest Registration
          </p>
        </div>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- FEATURE STRIP -->
      <div class="bg-white px-4 py-3 border-bottom">
        <div class="row g-3 text-center">
          <div class="col-md-4">
            <div class="ck-option h-100">
              <div class="fw-bold">All-in-One ERP</div>
              <small class="text-muted">Tender • Execution • Billing</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="ck-option h-100">
              <div class="fw-bold">Construction-Focused</div>
              <small class="text-muted">Built for Indian projects</small>
            </div>
          </div>
          <div class="col-md-4">
            <div class="ck-option h-100">
              <div class="fw-bold">Cost-Effective</div>
              <small class="text-muted">No heavy ERP pricing</small>
            </div>
          </div>
        </div>
      </div>

      <!-- BODY -->
      <div class="modal-body bg-light px-4 py-4">
        <form id="erpInterestForm">

          <!-- 1 -->
          <div class="mb-3">
            <label class="fw-semibold">
              <span class="ck-step me-1">1</span> Full Name *
            </label>
            <input class="form-control form-control-lg" name="full_name" required>
          </div>

          <!-- 2 -->
          <div class="mb-3">
            <label class="fw-semibold">
              <span class="ck-step me-1">2</span> Company Name *
            </label>
            <input class="form-control form-control-lg" name="company_name" required>
          </div>

          <!-- 3 -->
          <!-- <div class="mb-4">
            <label class="fw-semibold">
              <span class="ck-step me-1">3</span> Your Role *
            </label>
            <select class="form-select form-select-lg" name="role_in_org" required>
              <option value="">Select role</option>
              <option>Owner / Founder</option>
              <option>Director</option>
              <option>Project Manager</option>
              <option>Engineer</option>
              <option>Procurement</option>
              <option>Consultant</option>
              <option>Other</option>
            </select>
          </div> -->

          <!-- 3 -->
<div class="mb-4">
  <label class="fw-semibold">
    <span class="ck-step me-1">3</span> Your Role *
  </label>

  <select class="form-select form-select-lg"
          name="role_in_org"
          id="roleSelect"
          required>
    <option value="">Select role</option>
    <option value="Owner / Founder">Owner / Founder</option>
    <option value="Director">Director</option>
    <option value="Project Manager">Project Manager</option>
    <option value="Engineer">Engineer</option>
    <option value="Procurement">Procurement</option>
    <option value="Consultant">Consultant</option>
    <option value="Other">Other</option>
  </select>

  <!-- OTHER ROLE TEXTBOX (HIDDEN) -->
  <div id="roleOtherBox" class="mt-2 d-none">
    <input type="text"
           class="form-control form-control-lg"
           name="role_in_org_other"
           placeholder="Please specify your role">
  </div>
</div>

          <!-- 4 -->
        <div class="mb-4">
        <label class="fw-semibold mb-2 d-block">
            <span class="ck-step me-1">4</span> Organization Type *
        </label>

        @foreach([
            'Real Estate Builder / Developer',
            'EPC / Infrastructure Contractor',
            'Government Tender Contractor',
            'Industrial / Factory Owner',
            'PMC / Consultant',
            'Other'
        ] as $type)
            <label class="ck-option d-flex align-items-center mb-2">
            <input
                type="radio"
                name="organization_type"
                class="me-3 org-type-radio"
                value="{{ $type }}"
                required
            >
            {{ $type }}
            </label>
        @endforeach

        <!-- OTHER TEXTBOX (HIDDEN BY DEFAULT) -->
        <div id="orgTypeOtherBox" class="mt-2 d-none">
            <input type="text"
                class="form-control form-control-lg"
                name="organization_type_other"
                placeholder="Please specify organization type">
        </div>
        </div>


          <!-- 5 -->
          <div class="mb-4">
            <label class="fw-semibold">
              <span class="ck-step me-1">5</span> Project Size *
            </label>
            <select class="form-select form-select-lg" name="project_size" required>
              <option value="">Select size</option>
              <option>Below ₹5 Cr</option>
              <option>₹5 – 25 Cr</option>
              <option>₹25 – 100 Cr</option>
              <option>₹100 Cr+</option>
            </select>
          </div>

          <!-- 6 -->
          <div class="mb-4">
            <label class="fw-semibold mb-2 d-block">
              <span class="ck-step me-1">6</span> Looking For *
            </label>

            @foreach([
              'Tender publishing & bid comparison',
              'BOQ-based tendering',
              'Subcontractor procurement',
              'Execution dashboard',
              'Billing / RA tracking',
              'All-in-one ERP'
            ] as $need)
              <label class="ck-option d-flex align-items-center mb-2">
                <input type="checkbox" name="looking_for[]" class="me-3">
                {{ $need }}
              </label>
            @endforeach
          </div>

          <!-- 7 -->
          <div class="mb-4">
            <label class="fw-semibold mb-2 d-block">
              <span class="ck-step me-1">7</span> Current Challenge *
            </label>

            @foreach([
              'Managing tenders manually',
              'No visibility after L1',
              'Poor execution & billing',
              'ERP too costly / complex',
              'No structured system'
            ] as $c)
              <label class="ck-option d-flex align-items-center mb-2">
                <input type="radio" name="current_challenge" class="me-3" required>
                {{ $c }}
              </label>
            @endforeach
          </div>

          <!-- 8 -->
          <div class="mb-4">
            <label class="fw-semibold mb-2 d-block">
              <span class="ck-step me-1">8</span> Interest Level *
            </label>

            @foreach(['Urgent','Exploring','Maybe','No'] as $i)
              <label class="ck-option d-flex align-items-center mb-2">
                <input type="radio" name="interest_level" class="me-3" required>
                {{ $i }}
              </label>
            @endforeach
          </div>

          <!-- 9 -->
          <div class="mb-4">
            <label class="fw-semibold">
              <span class="ck-step me-1">9</span> Contact Details *
            </label>
            <textarea class="form-control form-control-lg"
                      rows="3"
                      name="contact_details"
                      placeholder="Mobile number & Email"
                      required></textarea>
          </div>

          <!-- SUBMIT -->
          <button type="submit" class="ck-submit w-100 ">
            Submit Registration
          </button>

        </form>
      </div>

    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll(".stat-num").forEach(num => {
    let target = +num.getAttribute("data-target");
    let count = 0;

    let update = () => {
        if (count < target) {
            count += Math.ceil(target / 40);
            num.textContent = count;
            requestAnimationFrame(update);
        } else {
            num.textContent = target;
        }
    };
    update();
});
</script>

<script>
function doSearch() {
    window.location.href = "{{ route('search_vendor') }}";
}

function openLoginPrompt() {
    const modal = new bootstrap.Modal(document.getElementById('loginPromptModal'));
    modal.show();
}
</script>
<script>
document.querySelectorAll('.org-type-radio').forEach(radio => {
    radio.addEventListener('change', function () {

        const otherBox = document.getElementById('orgTypeOtherBox');

        if (this.value === 'Other') {
            otherBox.classList.remove('d-none');
        } else {
            otherBox.classList.add('d-none');
            otherBox.querySelector('input').value = '';
        }
    });
});
</script>
<script>
document.getElementById('roleSelect').addEventListener('change', function () {

    const otherBox = document.getElementById('roleOtherBox');

    if (this.value === 'Other') {
        otherBox.classList.remove('d-none');
    } else {
        otherBox.classList.add('d-none');
        otherBox.querySelector('input').value = '';
    }
});
</script>

<script>
document.getElementById('erpInterestForm').addEventListener('submit', function(e){
    e.preventDefault();

    const formData = new FormData(this);

    fetch("{{ route('erp.interest.save') }}", {
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: formData
    })
    .then(res => res.json())
    .then(res => {
        if(res.status){
            alert('✅ Registration submitted successfully');
            this.reset();
            bootstrap.Modal.getInstance(
                document.getElementById('comingSoonModal')
            ).hide();
        }
    })
    .catch(() => alert('❌ Server error'));
});
</script>

@endsection
