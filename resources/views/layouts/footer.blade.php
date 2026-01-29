<style>
.footer-karo{
    background: linear-gradient(135deg, #0f172a, #1c2c3e);
    color:#e5e7eb;
    padding:70px 0 30px;
    position:relative;
}

/* subtle top border glow */
.footer-karo::before{
    content:'';
    position:absolute;
    top:0;
    left:0;
    width:100%;
    height:2px;
    background:linear-gradient(90deg,#f25c05,#2563eb,#f25c05);
}

/* Logo */
.footer-logo{
    height:40px;
}

/* Text */
.footer-about{
    font-size:.95rem;
    color:#cbd5e1;
    line-height:1.6;
}

/* Headings */
.footer-title{
    font-weight:700;
    margin-bottom:16px;
    color:#fff;
}

/* Links */
.footer-links a{
    display:block;
    color:#cbd5e1;
    text-decoration:none;
    font-size:.95rem;
    margin-bottom:10px;
    transition:.25s;
}

.footer-links a:hover{
    color:#f25c05;
    transform:translateX(4px);
}

/* Contact */
.footer-contact p{
    font-size:.95rem;
    margin-bottom:8px;
    color:#cbd5e1;
}

/* Social Icons */
.footer-social{
    display:flex;
    gap:14px;
    margin-top:16px;
}
.footer-social a{
    width:38px;
    height:38px;
    border-radius:50%;
    background:rgba(255,255,255,.08);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#fff;
    transition:.3s;
}
.footer-social a:hover{
    background:#f25c05;
    transform:translateY(-3px);
}

/* Bottom Bar */
.footer-bottom{
    border-top:1px solid rgba(255,255,255,.1);
    margin-top:40px;
    padding-top:18px;
    text-align:center;
    font-size:.85rem;
    color:#94a3b8;
}

/* Responsive */
@media(max-width:768px){
    .footer-karo{
        text-align:center;
    }
    .footer-social{
        justify-content:center;
    }
}
</style>

<footer class="footer-karo mt-5">
    <div class="container">
        <div class="row gy-4">

            <!-- BRAND -->
            <div class="col-lg-4">
                <img src="{{ asset('images/logobg.png') }}" class="footer-logo mb-3" alt="ConstructKaro">
                <p class="footer-about">
                    ConstructKaro is India’s construction-focused digital platform
                    connecting customers with verified vendors, suppliers, contractors
                    and service providers — transparently and efficiently.
                </p>

                <!-- SOCIAL -->
                <div class="footer-social">
                    <a href="#"><i class="bi bi-facebook"></i></a>
                    <a href="#"><i class="bi bi-instagram"></i></a>
                    <a href="#"><i class="bi bi-linkedin"></i></a>
                    <a href="#"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <!-- COMPANY -->
            <div class="col-lg-2 col-md-4 footer-links">
                <h6 class="footer-title">Company</h6>
                <!-- <a href="{{route('aboutus')}}">About Us</a> -->
                <a href="#">How It Works</a>
                <a href="#">Careers</a>
                <a href="#">Blog</a>
            </div>

            <!-- FOR VENDORS -->
            <div class="col-lg-2 col-md-4 footer-links">
                <h6 class="footer-title">For Vendors</h6>
                <a href="#">Become a Vendor</a>
                <a href="#">Vendor Login</a>
                <a href="#">Vendor Categories</a>
                <a href="#">Pricing</a>
            </div>

            <!-- SUPPORT -->
            <div class="col-lg-2 col-md-4 footer-links">
                <h6 class="footer-title">Support</h6>
                <a href="#">Help Center</a>
                <a href="#">Terms & Conditions</a>
                <a href="#">Privacy Policy</a>
            </div>

            <!-- CONTACT -->
            <div class="col-lg-2 footer-contact">
                <h6 class="footer-title">Contact</h6>
                <p><i class="bi bi-envelope me-2"></i>connect@constructkaro.com</p>
                <p><i class="bi bi-telephone me-2"></i>+91 73858 82657</p>
                <p><i class="bi bi-geo-alt me-2"></i>Maharashtra, India</p>
            </div>

        </div>

        <!-- BOTTOM -->
        <div class="footer-bottom">
            © {{ date('Y') }} ConstructKaro. All rights reserved.
        </div>
    </div>
</footer>
