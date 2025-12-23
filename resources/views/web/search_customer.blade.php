@extends('layouts.custapp')
@section('title', 'Search Vendors')

@section('content')
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-blue: #2563eb;
            --primary-indigo: #4f46e5;
            --primary-orange: #f97316;
            --success-green: #10b981;
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #eff6ff 50%, #f8fafc 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-gradient);
            color: #1e293b;
            min-height: 100vh;
        }

        /* HEADER */
        .header {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(15, 23, 42, 0.05);
        }

        .logo-box {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-indigo));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 800;
            font-size: 18px;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .brand-title {
            background: linear-gradient(135deg, #0f172a 0%, #1e40af 50%, #0f172a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 24px;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-indigo));
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 24px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-gradient-primary:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
            color: white;
        }

        /* BREADCRUMB */
        .breadcrumb-section {
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
        }

        /* FILTER SIDEBAR */
        .filter-sidebar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.6);
            padding: 24px;
            position: sticky;
            top: 100px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        }

        .filter-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(226, 232, 240, 0.6);
            margin-bottom: 24px;
        }

        .filter-icon-box {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-indigo));
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .filter-category-item {
            padding: 12px;
            border-radius: 12px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 8px;
        }

        .filter-category-item:hover {
            background: #f8fafc;
            border-color: #e2e8f0;
        }

        .filter-category-item.active {
            background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
            border-color: #93c5fd;
        }

        .filter-category-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            border-radius: 8px;
            cursor: pointer;
        }

        /* SEARCH BAR */
        .search-section {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.6);
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        }

        .form-control-custom {
            padding: 14px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .form-control-custom:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .form-select-custom {
            padding: 14px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-select-custom:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
        }

        .quick-filters {
            padding-top: 20px;
            margin-top: 20px;
            border-top: 1px solid rgba(226, 232, 240, 0.6);
        }

        .quick-filter-btn {
            padding: 8px 16px;
            background: #f1f5f9;
            border: none;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            color: #475569;
            transition: all 0.3s ease;
            margin: 4px;
        }

        .quick-filter-btn:hover {
            background: #dbeafe;
            color: var(--primary-blue);
            transform: scale(1.05);
        }

        /* VENDOR CARD */
        .vendor-card {
            background: white;
            border-radius: 16px;
            border: 1px solid rgba(226, 232, 240, 0.6);
            padding:14px;
            margin-bottom: 14px;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .vendor-card:hover {
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.15);
            border-color: rgba(147, 197, 253, 0.6);
            transform: translateY(-2px);
        }

        .premium-badge {
            position: absolute;
            top: 0;
            right: 0;
            background: linear-gradient(135deg, #fbbf24, #f97316);
            color: white;
            padding:4px 12px;
             font-size:10px;
            font-weight: 800;
            border-bottom-left-radius: 16px;
            border-top-right-radius: 24px;
            box-shadow: 0 4px 15px rgba(251, 191, 36, 0.4);
        }

        .vendor-avatar {
           width:64px;
             height:64px;
            border-radius:12px;
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-indigo), #7c3aed);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
             font-size:24px;
            font-weight: 800;
            position: relative;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.4);
            transition: all 0.5s ease;
        }

        .vendor-card:hover .vendor-avatar {
            transform: scale(1.08);
            box-shadow: 0 15px 40px rgba(37, 99, 235, 0.5);
        }

        .online-badge {
            position: absolute;
            bottom: -4px;
            right: -4px;
            width: 28px;
            height: 28px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .online-indicator {
            width: 20px;
            height: 20px;
            background: var(--success-green);
            border-radius: 50%;
            border: 2px solid white;
        }

        .vendor-name {
           font-size:16px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom:4px;
            transition: color 0.3s ease;
        }

        .vendor-card:hover .vendor-name {
            color: var(--primary-blue);
        }

        .category-badge {
            background: linear-gradient(135deg, #fff7ed, #fed7aa);
            color: #c2410c;
            padding:4px 10px;
            border-radius: 20px;
             font-size:11px;
            font-weight: 700;
            border: 1px solid #fdba74;
        }

        .rating-stars {
            color: #fbbf24;
             font-size:13px;
        }

        .rating-number {
             font-size:14px;
            font-weight: 800;
            color: #0f172a;
        }

        .top-rated-badge {
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            color: #065f46;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .contact-info-section {
            background: linear-gradient(135deg, #f8fafc, #eff6ff);
            border-radius: 12px;
            padding: 10px;
            border: 1px solid #e2e8f0;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            color: #334155;
            font-weight: 500;
        }

        .contact-icon-box {
            width:26px;
             height:26px;
            background: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .btn-interested {
            background: linear-gradient(135deg, #f97316, #ea580c);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.3);
        }

        .btn-interested:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(249, 115, 22, 0.4);
            color: white;
        }

        .btn-contact {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-indigo));
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
        }

        .btn-contact:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
            color: white;
        }

        .btn-profile {
            background: transparent;
            border: 2px solid #e2e8f0;
            color: #475569;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        .btn-profile:hover {
            border-color: #93c5fd;
            background: #eff6ff;
            color: var(--primary-blue);
            transform: scale(1.05);
        }

        /* MODAL STYLING */
        .modal-content {
            border-radius: 24px;
            border: none;
            overflow: hidden;
        }

        .modal-header-gradient {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-indigo), #7c3aed);
            color: white;
            padding: 32px;
            position: relative;
            overflow: hidden;
        }

        .modal-header-gradient::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .modal-header-gradient::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .payment-section {
            background: linear-gradient(135deg, var(--success-green), #059669, #047857);
            border-radius: 16px;
            padding: 24px;
            border: 2px solid #10b981;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }

        .payment-section::before {
            content: '';
            position: absolute;
            top: -80px;
            right: -80px;
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .price-tag {
            font-size: 40px;
            font-weight: 800;
            color: white;
        }

        /* EMPTY STATE */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            border: 1px solid rgba(226, 232, 240, 0.6);
        }

        .empty-icon {
            font-size: 80px;
            margin-bottom: 24px;
        }

        /* ANIMATIONS */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* RESPONSIVE */
        @media (max-width: 991px) {
            .filter-sidebar {
                position: relative;
                top: 0;
                margin-bottom: 24px;
            }
        }

        @media (max-width: 768px) {
            .vendor-avatar {
                width: 80px;
                height: 80px;
                font-size: 28px;
            }

            .vendor-name {
                font-size: 18px;
            }

            .btn-interested,
            .btn-contact,
            .btn-profile{
                padding:8px 14px;
                font-size:13px;
                border-radius:10px;
            }

        }

        /* CUSTOM SCROLLBAR */
        ::-webkit-scrollbar {
            width: 10px;
        }
        .dashboard-content {
            margin-top: 66px;
            padding: 30px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-blue), var(--primary-indigo));
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #1d4ed8, #4338ca);
        }


        .work-type-toggle {
    font-size:14px;
}

.toggle-icon {
    font-size:13px;
    transition: transform .2s ease;
}

.work-type-toggle.active .toggle-icon {
    transform: rotate(180deg);
}

.row {
    --bs-gutter-x: 3.5rem;
    --bs-gutter-y: 0;
    display: flex;
    flex-wrap: wrap;
    margin-top: calc(-1 * var(--bs-gutter-y));
    margin-right: calc(-.5 * var(--bs-gutter-x));
    margin-left: calc(-.5 * var(--bs-gutter-x));
}
    </style>

    <!-- MAIN CONTENT -->
    <div class="container-fluid px-4 py-4">
        <div class="row g-4">
            
            <!-- FILTER SIDEBAR -->
            <div class="col-lg-3">
                <div class="filter-sidebar">
                    <div class="filter-header">
                        <div class="filter-icon-box">
                            <i class="bi bi-funnel-fill"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Smart Filters</h5>
                            <small class="text-muted">Refine your search</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0">Work Category</h6>
                            <span class="badge bg-primary rounded-pill" id="categoryCount">0</span>
                        </div>

                        <div id="categoryFilters">
                            @foreach($work_types as $work)
                            <div class="mb-2">

                                <!-- WORK TYPE -->
                                <label class="filter-category-item d-flex align-items-center gap-3">
                                    <input type="checkbox"
                                        class="form-check-input m-0 category-check"
                                        value="{{ $work->id }}">

                                    <div class="category-icon">
                                        <i class="bi {{ $work->icon }}"></i>
                                    </div>

                                    <span class="fw-semibold">{{ $work->work_type }}</span>
                                </label>

                                <!-- WORK SUBTYPES -->
                                <div class="ms-5 mt-2 d-none subtype-box" data-type="{{ $work->id }}">
                                    @foreach(
                                        DB::table('work_subtypes')
                                            ->where('work_type_id', $work->id)
                                            ->get() as $sub
                                    )
                                    <label class="d-flex align-items-center gap-2 mb-1 small">
                                        <input type="checkbox"
                                            class="form-check-input subtype-check"
                                            value="{{ $sub->id }}">
                                        {{ $sub->work_subtype }}
                                    </label>
                                    @endforeach
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>



                    <!-- Rating Filter -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Minimum Rating</h6>
                        <div>
                            <label class="filter-category-item d-flex align-items-center gap-3">
                                <input type="radio" name="rating" class="form-check-input m-0">
                                <span>⭐⭐⭐⭐⭐</span>
                                <span class="fw-semibold">4.5 & above</span>
                            </label>
                            <label class="filter-category-item d-flex align-items-center gap-3">
                                <input type="radio" name="rating" class="form-check-input m-0">
                                <span>⭐⭐⭐⭐</span>
                                <span class="fw-semibold">4.0 & above</span>
                            </label>
                            <label class="filter-category-item d-flex align-items-center gap-3">
                                <input type="radio" name="rating" class="form-check-input m-0">
                                <span>⭐⭐⭐</span>
                                <span class="fw-semibold">3.5 & above</span>
                            </label>
                        </div>
                    </div>

                    <!-- Verified Only -->
                    <div class="mb-4">
                        <label class="filter-category-item d-flex align-items-center gap-3" style="background: rgba(16, 185, 129, 0.05); border-color: rgba(16, 185, 129, 0.2);">
                            <input type="checkbox" class="form-check-input m-0">
                            <i class="bi bi-patch-check-fill text-success"></i>
                            <span class="fw-bold">Verified Vendors Only</span>
                        </label>
                    </div>

                    <button class="btn btn-gradient-primary w-100 py-3 fw-bold" onclick="applyFilters()">
                        Apply Filters
                    </button>
                    <button class="btn btn-link w-100 mt-2 text-secondary fw-semibold" onclick="resetFilters()">
                        Reset All
                    </button>
                </div>
            </div>

            <!-- MAIN CONTENT AREA -->
            <div class="col-lg-9">
                
                <!-- SEARCH BAR -->
                <div class="search-section">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-bold small d-flex align-items-center gap-2">
                                <i class="bi bi-search text-primary"></i>
                                Search Location
                            </label>
                            <input type="text" class="form-control form-control-custom" placeholder="Enter city, area or landmark...">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small">State / Region</label>
                            <select class="form-select form-select-custom" id="stateSelect">
                                <option value="">All States</option>
                                <option value="Maharashtra">Maharashtra</option>
                                <option value="Delhi">Delhi</option>
                                <option value="Karnataka">Karnataka</option>
                                <option value="Gujarat">Gujarat</option>
                                <option value="Rajasthan">Rajasthan</option>
                                <option value="Tamil Nadu">Tamil Nadu</option>
                                <option value="Kerala">Kerala</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold small d-flex align-items-center gap-2">
                                <i class="bi bi-sliders text-primary"></i>
                                Sort By
                            </label>
                            <select class="form-select form-select-custom" id="sortSelect">
                                <option value="recommended">✨ Recommended</option>
                                <option value="rating">⭐ Highest Rated</option>
                                <option value="reviews">💬 Most Reviews</option>
                                <option value="experience">🏆 Most Experience</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex gap-2 align-items-end">
                            <button class="btn btn-gradient-primary flex-grow-1" onclick="searchVendors()">
                                <i class="bi bi-search"></i>
                            </button>
                            <button class="btn btn-dark" onclick="clearSearch()">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Quick Filters -->
                    
                </div>

                <!-- RESULTS HEADER -->
                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-1"><span id="vendorCount">{{ $projects->count() }}</span> Professional Vendors</h3>
                            <p class="text-muted mb-0 d-flex align-items-center gap-2">
                                <span class="badge bg-success rounded-circle p-1 pulse-animation" style="width: 10px; height: 10px;"></span>
                                Verified and ready to serve
                            </p>
                        </div>
                        <div>
                            <span class="badge bg-primary px-3 py-2">✨ Premium Results</span>
                        </div>
                    </div>
                </div>

               @foreach($projects as $project)

<div class="vendor-card"
     data-category="{{ $project->projecttype_name }}"
     data-state="{{ $project->state_name ?? '' }}">

    <span class="premium-badge">
        <i class="bi bi-star-fill me-1"></i>VERIFIED PRO
    </span>

    <div class="row">

        <!-- AVATAR -->
        <div class="col-auto">
            <div class="vendor-avatar">
                {{ strtoupper(substr($project->contact_name,0,1)) }}
                <div class="online-badge">
                    <div class="online-indicator"></div>
                </div>
            </div>
        </div>

        <!-- CONTENT -->
        <div class="col">

            <!-- NAME -->
            <h3 class="vendor-name">
                {{ strtoupper($project->contact_name) }}
            </h3>

            <!-- CATEGORY + TITLE -->
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <span class="category-badge">
                    {{ $project->projecttype_name }}
                </span>

                <span class="text-muted">•</span>

                <div class="d-flex align-items-center gap-1">
                    <i class="bi bi-briefcase-fill text-primary"></i>
                    <span class="fw-semibold small">
                        {{ $project->title }}
                    </span>
                </div>
            </div>

            <!-- RATING (STATIC / FUTURE DYNAMIC) -->
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="rating-stars">★★★★★</span>
                    <span class="rating-number">4.8</span>
                    <span class="text-muted small">(156 reviews)</span>
                </div>
                <span class="top-rated-badge">
                    <i class="bi bi-graph-up-arrow me-1"></i>Top Rated
                </span>
            </div>

            <!-- CONTACT + ACTION -->
            <div class="row align-items-center mt-3">

                <!-- LEFT -->
                <div class="col-md-6">
                    <div class="contact-info-section">
                        <div class="row g-2">

                            <div class="col-md-6">
                                <div class="contact-item">
                                    <div class="contact-icon-box">
                                        <i class="bi bi-geo-alt-fill text-primary"></i>
                                    </div>
                                    <span>
                                        
                                       
                                    </span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="contact-item">
                                    <div class="contact-icon-box">
                                        <i class="bi bi-telephone-fill text-success"></i>
                                    </div>
                                    <span>{{ $project->mobile }}</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="contact-item">
                                    <div class="contact-icon-box">
                                        <i class="bi bi-envelope-fill text-warning"></i>
                                    </div>
                                    <span>{{ $project->email }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- RIGHT -->
                <div class="col-md-5 d-flex justify-content-end mt-3 mt-md-0">
                    <button class="btn btn-interested px-4"
                        onclick="handleInterested(
                            {{ $project->id }},
                            '{{ addslashes($project->contact_name) }}',
                            '{{ addslashes($project->title) }}',
                            '{{ addslashes($project->projecttype_name) }}'
                        )">
                        ❤️ I'm Interested
                    </button>
                </div>

            </div>

        </div>
    </div>
</div>

@endforeach

                <!-- EMPTY STATE (Hidden by default) -->
                <div class="empty-state d-none" id="emptyState">
                    <div class="empty-icon">🔍</div>
                    <h3 class="fw-bold mb-3">No vendors found</h3>
                    <p class="text-muted mb-4">We couldn't find any vendors matching your criteria.<br>Try adjusting your filters or search terms.</p>
                    <button class="btn btn-gradient-primary px-5 py-3" onclick="resetFilters()">Clear All Filters</button>
                </div>

            </div>
        </div>
    </div>

    <!-- VENDOR MODAL -->
    <div class="modal fade" id="vendorModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header-gradient">
                    <div class="d-flex align-items-center gap-3 position-relative">
                        <div style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-sparkles" style="font-size: 24px;"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Premium Vendor Profile</h5>
                            <small style="color: rgba(255,255,255,0.8);">Complete professional details</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row mb-4">
                        <div class="col-auto">
                            <div class="vendor-avatar" style="width: 112px; height: 112px; font-size: 48px;">
                                <span id="modalAvatar">R</span>
                                <div class="online-badge" style="bottom: -8px; right: -8px;">
                                    <div class="online-indicator" style="width: 24px; height: 24px;"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <h4 class="fw-bold mb-2" id="modalName">Rajesh Kumar</h4>
                            <span class="category-badge mb-3 d-inline-block" id="modalCategory">Construction</span>
                            <p class="text-muted mb-3" id="modalBusiness">Kumar Constructions</p>
                            <div class="d-flex flex-wrap gap-3">
                                <div class="px-4 py-2 rounded-3" style="background: #eff6ff; border: 1px solid #bfdbfe;">
                                    <i class="bi bi-award-fill text-primary me-2"></i>
                                    <span class="fw-bold text-primary">12 years experience</span>
                                </div>
                                <div class="px-4 py-2 rounded-3" style="background: #d1fae5; border: 1px solid #a7f3d0;">
                                    <i class="bi bi-shield-check text-success me-2"></i>
                                    <span class="fw-bold text-success">Verified Pro</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="payment-section mb-4">
                        <div class="row align-items-center position-relative">
                            <div class="col-md-8">
                                <p class="text-white fw-semibold mb-2 opacity-90">Unlock Full Access</p>
                                <p class="small text-white mb-3 opacity-75">Connect directly with this professional vendor</p>
                                <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3" style="background: rgba(255,255,255,0.15); backdrop-filter: blur(10px);">
                                    <i class="bi bi-check-circle-fill text-white"></i>
                                    <small class="text-white">Instant contact • Priority support • 30-day guarantee</small>
                                </div>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="price-tag">₹500</div>
                                <small class="text-white opacity-75">one-time fee</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <button class="btn btn-profile flex-grow-1 py-3" data-bs-dismiss="modal">Maybe Later</button>
                        <button class="btn btn-contact flex-grow-1 py-3" id="payNowBtn" style="background: linear-gradient(135deg, var(--success-green), #059669);">
                            💳 Pay ₹500 Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AUTH MODAL -->
    <div class="modal fade" id="authModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header-gradient text-center position-relative">
                    <div class="w-100">
                        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                            <i class="bi bi-shield-lock" style="font-size: 40px;"></i>
                        </div>
                        <h5 class="fw-bold mb-2">Authentication Required</h5>
                        <p class="mb-0" style="color: rgba(255,255,255,0.8);">Sign in to access premium vendor services</p>
                    </div>
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="text-center mb-4">
                        <h6 class="fw-bold mb-2">Join VendorHub Pro</h6>
                        <p class="text-muted small">Get instant access to verified vendors, exclusive deals, and priority support.</p>
                    </div>

                    <div class="p-4 rounded-3 mb-4" style="background: linear-gradient(135deg, #f8fafc, #eff6ff); border: 1px solid #e2e8f0;">
                        <p class="fw-semibold small text-muted mb-3">What you'll get:</p>
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex align-items-start gap-2 small">
                                <span class="text-success fw-bold">✓</span>
                                <span>Direct access to 1000+ verified vendors</span>
                            </div>
                            <div class="d-flex align-items-start gap-2 small">
                                <span class="text-success fw-bold">✓</span>
                                <span>Priority customer support 24/7</span>
                            </div>
                            <div class="d-flex align-items-start gap-2 small">
                                <span class="text-success fw-bold">✓</span>
                                <span>Exclusive member discounts up to 20%</span>
                            </div>
                            <div class="d-flex align-items-start gap-2 small">
                                <span class="text-success fw-bold">✓</span>
                                <span>Secure payment protection</span>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button class="btn btn-gradient-primary py-3 fw-bold">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Sign In to Continue
                        </button>
                        <button class="btn btn-profile py-3 fw-bold">
                            <i class="bi bi-person-plus me-2"></i>Create Free Account
                        </button>
                    </div>

                    <div class="text-center">
                        <small class="text-muted">
                            By continuing, you agree to our 
                            <a href="#" class="text-primary fw-semibold">Terms of Service</a> and 
                            <a href="#" class="text-primary fw-semibold">Privacy Policy</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (Optional - for easier DOM manipulation) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    function handleInterested(id, name, business, work) {
        $.ajax({
            url: "{{ route('vendor.interest.check') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                vendor_id: id
            },
            success: function (res) {
                openVendorModal(
                    id,
                    name,
                    business,
                    work,
                    res.payment_required === true
                );
            },
            error: function (xhr) {
                // ✅ UNAUTHORIZED → LOGIN POPUP
                if (xhr.status === 401) {
                    new bootstrap.Modal(
                        document.getElementById('authModal')
                    ).show();
                } else {
                    alert('Something went wrong. Please try again.');
                }
            }
        });
    }


    function openVendorModal(id, name, business, work, showPayment) {
        $('#vendorName').text(name);
        $('#vendorBusiness').text(business);
        $('#vendorWork').text(work);

        if (showPayment) {
            $('#paymentSection').show();
            $('#payNowBtn').show().data('id', id);
        } else {
            $('#paymentSection').hide();
            $('#payNowBtn').hide();
        }

        new bootstrap.Modal(document.getElementById('vendorModal')).show();
    }

    $('#payNowBtn').on('click', function () {
        let id = $(this).data('id');
        window.location.href = "{{ route('razorpay.form') }}?vendor_id=" + btoa(id);
    });
    </script>

    @if(session('payment_success') && session('unlock_vendor'))
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let vendor = @json(session('unlock_vendor'));
        openVendorModal(
            vendor.id,
            vendor.name,
            vendor.business_name,
            vendor.work_type,
            false
        );
    });
    </script>

    @endif
    <script>

    document.querySelectorAll('.category-check').forEach(cb => {
        cb.addEventListener('change', function () {
            let box = document.querySelector(
                `.subtype-box[data-type="${this.value}"]`
            );

            if (box) {
                box.classList.toggle('d-none', !this.checked);
            }

            updateCategoryCount();
            filterVendors();
        });
    });

    function updateCategoryCount() {
        document.getElementById('categoryCount').innerText =
            document.querySelectorAll('.category-check:checked').length;
    }

    function filterVendors() {

        let selectedTypes = [];
        let selectedSubtypes = [];

        document.querySelectorAll('.category-check:checked')
            .forEach(cb => selectedTypes.push(cb.value));

        document.querySelectorAll('.subtype-check:checked')
            .forEach(cb => selectedSubtypes.push(parseInt(cb.value)));

        let visible = 0;

        document.querySelectorAll('.vendor-card').forEach(card => {

            let cardType = card.dataset.workType;
            let cardSubs = JSON.parse(card.dataset.workSubtypes || '[]');

            let typeMatch =
                selectedTypes.length === 0 ||
                selectedTypes.includes(cardType);

            let subtypeMatch =
                selectedSubtypes.length === 0 ||
                selectedSubtypes.some(id => cardSubs.includes(id));

            if (typeMatch && subtypeMatch) {
                card.style.display = 'block';
                visible++;
            } else {
                card.style.display = 'none';
            }
        });

        document.getElementById('vendorCount').innerText = visible;

        if (visible === 0) {
            vendorList.classList.add('d-none');
            emptyState.classList.remove('d-none');
        } else {
            vendorList.classList.remove('d-none');
            emptyState.classList.add('d-none');
        }
    }

    /* ===============================
    AUTO FILTER ON SUBTYPE CLICK
    =============================== */
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('subtype-check')) {
            filterVendors();
        }
    });
    </script>


@endsection