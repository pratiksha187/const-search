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

        .profile-dropdown {
            position: absolute;
            right: 32px;
            top: 88px;
            width: 240px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 18px 40px rgba(0,0,0,0.18);
            display: none;
            z-index: 300;
        }

        .dashboard-content {
            margin-top: 120px;
            padding: 30px;
        }
    </style>
</head>

<body>

<div class="main-header">

    <!-- LOGO -->
    <a href="{{ route('homepage') }}">
        <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro">
    </a>

    <!-- MENU -->
    <div class="top-menu">
        <a href="/dashboard">Dashboard</a>
        <a href="{{ route('myposts') }}">My Posts</a>
        <a href="{{ route('post') }}">Add Post</a>
        <a href="{{ route('search_vendor') }}">Search Vendors</a>
        <a href="{{ route('supplierserch') }}">Search Suppliers</a>
        
    </div>

    <!-- NOTIFICATION -->
    <div class="notification-container">
        @php
            $customer_id = session('user_id');
            $unreadCount = DB::table('customer_notifications')
                ->where('customer_id',$customer_id)
              
                ->count();

            $usernotifications = DB::table('customer_notifications')
                ->where('customer_id',$customer_id)
                ->latest()
                ->limit(5)
                ->get();
        @endphp

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
            {{ strtoupper(substr(session('user_name') ?? 'U', 0, 1)) }}
        </div>
        <span>{{ session('user_name') ?? 'User' }}</span>
        <i class="bi bi-chevron-down"></i>
    </div>
</div>

<div class="profile-dropdown" id="profileDropdown">
    <a href="{{route('cutomerprofile')}}" class="d-block p-3">My Profile</a>
    <a href="/logout" class="d-block p-3 text-danger">Logout</a>
</div>

<div class="dashboard-content">
    @yield('content')
</div>

<script>
function toggleProfileMenu(event){
    event.stopPropagation();
    const menu = document.getElementById('profileDropdown');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

function toggleNotificationMenu(event){
    event.stopPropagation();
    const menu = document.getElementById('notificationDropdown');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

document.addEventListener('click', function(){
    document.getElementById('profileDropdown').style.display = 'none';
    document.getElementById('notificationDropdown').style.display = 'none';
});
</script>

</body>
</html>
