@forelse($supplier_data as $supplier)

@php
    $initials = collect(explode(' ', $supplier->shop_name ?? 'Supplier'))
        ->map(fn($w) => strtoupper(substr($w,0,1)))
        ->take(2)
        ->join('');

    $materials = $supplier->material_categories ?? [];
@endphp
<style>
    .supplier-meta{
    font-size:13px;
    color:#475569;
}

.supplier-type{
    background:#eef2ff;
    color:#1d4ed8;
    font-weight:600;
    padding:6px 10px;
    border-radius:999px;
}

.location-text{
    display:flex;
    align-items:center;
    gap:6px;
    color:#64748b;
}

.location-text i{
    color:#ef4444;
}

</style>
<div class="supplier-card">

    <div class="card-header">
        <div class="logo-circle">
            @if(!empty($supplier->shop_logo))
                <img src="{{ asset('storage/'.$supplier->shop_logo) }}"
                    alt="{{ $supplier->shop_name }}"
                    class="shop-logo-img">
            @else
                {{ $initials }}
            @endif
        </div>

        <div class="supplier-info">
            <h5 class="supplier-name">{{ $supplier->shop_name }}</h5>
            <p class="supplier-meta d-flex align-items-center flex-wrap gap-2">
                <span class="badge supplier-type">
                    {{ ucfirst($supplier->primary_type ?? 'Supplier') }}
                </span>

                <span class="location-text">
                    <i class="bi bi-geo-alt-fill"></i>
                    {{$supplier->statename}} • {{$supplier->regionname}} • {{$supplier->cityname}}
                </span>
            </p>

        </div>

        <div class="badges">
            <span class="badge featured">FEATURED</span>
            <span class="badge verified">VERIFIED</span>
        </div>
    </div>

    <div class="product-tags">
        @forelse($materials as $mat)
            <span>🧱 {{ $mat['name'] }}</span>
        @empty
            <span class="muted">Materials not listed</span>
        @endforelse
    </div>

    <div class="info-tags">
        <span>🚚 Delivery</span>
        <span>💳 Credit {{ $supplier->credit_days_value ?? 'N/A' }}</span>
        <span class="distance">📍 {{ $supplier->maximum_distance ?? 0 }} km</span>
    </div>

   <div class="card-actions">
    <a href="javascript:void(0)"
       class="btn-outline btn-view-profile"
       data-url="{{ url('/supplier/profile/'.$supplier->id) }}">
        View Profile
    </a>
</div>


</div>

@empty
<div class="no-results">
    <h5>No suppliers found</h5>
    <p>Try adjusting filters.</p>
</div>
@endforelse



<!-- LOGIN MODAL -->
<div class="modal fade" id="loginModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login Required</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <p>Please login to send enquiry.</p>
        <a href="{{ route('login_register') }}" class="btn btn-dark w-100 mb-2">
            Login
        </a>
        <a href="{{ route('login_register') }}" class="btn btn-outline-dark w-100">
            Create Account
        </a>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>





