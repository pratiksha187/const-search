<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | ConstructKaro</title>

    <link rel="preload" href="{{ asset('images/logobg.png') }}" as="image">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --bg:#f4f6fb;
    --border:#e5e7eb;
    --muted:#64748b;
}
body{ background:var(--bg); font-family:'Poppins',sans-serif; }

.main-header{
    height:76px;background:#fff;padding:0 28px;display:flex;
    align-items:center;justify-content:space-between;
    position:fixed;top:0;width:100%;z-index:1200;
    border-bottom:1px solid var(--border);
    box-shadow:0 8px 28px rgba(15,23,42,.08);
}
.main-header img{ height:80px;object-fit:contain; }
.header-right{ display:flex;align-items:center;gap:28px; }
.top-menu{ display:flex;gap:26px;align-items:center; }
.top-menu a{
    text-decoration:none;color:var(--navy);
    font-weight:600;font-size:15px;
    position:relative;padding-bottom:6px;
}
.top-menu a::after{
    content:'';position:absolute;bottom:0;left:0;
    width:0;height:3px;background:var(--orange);
    border-radius:6px;transition:.25s;
}
.top-menu a:hover::after,.top-menu a.active::after{ width:100%; }
.top-menu a.active{ color:var(--orange); }

.notification-container{ position:relative; }
.notification-container i{ font-size:22px;cursor:pointer;color:var(--navy); }

.header-profile{
    display:flex;align-items:center;gap:10px;
    cursor:pointer;padding:6px 10px;border-radius:999px;
}
.header-profile:hover{ background:#f8fafc; }

.profile-avatar{
    width:38px;height:38px;border-radius:50%;
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
    display:flex;align-items:center;justify-content:center;
    color:#fff;font-weight:700;font-size:15px;
}

.header-profile span{ font-weight:600;color:var(--navy);font-size:14px; }

.profile-dropdown,.notification-dropdown{
    position:absolute;background:#fff;border-radius:14px;
    box-shadow:0 20px 40px rgba(15,23,42,.18);
    border:1px solid var(--border);display:none;z-index:2000;
}
.profile-dropdown.show,.notification-dropdown.show{ display:block; }

.profile-dropdown{ top:82px;right:22px;width:220px; }
.profile-dropdown a{
    padding:12px 16px;display:flex;gap:10px;
    align-items:center;font-size:14px;
    color:var(--navy);text-decoration:none;
}
.profile-dropdown a:hover{ background:#f8fafc; }

.notification-dropdown{ top:42px;right:0;width:320px; }
.notification-dropdown a{
    padding:12px 16px;display:block;
    font-size:13px;color:var(--navy);
    text-decoration:none;
}
.notification-dropdown a:hover{ background:#f8fafc; }

.dashboard-content{
    padding:28px;padding-top:120px !important;min-height:85vh;
}
.custom-footer{
    text-align:center;padding:12px;font-size:13px;color:#64748b;
}
@media(max-width:992px){
    .top-menu{display:none;}
    .header-profile span{display:none;}
}
</style>
</head>

@php
    /* ================= SAFE VENDOR LOGIC ================= */
    $vendor_id = session('vendor_id');
    $vendor_name = session('user_name'); // stored during login

    if ($vendor_id) {
        $unreadCount = DB::table('vendor_notifications')
            ->where('vendor_id', $vendor_id)
            ->where('is_read', 0)
            ->count();

        $notifications = DB::table('vendor_notifications')
            ->where('vendor_id', $vendor_id)
            ->latest()
            ->limit(5)
            ->get();
    } else {
        $unreadCount = 0;
        $notifications = collect();
    }
@endphp

<body>

<!-- HEADER -->
<div class="main-header">

    <!-- LOGO -->
    <a href="{{ $vendor_id ? route('vendordashboard') : url('/') }}">
        <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro">
    </a>

    <!-- RIGHT -->
    <div class="header-right">

        @if($vendor_id)

            <!-- MENU -->
            <div class="top-menu">
                <a href="{{ route('vendordashboard') }}" class="{{ request()->is('vendordashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('search_customer') }}" class="{{ request()->is('search-customer*') ? 'active' : '' }}">Lead Marketplace</a>
                <a href="{{ route('supplierserch') }}" class="{{ request()->routeIs('supplierserch') ? 'active' : '' }}">Search Suppliers</a>

            </div>

            <!-- NOTIFICATION -->
            <div class="notification-container">
                <i class="bi bi-bell" onclick="toggleNotificationMenu(event)"></i>

                @if($unreadCount > 0)
                    <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-circle">
                        {{ $unreadCount }}
                    </span>
                @endif

                <div class="notification-dropdown" id="notificationDropdown">
                    <div class="fw-bold p-3 border-bottom text-center">Notifications</div>

                    @forelse($notifications as $note)
                        <a href="{{ route('vendor.read.notification',$note->id) }}">
                            <strong>{{ $note->title }}</strong><br>
                            <small class="text-muted">{{ Str::limit($note->message,45) }}</small><br>
                            <small class="text-secondary">{{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}</small>
                        </a>
                    @empty
                        <div class="text-center text-muted p-3">No notifications</div>
                    @endforelse

                    <a href="{{ route('vendor.notifications') }}" class="text-primary text-center border-top py-2">View All</a>
                </div>
            </div>

            <!-- PROFILE -->
            <div class="header-profile" onclick="toggleProfileMenu(event)">
                <div class="profile-avatar">
                    {{ strtoupper(substr($vendor_name ?? 'V',0,1)) }}
                </div>
                <span>{{ $vendor_name }}</span>
                <i class="bi bi-chevron-down"></i>
            </div>

        @else
            <!-- GUEST -->
            <div class="top-menu">
                <a href="{{ route('login_register') }}">Vendor Login</a>
                <a href="{{ route('login_register') }}">Vendor Register</a>
            </div>
        @endif

    </div>
</div>

@if($vendor_id)
<div class="profile-dropdown" id="profileDropdown">
    <a href="{{ route('vendor.profile') }}"><i class="bi bi-person"></i> Profile</a>
    <a href="{{ route('logout') }}"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>
@endif

<!-- CONTENT -->
<div class="dashboard-content">
    @yield('content')
</div>

<div class="custom-footer">
    © {{ date('Y') }} ConstructKaro — Designed with ❤️ in India
</div>

<script>
function toggleProfileMenu(e){
    e.stopPropagation();
    profileDropdown.classList.toggle("show");
    notificationDropdown.classList.remove("show");
}
function toggleNotificationMenu(e){
    e.stopPropagation();
    notificationDropdown.classList.toggle("show");
    profileDropdown.classList.remove("show");
}
document.addEventListener("click",()=>{
    profileDropdown?.classList.remove("show");
    notificationDropdown?.classList.remove("show");
});
</script>

</body>
</html>
