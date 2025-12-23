@extends('layouts.app')

@section('title', 'Razorpay Payment')

@section('content')
<style>
    .mt-5 {
        margin-top: 9rem !important;
    }
</style>

<div class="container mt-5" style="max-width:600px;">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h4 class="mb-0">Pay with ConstructKaro</h4>
        </div>

        <div class="card-body">
            <p><strong>Amount:</strong> ₹{{ number_format($displayAmount, 2) }}</p>

            <button id="payBtn" class="btn btn-success w-100 fw-bold">
                Pay ₹{{ number_format($displayAmount, 2) }}
            </button>
        </div>
    </div>
</div>

{{-- Razorpay JS Script --}}
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.getElementById('payBtn').addEventListener('click', function() {

    var vendorId = "{{ request()->vendor_id }}"; // get vendor ID from URL

    var options = {
        "key": "{{ $razorpayKey }}",
        "amount": "{{ $amount }}", // ₹500 converted to paise
        "currency": "INR",
        "name": "ConstructKaro",
        "description": "Vendor Contact Unlock Fee",
        "image": "https://constructkaro.com/assets/logo.png",

        "handler": function (response){
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = "{{ route('razorpay.payment') }}";

            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="razorpay_payment_id" value="${response.razorpay_payment_id}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <input type="hidden" name="vendor_id" value="${vendorId}"> <!-- Added vendor id -->
            `;

            document.body.appendChild(form);
            form.submit();
        },

        "theme": {
            "color": "#F25C05"
        }
    };

    var rzp = new Razorpay(options);
    rzp.open();
});
</script>

@endsection
