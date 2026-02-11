@extends('layouts.custapp')

@section('title','Customer Platform Terms & Disclaimer')

@section('content')

<div class="container my-5">

    <div class="card shadow-sm">
        <div class="card-body p-4">

            <h4 class="fw-bold mb-3 text-center">
                CONSTRUCTKARO <br>
                <small class="text-muted">Customer Platform Terms & Disclaimer</small>
            </h4>

            <div class="text-muted text-center mb-4">
                Effective Date: Date of Digital Acceptance <br>
                Platform Owner: <strong>Swarajya Construction Private Limited</strong> <br>
                Brand Name: <strong>ConstructKaro</strong>
            </div>

            <hr>

            <div style="max-height: 500px; overflow-y: auto; font-size: 14px;">

                <p><strong>1. ROLE OF CONSTRUCTKARO</strong></p>
                <p>ConstructKaro is a neutral discovery and facilitation platform for private construction works.</p>
                <ul>
                    <li>Helps Customers discover and connect with independent Vendors</li>
                    <li>Enables communication and coordination</li>
                    <li>Does not execute, supervise, manage, or certify construction works</li>
                </ul>
                <p><strong>ConstructKaro is not:</strong></p>
                <ul>
                    <li>A contractor or subcontractor</li>
                    <li>A project management consultant (PMC)</li>
                    <li>A guarantor of quality, timelines, or payments</li>
                </ul>

                <hr>

                <p><strong>2. INDEPENDENT VENDOR RELATIONSHIP</strong></p>
                <ul>
                    <li>All Vendors are independent service providers</li>
                    <li>All agreements are solely between Customer and Vendor</li>
                    <li>ConstructKaro is not a party to execution contracts</li>
                </ul>

                <hr>

                <p><strong>3. NO GUARANTEES BY CONSTRUCTKARO</strong></p>
                <p>ConstructKaro does not guarantee:</p>
                <ul>
                    <li>Vendor performance</li>
                    <li>Quality of workmanship</li>
                    <li>Timely completion</li>
                    <li>Project cost accuracy</li>
                    <li>Payment behaviour of Vendors</li>
                </ul>

                <hr>

                <p><strong>4. PAYMENTS & PAYMENT FACILITATION</strong></p>
                <p>Payments are generally made directly between Customer and Vendor.</p>
                <p>For projects ₹1 Crore and above, ConstructKaro may enable payment facilitation for coordination or service fee purposes only.</p>
                <ul>
                    <li>No guarantee of payments</li>
                    <li>No bill certification</li>
                    <li>No dispute adjudication</li>
                </ul>

                <hr>

                <p><strong>5. CUSTOMER RESPONSIBILITIES</strong></p>
                <ul>
                    <li>Provide accurate details</li>
                    <li>Finalise scope & pricing directly with Vendor</li>
                    <li>Make payments as agreed</li>
                    <li>Obtain required approvals</li>
                    <li>Not hold ConstructKaro liable for Vendor actions</li>
                </ul>

                <hr>

                <p><strong>6. DISPUTES</strong></p>
                <p>All disputes must be resolved directly between Customer and Vendor. ConstructKaro may facilitate communication but will not adjudicate.</p>

                <hr>

                <p><strong>7. LIMITATION OF LIABILITY</strong></p>
                <p>ConstructKaro shall not be liable for defective work, cost overruns, accidents, statutory violations, or indirect losses. Liability, if any, is limited to fees received.</p>

                <hr>

                <p><strong>8. DATA PROTECTION & PRIVACY</strong></p>
                <ul>
                    <li>Handled under Digital Personal Data Protection Act, 2023</li>
                    <li>Anonymised data may be used for improvement</li>
                    <li>Reasonable security practices followed</li>
                </ul>

                <hr>

                <p><strong>9. TERMINATION</strong></p>
                <p>ConstructKaro may suspend access in case of misuse or fraud.</p>

                <hr>

                <p><strong>10. GOVERNING LAW</strong></p>
                <p>Governed by laws of India. Courts at Mumbai, Maharashtra have exclusive jurisdiction.</p>

                <hr>

                <p><strong>11. DIGITAL ACCEPTANCE</strong></p>
                <p>Acceptance is valid under the Information Technology Act, 2000.</p>

            </div>
<hr>

@if(!empty($customer->agreement_accepted_at))

    {{-- Already Accepted Message --}}
    <div class="alert alert-success text-center">
        <h5 class="mb-2">✅ Agreement Already Accepted</h5>
        <p class="mb-1">
            You accepted this agreement on 
            <strong>
                {{ \Carbon\Carbon::parse($customer->agreement_accepted_at)->format('d M Y, h:i A') }}
            </strong>
        </p>
        <p class="mb-0 text-muted">
            Version: {{ $customer->agreement_version }}
        </p>
    </div>

    <div class="text-center">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            ← Back to Dashboard
        </a>
    </div>

@else

    {{-- Agreement Form --}}
    <form method="POST" action="{{ route('customer.agreement.accept') }}">
        @csrf

        <input type="hidden" name="version" value="v1.0">

        <div class="form-check mb-3">
            <input 
                class="form-check-input" 
                type="checkbox" 
                name="agree" 
                value="1" 
                id="confirmCheck" 
                required
            >
            <label class="form-check-label fw-semibold" for="confirmCheck">
                I understand that ConstructKaro is a facilitation platform and is not responsible for execution, quality, timelines, or payments.
            </label>
        </div>

        <button type="submit" class="btn btn-primary w-100">
            I AGREE & CONTINUE
        </button>
    </form>

@endif

            <!-- <hr>

            {{-- Mandatory Confirmation --}}
           <form method="POST" action="{{ route('customer.agreement.accept') }}">
            @csrf

            {{-- hidden agreement version --}}
            <input type="hidden" name="version" value="v1.0">

            <div class="form-check mb-3">
                <input 
                    class="form-check-input" 
                    type="checkbox" 
                    name="agree" 
                    value="1" 
                    id="confirmCheck" 
                    required
                >
                <label class="form-check-label fw-semibold" for="confirmCheck">
                    I understand that ConstructKaro is a facilitation platform and is not responsible for execution, quality, timelines, or payments.
                </label>
            </div>

    <button type="submit" class="btn btn-primary w-100">
        I AGREE & CONTINUE
    </button>
</form> -->


        </div>
    </div>

</div>

@endsection
