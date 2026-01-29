@extends('layouts.app')
@section('title','About Us | ConstructKaro')

@section('content')

<style>
:root{
    --navy:#0f172a;
    --orange:#f25c05;
    --bg:#f8fafc;
    --muted:#64748b;
}

/* Base */
body{ background:var(--bg); }
.section{ padding:90px 0; }
h2{ font-weight:800; color:var(--navy); }
p{ color:var(--muted); }

/* HERO */
.about-hero{
    background: radial-gradient(circle at top,#ffffff,#eef2ff);
    padding:120px 0 90px;
}
.hero-card{
    background:#fff;
    border-radius:26px;
    padding:50px;
    box-shadow:0 40px 80px rgba(0,0,0,.08);
}
.hero-title{
    font-size:3rem;
    font-weight:900;
}
.hero-highlight{ color:var(--orange); }

/* GLASS CARDS */
.glass{
    background:rgba(255,255,255,.9);
    border-radius:22px;
    padding:34px;
    box-shadow:0 25px 60px rgba(15,23,42,.1);
}

/* CHECK LIST */
.check-list li{
    list-style:none;
    margin-bottom:12px;
    font-weight:600;
}
.check-list li::before{
    content:"✔";
    color:var(--orange);
    margin-right:10px;
}

/* STORY STRIP */
.story-strip{
    background:linear-gradient(135deg,#1c2c3e,#0f172a);
    color:#fff;
    border-radius:26px;
    padding:60px;
}

/* TEAM */
.team-card{
    background:#fff;
    border-radius:22px;
    padding:32px;
    height:100%;
    box-shadow:0 20px 50px rgba(0,0,0,.08);
}
.team-card h6{ font-weight:800; }

/* CONTENT CARDS */
.content-card{
    background:#fff;
    border-radius:18px;
    padding:22px;
    height:100%;
    font-weight:700;
    box-shadow:0 16px 40px rgba(0,0,0,.08);
    transition:.3s;
}
.content-card:hover{
    transform:translateY(-6px);
    box-shadow:0 30px 70px rgba(0,0,0,.15);
}

/* FOOTER */
.footer{
    background:linear-gradient(135deg,#020617,#0f172a);
    color:#cbd5e1;
    padding:80px 0 30px;
}
.footer a{ color:#cbd5e1; text-decoration:none; display:block; margin-bottom:8px; }
.footer a:hover{ color:var(--orange); }
.footer-bottom{
    border-top:1px solid rgba(255,255,255,.1);
    margin-top:40px;
    padding-top:20px;
    text-align:center;
    font-size:.9rem;
}
</style>

<!-- HERO -->
<section class="about-hero">
    <div class="container">
        <div class="hero-card text-center">
            <h1 class="hero-title">
                Building <span class="hero-highlight">Trust</span> in Construction
            </h1>
            <p class="mt-3">
                ConstructKaro is India’s construction-focused digital platform helping customers,
                contractors, vendors, and suppliers connect transparently — without brokers,
                confusion, or chaos.
            </p>
        </div>
    </div>
</section>

<!-- WHO WE ARE -->
<section class="section">
    <div class="container">
        <div class="row g-5 align-items-center">

            <div class="col-lg-6">
                <h2>Who Are We?</h2>
                <p>
                    ConstructKaro is a **neutral discovery and execution platform**
                    for the Indian construction industry.
                </p>
                <p>
                    We help customers find verified contractors, architects,
                    interior designers, suppliers, and service providers —
                    without relying on brokers or informal references.
                </p>
            </div>

            <div class="col-lg-6">
                <div class="glass">
                    <ul class="check-list p-0 m-0">
                        <li>Location-based verified vendors</li>
                        <li>Transparent & direct communication</li>
                        <li>Genuine project requirements</li>
                        <li>Designed for Indian construction workflows</li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- WHY STARTED -->
<section class="section">
    <div class="container">
        <div class="story-strip">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <h2 class="text-white">Why ConstructKaro Started?</h2>
                    <p class="text-light">
                        Construction in India often depends on brokers, word-of-mouth,
                        and unstructured communication — leading to delays, cost overruns,
                        fake leads, and trust issues.
                    </p>
                    <p class="text-light">
                        ConstructKaro was built to bring **verification, clarity,
                        and structure** — without becoming a commission-driven marketplace.
                    </p>
                </div>

                <div class="col-lg-6">
                    <div class="glass">
                        <h6 class="fw-bold mb-3">Problems We Solved</h6>
                        <p>• Fake leads & random enquiries</p>
                        <p>• Dependency on brokers</p>
                        <p>• No execution clarity</p>
                        <p>• Unverified vendors & suppliers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TEAM -->
<section class="section text-center">
    <div class="container">
        <h2>Our Team</h2>
        <p class="mb-5">
            Professionals who understand construction from the ground level
        </p>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="team-card">
                    <h6>Founders & Core Team</h6>
                    <p>
                        Hands-on experience in construction execution,
                        vendor management, and project coordination.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="team-card">
                    <h6>Technology Team</h6>
                    <p>
                        Engineers building practical systems for
                        real-world construction challenges.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="team-card">
                    <h6>Operations & Support</h6>
                    <p>
                        Ensuring vendor verification, lead quality,
                        and smooth coordination.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ARTICLES -->
<section class="section">
    <div class="container text-center">
        <h2>Articles & Insights</h2>
        <p class="mb-5">Practical construction knowledge from real experience</p>

        <div class="row g-4">
            <div class="col-md-4"><div class="content-card">How to Choose the Right Contractor</div></div>
            <div class="col-md-4"><div class="content-card">Bungalow Construction Cost Breakdown</div></div>
            <div class="col-md-4"><div class="content-card">Common Vendor Selection Mistakes</div></div>
        </div>
    </div>
</section>

<!-- TUTORIALS -->
<section class="section">
    <div class="container text-center">
        <h2>Tutorials</h2>
        <p class="mb-5">Step-by-step guidance for customers & vendors</p>

        <div class="row g-4">
            <div class="col-md-4"><div class="content-card">How to Post a Project</div></div>
            <div class="col-md-4"><div class="content-card">Vendor Registration Guide</div></div>
            <div class="col-md-4"><div class="content-card">How Vendor Matching Works</div></div>
        </div>
    </div>
</section>


@endsection
