@extends('layouts.vendorapp')
@section('title', 'Search Vendors')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
/* ================= ROOT ================= */
:root{
    --primary-blue:#2563eb;
    --primary-indigo:#4f46e5;
    --primary-orange:#f97316;
    --success-green:#10b981;
    --bg-gradient:linear-gradient(135deg,#f8fafc 0%,#eff6ff 50%,#f8fafc 100%);
}
*{box-sizing:border-box}
body{
    font-family:'Inter',sans-serif;
    background:var(--bg-gradient);
    color:#1e293b;
}

/* ================= HEADER ================= */
.header{
    background:rgba(255,255,255,.9);
    backdrop-filter:blur(20px);
    border-bottom:1px solid #e2e8f0;
    position:sticky;
    top:0;
    z-index:1000;
}

/* ================= BUTTONS ================= */
.btn-gradient-primary{
    background:linear-gradient(135deg,var(--primary-blue),var(--primary-indigo));
    border:none;
    color:#fff;
    font-weight:600;
    border-radius:10px;
}
.btn-gradient-primary:hover{
    transform:scale(1.05);
    box-shadow:0 10px 25px rgba(37,99,235,.4);
}

/* ================= FILTER SIDEBAR ================= */
.filter-sidebar{
    background:#fff;
    border-radius:24px;
    border:1px solid #e2e8f0;
    padding:24px;
    position:sticky;
    top:100px;
}
.filter-header{
    display:flex;
    gap:12px;
    border-bottom:1px solid #e2e8f0;
    padding-bottom:20px;
    margin-bottom:24px;
}
.filter-icon-box{
    width:40px;height:40px;
    background:linear-gradient(135deg,var(--primary-blue),var(--primary-indigo));
    border-radius:12px;
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
}
.filter-category-item{
    padding:12px;
    border-radius:12px;
    cursor:pointer;
    border:2px solid transparent;
}
.filter-category-item:hover{
    background:#f8fafc;
    border-color:#e2e8f0;
}
.filter-category-item.active{
    background:#eff6ff;
    border-color:#93c5fd;
}

/* ================= SEARCH ================= */
.search-section{
    background:#fff;
    border-radius:24px;
    border:1px solid #e2e8f0;
    padding:24px;
    margin-bottom:24px;
}
.form-control-custom,
.form-select-custom{
    padding:14px 20px;
    border:2px solid #e2e8f0;
    border-radius:12px;
    font-weight:500;
}
.form-control-custom:focus,
.form-select-custom:focus{
    border-color:var(--primary-blue);
    box-shadow:0 0 0 4px rgba(37,99,235,.1);
}

/* ================= VENDOR CARD ================= */
.vendor-card{
    background:#fff;
    border-radius:16px;
    border:1px solid #e2e8f0;
    padding:14px;
    margin-bottom:14px;
    position:relative;
    transition:.3s ease;
}
.vendor-card:hover{
    transform:translateY(-2px);
    box-shadow:0 20px 60px rgba(15,23,42,.15);
}
.premium-badge{
    position:absolute;
    top:0;right:0;
    background:linear-gradient(135deg,#fbbf24,#f97316);
    color:#fff;
    font-size:10px;
    padding:4px 12px;
    font-weight:800;
    border-bottom-left-radius:16px;
}

/* ================= AVATAR ================= */
.vendor-avatar{
    width:64px;height:64px;
    border-radius:12px;
    background:linear-gradient(135deg,var(--primary-blue),var(--primary-indigo));
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    font-size:24px;
    font-weight:800;
    position:relative;
}
.online-badge{
    position:absolute;
    bottom:-4px;right:-4px;
    background:#fff;
    border-radius:50%;
    padding:3px;
}
.online-indicator{
    width:16px;height:16px;
    background:var(--success-green);
    border-radius:50%;
}

/* ================= TEXT ================= */
.vendor-name{
    font-size:16px;
    font-weight:800;
}
.category-badge{
    background:#fed7aa;
    color:#c2410c;
    padding:4px 10px;
    border-radius:20px;
    font-size:11px;
    font-weight:700;
}

/* ================= CONTACT ================= */
.contact-info-section{
    background:#f8fafc;
    border-radius:12px;
    padding:10px;
    border:1px solid #e2e8f0;
}
.contact-item{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:13px;
}
.contact-icon-box{
    width:26px;height:26px;
    background:#fff;
    border-radius:8px;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* ================= ACTION BUTTONS ================= */
.btn-interested{
    background:linear-gradient(135deg,#f97316,#ea580c);
    border:none;
    color:#fff;
    padding:12px 24px;
    border-radius:12px;
    font-weight:700;
}
.btn-interested:hover{
    transform:scale(1.05);
}

/* ================= MODAL ================= */
.modal-content{
    border-radius:24px;
    overflow:hidden;
}
.modal-header-gradient{
    background:linear-gradient(135deg,var(--primary-blue),var(--primary-indigo));
    color:#fff;
    padding:32px;
}
.payment-section{
    background:linear-gradient(135deg,var(--success-green),#059669);
    border-radius:16px;
    padding:24px;
    color:#fff;
}
.price-tag{
    font-size:40px;
    font-weight:800;
}

/* ================= EMPTY ================= */
.empty-state{
    text-align:center;
    padding:80px 20px;
    background:#fff;
    border-radius:24px;
    border:1px solid #e2e8f0;
}

/* ================= RESPONSIVE ================= */
@media(max-width:991px){
    .filter-sidebar{position:relative;top:0}
}
@media(max-width:768px){
    .vendor-avatar{width:80px;height:80px}
}
</style>

    <script>
    window.VENDOR_ID = @json($vendor_id);
</script>


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
                            <h3 class="fw-bold mb-1"><span id="vendorCount">{{ $projects->count() }}</span> Professional Lead</h3>
                            <p class="text-muted mb-0 d-flex align-items-center gap-2">
                                <span class="badge bg-success rounded-circle p-1 pulse-animation" style="width: 10px; height: 10px;"></span>
                                Verified and ready to serve
                            </p>
                        </div>
                     
                    </div>
                </div>

               @foreach($projects as $project)

                    <!-- <div class="vendor-card"
                        data-category="{{ $project->projecttype_name }}"
                        data-state="{{ $project->state_name ?? '' }}"> -->
                        <div class="vendor-card"
    data-work-type="{{ $project->project_type_id }}"
    data-title="{{ strtolower($project->title) }}"
    data-state="{{ strtolower($project->state ?? '') }}">


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

    <!-- Customer MODAL -->
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

            // FRONTEND CHECK
            if (!window.VENDOR_ID) {
                new bootstrap.Modal(
                    document.getElementById('authModal')
                ).show();
                return;
            }

            // BACKEND CHECK (DOUBLE SECURITY)
            $.ajax({
                url: "{{ route('vendor.interest.check') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    cust_id: id
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
                error: function () {
                    alert('Something went wrong');
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
        window.location.href = "{{ route('razorpay.form') }}?cust_id=" + btoa(id);
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

function applyFilters() {

    let selectedTypes = [];
    let searchText = document.querySelector('.form-control-custom')?.value.toLowerCase() || '';
    let state = document.getElementById('stateSelect')?.value.toLowerCase() || '';

    // collect selected categories
    document.querySelectorAll('.category-check:checked')
        .forEach(cb => selectedTypes.push(cb.value));

    let visible = 0;

    document.querySelectorAll('.vendor-card').forEach(card => {

        let cardType  = card.dataset.workType;
        let cardTitle = card.dataset.title || '';
        let cardState = card.dataset.state || '';

        let typeMatch =
            selectedTypes.length === 0 ||
            selectedTypes.includes(cardType);

        let textMatch =
            searchText === '' ||
            cardTitle.includes(searchText);

        let stateMatch =
            state === '' ||
            cardState.includes(state);

        if (typeMatch && textMatch && stateMatch) {
            card.style.display = 'block';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });

    // update count
    document.getElementById('vendorCount').innerText = visible;

    // empty state
    document.getElementById('emptyState')
        .classList.toggle('d-none', visible !== 0);
}

/* ===============================
CATEGORY TOGGLE + COUNT
=============================== */
function updateCategoryCount() {
    document.getElementById('categoryCount').innerText =
        document.querySelectorAll('.category-check:checked').length;
}

document.querySelectorAll('.category-check').forEach(cb => {
    cb.addEventListener('change', function () {

        let box = document.querySelector(
            `.subtype-box[data-type="${this.value}"]`
        );

        if (box) {
            box.classList.toggle('d-none', !this.checked);
        }

        updateCategoryCount();
        applyFilters();
    });
});

/* ===============================
AUTO FILTER EVENTS
=============================== */
document.querySelectorAll('.subtype-check')
    .forEach(el => el.addEventListener('change', applyFilters));

document.querySelector('.form-control-custom')
    ?.addEventListener('keyup', applyFilters);

document.getElementById('stateSelect')
    ?.addEventListener('change', applyFilters);

/* ===============================
SEARCH & CLEAR BUTTONS
=============================== */
function searchVendors() {
    applyFilters();
}

function clearSearch() {
    resetFilters();
}

/* ===============================
RESET FILTERS
=============================== */
function resetFilters() {

    document.querySelectorAll('input[type=checkbox]')
        .forEach(cb => cb.checked = false);

    document.querySelectorAll('.subtype-box')
        .forEach(b => b.classList.add('d-none'));

    document.querySelector('.form-control-custom').value = '';
    document.getElementById('stateSelect').value = '';

    updateCategoryCount();
    applyFilters();
}
</script>


@endsection