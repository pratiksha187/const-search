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
    --ck-light:#F8FAFC;
    --ck-border:rgba(255,255,255,0.10);
    --ck-text-soft:#C9D2E0;
    --ck-card-dark:rgba(16,20,28,0.96);
}

.container-custom{
    width:min(1280px, 92%);
    margin:0 auto;
}

.find-pros-hero{
    position:relative;
    overflow:hidden;
    background:
        linear-gradient(rgba(244,122,32,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(11,74,147,0.06) 1px, transparent 1px),
        radial-gradient(circle at top center, rgba(244,122,32,0.10), transparent 30%),
        radial-gradient(circle at bottom left, rgba(11,74,147,0.10), transparent 28%),
        linear-gradient(180deg, #050607 0%, #0a0d14 100%);
    background-size:56px 56px, 56px 56px, auto, auto, auto;
    padding:70px 0 90px;
}

.find-pros-hero::before{
    content:"";
    position:absolute;
    inset:0;
    background:linear-gradient(90deg, rgba(0,0,0,0.20), rgba(0,0,0,0.04), rgba(0,0,0,0.20));
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
    gap:12px;
    padding:14px 24px;
    border-radius:999px;
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.10);
    color:#d4d9e2;
    font-size:17px;
    font-weight:500;
    margin-bottom:34px;
    backdrop-filter:blur(10px);
    box-shadow:0 10px 30px rgba(0,0,0,0.22);
}

.badge-dot{
    width:14px;
    height:14px;
    border-radius:50%;
    background:var(--ck-secondary);
    box-shadow:0 0 0 6px rgba(244,122,32,0.12);
    display:inline-block;
}

.find-pros-title{
    margin:0;
    color:var(--ck-white);
    font-family:Georgia, "Times New Roman", serif;
    font-size:92px;
    line-height:0.94;
    font-weight:700;
    letter-spacing:-2px;
    text-shadow:0 8px 28px rgba(0,0,0,0.20);
}

.find-pros-title span{
    color:var(--ck-secondary);
}

.find-pros-subtitle{
    margin:28px 0 58px;
    color:#c7cfdb;
    font-size:22px;
    line-height:1.6;
    font-weight:400;
}

.find-pros-search-card{
    max-width:1360px;
    margin:0 auto;
    padding:38px 36px 34px;
    border-radius:34px;
    background:
        linear-gradient(90deg, rgba(11,74,147,0.09) 0%, rgba(28,44,62,0.10) 50%, rgba(244,122,32,0.07) 100%),
        linear-gradient(180deg, rgba(20,24,34,0.98) 0%, rgba(13,16,24,0.98) 100%);
    border:1px solid rgba(255,255,255,0.10);
    box-shadow:
        0 28px 80px rgba(0,0,0,0.38),
        inset 0 1px 0 rgba(255,255,255,0.04);
    backdrop-filter:blur(6px);
}

.find-pros-search-grid{
    display:grid;
    grid-template-columns:repeat(4, 1fr);
    gap:20px;
    margin-bottom:28px;
}

.find-pros-field{
    text-align:left;
}

.find-pros-field label{
    display:block;
    margin-bottom:12px;
    color:#eef2f8;
    font-size:18px;
    font-weight:500;
}

.find-pros-field select{
    width:100%;
    height:72px;
    border-radius:18px;
    border:1px solid rgba(255,255,255,0.10);
    background:#020408;
    color:#ffffff;
    font-size:18px;
    font-weight:500;
    padding:0 22px;
    outline:none;
    transition:all 0.3s ease;
    box-shadow:inset 0 0 0 1px rgba(255,255,255,0.02);
}

.find-pros-field select:hover{
    border-color:rgba(244,122,32,0.30);
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
    min-width:410px;
    height:74px;
    padding:0 28px;
    border:none;
    outline:none;
    border-radius:20px;
    background:linear-gradient(180deg, #ff8b38 0%, #F47A20 100%);
    color:#ffffff;
    font-size:20px;
    font-weight:800;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:14px;
    box-shadow:
        0 18px 36px rgba(244,122,32,0.26),
        inset 0 1px 0 rgba(255,255,255,0.18);
    transition:all 0.3s ease;
}

.find-pros-btn:hover{
    transform:translateY(-2px);
    background:linear-gradient(180deg, #ff9a50 0%, #e96d13 100%);
    box-shadow:
        0 24px 42px rgba(244,122,32,0.30),
        inset 0 1px 0 rgba(255,255,255,0.20);
}

.find-pros-btn i{
    font-size:24px;
    line-height:1;
}

/* optional category pills section */
.find-pros-categories{
    background:#ffffff;
    padding:34px 0 28px;
}

.find-pros-category-title{
    font-size:14px;
    font-weight:700;
    letter-spacing:2px;
    color:#667085;
    text-transform:uppercase;
    margin-bottom:22px;
}

.find-pros-category-list{
    display:flex;
    gap:16px;
    flex-wrap:wrap;
}

.find-pros-category-pill{
    display:inline-flex;
    align-items:center;
    gap:12px;
    min-height:58px;
    padding:0 28px;
    border-radius:18px;
    border:1px solid #d7dfe8;
    background:#ffffff;
    color:var(--ck-dark);
    font-size:17px;
    font-weight:700;
    text-decoration:none;
    transition:all 0.3s ease;
}

.find-pros-category-pill i{
    font-size:20px;
}

.find-pros-category-pill:hover{
    border-color:var(--ck-primary);
    color:var(--ck-primary);
    transform:translateY(-2px);
    box-shadow:0 10px 22px rgba(11,74,147,0.08);
}

.find-pros-category-pill.active{
    background:#0a0d12;
    color:#ffffff;
    border-color:#0a0d12;
    box-shadow:0 12px 24px rgba(0,0,0,0.16);
}

.find-pros-category-pill.active i{
    color:var(--ck-secondary);
}

/* responsive */
@media (max-width: 1400px){
    .find-pros-title{
        font-size:80px;
    }
}

@media (max-width: 1199px){
    .find-pros-title{
        font-size:66px;
    }

    .find-pros-search-grid{
        grid-template-columns:repeat(2, 1fr);
    }

    .find-pros-search-card{
        border-radius:28px;
    }
}

@media (max-width: 767px){
    .find-pros-hero{
        padding:52px 0 62px;
        background-size:32px 32px, 32px 32px, auto, auto, auto;
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
        margin:18px 0 30px;
    }

    .find-pros-search-card{
        padding:22px 16px 20px;
        border-radius:22px;
    }

    .find-pros-search-grid{
        grid-template-columns:1fr;
        gap:14px;
        margin-bottom:20px;
    }

    .find-pros-field label{
        font-size:15px;
        margin-bottom:8px;
    }

    .find-pros-field select{
        height:58px;
        font-size:16px;
        border-radius:14px;
        padding:0 16px;
    }

    .find-pros-btn{
        width:100%;
        min-width:100%;
        height:58px;
        font-size:17px;
        border-radius:14px;
    }

    .find-pros-btn i{
        font-size:20px;
    }

    .find-pros-category-pill{
        width:100%;
        justify-content:flex-start;
        min-height:52px;
        border-radius:14px;
        font-size:15px;
        padding:0 18px;
    }
}

:root{
    --ck-primary:#0B4A93;
    --ck-secondary:#F47A20;
    --ck-dark:#1C2C3E;
    --ck-black:#05070b;
    --ck-white:#ffffff;
    --ck-bg:#f5f6f8;
    --ck-border:#d9dee5;
    --ck-text:#27364a;
    --ck-muted:#6c7a8c;
    --ck-yellow:#f4cf08;
}

.pro-category-area-section{
    background:#f3f3f4;
    padding:0;
}

.container-custom{
    width:min(1280px, 92%);
    margin:0 auto;
}

/* top category block */
.pro-category-block{
    background:#ffffff;
    padding:34px 0 38px;
}

.pro-small-heading{
    font-size:13px;
    font-weight:800;
    letter-spacing:2.4px;
    color:#627287;
    margin-bottom:24px;
}

.pro-category-list{
    display:flex;
    flex-wrap:wrap;
    gap:18px;
}

.pro-category-chip{
    min-height:66px;
    padding:0 28px;
    border-radius:18px;
    border:2px solid #d8dde4;
    background:#ffffff;
    color:#2c3440;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    gap:14px;
    font-size:17px;
    font-weight:700;
    transition:all 0.3s ease;
}

.pro-category-chip i{
    font-size:23px;
    line-height:1;
    color:#444;
    transition:all 0.3s ease;
}

.pro-category-chip:hover{
    border-color:var(--ck-primary);
    color:var(--ck-primary);
    transform:translateY(-2px);
    box-shadow:0 10px 24px rgba(11,74,147,0.08);
}

.pro-category-chip:hover i{
    color:var(--ck-primary);
}

.pro-category-chip.active{
    background:#05070b;
    border-color:#05070b;
    color:#f4cf08;
    box-shadow:0 12px 24px rgba(0,0,0,0.16);
}

.pro-category-chip.active i{
    color:#f4cf08;
}

/* explore areas block */
.pro-areas-block{
    background:#efefef;
    padding:82px 0 78px;
}

.pro-areas-head{
    margin-bottom:42px;
}

.pro-areas-head h2{
    margin:0 0 10px;
    font-family:Georgia, "Times New Roman", serif;
    font-size:62px;
    line-height:1;
    font-weight:700;
    color:#111827;
    letter-spacing:-1px;
}

.pro-areas-head p{
    margin:0;
    font-size:19px;
    color:#66758a;
    font-weight:500;
}

.pro-areas-grid{
    display:grid;
    grid-template-columns:repeat(5, 1fr);
    gap:22px;
}

.pro-area-card{
    min-height:210px;
    border-radius:22px;
    border:2px solid #d9dde3;
    background:#f8f8f9;
    text-decoration:none;
    padding:26px 24px 24px;
    transition:all 0.3s ease;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.pro-area-card:hover{
    transform:translateY(-4px);
    border-color:#c6cfdb;
    box-shadow:0 14px 30px rgba(28,44,62,0.08);
}

.pro-area-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
    margin-bottom:26px;
}

.pro-area-icon{
    font-size:30px;
    color:#707070;
    line-height:1;
}

.pro-area-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-width:56px;
    height:34px;
    padding:0 16px;
    border-radius:999px;
    font-size:16px;
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
    margin:0 0 12px;
    font-size:24px;
    line-height:1.2;
    font-weight:800;
    color:#243247;
}

.pro-area-card p{
    margin:0;
    font-size:18px;
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

/* responsive */
@media (max-width: 1399px){
    .pro-areas-grid{
        grid-template-columns:repeat(3, 1fr);
    }
}

@media (max-width: 991px){
    .pro-category-block{
        padding:28px 0 30px;
    }

    .pro-category-list{
        gap:14px;
    }

    .pro-category-chip{
        min-height:58px;
        padding:0 22px;
        font-size:15px;
        border-radius:16px;
    }

    .pro-category-chip i{
        font-size:20px;
    }

    .pro-areas-block{
        padding:56px 0 56px;
    }

    .pro-areas-head h2{
        font-size:44px;
    }

    .pro-areas-head p{
        font-size:17px;
    }

    .pro-areas-grid{
        grid-template-columns:repeat(2, 1fr);
        gap:18px;
    }

    .pro-area-card{
        min-height:190px;
        padding:22px 20px;
    }

    .pro-area-card h3{
        font-size:22px;
    }

    .pro-area-card p{
        font-size:16px;
    }
}

@media (max-width: 767px){
    .pro-small-heading{
        font-size:12px;
        margin-bottom:18px;
    }

    .pro-category-list{
        gap:12px;
    }

    .pro-category-chip{
        width:100%;
        justify-content:flex-start;
        min-height:54px;
        padding:0 18px;
        font-size:15px;
        border-radius:14px;
    }

    .pro-areas-block{
        padding:40px 0 42px;
    }

    .pro-areas-head{
        margin-bottom:24px;
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
        min-height:160px;
        border-radius:18px;
        padding:18px 18px;
    }

    .pro-area-top{
        margin-bottom:18px;
    }

    .pro-area-icon{
        font-size:24px;
    }

    .pro-area-badge{
        min-width:50px;
        height:30px;
        font-size:14px;
        padding:0 12px;
    }

    .pro-area-card h3{
        font-size:20px;
        margin-bottom:8px;
    }

    .pro-area-card p{
        font-size:15px;
    }
}
:root{
    --ck-primary:#0B4A93;
    --ck-secondary:#F47A20;
    --ck-dark:#1C2C3E;
    --ck-black:#05070b;
    --ck-white:#ffffff;
    --ck-bg:#f3f3f4;
    --ck-border:#ebd35a;
    --ck-text:#141b24;
    --ck-muted:#697586;
    --ck-star:#f4c400;
    --ck-verified-bg:#e7f6ec;
    --ck-verified-text:#17834f;
}

.container-custom{
    width:min(1280px, 92%);
    margin:0 auto;
}

.ranked-pros-section{
    background:#f3f3f4;
    padding:42px 0 26px;
}

.ranked-pros-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:24px;
    margin-bottom:28px;
    flex-wrap:wrap;
}

.ranked-pros-label{
    display:flex;
    align-items:center;
    gap:12px;
    font-size:13px;
    font-weight:800;
    letter-spacing:2.3px;
    color:#5e6c80;
    margin-bottom:18px;
}

.ranked-line{
    width:42px;
    height:6px;
    border-radius:999px;
    background:#f4c400;
    display:inline-block;
}

.ranked-pros-title{
    margin:0;
    font-family:Georgia, "Times New Roman", serif;
    font-size:62px;
    line-height:1.02;
    font-weight:700;
    color:#111111;
    letter-spacing:-1px;
}

.ranked-pros-updated{
    font-size:16px;
    font-weight:500;
    color:#6d798b;
    padding-top:58px;
}

.ranked-pros-divider{
    height:2px;
    background:#efe08a;
    margin-bottom:42px;
    border-radius:999px;
}

.ranked-pros-list{
    display:flex;
    flex-direction:column;
    gap:22px;
}

.ranked-pro-card{
    background:#ffffff;
    border:2px solid #efc400;
    border-radius:28px;
    padding:34px 30px;
    transition:all 0.3s ease;
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
    gap:18px;
    min-width:0;
    flex:1;
}

.rank-box{
    width:68px;
    height:86px;
    border-radius:18px;
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
    top:8px;
    right:7px;
    font-size:14px;
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
    width:78px;
    height:78px;
    border-radius:22px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#ffffff;
    font-size:24px;
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
    gap:14px;
    flex-wrap:wrap;
    margin-bottom:10px;
}

.ranked-name-row h3{
    margin:0;
    font-size:22px;
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
    padding:8px 14px;
    font-size:14px;
    font-weight:700;
    line-height:1;
}

.verified-badge i{
    font-size:14px;
}

.ranked-meta-row{
    display:flex;
    align-items:center;
    gap:24px;
    flex-wrap:wrap;
    margin-bottom:12px;
}

.ranked-meta-row span{
    display:inline-flex;
    align-items:center;
    gap:8px;
    color:#677487;
    font-size:17px;
    font-weight:500;
}

.ranked-meta-row i{
    font-size:17px;
}

.ranked-rating-row{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    margin-bottom:14px;
}

.stars{
    display:inline-flex;
    align-items:center;
    gap:2px;
    color:#f4c400;
    font-size:18px;
}

.ranked-rating-row strong{
    font-size:18px;
    color:#111827;
    font-weight:800;
}

.ranked-rating-row span{
    color:#6d798b;
    font-size:16px;
    font-weight:500;
}

.ranked-quote{
    margin:0;
    color:#5c697a;
    font-size:17px;
    line-height:1.7;
    font-weight:500;
}

.ranked-pro-right{
    flex-shrink:0;
}

.ranked-view-btn{
    min-width:188px;
    height:62px;
    padding:0 24px;
    border-radius:18px;
    background:#05070b;
    color:#f4cf08;
    text-decoration:none;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:12px;
    font-size:17px;
    font-weight:800;
    transition:all 0.3s ease;
    box-shadow:0 10px 22px rgba(0,0,0,0.10);
}

.ranked-view-btn:hover{
    background:#111827;
    color:#ffffff;
    transform:translateY(-2px);
}

.ranked-view-btn i{
    font-size:18px;
}

/* responsive */
@media (max-width: 1199px){
    .ranked-pros-title{
        font-size:50px;
    }

    .ranked-pros-updated{
        padding-top:0;
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

@media (max-width: 767px){
    .ranked-pros-section{
        padding:34px 0 18px;
    }

    .ranked-pros-head{
        margin-bottom:20px;
    }

    .ranked-pros-label{
        font-size:12px;
        margin-bottom:12px;
    }

    .ranked-line{
        width:34px;
        height:5px;
    }

    .ranked-pros-title{
        font-size:36px;
        line-height:1.08;
    }

    .ranked-pros-updated{
        font-size:14px;
    }

    .ranked-pros-divider{
        margin-bottom:24px;
    }

    .ranked-pro-card{
        padding:20px 16px;
        border-radius:20px;
    }

    .ranked-pro-left{
        align-items:flex-start;
        gap:14px;
        flex-wrap:wrap;
    }

    .rank-box{
        width:54px;
        height:68px;
        border-radius:14px;
    }

    .rank-number{
        font-size:20px;
    }

    .company-logo{
        width:64px;
        height:64px;
        border-radius:18px;
        font-size:22px;
    }

    .ranked-pro-content{
        width:100%;
    }

    .ranked-name-row h3{
        font-size:20px;
    }

    .verified-badge{
        font-size:13px;
        padding:7px 12px;
    }

    .ranked-meta-row{
        gap:14px;
        margin-bottom:10px;
    }

    .ranked-meta-row span{
        font-size:15px;
    }

    .ranked-rating-row strong,
    .ranked-rating-row span{
        font-size:15px;
    }

    .stars{
        font-size:16px;
    }

    .ranked-quote{
        font-size:15px;
    }

    .ranked-view-btn{
        height:54px;
        border-radius:14px;
        font-size:16px;
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

        <!-- Browse By Category -->
        <div class="pro-category-block">
            <div class="pro-small-heading">BROWSE BY CATEGORY</div>

            <div class="pro-category-list">
                <a href="#" class="pro-category-chip active">
                    <i class="bi bi-hammer"></i>
                    Contractors
                </a>

                <a href="#" class="pro-category-chip">
                    <i class="bi bi-pencil"></i>
                    Architects
                </a>

                <a href="#" class="pro-category-chip">
                    <i class="bi bi-box-seam"></i>
                    Suppliers
                </a>

                <a href="#" class="pro-category-chip">
                    <i class="bi bi-briefcase"></i>
                    Consultants
                </a>

                <a href="#" class="pro-category-chip">
                    <i class="bi bi-geo-alt"></i>
                    Surveyors
                </a>

                <a href="#" class="pro-category-chip">
                    <i class="bi bi-palette"></i>
                    Designers
                </a>

                <a href="#" class="pro-category-chip">
                    <i class="bi bi-house-door"></i>
                    Brokers
                </a>
            </div>
        </div>

        <!-- Explore Areas -->
        <div class="pro-areas-block">
            <div class="pro-areas-head">
                <h2>Explore Areas</h2>
                <p>Navi Mumbai · 5 popular localities</p>
            </div>

            <div class="pro-areas-grid">

                <a href="#" class="pro-area-card active">
                    <div class="pro-area-top">
                        <div class="pro-area-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <span class="pro-area-badge hot">Hot</span>
                    </div>
                    <h3>Vashi</h3>
                    <p>Sector 1–30</p>
                </a>

                <a href="#" class="pro-area-card">
                    <div class="pro-area-top">
                        <div class="pro-area-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                    </div>
                    <h3>Nerul</h3>
                    <p>East &amp; West</p>
                </a>

                <a href="#" class="pro-area-card">
                    <div class="pro-area-top">
                        <div class="pro-area-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                    </div>
                    <h3>Seawoods</h3>
                    <p>Grand Central</p>
                </a>

                <a href="#" class="pro-area-card">
                    <div class="pro-area-top">
                        <div class="pro-area-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <span class="pro-area-badge new">New</span>
                    </div>
                    <h3>Kharghar</h3>
                    <p>Hills &amp; Valley</p>
                </a>

                <a href="#" class="pro-area-card">
                    <div class="pro-area-top">
                        <div class="pro-area-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
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

            <!-- Card 1 -->
            <div class="ranked-pro-card rank-1">
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

            <!-- Card 2 -->
            <div class="ranked-pro-card rank-2">
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

            <!-- Card 3 -->
            <div class="ranked-pro-card rank-3">
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