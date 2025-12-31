<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | ConstructKaro</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --navy: #1c2c3e;
            --orange: #f25c05;
            --light-bg: #f5f6fa;
        }

        body {
            background: var(--light-bg);
            font-family: 'Poppins', sans-serif;
        }

        /* ================= HEADER ================= */
        .main-header {
            height: 78px;
            background: linear-gradient(180deg, #ffffff, #fafafa);
            padding: 0 32px;
            display: flex;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 20;
            box-shadow: 0 6px 20px rgba(0,0,0,0.12);
        }

        .main-header img {
            height: 72px;
            object-fit: contain;
        }

        /* ================= TOP MENU ================= */
        .top-menu {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-left: auto;
        }

        .top-menu a {
            text-decoration: none;
            color: var(--navy);
            font-weight: 600;
            font-size: 14px;
            padding: 8px 16px;
            border-radius: 30px;
            transition: all 0.25s ease;
        }

        .top-menu a:hover {
            background: rgba(242, 92, 5, 0.08);
            color: var(--orange);
        }

        .top-menu a.active {
            background: var(--orange);
            color: #fff;
            box-shadow: 0 6px 14px rgba(242, 92, 5, 0.35);
        }

        /* ================= NOTIFICATION ================= */
        .notification-container {
            position: relative;
            margin-left: 18px;
        }

        .notification-container i {
            font-size: 22px;
            cursor: pointer;
            color: var(--navy);
        }

        .notification-dropdown {
            position: absolute;
            right: 0;
            top: 42px;
            width: 320px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.18);
            display: none;
            z-index: 300;
            overflow: hidden;
        }

        .notification-dropdown a {
            display: block;
            padding: 12px 16px;
            text-decoration: none;
            color: #333;
            font-size: 13px;
            border-bottom: 1px solid #f1f1f1;
        }

        .notification-dropdown a:hover {
            background: #f7f7f7;
        }

        /* ================= PROFILE ================= */
        .header-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 14px 6px 8px;
            margin-left: 18px;
            border-radius: 40px;
            background: #ffffff;
            border: 1px solid #e6e6e6;
            cursor: pointer;
        }

        .profile-trigger-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--orange);
            color: #fff;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dashboard-content {
            margin-top: 120px;
            padding: 30px;
        }

        /* Dropdown */
        .profile-dropdown {
            position: absolute;
            top: 70px;
            right: 20px;
            width: 240px;
            background: #ffffff;
            border-radius: 18px;
            padding: 10px 0;
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            display: none;
            z-index: 9999;
            animation: fadeSlide 0.25s ease;
        }

        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .profile-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 22px;
            font-size: 16px;
            font-weight: 500;
            color: #0f172a;
            text-decoration: none;
            transition: background 0.2s ease;
        }

        .profile-dropdown .dropdown-item:hover {
            background: #f8fafc;
        }

        .profile-dropdown .icon {
            width: 34px;
            height: 34px;
            background: #f1f5f9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-dropdown .logout .icon {
            background: #fff1f2;
        }
    </style>
</head>

@php
    // ✅ Safe Customer Session Logic
    $cust_data = null;
    $customer_id = session('customer_id');

    if ($customer_id) {
        // change table name if your customer table is different
        $cust_data = DB::table('users')->where('id', $customer_id)->first();

        // ✅ If you have is_read column use it, else remove where('is_read',0)
        $unreadCountQuery = DB::table('customer_notifications')->where('customer_id', $customer_id);

        // If column exists in your table then keep, otherwise comment this line
        // $unreadCountQuery->where('is_read', 0);

        $unreadCount = $unreadCountQuery->count();

        $usernotifications = DB::table('customer_notifications')
            ->where('customer_id', $customer_id)
            ->latest()
            ->limit(5)
            ->get();
    } else {
        $unreadCount = 0;
        $usernotifications = collect();
    }
@endphp

<body>

<div class="main-header">

    <!-- LOGO -->
    <a href="{{ $cust_data ? route('dashboard') : url('/') }}">
        <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro">
    </a>

    <!-- MENU -->
    <div class="top-menu">
        @if($cust_data)

            <a href="{{route('dashboard')}}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('myposts') }}" class="{{ request()->routeIs('myposts') ? 'active' : '' }}">My Posts</a>
            <a href="{{ route('post') }}" class="{{ request()->routeIs('post') ? 'active' : '' }}">Add Post</a>
            <a href="{{ route('search_vendor') }}" class="{{ request()->routeIs('search_vendor') ? 'active' : '' }}">Search Vendors</a>
            <a href="{{ route('supplierserch') }}" class="{{ request()->routeIs('supplierserch') ? 'active' : '' }}">Search Suppliers</a>

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

                    @forelse($usernotifications as $note)
                        <a href="#">
                            <small class="text-muted">{{ Str::limit($note->message,45) }}</small>
                        </a>
                    @empty
                        <div class="text-center text-muted p-3">No notifications</div>
                    @endforelse

                    <a href="{{route('user.notifications')}}" class="text-center text-primary d-block py-2">View All</a>
                </div>
            </div>

            <!-- PROFILE -->
            <div class="header-profile" onclick="toggleProfileMenu(event)">
                <div class="profile-trigger-avatar">
                    {{ strtoupper(substr($cust_data->name ?? 'U', 0, 1)) }}
                </div>
                <span>{{ $cust_data->name ?? 'User' }}</span>
                <i class="bi bi-chevron-down"></i>
            </div>

        @else
            <!-- ✅ GUEST MENU -->
            <a href="{{ route('login_register') }}">Customer Login</a>
            <a href="{{ route('login_register') }}">Customer Register</a>
        @endif
    </div>
</div>

@if($cust_data)
<div class="profile-dropdown" id="profileDropdown">
    <a href="{{ route('cutomerprofile') }}" class="dropdown-item">
        <span class="icon"><i data-lucide="user"></i></span>
        <span>Profile</span>
    </a>

    <a href="{{ route('logout') }}" class="dropdown-item logout">
        <span class="icon"><i data-lucide="log-out"></i></span>
        <span>Logout</span>
    </a>
</div>
@endif

<div class="dashboard-content">
    @yield('content')
</div>

<script>
function toggleProfileMenu(event){
    event.stopPropagation();
    const menu = document.getElementById('profileDropdown');
    if(!menu) return;
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';

    const notify = document.getElementById('notificationDropdown');
    if(notify) notify.style.display = 'none';
}

function toggleNotificationMenu(event){
    event.stopPropagation();
    const menu = document.getElementById('notificationDropdown');
    if(!menu) return;
    menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';

    const profile = document.getElementById('profileDropdown');
    if(profile) profile.style.display = 'none';
}

document.addEventListener('click', function(){
    const profile = document.getElementById('profileDropdown');
    const notify  = document.getElementById('notificationDropdown');
    if(profile) profile.style.display = 'none';
    if(notify) notify.style.display = 'none';
});
</script>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

</body>
</html>
