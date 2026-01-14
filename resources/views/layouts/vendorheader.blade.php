<!-- HEADER -->
<div class="main-header">

    <!-- Logo -->
    <a href="{{ route('vendordashboard') }}" class="d-flex align-items-center">
        <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro" loading="eager">
    </a>

    <!-- TOP MENU -->
    <div class="top-menu">
        <a href="{{ route('vendordashboard') }}" 
           class="{{ request()->is('vendordashboard') ? 'active' : '' }}">
           Dashboard
        </a>

        <a href="{{ route('search_customer') }}" 
           class="{{ request()->is('search-customer*') ? 'active' : '' }}">
           Lead Marketplace
        </a>
    </div>

    <!-- RIGHT SIDE -->
    <div class="d-flex align-items-center gap-3">

       

        <!-- PROFILE -->
        <div class="header-profile" onclick="toggleProfileMenu(event)">
            <img src="{{ session('user_image') ? asset('storage/'.session('user_image')) : asset('images/default-user.png') }}">
            <span class="header-profile-name">{{ session('user_name') }}</span>
        </div>

    </div>

</div>

<!-- PROFILE MENU -->
<div class="profile-dropdown" id="profileDropdown">
    <a href="/profile"><i class="bi bi-person"></i> My Profile</a>
    <a href="/projects"><i class="bi bi-briefcase"></i> My Projects</a>
    <a href="/logout"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>
