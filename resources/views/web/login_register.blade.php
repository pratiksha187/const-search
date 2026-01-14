@extends('layouts.app')

@section('title', 'Login | ConstructKaro')

@section('content')

<style>
.auth-wrapper {
    max-width: 1100px;
    margin: 129px auto;
    background: #fff;
    border-radius: 18px;
    padding: 40px;
    box-shadow: 0 15px 40px rgba(0,0,0,0.08);
}

.auth-tabs {
    border-bottom: 2px solid #e5e7eb;
    display: flex;
    gap: 30px;
    margin-bottom: 25px;
}

.auth-tab {
    font-size: 1.2rem;
    font-weight: 600;
    cursor: pointer;
    padding-bottom: 6px;
}

.auth-tab.active {
    color: #00a8ff;
    border-bottom: 3px solid #00a8ff;
}

.form-control {
    height: 48px;
    border-radius: 8px;
}

.btn-blue {
    background: #00a8ff;
    color: white;
    font-size: 1.05rem;
    padding: 10px;
    border-radius: 8px;
    font-weight: 600;
    border: none;
}

.btn-blue:hover {
    background: #0094e0;
}

.illustration-img { width: 100%; }

/* ROLE SELECTOR */
.role-box {
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px;
    text-align: center;
    cursor: pointer;
    transition: .3s;
}

.role-box:hover { border-color: #00a8ff; }
.role-box.active {
    border-color: #00a8ff;
    background: rgba(0,168,255,0.08);
}

.role-icon {
    font-size: 32px;
    color: #00a8ff;
    margin-bottom: 10px;
}

.otp-input {
    width: 55px;
    height: 55px;
    font-size: 1.5rem;
    border-radius: 8px;
}

@media(max-width: 992px){
    .illustration-img { display: none; }
}

.password-toggle {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #6b7280;
    font-size: 1.2rem;
}

.password-toggle:hover {
    color: #00a8ff;
}

</style>

<div class="auth-wrapper">
    <div class="row">

        <!-- LEFT IMAGE -->
        <div class="col-lg-6 d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/vcr.png') }}" class="illustration-img">
        </div>

        <!-- RIGHT FORM -->
        <div class="col-lg-6">

            <!-- Tabs -->
            <div class="auth-tabs">
                <div class="auth-tab active" id="tab-login">Login</div>
                <div class="auth-tab" id="tab-register">Register</div>
            </div>

            <!-- ================= LOGIN FORM ================= -->
            <div id="login-form">

                <div class="row g-3 mb-3">
                    <div class="col-4">
                        <div class="role-box active" data-role="customer">
                            <div class="role-icon"><i class="bi bi-person"></i></div>
                            <div>Customer</div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="role-box" data-role="vendor">
                            <div class="role-icon"><i class="bi bi-briefcase"></i></div>
                            <div>Vendor</div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="role-box" data-role="supplier">
                            <div class="role-icon"><i class="bi bi-truck"></i></div>
                            <div>Supplier</div>
                        </div>
                    </div>
                </div>

                <label class="fw-bold mb-1">Mobile Number / Email</label>
                <input type="text" class="form-control mb-3" id="login-input">

                <label class="fw-bold mb-1">Password</label>
                <!-- <input type="password" class="form-control mb-3" id="login-pass"> -->
                <div class="position-relative mb-3">
                    <input type="password" class="form-control" id="login-pass">
                    <span class="password-toggle" id="toggle-login-password">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>

                <button class="btn-blue w-100" id="login-btn">Login</button>
            </div>

            <!-- ================= REGISTER FORM ================= -->
            <div id="register-form" class="d-none">

                <label class="fw-bold mb-2">Register As</label>

                <div class="row g-3 mb-3">
                    <div class="col-4">
                        <div class="role-box active" data-role="customer">
                            <div class="role-icon"><i class="bi bi-person"></i></div>
                            <div>Customer</div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="role-box" data-role="vendor">
                            <div class="role-icon"><i class="bi bi-briefcase"></i></div>
                            <div>Vendor</div>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="role-box" data-role="supplier">
                            <div class="role-icon"><i class="bi bi-truck"></i></div>
                            <div>Supplier</div>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="selected-role" value="customer">

                <!-- BASE REGISTER FIELDS -->
                <div id="register-fields">
                    <input type="text" class="form-control mb-3" id="reg-name" placeholder="Full Name">
                    <input type="text" class="form-control mb-3" id="reg-mobile" placeholder="Mobile Number">
                    <input type="email" class="form-control mb-3" id="reg-email" placeholder="Email">
                    <!-- <input type="password" class="form-control mb-3" id="reg-pass" placeholder="Password"> -->
                    <input type="password" class="form-control mb-2" id="reg-pass" placeholder="Password">

                    <input type="password" class="form-control mb-1" id="reg-confirm-pass" placeholder="Re-enter Password">

                    <small id="password-match-msg" class="fw-semibold"></small>

                </div>

                <!-- VENDOR EXTRA FIELDS -->
                <div id="vendor-inline-fields" class="d-none">
                    <input type="text" class="form-control mb-3" id="vendor-business-name" placeholder="Business Name">
                    <input type="text" class="form-control mb-3" id="vendor-gst-number" placeholder="GST Number (Optional)">
                </div>
                <!-- SUPPLIER EXTRA FIELDS -->
                <div id="supplier-inline-fields" class="d-none">
                      <input type="text"
                            class="form-control mb-3"
                            id="supplier-business-name" name="shop_name"
                            placeholder="Business Name">
                  

                </div>

                

                <button class="btn-blue w-100" id="btn-send-otp">Register</button>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
/* ================= TAB SWITCH ================= */
$("#tab-login").click(function () {
    $("#tab-login").addClass("active");
    $("#tab-register").removeClass("active");
    $("#login-form").removeClass("d-none");
    $("#register-form").addClass("d-none");
});

$("#tab-register").click(function () {
    $("#tab-register").addClass("active");
    $("#tab-login").removeClass("active");
    $("#register-form").removeClass("d-none");
    $("#login-form").addClass("d-none");
});

/* ================= ROLE SWITCH ================= */
$(".role-box").click(function () {
    $(".role-box").removeClass("active");
    $(this).addClass("active");

    let role = $(this).data("role");
    $("#selected-role").val(role);

    // Hide all extra fields first
    $("#vendor-inline-fields").addClass("d-none");
    $("#supplier-inline-fields").addClass("d-none");

    if (role === "vendor") {
        $("#vendor-inline-fields").removeClass("d-none");
    }

    if (role === "supplier") {
        $("#supplier-inline-fields").removeClass("d-none");
    }
});


/* ================= PASSWORD MATCH CHECK ================= */
function checkPasswordMatch() {
    let pass = $("#reg-pass").val();
    let confirmPass = $("#reg-confirm-pass").val();

    if (confirmPass.length === 0) {
        $("#password-match-msg").text("").removeClass("text-danger text-success");
        return false;
    }

    if (pass === confirmPass) {
        $("#password-match-msg")
            .text("Passwords match ✔")
            .removeClass("text-danger")
            .addClass("text-success");
        return true;
    } else {
        $("#password-match-msg")
            .text("Passwords do not match ✖")
            .removeClass("text-success")
            .addClass("text-danger");
        return false;
    }
}

$("#reg-pass, #reg-confirm-pass").on("keyup", checkPasswordMatch);

/* ================= REGISTER (ONLY ONE CALL) ================= */
$("#btn-send-otp").click(function () {

    if (!checkPasswordMatch()) {
        alert("Passwords do not match");
        return;
    }

    $.post("{{ route('register') }}", {
        role: $("#selected-role").val(),
        name: $("#reg-name").val(),
        mobile: $("#reg-mobile").val(),
        email: $("#reg-email").val(),
        password: $("#reg-pass").val(),
        shop_name:$("#supplier-business-name").val(),
        business_name: $("#vendor-business-name").val(),
        gst_number: $("#vendor-gst-number").val(),
         // Supplier
        // material_category: $("#supplier-material-category").val(),
        _token: "{{ csrf_token() }}"
    }, function (res) {
        if (res.status) {
            window.location.href = res.redirect;
        } else {
            alert(res.message);
        }
    });
});

/* ================= LOGIN ================= */
$("#login-btn").click(function () {
    $.post("{{ route('login') }}", {
        login: $("#login-input").val(),
        password: $("#login-pass").val(),
        role: $("#selected-role").val(),
        _token: "{{ csrf_token() }}"
    }, function (res) {
        if (res.status) {
            window.location.href = res.redirect;
        } else {
            alert(res.message);
        }
    });
});

/* ================= SHOW / HIDE LOGIN PASSWORD ================= */
$("#toggle-login-password").click(function () {
    let input = $("#login-pass");
    let icon = $(this).find("i");

    if (input.attr("type") === "password") {
        input.attr("type", "text");
        icon.removeClass("bi-eye").addClass("bi-eye-slash");
    } else {
        input.attr("type", "password");
        icon.removeClass("bi-eye-slash").addClass("bi-eye");
    }
});
</script>

@endsection
