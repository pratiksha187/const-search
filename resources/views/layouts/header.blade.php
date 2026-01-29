<!-- ========================= RESPONSIVE GLASS + STICKY HEADER ========================= -->

<style>
/* ===== Base Glass Header (UNCHANGED) ===== */
.glass-header {
    background: rgba(255, 255, 255, 0.22);
    border-radius: 60px;
    padding: 10px 30px; /* ❌ NOT changed */
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    border: 1px solid rgba(255, 255, 255, 0.4);
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.12);
    transition: all 0.35s ease-in-out;
}

/* ===== Sticky Behaviour (UNCHANGED) ===== */
.sticky-header {
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    width: 92%;
    z-index: 999;
    height: 10%;
}

/* ===== After Scroll (UNCHANGED) ===== */
.sticky-active {
    top: 0 !important;
    width: 100% !important;
    border-radius: 0 !important;
    background: rgba(255, 255, 255, 0.78) !important;
    border: 0 !important;
    backdrop-filter: blur(20px);
    box-shadow: 0 4px 25px rgba(0,0,0,0.15);
}

/* ===== LOGO SIZE ONLY (CHANGED) ===== */
.logo-img {
    height: 80px;          /* ✅ ONLY CHANGE */
    width: auto;
    object-fit: contain;
    display: block;
}

/* ===== Nav links (UNCHANGED) ===== */
.nav-link {
    color: #1a2233 !important;
    font-weight: 500;
    margin-right: 18px;
    transition: 0.25s;
}
.nav-link:hover {
    color: #f25c05 !important;
}

/* ===== Buttons (UNCHANGED) ===== */
.btn-cta {
    padding: 10px 26px;
    border-radius: 40px;
    border: none;
    background: linear-gradient(135deg, #ffa34d, #f25c05);
    color: white;
    font-weight: 600;
    box-shadow: 0px 6px 12px rgba(242, 92, 5, 0.35);
}
.btn-cta:hover { opacity: 0.9; }

.btn-login {
    padding: 8px 22px;
    border-radius: 40px;
    border: 1px solid #1c2c3e;
    background: transparent;
    color: #1c2c3e;
    font-weight: 600;
    transition: 0.3s;
}
.btn-login:hover {
    background: #1c2c3e;
    color: #fff;
}

/* ===== Mobile (LOGO ONLY) ===== */
@media (max-width: 767px) {
    .logo-img {
        height: 60px; /* mobile logo size */
    }

    .nav-link {
        margin: 10px 0;
        font-size: 1rem;
    }

    .btn-cta, .btn-login {
        width: 100%;
        margin-top: 10px;
    }
}
</style>

<!-- ========================= NAVBAR HTML ========================= -->
<nav id="mainHeader" class="navbar navbar-expand-lg glass-header sticky-header">

    <!-- LOGO -->
    <a class="navbar-brand d-flex align-items-center" href="{{ route('homepage') }}">
        <img src="{{ asset('images/logobg.png') }}" class="logo-img me-2" alt="ConstructKaro Logo">
    </a>

    <!-- MOBILE TOGGLER -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- NAVIGATION MENU -->
    <div class="collapse navbar-collapse" id="mainNav">

        <!-- Right Menu -->
        <ul class="navbar-nav ms-auto align-items-lg-center">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('homepage') }}">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('aboutus') }}">About Us</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{route('login_register')}}">Blog</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('login_register')}}">Tutorials</a>
            </li>
        </ul>

        <!-- Right Buttons -->
        <div class="d-flex flex-column flex-lg-row align-items-center ms-lg-3">

            <a href="{{ route('login_register') }}"
               class="btn btn-login ms-lg-1">
                   Login/Sign Up
            </a>
        </div>

    </div>
</nav>

<!-- ========================= STICKY SCRIPT ========================= -->
<script>
window.addEventListener("scroll", function () {
    const header = document.getElementById("mainHeader");
    if (window.scrollY > 80) {
        header.classList.add("sticky-active");
    } else {
        header.classList.remove("sticky-active");
    }
});
</script>

<!-- ========================= HEADER END ========================= -->
