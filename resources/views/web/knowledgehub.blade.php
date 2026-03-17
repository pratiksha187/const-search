@extends('layouts.app')

@section('title', 'Construction Vendor Discovery | ConstructKaro')

@section('content')
<style>
    .knowledge-hub-section{
    background:#f8fafc;
    padding:40px 0 30px;
}

.knowledge-hub-inner{
    position:relative;
    background:
        linear-gradient(rgba(28,44,62,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(28,44,62,0.04) 1px, transparent 1px),
        #f8fafc;
    background-size:48px 48px, 48px 48px, auto;
    border-radius:8px;
    overflow:hidden;
    min-height:360px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:50px 20px 70px;
}

.knowledge-hub-content{
    text-align:center;
    max-width:760px;
    margin:0 auto;
    position:relative;
    z-index:2;
}

.knowledge-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#1f1f1f;
    color:var(--ck-secondary);
    font-size:11px;
    font-weight:800;
    letter-spacing:1.2px;
    padding:8px 16px;
    border-radius:999px;
    margin-bottom:22px;
    box-shadow:0 10px 24px rgba(0,0,0,0.08);
}

.knowledge-title{
    font-size:58px;
    line-height:1.08;
    font-weight:900;
    color:var(--ck-primary);
    margin-bottom:14px;
    letter-spacing:-1.4px;
}

.knowledge-highlight{
    font-size:26px;
    line-height:1.5;
    color:var(--ck-secondary);
    font-weight:700;
    margin-bottom:18px;
}

.knowledge-desc{
    max-width:660px;
    margin:0 auto 34px;
    font-size:18px;
    line-height:1.75;
    color:#6f6f6f;
    font-weight:500;
}

.knowledge-search-box{
    width:100%;
    max-width:620px;
    margin:0 auto;
    background:#fff;
    border:1px solid rgba(28,44,62,0.10);
    border-radius:16px;
    display:flex;
    align-items:center;
    padding:8px 8px 8px 14px;
    gap:10px;
    box-shadow:0 12px 28px rgba(28,44,62,0.08);
}

.knowledge-search-icon{
    width:34px;
    height:34px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#8a8a8a;
    font-size:20px;
    flex-shrink:0;
}

.knowledge-search-input{
    flex:1;
    border:none;
    outline:none;
    background:transparent;
    font-size:16px;
    font-weight:500;
    color:var(--ck-primary);
    padding:10px 4px;
}

.knowledge-search-input::placeholder{
    color:#9b9b9b;
}

.knowledge-search-btn{
    border:none;
    outline:none;
    background:#111111;
    color:var(--ck-secondary);
    font-size:15px;
    font-weight:800;
    border-radius:12px;
    padding:14px 24px;
    min-width:110px;
    transition:all 0.3s ease;
    box-shadow:0 8px 18px rgba(0,0,0,0.12);
}

.knowledge-search-btn:hover{
    background:var(--ck-primary);
    color:#fff;
    transform:translateY(-2px);
}

.knowledge-bottom-strip{
    position:absolute;
    left:0;
    bottom:0;
    width:100%;
    height:10px;
    background:repeating-linear-gradient(
        -45deg,
        #111111 0 8px,
        #111111 8px 12px,
        var(--ck-secondary) 12px 20px,
        var(--ck-secondary) 20px 24px
    );
}

.kh-corner{
    position:absolute;
    width:28px;
    height:28px;
    pointer-events:none;
}

.kh-corner::before,
.kh-corner::after{
    content:"";
    position:absolute;
    background:rgba(242,92,5,0.45);
}

.kh-corner-top-left{
    top:12px;
    left:12px;
}

.kh-corner-top-left::before{
    top:0;
    left:0;
    width:28px;
    height:2px;
}

.kh-corner-top-left::after{
    top:0;
    left:0;
    width:2px;
    height:28px;
}

.kh-corner-top-right{
    top:12px;
    right:12px;
}

.kh-corner-top-right::before{
    top:0;
    right:0;
    width:28px;
    height:2px;
}

.kh-corner-top-right::after{
    top:0;
    right:0;
    width:2px;
    height:28px;
}

.kh-corner-bottom-left{
    bottom:18px;
    left:12px;
}

.kh-corner-bottom-left::before{
    bottom:0;
    left:0;
    width:28px;
    height:2px;
}

.kh-corner-bottom-left::after{
    bottom:0;
    left:0;
    width:2px;
    height:28px;
}

.kh-corner-bottom-right{
    bottom:18px;
    right:12px;
}

.kh-corner-bottom-right::before{
    bottom:0;
    right:0;
    width:28px;
    height:2px;
}

.kh-corner-bottom-right::after{
    bottom:0;
    right:0;
    width:2px;
    height:28px;
}

@media (max-width: 991px){
    .knowledge-hub-inner{
        min-height:330px;
        padding:44px 20px 60px;
    }

    .knowledge-title{
        font-size:42px;
    }

    .knowledge-highlight{
        font-size:22px;
    }

    .knowledge-desc{
        font-size:16px;
        max-width:580px;
    }

    .knowledge-search-box{
        max-width:560px;
    }
}

@media (max-width: 767px){
    .knowledge-hub-section{
        padding:24px 0 22px;
    }

    .knowledge-hub-inner{
        min-height:auto;
        padding:34px 14px 52px;
        background-size:34px 34px, 34px 34px, auto;
    }

    .knowledge-badge{
        font-size:10px;
        padding:7px 14px;
        margin-bottom:18px;
    }

    .knowledge-title{
        font-size:30px;
        line-height:1.15;
        margin-bottom:12px;
    }

    .knowledge-highlight{
        font-size:17px;
        line-height:1.5;
        margin-bottom:14px;
    }

    .knowledge-desc{
        font-size:14px;
        line-height:1.7;
        margin-bottom:24px;
    }

    .knowledge-search-box{
        flex-wrap:wrap;
        padding:10px;
        gap:8px;
        border-radius:14px;
    }

    .knowledge-search-icon{
        width:28px;
        height:28px;
        font-size:18px;
    }

    .knowledge-search-input{
        min-width:0;
        width:calc(100% - 38px);
        font-size:14px;
        padding:8px 0;
    }

    .knowledge-search-btn{
        width:100%;
        min-width:100%;
        padding:12px 18px;
        font-size:14px;
    }

    .knowledge-bottom-strip{
        height:8px;
    }
}

@media (max-width: 480px){
    .knowledge-title{
        font-size:26px;
    }

    .knowledge-highlight{
        font-size:15px;
    }

    .knowledge-desc{
        font-size:13px;
    }

    .kh-corner{
        width:20px;
        height:20px;
    }

    .kh-corner-top-left::before,
    .kh-corner-top-right::before,
    .kh-corner-bottom-left::before,
    .kh-corner-bottom-right::before{
        width:20px;
    }

    .kh-corner-top-left::after,
    .kh-corner-top-right::after,
    .kh-corner-bottom-left::after,
    .kh-corner-bottom-right::after{
        height:20px;
    }
}


.explore-topics-section{
    background:#efefef;
    padding:38px 0 48px;
    position:relative;
}

.explore-topics-wrap{
    position:relative;
}

.explore-topics-heading{
    display:flex;
    align-items:center;
    gap:12px;
    margin-bottom:28px;
}

.explore-line{
    width:4px;
    height:28px;
    background:var(--ck-secondary);
    border-radius:10px;
    flex-shrink:0;
}

.explore-topics-heading h2{
    margin:0;
    font-size:24px;
    line-height:1.2;
    font-weight:800;
    color:var(--ck-primary);
}

.explore-topics-grid{
    display:grid;
    grid-template-columns:repeat(5, 1fr);
    gap:14px;
}

.topic-card{
    background:#f7f7f7;
    border:1px solid #dddddd;
    border-radius:18px;
    padding:22px 20px;
    text-decoration:none;
    min-height:230px;
    transition:all 0.3s ease;
    box-shadow:0 4px 14px rgba(28,44,62,0.03);
}

.topic-card:hover{
    transform:translateY(-4px);
    border-color:#cfd8e3;
    box-shadow:0 14px 28px rgba(28,44,62,0.08);
}

.topic-icon-box{
    width:44px;
    height:44px;
    border-radius:12px;
    background:#f0efec;
    display:flex;
    align-items:center;
    justify-content:center;
    margin-bottom:18px;
    color:#3a3a3a;
    font-size:21px;
}

.topic-title{
    font-size:16px;
    line-height:1.45;
    font-weight:800;
    color:#2d2d2d;
    margin:0 0 10px;
}

.topic-desc{
    font-size:13px;
    line-height:1.9;
    color:#6d6d6d;
    margin:0;
    font-weight:500;
}

@media (max-width: 1199px){
    .explore-topics-grid{
        grid-template-columns:repeat(3, 1fr);
    }
}

@media (max-width: 767px){
    .explore-topics-section{
        padding:28px 0 34px;
    }

    .explore-topics-heading{
        margin-bottom:20px;
    }

    .explore-line{
        height:24px;
    }

    .explore-topics-heading h2{
        font-size:21px;
    }

    .explore-topics-grid{
        grid-template-columns:repeat(2, 1fr);
        gap:12px;
    }

    .topic-card{
        min-height:210px;
        padding:18px 16px;
        border-radius:16px;
    }

    .topic-icon-box{
        width:40px;
        height:40px;
        font-size:18px;
        margin-bottom:14px;
    }

    .topic-title{
        font-size:15px;
    }

    .topic-desc{
        font-size:12px;
        line-height:1.75;
    }
}

@media (max-width: 520px){
    .explore-topics-grid{
        grid-template-columns:1fr;
    }

    .topic-card{
        min-height:auto;
    }
}

.featured-insights-section{
    background:#f8fafc;
    padding:36px 0 54px;
}

.featured-insights-wrap{
    position:relative;
}

.featured-insights-head{
    margin-bottom:26px;
}

.featured-title-wrap{
    display:flex;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}

.featured-line{
    width:4px;
    height:30px;
    background:var(--ck-secondary);
    border-radius:10px;
    flex-shrink:0;
}

.featured-title-wrap h2{
    margin:0;
    font-size:24px;
    line-height:1.2;
    font-weight:800;
    color:var(--ck-primary);
}

.featured-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:#f4c21b;
    color:#1f1f1f;
    font-size:10px;
    font-weight:800;
    letter-spacing:1px;
    padding:5px 10px;
    border-radius:6px;
    line-height:1;
}

.featured-insights-grid{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:20px;
}

.insight-card{
    background:#ffffff;
    border:1px solid #e4e7eb;
    border-radius:18px;
    overflow:hidden;
    text-decoration:none;
    box-shadow:0 8px 24px rgba(28,44,62,0.05);
    transition:all 0.3s ease;
}

.insight-card:hover{
    transform:translateY(-5px);
    box-shadow:0 18px 36px rgba(28,44,62,0.10);
}

.insight-thumb{
    position:relative;
    height:155px;
    overflow:hidden;
    display:flex;
    align-items:center;
    justify-content:center;
}

.insight-thumb-dark{
    background:#1c2c3e;
}

.insight-thumb-yellow{
    background:#e6aa00;
}

.insight-grid-overlay{
    position:absolute;
    inset:0;
    background-image:
        linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
    background-size:22px 22px;
    opacity:0.45;
}

.insight-ghost-icon{
    position:relative;
    z-index:2;
    font-size:72px;
    line-height:1;
    color:rgba(244,194,27,0.18);
}

.insight-thumb-yellow .insight-ghost-icon{
    color:rgba(28,44,62,0.15);
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
    color:#1f1f1f;
    font-size:10px;
    font-weight:800;
    letter-spacing:1px;
    padding:6px 10px;
    border-radius:6px;
    line-height:1;
}

.insight-tag-dark{
    background:#111111;
    color:#f4c21b;
}

.insight-body{
    padding:18px 18px 16px;
}

.insight-title{
    font-size:16px;
    line-height:1.45;
    font-weight:800;
    color:#222;
    margin:0 0 10px;
}

.insight-title-highlight{
    color:#e0a10b;
}

.insight-desc{
    font-size:13px;
    line-height:1.8;
    color:#6b7280;
    margin:0 0 14px;
    font-weight:500;
}

.insight-meta{
    display:flex;
    align-items:center;
    gap:10px;
    flex-wrap:wrap;
    font-size:12px;
    color:#8b8f97;
    font-weight:600;
}

.insight-meta i{
    margin-right:4px;
}

@media (max-width: 991px){
    .featured-insights-grid{
        grid-template-columns:1fr;
    }

    .insight-thumb{
        height:170px;
    }
}

@media (max-width: 767px){
    .featured-insights-section{
        padding:28px 0 40px;
    }

    .featured-insights-head{
        margin-bottom:20px;
    }

    .featured-line{
        height:24px;
    }

    .featured-title-wrap h2{
        font-size:21px;
    }

    .featured-badge{
        font-size:9px;
        padding:5px 8px;
    }

    .featured-insights-grid{
        gap:16px;
    }

    .insight-thumb{
        height:145px;
    }

    .insight-ghost-icon{
        font-size:60px;
    }

    .insight-body{
        padding:16px;
    }

    .insight-title{
        font-size:15px;
    }

    .insight-desc{
        font-size:12px;
        line-height:1.75;
    }

    .insight-meta{
        font-size:11px;
        gap:8px;
    }
}

.latest-articles-section{
    background:#f8fafc;
    padding:38px 0 54px;
}

.latest-articles-head{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    margin-bottom:26px;
    flex-wrap:wrap;
}

.latest-title-wrap{
    display:flex;
    align-items:center;
    gap:14px;
}

.latest-line{
    width:4px;
    height:38px;
    border-radius:10px;
    background:var(--ck-secondary);
    flex-shrink:0;
}

.latest-title-wrap h2{
    margin:0;
    font-size:30px;
    line-height:1.2;
    font-weight:900;
    color:var(--ck-primary);
}

.latest-view-all{
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    color:var(--ck-primary);
    font-size:16px;
    font-weight:700;
    transition:all 0.3s ease;
}

.latest-view-all i{
    font-size:18px;
    transition:transform 0.3s ease;
}

.latest-view-all:hover{
    color:var(--ck-secondary);
}

.latest-view-all:hover i{
    transform:translateX(4px);
}

.latest-articles-grid{
    display:grid;
    grid-template-columns:repeat(3, 1fr);
    gap:28px;
}

.article-card{
    background:#ffffff;
    border:1px solid #dddddd;
    border-radius:22px;
    overflow:hidden;
    text-decoration:none;
    box-shadow:0 6px 22px rgba(28,44,62,0.04);
    transition:all 0.3s ease;
}

.article-card:hover{
    transform:translateY(-5px);
    box-shadow:0 18px 38px rgba(28,44,62,0.10);
}

.article-thumb{
    position:relative;
    height:178px;
    display:flex;
    align-items:center;
    justify-content:center;
    overflow:hidden;
}

.article-thumb-dark{
    background:linear-gradient(135deg, #4b5768, #1f2f46);
}

.article-thumb-orange{
    background:linear-gradient(135deg, #e28700, #bf6a00);
}

.article-thumb-blue{
    background:linear-gradient(135deg, #0d72b1, #1a4f9c);
}

.article-thumb-green{
    background:linear-gradient(135deg, #0a8c5b, #096744);
}

.article-thumb-purple{
    background:linear-gradient(135deg, #8c2be2, #40329e);
}

.article-thumb-red{
    background:linear-gradient(135deg, #de1e1e, #b01036);
}

.article-grid-overlay{
    position:absolute;
    inset:0;
    background-image:
        linear-gradient(rgba(255,255,255,0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.05) 1px, transparent 1px);
    background-size:22px 22px;
    opacity:0.35;
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
    padding:7px 10px;
    border-radius:6px;
    line-height:1;
}

.article-tag-light{
    background:rgba(255,255,255,0.18);
    color:#f4f4f4;
    backdrop-filter:blur(2px);
}

.article-tag-soft{
    background:rgba(255,255,255,0.22);
    color:#fff7e8;
}

.article-tag-blue{
    background:rgba(255,255,255,0.16);
    color:#dcecff;
}

.article-tag-green{
    background:rgba(255,255,255,0.16);
    color:#e0fff0;
}

.article-tag-purple{
    background:rgba(255,255,255,0.16);
    color:#f0e1ff;
}

.article-tag-red{
    background:rgba(255,255,255,0.16);
    color:#ffe6ea;
}

.article-ghost-icon{
    position:relative;
    z-index:2;
    font-size:78px;
    line-height:1;
    color:rgba(255,255,255,0.13);
}

.article-body{
    padding:22px 24px 20px;
}

.article-title{
    margin:0 0 14px;
    font-size:18px;
    line-height:1.45;
    font-weight:800;
    color:#121212;
}

.article-title-accent{
    color:#e0a200;
}

.article-desc{
    margin:0 0 20px;
    font-size:15px;
    line-height:1.8;
    color:#5f6672;
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
    font-size:14px;
    color:#666;
    font-weight:600;
    display:flex;
    align-items:center;
    gap:7px;
}

.article-time i{
    font-size:15px;
}

.article-readmore{
    display:inline-flex;
    align-items:center;
    gap:8px;
    color:#e0a200;
    font-size:15px;
    font-weight:800;
    transition:all 0.3s ease;
}

.article-readmore i{
    transition:transform 0.3s ease;
}

.article-card:hover .article-readmore i{
    transform:translateX(4px);
}

@media (max-width: 1199px){
    .latest-articles-grid{
        gap:20px;
    }

    .article-body{
        padding:20px 20px 18px;
    }
}

@media (max-width: 991px){
    .latest-articles-grid{
        grid-template-columns:repeat(2, 1fr);
    }
}

@media (max-width: 767px){
    .latest-articles-section{
        padding:28px 0 40px;
    }

    .latest-articles-head{
        margin-bottom:18px;
    }

    .latest-title-wrap h2{
        font-size:24px;
    }

    .latest-line{
        height:32px;
    }

    .latest-view-all{
        font-size:14px;
    }

    .latest-articles-grid{
        grid-template-columns:1fr;
        gap:16px;
    }

    .article-thumb{
        height:158px;
    }

    .article-ghost-icon{
        font-size:66px;
    }

    .article-body{
        padding:18px 18px 16px;
    }

    .article-title{
        font-size:16px;
        margin-bottom:10px;
    }

    .article-desc{
        font-size:14px;
        line-height:1.75;
        margin-bottom:16px;
    }

    .article-time,
    .article-readmore{
        font-size:13px;
    }
}
.from-field-section{
    background:#0f1115;
    padding:34px 0 0;
    position:relative;
    overflow:hidden;
}

.from-field-wrap{
    position:relative;
    padding:44px 0 70px;
    background:
        linear-gradient(rgba(242, 193, 21, 0.05) 1px, transparent 1px),
        linear-gradient(90deg, rgba(242, 193, 21, 0.05) 1px, transparent 1px),
        #14161b;
    background-size:42px 42px, 42px 42px, auto;
    border-top:1px solid rgba(255,255,255,0.05);
    border-bottom:1px solid rgba(255,255,255,0.05);
}

.from-field-header{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    margin-bottom:34px;
    flex-wrap:wrap;
    padding:0 10px;
}

.from-field-title-group{
    display:flex;
    align-items:center;
    gap:14px;
    flex-wrap:wrap;
}

.from-field-line{
    width:5px;
    height:44px;
    border-radius:10px;
    background:#f4c21b;
    flex-shrink:0;
}

.from-field-title-group h2{
    margin:0;
    font-size:38px;
    line-height:1.1;
    font-weight:900;
    color:#ffffff;
    letter-spacing:-0.8px;
}

.from-field-live{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:8px 12px;
    border-radius:8px;
    background:rgba(244,194,27,0.14);
    color:#f4c21b;
    font-size:12px;
    font-weight:800;
    letter-spacing:1.2px;
    line-height:1;
}

.from-field-handle{
    display:inline-flex;
    align-items:center;
    gap:10px;
    text-decoration:none;
    color:#f4c21b;
    font-size:16px;
    font-weight:700;
    transition:all 0.3s ease;
}

.from-field-handle i{
    font-size:20px;
}

.from-field-handle:hover{
    color:#ffffff;
}

.from-field-cards{
    display:grid;
    grid-template-columns:repeat(6, minmax(220px, 1fr));
    gap:18px;
    overflow-x:auto;
    padding:0 10px 8px;
    scrollbar-width:none;
}

.from-field-cards::-webkit-scrollbar{
    display:none;
}

.field-card{
    position:relative;
    min-height:338px;
    border-radius:24px;
    padding:18px 16px 18px;
    text-decoration:none;
    overflow:hidden;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    box-shadow:
        inset 0 1px 0 rgba(255,255,255,0.12),
        0 16px 36px rgba(0,0,0,0.30);
    transition:transform 0.3s ease, box-shadow 0.3s ease;
}

.field-card::before{
    content:"";
    position:absolute;
    inset:0;
    background:
        linear-gradient(rgba(255,255,255,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(255,255,255,0.04) 1px, transparent 1px);
    background-size:18px 18px;
    opacity:0.25;
    pointer-events:none;
}

.field-card::after{
    content:"";
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:90px;
    background:linear-gradient(to top, rgba(0,0,0,0.55), rgba(0,0,0,0));
    pointer-events:none;
}

.field-card:hover{
    transform:translateY(-6px);
    box-shadow:
        inset 0 1px 0 rgba(255,255,255,0.12),
        0 22px 46px rgba(0,0,0,0.36);
}

.field-card-yellow{
    background:linear-gradient(180deg, #f3a900 0%, #d89000 62%, #996400 100%);
}

.field-card-slate{
    background:linear-gradient(180deg, #59677d 0%, #3a4659 60%, #111826 100%);
}

.field-card-blue{
    background:linear-gradient(180deg, #2f68f3 0%, #2049b9 62%, #10246d 100%);
}

.field-card-pink{
    background:linear-gradient(180deg, #f33d57 0%, #db2252 60%, #7a0038 100%);
}

.field-card-orange{
    background:linear-gradient(180deg, #ff7d08 0%, #ec7100 60%, #8c4600 100%);
}

.field-card-green{
    background:linear-gradient(180deg, #1db97b 0%, #0ea96d 60%, #056f47 100%);
}

.field-card-badge{
    position:relative;
    z-index:2;
    align-self:flex-end;
    display:inline-flex;
    align-items:center;
    gap:6px;
    background:rgba(0,0,0,0.30);
    color:#f2f2f2;
    padding:8px 12px;
    border-radius:8px;
    font-size:11px;
    font-weight:800;
    letter-spacing:1px;
    line-height:1;
    box-shadow:0 6px 12px rgba(0,0,0,0.12);
}

.field-card-icon{
    position:relative;
    z-index:2;
    flex:1;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:64px;
    line-height:1;
    filter:drop-shadow(0 6px 12px rgba(0,0,0,0.18));
}

.field-card-title{
    position:relative;
    z-index:2;
    margin:0;
    font-size:20px;
    line-height:1.25;
    font-weight:900;
    color:#ffffff;
    letter-spacing:-0.3px;
}

.from-field-bottom-strip{
    position:absolute;
    left:0;
    right:0;
    bottom:0;
    height:9px;
    background:repeating-linear-gradient(
        -45deg,
        #f4c21b 0 10px,
        #f4c21b 10px 16px,
        #151515 16px 26px,
        #151515 26px 32px
    );
}

@media (max-width: 1399px){
    .from-field-cards{
        grid-template-columns:repeat(6, 240px);
    }
}

@media (max-width: 991px){
    .from-field-wrap{
        padding:34px 0 62px;
        background-size:32px 32px, 32px 32px, auto;
    }

    .from-field-title-group h2{
        font-size:30px;
    }

    .from-field-cards{
        grid-template-columns:repeat(6, 220px);
        gap:16px;
    }

    .field-card{
        min-height:310px;
        border-radius:20px;
    }

    .field-card-icon{
        font-size:54px;
    }

    .field-card-title{
        font-size:18px;
    }
}

@media (max-width: 767px){
    .from-field-section{
        padding-top:22px;
    }

    .from-field-wrap{
        padding:28px 0 52px;
    }

    .from-field-header{
        margin-bottom:22px;
        padding:0 4px;
    }

    .from-field-line{
        height:34px;
    }

    .from-field-title-group h2{
        font-size:24px;
    }

    .from-field-live{
        font-size:10px;
        padding:7px 10px;
    }

    .from-field-handle{
        font-size:14px;
    }

    .from-field-handle i{
        font-size:18px;
    }

    .from-field-cards{
        grid-template-columns:repeat(6, 190px);
        gap:14px;
        padding:0 4px 8px;
    }

    .field-card{
        min-height:280px;
        padding:14px 14px 16px;
        border-radius:18px;
    }

    .field-card-badge{
        font-size:10px;
        padding:7px 10px;
    }

    .field-card-icon{
        font-size:46px;
    }

    .field-card-title{
        font-size:16px;
    }
}

@media (max-width: 480px){
    .from-field-title-group{
        gap:10px;
    }

    .from-field-title-group h2{
        font-size:22px;
    }

    .from-field-cards{
        grid-template-columns:repeat(6, 175px);
    }

    .field-card{
        min-height:255px;
    }

    .field-card-icon{
        font-size:42px;
    }

    .field-card-title{
        font-size:15px;
    }
}

.construction-cta-section{
    background:#f8fafc;
    padding:42px 0 0;
}

.construction-cta-wrap{
    position:relative;
    min-height:560px;
    padding:70px 24px 90px;
    background:
        linear-gradient(rgba(28,44,62,0.04) 1px, transparent 1px),
        linear-gradient(90deg, rgba(28,44,62,0.04) 1px, transparent 1px),
        #f8fafc;
    background-size:48px 48px, 48px 48px, auto;
    overflow:hidden;
}

.construction-cta-content{
    position:relative;
    z-index:2;
    max-width:980px;
    margin:0 auto;
    text-align:center;
}

.construction-cta-badge{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    background:#efe7d4;
    color:var(--ck-primary);
    font-size:14px;
    font-weight:700;
    letter-spacing:2px;
    padding:12px 20px;
    border-radius:999px;
    margin-bottom:28px;
}

.construction-cta-badge i{
    color:var(--ck-secondary);
    font-size:16px;
}

.construction-cta-title{
    margin:0 0 22px;
    font-size:58px;
    line-height:1.14;
    font-weight:900;
    color:var(--ck-primary);
    letter-spacing:-1.4px;
}

.construction-cta-desc{
    max-width:920px;
    margin:0 auto 54px;
    font-size:24px;
    line-height:1.75;
    color:#5d6673;
    font-weight:500;
}

.construction-cta-btn{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:18px;
    min-width:640px;
    max-width:100%;
    min-height:84px;
    padding:18px 34px;
    background:#161616;
    color:#f4c21b;
    text-decoration:none;
    font-size:24px;
    font-weight:800;
    border-radius:20px;
    box-shadow:0 16px 34px rgba(0,0,0,0.14);
    transition:all 0.3s ease;
}

.construction-cta-btn i{
    font-size:28px;
    transition:transform 0.3s ease;
}

.construction-cta-btn:hover{
    background:var(--ck-primary);
    color:#ffffff;
    transform:translateY(-3px);
}

.construction-cta-btn:hover i{
    transform:translateX(5px);
}

.cta-dot-shape{
    position:absolute;
    right:28%;
    top:49%;
    width:42px;
    height:42px;
    border-radius:50%;
    background:#2bbac8;
    z-index:1;
}

.cta-corner{
    position:absolute;
    width:56px;
    height:56px;
    pointer-events:none;
    z-index:1;
}

.cta-corner::before,
.cta-corner::after{
    content:"";
    position:absolute;
    background:rgba(244,194,27,0.38);
}

.cta-corner-top-left{
    top:54px;
    left:19%;
}

.cta-corner-top-left::before{
    top:0;
    left:0;
    width:56px;
    height:3px;
}

.cta-corner-top-left::after{
    top:0;
    left:0;
    width:3px;
    height:56px;
}

.cta-corner-top-right{
    top:54px;
    right:19%;
}

.cta-corner-top-right::before{
    top:0;
    right:0;
    width:56px;
    height:3px;
}

.cta-corner-top-right::after{
    top:0;
    right:0;
    width:3px;
    height:56px;
}

.cta-corner-bottom-left{
    bottom:62px;
    left:19%;
}

.cta-corner-bottom-left::before{
    bottom:0;
    left:0;
    width:56px;
    height:3px;
}

.cta-corner-bottom-left::after{
    bottom:0;
    left:0;
    width:3px;
    height:56px;
}

.cta-corner-bottom-right{
    bottom:62px;
    right:19%;
}

.cta-corner-bottom-right::before{
    bottom:0;
    right:0;
    width:56px;
    height:3px;
}

.cta-corner-bottom-right::after{
    bottom:0;
    right:0;
    width:3px;
    height:56px;
}

.construction-cta-bottom-strip{
    position:absolute;
    left:0;
    bottom:0;
    width:100%;
    height:10px;
    background:repeating-linear-gradient(
        -45deg,
        #111111 0 10px,
        #111111 10px 16px,
        #f4c21b 16px 26px,
        #f4c21b 26px 32px
    );
}

@media (max-width: 1199px){
    .construction-cta-wrap{
        min-height:500px;
        padding:60px 20px 78px;
    }

    .construction-cta-title{
        font-size:48px;
    }

    .construction-cta-desc{
        font-size:20px;
        max-width:760px;
    }

    .construction-cta-btn{
        min-width:540px;
        font-size:21px;
        min-height:76px;
    }
}

@media (max-width: 991px){
    .construction-cta-wrap{
        background-size:38px 38px, 38px 38px, auto;
    }

    .construction-cta-title{
        font-size:40px;
    }

    .construction-cta-desc{
        font-size:18px;
        line-height:1.7;
        margin-bottom:42px;
    }

    .construction-cta-btn{
        min-width:100%;
        width:100%;
        font-size:20px;
        min-height:72px;
        border-radius:18px;
    }

    .cta-dot-shape{
        right:16%;
        top:53%;
        width:34px;
        height:34px;
    }

    .cta-corner-top-left,
    .cta-corner-bottom-left{
        left:8%;
    }

    .cta-corner-top-right,
    .cta-corner-bottom-right{
        right:8%;
    }
}

@media (max-width: 767px){
    .construction-cta-section{
        padding-top:24px;
    }

    .construction-cta-wrap{
        min-height:auto;
        padding:42px 16px 62px;
        background-size:28px 28px, 28px 28px, auto;
    }

    .construction-cta-badge{
        font-size:11px;
        letter-spacing:1.4px;
        padding:10px 16px;
        margin-bottom:22px;
    }

    .construction-cta-title{
        font-size:30px;
        line-height:1.2;
        margin-bottom:16px;
    }

    .construction-cta-desc{
        font-size:15px;
        line-height:1.8;
        margin-bottom:30px;
    }

    .construction-cta-btn{
        font-size:17px;
        min-height:62px;
        padding:16px 20px;
        gap:12px;
        border-radius:16px;
    }

    .construction-cta-btn i{
        font-size:22px;
    }

    .cta-dot-shape{
        width:24px;
        height:24px;
        right:10%;
        top:48%;
    }

    .cta-corner{
        width:34px;
        height:34px;
    }

    .cta-corner-top-left,
    .cta-corner-top-right{
        top:28px;
    }

    .cta-corner-bottom-left,
    .cta-corner-bottom-right{
        bottom:36px;
    }

    .cta-corner-top-left::before,
    .cta-corner-top-right::before,
    .cta-corner-bottom-left::before,
    .cta-corner-bottom-right::before{
        width:34px;
        height:2px;
    }

    .cta-corner-top-left::after,
    .cta-corner-top-right::after,
    .cta-corner-bottom-left::after,
    .cta-corner-bottom-right::after{
        width:2px;
        height:34px;
    }
}

@media (max-width: 480px){
    .construction-cta-title{
        font-size:26px;
    }

    .construction-cta-desc{
        font-size:14px;
    }

    .construction-cta-btn{
        font-size:15px;
        min-height:58px;
    }

    .cta-dot-shape{
        display:none;
    }
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
                <span class="knowledge-badge">KNOWLEDGE HUB ●</span>

                <h1 class="knowledge-title">ConstructKaro Knowledge Hub</h1>

                <p class="knowledge-highlight">
                    Learn. Plan. Build — All in One Place.
                </p>

                <p class="knowledge-desc">
                    India's first platform where you can understand construction, explore insights, and start
                    your project with confidence.
                </p>

                <form class="knowledge-search-box" action="#" method="GET">
                    <div class="knowledge-search-icon">
                        <i class="bi bi-search"></i>
                    </div>

                    <input
                        type="text"
                        class="knowledge-search-input"
                        placeholder="Search articles, topics, guides..."
                        name="search"
                    >

                    <button type="submit" class="knowledge-search-btn">
                        Search
                    </button>
                </form>
            </div>

            <div class="knowledge-bottom-strip"></div>
        </div>
    </div>
</section>
<section class="explore-topics-section">
    <div class="container-custom">
        <div class="explore-topics-wrap">

            <div class="explore-topics-heading">
                <span class="explore-line"></span>
                <h2>Explore Topics</h2>
            </div>

            <div class="explore-topics-grid">

                <a href="#" class="topic-card">
                    <div class="topic-icon-box">
                        <i class="bi bi-bricks"></i>
                    </div>
                    <h3 class="topic-title">Construction Education</h3>
                    <p class="topic-desc">
                        Understand construction basics, costing, materials, and processes.
                    </p>
                </a>

                <a href="#" class="topic-card">
                    <div class="topic-icon-box">
                        <i class="bi bi-compass"></i>
                    </div>
                    <h3 class="topic-title">How ConstructKaro Works</h3>
                    <p class="topic-desc">
                        Step-by-step guide for customers and vendors.
                    </p>
                </a>

                <a href="#" class="topic-card">
                    <div class="topic-icon-box">
                        <i class="bi bi-send"></i>
                    </div>
                    <h3 class="topic-title">Blogs &amp; Insights</h3>
                    <p class="topic-desc">
                        Latest trends, updates, and expert opinions in construction.
                    </p>
                </a>

                <a href="#" class="topic-card">
                    <div class="topic-icon-box">
                        <i class="bi bi-tv"></i>
                    </div>
                    <h3 class="topic-title">Social Feed</h3>
                    <p class="topic-desc">
                        Live updates, reels, and on-site activities.
                    </p>
                </a>

                <a href="#" class="topic-card">
                    <div class="topic-icon-box">
                        <i class="bi bi-bar-chart-line"></i>
                    </div>
                    <h3 class="topic-title">Case Studies</h3>
                    <p class="topic-desc">
                        Real project breakdowns and success stories.
                    </p>
                </a>

            </div>
        </div>
    </div>
</section>

<section class="featured-insights-section">
    <div class="container-custom">
        <div class="featured-insights-wrap">

            <div class="featured-insights-head">
                <div class="featured-title-wrap">
                    <span class="featured-line"></span>
                    <h2>Featured Insights</h2>
                    <span class="featured-badge">TRENDING</span>
                </div>
            </div>

            <div class="featured-insights-grid">

                <a href="#" class="insight-card">
                    <div class="insight-thumb insight-thumb-dark">
                        <div class="insight-grid-overlay"></div>
                        <span class="insight-tag">GUIDE</span>
                        <div class="insight-ghost-icon">
                            <i class="bi bi-calculator"></i>
                        </div>
                    </div>

                    <div class="insight-body">
                        <h3 class="insight-title">
                            How to Calculate Construction Cost per Sqft
                        </h3>

                        <p class="insight-desc">
                            A detailed breakdown of costs including materials, labour, and overheads for residential construction in India.
                        </p>

                        <div class="insight-meta">
                            <span><i class="bi bi-clock"></i> 8 min read</span>
                            <span>·</span>
                            <span>Dec 2024</span>
                        </div>
                    </div>
                </a>

                <a href="#" class="insight-card">
                    <div class="insight-thumb insight-thumb-yellow">
                        <div class="insight-grid-overlay"></div>
                        <span class="insight-tag insight-tag-dark">TIPS</span>
                        <div class="insight-ghost-icon">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                    </div>

                    <div class="insight-body">
                        <h3 class="insight-title">
                            5 Mistakes to Avoid While Building a Bungalow
                        </h3>

                        <p class="insight-desc">
                            Common pitfalls first-time builders face and how to plan smarter from day one.
                        </p>

                        <div class="insight-meta">
                            <span><i class="bi bi-clock"></i> 6 min read</span>
                            <span>·</span>
                            <span>Nov 2024</span>
                        </div>
                    </div>
                </a>

                <a href="#" class="insight-card">
                    <div class="insight-thumb insight-thumb-dark">
                        <div class="insight-grid-overlay"></div>
                        <span class="insight-tag">PROCESS</span>
                        <div class="insight-ghost-icon">
                            <i class="bi bi-layers"></i>
                        </div>
                    </div>

                    <div class="insight-body">
                        <h3 class="insight-title insight-title-highlight">
                            Step-by-Step Construction Process Explained
                        </h3>

                        <p class="insight-desc">
                            From foundation to finishing — understand every phase of building your dream home.
                        </p>

                        <div class="insight-meta">
                            <span><i class="bi bi-clock"></i> 12 min read</span>
                            <span>·</span>
                            <span>Oct 2024</span>
                        </div>
                    </div>
                </a>

            </div>
        </div>
    </div>
</section>
<section class="latest-articles-section">
    <div class="container-custom">

        <div class="latest-articles-head">
            <div class="latest-title-wrap">
                <span class="latest-line"></span>
                <h2>Latest Articles</h2>
            </div>

            <a href="#" class="latest-view-all">
                View all <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="latest-articles-grid">

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-dark">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-light">MATERIALS</span>
                    <div class="article-ghost-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                </div>

                <div class="article-body">
                    <h3 class="article-title">Choosing the Right Cement for Your Home</h3>
                    <p class="article-desc">
                        OPC vs PPC — which cement grade works best for different parts of your house?
                    </p>

                    <div class="article-footer">
                        <div class="article-time">
                            <i class="bi bi-clock"></i> 5 min
                        </div>
                        <span class="article-readmore">
                            Read More <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-orange">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-soft">EDUCATION</span>
                    <div class="article-ghost-icon">
                        <i class="bi bi-rulers"></i>
                    </div>
                </div>

                <div class="article-body">
                    <h3 class="article-title article-title-accent">Understanding Structural Drawings</h3>
                    <p class="article-desc">
                        How to read and interpret structural plans before construction begins.
                    </p>

                    <div class="article-footer">
                        <div class="article-time">
                            <i class="bi bi-clock"></i> 7 min
                        </div>
                        <span class="article-readmore">
                            Read More <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-blue">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-blue">TIPS</span>
                    <div class="article-ghost-icon">
                        <i class="bi bi-droplet"></i>
                    </div>
                </div>

                <div class="article-body">
                    <h3 class="article-title">Waterproofing Dos and Don'ts</h3>
                    <p class="article-desc">
                        Protect your building from leaks with the right waterproofing approach.
                    </p>

                    <div class="article-footer">
                        <div class="article-time">
                            <i class="bi bi-clock"></i> 4 min
                        </div>
                        <span class="article-readmore">
                            Read More <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-green">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-green">GUIDE</span>
                    <div class="article-ghost-icon">
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>

                <div class="article-body">
                    <h3 class="article-title">How to Choose the Right Contractor</h3>
                    <p class="article-desc">
                        Key questions to ask and red flags to watch before hiring a builder.
                    </p>

                    <div class="article-footer">
                        <div class="article-time">
                            <i class="bi bi-clock"></i> 6 min
                        </div>
                        <span class="article-readmore">
                            Read More <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-purple">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-purple">MATERIALS</span>
                    <div class="article-ghost-icon">
                        <i class="bi bi-brush"></i>
                    </div>
                </div>

                <div class="article-body">
                    <h3 class="article-title">Interior vs Exterior Paint Guide</h3>
                    <p class="article-desc">
                        Different paint types, finishes and when to use each for lasting results.
                    </p>

                    <div class="article-footer">
                        <div class="article-time">
                            <i class="bi bi-clock"></i> 5 min
                        </div>
                        <span class="article-readmore">
                            Read More <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </div>
            </a>

            <a href="#" class="article-card">
                <div class="article-thumb article-thumb-red">
                    <div class="article-grid-overlay"></div>
                    <span class="article-tag article-tag-red">LEGAL</span>
                    <div class="article-ghost-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>
                </div>

                <div class="article-body">
                    <h3 class="article-title">Building Permits in India Explained</h3>
                    <p class="article-desc">
                        Everything you need to know about approvals, NOCs and municipal processes.
                    </p>

                    <div class="article-footer">
                        <div class="article-time">
                            <i class="bi bi-clock"></i> 9 min
                        </div>
                        <span class="article-readmore">
                            Read More <i class="bi bi-arrow-right"></i>
                        </span>
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
                    Join thousands of homeowners and builders who trust ConstructKaro for
                    smarter construction.
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