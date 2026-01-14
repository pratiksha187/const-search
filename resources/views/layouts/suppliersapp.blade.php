<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title') | ConstructKaro</title>

<link rel="preload" href="{{ asset('images/logobg.png') }}" as="image">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
/* 🔒 YOUR CSS – UNCHANGED */
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --bg:#f4f6fb;
    --border:#e5e7eb;
    --muted:#64748b;
}

body{
    margin:0;
    background:var(--bg);
    font-family:'Poppins',sans-serif;
}

/* ================= SIDEBAR ================= */
.sidebar{
    position:fixed;
    top:76px;
    left:0;
    width:240px;
    height:calc(100vh - 76px);
    background:#fff;
    border-right:1px solid var(--border);
    transition:.3s;
    z-index:1000;
}

.sidebar.collapsed{
    width:80px;
}

.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:14px 20px;
    color:var(--navy);
    text-decoration:none;
    font-weight:600;
    font-size:15px;
    border-left:4px solid transparent;
    transition:.2s;
}

.sidebar a i{
    font-size:18px;
}

.sidebar a:hover,
.sidebar a.active{
    background:#f8fafc;
    color:var(--orange);
    border-left-color:var(--orange);
}

.sidebar.collapsed span{
    display:none;
}

/* ================= HEADER ================= */
.main-header{
    height:76px;
    background:#fff;
    padding:0 24px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    position:fixed;
    top:0;
    width:100%;
    z-index:1200;
    border-bottom:1px solid var(--border);
    box-shadow:0 8px 28px rgba(15,23,42,.08);
}

/* LEFT */
.header-left{
    display:flex;
    align-items:center;
    gap:14px;
}

.toggle-btn{
    font-size:22px;
    cursor:pointer;
    color:var(--navy);
}

/* LOGO */
.main-header img{
    height:78px;
}

/* RIGHT */
.header-right{
    display:flex;
    align-items:center;
    gap:24px;
}

/* PROFILE */
.header-profile{
    display:flex;
    align-items:center;
    gap:10px;
    cursor:pointer;
    padding:6px 10px;
    border-radius:999px;
}

.header-profile:hover{
    background:#f8fafc;
}

.profile-avatar{
    width:38px;
    height:38px;
    border-radius:50%;
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-weight:700;
}

.header-profile span{
    font-weight:600;
    font-size:14px;
}

/* DROPDOWN */
.profile-dropdown{
    position:absolute;
    top:82px;
    right:24px;
    width:220px;
    background:#fff;
    border-radius:14px;
    box-shadow:0 20px 40px rgba(15,23,42,.18);
    border:1px solid var(--border);
    display:none;
    overflow:hidden;
    z-index:2000;
}

.profile-dropdown.show{
    display:block;
}

.profile-dropdown a{
    padding:12px 16px;
    display:flex;
    gap:10px;
    align-items:center;
    font-size:14px;
    color:var(--navy);
    text-decoration:none;
}

.profile-dropdown a:hover{
    background:#f8fafc;
}

/* ================= CONTENT ================= */
.dashboard-content{
    margin-left:240px;
    padding:28px;
    padding-top:120px;
    transition:.3s;
}

.dashboard-content.collapsed{
    margin-left:80px;
}

/* FOOTER */
.custom-footer{
    text-align:center;
    padding:12px;
    font-size:13px;
    color:var(--muted);
}

/* MOBILE */
@media(max-width:768px){
    .sidebar{left:-240px;}
    .sidebar.show{left:0;}
    .dashboard-content{margin-left:0;}
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="main-header">
    <div class="header-left">
        <i class="bi bi-list toggle-btn" onclick="toggleSidebar()"></i>
        <a href="{{ route('supplierdashboard') }}">
            <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro">
        </a>
    </div>

    <div class="header-right">
        <div class="header-profile" onclick="toggleProfileMenu(event)">
            <div class="profile-avatar">
                {{ strtoupper(substr($supplierName,0,1)) }}
            </div>
            <span>{{ $supplierName }}</span>
            <i class="bi bi-chevron-down"></i>
        </div>
    </div>
</div>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <a href="{{ route('supplierdashboard') }}" class="{{ request()->routeIs('supplierdashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i><span>Dashboard</span>
    </a>

    <a href="{{ route('mystore') }}" class="{{ request()->routeIs('mystore') ? 'active' : '' }}">
        <i class="bi bi-plus-square"></i><span>My Store</span>
    </a>

    <a href="{{ route('myproducts') }}" class="{{ request()->routeIs('myproducts') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i><span>My Products</span>
    </a>

    <a href="{{ route('productenquiry') }}" class="{{ request()->routeIs('productenquiry') ? 'active' : '' }}">
        <i class="bi bi-chat-dots"></i><span>Enquiries</span>
    </a>

    <a href="{{ route('quotes.orders') }}" class="{{ request()->routeIs('quotes.orders') ? 'active' : '' }}">
        <i class="bi bi-chat-dots"></i><span>Quotes & Orders</span>
    </a>
</div>

<!-- PROFILE DROPDOWN -->
<div class="profile-dropdown" id="profileDropdown">
    <a href="{{ route('suppliers.profile') }}"><i class="bi bi-person"></i> Profile</a>
    <a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<!-- CONTENT -->
<div class="dashboard-content" id="content">
    @yield('content')
</div>

<div class="custom-footer">
    © {{ date('Y') }} ConstructKaro — Designed with ❤️ in India
</div>

<script>
const sidebar = document.getElementById("sidebar");
const content = document.getElementById("content");
const profileDropdown = document.getElementById("profileDropdown");

function toggleSidebar(){
    if(window.innerWidth <= 768){
        sidebar.classList.toggle("show");
    }else{
        sidebar.classList.toggle("collapsed");
        content.classList.toggle("collapsed");
    }
}

function toggleProfileMenu(e){
    e.stopPropagation();
    profileDropdown.classList.toggle("show");
}

document.addEventListener("click",()=>{
    profileDropdown.classList.remove("show");
});
</script>

</body>
</html>
