@extends('layouts.custapp')

@section('title', 'Enquiry Details')

@section('content')

<div class="card-box">
    <h3 class="fw-bold mb-1">📦 Enquiry Details</h3>
    <p class="text-muted">
        Supplier: <strong>{{ $enquiry->shop_name }}</strong>
    </p>

    <div class="row mb-3">
        <div class="col-md-6">
            <strong>Delivery Location</strong><br>
            {{ $enquiry->delivery_location }}
        </div>
        <div class="col-md-6">
            <strong>Required By</strong><br>
            {{ $enquiry->required_by ?? 'Not specified' }}
        </div>
    </div>

    <hr>

    <h5 class="fw-bold mb-3">Selected Products</h5>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Specification</th>
                    <th>Brand</th>
                    <th width="80">Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->product }}</td>
                    <td>{{ $item->spec }}</td>
                    <td>{{ $item->brand }}</td>
                    <td class="fw-bold text-center">{{ $item->qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex gap-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
            ← Back
        </a>

        <span class="badge bg-warning text-dark px-3 py-2">
            Awaiting Supplier Quotation
        </span>
    </div>
</div>

@endsection
