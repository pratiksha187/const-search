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
            z-index: 1000;
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

        /* ================= NOTIFICATION ================= */
        .notification-container {
            position: relative;
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
            z-index: 9999;
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

        .profile-dropdown {
            position: fixed;
            top: 78px;
            right: 32px;
            width: 240px;
            background: #ffffff;
            border-radius: 18px;
            padding: 10px 0;
            box-shadow: 0 15px 40px rgba(0,0,0,0.12);
            display: none;
            z-index: 9999;
        }

        .profile-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 22px;
            font-size: 15px;
            font-weight: 500;
            color: #0f172a;
            text-decoration: none;
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

<body>

<div class="main-header">

    <!-- LOGO -->
    <a href="{{ $cust_data ? route('dashboard') : url('/') }}">
        <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro">
    </a>

    <div class="top-menu">

        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('myposts') }}">My Posts</a>
        <a href="{{ route('post') }}">Add Post</a>

        <!-- 🔔 Notification -->
        <div class="notification-container" onclick="toggleNotification(event)">
            <i class="bi bi-bell"></i>

            @if(($notificationCount) > 0)
            <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle">
                {{ $notificationCount }}
            </span>
            @endif

            <div class="notification-dropdown" id="notificationDropdown" onclick="event.stopPropagation()">
                @forelse($notifications  as $note)
                    <a href="{{ route('customer.notifications') }}">
                        <strong>{{ $note->vendor_name ?? 'Vendor #'.$note->vendor_id }}</strong><br>
                        <small class="text-muted">Interested in your project</small><br>
                        <small>{{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}</small>
                    </a>
                @empty
                    <div class="text-center p-3 text-muted">No notifications</div>
                @endforelse
            </div>
        </div>


        <!-- 👤 Profile -->
        <div class="header-profile" onclick="toggleProfileMenu(event)">
            <div class="profile-trigger-avatar">
                {{ strtoupper(substr($cust_data->name ?? 'U', 0, 1)) }}
            </div>
            <span>{{ $cust_data->name ?? 'User' }}</span>
            <i class="bi bi-chevron-down"></i>
        </div>

    </div>
</div>

@if($cust_data)
<div class="profile-dropdown" id="profileDropdown">
    <a href="{{ route('cutomerprofile') }}" class="dropdown-item">
        <span class="icon"><i data-lucide="user"></i></span>
        Profile
    </a>

    <a href="{{ route('logout') }}" class="dropdown-item logout">
        <span class="icon"><i data-lucide="log-out"></i></span>
        Logout
    </a>
</div>
@endif

<div class="dashboard-content">
    @yield('content')
</div>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();


function closeAll() {
    const notif = document.getElementById('notificationDropdown');
    const profile = document.getElementById('profileDropdown');
    if (notif) notif.style.display = 'none';
    if (profile) profile.style.display = 'none';
}


function toggleProfileMenu(e) {
    e.stopPropagation();
    closeAll();

    const profile = document.getElementById('profileDropdown');
    if (profile) profile.style.display = 'block';
}

document.addEventListener('click', closeAll);


   function toggleNotification(e) {
    e.stopPropagation();
    closeAll();

    const notif = document.getElementById('notificationDropdown');
    if (notif) notif.style.display = 'block';
}

    function toggleProfileMenu(e) {
        e.stopPropagation();
        closeAll();
        document.getElementById('profileDropdown').style.display = 'block';
    }

    document.addEventListener('click', closeAll);
</script>

</body>
</html>
