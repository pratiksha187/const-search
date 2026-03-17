@extends('layouts.app')

@section('title', 'Construction Vendor Discovery | ConstructKaro')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<style>
:root{
    --ck-primary:#1c2c3e;
    --ck-secondary:#f25c05;
    --ck-secondary-light:#ff944d;
    --ck-blue:#256ee8;
    --ck-bg:#f8fafc;
    --ck-card:#ffffff;
    --ck-text:#1f1f1f;
    --ck-border:#e8edf3;
}

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

html, body{
    overflow-x:hidden;
}

body{
    font-family:'Montserrat',sans-serif;
    background:var(--ck-bg);
    color:var(--ck-text);
}

img{
    max-width:100%;
    height:auto;
    display:block;
}

.landing-page{
    background:var(--ck-bg);
    min-height:100vh;
    overflow-x:hidden;
}

.container-custom{
    width:min(1220px, 92%);
    margin:0 auto;
    padding:0 16px;
}

/* HERO */
.hero-section{
    background:transparent;
    text-align:center;
    min-height:100vh;
    min-height:100dvh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:40px 0;
}

.custom-section{
    width:100%;
    min-height:100vh;
    min-height:100dvh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:radial-gradient(78.42% 19.37% at 50.03% 96.63%, rgba(205,216,237,0.86) 23.88%, rgba(255,255,255,0.86) 100%);
    box-shadow:0 4px 4px 0 rgba(0,0,0,0.25);
    border-radius:0;
    padding:40px 24px;
}

.hero-section .container-custom{
    width:min(1220px, 92%);
    margin:0 auto;
}

.hero-title{
    margin-top:0;
    margin-bottom:18px;
    display:flex;
    justify-content:center;
}

.hero-title img{
    width:min(1186px, 100%)
    
}

.hero-subtitle{
    max-width:920px;
    margin:0 auto 22px;
    font-size:26px;
    line-height:1.55;
    color:#505050;
    font-weight:500;
}

.hero-subtitle strong{
    display:block;
    margin-top:6px;
    font-weight:800;
    color:var(--ck-primary);
}

.hero-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    text-decoration:none;
    background:linear-gradient(90deg,#f25c05,#ff944d);
    color:#fff;
    font-weight:800;
    font-size:16px;
    padding:18px 34px;
    border-radius:16px;
    box-shadow:0 10px 22px rgba(0,0,0,0.18);
    transition:all 0.35s ease;
    text-shadow:0 3px 6px rgba(0,0,0,0.25);
    min-width:320px;
    max-width:100%;
    text-align:center;
}

.hero-btn i{
    font-size:24px;
    line-height:1;
}

.hero-points-image{
    margin-top:22px;
    display:flex;
    justify-content:center;
}

.hero-points-image img{
    max-width:min(60%, 620px);
    width:100%;
}

.stats-wrap{
    margin-top:26px;
    padding-top:8px;
}

.stats-row{
    display:grid;
    grid-template-columns:repeat(2, max-content);
    justify-content:center;
    gap:70px;
}

.stat-item{
    display:flex;
    align-items:center;
    justify-content:center;
    gap:12px;
}

.stat-img{
    width:auto;
    max-width:46px;
    height:auto;
}

.stat-text{
    text-align:left;
    line-height:1.12;
}

.stat-number{
    display:block;
    font-size:17px;
    font-weight:800;
    color:var(--ck-primary);
}

.stat-label{
    font-size:12px;
    font-weight:700;
    color:#404040;
}

/* HOW IT WORKS */
.how-section{
    padding:60px 0 10px;
}

.section-head{
    display:flex;
    align-items:center;
    gap:28px;
    margin-bottom:34px;
}

.section-head .line{
    flex:1;
    height:1.5px;
    background:#bfc3c9;
}

.section-head h2{
    margin:0;
    font-size:32px;
    font-weight:800;
    color:#2a2a2a;
    white-space:nowrap;
    line-height:1;
}

.steps-image-grid{
    display:grid;
    grid-template-columns:1fr 70px 1fr 70px 1fr;
    align-items:center;
    gap:18px;
}

.step-image-box{
    display:flex;
    justify-content:center;
    align-items:center;
}

.step-full-img{
    width:100%;
    max-width:290px;
    height:auto;
}

.step-arrow{
    text-align:center;
    font-size:40px;
    color:#2e2e2e;
    font-weight:800;
    opacity:.85;
}

/* SERVICES */
.services-section-full{
    width:100%;
    padding:0;
}

.services-shell{
    width:100%;
    border-radius:0;
    padding:50px 24px;
    background:linear-gradient(180deg, #F8F8F8 19.86%, rgba(221,108,35,0.18) 336.99%);
    box-shadow:0 20px 60px rgba(0,0,0,0.08);
}

.services-image-grid{
    width:min(91%, 1600px);
    margin:0 auto;
    display:grid;
    grid-template-columns:repeat(2, 1fr);
    gap:26px;
    align-items:center;
}

.service-image-card{
    display:flex;
    justify-content:center;
    align-items:center;
}

.service-link{
    text-decoration:none;
    cursor:pointer;
}

.service-full-img{
    width:100%;
    max-width:235px;
    transition:transform 0.3s ease, box-shadow 0.3s ease;
    border-radius:12px;
}

.service-link:hover .service-full-img{
    transform:translateY(-4px) scale(1.02);
}

/* CATEGORIES */
.categories-section{
    background:#e9e9e9;
    padding:28px 0 22px;
}

.categories-title{
    text-align:center;
    font-size:30px;
    font-weight:800;
    color:#2f2f2f;
    margin-bottom:10px;
    line-height:1.2;
}

.categories-subtitle{
    text-align:center;
    font-size:14px;
    color:#6c6c6c;
    margin-bottom:6px;
    line-height:1.6;
}

.categories-subtext{
    text-align:center;
    max-width:760px;
    margin:0 auto 34px;
    font-size:13px;
    color:#6f6f6f;
    line-height:1.6;
}

.categories-grid{
    display:grid;
    grid-template-columns:repeat(7, 1fr);
    gap:10px;
    align-items:stretch;
}

.category-card{
    position:relative;
    background:#f8f8f8;
    border:1px solid #bdbdbd;
    border-radius:8px;
    text-align:center;
    padding:32px 10px 10px;
    min-height:82px;
    transition:all 0.3s ease;
}

.category-card:hover{
    transform:translateY(-3px);
    box-shadow:0 8px 18px rgba(0,0,0,0.08);
}

.category-image-box{
    position:absolute;
    top:-22px;
    left:50%;
    transform:translateX(-50%);
    width:42px;
    height:42px;
    border-radius:6px;
    background:#f25c05;
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:0 4px 10px rgba(242,92,5,0.25);
    overflow:hidden;
}

.category-image{
    width:24px;
    height:24px;
    object-fit:contain;
}

.category-name{
    font-size:15px;
    font-weight:700;
    color:#2f2f2f;
    margin:0 0 6px;
    line-height:1.2;
}

.category-desc{
    font-size:14px;
    color:#777;
    line-height:1.2;
    margin:0;
}

.category-note{
    text-align:center;
    margin-top:22px;
    font-size:14px;
    color:#3b3b3b;
    line-height:1.5;
}

/* FEATURE */
.feature-section{
    padding:16px 0 30px;
}

.feature-grid{
    display:grid;
    grid-template-columns:1.03fr .97fr;
    gap:28px;
    align-items:start;
}

.feature-content{
    padding:20px 8px 0 8px;
}

.badge-blue,
.badge-orange{
    display:inline-flex;
    align-items:center;
    gap:6px;
    color:#fff;
    font-size:11px;
    font-weight:700;
    padding:6px 12px;
    border-radius:18px;
    margin-bottom:16px;
}

.badge-blue{
    background:var(--ck-blue);
}

.badge-orange{
    background:var(--ck-secondary);
}

.feature-main-title{
    font-size:38px;
    line-height:1.12;
    font-weight:900;
    color:#202020;
    margin-bottom:14px;
    letter-spacing:-0.8px;
}

.feature-main-desc{
    font-size:16px;
    line-height:1.95;
    color:#666;
    max-width:560px;
}

.mini-features{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:18px;
}

.mini-card{
    background:var(--ck-card);
    border:1px solid var(--ck-border);
    border-radius:22px;
    padding:22px 20px;
    min-height:145px;
    transition:all .3s ease;
    box-shadow:0 10px 30px rgba(28,44,62,0.06);
}

.mini-card:hover{
    transform:translateY(-5px);
    box-shadow:0 22px 60px rgba(28,44,62,0.12);
}

.mini-icon{
    width:44px;
    height:44px;
    border-radius:12px;
    background:#eef4ff;
    color:var(--ck-blue);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    margin-bottom:12px;
}

.mini-title{
    font-size:18px;
    font-weight:800;
    color:#202020;
    margin-bottom:6px;
}

.mini-desc{
    font-size:13px;
    line-height:1.7;
    color:#666;
}

.bottom-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:24px;
    margin-top:28px;
}

.form-card,
.cost-card{
    background:var(--ck-card);
    border:1px solid var(--ck-border);
    border-radius:24px;
    box-shadow:0 10px 30px rgba(28,44,62,0.06);
    padding:28px;
    min-height:310px;
    transition:all .3s ease;
}

.form-card:hover,
.cost-card:hover{
    box-shadow:0 22px 60px rgba(28,44,62,0.12);
}

.form-title,
.cost-title{
    font-size:24px;
    font-weight:800;
    color:#232323;
    margin-bottom:8px;
}

.form-desc,
.cost-desc{
    font-size:13px;
    line-height:1.8;
    color:#757575;
    margin-bottom:18px;
}

.form-group{
    margin-bottom:14px;
}

.form-control{
    width:100%;
    height:50px;
    background:#f8f5f2;
    border:1px solid #e7dfd8;
    border-radius:12px;
    padding:0 16px;
    font-family:'Montserrat',sans-serif;
    font-size:13px;
    color:#2d2d2d;
    transition:all .25s ease;
}

.form-control:focus,
.form-select:focus{
    outline:none;
    border-color:#bfd1f5;
    background:#fff;
    box-shadow:0 0 0 4px rgba(37,110,232,0.08);
}

.submit-btn{
    width:100%;
    height:50px;
    border:none;
    border-radius:12px;
    background:linear-gradient(90deg,var(--ck-secondary),var(--ck-secondary-light));
    color:#fff;
    font-family:'Montserrat',sans-serif;
    font-size:14px;
    font-weight:800;
    cursor:pointer;
    box-shadow:0 12px 24px rgba(242,92,5,0.18);
    transition:all .3s ease;
}

.submit-btn:hover{
    transform:translateY(-2px);
}

.cost-heading{
    font-size:38px;
    line-height:1.1;
    font-weight:900;
    color:#202020;
    margin-bottom:12px;
    letter-spacing:-0.7px;
}

.cost-list{
    list-style:none;
    padding:0;
    margin:0;
}

.cost-list li{
    display:flex;
    gap:10px;
    align-items:flex-start;
    font-size:14px;
    line-height:1.75;
    color:#454545;
    font-weight:600;
    margin-bottom:10px;
}

.cost-list i{
    color:#22a447;
    margin-top:3px;
}

/* TESTIMONIAL */
.section-wrapper{
    padding:70px 0 40px;
}

.section-title{
    font-size:2rem;
    font-weight:800;
}

.testimonial-section{
    background:#efefef;
    padding:60px 0 40px;
    overflow:hidden;
}

.testimonial-heading{
    margin-bottom:56px;
}

.testimonial-badge{
    display:inline-block;
    background:#2f73d9;
    color:#fff;
    font-size:14px;
    font-weight:700;
    padding:8px 18px;
    border-radius:12px;
    line-height:1;
}

.testimonial-section .section-title{
    font-size:33px;
    font-weight:800;
    color:#2f2f2f;
    line-height:1.15;
    margin-bottom:10px;
}

.testimonial-subtitle{
    color:#6f6f6f;
    font-size:16px;
    margin-bottom:0;
}

.testimonial-scroll-wrapper{
    overflow:hidden;
    position:relative;
    width:100%;
}

.testimonial-scroll-track{
    display:flex;
    gap:18px;
    width:max-content;
    animation:testimonialScroll 35s linear infinite;
}

.testimonial-scroll-wrapper:hover .testimonial-scroll-track{
    animation-play-state:paused;
}

.testimonial-card-new{
    position:relative;
    flex:0 0 290px;
    padding-top:44px;
}

.testimonial-card-body{
    background:#f8f8f8;
    border:1.5px solid #7da0d6;
    border-radius:18px;
    padding:58px 18px 18px;
    text-align:center;
    min-height:290px;
    transition:all 0.3s ease;
}

.testimonial-card-new:hover .testimonial-card-body{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}

.testimonial-avatar-wrap{
    position:absolute;
    top:0;
    left:50%;
    transform:translateX(-50%);
    width:86px;
    height:86px;
    border-radius:50%;
    overflow:hidden;
    z-index:2;
    background:#ddd;
}

.testimonial-avatar-new{
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:50%;
}

.testimonial-name{
    font-size:18px;
    font-weight:700;
    color:#2f2f2f;
    margin-bottom:4px;
    line-height:1.3;
}

.testimonial-role{
    font-size:14px;
    color:#666;
    margin-bottom:12px;
    line-height:1.4;
}

.testimonial-rating{
    margin-bottom:14px;
}

.testimonial-rating i{
    color:#f4b400;
    font-size:22px;
    margin:0 2px;
}

.testimonial-text{
    font-size:13px;
    line-height:1.45;
    color:#777;
    margin-bottom:0;
}

@keyframes testimonialScroll{
    0%{ transform:translateX(0); }
    100%{ transform:translateX(-50%); }
}

/* MODAL */
.ck-modal-header{
    background:linear-gradient(135deg, #1c2c3e, #2d4864);
    color:#fff;
}

.ck-modal-title{
    font-weight:800;
    font-size:22px;
    color:#fff;
}

.ck-modal-subtitle{
    font-size:13px;
    color:rgba(255,255,255,0.85);
}

.ck-option{
    background:#fff;
    border:1px solid #e9eef5;
    border-radius:14px;
    padding:14px 16px;
    transition:all 0.25s ease;
}

.ck-option:hover{
    border-color:#f25c05;
    box-shadow:0 8px 22px rgba(0,0,0,0.05);
}

.ck-step{
    display:inline-flex;
    width:24px;
    height:24px;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:#f25c05;
    color:#fff;
    font-size:12px;
    font-weight:700;
}

.ck-submit{
    width:100%;
    height:52px;
    border:none;
    border-radius:14px;
    background:linear-gradient(90deg, #f25c05, #ff944d);
    color:#fff;
    font-size:15px;
    font-weight:800;
    transition:all 0.3s ease;
    box-shadow:0 12px 24px rgba(242,92,5,0.18);
}

.ck-submit:hover{
    transform:translateY(-2px);
}

#comingSoonModal .form-control,
#comingSoonModal .form-select{
    border-radius:14px;
}

/* ANIMATION */
.reveal{
    opacity:0;
    transform:translateY(24px);
    transition:all .7s ease;
}

.reveal.show{
    opacity:1;
    transform:translateY(0);
}

/* RESPONSIVE */
@media (max-width:1100px){
    .feature-grid,
    .bottom-grid{
        grid-template-columns:1fr;
    }

    .feature-main-title,
    .cost-heading{
        font-size:32px;
    }
}

@media (max-width:991px){
    .hero-subtitle{
        font-size:18px;
        line-height:1.55;
        max-width:760px;
    }

    .hero-btn{
        min-width:auto;
        width:auto;
        padding:16px 24px;
        font-size:15px;
    }

    .stats-row{
        grid-template-columns:repeat(2, max-content);
        gap:26px 50px;
    }

    .testimonial-section .section-title{
        font-size:38px;
    }

    .testimonial-card-new{
        flex:0 0 260px;
    }

    .testimonial-card-body{
        min-height:300px;
    }
}

@media (max-width:900px){
    .stats-row{
        grid-template-columns:repeat(2,1fr);
    }

    .steps-image-grid{
        grid-template-columns:1fr;
    }

    .step-arrow{
        transform:rotate(90deg);
    }

    .services-image-grid{
        grid-template-columns:1fr;
        gap:20px;
    }

    .service-full-img{
        max-width:280px;
        margin:0 auto;
    }
}

@media (max-width:768px){
    .hero-subtitle{
        font-size:14px;
    }

    .hero-btn{
        background:linear-gradient(90deg,#f97316,#fb923c);
        color:#fff;
        text-shadow:0 3px 6px rgba(0,0,0,0.28);
    }

    .categories-grid,
    .mini-features{
        grid-template-columns:repeat(2,1fr);
    }

    .categories-title,
    .feature-main-title,
    .cost-heading{
        font-size:28px;
    }

    .section-head h2{
        font-size:24px;
    }
}

@media (max-width:767px){
    .categories-title{
        font-size:24px;
    }

    .categories-subtitle,
    .categories-subtext{
        font-size:13px;
    }

    .categories-grid{
        grid-template-columns:repeat(2, 1fr);
        gap:14px;
    }

    .category-card{
        min-height:100px;
    }

    .testimonial-section{
        padding:45px 0 30px;
    }

    .testimonial-section .section-title{
        font-size:30px;
    }

    .testimonial-subtitle{
        font-size:14px;
    }

    .testimonial-card-new{
        flex:0 0 240px;
    }

    .testimonial-card-body{
        min-height:285px;
        padding:56px 14px 16px;
    }

    .testimonial-name{
        font-size:16px;
    }

    .testimonial-role{
        font-size:12px;
    }

    .testimonial-text{
        font-size:12px;
    }

    .testimonial-rating i{
        font-size:18px;
    }
}

@media (max-width:575px){
    .hero-section{
        padding:26px 0 12px;
    }

    .custom-section{
        padding:30px 16px;
    }

    .hero-subtitle{
        font-size:15px;
        line-height:1.6;
        margin-bottom:18px;
    }

    .hero-btn{
        width:100%;
        max-width:360px;
        min-width:auto;
        font-size:14px;
        padding:14px 18px;
    }

    .hero-points-image img{
        max-width:100%;
    }

    .stats-wrap{
        margin-top:34px;
    }

    .stats-row{
        grid-template-columns:repeat(2,1fr);
        gap:18px 18px;
    }

    .stat-item{
        justify-content:flex-start;
    }
}

@media (max-width:520px){
    .stats-row,
    .categories-grid,
    .mini-features,
    .bottom-grid{
        grid-template-columns:1fr;
    }

    .section-head .line{
        display:none;
    }

    .section-head{
        justify-content:center;
    }
}

@media (max-width:480px){
    .categories-grid{
        grid-template-columns:1fr;
    }
}
</style>

<div class="landing-page">

    <section class="hero-section custom-section">
        <div class="container-custom">
            <div class="reveal">
                <h1 class="hero-title">
                    <img src="{{ asset('images/icons/planig.png') }}" alt="Verified Profiles, Real Experience, Faster Shortlisting">
                </h1>

                <p class="hero-subtitle">
                    Post your requirement and connect with verified
                    <strong>Construction Vendors, &amp; Tendering ERP</strong>
                </p>

                <a href="{{ route('post') }}" class="hero-btn">
                    POST YOUR PROJECT FOR FREE
                    <i class="bi bi-arrow-right"></i>
                </a>

                <div class="hero-points-image">
                    <img src="{{ asset('images/icons/b.png') }}" alt="Verified Profiles, Real Experience, Faster Shortlisting">
                </div>

                <div class="stats-wrap">
                    <div class="stats-row">
                        <div class="stat-item">
                            <img src="{{ asset('images/icons/p.png') }}" alt="Projects" class="stat-img">
                            <div class="stat-text">
                                <span class="stat-number">52+</span>
                                <span class="stat-label">Projects</span>
                            </div>
                        </div>

                        <div class="stat-item">
                            <img src="{{ asset('images/icons/e.png') }}" alt="ERP Users" class="stat-img">
                            <div class="stat-text">
                                <span class="stat-number">134+</span>
                                <span class="stat-label">ERP Users</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="how-section">
        <div class="container-custom">
            <div class="section-head reveal">
                <div class="line"></div>
                <h2>How it Works?</h2>
                <div class="line"></div>
            </div>

            <div class="steps-image-grid">
                <div class="step-image-box reveal">
                    <img src="{{ asset('images/how-it-works/post-requirement.png') }}" alt="Post Requirement" class="step-full-img">
                </div>

                <div class="step-arrow reveal">
                    <i class="bi bi-arrow-right"></i>
                </div>

                <div class="step-image-box reveal">
                    <img src="{{ asset('images/how-it-works/vendor-matches.png') }}" alt="Get Vendor Matches" class="step-full-img">
                </div>

                <div class="step-arrow reveal">
                    <i class="bi bi-arrow-right"></i>
                </div>

                <div class="step-image-box reveal">
                    <img src="{{ asset('images/how-it-works/start-construction.png') }}" alt="Start Construction" class="step-full-img">
                </div>
            </div>
        </div>
    </section>

    <section class="services-section-full">
        <div class="services-shell">
            <div class="services-image-grid">

                <a href="{{ route('search_customer') }}" class="service-image-card reveal service-link">
                    <img src="{{ asset('images/services/find-leads.png') }}" alt="Find Leads" class="service-full-img">
                </a>

                <a href="javascript:void(0);"
                   class="service-image-card reveal service-link"
                   data-bs-toggle="modal"
                   data-bs-target="#comingSoonModal">
                    <img src="{{ asset('images/services/tendering-erp.png') }}" alt="Tendering ERP" class="service-full-img">
                </a>

            </div>
        </div>
    </section>

    <section class="categories-section">
        <div class="container-custom">
            <div class="reveal">
                <h2 class="categories-title">Popular Vendor Categories</h2>

                <p class="categories-subtitle">
                    Discover verified professionals commonly required across construction projects
                </p>

                <p class="categories-subtext">
                    These categories cover the most frequently searched construction services from planning and design to execution
                    and on-site workforce. All vendors listed under these categories are location-based and verified
                </p>

                <div class="categories-grid">

                    <div class="category-card">
                        <div class="category-image-box">
                            <img src="{{ asset('images/categories/buildingcontractor.png') }}" alt="Building Contractor" class="category-image">
                        </div>
                        <h3 class="category-name">Building Contractor</h3>
                        <p class="category-desc">RCC, bungalow & building construction execution</p>
                    </div>

                    <div class="category-card">
                        <div class="category-image-box">
                            <img src="{{ asset('images/categories/residen.png') }}" alt="Residential Interiors" class="category-image">
                        </div>
                        <h3 class="category-name">Residential Interiors</h3>
                        <p class="category-desc">Modular kitchens, wardrobes & turnkey interiors</p>
                    </div>

                    <div class="category-card">
                        <div class="category-image-box">
                            <img src="{{ asset('images/categories/architect.png') }}" alt="Residential Architect" class="category-image">
                        </div>
                        <h3 class="category-name">Residential Architect</h3>
                        <p class="category-desc">Planning, approvals & bungalow designs</p>
                    </div>

                    <div class="category-card">
                        <div class="category-image-box">
                            <img src="{{ asset('images/categories/industrial.png') }}" alt="Industrial Contractor" class="category-image">
                        </div>
                        <h3 class="category-name">Industrial Contractor</h3>
                        <p class="category-desc">Factories, warehouses & PEB sheds</p>
                    </div>

                    <div class="category-card">
                        <div class="category-image-box">
                            <img src="{{ asset('images/categories/luxury.png') }}" alt="Luxury Interiors" class="category-image">
                        </div>
                        <h3 class="category-name">Luxury Interiors</h3>
                        <p class="category-desc">Premium finishes & high-end interior execution</p>
                    </div>

                    <div class="category-card">
                        <div class="category-image-box">
                            <img src="{{ asset('images/categories/labour.png') }}" alt="Labour Contractor" class="category-image">
                        </div>
                        <h3 class="category-name">Labour Contractor</h3>
                        <p class="category-desc">Skilled & unskilled construction workforce</p>
                    </div>

                    <div class="category-card">
                        <div class="category-image-box">
                            <img src="{{ asset('images/categories/commercial.png') }}" alt="Commercial Architect" class="category-image">
                        </div>
                        <h3 class="category-name">Commercial Architect</h3>
                        <p class="category-desc">Offices, retail & commercial planning</p>
                    </div>

                </div>

                <div class="category-note">
                    👉 Select a category to find nearby verified vendors or post your requirement to receive responses directly.
                </div>
            </div>
        </div>
    </section>

    <section class="feature-section">
        <div class="container-custom">
            <div class="feature-grid">
                <div class="feature-content reveal">
                    <div class="badge-blue">
                        <i class="bi bi-lightning-charge-fill"></i> Smart Discovery
                    </div>

                    <h2 class="feature-main-title">Smart Vendor Search Tool</h2>

                    <p class="feature-main-desc">
                        Finding the right construction vendor shouldn’t be confusing.
                        ConstructKaro helps you discover trusted vendors using smart
                        location-based filters and matching.
                    </p>
                </div>

                <div class="mini-features">
                    <div class="mini-card reveal">
                        <div class="mini-icon"><i class="bi bi-lightning-charge"></i></div>
                        <div class="mini-title">Fast &amp; Reliable</div>
                        <div class="mini-desc">Instantly find verified vendors with responsive, fast results.</div>
                    </div>

                    <div class="mini-card reveal">
                        <div class="mini-icon"><i class="bi bi-grid-1x2-fill"></i></div>
                        <div class="mini-title">Easy to Use</div>
                        <div class="mini-desc">Simple interface built for customer-friendly vendor discovery.</div>
                    </div>

                    <div class="mini-card reveal">
                        <div class="mini-icon"><i class="bi bi-shield-check"></i></div>
                        <div class="mini-title">Verified Vendors</div>
                        <div class="mini-desc">Every vendor is checked to improve trust and response quality.</div>
                    </div>

                    <div class="mini-card reveal">
                        <div class="mini-icon"><i class="bi bi-geo-alt"></i></div>
                        <div class="mini-title">Location Based</div>
                        <div class="mini-desc">Find vendors near your site for faster coordination and execution.</div>
                    </div>
                </div>
            </div>

            <div class="bottom-grid">
                <div class="form-card reveal">
                    <div class="form-title">Tell Us About Your Requirement</div>
                    <div class="form-desc">
                        Share your basic project details and we’ll connect you with suitable vendors.
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Your Name">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Phone Number">
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Requirement Type (e.g. Designing, PEB, Interiors)">
                    </div>

                    <button class="submit-btn" type="button">Get Matched With Vendors</button>
                </div>

                <div class="cost-card reveal">
                    <div class="badge-orange">
                        <i class="bi bi-coin"></i> Cost Optimization
                    </div>

                    <div class="cost-heading">Reduce Your Construction Cost</div>

                    <div class="cost-desc">
                        ConstructKaro helps you connect directly with verified vendors,
                        eliminating unnecessary commissions, delays, and wrong decisions.
                    </div>

                    <ul class="cost-list">
                        <li><i class="bi bi-check-circle-fill"></i> Verified vendors near your site</li>
                        <li><i class="bi bi-check-circle-fill"></i> Compare prices transparently without brokers</li>
                        <li><i class="bi bi-check-circle-fill"></i> Faster execution with better cost control</li>
                        <li><i class="bi bi-check-circle-fill"></i> Genuine leads with clear scope &amp; requirements</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="section-wrapper testimonial-section">
        <div class="container">
            <div class="text-center testimonial-heading">
                <span class="testimonial-badge">⭐ Real Experiences</span>
                <h2 class="section-title mt-3">What People Say About Us</h2>
                <p class="testimonial-subtitle">
                    Trusted by customers & contractors across Maharashtra.
                </p>
            </div>

            @php
                $testimonials = [
                    [
                        'name' => 'Patil Infra & Realtors Pvt. Ltd.',
                        'role' => 'Real Estate Developer | Khopoli',
                        'text' => 'For our ongoing building projects, finding dependable contractors on time is always a challenge. Through ConstructKaro, we were able to identify suitable labour contractors quickly, improving our execution efficiency.',
                        'image' => 'patil-infra.jpg',
                        'rating' => 4,
                    ],
                    [
                        'name' => 'Samiksha Shirke',
                        'role' => 'Home Owner | Nagothane, Maharashtra',
                        'text' => 'I was planning to construct a bungalow and did not know how to start. I posted my requirement on ConstructKaro and received genuine responses. One lead converted into actual work and my bungalow construction has started.',
                        'image' => 'samiksha.jpg',
                        'rating' => 4,
                    ],
                    [
                        'name' => 'Omkar Vidhate',
                        'role' => 'Architect | Pune',
                        'text' => 'After leaving my job, getting independent projects was challenging. Through ConstructKaro, I received architectural planning & interior design work that matched my skills perfectly.',
                        'image' => 'omkar.jpg',
                        'rating' => 3,
                    ],
                    [
                        'name' => 'Sanket Asgaonkar',
                        'role' => 'Land Surveyor & Drone Survey Specialist | Raigad',
                        'text' => 'I had the skills and equipment, but finding the right drone survey clients was difficult. Through ConstructKaro, I received a drone survey requirement in Poladpur that perfectly matched my profile.',
                        'image' => 'sanket.jpg',
                        'rating' => 4,
                    ],
                    [
                        'name' => 'Vikram Naik',
                        'role' => 'Civil Contractor | Pen, Maharashtra',
                        'text' => 'Getting genuine private bungalow work is very difficult for small contractors. Through ConstructKaro, I received my first bungalow construction lead which converted into a real project.',
                        'image' => 'vikram.jpeg',
                        'rating' => 5,
                    ],
                    [
                        'name' => 'Ivan Maben',
                        'role' => 'Home Owner | Pen, Maharashtra',
                        'text' => 'While planning my bungalow construction, I did not want to depend only on local references. Through ConstructKaro, I connected with the right team and finalized my project confidently.',
                        'image' => 'ivan.jpg',
                        'rating' => 4,
                    ],
                ];
            @endphp

            <div class="testimonial-scroll-wrapper">
                <div class="testimonial-scroll-track">
                    @foreach ($testimonials as $t)
                        <div class="testimonial-card-new">
                            <div class="testimonial-avatar-wrap">
                                <img src="{{ asset('images/testo/'.$t['image']) }}" alt="{{ $t['name'] }}" class="testimonial-avatar-new">
                            </div>

                            <div class="testimonial-card-body">
                                <h3 class="testimonial-name">{{ $t['name'] }}</h3>
                                <p class="testimonial-role">{{ $t['role'] }}</p>

                                <div class="testimonial-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $t['rating'])
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>

                                <p class="testimonial-text">{{ $t['text'] }}</p>
                            </div>
                        </div>
                    @endforeach

                    @foreach ($testimonials as $t)
                        <div class="testimonial-card-new">
                            <div class="testimonial-avatar-wrap">
                                <img src="{{ asset('images/testo/'.$t['image']) }}" alt="{{ $t['name'] }}" class="testimonial-avatar-new">
                            </div>

                            <div class="testimonial-card-body">
                                <h3 class="testimonial-name">{{ $t['name'] }}</h3>
                                <p class="testimonial-role">{{ $t['role'] }}</p>

                                <div class="testimonial-rating">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $t['rating'])
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>

                                <p class="testimonial-text">{{ $t['text'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

</div>

<div class="modal fade" id="comingSoonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 rounded-4 shadow-lg">

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
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

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

            <div class="modal-body bg-light px-4 py-4">
                <form id="erpInterestForm">

                    <div class="mb-3">
                        <label class="fw-semibold">
                            <span class="ck-step me-1">1</span> Full Name *
                        </label>
                        <input class="form-control form-control-lg" name="full_name" required>
                    </div>

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

                        <select class="form-select form-select-lg" name="role_in_org" id="roleSelect" required>
                            <option value="">Select role</option>
                            <option value="Owner / Founder">Owner / Founder</option>
                            <option value="Director">Director</option>
                            <option value="Project Manager">Project Manager</option>
                            <option value="Engineer">Engineer</option>
                            <option value="Procurement">Procurement</option>
                            <option value="Consultant">Consultant</option>
                            <option value="Other">Other</option>
                        </select>

                        <div id="roleOtherBox" class="mt-2 d-none">
                            <input type="text"
                                   class="form-control form-control-lg"
                                   name="role_in_org_other"
                                   id="roleOtherInput"
                                   placeholder="Please specify your role">
                        </div>
                    </div>

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
                                <input type="radio"
                                       name="organization_type"
                                       class="me-3 org-type-radio"
                                       value="{{ $type }}"
                                       required>
                                {{ $type }}
                            </label>
                        @endforeach

                        <div id="orgTypeOtherBox" class="mt-2 d-none">
                            <input type="text"
                                   class="form-control form-control-lg"
                                   name="organization_type_other"
                                   id="orgTypeOtherInput"
                                   placeholder="Please specify organization type">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold">
                            <span class="ck-step me-1">5</span> Project Size *
                        </label>
                        <select class="form-select form-select-lg" name="project_size" required>
                            <option value="">Select size</option>
                            <option value="Below ₹5 Cr">Below ₹5 Cr</option>
                            <option value="₹5 – 25 Cr">₹5 – 25 Cr</option>
                            <option value="₹25 – 100 Cr">₹25 – 100 Cr</option>
                            <option value="₹100 Cr+">₹100 Cr+</option>
                        </select>
                    </div>

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
                                <input type="checkbox" name="looking_for[]" class="me-3" value="{{ $need }}">
                                {{ $need }}
                            </label>
                        @endforeach
                    </div>

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
                                <input type="radio" name="current_challenge" class="me-3" value="{{ $c }}" required>
                                {{ $c }}
                            </label>
                        @endforeach
                    </div>

                    <div class="mb-4">
                        <label class="fw-semibold mb-2 d-block">
                            <span class="ck-step me-1">8</span> Interest Level *
                        </label>

                        @foreach(['Urgent','Exploring','Maybe','No'] as $i)
                            <label class="ck-option d-flex align-items-center mb-2">
                                <input type="radio" name="interest_level" class="me-3" value="{{ $i }}" required>
                                {{ $i }}
                            </label>
                        @endforeach
                    </div>

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

                    <button type="submit" class="ck-submit">
                        Submit Registration
                    </button>

                </form>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
            }
        });
    }, { threshold: 0.10 });

    document.querySelectorAll('.reveal').forEach((el) => {
        observer.observe(el);
    });

    const roleSelect = document.getElementById('roleSelect');
    const roleOtherBox = document.getElementById('roleOtherBox');
    const roleOtherInput = document.getElementById('roleOtherInput');

    if (roleSelect) {
        roleSelect.addEventListener('change', function () {
            if (this.value === 'Other') {
                roleOtherBox.classList.remove('d-none');
                roleOtherInput.setAttribute('required', 'required');
            } else {
                roleOtherBox.classList.add('d-none');
                roleOtherInput.removeAttribute('required');
                roleOtherInput.value = '';
            }
        });
    }

    const orgRadios = document.querySelectorAll('.org-type-radio');
    const orgTypeOtherBox = document.getElementById('orgTypeOtherBox');
    const orgTypeOtherInput = document.getElementById('orgTypeOtherInput');

    orgRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (this.value === 'Other') {
                orgTypeOtherBox.classList.remove('d-none');
                orgTypeOtherInput.setAttribute('required', 'required');
            } else {
                orgTypeOtherBox.classList.add('d-none');
                orgTypeOtherInput.removeAttribute('required');
                orgTypeOtherInput.value = '';
            }
        });
    });

    const erpForm = document.getElementById('erpInterestForm');
    if (erpForm) {
        erpForm.addEventListener('submit', function(e){
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Submitting...';

            const formData = new FormData(this);

            fetch("{{ route('erp.interest.save') }}", {
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(async res => {
                const data = await res.json();
                if (!res.ok) {
                    throw data;
                }
                return data;
            })
            .then(res => {
                if (res.status) {
                    alert('✅ Registration submitted successfully');
                    erpForm.reset();

                    roleOtherBox.classList.add('d-none');
                    roleOtherInput.removeAttribute('required');
                    orgTypeOtherBox.classList.add('d-none');
                    orgTypeOtherInput.removeAttribute('required');

                    const modalEl = document.getElementById('comingSoonModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                } else {
                    alert(res.message || 'Something went wrong');
                }
            })
            .catch(err => {
                alert(err.message || '❌ Server error');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.innerText = 'Submit Registration';
            });
        });
    }
});
</script>
@endsection