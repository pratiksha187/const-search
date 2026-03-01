<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | ConstructKaro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    :root{
        --navy:#1c2c3e;
        --orange:#f25c05;
        --bg:#f4f6fb;
        --border:#e5e7eb;
    }

    body{
        margin:0;
        background:var(--bg);
        font-family:'Poppins',sans-serif;
    }

    /* ================= HEADER ================= */

    .main-header{
        height:65px;
        background:#fff;
        padding:0 18px;
        display:flex;
        align-items:center;
        justify-content:space-between;
        position:fixed;
        top:0;
        left:0;
        right:0;
        z-index:9999;
        border-bottom:1px solid var(--border);
        box-shadow:0 4px 14px rgba(0,0,0,0.05);
    }

    .logo img{
        height:84px;
    }

    .header-right{
        display:flex;
        align-items:center;
        gap:20px;
    }

    /* ================= DESKTOP MENU ================= */

    .top-menu{
        display:flex;
        gap:22px;
        align-items:center;
    }

    .top-menu a{
        text-decoration:none;
        color:var(--navy);
        font-weight:600;
        font-size:14px;
        position:relative;
    }

    .top-menu a:hover,
    .top-menu a.active{
        color:var(--orange);
    }

    /* ================= DROPDOWN ================= */

    .menu-dd{
        position:relative;
    }

    .menu-dd-menu{
        position:absolute;
        top:30px;
        left:0;
        width:220px;
        background:#fff;
        border-radius:10px;
        box-shadow:0 12px 28px rgba(0,0,0,0.12);
        display:none;
        padding:8px;
        z-index:2000;
    }

    .menu-dd-menu.show{
        display:block;
    }

    .menu-dd-menu a{
        display:block;
        padding:8px 10px;
        border-radius:6px;
        font-size:13px;
        text-decoration:none;
        color:var(--navy);
    }

    .menu-dd-menu a:hover{
        background:#f7f7f7;
    }

    /* ================= PROFILE ================= */

    .header-profile{
        display:flex;
        align-items:center;
        gap:8px;
        cursor:pointer;
    }

    .profile-avatar{
        width:32px;
        height:32px;
        border-radius:50%;
        background:linear-gradient(135deg,#ff9a3c,#f25c05);
        display:flex;
        align-items:center;
        justify-content:center;
        color:#fff;
        font-weight:700;
    }

    .profile-dropdown{
        position:absolute;
        top:60px;
        right:15px;
        background:#fff;
        border-radius:10px;
        box-shadow:0 12px 28px rgba(0,0,0,0.12);
        display:none;
        width:180px;
        z-index:2000;
    }

    .profile-dropdown.show{
        display:block;
    }

    .profile-dropdown a{
        display:block;
        padding:10px 14px;
        text-decoration:none;
        color:var(--navy);
        font-size:14px;
    }

    .profile-dropdown a:hover{
        background:#f7f7f7;
    }

    /* ================= MOBILE MENU ================= */

    .mobile-toggle{
        display:none;
        font-size:22px;
        cursor:pointer;
    }

    .mobile-menu{
        position:fixed;
        top:65px;
        left:0;
        width:100%;
        background:#fff;
        display:none;
        flex-direction:column;
        padding:15px;
        gap:12px;
        box-shadow:0 8px 20px rgba(0,0,0,0.08);
        z-index:9998;
    }

    .mobile-menu.show{
        display:flex;
    }

    .mobile-menu a{
        text-decoration:none;
        color:var(--navy);
        font-weight:600;
    }

    /* ================= CONTENT ================= */

    .dashboard-content{
        margin-top:80px;
        padding:20px;
        min-height:80vh;
    }

    /* ================= RESPONSIVE ================= */

    @media(max-width:992px){

        .top-menu{
            display:none;
        }

        .mobile-toggle{
            display:block;
        }

        .header-profile span{
            display:none;
        }
    }

    </style>
</head>
<body>
@php
    $vendor_id = session('vendor_id');
@endphp
<!-- HEADER -->
<div class="main-header">

    <div class="logo">
        <a href="{{ route('vendordashboard') }}">
            <img src="{{ asset('images/logobg.png') }}">
        </a>
    </div>

    <div class="header-right">

        <!-- DESKTOP MENU -->
         @if($vendor_id)
       
        <div class="top-menu">
            <a href="{{ route('vendordashboard') }}">Dashboard</a>

            <div class="menu-dd">
                <a href="javascript:void(0)" onclick="toggleMarketplace(event)">
                    Marketplace <i class="bi bi-chevron-down"></i>
                </a>
                <div class="menu-dd-menu" id="marketplaceDropdown">
                    <a href="{{ route('search_customer') }}">Lead Marketplace</a>
                    <!-- <a href="{{ route('supplierserch') }}">Search Suppliers</a> -->
                </div>
            </div>

            <a href="{{ route('vendorsubscription') }}">Credit Points</a>
            <a href="{{ route('vendor.agreement') }}">Agreement</a>
            <a href="{{ route('vendor.erp.notifications') }}">
                ERP Notifications
            </a>
        </div>

        <!-- PROFILE -->
        <div class="header-profile" onclick="toggleProfile(event)">
            <div class="profile-avatar">
                {{ strtoupper(substr($vendor->name ?? 'V',0,1)) }}
            </div>
            <span>{{ $vendor->name ?? '' }}</span>
            <i class="bi bi-chevron-down"></i>
        </div>

        <!-- MOBILE TOGGLE -->
        <div class="mobile-toggle" onclick="toggleMobileMenu()">
            <i class="bi bi-list"></i>
        </div>
        @endif
    </div>
</div>

      
<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
    <a href="{{ route('vendordashboard') }}">Dashboard</a>
    <a href="{{ route('search_customer') }}">Lead Marketplace</a>
    <!-- <a href="{{ route('supplierserch') }}">Search Suppliers</a> -->
    <a href="{{ route('vendorsubscription') }}">Credit Points</a>
    <a href="{{ route('vendor.agreement') }}">Agreement</a>
     <a href="{{ route('vendor.erp.notifications') }}">ERP Notifications</a>
</div>

<!-- PROFILE DROPDOWN -->
<div class="profile-dropdown" id="profileDropdown">
    <a href="{{ route('vendor.profile') }}">Profile</a>
    <a href="{{ route('logout') }}">Logout</a>
</div>

<!-- CONTENT -->
<div class="dashboard-content">
    @yield('content')
</div>

<script>
function toggleMarketplace(e){
    e.stopPropagation();
    document.getElementById('marketplaceDropdown').classList.toggle('show');
}

function toggleProfile(e){
    e.stopPropagation();
    document.getElementById('profileDropdown').classList.toggle('show');
}

function toggleMobileMenu(){
    document.getElementById('mobileMenu').classList.toggle('show');
}

document.addEventListener('click', function(){
    document.getElementById('marketplaceDropdown').classList.remove('show');
    document.getElementById('profileDropdown').classList.remove('show');
});
</script>

</body>
</html>
