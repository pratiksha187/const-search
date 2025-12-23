@extends('layouts.app')

@section('title', 'Register | ConstructKaro')

@section('content')

<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --bg:#f4f7fb;
    --border:#e5e7eb;
}

body{
    background:linear-gradient(135deg,#f4f7fb,#ffffff);
}

/* PAGE */
.auth-wrapper{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:30px;
}

/* CARD */


.auth-card {
    width: 100%;
    max-width: 1611px;
    background: #fff;
    border-radius: 28px;
    box-shadow: 0 40px 90px rgba(0, 0, 0, .12);
    padding: 45px 50px;
}

/* TITLE */
.form-title{
    font-size:28px;
    font-weight:800;
    color:var(--navy);
}

.form-sub{
    font-size:14px;
    color:#6b7280;
    margin-bottom:30px;
}

/* INPUT */
.form-control{
    border-radius:14px;
    padding:12px 14px;
    border:1px solid var(--border);
}

.form-control:focus{
    border-color:var(--orange);
    box-shadow:0 0 0 3px rgba(242,92,5,.15);
}

/* BUTTON */
.btn-register{
    background:linear-gradient(135deg,#ff9a3c,#f25c05);
    border:none;
    color:#fff;
    padding:14px;
    border-radius:14px;
    font-weight:800;
    width:100%;
    margin-top:20px;
}

.btn-register:hover{
    transform:translateY(-1px);
}

/* FOOTER */
.auth-footer{
    text-align:center;
    margin-top:20px;
    font-size:14px;
}

.auth-footer a{
    color:var(--orange);
    font-weight:700;
    text-decoration:none;
}

/* MOBILE */
@media(max-width:768px){
    .auth-card{
        padding:35px 30px;
    }
}
</style>

<div class="auth-wrapper">

    <div class="auth-card">

        <div class="text-center mb-4">
            <div class="form-title">Create Your Account</div>
            <div class="form-sub">
                Join ConstructKaro and manage your construction projects smarter.
            </div>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- 🔹 ROW 1 : 3 COLUMNS -->
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="fw-bold">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Full name" required>
                </div>

                <div class="col-md-4">
                    <label class="fw-bold">Email Address</label>
                    <input type="email" name="email" class="form-control" placeholder="Email address" required>
                </div>

                <div class="col-md-4">
                    <label class="fw-bold">Mobile Number</label>
                    <input type="text" name="mobile" class="form-control" placeholder="Mobile number" required>
                </div>
            </div>

            <!-- 🔹 ROW 2 : 2 COLUMNS -->
            <div class="row g-3 mt-2">
                <div class="col-md-6">
                    <label class="fw-bold">Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Create password" required>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                </div>
            </div>

            <button type="submit" class="btn-register">
                Create Account
            </button>

            <div class="auth-footer">
                Already have an account?
                <a href="{{ route('login') }}">Login</a>
            </div>

        </form>

    </div>

</div>

@endsection
