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
        :root {
            --navy: #1c2c3e;
            --orange: #f25c05;
            --bg: #f5f6fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
        }

        /* ================= HEADER ================= */
        .main-header {
            height: 78px;
            background: #fff;
            padding: 0 32px;
            display: flex;
            align-items: center;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 8px 25px rgba(0,0,0,.08);
        }

        .main-header img {
            height: 64px;
        }

        /* ================= MENU ================= */
        .top-menu {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .top-menu a,
        .dropdown-toggle {
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            color: var(--navy);
            padding: 8px 18px;
            border-radius: 30px;
            transition: .25s;
            cursor: pointer;
        }

        .top-menu a:hover,
        .dropdown-toggle:hover,
        .dropdown-toggle.show {
            background: var(--orange);
            color: #fff;
        }

        /* ================= PROFILE ================= */
        .profile-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: var(--orange);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* ================= CONTENT ================= */
        .dashboard-content {
            margin-top: 120px;
            padding: 30px;
        }

        /* ================= MEGA DROPDOWN ================= */
        .dropdown-menu.master-grid {
            position: absolute;
            width: 560px;
            padding: 22px;
            border-radius: 20px;
            border: none;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            background: #fff;
            box-shadow: 0 20px 50px rgba(0,0,0,.18);
            visibility: hidden; /* Hide by default */
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .master-tile {
            background: #f9fafb;
            border-radius: 14px;
            padding: 14px;
        }

        .master-title {
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
            text-transform: uppercase;
            margin-bottom: 8px;
        }

        .master-actions a {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: var(--navy);
            text-decoration: none;
            margin-bottom: 4px;
        }

        .master-actions a:hover {
            color: var(--orange);
        }

        /* Add a class for visible dropdown */
        .dropdown-menu.show {
            visibility: visible;
            opacity: 1;
        }

        body.dropdown-open {
            overflow: hidden;
        }
    </style>
</head>

<body>

<!-- ================= HEADER ================= -->
<div class="main-header">

    <a href="{{ route('admindashboard') }}">
        <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro">
    </a>

    <div class="top-menu">

        <a href="{{ route('admindashboard') }}">Dashboard</a>

        <!-- ADD MASTER -->
        <div class="dropdown">
            <span id="addMasterDropdown"
                  class="dropdown-toggle"
                  data-bs-toggle="dropdown"
                  data-bs-auto-close="outside">
                Add Master
            </span>

            <ul class="dropdown-menu master-grid" aria-labelledby="addMasterDropdown">

                <li class="master-tile">
                    <div class="master-title">Category</div>
                    <div class="master-actions">
                        <a href="{{ route('material-categories.index') }}">View</a>
                        <a href="{{ route('material-categories.create') }}">Add</a>
                    </div>
                </li>

                <li class="master-tile">
                    <div class="master-title">Product</div>
                    <div class="master-actions">
                        <a href="{{ route('material-products.index') }}">View</a>
                        <a href="{{ route('material-products.create') }}">Add</a>
                    </div>
                </li>

                <li class="master-tile">
                    <div class="master-title">Subtype</div>
                    <div class="master-actions">
                        <a href="{{ route('material-product-subtypes.index') }}">View</a>
                        <a href="{{ route('material-product-subtypes.create') }}">Add</a>
                    </div>
                </li>

                <li class="master-tile">
                    <div class="master-title">Brand</div>
                    <div class="master-actions">
                        <a href="{{ route('brands.index') }}">View</a>
                        <a href="{{ route('brands.create') }}">Add</a>
                    </div>
                </li>

                <li class="master-tile">
                    <div class="master-title">Profile Type</div>
                    <div class="master-actions">
                        <a href="{{ route('profiletypes.index') }}">View</a>
                        <a href="{{ route('profiletypes.create') }}">Add</a>
                    </div>
                </li>
                <li class="master-tile">
                    <div class="master-title">Unit</div>
                    <div class="master-actions">
                        <a href="{{ route('unit.index') }}">Add/View</a>
                        
                    </div>
                </li>
                <li class="master-tile">
                    <div class="master-title">Size</div>
                    <div class="master-actions">
                        <a href="{{ route('thickness.size.index') }}">Add/View</a>
                        
                    </div>
                </li>

                <li class="master-tile">
                    <div class="master-title">Grade</div>
                    <div class="master-actions">
                        <a href="{{ route('grade.index') }}">Add/View</a>
                        
                    </div>
                </li>
                <li class="master-tile">
                    <div class="master-title">Standard</div>
                    <div class="master-actions">
                        <a href="{{ route('standard.index') }}">Add/View</a>
                        
                    </div>
                </li>
                


            </ul>
        </div>

        <div class="profile-avatar">A</div>
    </div>
</div>

<!-- ================= CONTENT ================= -->
<div class="dashboard-content">
    @yield('content')
</div>

<!-- ================= SCRIPTS ================= -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const toggle = document.getElementById('addMasterDropdown');
    const menu   = document.querySelector('.dropdown-menu.master-grid');
    const dropdown = bootstrap.Dropdown.getOrCreateInstance(toggle);

    toggle.addEventListener('shown.bs.dropdown', () => {
        const rect = toggle.getBoundingClientRect();
        menu.style.top  = (rect.bottom + 12) + 'px';
        menu.style.left = (rect.right - menu.offsetWidth) + 'px';
        document.body.classList.add('dropdown-open');
        menu.classList.add('show');  // Make it visible when dropdown is shown
    });

    toggle.addEventListener('hidden.bs.dropdown', () => {
        document.body.classList.remove('dropdown-open');
        menu.classList.remove('show');  // Hide it after dropdown is closed
    });

    document.querySelectorAll('.master-actions a').forEach(link => {
        link.addEventListener('click', () => dropdown.hide());
    });

});
</script>

</body>
</html>
