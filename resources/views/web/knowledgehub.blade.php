@extends('layouts.app')

@section('title', 'Construction Vendor Discovery | ConstructKaro')

@section('content')
<style>
:root{
    --ck-primary:#1c2c3e;
    --ck-secondary:#f25c05;
    --ck-secondary-dark:#d94f04;
    --ck-accent:#f4c21b;
    --ck-bg:#f7f9fc;
    --ck-card:#ffffff;
    --ck-text:#1b2430;
    --ck-muted:#667085;
    --ck-border:#e8edf3;
    --ck-shadow:0 10px 30px rgba(28,44,62,0.07);
    --ck-shadow-hover:0 18px 40px rgba(28,44,62,0.12);
}

body{
    background:var(--ck-bg);
}

.container-custom{
    width:min(1280px, 94%);
    margin:0 auto;
}

/* =========================
   COMMON
========================= */
.section-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    margin-bottom:28px;
    flex-wrap:wrap;
}

.section-title-wrap{
    display:flex;
    align-items:center;
    gap:14px;
}

.section-line{
    width:5px;
    height:32px;
    border-radius:20px;
    background:var(--ck-secondary);
    flex-shrink:0;
}

.section-title{
    margin:0;
    font-size:30px;
    line-height:1.2;
    font-weight:900;
    color:var(--ck-primary);
    letter-spacing:-0.5px;
}

.section-link{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    color:var(--ck-primary);
    font-size:15px;
    font-weight:700;
    transition:0.3s ease;
}

.section-link i{
    transition:0.3s ease;
}

.section-link:hover{
    color:var(--ck-secondary);
}

.section-link:hover i{
    transform:translateX(4px);
}

/* =========================
   HERO
========================= */
.knowledge-hub-section{
    padding:34px 0 26px;
    background:var(--ck-bg);
}

.knowledge-hub-inner{
    position:relative;
    overflow:hidden;
    border-radius:28px;
    padding:72px 22px 78px;
    min-height:420px;
    display:flex;
    align-items:center;
    justify-content:center;
    background:
        linear-gradient(rgba(28,44,62,0.045) 1px, transparent 1px),
        linear-gradient(90deg, rgba(28,44,62,0.045) 1px, transparent 1px),
        linear-gradient(180deg, #fbfcfe 0%, #f4f7fb 100%);
    background-size:44px 44px, 44px 44px, auto;
    border:1px solid rgba(28,44,62,0.06);
    box-shadow:var(--ck-shadow);
}

.knowledge-hub-inner::before{
    content:"";
    position:absolute;
    top:-80px;
    left:-60px;
    width:220px;
    height:220px;
    background:radial-gradient(circle, rgba(242,92,5,0.10), transparent 70%);
    pointer-events:none;
}

.knowledge-hub-inner::after{
    content:"";
    position:absolute;
    right:-60px;
    bottom:-80px;
    width:260px;
    height:260px;
    background:radial-gradient(circle, rgba(28,44,62,0.10), transparent 70%);
    pointer-events:none;
}

.knowledge-hub-content{
    position:relative;
    z-index:2;
    text-align:center;
    max-width:850px;
    margin:0 auto;
}

.knowledge-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#111;
    color:#fff;
    border-radius:999px;
    padding:10px 18px;
    font-size:11px;
    font-weight:800;
    letter-spacing:1.8px;
    margin-bottom:20px;
    box-shadow:0 10px 24px rgba(0,0,0,0.10);
}

.knowledge-badge span{
    color:var(--ck-secondary);
    margin-left:6px;
}

.knowledge-title{
    margin:0 0 14px;
    font-size:62px;
    line-height:1.02;
    font-weight:900;
    color:var(--ck-primary);
    letter-spacing:-2px;
}

.knowledge-highlight{
    margin:0 0 16px;
    font-size:26px;
    line-height:1.5;
    color:#111827;
    font-weight:700;
}

.knowledge-highlight strong{
    color:var(--ck-secondary);
}

.knowledge-desc{
    margin:0 auto 34px;
    max-width:720px;
    font-size:17px;
    line-height:1.9;
    color:var(--ck-muted);
    font-weight:500;
}

.knowledge-search-box{
    max-width:650px;
    margin:0 auto;
    background:#fff;
    border:1px solid var(--ck-border);
    border-radius:18px;
    display:flex;
    align-items:center;
    gap:10px;
    padding:8px 8px 8px 16px;
    box-shadow:0 14px 36px rgba(28,44,62,0.08);
}

.knowledge-search-icon{
    width:36px;
    height:36px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#98a2b3;
    font-size:18px;
    flex-shrink:0;
}

.knowledge-search-input{
    flex:1;
    border:none;
    outline:none;
    background:transparent;
    color:var(--ck-primary);
    font-size:15px;
    font-weight:600;
    padding:12px 2px;
}

.knowledge-search-input::placeholder{
    color:#98a2b3;
    font-weight:500;
}

.knowledge-search-btn{
    border:none;
    outline:none;
    background:#111;
    color:#fff;
    border-radius:14px;
    padding:14px 26px;
    min-width:120px;
    font-size:14px;
    font-weight:800;
    transition:0.3s ease;
    box-shadow:0 8px 22px rgba(0,0,0,0.10);
}

.knowledge-search-btn:hover{
    background:var(--ck-secondary);
    transform:translateY(-2px);
}

.knowledge-bottom-strip{
    position:absolute;
    left:0;
    bottom:0;
    width:100%;
    height:9px;
    background:repeating-linear-gradient(
        -45deg,
        #111 0 10px,
        #111 10px 16px,
        var(--ck-secondary) 16px 26px,
        var(--ck-secondary) 26px 32px
    );
}

.kh-corner{
    position:absolute;
    width:34px;
    height:34px;
    z-index:1;
}

.kh-corner::before,
.kh-corner::after{
    content:"";
    position:absolute;
    background:rgba(242,92,5,0.45);
    border-radius:10px;
}

.kh-corner-top-left{ top:16px; left:16px; }
.kh-corner-top-right{ top:16px; right:16px; }
.kh-corner-bottom-left{ bottom:16px; left:16px; }
.kh-corner-bottom-right{ bottom:16px; right:16px; }

.kh-corner-top-left::before,
.kh-corner-top-right::before,
.kh-corner-bottom-left::before,
.kh-corner-bottom-right::before{
    width:34px; height:2px;
}

.kh-corner-top-left::after,
.kh-corner-top-right::after,
.kh-corner-bottom-left::after,
.kh-corner-bottom-right::after{
    width:2px; height:34px;
}

.kh-corner-top-right::before,
.kh-corner-bottom-right::before{ right:0; }
.kh-corner-top-right::after,
.kh-corner-bottom-right::after{ right:0; }

.kh-corner-bottom-left::before,
.kh-corner-bottom-right::before{ bottom:0; }

.kh-corner-bottom-left::after,
.kh-corner-bottom-right::after{ bottom:0; }

/* =========================
   TOPICS
========================= */
.explore-topics-section{
    padding:26px 0 20px;
}

.explore-topics-grid{
    display:grid;
    grid-template-columns:repeat(5,1fr);
    gap:18px;
}

.topic-card{
    background:#fff;
    border:1px solid var(--ck-border);
    border-radius:22px;
    padding:24px 22px;
    text-decoration:none;
    min-height:210px;
    box-shadow:var(--ck-shadow);
    transition:0.3s ease;
    position:relative;
    overflow:hidden;
}

.topic-card::before{
    content:"";
    position:absolute;
    left:0;
    top:0;
    width:100%;
    height:5px;
    background:linear-gradient(90deg, var(--ck-secondary), var(--ck-accent));
    opacity:0;
    transition:0.3s ease;
}

.topic-card:hover{
    transform:translateY(-6px);
    box-shadow:var(--ck-shadow-hover);
    border-color:#d8e0ea;
}

.topic-card:hover::before{
    opacity:1;
}

.topic-icon-box{
    width:54px;
    height:54px;
    border-radius:16px;
    background:linear-gradient(135deg, rgba(242,92,5,0.12), rgba(28,44,62,0.06));
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:16px;
    font-size:22px;
    color:var(--ck-primary);
}

.topic-title{
    margin:0 0 10px;
    font-size:17px;
    line-height:1.4;
    font-weight:800;
    color:var(--ck-primary);
}

.topic-desc{
    margin:0;
    font-size:13px;
    line-height:1.8;
    color:var(--ck-muted);
    font-weight:500;
}

/* =========================
   FEATURED INSIGHTS
========================= */
.featured-insights-section{
    padding:30px 0 20px;
}

.featured-title-group{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.featured-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#f4c21b;
    color:#111;
    font-size:10px;
    font-weight:800;
    letter-spacing:1px;
    padding:6px 10px;
    border-radius:999px;
}

.featured-insights-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:22px;
}

.insight-card{
    background:#fff;
    border:1px solid var(--ck-border);
    border-radius:22px;
    overflow:hidden;
    text-decoration:none;
    box-shadow:var(--ck-shadow);
    transition:0.3s ease;
}

.insight-card:hover{
    transform:translateY(-6px);
    box-shadow:var(--ck-shadow-hover);
}

.insight-thumb{
    position:relative;
    height:170px;
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:center;
}

.insight-thumb-dark{
    background:linear-gradient(135deg, #162536, #243850);
}

.insight-thumb-yellow{
    background:linear-gradient(135deg, #f0b000, #d89200);
}

.insight-grid-overlay{
    position:absolute;
    inset:0;
    background-image:
        linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
    background-size:22px 22px;
}

.insight-ghost-icon{
    position:relative;
    z-index:2;
    font-size:68px;
    color:rgba(255,255,255,0.16);
}

.insight-thumb-yellow .insight-ghost-icon{
    color:rgba(28,44,62,0.14);
}

.insight-tag{
    position:absolute;
    left:16px;
    bottom:16px;
    z-index:3;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#f4c21b;
    color:#111;
    font-size:10px;
    font-weight:800;
    letter-spacing:1px;
    padding:6px 10px;
    border-radius:8px;
}

.insight-tag-dark{
    background:#111;
    color:#f4c21b;
}

.insight-body{
    padding:20px;
}

.insight-title{
    margin:0 0 10px;
    font-size:18px;
    line-height:1.45;
    font-weight:800;
    color:#17202b;
}

.insight-title-highlight{
    color:#d88d00;
}

.insight-desc{
    margin:0 0 14px;
    font-size:14px;
    line-height:1.8;
    color:var(--ck-muted);
    font-weight:500;
}

.insight-meta{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    font-size:12px;
    color:#8b95a5;
    font-weight:700;
}

/* =========================
   LATEST ARTICLES
========================= */
.latest-articles-section{
    padding:30px 0 20px;
}

.latest-articles-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:22px;
}

.article-card{
    background:#fff;
    border:1px solid var(--ck-border);
    border-radius:22px;
    overflow:hidden;
    text-decoration:none;
    box-shadow:var(--ck-shadow);
    transition:0.3s ease;
}

.article-card:hover{
    transform:translateY(-6px);
    box-shadow:var(--ck-shadow-hover);
}

.article-thumb{
    position:relative;
    height:180px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

.article-thumb-dark{ background:linear-gradient(135deg,#455367,#1d2b3f); }
.article-thumb-orange{ background:linear-gradient(135deg,#f59f00,#d97706); }
.article-thumb-blue{ background:linear-gradient(135deg,#0d7cc0,#1d4ed8); }
.article-thumb-green{ background:linear-gradient(135deg,#0c9e67,#08724a); }
.article-thumb-purple{ background:linear-gradient(135deg,#8b3dff,#5b2ab9); }
.article-thumb-red{ background:linear-gradient(135deg,#ef233c,#b5173f); }

.article-grid-overlay{
    position:absolute;
    inset:0;
    background-image:
        linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
    background-size:22px 22px;
    opacity:0.4;
}

.article-tag{
    position:absolute;
    left:16px;
    bottom:16px;
    z-index:3;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    font-size:10px;
    font-weight:800;
    letter-spacing:1px;
    padding:7px 11px;
    border-radius:8px;
    backdrop-filter:blur(2px);
}

.article-tag-light,
.article-tag-soft,
.article-tag-blue,
.article-tag-green,
.article-tag-purple,
.article-tag-red{
    background:rgba(255,255,255,0.18);
    color:#fff;
}

.article-ghost-icon{
    position:relative;
    z-index:2;
    font-size:74px;
    color:rgba(255,255,255,0.14);
}

.article-body{
    padding:20px;
}

.article-title{
    margin:0 0 12px;
    font-size:18px;
    line-height:1.45;
    font-weight:800;
    color:#101828;
}

.article-title-accent{
    color:#d88d00;
}

.article-desc{
    margin:0 0 18px;
    font-size:14px;
    line-height:1.8;
    color:var(--ck-muted);
    font-weight:500;
}

.article-footer{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
}

.article-time{
    display:flex;
    align-items:center;
    gap:7px;
    font-size:13px;
    color:#667085;
    font-weight:700;
}

.article-readmore{
    display:inline-flex;
    align-items:center;
    gap:8px;
    color:var(--ck-secondary);
    font-size:14px;
    font-weight:800;
}

.article-readmore i{
    transition:0.3s ease;
}

.article-card:hover .article-readmore i{
    transform:translateX(4px);
}

/* =========================
   FROM THE FIELD
========================= */
.from-field-section{
    padding:36px 0 0;
    background:#0d1117;
}

.from-field-wrap{
    position:relative;
    border-radius:28px 28px 0 0;
    overflow:hidden;
    padding:38px 0 70px;
    background:
        linear-gradient(rgba(244,194,27,0.06) 1px, transparent 1px),
        linear-gradient(90deg, rgba(244,194,27,0.06) 1px, transparent 1px),
        linear-gradient(180deg, #121722 0%, #0b1018 100%);
    background-size:34px 34px, 34px 34px, auto;
}

.from-field-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    flex-wrap:wrap;
    margin-bottom:28px;
    padding:0 16px;
}

.from-field-title-group{
    display:flex;
    align-items:center;
    gap:14px;
    flex-wrap:wrap;
}

.from-field-line{
    width:5px;
    height:34px;
    border-radius:20px;
    background:var(--ck-accent);
}

.from-field-title-group h2{
    margin:0;
    font-size:30px;
    font-weight:900;
    color:#fff;
}

.from-field-live{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:rgba(244,194,27,0.12);
    color:var(--ck-accent);
    padding:7px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:800;
    letter-spacing:1px;
}

.from-field-handle{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    color:var(--ck-accent);
    font-size:15px;
    font-weight:700;
}

.from-field-handle:hover{
    color:#fff;
}

.from-field-cards{
    display:grid;
    grid-template-columns:repeat(6, minmax(180px, 1fr));
    gap:16px;
    overflow-x:auto;
    padding:0 16px 8px;
    scrollbar-width:none;
}

.from-field-cards::-webkit-scrollbar{
    display:none;
}

.field-card{
    position:relative;
    min-height:270px;
    border-radius:22px;
    padding:14px;
    text-decoration:none;
    overflow:hidden;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    transition:0.3s ease;
    box-shadow:0 16px 34px rgba(0,0,0,0.28);
}

.field-card:hover{
    transform:translateY(-6px);
}

.field-card::before{
    content:"";
    position:absolute;
    inset:0;
    background:
        linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
    background-size:18px 18px;
    opacity:0.3;
}

.field-card-yellow{ background:linear-gradient(180deg,#f4b000 0%,#cb8500 100%); }
.field-card-slate{ background:linear-gradient(180deg,#71809b 0%,#253040 100%); }
.field-card-blue{ background:linear-gradient(180deg,#3572ff 0%,#143b9c 100%); }
.field-card-pink{ background:linear-gradient(180deg,#ff4562 0%,#a30d3f 100%); }
.field-card-orange{ background:linear-gradient(180deg,#ff8a00 0%,#a64c00 100%); }
.field-card-green{ background:linear-gradient(180deg,#1fcf86 0%,#08764b 100%); }

.field-card-badge{
    position:relative;
    z-index:2;
    align-self:flex-start;
    display:inline-flex;
    align-items:center;
    gap:6px;
    padding:7px 10px;
    border-radius:999px;
    background:rgba(0,0,0,0.22);
    color:#fff;
    font-size:10px;
    font-weight:800;
    letter-spacing:0.8px;
}

.field-card-icon{
    position:relative;
    z-index:2;
    display:flex;
    align-items:center;
    justify-content:center;
    flex:1;
    font-size:54px;
}

.field-card-title{
    position:relative;
    z-index:2;
    margin:0;
    font-size:20px;
    line-height:1.3;
    color:#fff;
    font-weight:900;
}

.from-field-bottom-strip{
    position:absolute;
    left:0;
    bottom:0;
    width:100%;
    height:9px;
    background:repeating-linear-gradient(
        -45deg,
        #f4c21b 0 10px,
        #f4c21b 10px 16px,
        #151515 16px 26px,
        #151515 26px 32px
    );
}

/* =========================
   CTA
========================= */
.construction-cta-section{
    padding:34px 0 0;
    background:var(--ck-bg);
}

.construction-cta-wrap{
    position:relative;
    overflow:hidden;
    border-radius:28px 28px 0 0;
    padding:64px 20px 72px;
    background:
        linear-gradient(rgba(28,44,62,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(28,44,62,0.04) 1px, transparent 1px),
        linear-gradient(180deg,#fbfcfd 0%, #f4f7fb 100%);
    background-size:40px 40px, 40px 40px, auto;
    border:1px solid rgba(28,44,62,0.05);
    box-shadow:var(--ck-shadow);
}

.construction-cta-content{
    position:relative;
    z-index:2;
    max-width:860px;
    margin:0 auto;
    text-align:center;
}

.construction-cta-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    background:#f6ecdb;
    color:var(--ck-primary);
    padding:10px 18px;
    border-radius:999px;
    font-size:12px;
    font-weight:800;
    letter-spacing:1.4px;
    margin-bottom:22px;
}

.construction-cta-badge i{
    color:var(--ck-secondary);
}

.construction-cta-title{
    margin:0 0 16px;
    font-size:52px;
    line-height:1.12;
    font-weight:900;
    color:var(--ck-primary);
    letter-spacing:-1.4px;
}

.construction-cta-desc{
    margin:0 auto 32px;
    max-width:720px;
    font-size:18px;
    line-height:1.85;
    color:var(--ck-muted);
    font-weight:500;
}

.construction-cta-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:14px;
    min-width:430px;
    max-width:100%;
    min-height:68px;
    padding:16px 28px;
    border-radius:18px;
    background:#111;
    color:#fff;
    text-decoration:none;
    font-size:20px;
    font-weight:800;
    box-shadow:0 14px 34px rgba(0,0,0,0.12);
    transition:0.3s ease;
}

.construction-cta-btn:hover{
    background:var(--ck-secondary);
    transform:translateY(-3px);
}

.construction-cta-btn i{
    transition:0.3s ease;
}

.construction-cta-btn:hover i{
    transform:translateX(4px);
}

.cta-dot-shape{
    position:absolute;
    right:24%;
    top:48%;
    width:26px;
    height:26px;
    border-radius:50%;
    background:#1fc7d4;
    opacity:0.9;
}

.cta-corner{
    position:absolute;
    width:44px;
    height:44px;
}

.cta-corner::before,
.cta-corner::after{
    content:"";
    position:absolute;
    background:rgba(244,194,27,0.45);
}

.cta-corner-top-left{ top:26px; left:18%; }
.cta-corner-top-right{ top:26px; right:18%; }
.cta-corner-bottom-left{ bottom:26px; left:18%; }
.cta-corner-bottom-right{ bottom:26px; right:18%; }

.cta-corner-top-left::before,
.cta-corner-top-right::before,
.cta-corner-bottom-left::before,
.cta-corner-bottom-right::before{
    width:44px;
    height:2px;
}

.cta-corner-top-left::after,
.cta-corner-top-right::after,
.cta-corner-bottom-left::after,
.cta-corner-bottom-right::after{
    width:2px;
    height:44px;
}

.cta-corner-top-right::before,
.cta-corner-bottom-right::before{ right:0; }
.cta-corner-top-right::after,
.cta-corner-bottom-right::after{ right:0; }

.cta-corner-bottom-left::before,
.cta-corner-bottom-right::before{ bottom:0; }
.cta-corner-bottom-left::after,
.cta-corner-bottom-right::after{ bottom:0; }

.construction-cta-bottom-strip{
    position:absolute;
    left:0;
    bottom:0;
    width:100%;
    height:9px;
    background:repeating-linear-gradient(
        -45deg,
        #111 0 10px,
        #111 10px 16px,
        #f4c21b 16px 26px,
        #f4c21b 26px 32px
    );
}

/* =========================
   RESPONSIVE
========================= */
@media (max-width: 1199px){
    .knowledge-title{ font-size:52px; }
    .explore-topics-grid{ grid-template-columns:repeat(3,1fr); }
    .featured-insights-grid{ grid-template-columns:1fr; }
    .latest-articles-grid{ grid-template-columns:repeat(2,1fr); }
}

@media (max-width: 991px){
    .knowledge-hub-inner{ min-height:auto; padding:56px 18px 66px; }
    .knowledge-title{ font-size:42px; }
    .knowledge-highlight{ font-size:22px; }
    .knowledge-desc{ font-size:15px; }

    .construction-cta-title{ font-size:40px; }
    .construction-cta-btn{
        width:100%;
        min-width:100%;
    }

    .cta-corner-top-left,
    .cta-corner-bottom-left{ left:8%; }

    .cta-corner-top-right,
    .cta-corner-bottom-right{ right:8%; }
}

@media (max-width: 767px){
    .section-title{ font-size:24px; }

    .knowledge-hub-section{ padding:24px 0 18px; }
    .knowledge-hub-inner{
        border-radius:22px;
        padding:40px 14px 54px;
        background-size:28px 28px, 28px 28px, auto;
    }
    .knowledge-title{
        font-size:31px;
        line-height:1.12;
        letter-spacing:-1px;
    }
    .knowledge-highlight{
        font-size:17px;
        margin-bottom:12px;
    }
    .knowledge-desc{
        font-size:14px;
        line-height:1.8;
        margin-bottom:22px;
    }
    .knowledge-search-box{
        flex-wrap:wrap;
        padding:10px;
        border-radius:16px;
    }
    .knowledge-search-input{
        width:calc(100% - 48px);
        font-size:14px;
    }
    .knowledge-search-btn{
        width:100%;
    }

    .explore-topics-grid{ grid-template-columns:1fr; }
    .latest-articles-grid{ grid-template-columns:1fr; }

    .from-field-title-group h2,
    .construction-cta-title{
        font-size:30px;
    }

    .construction-cta-wrap{
        padding:42px 14px 56px;
        border-radius:22px 22px 0 0;
        background-size:28px 28px, 28px 28px, auto;
    }

    .construction-cta-desc{
        font-size:15px;
        margin-bottom:24px;
    }

    .construction-cta-btn{
        font-size:16px;
        min-height:58px;
        border-radius:16px;
    }

    .cta-dot-shape{ display:none; }
    .cta-corner{ width:28px; height:28px; }
    .cta-corner::before{ width:28px !important; height:2px !important; }
    .cta-corner::after{ height:28px !important; width:2px !important; }
}

@media (max-width: 520px){
    .featured-insights-grid{ grid-template-columns:1fr; }
    .from-field-cards{ grid-template-columns:repeat(6, 180px); }
}
</style>

<section class="knowledge-hub-section">
    <div class="container-custom">
        <div class="knowledge-hub-inner">
            <div class="kh-corner kh-corner-top-left"></div>
            <div class="kh-corner kh-corner-top-right"></div>
            <div class="kh-corner kh-corner-bottom-left"></div>
            <div class="kh-corner kh-corner-bottom-right"></div>

            <div class="knowledge-hub-content">
                <span class="knowledge-badge">KNOWLEDGE HUB <span>●</span></span>

                <h1 class="knowledge-title">ConstructKaro Knowledge Hub</h1>

                <p class="knowledge-highlight">
                    Learn. Plan. <strong>Build</strong> — All in One Place.
                </p>

                <p class="knowledge-desc">
                    India’s first platform where you can understand construction, explore practical insights,
                    compare topics, and start your project with more confidence.
                </p>

                <form class="knowledge-search-box" action="#" method="GET">
                    <div class="knowledge-search-icon">
                        <i class="bi bi-search"></i>
                    </div>

                    <input type="text" class="knowledge-search-input"
                        placeholder="Search articles, topics, guides..." name="search">

                    <button type="submit" class="knowledge-search-btn">Search</button>
                </form>
            </div>

            <div class="knowledge-bottom-strip"></div>
        </div>
    </div>
</section>

<section class="explore-topics-section">
    <div class="container-custom">
        <div class="section-head">
            <div class="section-title-wrap">
                <span class="section-line"></span>
                <h2 class="section-title">Explore Topics</h2>
            </div>
        </div>

        <div class="explore-topics-grid">
            <a href="#" class="topic-card">
                <div class="topic-icon-box"><i class="bi bi-bricks"></i></div>
                <h3 class="topic-title">Construction Education</h3>
                <p class="topic-desc">Understand construction basics, costing, materials, and processes.</p>
            </a>

            <a href="#" class="topic-card">
                <div class="topic-icon-box"><i class="bi bi-compass"></i></div>
                <h3 class="topic-title">How ConstructKaro Works</h3>
                <p class="topic-desc">Step-by-step guide for customers and vendors using the platform.</p>
            </a>

            <a href="#" class="topic-card">
                <div class="topic-icon-box"><i class="bi bi-send"></i></div>
                <h3 class="topic-title">Blogs & Insights</h3>
                <p class="topic-desc">Latest construction trends, expert ideas, and practical updates.</p>
            </a>

            <a href="#" class="topic-card">
                <div class="topic-icon-box"><i class="bi bi-tv"></i></div>
                <h3 class="topic-title">Social Feed</h3>
                <p class="topic-desc">Live updates, reels, field work visuals, and on-site activities.</p>
            </a>

            <a href="#" class="topic-card">
                <div class="topic-icon-box"><i class="bi bi-bar-chart-line"></i></div>
                <h3 class="topic-title">Case Studies</h3>
                <p class="topic-desc">Real project breakdowns, learnings, and practical success stories.</p>
            </a>
        </div>
    </div>
</section>

<section class="featured-insights-section">
    <div class="container-custom">
        <div class="section-head">
            <div class="featured-title-group">
                <div class="section-title-wrap">
                    <span class="section-line"></span>
                    <h2 class="section-title">Featured Insights</h2>
                </div>
                <span class="featured-badge">TRENDING</span>
            </div>
        </div>

        <div class="featured-insights-grid">
            <a href="#" class="insight-card">
                <div class="insight-thumb insight-thumb-dark">
                    <div class="insight-grid-overlay"></div>
                    <span class="insight-tag">GUIDE</span>
                    <div class="insight-ghost-icon"><i class="bi bi-calculator"></i></div>
                </div>
                <div class="insight-body">
                    <h3 class="insight-title">How to Calculate Construction Cost per Sqft</h3>
                    <p class="insight-desc">A practical breakdown of materials, labour, and overhead costs for residential construction in India.</p>
                    <div class="insight-meta">
                        <span><i class="bi bi-clock"></i> 8 min read</span>
                        <span>•</span>
                        <span>Dec 2024</span>
                    </div>
                </div>
            </a>

            <a href="#" class="insight-card">
                <div class="insight-thumb insight-thumb-yellow">
                    <div class="insight-grid-overlay"></div>
                    <span class="insight-tag insight-tag-dark">TIPS</span>
                    <div class="insight-ghost-icon"><i class="bi bi-exclamation-triangle"></i></div>
                </div>
                <div class="insight-body">
                    <h3 class="insight-title">5 Mistakes to Avoid While Building a Bungalow</h3>
                    <p class="insight-desc">Common first-time builder mistakes and smart planning steps to avoid delays, confusion, and cost issues.</p>
                    <div class="insight-meta">
                        <span><i class="bi bi-clock"></i> 6 min read</span>
                        <span>•</span>
                        <span>Nov 2024</span>
                    </div>
                </div>
            </a>

            <a href="#" class="insight-card">
                <div class="insight-thumb insight-thumb-dark">
                    <div class="insight-grid-overlay"></div>
                    <span class="insight-tag">PROCESS</span>
                    <div class="insight-ghost-icon"><i class="bi bi-layers"></i></div>
                </div>
                <div class="insight-body">
                    <h3 class="insight-title insight-title-highlight">Step-by-Step Construction Process Explained</h3>
                    <p class="insight-desc">From excavation to finishing, understand each major phase before you start your home construction journey.</p>
                    <div class="insight-meta">
                        <span><i class="bi bi-clock"></i> 12 min read</span>
                        <span>•</span>
                        <span>Oct 2024</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="latest-articles-section">
    <div class="container-custom">
        <div class="section-head">
            <div class="section-title-wrap">
                <span class="section-line"></span>
                <h2 class="section-title">Latest Articles</h2>
            </div>

            <a href="#" class="section-link">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="latest-articles-grid">
            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-dark">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-light">MATERIALS</span>
                    <div class="article-ghost-icon"><i class="bi bi-box-seam"></i></div>
                </div>
                <div class="article-body">
                    <h3 class="article-title">Choosing the Right Cement for Your Home</h3>
                    <p class="article-desc">OPC vs PPC — understand which cement grade works best for different parts of your house.</p>
                    <div class="article-footer">
                        <div class="article-time"><i class="bi bi-clock"></i> 5 min</div>
                        <span class="article-readmore">Read More <i class="bi bi-arrow-right"></i></span>
                    </div>
                </div>
            </a>

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-orange">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-soft">EDUCATION</span>
                    <div class="article-ghost-icon"><i class="bi bi-rulers"></i></div>
                </div>
                <div class="article-body">
                    <h3 class="article-title article-title-accent">Understanding Structural Drawings</h3>
                    <p class="article-desc">Learn how to read and interpret structural plans before your construction work begins.</p>
                    <div class="article-footer">
                        <div class="article-time"><i class="bi bi-clock"></i> 7 min</div>
                        <span class="article-readmore">Read More <i class="bi bi-arrow-right"></i></span>
                    </div>
                </div>
            </a>

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-blue">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-blue">TIPS</span>
                    <div class="article-ghost-icon"><i class="bi bi-droplet"></i></div>
                </div>
                <div class="article-body">
                    <h3 class="article-title">Waterproofing Dos and Don'ts</h3>
                    <p class="article-desc">Protect your home from leakage and dampness with the right waterproofing approach.</p>
                    <div class="article-footer">
                        <div class="article-time"><i class="bi bi-clock"></i> 4 min</div>
                        <span class="article-readmore">Read More <i class="bi bi-arrow-right"></i></span>
                    </div>
                </div>
            </a>

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-green">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-green">GUIDE</span>
                    <div class="article-ghost-icon"><i class="bi bi-person-check"></i></div>
                </div>
                <div class="article-body">
                    <h3 class="article-title">How to Choose the Right Contractor</h3>
                    <p class="article-desc">Important questions to ask and red flags to notice before hiring a contractor.</p>
                    <div class="article-footer">
                        <div class="article-time"><i class="bi bi-clock"></i> 6 min</div>
                        <span class="article-readmore">Read More <i class="bi bi-arrow-right"></i></span>
                    </div>
                </div>
            </a>

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-purple">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-purple">MATERIALS</span>
                    <div class="article-ghost-icon"><i class="bi bi-brush"></i></div>
                </div>
                <div class="article-body">
                    <h3 class="article-title">Interior vs Exterior Paint Guide</h3>
                    <p class="article-desc">Compare paint types, finishes, and use cases for long-lasting home results.</p>
                    <div class="article-footer">
                        <div class="article-time"><i class="bi bi-clock"></i> 5 min</div>
                        <span class="article-readmore">Read More <i class="bi bi-arrow-right"></i></span>
                    </div>
                </div>
            </a>

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-red">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-red">LEGAL</span>
                    <div class="article-ghost-icon"><i class="bi bi-file-earmark-check"></i></div>
                </div>
                <div class="article-body">
                    <h3 class="article-title">Building Permits in India Explained</h3>
                    <p class="article-desc">Everything you should know about approvals, NOCs, permissions, and municipal procedures.</p>
                    <div class="article-footer">
                        <div class="article-time"><i class="bi bi-clock"></i> 9 min</div>
                        <span class="article-readmore">Read More <i class="bi bi-arrow-right"></i></span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="from-field-section">
    <div class="container-custom">
        <div class="from-field-wrap">
            <div class="from-field-header">
                <div class="from-field-title-group">
                    <span class="from-field-line"></span>
                    <h2>From the Field</h2>
                    <span class="from-field-live">LIVE</span>
                </div>

                <a href="#" class="from-field-handle">
                    <i class="bi bi-instagram"></i>
                    @constructkaro
                </a>
            </div>

            <div class="from-field-cards">
                <a href="#" class="field-card field-card-yellow">
                    <span class="field-card-badge"><i class="bi bi-play"></i> REEL</span>
                    <div class="field-card-icon">🏗️</div>
                    <h3 class="field-card-title">Foundation Work</h3>
                </a>

                <a href="#" class="field-card field-card-slate">
                    <span class="field-card-badge"><i class="bi bi-image"></i> PHOTO</span>
                    <div class="field-card-icon">🧱</div>
                    <h3 class="field-card-title">Concrete Pouring</h3>
                </a>

                <a href="#" class="field-card field-card-blue">
                    <span class="field-card-badge"><i class="bi bi-play"></i> REEL</span>
                    <div class="field-card-icon">⚙️</div>
                    <h3 class="field-card-title">Steel Framework</h3>
                </a>

                <a href="#" class="field-card field-card-pink">
                    <span class="field-card-badge"><i class="bi bi-camera-video"></i> VIDEO</span>
                    <div class="field-card-icon">📹</div>
                    <h3 class="field-card-title">Site Visit Vlog</h3>
                </a>

                <a href="#" class="field-card field-card-orange">
                    <span class="field-card-badge"><i class="bi bi-image"></i> PHOTO</span>
                    <div class="field-card-icon">🔨</div>
                    <h3 class="field-card-title">Plastering Work</h3>
                </a>

                <a href="#" class="field-card field-card-green">
                    <span class="field-card-badge"><i class="bi bi-play"></i> REEL</span>
                    <div class="field-card-icon">✨</div>
                    <h3 class="field-card-title">Finishing Touches</h3>
                </a>
            </div>

            <div class="from-field-bottom-strip"></div>
        </div>
    </div>
</section>

<section class="construction-cta-section">
    <div class="container-custom">
        <div class="construction-cta-wrap">
            <div class="cta-corner cta-corner-top-left"></div>
            <div class="cta-corner cta-corner-top-right"></div>
            <div class="cta-corner cta-corner-bottom-left"></div>
            <div class="cta-corner cta-corner-bottom-right"></div>
            <div class="cta-dot-shape"></div>

            <div class="construction-cta-content">
                <span class="construction-cta-badge">
                    <i class="bi bi-stars"></i>
                    GET STARTED TODAY
                </span>

                <h2 class="construction-cta-title">
                    Planning to Start Your Construction Project?
                </h2>

                <p class="construction-cta-desc">
                    Join thousands of homeowners and builders who trust ConstructKaro for smarter,
                    simpler, and more confident construction planning.
                </p>

                <a href="{{ route('post') }}" class="construction-cta-btn">
                    Post Your Project on ConstructKaro
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="construction-cta-bottom-strip"></div>
        </div>
    </div>
</section>
@endsection