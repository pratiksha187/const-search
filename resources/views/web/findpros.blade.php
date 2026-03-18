@extends('layouts.app')

@section('title', 'Construction Vendor Discovery | ConstructKaro')

@section('content')
<style>
:root{
    --ck-primary:#0B4A93;
    --ck-secondary:#F47A20;
    --ck-secondary-dark:#d96512;
    --ck-dark:#1C2C3E;
    --ck-black:#0B0D12;
    --ck-white:#ffffff;
    --ck-bg:#f4f6f9;
    --ck-card:#ffffff;
    --ck-border:#d9dee5;
    --ck-text:#1a2433;
    --ck-muted:#6b7a8f;
    --ck-yellow:#f4c400;
    --ck-soft-yellow:#efe08a;
    --ck-verified-bg:#e7f6ec;
    --ck-verified-text:#17834f;
    --ck-shadow:0 10px 30px rgba(15,23,42,.06);
    --ck-shadow-lg:0 20px 42px rgba(15,23,42,.10);
}

body{
    background:var(--ck-bg);
    color:var(--ck-text);
}

.container-custom{
    width:min(1280px, 92%);
    margin:0 auto;
}

/* ================= HERO ================= */
.find-pros-hero{
    position:relative;
    overflow:hidden;
    background:
        linear-gradient(rgba(244,122,32,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(11,74,147,0.05) 1px, transparent 1px),
        radial-gradient(circle at top center, rgba(244,122,32,0.10), transparent 30%),
        radial-gradient(circle at bottom left, rgba(11,74,147,0.12), transparent 28%),
        linear-gradient(180deg, #050607 0%, #0a0d14 100%);
    background-size:52px 52px, 52px 52px, auto, auto, auto;
    padding:72px 0 92px;
}

.find-pros-hero::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(90deg, rgba(0,0,0,0.20), rgba(0,0,0,0.03), rgba(0,0,0,0.20));
    pointer-events:none;
}

.find-pros-inner{
    position:relative;
    z-index:2;
    text-align:center;
}

.find-pros-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    padding:12px 22px;
    border-radius:999px;
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.10);
    color:#d4d9e2;
    font-size:15px;
    font-weight:600;
    margin-bottom:32px;
    backdrop-filter:blur(10px);
    box-shadow:0 10px 26px rgba(0,0,0,0.18);
}

.badge-dot{
    width:12px;
    height:12px;
    border-radius:50%;
    background:var(--ck-secondary);
    box-shadow:0 0 0 6px rgba(244,122,32,0.12);
    display:inline-block;
}

.find-pros-title{
    margin:0;
    color:var(--ck-white);
    font-family:Georgia, "Times New Roman", serif;
    font-size:86px;
    line-height:.96;
    font-weight:700;
    letter-spacing:-2px;
    text-shadow:0 8px 28px rgba(0,0,0,0.22);
}

.find-pros-title span{
    color:var(--ck-secondary);
}

.find-pros-subtitle{
    margin:26px 0 52px;
    color:#d0d7e2;
    font-size:21px;
    line-height:1.6;
    font-weight:400;
}

.find-pros-search-card{
    max-width:1120px;
    margin:0 auto;
    padding:34px 30px 28px;
    border-radius:30px;
    background:
        linear-gradient(90deg, rgba(11,74,147,0.10) 0%, rgba(28,44,62,0.10) 50%, rgba(244,122,32,0.08) 100%),
        linear-gradient(180deg, rgba(20,24,34,0.98) 0%, rgba(13,16,24,0.98) 100%);
    border:1px solid rgba(255,255,255,0.10);
    box-shadow:
        0 30px 80px rgba(0,0,0,0.35),
        inset 0 1px 0 rgba(255,255,255,0.04);
}

.find-pros-search-grid{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:18px;
    margin-bottom:24px;
}

.find-pros-field{
    text-align:left;
}

.find-pros-field label{
    display:block;
    margin-bottom:10px;
    color:#eef2f8;
    font-size:16px;
    font-weight:500;
}

.find-pros-field select{
    width:100%;
    height:62px;
    border-radius:16px;
    border:1px solid rgba(255,255,255,0.10);
    background:#020408;
    color:#ffffff;
    font-size:16px;
    font-weight:500;
    padding:0 18px;
    outline:none;
    transition:.25s ease;
    box-shadow:inset 0 0 0 1px rgba(255,255,255,0.02);
}

.find-pros-field select:hover{
    border-color:rgba(244,122,32,0.28);
}

.find-pros-field select:focus{
    border-color:var(--ck-secondary);
    box-shadow:0 0 0 4px rgba(244,122,32,0.12);
}

.find-pros-btn-wrap{
    display:flex;
    justify-content:center;
}

.find-pros-btn{
    min-width:350px;
    height:66px;
    padding:0 28px;
    border:none;
    outline:none;
    border-radius:18px;
    background:linear-gradient(180deg, #ff963f 0%, #F47A20 100%);
    color:#ffffff;
    font-size:19px;
    font-weight:800;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    box-shadow:
        0 18px 36px rgba(244,122,32,.24),
        inset 0 1px 0 rgba(255,255,255,.18);
    transition:.25s ease;
}

.find-pros-btn:hover{
    transform:translateY(-2px);
    background:linear-gradient(180deg, #ffa152 0%, #e96d13 100%);
}

.find-pros-btn i{
    font-size:20px;
}

/* ================= CATEGORY + AREAS ================= */
.pro-category-area-section{
    background:#f3f3f4;
    padding:0 0 12px;
}

.pro-category-block{
    background:#ffffff;
    padding:30px 0 34px;
    border-bottom:1px solid #eceff4;
}

.pro-small-heading{
    font-size:12px;
    font-weight:800;
    letter-spacing:2.4px;
    color:#6b7a8f;
    margin-bottom:22px;
}

.pro-category-list{
    display:flex;
    flex-wrap:wrap;
    gap:14px;
}

.pro-category-chip{
    min-height:58px;
    padding:0 24px;
    border-radius:16px;
    border:1.5px solid #d8dde4;
    background:#ffffff;
    color:#2c3440;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:12px;
    font-size:16px;
    font-weight:700;
    transition:.25s ease;
}

.pro-category-chip i{
    font-size:19px;
    color:#444;
    transition:.25s ease;
}

.pro-category-chip:hover{
    border-color:var(--ck-primary);
    color:var(--ck-primary);
    transform:translateY(-2px);
    box-shadow:0 10px 20px rgba(11,74,147,0.08);
}

.pro-category-chip:hover i{
    color:var(--ck-primary);
}

.pro-category-chip.active{
    background:#05070b;
    border-color:#05070b;
    color:#f4cf08;
    box-shadow:0 12px 24px rgba(0,0,0,0.14);
}

.pro-category-chip.active i{
    color:#f4cf08;
}

.pro-areas-block{
    background:#f3f3f4;
    padding:62px 0 58px;
}

.pro-areas-head{
    margin-bottom:30px;
}

.pro-areas-head h2{
    margin:0 0 8px;
    font-family:Georgia, "Times New Roman", serif;
    font-size:58px;
    line-height:1;
    font-weight:700;
    color:#111827;
    letter-spacing:-1px;
}

.pro-areas-head p{
    margin:0;
    font-size:18px;
    color:#66758a;
    font-weight:500;
}

.pro-areas-grid{
    display:grid;
    grid-template-columns:repeat(5, 1fr);
    gap:18px;
}

.pro-area-card{
    min-height:184px;
    border-radius:20px;
    border:1.5px solid #d9dde3;
    background:#f8f8f9;
    text-decoration:none;
    padding:22px 20px 18px;
    transition:.25s ease;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.pro-area-card:hover{
    transform:translateY(-4px);
    border-color:#c6cfdb;
    box-shadow:var(--ck-shadow);
}

.pro-area-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    margin-bottom:20px;
}

.pro-area-icon{
    font-size:24px;
    color:#707070;
    line-height:1;
}

.pro-area-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:52px;
    height:30px;
    padding:0 14px;
    border-radius:999px;
    font-size:14px;
    font-weight:700;
    line-height:1;
}

.pro-area-badge.hot{
    background:#f4cf08;
    color:#111111;
}

.pro-area-badge.new{
    background:#eadca3;
    color:#2f3440;
}

.pro-area-card h3{
    margin:0 0 10px;
    font-size:20px;
    line-height:1.2;
    font-weight:800;
    color:#243247;
}

.pro-area-card p{
    margin:0;
    font-size:15px;
    line-height:1.5;
    color:#657284;
    font-weight:500;
}

.pro-area-card.active{
    background:#05070b;
    border-color:#05070b;
    box-shadow:0 16px 32px rgba(0,0,0,0.18);
}

.pro-area-card.active .pro-area-icon{
    color:#f4cf08;
}

.pro-area-card.active h3{
    color:#f4cf08;
}

.pro-area-card.active p{
    color:#d8b700;
}

/* ================= RANKED LIST ================= */
.ranked-pros-section{
    background:#f3f3f4;
    padding:18px 0 36px;
}

.ranked-pros-head{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:20px;
    margin-bottom:24px;
    flex-wrap:wrap;
}

.ranked-pros-label{
    display:flex;
    align-items:center;
    gap:10px;
    font-size:12px;
    font-weight:800;
    letter-spacing:2.3px;
    color:#5e6c80;
    margin-bottom:14px;
}

.ranked-line{
    width:34px;
    height:5px;
    border-radius:999px;
    background:#f4c400;
    display:inline-block;
}

.ranked-pros-title{
    margin:0;
    font-family:Georgia, "Times New Roman", serif;
    font-size:54px;
    line-height:1.03;
    font-weight:700;
    color:#111111;
    letter-spacing:-1px;
}

.ranked-pros-updated{
    font-size:15px;
    font-weight:500;
    color:#6d798b;
}

.ranked-pros-divider{
    height:2px;
    background:#efe08a;
    margin-bottom:28px;
    border-radius:999px;
}

.ranked-pros-list{
    display:flex;
    flex-direction:column;
    gap:18px;
}

.ranked-pro-card{
    background:#ffffff;
    border:2px solid #efc400;
    border-radius:26px;
    padding:28px 26px;
    transition:.25s ease;
    box-shadow:0 8px 22px rgba(28,44,62,0.03);
}

.ranked-pro-card:hover{
    transform:translateY(-3px);
    box-shadow:0 18px 32px rgba(28,44,62,0.08);
}

.ranked-pro-main{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:24px;
}

.ranked-pro-left{
    display:flex;
    align-items:center;
    gap:16px;
    min-width:0;
    flex:1;
}

.rank-box{
    width:60px;
    height:76px;
    border-radius:16px;
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    flex-shrink:0;
}

.rank-number{
    font-size:22px;
    font-weight:900;
    color:#ffffff;
    line-height:1;
}

.rank-crown{
    position:absolute;
    top:7px;
    right:6px;
    font-size:12px;
    line-height:1;
}

.rank-box.gold{
    background:linear-gradient(180deg, #ffcc14 0%, #f2b300 100%);
}
.rank-box.silver{
    background:linear-gradient(180deg, #b7b7b9 0%, #8e8f93 100%);
}
.rank-box.bronze{
    background:linear-gradient(180deg, #cf7c36 0%, #b6632a 100%);
}

.company-logo{
    width:68px;
    height:68px;
    border-radius:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#ffffff;
    font-size:22px;
    font-weight:800;
    flex-shrink:0;
}

.blue-logo{
    background:linear-gradient(135deg, #3c73e8, #2958d8);
}
.green-logo{
    background:linear-gradient(135deg, #11aa6b, #0c9960);
}
.purple-logo{
    background:linear-gradient(135deg, #8d4cf3, #6c33e8);
}

.ranked-pro-content{
    min-width:0;
    flex:1;
}

.ranked-name-row{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
    margin-bottom:8px;
}

.ranked-name-row h3{
    margin:0;
    font-size:20px;
    line-height:1.3;
    font-weight:800;
    color:#111827;
}

.verified-badge{
    display:inline-flex;
    align-items:center;
    gap:7px;
    background:#e7f6ec;
    color:#17834f;
    border-radius:999px;
    padding:7px 12px;
    font-size:13px;
    font-weight:700;
    line-height:1;
}

.ranked-meta-row{
    display:flex;
    align-items:center;
    gap:18px;
    flex-wrap:wrap;
    margin-bottom:10px;
}

.ranked-meta-row span{
    display:inline-flex;
    align-items:center;
    gap:7px;
    color:#677487;
    font-size:15px;
    font-weight:500;
}

.ranked-rating-row{
    display:flex;
    align-items:center;
    gap:8px;
    flex-wrap:wrap;
    margin-bottom:10px;
}

.stars{
    display:inline-flex;
    align-items:center;
    gap:2px;
    color:#f4c400;
    font-size:16px;
}

.ranked-rating-row strong{
    font-size:17px;
    color:#111827;
    font-weight:800;
}

.ranked-rating-row span{
    color:#6d798b;
    font-size:14px;
    font-weight:500;
}

.ranked-quote{
    margin:0;
    color:#5c697a;
    font-size:15px;
    line-height:1.7;
    font-weight:500;
}

.ranked-pro-right{
    flex-shrink:0;
}

.ranked-view-btn{
    min-width:170px;
    height:56px;
    padding:0 22px;
    border-radius:16px;
    background:#05070b;
    color:#f4cf08;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    font-size:16px;
    font-weight:800;
    transition:.25s ease;
    box-shadow:0 10px 22px rgba(0,0,0,0.10);
}

.ranked-view-btn:hover{
    background:#111827;
    color:#ffffff;
    transform:translateY(-2px);
}

/* ================= RESPONSIVE ================= */
@media (max-width: 1199px){
    .find-pros-title{
        font-size:66px;
    }

    .find-pros-search-grid{
        grid-template-columns:repeat(2, 1fr);
    }

    .pro-areas-grid{
        grid-template-columns:repeat(3, 1fr);
    }

    .ranked-pros-title{
        font-size:46px;
    }

    .ranked-pro-main{
        align-items:flex-start;
        flex-direction:column;
    }

    .ranked-pro-right{
        width:100%;
    }

    .ranked-view-btn{
        width:100%;
    }
}

@media (max-width: 991px){
    .pro-areas-grid{
        grid-template-columns:repeat(2, 1fr);
    }

    .pro-areas-head h2{
        font-size:44px;
    }
}

@media (max-width: 767px){
    .find-pros-hero{
        padding:50px 0 58px;
        background-size:30px 30px, 30px 30px, auto, auto, auto;
    }

    .find-pros-badge{
        font-size:13px;
        padding:10px 16px;
        margin-bottom:22px;
    }

    .badge-dot{
        width:10px;
        height:10px;
    }

    .find-pros-title{
        font-size:42px;
        line-height:1.04;
        letter-spacing:-1px;
    }

    .find-pros-subtitle{
        font-size:16px;
        margin:18px 0 28px;
    }

    .find-pros-search-card{
        padding:20px 14px 18px;
        border-radius:22px;
    }

    .find-pros-search-grid{
        grid-template-columns:1fr;
        gap:14px;
        margin-bottom:18px;
    }

    .find-pros-field label{
        font-size:14px;
        margin-bottom:8px;
    }

    .find-pros-field select{
        height:56px;
        font-size:15px;
        border-radius:14px;
        padding:0 14px;
    }

    .find-pros-btn{
        width:100%;
        min-width:100%;
        height:56px;
        font-size:16px;
        border-radius:14px;
    }

    .pro-category-block{
        padding:24px 0 28px;
    }

    .pro-category-list{
        gap:10px;
    }

    .pro-category-chip{
        width:100%;
        justify-content:flex-start;
        min-height:52px;
        font-size:15px;
        border-radius:14px;
        padding:0 18px;
    }

    .pro-areas-block{
        padding:38px 0 40px;
    }

    .pro-areas-head{
        margin-bottom:22px;
    }

    .pro-areas-head h2{
        font-size:34px;
        line-height:1.08;
    }

    .pro-areas-head p{
        font-size:15px;
    }

    .pro-areas-grid{
        grid-template-columns:1fr;
        gap:14px;
    }

    .pro-area-card{
        min-height:152px;
        border-radius:18px;
        padding:18px 18px;
    }

    .ranked-pros-section{
        padding:12px 0 20px;
    }

    .ranked-pros-head{
        margin-bottom:18px;
    }

    .ranked-pros-title{
        font-size:34px;
        line-height:1.08;
    }

    .ranked-pros-updated{
        font-size:14px;
    }

    .ranked-pros-divider{
        margin-bottom:22px;
    }

    .ranked-pro-card{
        padding:18px 14px;
        border-radius:20px;
    }

    .ranked-pro-left{
        align-items:flex-start;
        gap:12px;
        flex-wrap:wrap;
    }

    .rank-box{
        width:52px;
        height:64px;
        border-radius:14px;
    }

    .company-logo{
        width:60px;
        height:60px;
        border-radius:18px;
        font-size:20px;
    }

    .ranked-pro-content{
        width:100%;
    }

    .ranked-name-row h3{
        font-size:18px;
    }

    .ranked-meta-row span{
        font-size:14px;
    }

    .ranked-quote{
        font-size:14px;
    }

    .ranked-view-btn{
        height:52px;
        border-radius:14px;
        font-size:15px;
        min-width:100%;
    }
}
</style>

<section class="find-pros-hero">
    <div class="container-custom">
        <div class="find-pros-inner">

            <div class="find-pros-badge">
                <span class="badge-dot"></span>
                Live Rankings · Updated Weekly
            </div>

            <h1 class="find-pros-title">
                Top Construction <br>
                Professionals <span>Near You</span>
            </h1>

            <p class="find-pros-subtitle">
                Verified. Ranked. Trusted by ConstructKaro.
            </p>

            <div class="find-pros-search-card">
                <div class="find-pros-search-grid">
                    <div class="find-pros-field">
                        <label for="state">State</label>
                        <select id="state">
                            <option>Maharashtra</option>
                            <option>Gujarat</option>
                            <option>Karnataka</option>
                        </select>
                    </div>

                    <div class="find-pros-field">
                        <label for="city">City</label>
                        <select id="city">
                            <option>Navi Mumbai</option>
                            <option>Mumbai</option>
                            <option>Pune</option>
                        </select>
                    </div>

                    <div class="find-pros-field">
                        <label for="area">Area</label>
                        <select id="area">
                            <option>Vashi</option>
                            <option>Nerul</option>
                            <option>Panvel</option>
                        </select>
                    </div>

                    <div class="find-pros-field">
                        <label for="category">Category</label>
                        <select id="category">
                            <option>Contractor</option>
                            <option>Architect</option>
                            <option>Consultant</option>
                            <option>Supplier</option>
                        </select>
                    </div>
                </div>

                <div class="find-pros-btn-wrap">
                    <button type="button" class="find-pros-btn">
                        <i class="bi bi-search"></i>
                        Find Professionals
                    </button>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="pro-category-area-section">
    <div class="container-custom">
        <div class="pro-category-block">
            <div class="pro-small-heading">BROWSE BY CATEGORY</div>

            <div class="pro-category-list">
                <a href="#" class="pro-category-chip active"><i class="bi bi-hammer"></i> Contractors</a>
                <a href="#" class="pro-category-chip"><i class="bi bi-pencil"></i> Architects</a>
                <a href="#" class="pro-category-chip"><i class="bi bi-box-seam"></i> Suppliers</a>
                <a href="#" class="pro-category-chip"><i class="bi bi-briefcase"></i> Consultants</a>
                <a href="#" class="pro-category-chip"><i class="bi bi-geo-alt"></i> Surveyors</a>
                <a href="#" class="pro-category-chip"><i class="bi bi-palette"></i> Designers</a>
                <a href="#" class="pro-category-chip"><i class="bi bi-house-door"></i> Brokers</a>
            </div>
        </div>

        <div class="pro-areas-block">
            <div class="pro-areas-head">
                <h2>Explore Areas</h2>
                <p>Navi Mumbai · 5 popular localities</p>
            </div>

            <div class="pro-areas-grid">
                <a href="#" class="pro-area-card active">
                    <div class="pro-area-top">
                        <div class="pro-area-icon"><i class="bi bi-geo-alt"></i></div>
                        <span class="pro-area-badge hot">Hot</span>
                    </div>
                    <h3>Vashi</h3>
                    <p>Sector 1–30</p>
                </a>

                <a href="#" class="pro-area-card">
                    <div class="pro-area-top">
                        <div class="pro-area-icon"><i class="bi bi-geo-alt"></i></div>
                    </div>
                    <h3>Nerul</h3>
                    <p>East &amp; West</p>
                </a>

                <a href="#" class="pro-area-card">
                    <div class="pro-area-top">
                        <div class="pro-area-icon"><i class="bi bi-geo-alt"></i></div>
                    </div>
                    <h3>Seawoods</h3>
                    <p>Grand Central</p>
                </a>

                <a href="#" class="pro-area-card">
                    <div class="pro-area-top">
                        <div class="pro-area-icon"><i class="bi bi-geo-alt"></i></div>
                        <span class="pro-area-badge new">New</span>
                    </div>
                    <h3>Kharghar</h3>
                    <p>Hills &amp; Valley</p>
                </a>

                <a href="#" class="pro-area-card">
                    <div class="pro-area-top">
                        <div class="pro-area-icon"><i class="bi bi-geo-alt"></i></div>
                    </div>
                    <h3>Panvel</h3>
                    <p>Old &amp; New City</p>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="ranked-pros-section">
    <div class="container-custom">
        <div class="ranked-pros-head">
            <div class="ranked-pros-head-left">
                <div class="ranked-pros-label">
                    <span class="ranked-line"></span>
                    RANKED LIST
                </div>
                <h2 class="ranked-pros-title">Top 10 Contractors in Vashi</h2>
            </div>

            <div class="ranked-pros-updated">
                Updated: Jan 2025
            </div>
        </div>

        <div class="ranked-pros-divider"></div>

        <div class="ranked-pros-list">
            <div class="ranked-pro-card">
                <div class="ranked-pro-main">
                    <div class="ranked-pro-left">
                        <div class="rank-box gold">
                            <span class="rank-number">1</span>
                            <span class="rank-crown">🏆</span>
                        </div>

                        <div class="company-logo blue-logo">S&amp;</div>

                        <div class="ranked-pro-content">
                            <div class="ranked-name-row">
                                <h3>Sharma &amp; Associates</h3>
                                <span class="verified-badge">
                                    <i class="bi bi-patch-check-fill"></i>
                                    Verified
                                </span>
                            </div>

                            <div class="ranked-meta-row">
                                <span><i class="bi bi-clock-history"></i> 18+ years</span>
                                <span><i class="bi bi-layers"></i> Residential Towers</span>
                            </div>

                            <div class="ranked-rating-row">
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <strong>4.9</strong>
                                <span>(127 reviews)</span>
                            </div>

                            <p class="ranked-quote">
                                "Known for timely execution and premium quality finishes in high-rise projects"
                            </p>
                        </div>
                    </div>

                    <div class="ranked-pro-right">
                        <a href="#" class="ranked-view-btn">
                            View Profile
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="ranked-pro-card">
                <div class="ranked-pro-main">
                    <div class="ranked-pro-left">
                        <div class="rank-box silver">
                            <span class="rank-number">2</span>
                            <span class="rank-crown">🏆</span>
                        </div>

                        <div class="company-logo green-logo">BI</div>

                        <div class="ranked-pro-content">
                            <div class="ranked-name-row">
                                <h3>BuildRight Infra Pvt Ltd</h3>
                                <span class="verified-badge">
                                    <i class="bi bi-patch-check-fill"></i>
                                    Verified
                                </span>
                            </div>

                            <div class="ranked-meta-row">
                                <span><i class="bi bi-clock-history"></i> 15+ years</span>
                                <span><i class="bi bi-layers"></i> Commercial Complexes</span>
                            </div>

                            <div class="ranked-rating-row">
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <strong>4.8</strong>
                                <span>(98 reviews)</span>
                            </div>

                            <p class="ranked-quote">
                                "Consistent delivery of large-scale commercial projects within budget"
                            </p>
                        </div>
                    </div>

                    <div class="ranked-pro-right">
                        <a href="#" class="ranked-view-btn">
                            View Profile
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="ranked-pro-card">
                <div class="ranked-pro-main">
                    <div class="ranked-pro-left">
                        <div class="rank-box bronze">
                            <span class="rank-number">3</span>
                            <span class="rank-crown">🏆</span>
                        </div>

                        <div class="company-logo purple-logo">RC</div>

                        <div class="ranked-pro-content">
                            <div class="ranked-name-row">
                                <h3>Raj Construction Co.</h3>
                                <span class="verified-badge">
                                    <i class="bi bi-patch-check-fill"></i>
                                    Verified
                                </span>
                            </div>

                            <div class="ranked-meta-row">
                                <span><i class="bi bi-clock-history"></i> 22+ years</span>
                                <span><i class="bi bi-layers"></i> Industrial &amp; Warehousing</span>
                            </div>

                            <div class="ranked-rating-row">
                                <div class="stars">
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-fill"></i>
                                    <i class="bi bi-star-half"></i>
                                </div>
                                <strong>4.8</strong>
                                <span>(156 reviews)</span>
                            </div>

                            <p class="ranked-quote">
                                "Pioneers in industrial construction with unmatched reliability"
                            </p>
                        </div>
                    </div>

                    <div class="ranked-pro-right">
                        <a href="#" class="ranked-view-btn">
                            View Profile
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection