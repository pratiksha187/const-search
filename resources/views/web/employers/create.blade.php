@extends('layouts.adminapp') {{-- agar aapka admin layout alag hai --}}
@section('title', 'Add Employer')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h4 class="mb-0">Add Employer</h4>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">Please fix the errors:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.employers.store') }}" class="card shadow-sm border-0">
        @csrf

        <div class="card-body p-4">

            {{-- Employer Details --}}
            <div class="mb-3">
                <div class="fw-semibold mb-2">Employer Details</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="{{ old('mobile') }}">
                    </div>
                </div>
            </div>

            <hr>

            {{-- Company Details --}}
            <div class="mb-3">
                <div class="fw-semibold mb-2">Company Details</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company Name *</label>
                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Company Email</label>
                        <input type="email" name="company_email" class="form-control" value="{{ old('company_email') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Company Phone</label>
                        <input type="text" name="company_phone" class="form-control" value="{{ old('company_phone') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">GST No.</label>
                        <input type="text" name="gst_number" class="form-control" value="{{ old('gst_number') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">PAN No.</label>
                        <input type="text" name="pan_number" class="form-control" value="{{ old('pan_number') }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Website</label>
                        <input type="text" name="website" class="form-control" value="{{ old('website') }}" placeholder="https://">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Company Address</label>
                        <textarea name="company_address" class="form-control" rows="2">{{ old('company_address') }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">State</label>
                        <input type="text" name="state" class="form-control" value="{{ old('state') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" value="{{ old('city') }}">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Pincode</label>
                        <input type="text" name="pincode" class="form-control" value="{{ old('pincode') }}">
                    </div>
                </div>
            </div>

            <hr>

            {{-- Login Credentials --}}
            <div class="mb-3">
                <div class="fw-semibold mb-2">Login Credentials</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Password *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Confirm Password *</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer bg-white border-0 px-4 pb-4">
            <button class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Save Employer
            </button>
        </div>
    </form>

</div>
@endsection
