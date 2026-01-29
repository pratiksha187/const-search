@extends('layouts.app')

@section('title','Login / Register | ConstructKaro')

@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.auth-wrapper{
    max-width:480px;
    margin:130px auto;
    background:#fff;
    padding:28px;
    border-radius:18px;
    box-shadow:0 20px 50px rgba(0,0,0,.1);
}

/* STEP 1 */
.action-switch{
    display:flex;
    gap:10px;
    margin-bottom:18px;
}
.action-btn{
    flex:1;
    padding:10px;
    border-radius:12px;
    border:2px solid #e5e7eb;
    background:#fff;
    font-weight:600;
    cursor:pointer;
}
.action-btn.active{
    background:#00a8ff;
    color:#fff;
    border-color:#00a8ff;
}

/* STEP 2 */
.role-switch{
    display:flex;
    gap:10px;
    margin-bottom:20px;
}
.role-box{
    flex:1;
    text-align:center;
    padding:12px 8px;
    border-radius:14px;
    border:2px solid #e5e7eb;
    cursor:pointer;
    font-weight:600;
}
.role-box.active{
    border-color:#00a8ff;
    background:#eaf6ff;
    color:#00a8ff;
}

.form-control{
    height:46px;
    border-radius:10px;
}

.btn-blue{
    background:#00a8ff;
    color:#fff;
    padding:11px;
    border-radius:10px;
    font-weight:600;
    border:none;
}
.btn-blue:hover{ background:#0095e0; }

.password-toggle{
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
}

.social-icon{
    width:42px;
    height:42px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:20px;
    color:#fff;
    transition:.3s;
    text-decoration:none;
}

.social-icon.instagram{ background:#E1306C; }
.social-icon.linkedin{ background:#0077B5; }
.social-icon.facebook{ background:#1877F2; }
.social-icon.youtube{ background:#FF0000; }

.social-icon:hover{
    transform:translateY(-3px);
    opacity:.9;
}

</style>

<div class="auth-wrapper">

    <!-- STEP 1 -->
    <div class="action-switch">
        <button type="button" class="action-btn active" data-action="login">Login</button>
        <button type="button" class="action-btn" data-action="register">Register</button>
    </div>

    <!-- STEP 2 -->
    <div class="role-switch">
        <div class="role-box active" data-role="customer">👤 Customer</div>
        <div class="role-box" data-role="vendor">💼 Vendor</div>
        <div class="role-box" data-role="supplier">🚚 Supplier</div>
    </div>

    <input type="hidden" id="selected-role" value="customer">

    <!-- LOGIN -->
    <div id="login-form">
        <input class="form-control mb-3" id="login-input" placeholder="Mobile Number / Email">

        <div class="position-relative mb-3">
            <input type="password" class="form-control" id="login-pass" placeholder="Password">
            <span class="password-toggle" id="toggle-login-password">
                <i class="bi bi-eye"></i>
            </span>
        </div>

        <button class="btn-blue w-100" id="login-btn">Login</button>

        <div class="text-end mt-2">
            <a href="javascript:void(0)" id="forgot-password-link">Forgot Password?</a>
        </div>
    </div>

    <!-- REGISTER -->
    <div id="register-form" class="d-none">
        <input class="form-control mb-3" id="reg-name" placeholder="Full Name">
        <input class="form-control mb-3" id="reg-mobile" placeholder="Mobile Number">
        <input class="form-control mb-3" id="reg-email" placeholder="Email">

        <div id="vendor-inline-fields" class="d-none">
            <input class="form-control mb-3" id="vendor-business-name" placeholder="Business Name">
            <input class="form-control mb-3" id="vendor-gst-number" placeholder="GST Number (Optional)">
        </div>

        <div id="supplier-inline-fields" class="d-none">
            <input class="form-control mb-3" id="supplier-business-name" placeholder="Business Name">
        </div>

        <input type="password" class="form-control mb-2" id="reg-pass" placeholder="Password">
        <input type="password" class="form-control mb-1" id="reg-confirm-pass" placeholder="Confirm Password">
        <small id="password-match-msg"></small>

        <button class="btn-blue w-100 mt-2" id="btn-send-otp">Register</button>
    </div>

    <!-- FOLLOW CONSTRUCTKARO -->
<div class="text-center mt-4 pt-3 border-top">
    <div class="text-muted fw-semibold mb-2">
        Follow ConstructKaro
    </div>

    <div class="d-flex justify-content-center gap-3">
        <a href="https://www.instagram.com/constructkaro" target="_blank"
           class="social-icon instagram" title="Instagram">
            <i class="bi bi-instagram"></i>
        </a>

        <a href="https://www.linkedin.com/company/constructkaro" target="_blank"
           class="social-icon linkedin" title="LinkedIn">
            <i class="bi bi-linkedin"></i>
        </a>

        <a href="https://www.facebook.com/constructkaro" target="_blank"
           class="social-icon facebook" title="Facebook">
            <i class="bi bi-facebook"></i>
        </a>

        <a href="https://www.youtube.com/@constructkaro" target="_blank"
           class="social-icon youtube" title="YouTube">
            <i class="bi bi-youtube"></i>
        </a>
    </div>
</div>

</div>

<!-- FORGOT PASSWORD MODAL -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input class="form-control mb-3" id="fp-login" placeholder="Registered Mobile / Email">
                <input type="password" class="form-control mb-3" id="fp-password" placeholder="New Password">
                <input type="password" class="form-control mb-3" id="fp-confirm" placeholder="Confirm Password">

                <button class="btn btn-primary w-100" id="change-password-btn">
                    Change Password
                </button>
            </div>
        </div>
    </div>
</div>

<!-- JS LIBS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
let action = 'login';
let role   = 'customer';

function updateURL(){
    history.pushState({},'',`/auth/${action}/${role}`);
}

/* ACTION */
$('.action-btn').on('click',function(){
    action = $(this).data('action');
    $('.action-btn').removeClass('active');
    $(this).addClass('active');

    $('#login-form').toggleClass('d-none', action !== 'login');
    $('#register-form').toggleClass('d-none', action !== 'register');

    updateURL();
});

/* ROLE */
$('.role-box').on('click',function(){
    role = $(this).data('role');
    $('#selected-role').val(role);

    $('.role-box').removeClass('active');
    $(this).addClass('active');

    $('#vendor-inline-fields,#supplier-inline-fields').addClass('d-none');
    if(role === 'vendor') $('#vendor-inline-fields').removeClass('d-none');
    if(role === 'supplier') $('#supplier-inline-fields').removeClass('d-none');

    updateURL();
});

/* PASSWORD MATCH */
$('#reg-pass,#reg-confirm-pass').on('keyup',function(){
    let p = $('#reg-pass').val();
    let c = $('#reg-confirm-pass').val();
    if(!c){ $('#password-match-msg').text(''); return; }
    $('#password-match-msg')
        .text(p===c?'Passwords match ✔':'Passwords do not match ✖')
        .css('color',p===c?'green':'red');
});

/* LOGIN */
$('#login-btn').click(function(){
    $.post("{{ route('login') }}",{
        login:$('#login-input').val(),
        password:$('#login-pass').val(),
        role:$('#selected-role').val(),
        _token:"{{ csrf_token() }}"
    },res=>{
        res.status ? location.href=res.redirect : alert(res.message);
    });
});

/* REGISTER */
$('#btn-send-otp').click(function(){
    $.post("{{ route('register') }}",{
        role:$('#selected-role').val(),
        name:$('#reg-name').val(),
        mobile:$('#reg-mobile').val(),
        email:$('#reg-email').val(),
        password:$('#reg-pass').val(),
        shop_name:$('#supplier-business-name').val(),
        business_name:$('#vendor-business-name').val(),
        gst_number:$('#vendor-gst-number').val(),
        _token:"{{ csrf_token() }}"
    },res=>{
        res.status ? location.href=res.redirect : alert(res.message);
    });
});

/* PASSWORD TOGGLE */
$('#toggle-login-password').click(function(){
    let i=$('#login-pass'),icon=$(this).find('i');
    i.attr('type',i.attr('type')==='password'?'text':'password');
    icon.toggleClass('bi-eye bi-eye-slash');
});

/* FORGOT PASSWORD */
const forgotModal = new bootstrap.Modal(document.getElementById('forgotPasswordModal'));
$('#forgot-password-link').click(()=>forgotModal.show());

$('#change-password-btn').click(function(){
    fetch('/change-password',{
        method:'POST',
        headers:{
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
        },
        body:JSON.stringify({
            login:$('#fp-login').val(),
            password:$('#fp-password').val(),
            role:$('#selected-role').val()
        })
    }).then(r=>r.json()).then(d=>{
        alert(d.message);
        if(d.status) forgotModal.hide();
    });
});

/* URL LOAD */
$(function(){
    let p=location.pathname.split('/');
    action=p[2]||'login';
    role=p[3]||'customer';
    $(`.action-btn[data-action="${action}"]`).trigger('click');
    $(`.role-box[data-role="${role}"]`).trigger('click');
});
</script>

@endsection
