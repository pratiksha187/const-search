<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>@yield('title', 'ConstructKaro ERP')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-EM9F50FXF3"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-EM9F50FXF3');
    </script>
    @stack('styles')
<style>
    :root{
      --navy:#1c2c3e;
      --orange:#f25c05;
      --bg:#f6f8fb;
      --card:#ffffff;
      --muted:#64748b;
      --line:#e5e7eb;
    }
    body{ background:var(--bg); font-family:system-ui,-apple-system,Segoe UI,Roboto,Inter,Arial,sans-serif; }
    .app{
      display:grid;
      grid-template-columns: 280px 1fr;
      min-height:100vh;
    }
    .sidebar{
      background:linear-gradient(180deg, rgba(28,44,62,1), rgba(15,23,42,1));
      color:#fff;
      padding:18px 14px;
      position:sticky; top:0; height:100vh;
      overflow:auto;
    }
    .brand{
      display:flex; align-items:center; gap:10px;
      padding:10px 10px; border-radius:14px;
      background:rgba(255,255,255,.06);
      margin-bottom:16px;
    }
    .brand .logo{
      width:38px; height:38px; border-radius:12px;
      background:rgba(242,92,5,.18);
      display:flex; align-items:center; justify-content:center;
      border:1px solid rgba(242,92,5,.35);
    }
    .nav-pill{
      display:flex; align-items:center; justify-content:space-between;
      gap:10px; padding:10px 12px; border-radius:14px;
      color:#e2e8f0; text-decoration:none;
      margin:6px 0;
      background:transparent;
      border:1px solid rgba(255,255,255,.06);
      transition:.15s ease;
      cursor:pointer;
    }
    .nav-pill:hover{ background:rgba(255,255,255,.07); }
    .nav-pill.active{
      background:rgba(242,92,5,.14);
      border-color: rgba(242,92,5,.35);
      color:#fff;
    }
    .nav-pill .left{ display:flex; align-items:center; gap:10px; }
    .nav-pill small{
      background:rgba(255,255,255,.10);
      border:1px solid rgba(255,255,255,.12);
      padding:2px 8px; border-radius:99px;
      font-size:11px;
    }
    .content{
      padding:18px 18px 40px;
    }
    .topbar{
      background:var(--card);
      border:1px solid var(--line);
      border-radius:18px;
      padding:14px 16px;
      display:flex; align-items:center; justify-content:space-between; gap:12px;
      box-shadow:0 10px 30px rgba(2,6,23,.06);
      position:sticky; top:12px; z-index:5;
    }
    .title h5{ margin:0; color:var(--navy); font-weight:800; }
    .title .sub{ color:var(--muted); font-size:13px; }
    .chip{
      display:inline-flex; align-items:center; gap:8px;
      padding:8px 12px; border-radius:999px;
      border:1px solid var(--line);
      background:#fff;
      color:var(--navy);
      font-weight:600; font-size:13px;
    }
    .chip .dot{
      width:8px; height:8px; border-radius:99px; background:var(--orange);
      box-shadow:0 0 0 4px rgba(242,92,5,.15);
    }
    .cardx{
      background:var(--card);
      border:1px solid var(--line);
      border-radius:18px;
      box-shadow:0 10px 30px rgba(2,6,23,.06);
    }
    .kpi{
      padding:16px;
    }
    .kpi .label{ color:var(--muted); font-size:12px; font-weight:700; }
    .kpi .value{ color:var(--navy); font-size:22px; font-weight:900; margin-top:6px; }
    .kpi .hint{ color:var(--muted); font-size:12px; margin-top:6px; }
    .btn-ck{
      background:var(--orange); border:none; color:#fff;
      border-radius:14px; padding:10px 14px; font-weight:800;
    }
    .btn-ck:hover{ background:#e65200; color:#fff; }
    .btn-soft{
      background:#fff; border:1px solid var(--line); color:var(--navy);
      border-radius:14px; padding:10px 14px; font-weight:800;
    }
    .stepbar{
      display:flex; flex-wrap:wrap; gap:10px;
      margin-top:14px;
    }
    .step{
      display:flex; align-items:center; gap:10px;
      padding:10px 12px;
      border-radius:16px;
      border:1px dashed #dbe3ef;
      background:#fff;
      cursor:pointer;
      user-select:none;
    }
    .step .num{
      width:28px; height:28px; border-radius:12px;
      background:rgba(28,44,62,.08);
      display:flex; align-items:center; justify-content:center;
      font-weight:900; color:var(--navy);
    }
    .step.done{ border-style:solid; border-color: rgba(16,185,129,.25); }
    .step.done .num{ background:rgba(16,185,129,.14); }
    .step.active{
      border-style:solid;
      border-color: rgba(242,92,5,.35);
      box-shadow:0 12px 30px rgba(242,92,5,.12);
    }
    .table thead th{
      font-size:12px; text-transform:uppercase; letter-spacing:.02em;
      color:var(--muted);
      background:#f8fafc !important;
    }
    .badge-soft{
      background:rgba(28,44,62,.08);
      border:1px solid rgba(28,44,62,.12);
      color:var(--navy);
      border-radius:999px;
      padding:6px 10px;
      font-weight:800;
    }
    .badge-ok{
      background:rgba(16,185,129,.14);
      border:1px solid rgba(16,185,129,.25);
      color:#065f46;
    }
    .badge-warn{
      background:rgba(245,158,11,.14);
      border:1px solid rgba(245,158,11,.25);
      color:#92400e;
    }
    .badge-danger{
      background:rgba(239,68,68,.12);
      border:1px solid rgba(239,68,68,.22);
      color:#991b1b;
    }
    /* .section{ display:none; } */
    .section.active{ display:block; }
    .hintbox{
      background:linear-gradient(135deg, rgba(242,92,5,.14), rgba(255,255,255,1));
      border:1px solid rgba(242,92,5,.22);
      border-radius:18px;
      padding:14px 16px;
    }
    .form-control, .form-select{ border-radius:14px; }
    .modal-content{ border-radius:18px; }
    .smallmuted{ color:var(--muted); font-size:13px; }
    .divider{ height:1px; background:var(--line); margin:14px 0; }

    .nav-pill-logout{
  background: transparent;
  border: 0;
  text-align: left;
  cursor: pointer;
}

.nav-pill-logout:hover{
  background: rgba(220, 38, 38, .08);
  border: 1px solid rgba(220, 38, 38, .25);
}

.nav-pill-logout i{
  color: #dc2626;
}

</style>
</head>

<body>
<div class="app">

    {{-- Sidebar --}}
    @include('layouts.employersidebar')

    <main class="content">
        {{-- Header --}}
        @include('layouts.employerheader')

        {{-- Page Content --}}
        <section class="mt-3">
            @yield('content')
        </section>
    </main>

</div>

@include('layouts.employerfooter')
</body>
</html>
