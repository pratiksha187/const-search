<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','Dashboard') | ConstructKaro</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --bg:#f5f6fa;
    --border:#e5e7eb;
}

body{
    margin:0;
    font-family:'Poppins',sans-serif;
    background:var(--bg);
}

/* ================= LAYOUT ================= */

.app-layout{
    display:flex;
    min-height:100vh;
}

/* ================= SIDEBAR ================= */

.sidebar{
    width:270px;
    background:#fff;
    border-right:1px solid var(--border);
    position:fixed;
    top:0;
    bottom:0;
    left:0;
    overflow-y:auto;
}

/* LOGO */
.sidebar-logo{
    height:85px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-bottom:1px solid var(--border);
}

.sidebar-logo img{
    height:55px;
}

/* MENU */
.sidebar-menu{
    padding:20px 14px;
}

/* MENU ITEM */
.menu-item{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
    padding:12px 16px;
    border-radius:12px;
    font-weight:600;
    font-size:14px;
    color:var(--navy);
    text-decoration:none;
    margin-bottom:6px;
    transition:.25s;
    cursor:pointer;
}

.menu-item i{
    font-size:18px;
}

.menu-item:hover,
.menu-item.active{
    background:var(--orange);
    color:#fff;
}

/* GROUP TITLE */
.menu-group-title{
    font-size:11px;
    font-weight:700;
    color:#94a3b8;
    margin:20px 16px 10px;
    text-transform:uppercase;
}

/* SUB MENU */
.sub-menu{
    display:none;
    padding-left:10px;
}

.sub-menu a{
    display:block;
    padding:10px 14px;
    font-size:13px;
    border-radius:10px;
    text-decoration:none;
    color:var(--navy);
    margin-bottom:5px;
}

.sub-menu a:hover,
.sub-menu a.active{
    background:#fff3ec;
    color:var(--orange);
}

/* ARROW */
.menu-arrow{
    font-size:14px;
    transition:.3s;
}

.rotate{
    transform:rotate(90deg);
}

/* FOOTER */
.sidebar-footer{
    padding:15px;
    border-top:1px solid var(--border);
    display:flex;
    align-items:center;
    gap:12px;
}

.profile-avatar{
    width:42px;
    height:42px;
    border-radius:50%;
    background:var(--orange);
    color:#fff;
    display:flex;
    align-items:center;
    justify-content:center;
    font-weight:700;
}

/* ================= CONTENT ================= */

.main-content{
    margin-left:270px;
    padding:32px;
    width:calc(100% - 270px);
}

/* ================= RESPONSIVE ================= */

@media(max-width:768px){
    .sidebar{
        transform:translateX(-100%);
    }
    .main-content{
        margin-left:0;
        width:100%;
    }
}

</style>
</head>

<body>

<div class="app-layout">

    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar">

        <div class="sidebar-logo">
            <a href="{{ route('admindashboard') }}">
                <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro">
            </a>
        </div>

        <nav class="sidebar-menu">

            {{-- DASHBOARD --}}
            <a href="{{ route('admindashboard') }}"
               class="menu-item {{ request()->routeIs('admindashboard') ? 'active' : '' }}">
                <span><i class="bi bi-speedometer2"></i> Dashboard</span>
            </a>

            {{-- MASTER --}}
            <a href="{{ route('addmaster') }}"
               class="menu-item {{ request()->routeIs('addmaster') ? 'active' : '' }}">
                <span><i class="bi bi-grid"></i> Add Master</span>
            </a>

            {{-- VENDORS --}}
            <div class="menu-group-title">Vendors</div>

            <div class="menu-item toggle-menu">
                <span><i class="bi bi-people"></i> Vendor Management</span>
                <i class="bi bi-chevron-right menu-arrow"></i>
            </div>

            <div class="sub-menu">
                <a href="{{ route('vendor_verification') }}">Vendor Verification</a>
                <a href="{{ route('admin.vendor.agreement.list') }}">Vendor Agreement(CK)</a>
            </div>


            {{-- SUPPLIERS --}}
            <div class="menu-group-title">Suppliers</div>

            <div class="menu-item toggle-menu">
                <span><i class="bi bi-box-seam"></i> Supplier Management</span>
                <i class="bi bi-chevron-right menu-arrow"></i>
            </div>

            <div class="sub-menu">
                <a href="{{ route('supplier_verification') }}">Supplier Verification</a>
               
            </div>


            {{-- LEADS --}}
            <div class="menu-group-title">Leads</div>

            <div class="menu-item toggle-menu">
                <span><i class="bi bi-journal-bookmark"></i> Lead Management</span>
                <i class="bi bi-chevron-right menu-arrow"></i>
            </div>

            <div class="sub-menu">
                <a href="{{ route('postverification') }}">Lead Verification</a>
                <a href="{{ route('admin.freeleads') }}">Free Leads (FB/Insta)</a>
                <a href="{{ route('primium_lead_intrested') }}">Premium Lead Interested</a>
                <a href="{{ route('admin.post.agreement.list') }}">Post Agreement(CK)</a>
                 
            </div>

        </nav>

        <div class="sidebar-footer">
            <div class="profile-avatar">A</div>
            <div>
                <div style="font-weight:600;">Admin</div>
                <a href="{{ route('logout') }}" style="font-size:13px;">Logout</a>
            </div>
        </div>

    </aside>

    <!-- ================= CONTENT ================= -->
    <main class="main-content">
        @yield('content')
    </main>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
// COLLAPSIBLE MENU
document.querySelectorAll('.toggle-menu').forEach(function(menu){
    menu.addEventListener('click', function(){

        const subMenu = this.nextElementSibling;
        const arrow = this.querySelector('.menu-arrow');

        if(subMenu.style.display === "block"){
            subMenu.style.display = "none";
            arrow.classList.remove('rotate');
        }else{
            subMenu.style.display = "block";
            arrow.classList.add('rotate');
        }
    });
});
</script>

</body>
</html>
