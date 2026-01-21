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

        *{ box-sizing:border-box }

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
            width:260px;
            background:#fff;
            border-right:1px solid var(--border);
            display:flex;
            flex-direction:column;
            position:fixed;
            top:0;
            bottom:0;
            left:0;
        }

        .sidebar-logo{
            height:90px;
            display:flex;
            align-items:center;
            justify-content:center;
            border-bottom:1px solid var(--border);
        }

        .sidebar-logo img{
            height:60px;
        }

        .sidebar-menu{
            padding:20px 14px;
            flex:1;
        }

        .menu-item{
            display:flex;
            align-items:center;
            gap:12px;
            padding:12px 16px;
            border-radius:14px;
            font-weight:600;
            font-size:14px;
            color:var(--navy);
            text-decoration:none;
            margin-bottom:8px;
            transition:.25s;
        }

        .menu-item i{
            font-size:18px;
        }

        .menu-item:hover,
        .menu-item.active{
            background:var(--orange);
            color:#fff;
        }

        /* ================= SIDEBAR FOOTER ================= */
        .sidebar-footer{
            padding:16px;
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

        .profile-name{
            font-weight:600;
            color:var(--navy);
            font-size:14px;
        }

        /* ================= CONTENT ================= */
        .main-content{
            margin-left:260px;
            padding:32px;
            width:calc(100% - 260px);
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

            <a href="{{ route('admindashboard') }}" class="menu-item active">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="{{ route('addmaster') }}" class="menu-item">
                <i class="bi bi-grid"></i>
                Add Master
            </a>

            <a href="{{ route('vendor_verification') }}" class="menu-item">
                <i class="bi bi-shield-check"></i>
                Vendor Verification
            </a>

        </nav>

        <div class="sidebar-footer">
            <div class="profile-avatar">A</div>
            <div class="profile-name">Admin</div>
        </div>

    </aside>

    <!-- ================= CONTENT ================= -->
    <main class="main-content">
        @yield('content')
    </main>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
