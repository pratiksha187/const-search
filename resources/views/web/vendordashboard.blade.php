@extends('layouts.vendorapp')
@section('title', 'Vendor Dashboard | ConstructKaro')

@section('content')
<style>
:root{
  --navy:#0a1b2f;
  --navy2:#0f243b;
  --orange:#f25c05;
  --blue:#2563eb;
  --green:#16a34a;
  --gold:#f59e0b;
  --text:#0f172a;
  --muted:#64748b;
  --border:#e5e7eb;
  --bg:#f6f8fb;
}

body{ background:var(--bg); font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial; }

/* PAGE */
.dashboard-wrap{
  max-width:1450px;
  margin:22px auto 46px;
  padding:0 16px;
}

/* generic card */
.card-soft{
  background:#fff;
  border:1px solid var(--border);
  border-radius:18px;
  padding:18px 20px;
  height:100%;
  box-shadow:0 10px 26px rgba(15,23,42,0.05);
}

/* HERO LEFT */
.hero-title{
  font-size:28px;
  font-weight:900;
  margin:0 0 6px;
  color:var(--text);
}
.hero-sub{
  font-size:14px;
  color:var(--muted);
  margin:0 0 10px;
}
.hero-meta{
  display:flex; gap:10px; flex-wrap:wrap; align-items:center;
}
.pill{
  display:inline-flex; align-items:center; gap:8px;
  padding:8px 12px;
  border-radius:999px;
  font-weight:800;
  font-size:12px;
  border:1px solid var(--border);
  background:#fff;
  color:#111827;
}
.pill.good{ background:#ecfeff; border-color:#bae6fd; color:#0369a1; }
.pill.warn{ background:#fff7ed; border-color:#fed7aa; color:#9a3412; }
.pill i{ font-size:14px; }

.hero-actions{
  margin-top:14px;
  display:flex;
  gap:10px;
  flex-wrap:wrap;
}
.btn-hero{
  border-radius:14px;
  padding:10px 14px;
  font-weight:900;
}
.btn-hero.primary{
  background:linear-gradient(135deg,#4f46e5,#4338ca);
  color:#fff;
  border:none;
}
.btn-hero.primary:hover{ filter:brightness(.95); color:#fff; }
.btn-hero.outline{
  background:#fff;
  border:1px solid var(--border);
  color:#0f172a;
}
.btn-hero.outline:hover{ border-color:#cbd5e1; }

/* CREDITS CARD */
.credits-card{
  background: radial-gradient(900px 420px at 20% 0%, #233b5b 0%, var(--navy2) 45%, var(--navy) 100%);
  border-radius:18px;
  padding:18px;
  color:#fff;
  box-shadow:0 18px 40px rgba(2,10,25,.22);
  border:1px solid rgba(255,255,255,.08);
  height:100%;
  position:relative;
  overflow:hidden;
}
.credits-card:after{
  content:'';
  position:absolute;
  inset:-30px;
  background:radial-gradient(500px 240px at 85% 10%, rgba(242,92,5,.18), transparent 60%);
  pointer-events:none;
}
.credits-card *{ position:relative; z-index:2; }

.credit-ico{
  width:40px; height:40px;
  border-radius:14px;
  background: linear-gradient(135deg, #ff3d7f, #ff7aa8);
  display:flex; align-items:center; justify-content:center;
  font-size:16px;
}
.credits-head{
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
  gap:12px;
}
.credits-title{
  font-weight:900;
  font-size:18px;
  line-height:1.1;
}
.credits-sub{
  font-size:12px;
  color:rgba(255,255,255,.72);
  margin-top:2px;
}
.credits-count{
  text-align:right;
}
.credits-number{
  font-size:46px;
  font-weight:900;
  line-height:1;
}
.credits-available{
  font-size:12px;
  color:rgba(255,255,255,.72);
  margin-top:2px;
}
.divider{
  height:1px;
  background:rgba(255,255,255,.14);
  margin:12px 0;
}
.unlock-title{
  font-size:12px;
  color:rgba(255,255,255,.72);
  margin-bottom:8px;
}
.points .p{
  display:flex; gap:10px;
  align-items:flex-start;
  margin:7px 0;
  font-size:14px;
  color:rgba(255,255,255,.92);
}
.points .p i{
  color:#22c55e;
  font-size:16px;
  margin-top:2px;
}
.hint{
  margin-top:10px;
  font-size:12px;
  color:rgba(255,255,255,.75);
  background:rgba(255,255,255,.06);
  border:1px solid rgba(255,255,255,.12);
  padding:10px 12px;
  border-radius:14px;
}
.credits-actions{
  display:flex; gap:10px; margin-top:12px;
}
.btn-credit{
  flex:1;
  border-radius:14px;
  padding:12px 14px;
  font-weight:900;
  border:none;
}
.btn-credit.primary{
  background:#4f46e5; color:#fff;
}
.btn-credit.primary:hover{ filter:brightness(.95); color:#fff; }
.btn-credit.outline{
  background:rgba(255,255,255,.06);
  border:1px solid rgba(255,255,255,.22);
  color:#fff;
}
.btn-credit.outline:hover{ background:rgba(255,255,255,.10); color:#fff; }

/* KPI */
.kpi-card{
  background:#fff;
  border:1px solid var(--border);
  border-radius:18px;
  padding:18px;
  display:flex;
  justify-content:space-between;
  align-items:center;
  transition:.25s;
  height:100%;
}
.kpi-card:hover{ transform:translateY(-3px); box-shadow:0 16px 34px rgba(15,23,42,0.08); }
.kpi-title{
  font-size:12px; text-transform:uppercase;
  letter-spacing:.5px;
  color:var(--muted);
  font-weight:800;
}
.kpi-value{ font-size:26px; font-weight:900; color:var(--text); }
.kpi-sub{ font-size:12px; color:var(--muted); }
.kpi-icon{
  width:44px; height:44px;
  border-radius:14px;
  display:flex; align-items:center; justify-content:center;
  color:#fff;
}
.bg-orange{background:#f97316;}
.bg-blue{background:#2563eb;}
.bg-gold{background:#f59e0b;}

/* profile completion */
.profile-card{
  background:linear-gradient(135deg,#fff7ed,#ffffff);
  border:1px solid var(--border);
  border-radius:20px;
  padding:18px 20px;
  display:flex;
  align-items:center;
  justify-content:space-between;
  gap:16px;
  box-shadow:0 10px 26px rgba(15,23,42,0.05);
}
.pc-left{
  display:flex; align-items:center; gap:12px;
}
.pc-ico{
  width:52px; height:52px;
  border-radius:16px;
  background:linear-gradient(135deg,#ff9a3c,#f25c05);
  color:#fff;
  display:flex; align-items:center; justify-content:center;
  font-size:22px;
}
.pc-title{ font-weight:900; margin:0; }
.pc-sub{ margin:0; font-size:13px; color:var(--muted); }
.pc-right{ min-width:260px; text-align:right; }
.pc-percent{ font-size:26px; font-weight:900; color:var(--orange); margin-bottom:8px; }
.progress{ height:8px; border-radius:10px; overflow:hidden; background:#eef2f7; }
.progress-bar{ background:linear-gradient(135deg,#ff9a3c,#f25c05); }

/* opportunities */
.table-wrap{
  background:#fff;
  border:1px solid var(--border);
  border-radius:18px;
  padding:18px 18px 10px;
  box-shadow:0 10px 26px rgba(15,23,42,0.05);
}
.section-title{
  font-size:16px;
  font-weight:900;
  margin:0;
}
.table th{
  font-size:12px;
  text-transform:uppercase;
  color:var(--muted);
  letter-spacing:.4px;
}
@media(max-width: 992px){
  .credits-actions{ flex-direction:column; }
  .pc-right{ text-align:left; }
}

/* AGREEMENT HIGHLIGHT */

.agreement-highlight{
    margin-top:18px;
    padding:14px 18px;
    border-radius:14px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap:wrap;
    gap:12px;
    font-size:14px;
    font-weight:600;
}

.agreement-active{
    background:linear-gradient(135deg,#dcfce7,#bbf7d0);
    border:1px solid #22c55e;
    box-shadow:0 8px 20px rgba(34,197,94,.15);
}

.agreement-missing{
    background:linear-gradient(135deg,#fee2e2,#fecaca);
    border:1px solid #ef4444;
    box-shadow:0 8px 20px rgba(239,68,68,.15);
}

.agreement-highlight i{
    font-size:18px;
}

.agreement-btn{
    padding:6px 14px;
    border-radius:8px;
    font-size:13px;
    font-weight:600;
    text-decoration:none;
}

</style>

<div class="dashboard-wrap">
@php
    // ✅ always use real vendor credits
    $credits = (int) ($vendor->lead_balance ?? 0);

    // credit rules
    $smallCost = 30;
    $midCost   = 120;
    $largeCost = 250;

    $smallCount = intdiv($credits, $smallCost);
    $midCount   = intdiv($credits, $midCost);
    $largeCount = intdiv($credits, $largeCost);

    // next unlock hint
    $nextMidNeed = $credits >= $midCost ? 0 : ($midCost - $credits);
    $nextLargeNeed = $credits >= $largeCost ? 0 : ($largeCost - $credits);
@endphp

  {{-- TOP ROW --}}
  <div class="row g-3 align-items-stretch mb-4">

    {{-- HERO LEFT --}}
    <div class="col-lg-7">
      <div class="card-soft">
        <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
          <div>
            <div class="hero-title">Hi {{ $vendor->name }} 👋</div>
            <div class="hero-sub">Track your leads, bids and projects at a glance.</div>
              {{-- AGREEMENT HIGHLIGHT SECTION --}}
              @if(!empty($vendor->custntructkaro_agreement_file))

                  <div class="agreement-highlight agreement-active">

                      <div>
                          <i class="bi bi-shield-check text-success me-2"></i>
                          ConstructKaro Agreement Uploaded & Active
                      </div>

                      <a href="{{ asset('storage/'.$vendor->custntructkaro_agreement_file) }}"
                        target="_blank"
                        class="agreement-btn btn btn-success btn-sm">
                          View Agreement
                      </a>

                  </div>

              @else

                  <div class="agreement-highlight agreement-missing">

                      <div>
                          <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                          Agreement Not Uploaded Yet
                      </div>

                     

                  </div>

              @endif
              <br>
            <div class="hero-meta">
              <span class="pill good">
                <i class="bi bi-shield-check"></i> Verified Vendor
              </span>

              @if(($profilePercent ?? 0) >= 100)
                <span class="pill">
                  <i class="bi bi-check2-circle"></i> Profile Completed
                </span>
              @else
                <span class="pill warn">
                  <i class="bi bi-exclamation-circle"></i> Complete profile for more leads
                </span>
              @endif

              <a href="javascript:void(0)" class="pill" data-bs-toggle="modal" data-bs-target="#howItWorksModal" style="text-decoration:none;">
                <i class="bi bi-play-circle"></i> How it works?
              </a>
            </div>
            

            <div class="hero-actions">
              <a href="{{ route('search_customer') }}" class="btn btn-hero primary">
                <i class="bi bi-search me-1"></i> Browse Projects
              </a>
              <a href="{{ route('vendorsubscription') }}" class="btn btn-hero outline">
                <i class="bi bi-plus-circle me-1"></i> Add Credits
              </a>
              <a href="{{ route('vendorleadhistory') }}" class="btn btn-hero outline">
                <i class="bi bi-clock-history me-1"></i> Lead History
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- CREDITS RIGHT --}}
    <div class="col-lg-5">
      <div class="credits-card">
        <div class="credits-head">
          <div class="d-flex gap-10 align-items-center" style="display:flex;gap:10px;">
            <div class="credit-ico"><i class="bi bi-ticket-perforated-fill"></i></div>
            <div>
              <div class="credits-title">Your Access Credits</div>
              <div class="credits-sub">Use credits to unlock projects</div>
            </div>
          </div>
          <div class="credits-count">
            <div class="credits-number">{{ $credits }}</div>
            <div class="credits-available">credits available</div>
          </div>
        </div>

        <div class="divider"></div>

        <div class="unlock-title">With your credits, you can unlock:</div>
        <div class="points">
          <div class="p">
            <i class="bi bi-check2-circle"></i>
            <div><strong>{{ $smallCount }}</strong> small projects <span style="opacity:.75;">({{ $smallCost }} credits each)</span></div>
          </div>
          <div class="p">
            <i class="bi bi-check2-circle"></i>
            <div><strong>{{ $midCount }}</strong> mid-size projects <span style="opacity:.75;">({{ $midCost }} credits each)</span></div>
          </div>
          <div class="p">
            <i class="bi bi-check2-circle"></i>
            <div><strong>{{ $largeCount }}</strong> large projects <span style="opacity:.75;">({{ $largeCost }} credits each)</span></div>
          </div>
        </div>

        <div class="hint">
          @if($credits < $midCost)
            💡 Add <strong>{{ $nextMidNeed }}</strong> more credits to unlock a <strong>mid-size</strong> project.
          @elseif($credits < $largeCost)
            💡 Add <strong>{{ $nextLargeNeed }}</strong> more credits to unlock a <strong>large</strong> project.
          @else
            ✅ You can unlock <strong>mid-size</strong> and <strong>large</strong> projects now.
          @endif
        </div>

        <div class="credits-actions">
          <a href="{{ route('search_customer') }}" class="btn btn-credit primary">
            <i class="bi bi-search me-1"></i> Browse Projects
          </a>
          <a href="{{ route('vendorsubscription') }}" class="btn btn-credit outline">
            <i class="bi bi-plus-lg me-1"></i> Add Credits
          </a>
        </div>
      </div>
    </div>

  </div>

  {{-- KPI ROW --}}
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="kpi-card">
        <div>
          <div class="kpi-title">Active Leads</div>
          <div class="kpi-value">{{ $ActiveLeads }}</div>
          <div class="kpi-sub">Open opportunities</div>
        </div>
        <div class="kpi-icon bg-orange"><i class="bi bi-briefcase-fill"></i></div>
      </div>
    </div>

    <div class="col-md-4">
      <a href="{{ route('vendorleadhistory') }}" class="text-decoration-none text-dark">
        <div class="kpi-card">
          <div>
            <div class="kpi-title">Lead History</div>
            <div class="kpi-value">{{ $countleadhistory  }}</div>
            <div class="kpi-sub">Under review</div>
          </div>
          <div class="kpi-icon bg-blue"><i class="bi bi-file-earmark-text"></i></div>
        </div>
      </a>
    </div>

    <div class="col-md-4">
      <div class="kpi-card">
        <div>
          <div class="kpi-title">Rating</div>
          <div class="kpi-value">0.0</div>
          <div class="kpi-sub">Profile based</div>
        </div>
        <div class="kpi-icon bg-gold"><i class="bi bi-star-fill"></i></div>
      </div>
    </div>
  </div>

  {{-- PROFILE COMPLETION --}}
  <div class="profile-card mb-4">
    <div class="pc-left">
      <div class="pc-ico"><i class="bi bi-person-check-fill"></i></div>
      <div>
        <p class="pc-title">Complete Your Profile</p>
        <p class="pc-sub">Higher profile completion increases trust & visibility.</p>
      </div>
    </div>

    <div class="pc-right">
      <div class="pc-percent">{{ $profilePercent }}%</div>
      <div class="progress">
        <div class="progress-bar" style="width: {{ $profilePercent }}%"></div>
      </div>
      @if($profilePercent >= 100)
        <div class="mt-2" style="font-size:13px;font-weight:900;color:var(--green);">✅ Profile Fully Completed</div>
      @endif
    </div>
  </div>

  {{-- NEW OPPORTUNITIES --}}
  <div class="table-wrap">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div class="section-title">New Opportunities</div>
      <a href="{{ route('search_customer') }}" class="btn btn-sm btn-outline-primary" style="border-radius:12px;font-weight:900;">
        View All Projects
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead>
          <tr>
            <th>Project</th>
            <th>Location</th>
            <th>Posted</th>
          </tr>
        </thead>
        <tbody>
        @forelse($projects->take(6) as $project)
          <tr>
            <td><strong>{{ $project->title }}</strong></td>
            <td>{{ $project->statename }}, {{ $project->regionname }}, {{ $project->cityname }}</td>
            <td>{{ \Carbon\Carbon::parse($project->created_at)->diffForHumans() }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="3" class="text-center text-muted">No opportunities available</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>
@endsection
