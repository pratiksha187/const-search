@extends('layouts.adminapp')
@section('title','Add Master')

@section('content')

<style>
    :root{
        --bg:#f6f8fb;
        --card:#ffffff;
        --text:#0f172a;
        --muted:#64748b;
        --line:#e5e7eb;
        --accent:#2563eb;
    }

    body{
        background:var(--bg);
    }

    .master-page{
        max-width:1200px;
        margin:40px auto 80px;
    }

    .page-header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        margin-bottom:28px;
    }

    .page-header h2{
        font-size:24px;
        font-weight:700;
        color:var(--text);
        margin:0;
    }

    .page-header p{
        color:var(--muted);
        margin:4px 0 0;
        font-size:14px;
    }

    .master-grid{
        display:grid;
        grid-template-columns:repeat(3,1fr);
        gap:20px;
    }

    .master-card{
        background:var(--card);
        border-radius:14px;
        padding:22px 24px;
        box-shadow:0 8px 20px rgba(0,0,0,.04);
        border:1px solid var(--line);
        transition:.2s ease;
    }

    .master-card:hover{
        box-shadow:0 14px 30px rgba(0,0,0,.08);
        transform:translateY(-2px);
    }

    .master-title{
        font-size:15px;
        font-weight:600;
        color:var(--text);
        margin-bottom:16px;
    }

    .master-actions{
        display:flex;
        gap:16px;
    }

    .master-actions a{
        font-size:14px;
        font-weight:500;
        color:var(--accent);
        text-decoration:none;
        padding-bottom:2px;
        border-bottom:1px solid transparent;
    }

    .master-actions a:hover{
        border-color:var(--accent);
    }

    @media(max-width:992px){
        .master-grid{grid-template-columns:repeat(2,1fr);}
    }

    @media(max-width:576px){
        .master-grid{grid-template-columns:1fr;}
    }
</style>

<div class="master-page">

    <div class="page-header">
        <div>
            <h2>Add Master</h2>
            <p>Manage all master data used across products & suppliers</p>
        </div>
    </div>

    <div class="master-grid">

        {{-- CATEGORY --}}
        <div class="master-card">
            <div class="master-title">Category</div>
            <div class="master-actions">
                <a href="{{ route('material-categories.index') }}">View</a>
                <a href="{{ route('material-categories.create') }}">Add</a>
            </div>
        </div>

        {{-- PRODUCT --}}
        <div class="master-card">
            <div class="master-title">Product</div>
            <div class="master-actions">
                <a href="{{ route('material-products.index') }}">View</a>
                <a href="{{ route('material-products.create') }}">Add</a>
            </div>
        </div>

        {{-- SUBTYPE --}}
        <div class="master-card">
            <div class="master-title">Subtype</div>
            <div class="master-actions">
                <a href="{{ route('material-product-subtypes.index') }}">View</a>
                <a href="{{ route('material-product-subtypes.create') }}">Add</a>
            </div>
        </div>

        {{-- BRAND --}}
        <div class="master-card">
            <div class="master-title">Brand</div>
            <div class="master-actions">
                <a href="{{ route('brands.index') }}">View</a>
                <a href="{{ route('brands.create') }}">Add</a>
            </div>
        </div>

        {{-- PROFILE TYPE --}}
        <div class="master-card">
            <div class="master-title">Profile Type</div>
            <div class="master-actions">
                <a href="{{ route('profiletypes.index') }}">View</a>
                <a href="{{ route('profiletypes.create') }}">Add</a>
            </div>
        </div>

        {{-- UNIT --}}
        <div class="master-card">
            <div class="master-title">Unit</div>
            <div class="master-actions">
                <a href="{{ route('unit.index') }}">Add / View</a>
            </div>
        </div>

        {{-- SIZE --}}
        <div class="master-card">
            <div class="master-title">Size</div>
            <div class="master-actions">
                <a href="{{ route('thickness.size.index') }}">Add / View</a>
            </div>
        </div>

        {{-- GRADE --}}
        <div class="master-card">
            <div class="master-title">Grade</div>
            <div class="master-actions">
                <a href="{{ route('grade.index') }}">Add / View</a>
            </div>
        </div>

        {{-- STANDARD --}}
        <div class="master-card">
            <div class="master-title">Standard</div>
            <div class="master-actions">
                <a href="{{ route('standard.index') }}">Add / View</a>
            </div>
        </div>

        {{-- WEIGHT --}}
        <div class="master-card">
            <div class="master-title">Weight</div>
            <div class="master-actions">
                <a href="{{ route('whight.index') }}">Add / View</a>
            </div>
        </div>
        <div class="master-card">
            <div class="master-title">State</div>
            <div class="master-actions">
                <a href="{{ route('states.index') }}">Add / View</a>
            </div>
        </div>

        <div class="master-card">
            <div class="master-title">Region</div>
            <div class="master-actions">
                <a href="{{ route('regions.index') }}">Add / View</a>
            </div>
        </div>

        <div class="master-card">
            <div class="master-title">City</div>
            <div class="master-actions">
                <a href="{{ route('cities.index') }}">Add / View</a>
            </div>
        </div>


    </div>

</div>

@endsection
