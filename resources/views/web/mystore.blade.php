@extends('layouts.suppliersapp')

@section('title','Supplier Dashboard | ConstructKaro')

@section('content')
<style>
    /* HEADER */
.store-header{
    margin-bottom:20px;
}

.store-header h2{
    font-weight:800;
    color:#0f172a;
}

.store-header p{
    color:#64748b;
    margin:0;
}

/* CARD */
.store-card{
    background:#fff;
    border-radius:20px;
    padding:28px;
    box-shadow:0 16px 40px rgba(15,23,42,.08);
}

/* TOP */
.store-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
}

.store-left{
    display:flex;
    gap:18px;
}

/* LOGO */
.store-logo{
    width:86px;
    height:86px;
    border-radius:20px;
    background:linear-gradient(135deg,#3b82f6,#2563eb);
    color:#fff;
    font-size:32px;
    font-weight:800;
    display:flex;
    align-items:center;
    justify-content:center;
}

/* INFO */
.store-info h3{
    font-weight:800;
    margin-bottom:4px;
}

.location{
    color:#64748b;
    margin-bottom:10px;
}

/* VERIFIED */
.verified{
    background:#ecfdf5;
    color:#16a34a;
    font-size:13px;
    font-weight:600;
    padding:4px 10px;
    border-radius:999px;
    margin-left:8px;
}

/* TAGS */
.tags{
    display:flex;
    flex-wrap:wrap;
    gap:10px;
    margin-bottom:12px;
}

.tags span{
    background:#eff6ff;
    color:#2563eb;
    font-size:13px;
    font-weight:600;
    padding:6px 12px;
    border-radius:999px;
}

/* FEATURES */
.features{
    display:flex;
    gap:20px;
    font-size:14px;
    color:#475569;
}

/* EDIT */
.btn-edit{
    background:linear-gradient(135deg,#2563eb,#1d4ed8);
    color:#fff;
    border:none;
    padding:10px 18px;
    border-radius:12px;
    font-weight:600;
}

/* ABOUT */
.store-about h5{
    font-weight:700;
    margin-bottom:10px;
}

.store-about p{
    color:#475569;
    line-height:1.7;
}

/* STATS */
.store-stats{
    display:flex;
    justify-content:space-around;
    text-align:center;
}

.store-stats h3{
    font-weight:800;
    margin-bottom:4px;
}

.store-stats span{
    color:#64748b;
}

/* MOBILE */
@media(max-width:768px){
    .store-top{
        flex-direction:column;
        gap:20px;
    }
    .features{
        flex-direction:column;
        gap:8px;
    }
    .store-stats{
        flex-direction:column;
        gap:18px;
    }
}

</style>
<div class="store-header">
    <h2>My Store</h2>
    <p>This is how customers see your profile</p>
</div>

<div class="store-card">

    <!-- TOP -->
    <div class="store-top">
        <div class="store-left">
            <div class="store-logo">SH</div>

            <div class="store-info">
                <h3>
                    {{ $supplierName }}
                    <span class="verified">
                        <i class="bi bi-check-circle-fill"></i> Verified
                    </span>
                </h3>
                <p class="location">Manufacturer | {{$supplier_data->statename}}.{{$supplier_data->regionname}}.{{$supplier_data->cityname}}</p>

                <div class="tags">
                    @foreach($categories as $category)
                        <span>✓ {{ $category }}</span>
                    @endforeach
                </div>


                <div class="features">
                   <span>
                        <i class="bi bi-truck"></i> {{ $delivery_type }}
                    </span>

                    <span><i class="bi bi-credit-card"></i> Credit: {{$credit_days}}</span>
                    <span><i class="bi bi-clock"></i> Delivery Time (in Days) :{{$supplier_data->delivery_days}}</span>
                </div>
            </div>
        </div>

       <a href="{{ route('suppliers.profile') }}" class="btn-edit">
            Edit Profile
        </a>

    </div>

    <hr>

    <!-- ABOUT -->
    <div class="store-about">
    <h5>About Supplier</h5>

    <p>
        <strong>{{ $supplier_data->shop_name }}</strong>
        is a trusted supplier managed by
        <strong>{{ $supplier_data->contact_person }}</strong>.

        @if($supplier_data->brands_supplied)
            We specialize in supplying
            <strong>{{ $supplier_data->brands_supplied }}</strong>.
        @endif

        @if($supplier_data->experiance_yer)
            With over <strong>{{ $supplier_data->experiance_yer }} </strong>
            of industry experience,
        @endif

        we cater to customers across
        @if($supplier_data->service_areas)
            <strong>{{ $supplier_data->service_areas }}</strong>.
        @else
            multiple service areas.
        @endif
    </p>

    <p>
        @if($supplier_data->minimum_order_cost)
            The minimum order value starts from
            <strong>₹{{ number_format($supplier_data->minimum_order_cost) }}</strong>.
        @endif

        @if($credit_days)
            We offer flexible credit terms of
            <strong>{{ $credit_days }}</strong>.
        @endif
    </p>

    <p>
        @if($supplier_data->gst_number)
            We are a GST-registered supplier.
        @endif

        @if($supplier_data->status === 'approved')
            All compliance documents are verified and approved.
        @endif
    </p>
</div>


    <hr>

    <!-- STATS -->
    <div class="store-stats">
        <div>
            <h3>{{$supplier_data->experiance_yer}}</h3>
            <span>Years Experience</span>
        </div>
       
        <div>
            <h3>{{$maximum_distance}}</h3>
            <span>Maximum Delivery Distance (KM)</span>
        </div>
    </div>

</div>
@endsection
