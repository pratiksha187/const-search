<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title') | ConstructKaro</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
<link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">

    <style>
        :root {
            --navy: #1c2c3e;
            --orange: #f25c05;
            --light-bg: #f5f6fa;
        }

        body { background: var(--light-bg); font-family: 'Poppins', sans-serif; }

        /* HEADER */
        .main-header{
            height:78px;
            background:linear-gradient(180deg,#ffffff,#fafafa);
            padding:0 32px;
            display:flex;
            align-items:center;
            position:fixed;
            width:100%;
            top:0;
            z-index:1000;
            box-shadow:0 6px 20px rgba(0,0,0,0.12);
        }
        .main-header img{ height:72px; object-fit:contain; }

        /* TOP MENU */
        .top-menu{
            display:flex;
            align-items:center;
            gap:18px;
            margin-left:auto;
        }
        .top-menu a, .top-dd-btn{
            text-decoration:none;
            color:var(--navy);
            font-weight:600;
            font-size:14px;
            padding:8px 16px;
            border-radius:30px;
            transition:all .25s ease;
            display:flex;
            align-items:center;
            gap:8px;
        }
        .top-menu a:hover, .top-dd-btn:hover{
            background:rgba(242,92,5,0.08);
            color:var(--orange);
        }

        /* FIND DROPDOWN */
        .top-dd{ position:relative; }
        .top-dd-btn{ border:0; background:transparent; cursor:pointer; }

        .top-dd-menu{
            position:absolute;
            right:0;
            top:44px;
            width:260px;
            background:#fff;
            border-radius:14px;
            box-shadow:0 18px 40px rgba(0,0,0,0.18);
            overflow:hidden;
            display:none;
            z-index:9999;
            border:1px solid #f1f1f1;
        }
        .top-dd-menu a{
            display:flex;
            align-items:center;
            gap:10px;
            padding:12px 14px;
            font-size:13px;
            font-weight:600;
            color:#0f172a;
            border-bottom:1px solid #f3f4f6;
            border-radius:0;
        }
        .top-dd-menu a:hover{
            background:#f8fafc;
            color:var(--orange);
        }

        /* NOTIFICATION */
        .notification-container{ position:relative; }
        .notification-container i{
            font-size:22px;
            cursor:pointer;
            color:var(--navy);
        }
        .notification-dropdown{
            position:absolute;
            right:0;
            top:42px;
            width:320px;
            background:#fff;
            border-radius:14px;
            box-shadow:0 18px 40px rgba(0,0,0,0.18);
            display:none;
            z-index:9999;
            overflow:hidden;
        }
        .notification-dropdown a{
            display:block;
            padding:12px 16px;
            text-decoration:none;
            color:#333;
            font-size:13px;
            border-bottom:1px solid #f1f1f1;
        }
        .notification-dropdown a:hover{ background:#f7f7f7; }

        /* PROFILE */
        .header-profile{
            display:flex;
            align-items:center;
            gap:10px;
            padding:6px 14px 6px 8px;
            margin-left:18px;
            border-radius:40px;
            background:#fff;
            border:1px solid #e6e6e6;
            cursor:pointer;
        }
        .profile-trigger-avatar{
            width:36px;height:36px;border-radius:50%;
            background:var(--orange);
            color:#fff;font-weight:700;
            display:flex;align-items:center;justify-content:center;
        }
        .dashboard-content{ margin-top:120px; padding:30px; }

        .profile-dropdown{
            position:fixed;
            top:78px;
            right:32px;
            width:240px;
            background:#fff;
            border-radius:18px;
            padding:10px 0;
            box-shadow:0 15px 40px rgba(0,0,0,0.12);
            display:none;
            z-index:9999;
        }
        .profile-dropdown .dropdown-item{
            display:flex;align-items:center;gap:14px;
            padding:14px 22px;
            font-size:15px;
            font-weight:500;
            color:#0f172a;
            text-decoration:none;
        }
        .profile-dropdown .dropdown-item:hover{ background:#f8fafc; }
        .profile-dropdown .icon{
            width:34px;height:34px;
            background:#f1f5f9;border-radius:10px;
            display:flex;align-items:center;justify-content:center;
        }
        .profile-dropdown .logout .icon{ background:#fff1f2; }
    </style>
</head>

<body>

<div class="main-header">

    <!-- LOGO -->
    <a href="{{ $cust_data ? route('dashboard') : url('/') }}">
        <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro">
    </a>

    <div class="top-menu">

        @if($cust_data)
            <a href="{{ route('dashboard') }}">Dashboard</a>

            <!-- ✅ Find Dropdown -->
            <div class="top-dd" onclick="toggleFindMenu(event)">
                <button type="button" class="top-dd-btn">
                    Marketplace <i class="bi bi-chevron-down"></i>
                </button>

                <div class="top-dd-menu" id="findMenuDropdown" onclick="event.stopPropagation()">
                    <a href="{{ route('search_vendor') }}">
                        <i class="bi bi-person-badge"></i> Find Vendor
                    </a>
                    <a href="{{ route('supplierserch') }}">
                        <i class="bi bi-truck"></i> Find Supplier
                    </a>
                </div>
            </div>

            <!-- ✅ Normal Links (NO More dropdown) -->
            <a href="{{ route('supplier.enquiry.index') }}">Request Quote (RFQ)</a>
            <a href="{{ route('postsubscription') }}">Subscription Packages</a>
            <a href="{{ route('customer.agreement') }}">Agreement</a>

        @endif

        @if($cust_data)
            <!-- 🔔 Notification -->
            <div class="notification-container" onclick="toggleNotification(event)">
                <i class="bi bi-bell"></i>

                @if(($notificationCount) > 0)
                    <span class="badge bg-danger rounded-circle position-absolute top-0 start-100 translate-middle">
                        {{ $notificationCount }}
                    </span>
                @endif

                <div class="notification-dropdown" id="notificationDropdown" onclick="event.stopPropagation()">
                    @forelse($notifications as $note)
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
        @endif

        @if($cust_data)
            <!-- 👤 Profile -->
            <div class="header-profile" onclick="toggleProfileMenu(event)">
                <div class="profile-trigger-avatar">
                    {{ strtoupper(substr($cust_data->name ?? 'U', 0, 1)) }}
                </div>
                <span>{{ $cust_data->name ?? 'User' }}</span>
                <i class="bi bi-chevron-down"></i>
            </div>
        @endif

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
        const finddd = document.getElementById('findMenuDropdown');

        if (notif) notif.style.display = 'none';
        if (profile) profile.style.display = 'none';
        if (finddd) finddd.style.display = 'none';
    }

    function toggleFindMenu(e){
        e.stopPropagation();
        const dd = document.getElementById('findMenuDropdown');
        const isOpen = dd && dd.style.display === 'block';
        closeAll();
        if(dd) dd.style.display = isOpen ? 'none' : 'block';
    }

    function toggleNotification(e) {
        e.stopPropagation();
        const notif = document.getElementById('notificationDropdown');
        const isOpen = notif && notif.style.display === 'block';
        closeAll();
        if (notif) notif.style.display = isOpen ? 'none' : 'block';
    }

    function toggleProfileMenu(e) {
        e.stopPropagation();
        const profile = document.getElementById('profileDropdown');
        const isOpen = profile && profile.style.display === 'block';
        closeAll();
        if (profile) profile.style.display = isOpen ? 'none' : 'block';
    }

    document.addEventListener('click', closeAll);
</script>

</body>
</html>
