<form action="{{ route('supplier-products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Product Type *</label>
                <select class="form-select js-product-type" name="product_type">
                    <option value="">Select product type</option>
                    @foreach($pavers as $paver)
                    <option value="{{ $paver->id }}">{{ $paver->product_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Product Sub Type *</label>
                <select class="form-select js-product-subtype" name="product_subtype" disabled>
                    <option value="">Select sub type</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Brand *</label>
                <select class="form-select js-brand" name="brand" disabled>
                    <option value="">Select brand</option>
                </select>
            </div>
            <!-- ADD BRAND (ONLY FOR OTHER) -->
            <div class="col-md-6 js-other-brand d-none">
                <label class="form-label">Add Brand Name</label>
                <input type="text"
                    name="other_brand"
                    class="form-control"
                    placeholder="Enter brand name">
            </div>
            <!-- SPECIFICATION -->
            <div class="col-md-6 js-specification d-none">
                <label class="form-label">Specification</label>
                <input type="text"
                    name="specification"
                    class="form-control"
                    placeholder="Enter specification (e.g. 6mm, 10A)">
            </div>



            <div class="col-md-6">
                <label class="form-label">Unit *</label>
                <select class="form-select" name="unit">
                    <option value="">Select unit</option>
                    @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->unitname }}</option>
                    @endforeach
                </select>
            </div>

             <div class="col-md-6">
                <label class="form-label">Thickness</label>
                <select class="form-select" name="unit">
                    <option value="">Select unit</option>
                    @foreach($thickness_size as $size)
                    <option value="{{ $size->id }}">{{ $size->thickness_size }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Price per Unit (₹)</label>
                <input type="number" name="price" class="form-control">
            </div>
            <!-- UPLOAD PHOTO -->
            <div class="col-md-6">
                <label class="form-label">Upload Photo</label>
                <input type="file"
                    name="product_image"
                    class="form-control"
                    accept="image/*">
            </div>

            <!-- PRICE -->
            <div class="col-md-6">
                <label class="form-label">Price (₹)</label>
                <input type="number"
                    name="price"
                    class="form-control"
                    placeholder="Enter price per unit">
            </div>

            <!-- GST -->
            <div class="col-md-4">
                <label class="form-label">GST %</label>
                <select class="form-select" name="gst">
                    <option value="">Select GST</option>
                    <option value="0">0%</option>
                    <option value="5">5%</option>
                    <option value="12">12%</option>
                    <option value="18">18%</option>
                    <option value="28">28%</option>
                
                </select>
            </div>

            <!-- DELIVERY TIME -->
            <div class="col-md-4">
                <label class="form-label">Delivery Time (Days)</label>
                <input type="number"
                    name="delivery_time"
                    class="form-control"
                    placeholder="e.g. 3">
            </div>

            <!-- PAYMENT TYPE -->
            <div class="col-md-4">
                <label class="form-label">💳 Payment Type</label>
                <select class="form-select" name="payment_type">
                    <option value="">Select payment type</option>
                    @foreach($delivery_type as $delivery_types)
                    <option value="{{ $delivery_types->id }}">{{ $delivery_types->type }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-md-12 text-end">
                <button class="btn btn-warning px-4">💾 Save Product</button>
            </div>

        </div>
    </div>
    <!-- </div> -->
</form>





{{-- ================== CATEGORY TAB SCRIPT ================== --}}
<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
    
        const tabs  = document.querySelectorAll('#categoryTabs .list-group-item');
        const pages = document.querySelectorAll('.category-page');
    
        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                tabs.forEach(t => t.classList.remove('active'));
                pages.forEach(p => p.classList.remove('active'));
    
                this.classList.add('active');
    
                const slug = this.getAttribute('data-category');
                const target = document.getElementById('category-' + slug);
                if (target) target.classList.add('active');
            });
        });
    
    });
</script> -->

{{-- ================== COMMON DEPENDENCY JS ================== --}}
<!-- <script>
    document.addEventListener('change', function (e) {
    
        if (!e.target.classList.contains('js-product-type')) return;
    
        const form = e.target.closest('form');
        const subtype = form.querySelector('.js-product-subtype');
        const brand   = form.querySelector('.js-brand');
        const productId = e.target.value;
    
        subtype.innerHTML = '<option>Loading...</option>';
        brand.innerHTML   = '<option>Loading...</option>';
        subtype.disabled = true;
        brand.disabled   = true;
    
        if (!productId) return;
    
        fetch(`/get-product-subtypes/${productId}`)
            .then(res => res.json())
            .then(data => {
                subtype.innerHTML = '<option value="">Select sub type</option>';
                data.forEach(i => {
                    subtype.innerHTML += `<option value="${i.id}">${i.material_subproduct}</option>`;
                });
                subtype.disabled = false;
            });
    
        fetch(`/get-brands/${productId}`)
            .then(res => res.json())
            .then(data => {
                brand.innerHTML = '<option value="">Select brand</option>';
                data.forEach(b => {
                    brand.innerHTML += `<option value="${b.id}">${b.name}</option>`;
                });
                brand.disabled = false;
            });
    
    });
</script>
<script>
document.addEventListener('change', function (e) {

    if (!e.target.classList.contains('js-brand')) return;

    const form = e.target.closest('form');
    const specBox = form.querySelector('.js-specification');
    const otherBrandBox = form.querySelector('.js-other-brand');

    // Reset first
    specBox.classList.add('d-none');
    otherBrandBox.classList.add('d-none');

    if (!e.target.value) return;

    // Show specification for any brand
    specBox.classList.remove('d-none');

    // If "Other" selected
    if (e.target.value === '25') {
        otherBrandBox.classList.remove('d-none');
    }
});
</script> -->
