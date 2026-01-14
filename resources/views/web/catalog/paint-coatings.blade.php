

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
