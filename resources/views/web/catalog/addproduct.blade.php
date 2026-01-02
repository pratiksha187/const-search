@extends('layouts.suppliersapp')

@section('title','Supplier Product Catalog')

@section('content')

<style>
.dashboard-content {
    padding: 24px;
    padding-top: 23px !important;
    min-height: 85vh;
}
.py-4 {
    padding-top: 4.5rem !important;
    padding-bottom: 1.5rem !important;
}

/* LEFT CATEGORY TABS */
.category-tabs .list-group-item {
    cursor: pointer;
    border-left: 4px solid transparent;
    transition: all .2s ease;
}
.category-tabs .list-group-item.active {
    background: #fff3e9;
    border-left-color: #f25c05;
    color: #f25c05;
    font-weight: 600;
}
.category-tabs .list-group-item:hover {
    background: #f8f9fa;
}

/* RIGHT CONTENT */
.category-page {
    display: none;
}
.category-page.active {
    display: block;
}
</style>

<div class="container-fluid py-4">

    <!-- HEADER -->
    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-1 fw-semibold">🧱 Supplier Product Catalog</h5>
            <small class="text-muted">
                Add products to your catalog. Select a category to begin.
            </small>
        </div>
    </div>

    <div class="row g-4">

        <!-- LEFT SIDEBAR -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    Material Categories
                </div>

                <ul class="list-group list-group-flush category-tabs" id="categoryTabs">
                    <li class="list-group-item active" data-target="ConstructionChemicals">Construction & Chemicals</li>
                    <li class="list-group-item" data-target="plumbing">Plumbing Materials</li>
                    <li class="list-group-item" data-target="electrical">Electrical Items</li>
                    <li class="list-group-item" data-target="doorswindows">Doors & Windows</li>
                    <li class="list-group-item" data-target="glassglazing">Glass & Glazing</li>
                    <li class="list-group-item" data-target="hardwaretools">Hardware & Tools</li>
                    <li class="list-group-item" data-target="machineries">Machineries & Equipments</li>
                    <li class="list-group-item" data-target="timberwood">Timber & Wood</li>
                    <li class="list-group-item" data-target="roofing">Roofing Materials </li>
                    <li class="list-group-item" data-target="pavers">Pavers & Kerbstones </li>
                    <li class="list-group-item" data-target="concreteproducts">Concrete Products</li>
                    <li class="list-group-item" data-target="roadsafety">Road Safety Products</li>
                    <li class="list-group-item" data-target="facadecladding">Facade & Cladding Materials</li>
                    <li class="list-group-item" data-target="scaffolding">Scaffolding</li>
                    <li class="list-group-item" data-target="hvacutilities">HVAC & Utilities</li>
                    <li class="list-group-item" data-target="readymix">Ready Mix Concrete</li>
                    <li class="list-group-item" data-target="paintcoating">Paint & Coatings</li>
                    <li class="list-group-item" data-target="tilesflooring">Tiles & Flooring	</li>
                    											
									

					
														


                    
                   
                </ul>
            </div>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="col-md-9">

            <!-- ConstructionChemicals -->
            <div class="category-page active" id="ConstructionChemicals">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Cement & Concrete</div>
                    <div class="card-body">
                        @include('web.catalog.construction-chemicals')
                    </div>
                </div>
            </div>

            <!-- STEEL -->
            <div class="category-page" id="steel">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Steel & TMT Bars</div>
                    <div class="card-body">
                        @include('web.catalog.static-form')
                    </div>
                </div>
            </div>

            <!-- TILES -->
            <div class="category-page" id="tiles">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Tiles & Flooring</div>
                    <div class="card-body">
                        @include('web.catalog.static-form')
                    </div>
                </div>
            </div>

            <!-- PAINT -->
            <div class="category-page" id="paint">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Paint & Coatings</div>
                    <div class="card-body">
                        @include('web.catalog.static-form')
                    </div>
                </div>
            </div>

            <!-- ELECTRICAL -->
            <div class="category-page" id="electrical">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Electrical Items</div>
                    <div class="card-body">
                        @include('web.catalog.electrical-items')
                    </div>
                </div>
            </div>

            <!-- PLUMBING -->
            <div class="category-page" id="plumbing">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Plumbing Materials</div>
                    <div class="card-body">
                        @include('web.catalog.plumbing-materials')
                    </div>
                </div>
            </div>

            <!-- doorswindows -->

            <div class="category-page" id="doorswindows">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Doors & Windows</div>
                    <div class="card-body">
                        @include('web.catalog.doorswindows')
                    </div>
                </div>
            </div>

            <!-- glassglazing -->

            <div class="category-page" id="glassglazing">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Glass & Glazing</div>
                    <div class="card-body">
                        @include('web.catalog.glassglazing')
                    </div>
                </div>
            </div>

            <!-- hardwaretools -->
            <div class="category-page" id="hardwaretools">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product –  Hardware & Tools</div>
                    <div class="card-body">
                        @include('web.catalog.hardwaretools')
                    </div>
                </div>
            </div>

            <!-- machineries -->

            <div class="category-page" id="machineries">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product –  Machineries & Equipments</div>
                    <div class="card-body">
                        @include('web.catalog.machineries')
                    </div>
                </div>
            </div>

            <!-- timberwood -->
            <div class="category-page" id="timberwood">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Timber & Wood</div>
                    <div class="card-body">
                        @include('web.catalog.timberwood')
                    </div>
                </div>
            </div>

            <!-- roofing -->
            <div class="category-page" id="roofing">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Roofing Materials</div>
                    <div class="card-body">
                        @include('web.catalog.roofing')
                    </div>
                </div>
            </div>

            <!-- pavers -->
            <div class="category-page" id="pavers">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Pavers & Kerbstones</div>
                    <div class="card-body">
                        @include('web.catalog.pavers')
                    </div>
                </div>
            </div>

            <!-- concreteproducts -->
            <div class="category-page" id="concreteproducts">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Concrete Products </div>
                    <div class="card-body">
                        @include('web.catalog.concreteproducts')
                    </div>
                </div>
            </div>

            <!-- roadsafety -->
            <div class="category-page" id="roadsafety">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Road Safety Products </div>
                    <div class="card-body">
                        @include('web.catalog.roadsafety')
                    </div>
                </div>
            </div>

            <!-- facadecladding -->

            <div class="category-page" id="facadecladding">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Facade & Cladding Materials </div>
                    <div class="card-body">
                        @include('web.catalog.facadecladding')
                    </div>
                </div>
            </div>

            <!-- Scaffolding -->
             <div class="category-page" id="scaffolding">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Scaffolding </div>
                    <div class="card-body">
                        @include('web.catalog.scaffolding')
                    </div>
                </div>
            </div>
            <!-- hvacutilities -->
            <div class="category-page" id="hvacutilities">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – HVAC & Utilities </div>
                    <div class="card-body">
                        @include('web.catalog.hvacutilities')
                    </div>
                </div>
            </div>

            <!-- readymix -->
            <div class="category-page" id="readymix">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Ready Mix Concrete</div>
                    <div class="card-body">
                        @include('web.catalog.readymix')
                    </div>
                </div>
            </div>

            <!-- Paint & Coatings									 -->
            <div class="category-page" id="paintcoating">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Paint & Coatings</div>
                    <div class="card-body">
                        @include('web.catalog.paint-coatings')
                    </div>
                </div>
            </div>

            <!-- tilesflooring -->
            <div class="category-page" id="tilesflooring">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Tiles & Flooring	</div>
                    <div class="card-body">
                        @include('web.catalog.tilesflooring')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- TAB SCRIPT --}}
<script>
document.querySelectorAll('#categoryTabs .list-group-item').forEach(tab => {
    tab.addEventListener('click', function () {

        document.querySelectorAll('#categoryTabs .list-group-item')
            .forEach(t => t.classList.remove('active'));

        document.querySelectorAll('.category-page')
            .forEach(p => p.classList.remove('active'));

        this.classList.add('active');
        document.getElementById(this.dataset.target).classList.add('active');
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabs  = document.querySelectorAll('#categoryTabs .list-group-item');
    const pages = document.querySelectorAll('.category-page');

    function activateTab(target) {

        // Remove active states
        tabs.forEach(t => t.classList.remove('active'));
        pages.forEach(p => p.classList.remove('active'));

        // Activate tab
        const activeTab = document.querySelector(
            '#categoryTabs .list-group-item[data-target="' + target + '"]'
        );
        const activePage = document.getElementById(target);

        if (activeTab && activePage) {
            activeTab.classList.add('active');
            activePage.classList.add('active');
        }
    }

    // 👉 On tab click
    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            const target = this.dataset.target;

            // Update URL hash
            window.location.hash = target;

            activateTab(target);
        });
    });

    // 👉 On page load (refresh / back)
    const hash = window.location.hash.replace('#', '');

    if (hash) {
        activateTab(hash);
    } else {
        activateTab('cement'); // default
    }

});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const cache = {}; // 🔥 Prevent multiple calls

    document.querySelectorAll('.js-product-type').forEach(select => {

        select.addEventListener('change', function () {

            const form = this.closest('form');
            if (!form) return;

            const subtype = form.querySelector('.js-product-subtype');
            const brand   = form.querySelector('.js-brand');

            const productId = this.value;

            // Reset
            subtype.innerHTML = '<option value="">Select sub type</option>';
            brand.innerHTML   = '<option value="">Select brand</option>';
            subtype.disabled = true;
            brand.disabled   = true;

            if (!productId) return;

            // ✅ If already fetched → use cache
            if (cache[productId]) {
                fillData(cache[productId], subtype, brand);
                return;
            }

            // 🔥 SINGLE REQUEST
            fetch(`/get-product-meta/${productId}`)
                .then(res => res.json())
                .then(data => {
                    cache[productId] = data;
                    fillData(data, subtype, brand);
                });

        });
    });

    function fillData(data, subtype, brand) {

        data.subtypes.forEach(i => {
            subtype.innerHTML +=
                `<option value="${i.id}">${i.material_subproduct}</option>`;
        });

        data.brands.forEach(b => {
            brand.innerHTML +=
                `<option value="${b.id}">${b.name}</option>`;
        });

        subtype.disabled = false;
        brand.disabled   = false;
    }

    // BRAND CHANGE LOGIC
    document.querySelectorAll('.js-brand').forEach(select => {
        select.addEventListener('change', function () {

            const form = this.closest('form');
            const spec = form.querySelector('.js-specification');
            const other = form.querySelector('.js-other-brand');

            spec.classList.add('d-none');
            other.classList.add('d-none');

            if (!this.value) return;

            spec.classList.remove('d-none');

            if (this.value === '25') { // OTHER brand id
                other.classList.remove('d-none');
            }
        });
    });

});
</script>


@endsection
