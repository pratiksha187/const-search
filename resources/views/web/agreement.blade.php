<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vendor Agreement | ConstructKaro</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
:root{--navy:#1c2c3e;--orange:#f25c05;--border:#e5e7eb;--bg:#f4f6fb;}
body{background:var(--bg);}
.card{border-radius:18px;}
.agree-box{
  height:420px; overflow:auto; background:#fff;
  border:1px solid var(--border); border-radius:14px;
  padding:18px; white-space:pre-wrap; line-height:1.65;
  color:#0f172a; font-size:14px;
}
.btn-orange{background:var(--orange); color:#fff; font-weight:800; border-radius:14px;}
.btn-orange:disabled{opacity:.5;}
</style>
</head>

<body>
  
<div class="container py-5" style="max-width:1290px;">
 

  <div class="card border-0 shadow-sm">
    <div class="card-body p-4 p-md-5">
      <a href="{{ route('vendordashboard') }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left"></i> Back
      </a>

      <div class="d-flex justify-content-between flex-wrap gap-3">
        <div>
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('images/logobg.png') }}" alt="ConstructKaro"
                    style="height:85px;width:auto;object-fit:contain;">
            
            </div>

          <div class="text-muted fw-semibold">Vendor Platform Terms, Lead Access & High-Value Project Agreement</div>
          <div class="text-muted small">(Click-Wrap Acceptance with Conditional Digital Execution)</div>
        </div>
        <div class="text-end">
          <span class="badge rounded-pill bg-light text-dark border">Version: {{ $version }}</span>
          <!-- <div class="text-muted small mt-2">Effective Date: Date of Vendor’s digital acceptance</div> -->
          <div class="text-muted small mt-2">
            <b>Effective Date:</b> {{ \Carbon\Carbon::now('Asia/Kolkata')->format('d M Y') }}
          </div>

        </div>
      </div>

      <hr class="my-4">

      @if(!empty($alreadyAccepted) && $alreadyAccepted)
        <div class="alert alert-success mb-3">
          ✅ You already accepted this agreement ({{ $version }}).
        </div>
      @endif
<div class="p-3 mb-3"
     style="background:#fff;border:1px solid var(--border);border-radius:14px;">
  <div class="d-flex justify-content-between flex-wrap gap-2">
    <div>
      <div class="fw-bold" style="color:var(--navy);">Vendor Details (Signing Party)</div>
      <div class="text-muted small">These details are taken from your registered vendor profile.</div>
    </div>
    <span class="badge bg-light text-dark border align-self-start">
      Vendor ID: {{ $vendor->id ?? '-' }}
    </span>
  </div>

  <div class="row mt-3 g-3">
    <div class="col-md-4">
      <div class="text-muted small">Vendor Name</div>
      <div class="fw-semibold" style="color:var(--navy);">
        {{ $vendor->name ?? '-' }}
      </div>
    </div>

    <div class="col-md-4">
      <div class="text-muted small">Mobile</div>
      <div class="fw-semibold" style="color:var(--navy);">
        {{ $vendor->mobile ?? $vendor->phone ?? '-' }}
      </div>
    </div>

    <div class="col-md-4">
      <div class="text-muted small">Email</div>
      <div class="fw-semibold" style="color:var(--navy);">
        {{ $vendor->email ?? '-' }}
      </div>
    </div>
  </div>
</div>

      <div id="agreementBox" class="agree-box">
CONSTRUCTKARO
Vendor Platform Terms, Lead Access & High-Value Project Agreement
(Click-Wrap Acceptance with Conditional Digital Execution)
Effective Date: <b>{{ \Carbon\Carbon::now('Asia/Kolkata')->format('d M Y') }}</b>
Platform Owner: Swarajya Construction Private Limited (Brand: ConstructKaro)
By clicking “<b>I AGREE & CONTINUE</b>”, the Vendor confirms acceptance of the following legally binding terms.
________________________________________
1. PLATFORM ROLE & LIMITATION
ConstructKaro is a neutral discovery, coordination, and facilitation platform for private construction works.
ConstructKaro:
•	Connects Customers with independent Vendors
•	Facilitates discovery, lead access, and coordination
•	Does not execute, supervise, certify, or guarantee construction works
All execution, quality, safety, labour, statutory compliance, and delivery obligations rest solely with the Vendor.
________________________________________
2. INDEPENDENT CONTRACTOR STATUS
•	Vendor acts as an independent contractor
•	No partnership, agency, joint venture, or employment is created
•	ConstructKaro bears no execution or site-level liability
________________________________________
3. LEAD ACCESS & PRICING STRUCTURE
3.1 Free Lead Allowance
(Applicable ONLY to Projects Below ₹1 Crore)
Upon successful registration on the ConstructKaro platform, the Vendor shall be entitled to access up to three (3) project leads free of cost.
This free lead allowance shall apply strictly and exclusively to projects having an estimated project value below ₹1 Crore.
📌 Projects valued at or above ₹1 Crore are expressly excluded from this free lead allowance.
________________________________________
3.2 Paid Lead Access
(Projects Below ₹1 Crore – From 4th Lead Onwards)
For projects with an estimated value below ₹1 Crore, from the fourth (4th) lead onwards, the Vendor must choose one of the following options:
OPTION A – Pay Per Lead
Pay the applicable per-lead access fee based on the project value slab displayed on the platform at the time of lead access.
OPTION B – Subscription Plan
Purchase a subscription plan granting access to a defined number of leads, as displayed on the platform.
📌 All prices, fees, and charges displayed on the platform are exclusive of Goods and Services Tax (GST). Applicable GST shall be charged additionally and shall be payable by the Vendor in accordance with prevailing law.
________________________________________
3.3 No Rights, Carry Forward, or Conversion
The free lead allowance:
•	Is non-transferable
•	Cannot be carried forward beyond its initial availability
•	Cannot be converted into cash, credits, or adjusted against future fees
ConstructKaro reserves the right to limit, suspend, or revoke free lead access in cases of misuse, manipulation, or circumvention.
________________________________________
3.4 Projects Above ₹1 Crore – Success Fee Model (No Free Leads)
For any project having an estimated, declared, or actual value exceeding ₹1 Crore, the following shall apply:
•	No free leads shall be provided
•	Lead access for such projects shall not be governed by Clause 3.1 or 3.2
•	Monetisation shall be based on a success-linked fee model, as detailed below
________________________________________
3.5 Success Fee Options
(Applicable ONLY to Projects Above ₹1 Crore)
For projects exceeding ₹1 Crore, the Vendor must select one of the following success fee options:
OPTION A – One-Time Success Fee
•	1% of the total project value
•	Payable within seven (7) days of issuance of a work order, letter of intent, written or email confirmation, commencement of work, receipt of advance payment, or execution of any agreement between the Vendor and the Customer, whichever occurs earlier.

OPTION B – Bill-to-Bill Facilitation Fee
•	2% of each bill amount actually received by the Vendor from the Customer
•	Fee may be deducted through a designated payment facilitation or escrow-like arrangement
•	ConstructKaro does not guarantee payments, approvals, or dispute outcomes
👉 All success fees are exclusive of applicable taxes, and GST shall be charged additionally as per prevailing law.
________________________________________
4. PROJECTS ABOVE ₹1 CRORE – SPECIAL LEGAL FRAMEWORK
4.1 Applicability
For any project with an estimated or actual value exceeding ₹1 Crore, the following shall apply in addition to this click-wrap agreement.
________________________________________
4.2 Mandatory Digital Agreement For Projects Above 1 Crore (Leegality / Equivalent)
•	Vendor shall be required to execute a separate digital agreement via a legally recognized platform (such as Leegality or equivalent)
•	This agreement may cover:
o	Facilitation / success fee
o	Escrow or payment routing (if applicable)
o	Non-circumvention
o	Limited mediation role of ConstructKaro
o	Additional disclosures required for high-value projects
📌 Execution of such digital agreement is mandatory to access or proceed with ₹1 Cr+ projects.
________________________________________
4.3 Click-Wrap Still Applies
This click-wrap agreement:
•	Continues to apply to ₹1 Cr+ projects
•	Works in conjunction with the digitally executed agreement
•	Does not get replaced or overridden unless explicitly stated
________________________________________
5. NON-CIRCUMVENTION
•	Vendor shall not bypass ConstructKaro for any Customer introduced through the platform
•	This restriction applies for 24 months from first introduction
•	Any circumvention shall result in:
o	Immediate account suspension, and
o	Liability to pay charges equivalent to applicable platform fees
________________________________________
6. NO GUARANTEES BY CONSTRUCTKARO
ConstructKaro does not guarantee:
•	Award of work
•	Project size or value
•	Customer behaviour or payments
•	Timelines or outcomes
Vendor acknowledges that construction projects involve inherent commercial and execution risks.
________________________________________
7. CONFIDENTIALITY & DATA PROTECTION
•	All Customer details, project data, pricing, BOQs, and communications are confidential
•	Vendor shall comply with the Digital Personal Data Protection Act, 2023
•	Confidentiality obligations survive termination
________________________________________
8. INTELLECTUAL PROPERTY & BRAND USE
•	All platform technology, data, and branding belong exclusively to ConstructKaro
•	Vendor shall not represent ConstructKaro as:
o	Execution partner
o	Project guarantor
o	Supervisory authority
________________________________________
9. LIABILITY & INDEMNITY
•	Vendor bears full responsibility for execution, quality, safety, labour, and compliance
•	Vendor agrees to indemnify and hold harmless ConstructKaro from:
o	Customer claims
o	Legal notices
o	Regulatory actions
•	ConstructKaro’s liability, if any, shall be strictly limited to fees actually received
________________________________________
10. TERMINATION
•	Either party may terminate platform access with 7 days’ notice
•	Outstanding dues and non-circumvention obligations survive termination
________________________________________
11. GOVERNING LAW & JURISDICTION
•	Governed by the laws of India
•	Courts at Mumbai, Maharashtra shall have exclusive jurisdiction
________________________________________
12. DIGITAL ACCEPTANCE
By clicking “I AGREE & CONTINUE”, the Vendor confirms that:
•	They have read and understood these terms
•	They voluntarily accept them
•	This acceptance constitutes valid consent under the Information Technology Act, 2000
________________________________________

      </div>

      <div class="form-check mt-3">
        <input class="form-check-input" type="checkbox" id="agreeCheck" disabled>
        <label class="form-check-label fw-semibold" for="agreeCheck" style="color:var(--navy);">
          I agree to the ConstructKaro Platform Terms, Lead Access Model, and the requirement of additional digital agreements for projects above ₹1 Crore.
        </label>
      </div>

      <form method="POST" action="{{ route('vendor.agreement.accept') }}" class="mt-3">
        @csrf
        <input type="hidden" name="agree" id="agreeHidden" value="0">
        <input type="hidden" name="version" value="{{ $version }}">
        

        <button class="btn btn-orange btn-lg w-100" id="agreeBtn" disabled>
          I AGREE & CONTINUE
        </button>

        <div class="text-muted small text-center mt-2">
          By clicking, you consent under the Information Technology Act, 2000.
        </div>
      </form>

    </div>
  </div>
</div>

<script>
(function(){
  const box = document.getElementById('agreementBox');
  const check = document.getElementById('agreeCheck');
  const btn = document.getElementById('agreeBtn');
  const hidden = document.getElementById('agreeHidden');

  let scrolledBottom = false;

  function update(){
    const ok = scrolledBottom && check.checked;
    btn.disabled = !ok;
    hidden.value = ok ? "1" : "0";
  }

  box.addEventListener('scroll', () => {
    const nearBottom = box.scrollTop + box.clientHeight >= box.scrollHeight - 10;
    if(nearBottom){
      scrolledBottom = true;
      check.disabled = false;
    }
    update();
  });

  check.addEventListener('change', update);
})();
</script>
</body>
</html>
