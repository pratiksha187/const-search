<style>
body {
    background: #ffffff;
    font-family: 'Poppins', sans-serif;
}

.page-offset {
    padding-top: 92px;
}

/* ===== Header fixed size ===== */
.glass-header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 99999;
    background: rgba(255, 255, 255, 0.92);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 0;
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.04);
    width: 100%;
    height: 72px;
    padding: 0 30px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.sticky-header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
}

.sticky-active {
    height: 72px !important;
    padding-top: 0 !important;
    padding-bottom: 0 !important;
    background: rgba(255, 255, 255, 0.98) !important;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06) !important;
}

.glass-header .container-fluid {
    height: 100%;
    display: flex;
    align-items: center;
    position: relative;
    z-index: 2;
}

.glass-header .navbar-collapse {
    justify-content: flex-end;
    align-items: center;
}

/* ===== Brand ===== */
.navbar-brand {
    height: 72px;
    display: flex;
    align-items: center;
    margin: 0;
    padding: 0;
    position: relative;
    z-index: 100001;
}

.glass-header .navbar-brand {
    margin-right: 0;
}

.logo-img {
    height: 90px;
    width: auto;
    object-fit: contain;
    display: block;
    transition: all 0.3s ease;
}

.sticky-active .logo-img {
    height: 90px;
}

/* ===== Links ===== */
.nav-link {
    color: #1c2c3e !important;
    font-weight: 600;
    font-size: 16px;
    margin-right: 22px;
    padding: 8px 0 !important;
    position: relative;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #f25c05 !important;
}

.nav-link::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 2px;
    width: 0;
    height: 2px;
    background: #f25c05;
    transition: width 0.3s ease;
}

.nav-link:hover::after {
    width: 100%;
}

/* ===== Login Button ===== */
.btn-login {
    padding: 10px 24px;
    border-radius: 999px;
    border: 1.5px solid #1c2c3e;
    background: transparent;
    color: #1c2c3e;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-login:hover {
    background: #1c2c3e;
    color: #fff;
    border-color: #1c2c3e;
    box-shadow: 0 8px 18px rgba(28, 44, 62, 0.15);
}

/* ===== Toggler ===== */
.navbar-toggler {
    border: 1px solid rgba(28, 44, 62, 0.18);
    border-radius: 12px;
    padding: 8px 10px;
    background: #fff;
    box-shadow: none !important;
    position: relative;
    z-index: 100001;
    pointer-events: auto !important;
}

.navbar-toggler:focus {
    box-shadow: none;
    border-color: rgba(28, 44, 62, 0.25);
}

.navbar-toggler-icon {
    background-image: none;
    width: 24px;
    height: 18px;
    position: relative;
    display: inline-block;
}

.navbar-toggler-icon::before,
.navbar-toggler-icon::after,
.navbar-toggler-icon span {
    content: "";
    position: absolute;
    left: 0;
    width: 24px;
    height: 2.5px;
    background: #1c2c3e;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.navbar-toggler-icon::before {
    top: 0;
}

.navbar-toggler-icon span {
    top: 7px;
}

.navbar-toggler-icon::after {
    top: 14px;
}

/* ===== Tablet / Mobile ===== */
@media (max-width: 991px) {
    .glass-header {
        height: 64px;
        padding: 0 16px;
        overflow: visible;
    }

    .navbar-brand {
        height: 64px;
    }

    .logo-img {
        height: 70px;
    }

    .sticky-active {
        height: 64px !important;
    }

    .sticky-active .logo-img {
        height: 70px;
    }

    .navbar-collapse {
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        right: 0;
        margin-top: 0;
        padding: 16px;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 14px 30px rgba(0, 0, 0, 0.08);
        border: 1px solid rgba(0, 0, 0, 0.05);
        z-index: 99998;
    }

    .navbar-nav {
        align-items: flex-start !important;
    }

    .nav-link {
        margin-right: 0;
        padding: 10px 0 !important;
        font-size: 15px;
        width: 100%;
    }

    .nav-link::after {
        display: none;
    }

    .btn-login {
        width: 100%;
        margin-top: 12px;
        text-align: center;
        padding: 12px 20px;
    }

    .page-offset {
        padding-top: 82px;
    }
}

/* ===== Mobile ===== */
@media (max-width: 575px) {
    .glass-header {
        height: 58px;
        padding: 0 12px;
    }

    .navbar-brand {
        height: 58px;
    }

    .logo-img {
        height: 62px;
    }

    .sticky-active {
        height: 58px !important;
    }

    .sticky-active .logo-img {
        height: 62px;
    }

    .page-offset {
        padding-top: 74px;
    }
}
</style>

<nav id="mainHeader" class="navbar navbar-expand-lg glass-header sticky-header">
    <div class="container-fluid px-0">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('homepage') }}">
            <img src="{{ asset('images/logobg.png') }}" class="logo-img me-2" alt="ConstructKaro Logo">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><span></span></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('homepage') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('aboutus') }}">About Us</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('knowledgehub') }}">Eduction </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('findpros') }}">Find Pros</a>
                </li> -->
            </ul>

            <div class="d-flex flex-column flex-lg-row align-items-center ms-lg-3">
                <a href="{{ route('login_register') }}" class="btn-login">
                    Login/Sign Up
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
window.addEventListener("scroll", function () {
    const header = document.getElementById("mainHeader");
    if (window.scrollY > 40) {
        header.classList.add("sticky-active");
    } else {
        header.classList.remove("sticky-active");
    }
});
</script>