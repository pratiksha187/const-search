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
    background: #1e293b;
    border: 1px solid #334155;
    padding: 10px 16px;
    border-radius: 999px;
    color: white;
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
.hero-img{ width: 92%; max-width: 440px; }
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

/* glass + premium depth */
.overlap-card{
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(14px);
    border-radius: 22px;
    padding: 20px 22px;
    width: 280px;
    display:flex;
    align-items:center;
    gap: 14px;
    border: 1px solid rgba(255,255,255,0.65);
    box-shadow:
        0 30px 60px rgba(15,23,42,0.18),
        0 10px 20px rgba(15,23,42,0.08);
    transition: all .35s ease;
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

/* subtle floating motion */
@keyframes floatSoft {
    0% { transform: translateY(0); }
    50% { transform: translateY(-6px); }
    100% { transform: translateY(0); }
}
/* .hero-overlap-cards .overlap-card:nth-child(1){ animation: floatSoft 6.5s ease-in-out infinite; }
.hero-overlap-cards .overlap-card:nth-child(2){ animation: floatSoft 6.5s ease-in-out infinite; animation-delay: 1s; }
.hero-overlap-cards .overlap-card:nth-child(3){ animation: floatSoft 6.5s ease-in-out infinite; animation-delay: 2s; } */

/* spacing for next section after hero overlap */

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
                    Find <span class="hero-highlight">Verified Vendors</span> & <span class="hero-highlight-blue">Suppliers</span>
                    <br>for All Your Construction Projects
                </h1>

                <p class="hero-subtext">
                    Contractors, architects, interior designers, machinery rentals, material suppliers – all in one place.
                </p>

                <!-- HERO SEARCH BAR -->
                

                <div class="trusted-strip d-flex gap-2 mt-4 flex-wrap">
                    <span class="trusted-pill"><i class="bi bi-building"></i> <strong>{{$vendors}}+ Vendors</strong></span>
                    <span class="trusted-pill"><i class="bi bi-geo-alt"></i> <strong> Cities</strong></span>
                    <span class="trusted-pill"><i class="bi bi-clipboard-check"></i> <strong>{{$posts}}+ Projects</strong></span>
                </div>

            </div>

            <!-- RIGHT SIDE -->
            <div class="col-lg-5 d-flex justify-content-center">
                <div class="hero-illustration">
                    <img src="{{ asset('images/vcr.png') }}" alt="Project Planet" class="hero-img">
                </div>
            </div>

        </div>
    </div>

    <!-- ✅ OVERLAP CARDS (HALF IN / HALF OUT) -->
    <div class="hero-overlap-cards">
        <!-- <div class="overlap-card">
            <div class="card-icon icon-blue"><i class="bi bi-shield-check"></i></div>
            <div>
                <h6>Find Vendors</h6>
                <p>Find vendors near your site</p>
            </div>
        </div> -->
        <a href="{{ route('search_vendor') }}" class="text-decoration-none">
            <div class="overlap-card">
                <div class="card-icon icon-blue">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div>
                    <h6 class="text-dark mb-1">Find Vendors</h6>
                    <p class="mb-0 text-muted">Find vendors near your site</p>
                </div>
            </div>
        </a>

        <a href="{{ route('login_register') }}" class="text-decoration-none">

            <div class="overlap-card">
                <div class="card-icon icon-orange"><i class="bi bi-geo-alt"></i></div>
                <div>
                    <h6>Find Suppliers</h6>
                    <p>Find Suppliers near your site</p>
                </div>
            </div>
        </a>
        <a href="{{ route('search_customer') }}" class="text-decoration-none">

        <div class="overlap-card">
            <div class="card-icon icon-green"><i class="bi bi-graph-up"></i></div>
            <div>
                <h6>Find Customer</h6>
                <p>Find Customer near your site</p>
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
        <p class="text-center text-muted mb-5">Find trusted professionals for your construction needs</p>

        <div class="row g-4 justify-content-center text-center">
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-building"></i></div>
                    <p class="category-title">Building Contractor</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-palette"></i></div>
                    <p class="category-title">Interior Designer</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-rulers"></i></div>
                    <p class="category-title">Architect</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-tools"></i></div>
                    <p class="category-title">Plumber</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-lightning-charge"></i></div>
                    <p class="category-title">Electrician</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                    <p class="category-title">Carpenter</p>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- ================= MATERIALS ================= -->
<section class="section-wrapper py-5" style="background:#f8f9fc;">
    <div class="container">

        <h2 class="section-title text-center mb-2">Construction Materials</h2>
        <p class="text-center text-muted mb-5">Order quality materials delivered to your doorstep</p>

        <div class="row g-4 justify-content-center text-center">
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-buildings"></i></div>
                    <p class="category-title">Cement</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-cloud"></i></div>
                    <p class="category-title">Sand</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-hammer"></i></div>
                    <p class="category-title">Steel</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                    <p class="category-title">Bricks</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-border-all"></i></div>
                    <p class="category-title">Tiles</p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-lightning-charge"></i></div>
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
                <h2 class="section-title">How much can you save?</h2>
                <p class="text-muted">Our team will help you choose the most economical vendor.</p>
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
        <p class="text-center text-muted mb-4">Trusted by customers, contractors & suppliers across Maharashtra.</p>

        <div class="testimonial-auto-wrapper">
            <div class="testimonial-track">

                <!-- CARDS SET 1 -->
                @foreach ([1,2,3,4] as $i)
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://i.pravatar.cc/300?img={{ 10+$i }}" class="testimonial-avatar">
                        <div class="ms-3">
                            <p class="testimonial-name mb-0">User {{ $i }}</p>
                            <p class="testimonial-role mb-0">Role {{ $i }}</p>
                        </div>
                    </div>

                    <div class="testimonial-rating mb-2">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>

                    <p class="text-muted">
                        ConstructKaro helped me find the right vendor quickly and professionally.
                    </p>
                </div>
                @endforeach

                <!-- CARDS SET 2 (duplicate for infinite scroll) -->
                @foreach ([1,2,3,4] as $i)
                <div class="testimonial-card">
                    <div class="d-flex align-items-center mb-3">
                        <img src="https://i.pravatar.cc/300?img={{ 20+$i }}" class="testimonial-avatar">
                        <div class="ms-3">
                            <p class="testimonial-name mb-0">User {{ $i }}</p>
                            <p class="testimonial-role mb-0">Role {{ $i }}</p>
                        </div>
                    </div>

                    <div class="testimonial-rating mb-2">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>

                    <p class="text-muted">
                        Great experience, very easy vendor comparison system.
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

@endsection
