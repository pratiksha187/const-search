@forelse($supplier_data as $supplier)

@php
    $initials = collect(explode(' ', $supplier->shop_name ?? 'Supplier'))
        ->map(fn($w) => strtoupper(substr($w,0,1)))
        ->take(2)
        ->join('');

    $materials = $supplier->material_categories ?? [];
@endphp

<div class="supplier-card">

    <div class="card-header">
        <div class="logo-circle">{{ $initials }}</div>

        <div class="supplier-info">
            <h5 class="supplier-name">{{ $supplier->shop_name }}</h5>
            <p class="supplier-meta">
                {{ ucfirst($supplier->primary_type ?? 'Supplier') }} • Pune
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
        <a href="{{ url('/supplier/profile/'.$supplier->id) }}" class="btn-outline">
            View Profile
        </a>

        <a href="javascript:void(0)"
           class="btn-primary btn-enquire"
           data-supplier-id="{{ $supplier->id }}"
           data-supplier-name="{{ $supplier->shop_name }}"
           data-categories='@json($supplier->material_categories)'>
            Enquire Now
        </a>
    </div>

</div>

@empty
<div class="no-results">
    <h5>No suppliers found</h5>
    <p>Try adjusting filters.</p>
</div>
@endforelse




<div class="modal fade" id="enquiryModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div>
          <h5 class="modal-title">Send Enquiry</h5>
          <small class="text-muted">To: <span id="modalSupplierName"></span></small>
        </div>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <form id="enquiryForm">
        <div class="modal-body">

          <input type="hidden" name="supplier_id" id="modalSupplierId">

          <div class="row g-3">

            <div class="col-md-6">
              <label class="form-label">Category</label>
              <select class="form-select" name="category" id="modalCategory">
                <option value="">Select Category</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Quantity</label>
              <input type="text" class="form-control" name="quantity" placeholder="200 bags">
            </div>

            <div class="col-12">
              <label class="form-label">Specs (type freely)</label>
              <textarea class="form-control" name="specs" rows="3"
                        placeholder="Brand, grade, size, approx qty..."></textarea>
              <small class="text-muted">Tip: Add brand preference, grade, pack size, usage, site urgency.</small>
            </div>

            <div class="col-md-6">
              <label class="form-label">Delivery location</label>
              <input type="text" class="form-control" name="delivery_location" placeholder="Khopoli site">
            </div>

            <div class="col-md-6">
              <label class="form-label">Required by</label>
              <input type="text" class="form-control" name="required_by" placeholder="Tomorrow">
            </div>

            <div class="col-md-6">
              <label class="form-label">Payment preference</label>
              <select class="form-select" name="payment_preference" id="modalPayment">
                <option value="cash">Cash</option>
                <option value="online">Online</option>
                <option value="credit">Credit (if available)</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Attachments</label>
              <input type="file" class="form-control" name="attachments[]" multiple>
            </div>

          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-dark px-4">Send enquiry</button>
        </div>
      </form>
    </div>
  </div>
</div>

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





