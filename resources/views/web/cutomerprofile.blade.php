@extends('layouts.custapp')

@section('page_title', 'My Profile')

@section('content')
<style>
    .card {
    border-radius: 14px;
}

.form-control-lg {
    border-radius: 10px;
}

.btn-primary {
    border-radius: 10px;
}

</style>
<div class="container-fluid py-4">

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="row justify-content-center">
    <div class="col-xl-10">

        <div class="row g-4">

            {{-- LEFT PROFILE CARD --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">

                        <div class="rounded-circle bg-primary text-white d-flex 
                            align-items-center justify-content-center mb-3"
                            style="width:120px;height:120px;font-size:42px;font-weight:600;">
                            {{ strtoupper(substr($cust_data->name, 0, 1)) }}
                        </div>

                        <h4 class="mb-1">{{ $cust_data->name }}</h4>
                        <p class="text-muted mb-2">{{ $cust_data->email }}</p>

                        <span class="badge bg-light text-dark px-3 py-2">
                            Customer Account
                        </span>

                    </div>
                </div>
            </div>

            {{-- RIGHT PROFILE FORM --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">

                        <h5 class="mb-4 fw-semibold">Profile Details</h5>

                        <form method="POST" action="{{ route('profile.cutomerupdate') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name"
                                           value="{{ $cust_data->name }}"
                                           class="form-control form-control-lg">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Mobile Number</label>
                                    <input type="text" name="mobile"
                                           value="{{ $cust_data->mobile }}"
                                           class="form-control form-control-lg">
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email"
                                           value="{{ $cust_data->email }}"
                                           class="form-control form-control-lg">
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="mb-3 fw-semibold">Change Password</h6>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <input type="password" name="password"
                                           class="form-control"
                                           placeholder="New Password">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <input type="password" name="password_confirmation"
                                           class="form-control"
                                           placeholder="Confirm Password">
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-primary px-5 py-2">
                                    <i data-lucide="save" class="me-1"></i>
                                    Save Changes
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
</div>
@endsection
