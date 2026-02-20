<aside class="sidebar">
  <div class="brand">
    <div class="logo">
      <i class="bi bi-box-seam-fill" style="color:var(--orange)"></i>
    </div>
    <div>
      <div style="font-weight:900;">ConstructKaro ERP</div>
      <div style="opacity:.8; font-size:12px;">Procurement Prototype</div>
    </div>
  </div>

  <div class="small mt-3">MAIN</div>

  <a href="{{ route('employers.dashboard') }}"
     class="nav-pill {{ request()->routeIs('employers.dashboard') ? 'active' : '' }}">
    <div class="left">
      <i class="bi bi-speedometer2"></i> Dashboard
    </div>
  </a>

  <a href="{{ route('erpproject') }}"
     class="nav-pill {{ request()->routeIs('erpproject') ? 'active' : '' }}">
    <div class="left">
      <i class="bi bi-building"></i> Projects
    </div>
  </a>

  <a href="{{ route('boq_rfq_bids') }}"
     class="nav-pill {{ request()->routeIs('boq_rfq_bids') ? 'active' : '' }}">
    <div class="left">
      <i class="bi bi-clipboard2-data"></i> BOQ → RFQ → Bids
    </div>
  </a>

  <a href="{{ route('po_grm_invoice') }}"
     class="nav-pill {{ request()->routeIs('po_grm_invoice') ? 'active' : '' }}">
    <div class="left">
      <i class="bi bi-receipt-cutoff"></i> PO / GRN / Invoice
    </div>
  </a>

  <div class="small mt-3">ADMIN</div>

  <a href="{{ route('vendor_network') }}"
     class="nav-pill {{ request()->routeIs('vendor_network') ? 'active' : '' }}">
    <div class="left">
      <i class="bi bi-people"></i> Vendor Network
    </div>
  </a>

  <a href="{{ route('user_roles') }}"
     class="nav-pill {{ request()->routeIs('user_roles') ? 'active' : '' }}">
    <div class="left">
      <i class="bi bi-gear"></i> Users & Roles
    </div>
  </a>

  <div class="divider"></div>
  <div class="smallmuted px-2">
    Tip: Click the "Flow Steps" chips inside <b>BOQ → RFQ → Bids</b> to simulate how your platform works.
  </div>

  <form method="POST" action="{{ route('employer.logout') }}" class="px-1">
  @csrf
  <button type="submit" class="nav-pill nav-pill-logout w-100">
    <div class="left">
      <i class="bi bi-box-arrow-right"></i> Logout
    </div>
  </button>
</form>
</aside>
