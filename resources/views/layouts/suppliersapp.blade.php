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
/* ===== YOUR ORIGINAL CSS (UNCHANGED) ===== */
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

/* SIDEBAR */
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
.sidebar.collapsed{ width:80px; }
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
}
.sidebar a:hover,
.sidebar a.active{
    background:#f8fafc;
    color:var(--orange);
    border-left-color:var(--orange);
}
.sidebar.collapsed span{ display:none; }

/* HEADER */
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
.header-left{ display:flex; align-items:center; gap:14px; }
.toggle-btn{ font-size:22px; cursor:pointer; color:var(--navy); }
.main-header img{ height:78px; }

.header-right{ display:flex; align-items:center; gap:24px; }

/* PROFILE */
.header-profile{
    display:flex;
    align-items:center;
    gap:10px;
    cursor:pointer;
    padding:6px 10px;
    border-radius:999px;
}
.header-profile:hover{ background:#f8fafc; }
.profile-avatar{
    width:38px;height:38px;border-radius:50%;
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-weight:700;
}

/* DROPDOWNS */
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
    z-index:2000;
}
.profile-dropdown.show{ display:block; }
.profile-dropdown a{
    padding:12px 16px;
    display:flex;gap:10px;
    font-size:14px;color:var(--navy);
    text-decoration:none;
}
.profile-dropdown a:hover{ background:#f8fafc; }

/* CONTENT */
.dashboard-content{
    margin-left:240px;
    padding:28px;
    padding-top:120px;
    transition:.3s;
}
.dashboard-content.collapsed{ margin-left:80px; }

/* FOOTER */
.custom-footer{
    text-align:center;
    padding:12px;
    font-size:13px;
    color:var(--muted);
}

/* NOTIFICATIONS */
.header-notification{ position:relative; cursor:pointer; }
.header-notification i{ font-size:20px; }
.notify-badge{
    position:absolute;top:-6px;right:-8px;
    background:#f25c05;color:#fff;
    font-size:11px;padding:2px 6px;
    border-radius:999px;
}
.notification-dropdown{
    position:absolute;top:42px;right:0;
    width:280px;background:#fff;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,.12);
    display:none;z-index:999;
}
.notification-dropdown.show{ display:block; }
.notification-item{ padding:10px 12px;border-bottom:1px solid #f1f1f1; }
.notification-item .time{ font-size:11px;color:#888; }

@media(max-width:768px){
    .sidebar{left:-240px;}
    .sidebar.show{left:0;}
    .dashboard-content{margin-left:0;}
}
.sidebar a.active{
    background:#f8fafc;
    color:var(--orange);
    border-left-color:var(--orange);
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

        {{-- 🔔 Notification --}}
        <div class="header-notification" onclick="toggleNotification(event)">
            <i class="bi bi-bell"></i>

            @if(($notificationCount ?? 0) > 0)
                <span class="notify-badge">{{ $notificationCount }}</span>
            @endif

            <div class="notification-dropdown" id="notificationDropdown">
                <h6 class="px-3 pt-2">Notifications</h6>

                @forelse($notifications ?? [] as $note)
                    <div class="notification-item">
                        <strong>New Enquiry</strong>
                        <p class="mb-0">Qty: {{ number_format($note->quantity) }}</p>
                        <span class="time">
                            {{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}
                        </span>
                    </div>
                @empty
                    <p class="text-center py-3 text-muted">No notifications</p>
                @endforelse
            </div>
        </div>

        {{-- 👤 Profile --}}
        <div class="header-profile" onclick="toggleProfileMenu(event)">
            <div class="profile-avatar">
                {{ strtoupper(substr($supplierName ?? 'S',0,1)) }}
            </div>
            <span>{{ $supplierName ?? 'Supplier' }}</span>
            <i class="bi bi-chevron-down"></i>
        </div>
    </div>
</div>


<div class="sidebar" id="sidebar">

    <a href="{{ route('supplierdashboard') }}"
       class="{{ request()->routeIs('supplierdashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i><span>Dashboard</span>
    </a>

    <a href="{{ route('mystore') }}"
       class="{{ request()->routeIs('mystore') ? 'active' : '' }}">
        <i class="bi bi-shop"></i><span>My Store</span>
    </a>

    <a href="{{ route('myproducts') }}"
       class="{{ request()->routeIs('myproducts') ? 'active' : '' }}">
        <i class="bi bi-box-seam"></i><span>My Products</span>
    </a>

    <a href="{{ route('productenquiry') }}"
       class="{{ request()->routeIs('productenquiry') ? 'active' : '' }}">
        <i class="bi bi-chat-dots"></i><span>Enquiries</span>
    </a>

    <a href="{{ route('quotes.orders') }}"
       class="{{ request()->routeIs('quotes.orders') ? 'active' : '' }}">
        <i class="bi bi-receipt"></i><span>Quotes & Orders</span>
    </a>

</div>


<!-- PROFILE MENU -->
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
const notificationDropdown = document.getElementById("notificationDropdown");

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
    notificationDropdown.classList.remove("show");
}

function toggleNotification(e){
    e.stopPropagation();
    notificationDropdown.classList.toggle("show");
    profileDropdown.classList.remove("show");
}

document.addEventListener("click",()=>{
    profileDropdown.classList.remove("show");
    notificationDropdown.classList.remove("show");
});
</script>

</body>
</html>
