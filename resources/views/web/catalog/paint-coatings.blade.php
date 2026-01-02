

<form action="{{ route('supplier-products.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="card shadow-sm">
    <div class="card-body">
        <div class="row g-3">

            {{-- PRODUCT TYPE --}}
            <div class="col-md-6">
                <label class="form-label">Product Type *</label>
                <select class="form-select js-product-type" name="product_type" required>
                    <option value="">Select product type</option>
                    @foreach($paintcoating as $paint)
                        <option value="{{ $paint->id }}">{{ $paint->product_name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- PRODUCT SUB TYPE --}}
            <div class="col-md-6">
                <label class="form-label">Product Sub Type *</label>
                <select class="form-select js-product-subtype" name="product_subtype" disabled required>
                    <option value="">Select sub type</option>
                </select>
            </div>

            {{-- BRAND --}}
            <div class="col-md-6">
                <label class="form-label">Brand *</label>
                <select class="form-select js-brand" name="brand" disabled required>
                    <option value="">Select brand</option>
                </select>
            </div>

            {{-- OTHER BRAND --}}
            <div class="col-md-6 js-other-brand d-none">
                <label class="form-label">Add Brand Name</label>
                <input type="text" name="other_brand" class="form-control" placeholder="Enter brand name">
            </div>

            {{-- SPECIFICATION --}}
            <div class="col-md-6 js-specification d-none">
                <label class="form-label">Specification</label>
                <input type="text" name="specification" class="form-control" placeholder="e.g. Matt, 10L, WB">
            </div>

            {{-- PROFILE TYPE --}}
            <div class="col-md-6">
                <label class="form-label">Profile Type *</label>
                <select class="form-select js-profile-type" name="profile_type" disabled required>
                    <option value="">Select profile type</option>
                </select>
            </div>

            {{-- UNIT --}}
            <div class="col-md-6">
                <label class="form-label">Unit *</label>
                <select class="form-select" name="unit" required>
                    <option value="">Select unit</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}">{{ $unit->unitname }}</option>
                    @endforeach
                </select>
            </div>

            {{-- SIZE / GRADE --}}
            <div class="col-md-6">
                <label class="form-label">Size / Grade</label>
                <select class="form-select" name="thickness_size">
                    <option value="">Select Size / Grade</option>
                    @foreach($thickness_size as $size)
                        <option value="{{ $size->id }}">{{ $size->thickness_size }}</option>
                    @endforeach
                </select>
            </div>

            {{-- INSTALLATION --}}
            <div class="col-md-6">
                <label class="form-label">Installation Included</label>
                <select class="form-select" name="installation_included">
                    <option value="">Select option</option>
                    <option value="yes">Yes</option>
                    <option value="no">No</option>
                </select>
            </div>

            {{-- PRICE --}}
            <div class="col-md-6">
                <label class="form-label">Price per Unit (₹)</label>
                <input type="number" name="price" class="form-control" min="0" required>
            </div>

            {{-- GST --}}
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

            {{-- DELIVERY --}}
            <div class="col-md-4">
                <label class="form-label">Delivery Time (Days)</label>
                <input type="number" name="delivery_time" class="form-control">
            </div>

            {{-- PAYMENT TYPE --}}
            <div class="col-md-4">
                <label class="form-label">💳 Payment Type</label>
                <select class="form-select" name="payment_type">
                    <option value="">Select payment type</option>
                    @foreach($delivery_type as $delivery)
                        <option value="{{ $delivery->id }}">{{ $delivery->type }}</option>
                    @endforeach
                </select>
            </div>

            {{-- IMAGE --}}
            <div class="col-md-6">
                <label class="form-label">Upload Photo</label>
                <input type="file" name="product_image" class="form-control" accept="image/*">
            </div>

            {{-- SUBMIT --}}
            <div class="col-md-12 text-end mt-3">
                <button class="btn btn-warning px-4">💾 Save Product</button>
            </div>

        </div>
    </div>
</div>

</form>

<!-- <script>
document.addEventListener('DOMContentLoaded', () => {

    let subtypeReq, brandReq, profileReq;

    document.addEventListener('change', async (e) => {

        const form = e.target.closest('form');
        if (!form) return;

        /* PRODUCT TYPE */
        if (e.target.classList.contains('js-product-type')) {

            const productId = e.target.value;
            const subtype = form.querySelector('.js-product-subtype');
            const brand   = form.querySelector('.js-brand');

            subtype.innerHTML = '<option>Loading...</option>';
            brand.innerHTML   = '<option>Loading...</option>';
            subtype.disabled = brand.disabled = true;

            if (!productId) return;

            subtypeReq?.abort();
            brandReq?.abort();

            subtypeReq = new AbortController();
            brandReq   = new AbortController();

            try {
                const [subtypes, brands] = await Promise.all([
                    fetch(`/get-product-subtypes/${productId}`, { signal: subtypeReq.signal }).then(r => r.json()),
                    fetch(`/get-brands/${productId}`, { signal: brandReq.signal }).then(r => r.json())
                ]);

                subtype.innerHTML = '<option value="">Select sub type</option>';
                subtypes.forEach(s =>
                    subtype.insertAdjacentHTML('beforeend', `<option value="${s.id}">${s.material_subproduct}</option>`)
                );
                subtype.disabled = false;

                brand.innerHTML = '<option value="">Select brand</option>';
                brands.forEach(b =>
                    brand.insertAdjacentHTML('beforeend', `<option value="${b.id}">${b.name}</option>`)
                );
                brand.disabled = false;

            } catch (err) {
                if (err.name !== 'AbortError') console.error(err);
            }
        }

        /* BRAND */
        if (e.target.classList.contains('js-brand')) {

            const spec = form.querySelector('.js-specification');
            const other = form.querySelector('.js-other-brand');

            spec.classList.add('d-none');
            other.classList.add('d-none');

            if (!e.target.value) return;

            spec.classList.remove('d-none');

            if (e.target.options[e.target.selectedIndex].text === 'Others') {
                other.classList.remove('d-none');
            }
        }

        /* PRODUCT SUBTYPE */
        if (e.target.classList.contains('js-product-subtype')) {

            const profile = form.querySelector('.js-profile-type');
            const subId = e.target.value;

            profile.innerHTML = '<option>Loading...</option>';
            profile.disabled = true;

            if (!subId) return;

            profileReq?.abort();
            profileReq = new AbortController();

            try {
                const data = await fetch(`/get-profile-types/${subId}`, { signal: profileReq.signal }).then(r => r.json());

                profile.innerHTML = '<option value="">Select profile type</option>';
                data.forEach(p =>
                    profile.insertAdjacentHTML('beforeend', `<option value="${p.id}">${p.type}</option>`)
                );
                profile.disabled = false;

            } catch (err) {
                if (err.name !== 'AbortError') console.error(err);
            }
        }
    });
});
</script> -->
