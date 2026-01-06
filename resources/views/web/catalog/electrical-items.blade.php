<form action="{{ route('supplier-products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf


    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Product Type *</label>
                <select class="form-select js-product-type" name="product_type">
                    <option value="">Select product type</option>
                    @foreach($electricalitems as $electricalitem)
                    <option value="{{ $electricalitem->id }}">{{ $electricalitem->product_name }}</option>
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


