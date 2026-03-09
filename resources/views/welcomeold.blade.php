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
/* FEATURE CARD CONSISTENCY */
.feature-card{
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

/* ICON FIX */
.feature-icon{
    width: 38px;
    height: 38px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* TEXT BALANCE */
.feature-card h6{
    min-height: 22px;
}

.feature-card p{
    min-height: 48px;
    line-height: 1.35;
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

/* ===== HOW IT WORKS COLORFUL ===== */
.how-it-works{
    background: linear-gradient(180deg,#ffffff,#f6f8ff);
}

/* Badge */
.how-badge{
    display:inline-block;
    background: linear-gradient(135deg,#2563eb,#3b82f6);
    color:#fff;
    padding:6px 16px;
    border-radius:999px;
    font-size:.8rem;
    font-weight:600;
}

/* Flow Cards */
.flow-card.colorful{
    position:relative;
    border-radius:22px;
    padding:34px 26px 28px;
    background:#fff;
    box-shadow:0 14px 40px rgba(0,0,0,0.08);
    transition:.35s ease;
}

.flow-card.colorful:hover{
    transform:translateY(-8px);
    box-shadow:0 25px 55px rgba(0,0,0,0.15);
}

/* Step Number */
.step-number{
    position:absolute;
    top:18px;
    right:22px;
    font-size:2.4rem;
    font-weight:900;
    opacity:0.08;
}

/* Icon Circle */
.flow-card.colorful .flow-icon-circle{
    width:64px;
    height:64px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:26px;
    color:#fff;
    margin:0 auto 16px;
}

/* Colors */
.flow-card.blue .flow-icon-circle{
    background:linear-gradient(135deg,#2563eb,#3b82f6);
}
.flow-card.orange .flow-icon-circle{
    background:linear-gradient(135deg,#f25c05,#ff9731);
}
.flow-card.green .flow-icon-circle{
    background:linear-gradient(135deg,#16a34a,#22c55e);
}

/* Text */
.flow-card h5{
    font-weight:800;
    margin-bottom:10px;
    color:#0f172a;
}
.flow-card p{
    font-size:.95rem;
    color:#475569;
    line-height:1.5;
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

/* ===== TESTIMONIAL SECTION ===== */
.testimonial-section{
    background: linear-gradient(180deg,#ffffff,#f6f8ff);
}

/* Badge */
.testimonial-badge{
    display:inline-block;
    background: linear-gradient(135deg,#f25c05,#ff9731);
    color:#fff;
    padding:6px 16px;
    border-radius:999px;
    font-size:.8rem;
    font-weight:600;
}

/* Card */
.testimonial-card.colorful{
    min-width:340px;
    max-width:360px;
    background:#fff;
    border-radius:22px;
    padding:24px;
    box-shadow:0 14px 40px rgba(0,0,0,0.08);
    transition:.35s;
    position:relative;
}

.testimonial-card.colorful:hover{
    transform:translateY(-8px);
    box-shadow:0 25px 60px rgba(0,0,0,0.15);
}

/* Header */
.testimonial-header{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:12px;
}

.testimonial-avatar{
    width:58px;
    height:58px;
    border-radius:50%;
    object-fit:cover;
    border:3px solid #3b82f6;
}

/* Name & role */
.testimonial-name{
    font-weight:700;
    margin:0;
    color:#0f172a;
}
.testimonial-role{
    font-size:.85rem;
    color:#64748b;
    margin:0;
}

/* Rating */
.testimonial-rating i{
    color:#facc15;
    margin-right:2px;
}

/* Text */
.testimonial-text{
    font-size:.9rem;
    color:#475569;
    line-height:1.5;
}

/* Smooth auto-scroll already handled by your existing CSS */

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

/* ===== LEAD SECTION ===== */
.lead-section{
    background: linear-gradient(180deg,#ffffff,#fef3e7);
}

/* Badge */
.lead-badge{
    display:inline-block;
    background: linear-gradient(135deg,#f25c05,#ff9731);
    color:#fff;
    padding:6px 16px;
    border-radius:999px;
    font-size:.8rem;
    font-weight:600;
}

/* Left text */
.lead-subtext{
    color:#475569;
    margin-bottom:16px;
}

/* Points */
.lead-points{
    list-style:none;
    padding:0;
    margin-top:16px;
}
.lead-points li{
    display:flex;
    align-items:center;
    gap:10px;
    margin-bottom:10px;
    font-weight:500;
    color:#0f172a;
}
.lead-points i{
    color:#16a34a;
    font-size:1.1rem;
}

/* Form Card */
.lead-form-card{
    background:#ffffff;
    border-radius:22px;
    padding:28px;
    box-shadow:0 18px 45px rgba(0,0,0,0.12);
}

/* Inputs */
.lead-input{
    background:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:12px;
    padding:12px 16px;
    font-size:.95rem;
}
.lead-input:focus{
    outline:none;
    border-color:#f25c05;
    box-shadow:0 0 0 3px rgba(242,92,5,.2);
}

/* Submit Button */
.lead-submit-btn{
    width:100%;
    background: linear-gradient(135deg,#f25c05,#ff9731);
    color:#fff;
    border:none;
    border-radius:14px;
    padding:14px;
    font-weight:700;
    transition:.25s;
}
.lead-submit-btn:hover{
    transform:translateY(-1px);
    box-shadow:0 10px 30px rgba(242,92,5,.35);
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
.vendor-row{
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: nowrap; /* 🔥 one line */
}
@media(max-width: 992px){
    .vendor-row{
        overflow-x: auto;
        justify-content: flex-start;
        padding-bottom: 10px;
    }
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

/* ===== COLORFUL SMART SEARCH ===== */
.smart-search-section{
    background: linear-gradient(
        180deg,
        #ffffff,
        #f4f7ff
    );
}

/* Badge */
.smart-badge{
    background: linear-gradient(135deg,#2563eb,#3b82f6);
    color:#fff;
    padding:6px 14px;
    border-radius:999px;
    font-size:.8rem;
    font-weight:600;
}

/* Colorful Feature Cards */
.feature-card.colorful{
    height:100%;
    border-radius:18px;
    padding:22px;
    color:#0f172a;
    background:#fff;
    box-shadow:0 12px 30px rgba(0,0,0,0.08);
    transition:.3s;
}

.feature-card.colorful:hover{
    transform:translateY(-6px);
    box-shadow:0 20px 45px rgba(0,0,0,0.15);
}

/* Icon */
.feature-card.colorful .feature-icon{
    width:42px;
    height:42px;
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    margin-bottom:10px;
    color:#fff;
}

/* Color Variants */
.feature-card.blue .feature-icon{
    background:linear-gradient(135deg,#2563eb,#3b82f6);
}
.feature-card.green .feature-icon{
    background:linear-gradient(135deg,#16a34a,#22c55e);
}
.feature-card.orange .feature-icon{
    background:linear-gradient(135deg,#f25c05,#ff9731);
}
.feature-card.purple .feature-icon{
    background:linear-gradient(135deg,#7c3aed,#a78bfa);
}

/* Text Balance */
.feature-card h6{
    font-weight:700;
    margin-bottom:6px;
}
.feature-card p{
    font-size:.9rem;
    color:#475569;
    line-height:1.4;
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
                    Find <span class="hero-highlight">Verified Vendors</span> & 
                    <span class="hero-highlight-blue">Suppliers</span><br>
                    for All Your Construction Projects.
                    If Still Confused,
                    <span class="hero-highlight-blue">Post Your Project</span> For Free Here
                </h1>

                <div class="hero-link mt-4">
                    <a href="{{ route('post') }}" class="cta-link">
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
                    <!-- <span class="trusted-pill"><i class="bi bi-award-fill"></i><strong>{{$supplier}}+ Supplier</strong></span> -->
                    
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
        <!-- <a href="{{ route('supplierserch') }}" class="text-decoration-none">
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
        </a> -->

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


<section class="section-wrapper py-5">
    <div class="container">

        <h2 class="section-title text-center mb-2">Popular Vendor Categories</h2>
        <p class="text-center text-muted mb-3">
            Discover verified professionals commonly required across construction projects
        </p>

        <!-- INFO STRIP -->
        <p class="text-center text-muted mb-5" style="max-width:820px;margin:auto;">
            These categories cover the most frequently searched construction services —
            from planning and design to execution and on-site workforce.
            All vendors listed under these categories are location-based and verified.
        </p>

        <div class="vendor-row">

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-building"></i></div>
                <p class="category-title mb-1">Building Contractor</p>
                <small class="text-muted">
                    RCC, bungalow & building construction execution
                </small>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-house-heart"></i></div>
                <p class="category-title mb-1">Residential Interiors</p>
                <small class="text-muted">
                    Modular kitchens, wardrobes & turnkey interiors
                </small>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-rulers"></i></div>
                <p class="category-title mb-1">Residential Architect</p>
                <small class="text-muted">
                    Planning, approvals & bungalow designs
                </small>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-building-gear"></i></div>
                <p class="category-title mb-1">Industrial Contractor</p>
                <small class="text-muted">
                    Factories, warehouses & PEB sheds
                </small>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-gem"></i></div>
                <p class="category-title mb-1">Luxury Interiors</p>
                <small class="text-muted">
                    Premium finishes & high-end interior execution
                </small>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-people"></i></div>
                <p class="category-title mb-1">Labour Contractor</p>
                <small class="text-muted">
                    Skilled & unskilled construction workforce
                </small>
            </div>

            <div class="category-box">
                <div class="category-icon"><i class="bi bi-buildings"></i></div>
                <p class="category-title mb-1">Commercial Architect</p>
                <small class="text-muted">
                    Offices, retail & commercial planning
                </small>
            </div>

        </div>

        <!-- HELPER NOTE -->
        <p class="text-center text-muted mt-4" style="font-size:0.95rem;">
            👉 Select a category to find nearby verified vendors or post your requirement to receive responses directly.
        </p>

    </div>
</section>



<!-- ================= MATERIALS ================= -->
<section class="section-wrapper py-5" style="background:#f8f9fc;">
    <div class="container">

        <h2 class="section-title text-center mb-2">Construction Materials</h2>
        <p class="text-center text-muted mb-3">
            Order quality materials delivered to your doorstep
        </p>

        <!-- INFO LINE -->
        <p class="text-center text-muted mb-5" style="max-width:820px;margin:auto;">
            Source construction materials directly from verified local suppliers.
            Compare quality, pricing, and availability — without brokers or hidden margins.
        </p>

        <div class="row g-4 justify-content-center text-center">

            <!-- Cement -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/cement.png') }}"
                         class="category-img"
                         alt="Cement">
                    <p class="category-title mb-1">Cement</p>
                    <small class="text-muted">
                        OPC, PPC & ready-mix supply
                    </small>
                </div>
            </div>

            <!-- Sand -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/sand.jpg') }}"
                         class="category-img"
                         alt="Sand">
                    <p class="category-title mb-1">Sand</p>
                    <small class="text-muted">
                        River sand & manufactured sand
                    </small>
                </div>
            </div>

            <!-- Steel -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/steel.jpg') }}"
                         class="category-img"
                         alt="Steel">
                    <p class="category-title mb-1">Steel</p>
                    <small class="text-muted">
                        TMT bars & structural steel
                    </small>
                </div>
            </div>

            <!-- Bricks -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/bricks.png') }}"
                         class="category-img"
                         alt="Bricks">
                    <p class="category-title mb-1">Bricks</p>
                    <small class="text-muted">
                        Clay bricks, AAC & fly ash
                    </small>
                </div>
            </div>

            <!-- Tiles -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/tiles.jpg') }}"
                         class="category-img"
                         alt="Tiles">
                    <p class="category-title mb-1">Tiles</p>
                    <small class="text-muted">
                        Flooring, wall & outdoor tiles
                    </small>
                </div>
            </div>

            <!-- Electricals -->
            <div class="col-lg-2 col-md-3 col-6">
                <div class="category-box">
                    <img src="{{ asset('images/electricals.jpg') }}"
                         class="category-img"
                         alt="Electricals">
                    <p class="category-title mb-1">Electricals</p>
                    <small class="text-muted">
                        Wires, switches & fittings
                    </small>
                </div>
            </div>

        </div>

        <!-- TRUST NOTE -->
        <p class="text-center text-muted mt-4" style="font-size:0.95rem;">
            ✔ Verified suppliers • ✔ Transparent pricing • ✔ Site-delivery support
        </p>

    </div>
</section>


<!-- ================= SMART SEARCH TOOL ================= -->
<section class="section-wrapper smart-search-section">
    <div class="container">
        <div class="row g-4 align-items-center">

            <!-- LEFT CONTENT -->
            <div class="col-lg-5">
                <span class="badge smart-badge mb-2">
                    🔍 Smart Discovery
                </span>

                <h2 class="section-title mb-3">
                    Smart Vendor Search Tool
                </h2>

                <p class="text-muted mb-3">
                    Finding the right construction vendor shouldn’t be confusing.
                    ConstructKaro helps you discover trusted vendors and suppliers
                    using smart, location-based filters.
                </p>

                <p class="fw-semibold text-primary">
                    No brokers. No random calls. Just verified results.
                </p>
            </div>

            <!-- RIGHT FEATURES -->
            <div class="col-lg-7">
                <div class="row g-3">

                    <div class="col-md-6">
                        <div class="feature-card colorful blue">
                            <div class="feature-icon">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <h6>Fast & Reliable</h6>
                            <p>
                                Instantly find vendors who are active,
                                responsive, and relevant to your project.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feature-card colorful green">
                            <div class="feature-icon">
                                <i class="bi bi-ui-checks-grid"></i>
                            </div>
                            <h6>Easy to Use</h6>
                            <p>
                                Simple filters and clean profiles —
                                no technical knowledge required.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feature-card colorful orange">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <h6>Verified Vendors</h6>
                            <p>
                                Each vendor is checked to reduce
                                fake leads and unreliable contacts.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="feature-card colorful purple">
                            <div class="feature-icon">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <h6>Location Based</h6>
                            <p>
                                Find vendors near your site for
                                faster execution and coordination.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>



<!-- ================= HOW IT WORKS ================= -->
<section class="section-wrapper py-5 how-it-works">
    <div class="container">

        <div class="text-center mb-5">
            <span class="how-badge">🚀 Simple Process</span>
            <h2 class="section-title mt-2">How ConstructKaro Works</h2>
            <p class="text-muted">
                From requirement to execution — everything in one structured flow
            </p>
        </div>

        <div class="row g-4 justify-content-center text-center">

            <!-- STEP 1 -->
            <div class="col-md-4">
                <div class="flow-card colorful blue h-100">
                    <div class="step-number">01</div>

                    <div class="flow-icon-circle">
                        <i class="bi bi-person-plus"></i>
                    </div>

                    <h5>Post Your Requirement</h5>
                    <p>
                        Share your project details like location, budget,
                        timeline, and work type in a few simple steps.
                    </p>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="col-md-4">
                <div class="flow-card colorful orange h-100">
                    <div class="step-number">02</div>

                    <div class="flow-icon-circle">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                    <h5>Get Verified Quotes</h5>
                    <p>
                        Nearby verified vendors and suppliers review your
                        requirement and share genuine proposals.
                    </p>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="col-md-4">
                <div class="flow-card colorful green h-100">
                    <div class="step-number">03</div>

                    <div class="flow-icon-circle">
                        <i class="bi bi-send-check"></i>
                    </div>

                    <h5>Hire & Track Work</h5>
                    <p>
                        Compare offers, finalize the right partner,
                        and track work progress with clarity.
                    </p>
                </div>
            </div>

        </div>

    </div>
</section>


<!-- ================= LEAD FORM ================= -->
<section class="section-wrapper lead-section">
    <div class="container">
        <div class="row g-4 align-items-center">

            <!-- LEFT CONTENT -->
            <div class="col-lg-5">
                <span class="lead-badge">💰 Cost Optimization</span>

                <h2 class="section-title mt-2">
                    Reduce Your Construction Cost
                </h2>

                <p class="lead-subtext">
                    ConstructKaro helps you connect directly with verified vendors and suppliers —
                    eliminating unnecessary commissions, delays, and wrong decisions.
                </p>

                <ul class="lead-points">
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Verified vendors & suppliers near your site
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Compare prices transparently without brokers
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Faster execution with better cost control
                    </li>
                    <li>
                        <i class="bi bi-check-circle-fill"></i>
                        Genuine leads with clear scope & requirements
                    </li>
                </ul>
            </div>

            <!-- RIGHT FORM -->
            <div class="col-lg-7">
                <div class="lead-form-card">
                    <h5 class="fw-bold mb-2">Tell Us About Your Requirement</h5>
                    <p class="small text-muted mb-3">
                        Share your details and our system will match you with suitable vendors.
                    </p>

                    <form action="{{ route('save.leadform') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <input class="lead-input w-100" name="name" placeholder="Your Name" required>
                            </div>

                            <div class="col-md-6">
                                <input class="lead-input w-100" name="company_name" placeholder="Company Name (Optional)">
                            </div>

                            <div class="col-md-6">
                                <input class="lead-input w-100" name="phone" placeholder="Phone Number" required>
                            </div>

                            <div class="col-md-6">
                                <input class="lead-input w-100" name="email" placeholder="Work Email" required>
                            </div>

                            <div class="col-12">
                                <input class="lead-input w-100" name="requirement" placeholder="Requirement Type (e.g. Bungalow, PEB Shed)" required>
                            </div>

                            <div class="col-12">
                                <button type="submit" class="lead-submit-btn">
                                    Get Matched With Vendors →
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================= TESTIMONIALS ================= -->
<section class="section-wrapper  testimonial-section">
    <div class="container">

        <div class="text-center mb-4">
            <span class="testimonial-badge">⭐ Real Experiences</span>
            <h2 class="section-title mt-2">What People Say About Us</h2>
            <p class="text-muted">
                Trusted by customers, contractors & suppliers across Maharashtra.
            </p>
        </div>

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

                @foreach ($testimonials as $t)
                <div class="testimonial-card colorful">

                    <!-- USER -->
                    <div class="testimonial-header">
                        <img 
                            src="{{ asset('images/testo/'.$t['image']) }}" 
                            class="testimonial-avatar"
                            alt="{{ $t['name'] }}"
                        >

                        <div>
                            <p class="testimonial-name">{{ $t['name'] }}</p>
                            <p class="testimonial-role">{{ $t['role'] }}</p>
                        </div>
                    </div>

                    <!-- RATING -->
                    <div class="testimonial-rating mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $t['rating'])
                                <i class="bi bi-star-fill"></i>
                            @else
                                <i class="bi bi-star"></i>
                            @endif
                        @endfor
                    </div>

                    <!-- TEXT -->
                    <p class="testimonial-text">
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
