<div class="card shadow-sm mb-4">
    <div class="card-header fw-semibold">
        Add Product – Cement & Concrete
    </div>

    <div class="card-body">
        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Product Type *</label>
                <select class="form-select">
                    <option>Select product type</option>
                    <option>OPC Cement</option>
                    <option>PPC Cement</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Brand *</label>
                <select class="form-select">
                    <option>Select brand</option>
                    <option>ACC</option>
                    <option>UltraTech</option>
                    <option>Ambuja</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Unit *</label>
                <select class="form-select">
                    <option>Bag (50 Kg)</option>
                </select>
            </div>

            <div class="col-md-6">
                <label class="form-label">Price per Unit (₹)</label>
                <input type="number" class="form-control" placeholder="Enter price">
            </div>

            <div class="col-md-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox">
                    <label class="form-check-label">GST Included</label>
                </div>
            </div>

            <div class="col-md-12">
                <label class="form-label">Stock Availability</label>
                <select class="form-select">
                    <option>In Stock</option>
                    <option>Out of Stock</option>
                </select>
            </div>

            <div class="col-md-12 text-end">
                <button class="btn btn-warning px-4">
                    💾 Save Product
                </button>
            </div>
        </div>
    </div>
</div>

<!-- PRODUCT LIST -->
<div class="card shadow-sm">
    <div class="card-header fw-semibold">
        Products in Cement & Concrete (1)
    </div>

    <div class="card-body">
        <div class="border rounded p-3 d-flex justify-content-between align-items-center">
            <div>
                <strong>ACC OPC 43 Cement</strong><br>
                <small class="text-muted">Category: Cement & Concrete</small>
                <div class="mt-2">
                    <span class="badge bg-warning text-dark">₹400 / Bag (50 Kg)</span>
                    <span class="badge bg-success">GST Included</span>
                    <span class="badge bg-success">In Stock</span>
                </div>
            </div>
            <button class="btn btn-danger btn-sm">Delete</button>
        </div>
    </div>
</div>
