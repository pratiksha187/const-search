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

        <!-- NOTIFICATION -->
        <div class="notification-container position-relative">
            @php
                $vendor_id = session('user_id');
                $unreadCount = DB::table('vendor_notifications')->where('vendor_id', $vendor_id)->where('is_read', 0)->count();
                $notifications = DB::table('vendor_notifications')->where('vendor_id', $vendor_id)->orderBy('id','DESC')->limit(5)->get();
            @endphp

            <i class="bi bi-bell fs-4" onclick="toggleNotificationMenu(event)" style="cursor:pointer;"></i>

            @if($unreadCount > 0)
            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle rounded-pill">
                {{ $unreadCount }}
            </span>
            @endif

            <div class="notification-dropdown" id="notificationDropdown">
                <div class="fw-bold p-2 border-bottom text-center">Notifications</div>
                @forelse ($notifications as $note)
                    <a href="{{ route('vendor.read.notification', $note->id) }}">
                        <strong>{{ $note->title }}</strong><br>
                        <small class="text-muted">{{ Str::limit($note->message, 50) }}</small><br>
                        <small class="text-secondary">{{ \Carbon\Carbon::parse($note->created_at)->diffForHumans() }}</small>
                    </a>
                @empty
                    <div class="text-center text-muted py-3">No notifications</div>
                @endforelse
                <a href="{{ route('vendor.notifications') }}" class="text-primary border-top text-center py-2">View All</a>
            </div>
        </div>

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
