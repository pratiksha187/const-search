@extends('layouts.app')

@section('title', 'Construction Vendor Discovery | ConstructKaro')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>

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

.section-wrapper {
    padding: 70px 0 40px;
}

.section-title {
    font-size: 2rem;
    font-weight: 800;
    color: var(--navy);
}

.hero-inner {
    position: relative;
    z-index: 3;
}

.hero-badge {
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

.category-icon i {
    color: var(--blue);
    font-size: 1.4rem;
}

.category-title {
    font-weight: 700;
    margin-top: 12px;
}

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


.flow-wrapper {
    position: relative;
    margin-top: 40px;
}

.flow-wrapper::before {
    content: "";
    position: absolute;
    top: 36px;
    left: 8%;
    right: 8%;
    height: 3px;
    background: linear-gradient(90deg, var(--blue));
    opacity: 0.6;
}



.flow-label {
    color: var(--blue);
    font-size: 0.78rem;
    letter-spacing: 0.08em;
}

.flow-card {
    background: #fff;
    padding: 22px 20px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}

.vendor-card {
    background: #fff;
    padding: 24px;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.06);
}

.vendor-icon {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    background: var(--blue-soft);
    color: var(--blue);
    display: flex;
    align-items: center;
    justify-content: center;
}

.vendor-tags span {
    background: var(--blue-soft);
    padding: 5px 10px;
    border-radius: 999px;
    color: var(--blue);
    font-size: .8rem;
}

.cta-box {
    background: linear-gradient(135deg, var(--blue-light));
    padding: 30px;
    border-radius: 24px;
    color: #fff;
}

.cta-btn {
    background: #fff;
    color: var(--blue);
    padding: 10px 24px;
    border-radius: 999px;
    border: none;
    font-weight: 600;
}

.lead-card {
    background: #0f172a;
    color: #e5e7eb;
    border-radius: 24px;
    padding: 30px;
}

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

.flow-icon-circle {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #1e3a8a); /* blue gradient */
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
    color: white;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(30, 58, 138, 0.35);
}

.testimonial-auto-wrapper {
    overflow: hidden;
    position: relative;
    width: 100%;
}

.testimonial-track {
    display: flex;
    gap: 24px;
    width: max-content;
    animation: autoScroll 25s linear infinite;
    padding-bottom: 20px;
}

/* pause on hover */
.testimonial-auto-wrapper:hover .testimonial-track {
    animation-play-state: paused;
}

@keyframes autoScroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

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

.testimonial-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 18px 40px rgba(0,0,0,0.12);
}

/* Avatar */
.testimonial-avatar {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #3b82f6;
}

.testimonial-rating i {
    color: #facc15;
}

.hero-title {
    font-family: 'Sora', sans-serif !important;
    letter-spacing: 1px;
}

.hero-new {
    position: relative;
    /* padding:123px 0 110px; */
    padding: 140px 0 110px;
    background: radial-gradient(circle at top, #ffffff 8%, #f1f4fa 55%, #e5e9f2 100%);
    overflow: hidden;
}

.hero-new::before {
    content: "";
    position: absolute;
    inset: 0;
    background-image:
        linear-gradient(#dce3ef 1px, transparent 1px),
        linear-gradient(90deg, #dce3ef 1px, transparent 1px);
    background-size: 58px 58px;
    opacity: 0.25;
}

/* ---- Left Hero ---- */
.hero-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1c2c3e;
    line-height: 1.25;
}

.hero-highlight {
    color: #f25c05;
}
.hero-highlight-blue{
    color: #1669d5ff;
}

.hero-subtext {
    color: #6b7484;
    font-size: 1.1rem;
}


.location-box {
    background: rgba(255,255,255,0.9);
    padding: 10px 16px;
    border-radius: 40px;
    backdrop-filter: blur(10px);
    display: flex;
    gap: 8px;
    flex: 0 0 30%;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.05);
}

.location-icon {
    font-size: 1.2rem;
    color: var(--orange);
}

.hero-location-input {
    border: none;
    outline: none;
    width: 100%;
    background: transparent;
    font-size: 1rem;
    color: var(--navy);
}



/* Trusted Pills */
.trusted-pill {
    background: #fff;
    padding: 8px 18px;
    border-radius: 999px;
    font-size: 0.9rem;
    color: #6b7484;
    box-shadow: 0 8px 16px rgba(0,0,0,0.05);
}

.stats-card-hero {
    background: rgba(255,255,255,0.85);
    border: 1px solid rgba(255,255,255,0.4);
    border-radius: 24px;
    padding: 11px;
    box-shadow: 0 18px 45px rgba(0, 0, 0, 0.12);
    backdrop-filter: blur(12px);
    position: relative;
    overflow: hidden;
}

.stats-card-hero::before {
    content: "";
    position: absolute;
    width: 200px;
    height: 200px;
    right: -50px;
    top: -50px;
    background: radial-gradient(circle, rgba(37,99,235,0.18), transparent 70%);
    border-radius: 50%;
}

.stats-header {
    font-size: 1rem;
    font-weight: 700;
    color: #1c2c3e;
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 20px;
}

.stats-header i {
    color: #2563eb;
    font-size: 1.4rem;
}

.stats-row {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.stats-box {
    text-align: center;
    width: 48%;
}

.stats-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: #fff;
    font-size: 1.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
    box-shadow: 0 12px 25px rgba(37,99,235,0.35);
}

.stat-num {
    font-size: 2rem;
    font-weight: 800;
    color: #1c2c3e;
    margin-bottom: 5px;
}

.stat-label {
    color: #6b7484;
    font-size: 0.9rem;
}

/* Bar Chart */
.metrics-bar {
    height: 10px;
    background: #e5e9f2;
    border-radius: 999px;
    margin: 12px 0;
    overflow: hidden;
}

.bar-fill {
    height: 100%;
    background: linear-gradient(90deg, #f25c05, #ff8f38);
    border-radius: 999px;
    transition: 1s ease;
}

.bar-label {
    font-size: 0.85rem;
    color: #6b7484;
}

.hero-illustration {
    text-align: center;
    animation: floatUpDown 4s ease-in-out infinite;
}

.hero-img {
    width: 90%;
    max-width: 420px;
}

@keyframes floatUpDown {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
    100% { transform: translateY(0px); }
}


.search-bar-wrapper {
    display: flex;
    align-items: center;
    background: #fff;
    padding: 8px;
    border-radius: 60px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.08);
    border: 1px solid rgba(0,0,0,0.06);
    gap: 52px;
}

/* Items inside */
.search-item {
    display: flex;
    align-items: center;
    gap: 10px;
    flex: 1;
    padding: 10px 18px;
    border-radius: 50px;
}

/* Location box */
.search-location i {
    font-size: 1.3rem;
    color: var(--orange);
}

/* Keyword box */
.search-keyword i {
    font-size: 1.2rem;
    color: #8791a6;
}

.search-item input {
    border: none;
    outline: none;
    flex: 1;
    font-size: 1rem;
    background: transparent;
    color: #1c2c3e;
}

/* Divider between location & keyword */
.divider {
    width: 1px;
    height: 34px;
    background: rgba(0,0,0,0.10);
}

/* Search Button (Right Round Button) */
.search-btn-final {
    background: linear-gradient(135deg, #2563eb, #3b82f6);
    color: white;
    padding: 12px 28px;
    border-radius: 50px;
    border: none;
    font-weight: 600;
    box-shadow: 0 8px 18px rgba(37,99,235,0.35);
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Hover */
.search-btn-final:hover {
    opacity: .92;
}

/* Responsive */
@media(max-width: 768px) {
    .search-bar-wrapper {
        flex-direction: column;
        border-radius: 24px;
        padding: 16px;
    }

    .divider {
        display: none;
    }

    .search-item {
        width: 100%;
        padding: 12px;
        background: rgba(255,255,255,0.7);
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .search-btn-final {
        width: 100%;
        justify-content: center;
    }
}

.dropdown-premium select {
    width: 119%;
    padding: 14px 20px;
    border-radius: 14px;
    border: 1px solid #d4d8e0;
    background: #fff;
    font-size: 1rem;
    transition: 0.3s;
}

.dropdown-premium select:hover {
    border-color: #2563eb;
    box-shadow: 0 0 8px rgba(37,99,235,0.25);
}

.dropdown-premium select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.3);
}


:root {
    --navy: #1c2c3e;
    --orange: #f25c05;
}

/* Flow Card Styling */
.flow-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 8px 18px rgba(0,0,0,0.08);
    transition: 0.3s ease-in-out;
}
.flow-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.12);
}

/* Icon Circle Styling */
.flow-icon-circle {
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

.category-box {
    background: #fff;
    border-radius: 18px;
    padding: 25px 10px;
    transition: 0.3s ease-in-out;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

.category-box:hover {
    transform: translateY(-6px);
    box-shadow: 0 14px 35px rgba(0,0,0,0.08);
}

.category-icon {
    font-size: 42px;
    margin-bottom: 12px;
    color: #f25c05; 
}

.category-title {
    font-weight: 600;
    color: #000;
    margin-bottom: 0;
}


.colored-toast.swal2-icon-success {
    background-color: #00b853 !important;
}
.colored-toast.swal2-popup {
    color: #fff !important;
    font-weight: 600;
}
</style>



@if(session('success'))
<script>
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    iconColor: 'white',
    customClass: {
        popup: 'colored-toast'
    },
    timer: 3000,
    timerProgressBar: true,
    showConfirmButton: false
});
Toast.fire({
    icon: 'success',
    title: "{{ session('success') }}"
});
</script>
@endif

 
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
                <div class="search-bar-wrapper">

                    <!-- Location -->
                    <div class="search-item search-location">
                        <i class="bi bi-geo-alt-fill"></i>
                        <input type="text" placeholder="Location (City / Area)">
                    </div>

                    <!-- Divider -->
                    <div class="divider"></div>

                    <!-- Keyword -->
                   <div class="dropdown-premium">
                        <select>
                            <option>Select Service...</option>
                            <option>Contractors</option>
                            <option>Material Suppliers</option>
                            <option>Machinery</option>
                            <option>Architects</option>
                            <option>Interior Designers</option>
                            <option>Consultants</option>
                            <option>Labour Vendors</option>
                            <option>Surveyors</option>
                        </select>
                    </div>

                    <button type="button" class="search-btn-final" onclick="openLoginPrompt()"> <i class="bi bi-search"></i> Search
                    </button>
                </div>



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
</section>

<section class="section-wrapper py-5">
    <div class="container">

        <h2 class="section-title text-center mb-2">Popular Vendor Categories</h2>
        <p class="text-center text-muted mb-5">Find trusted professionals for your construction needs</p>

        <div class="row g-4 justify-content-center text-center">

            <!-- Building Contractor -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-building"></i></div>
                    <p class="category-title">Building Contractor</p>
                </div>
            </div>

            <!-- Interior Designer -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-palette"></i></div>
                    <p class="category-title">Interior Designer</p>
                </div>
            </div>

            <!-- Architect -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-rulers"></i></div>
                    <p class="category-title">Architect</p>
                </div>
            </div>

            <!-- Plumber -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-tools"></i></div>
                    <p class="category-title">Plumber</p>
                </div>
            </div>

            <!-- Electrician -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-lightning-charge"></i></div>
                    <p class="category-title">Electrician</p>
                </div>
            </div>

            <!-- Carpenter -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                    <p class="category-title">Carpenter</p>
                </div>
            </div>

        </div>

    </div>
</section>
<section class="section-wrapper py-5" style="background:#f8f9fc;">
    <div class="container">

        <h2 class="section-title text-center mb-2">Construction Materials</h2>
        <p class="text-center text-muted mb-5">Order quality materials delivered to your doorstep</p>

        <div class="row g-4 justify-content-center text-center">

            <!-- Cement -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-buildings"></i></div>
                    <p class="category-title">Cement</p>
                </div>
            </div>

            <!-- Sand -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-cloud"></i></div>
                    <p class="category-title">Sand</p>
                </div>
            </div>

            <!-- Steel -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-hammer"></i></div>
                    <p class="category-title">Steel</p>
                </div>
            </div>

            <!-- Bricks -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                    <p class="category-title">Bricks</p>
                </div>
            </div>

            <!-- Tiles -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-border-all"></i></div>
                    <p class="category-title">Tiles</p>
                </div>
            </div>

            <!-- Electricals -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <div class="category-icon"><i class="bi bi-lightning-charge"></i></div>
                    <p class="category-title">Electricals</p>
                </div>
            </div>

        </div>

    </div>
</section>

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
<section class="section-wrapper py-5">
    <div class="container">

        <h2 class="section-title text-center mb-2">How ConstructKaro Works</h2>
        <p class="text-center text-muted mb-5">Simple 3-step process</p>

        <div class="row g-4 justify-content-center text-center">

            <!-- STEP 1 -->
            <div class="col-md-4">
                <div class="flow-card p-4 h-100">
                    
                    <div class="flow-icon-circle mx-auto mb-3">
                        <i class="bi bi-person-plus"></i>
                    </div>

                    <h5 class="fw-bold text-dark">Post Your Requirement</h5>
                    <p class="text-muted small mb-0">
                        Share your construction needs, budget & timeline.
                    </p>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="col-md-4">
                <div class="flow-card p-4 h-100">

                    <div class="flow-icon-circle mx-auto mb-3">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                    <h5 class="fw-bold text-dark">Get Verified Quotes</h5>
                    <p class="text-muted small mb-0">
                        Receive proposals from trusted & verified vendors.
                    </p>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="col-md-4">
                <div class="flow-card p-4 h-100">

                    <div class="flow-icon-circle mx-auto mb-3">
                        <i class="bi bi-send-check"></i>
                    </div>

                    <h5 class="fw-bold text-dark">Hire & Track Work</h5>
                    <p class="text-muted small mb-0">
                        Compare, hire the best vendor & monitor progress online.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>


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
<section class="section-wrapper">
    <div class="container">

        <h2 class="section-title text-center mb-3">What People Say About Us</h2>
        <p class="text-center text-muted mb-4">
            Trusted by customers, contractors & suppliers across Maharashtra.
        </p>

        <div class="testimonial-auto-wrapper">
            <div class="testimonial-track">

                <!-- ================= CARDS SET 1 ================= -->
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

                <!-- ================= CARDS SET 2 (duplicate for infinite scroll) ================= -->
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
    // let loc = document.querySelector('.hero-location-input').value;
    // let kw  = document.querySelector('.hero-search-input').value;

    window.location.href = "{{ route('search_vendor') }}";
}


function openLoginPrompt() {
    const modal = new bootstrap.Modal(document.getElementById('loginPromptModal'));
    modal.show();
}

</script>

@endsection
