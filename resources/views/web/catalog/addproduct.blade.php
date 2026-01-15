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
@php
$categories = [
    ['id'=>5,  'target'=>'ConstructionChemicals', 'name'=>'Construction & Chemicals'],
    ['id'=>6,  'target'=>'plumbing', 'name'=>'Plumbing Materials'],
    ['id'=>7,  'target'=>'electrical', 'name'=>'Electrical Items'],
    ['id'=>8,  'target'=>'doorswindows', 'name'=>'Doors & Windows'],
    ['id'=>9,  'target'=>'glassglazing', 'name'=>'Glass & Glazing'],
    ['id'=>10, 'target'=>'hardwaretools', 'name'=>'Hardware & Tools'],
    ['id'=>11, 'target'=>'machineries', 'name'=>'Machineries & Equipments'],
    ['id'=>12, 'target'=>'timberwood', 'name'=>'Timber & Wood'],
    ['id'=>13, 'target'=>'roofing', 'name'=>'Roofing Materials'],
    ['id'=>14, 'target'=>'pavers', 'name'=>'Pavers & Kerbstones'],
    ['id'=>15, 'target'=>'concreteproducts', 'name'=>'Concrete Products'],
    ['id'=>16, 'target'=>'roadsafety', 'name'=>'Road Safety Products'],
    ['id'=>17, 'target'=>'facadecladding', 'name'=>'Facade & Cladding Materials'],
    ['id'=>18, 'target'=>'scaffolding', 'name'=>'Scaffolding'],
    ['id'=>19, 'target'=>'hvacutilities', 'name'=>'HVAC & Utilities'],
    ['id'=>20, 'target'=>'readymix', 'name'=>'Ready Mix Concrete'],
    ['id'=>21, 'target'=>'paintcoating', 'name'=>'Paint & Coatings'],
    ['id'=>22, 'target'=>'tilesflooring', 'name'=>'Tiles & Flooring'],
    ['id'=>2,  'target'=>'steeltmt', 'name'=>'Steel & TMT Bars'],
    ['id'=>1,  'target'=>'cement-concrete', 'name'=>'Cement & Concrete'],
    ['id'=>28, 'target'=>'aggregates', 'name'=>'Aggregates, Sand & Masonry'],
    ['id'=>29, 'target'=>'roadconstruction', 'name'=>'Road Construction Materials'],
];
@endphp

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

                <!-- <ul class="list-group list-group-flush category-tabs" id="categoryTabs">
                    <li class="list-group-item active" data-target="ConstructionChemicals" data-category-id="5">Construction & Chemicals</li>
                    <li class="list-group-item" data-target="plumbing" data-category-id="6">Plumbing Materials</li>
                    <li class="list-group-item" data-target="electrical" data-category-id="7">Electrical Items</li>
                    <li class="list-group-item" data-target="doorswindows" data-category-id="8">Doors & Windows</li>
                    <li class="list-group-item" data-target="glassglazing" data-category-id="9">Glass & Glazing</li>
                    <li class="list-group-item" data-target="hardwaretools" data-category-id="10">Hardware & Tools</li>
                    <li class="list-group-item" data-target="machineries" data-category-id="11">Machineries & Equipments</li>
                    <li class="list-group-item" data-target="timberwood" data-category-id="12">Timber & Wood</li>
                    <li class="list-group-item" data-target="roofing"  data-category-id="13">Roofing Materials </li>
                    <li class="list-group-item" data-target="pavers"  data-category-id="14">Pavers & Kerbstones </li>
                    <li class="list-group-item" data-target="concreteproducts"  data-category-id="15">Concrete Products</li>
                    <li class="list-group-item" data-target="roadsafety"  data-category-id="16">Road Safety Products</li>
                    <li class="list-group-item" data-target="facadecladding"  data-category-id="17">Facade & Cladding Materials</li>
                    <li class="list-group-item" data-target="scaffolding" data-category-id="18">Scaffolding</li>
                    <li class="list-group-item" data-target="hvacutilities"  data-category-id="19">HVAC & Utilities</li>
                    <li class="list-group-item" data-target="readymix"  data-category-id="20">Ready Mix Concrete</li>
                    <li class="list-group-item" data-target="paintcoating"  data-category-id="21">Paint & Coatings</li>
                    <li class="list-group-item" data-target="tilesflooring"  data-category-id="22">Tiles & Flooring</li>
                    <li class="list-group-item" data-target="steeltmt"  data-category-id="2">Steel & TMT Bars</li>
                    <li class="list-group-item" data-target="cement-concrete" data-category-id="1">Cement & Concrete</li>
                    <li class="list-group-item" data-target="aggregates"  data-category-id="28">Aggregates, sand, and Masonry Materials</li>
                    <li class="list-group-item" data-target="roadconstruction"  data-category-id="29">Road Construction Materials & Asphalt Works</li>
                    											
                </ul> -->
                <ul class="list-group list-group-flush category-tabs" id="categoryTabs">

@php $first = true; @endphp

@foreach($categories as $cat)

    @if(in_array($cat['id'], $allowedCategories))

        <li class="list-group-item {{ $first ? 'active' : '' }}"
            data-target="{{ $cat['target'] }}"
            data-category-id="{{ $cat['id'] }}">
            {{ $cat['name'] }}
        </li>

        @php $first = false; @endphp

    @endif

@endforeach

</ul>

            </div>
        </div>

        <!-- RIGHT CONTENT -->
        <div class="col-md-9">

            <!-- ConstructionChemicals -->
            <div class="category-page active" id="ConstructionChemicals">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Construction & Chemicals</div>
                    <div class="card-body">
                        @include('web.catalog.construction-chemicals')
                    </div>
                </div>
            </div>

             <!-- cement-concrete -->
            <div class="category-page" id="cement-concrete">

                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Cement & Concrete</div>
                    <div class="card-body">
                        @include('web.catalog.cementconcrete')
                    </div>
                </div>
            </div>

         

            <!-- TILES -->
            <div class="category-page" id="tiles">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Tiles & Flooring</div>
                    <div class="card-body">
                        @include('web.catalog.tilesflooring')
                    </div>
                </div>
            </div>

            <!-- PAINT -->
            <div class="category-page" id="paint">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Paint & Coatings</div>
                    <div class="card-body">
                        @include('web.catalog.paint-coatings')
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

          

            <!-- tilesflooring -->
            <div class="category-page" id="tilesflooring">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Tiles & Flooring	</div>
                    <div class="card-body">
                        @include('web.catalog.tilesflooring')
                    </div>
                </div>
            </div>

            <!-- steeltmt -->
            <div class="category-page" id="steeltmt">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Steel & TMT Bars</div>
                    <div class="card-body">
                        @include('web.catalog.steeltmt')
                    </div>
                </div>
            </div>

            <!-- cement-concrete -->
            <div class="category-page" id="cement-concrete">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Cement & Concrete</div>
                    <div class="card-body">
                        @include('web.catalog.cementconcrete')
                    </div>
                </div>
            </div>

            <!-- aggregates -->
            <div class="category-page" id="aggregates">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Aggregates, sand, and Masonry Materials</div>
                    <div class="card-body">
                        @include('web.catalog.aggregates')
                    </div>
                </div>
            </div>
            <!-- roadconstruction -->
            <div class="category-page" id="roadconstruction">
                <div class="card shadow-sm mb-4">
                    <div class="card-header fw-semibold">Add Product – Road Construction Materials & Asphalt Works</div>
                    <div class="card-body">
                        @include('web.catalog.roadconstruction')
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- <script>
document.addEventListener('DOMContentLoaded', function () {

    const tabs = document.querySelectorAll('#categoryTabs .list-group-item');

    function activateTab(tab){

        // UI
        tabs.forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.category-page')
            .forEach(p => p.classList.remove('active'));

        tab.classList.add('active');
        document.getElementById(tab.dataset.target).classList.add('active');

        // ✅ SET CATEGORY ID IN ALL FORMS
        document.querySelectorAll('.materialCategoryInput')
            .forEach(input => input.value = tab.dataset.categoryId);

        console.log('material_category_id:', tab.dataset.categoryId);
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => activateTab(tab));
    });

    // default
    activateTab(tabs[0]);
});
</script> -->

<script>
document.addEventListener('DOMContentLoaded', function () {

    const tabs = document.querySelectorAll('#categoryTabs .list-group-item');
    const pages = document.querySelectorAll('.category-page');
    const categoryInput = document.getElementById('materialCategoryInput');

    function activate(tab){
        tabs.forEach(t => t.classList.remove('active'));
        pages.forEach(p => p.classList.remove('active'));

        tab.classList.add('active');

        const page = document.getElementById(tab.dataset.target);
        if(page) page.classList.add('active');

        if(categoryInput){
            categoryInput.value = tab.dataset.categoryId;
        }
    }

    tabs.forEach(tab => {
        tab.addEventListener('click', () => activate(tab));
    });

    if(tabs.length){
        activate(tabs[0]); // auto select first allowed
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

            
        });
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.category-page').forEach(page => {

        page.addEventListener('click', function () {

            // remove active from all
            document.querySelectorAll('.category-page')
                .forEach(p => p.classList.remove('active'));

            // add active to clicked
            this.classList.add('active');

            // get category id
            const categoryId = this.dataset.categoryId;

            // set input value
            document.getElementById('materialCategoryInput').value = categoryId;

            console.log('Selected material_category_id:', categoryId);
        });

    });

});
</script>

@endsection
