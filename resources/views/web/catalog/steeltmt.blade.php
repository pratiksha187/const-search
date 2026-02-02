<form action="{{ route('supplier-products.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="hidden"
       name="material_category_id"
       class="materialCategoryInput">
<div class="card-body">
    <div class="row g-3">

        <!-- PRODUCT TYPE -->
        <div class="col-md-6">
            <label class="form-label">Product Type *</label>
            <select class="form-select js-product-type" name="product_type">
                <option value="">Select product type</option>
                @foreach($steeltmt as $steel)
                    <option value="{{ $steel->id }}">{{ $steel->product_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- SUB TYPE -->
        <div class="col-md-6">
            <label class="form-label">Product Sub Type *</label>
            <select class="form-select js-product-subtype" name="product_subtype" disabled>
                <option value="">Select sub type</option>
            </select>
        </div>

        <!-- BRAND -->
        <div class="col-md-6">
            <label class="form-label">Brand *</label>
            <select class="form-select js-brand" name="brand" disabled>
                <option value="">Select brand</option>
            </select>
        </div>

        <!-- OTHER BRAND -->
        <div class="col-md-6 js-other-brand d-none">
            <label class="form-label">Add Brand Name</label>
            <input type="text" name="other_brand" class="form-control">
        </div>

        <!-- SPECIFICATION -->
        <div class="col-md-6 js-specification d-none">
            <label class="form-label">Specification</label>
            <input type="text" name="specification" class="form-control">
        </div>

        <!-- UNIT -->
        <div class="col-md-6">
            <label class="form-label">Unit *</label>
            <select class="form-select" name="unit">
                <option value="">Select unit</option>
                @foreach($units as $unit)
                    <option value="{{ $unit->id }}">{{ $unit->unitname }}</option>
                @endforeach
            </select>
        </div>

         <!-- Quntity -->
        <div class="col-md-6 js-quntity">
            <label class="form-label">Quntity</label>
            <input type="text" name="quntity" class="form-control">
        </div>
        <!-- Size -->
        <div class="col-md-6">
            <label class="form-label">Size *</label>
            <select class="form-select" name="unit">
                <option value="">Select Size</option>
                @foreach($thickness_size as $Size)
                    <option value="{{ $Size->id }}">{{ $Size->thickness_size }}</option>
                @endforeach
            </select>
        </div>
        <!-- PRICE -->
        <div class="col-md-6">
            <label class="form-label">Price (₹)</label>
            <input type="number" name="price" class="form-control">
        </div>

        <!-- IMAGE -->
        <div class="col-md-6">
            <label class="form-label">Upload Photo</label>
            <input type="file" name="product_image" class="form-control" accept="image/*">
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

      

        <div class="col-md-12 text-end">
            <button class="btn btn-warning px-4">Save Product</button>
        </div>

    </div>
</div>
</form>
