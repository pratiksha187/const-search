@extends($layout)

@section('title','Supplier Enquiries')

@section('content')

<style>
:root{
    --navy:#1c2c3e;
    --orange:#f25c05;
    --bg:#f4f6fb;
    --card:#ffffff;
    --text:#0f172a;
    --muted:#64748b;
    --border:#e6ebf2;
    --shadow:0 18px 40px rgba(15,23,42,.08);
    --shadow2:0 10px 22px rgba(15,23,42,.06);
    --radius:18px;
}

/* Page shell */
.ck-page{
    max-width:1480px;
    margin:0 auto;
    padding:0 16px;
}
.ck-stack{ display:flex; flex-direction:column; gap:14px; }

/* Hero header */
.ck-hero{
    border-radius:22px;
    padding:18px 18px;
    color:#fff;
    background:
        radial-gradient(900px 240px at 30% 0%, rgba(242,92,5,.22), transparent 55%),
        linear-gradient(135deg, rgba(28,44,62,1), rgba(28,44,62,.86));
    box-shadow: var(--shadow);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:14px;
}
.ck-hero-left{ display:flex; gap:14px; align-items:flex-start; }
.ck-hero-icon{
    width:50px; height:50px;
    border-radius:16px;
    background:rgba(255,255,255,.10);
    border:1px solid rgba(255,255,255,.14);
    display:flex; align-items:center; justify-content:center;
    backdrop-filter: blur(6px);
    font-size:20px;
}
.ck-hero h2{
    margin:0;
    font-weight:900;
    letter-spacing:.2px;
    font-size:26px;
    line-height:1.1;
}
.ck-hero p{
    margin:6px 0 0;
    color:rgba(255,255,255,.82);
    font-size:13px;
}

/* Total pill */
.ck-pill{
    background:rgba(255,255,255,.92);
    color:var(--text);
    border:1px solid rgba(255,255,255,.65);
    border-radius:999px;
    padding:8px 12px;
    font-weight:900;
    font-size:13px;
    white-space:nowrap;
}

/* Search bar card */
.ck-toolbar{
    background:var(--card);
    border:1px solid var(--border);
    border-radius:20px;
    padding:12px 12px;
    box-shadow: var(--shadow2);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
}
.ck-search{
    position:relative;
    flex:1;
    min-width:260px;
    max-width:520px;
}
.ck-search i{
    position:absolute;
    left:14px; top:50%;
    transform:translateY(-50%);
    color:#94a3b8;
    font-size:14px;
    pointer-events:none;
}
.ck-search input{
    width:100%;
    border:1px solid var(--border);
    background:#fbfdff;
    border-radius:16px;
    padding:11px 12px 11px 38px;
    font-size:14px;
    outline:none;
    transition:.2s ease;
}
.ck-search input:focus{
    background:#fff;
    border-color:rgba(37,99,235,.35);
    box-shadow:0 0 0 4px rgba(37,99,235,.08);
}
.ck-clear{
    border:1px solid #e5e7eb;
    background:#fff;
    color:#334155;
    padding:10px 14px;
    border-radius:999px;
    font-weight:800;
    font-size:13px;
    text-decoration:none;
}
.ck-clear:hover{
    background:#f8fafc;
    color:#0f172a;
}

/* Table card */
.ck-card{
    background:var(--card);
    border:1px solid var(--border);
    border-radius:22px;
    box-shadow: var(--shadow2);
    overflow:hidden;
}
.ck-table{
    width:100%;
    margin:0;
    border-collapse:separate;
    border-spacing:0;
}
.ck-table thead th{
    background:#f8fafc;
    color:#0f172a;
    font-weight:900;
    font-size:13px;
    padding:14px 16px;
    border-bottom:1px solid var(--border);
    white-space:nowrap;
}
.ck-table tbody td{
    padding:16px 16px;
    border-bottom:1px solid #eef2f7;
    vertical-align:middle;
    color:var(--text);
    font-size:14px;
}
.ck-table tbody tr:hover{ background:#fbfdff; }

.ck-id{
    font-weight:900;
    color:#0f172a;
}
.ck-supplier{
    display:flex;
    flex-direction:column;
    gap:2px;
}
.ck-supplier .name{
    font-weight:900;
    line-height:1.15;
}
.ck-supplier .sub{
    font-size:12px;
    color:var(--muted);
}

.ck-loc{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 10px;
    border-radius:999px;
    background:#eef2ff;
    color:#3730a3;
    border:1px solid #e0e7ff;
    font-weight:800;
    font-size:12px;
}
.ck-loc i{ font-size:13px; }

.ck-date{
    display:flex;
    flex-direction:column;
    gap:2px;
}
.ck-date .d{ font-weight:900; }
.ck-date .h{ font-size:12px; color:var(--muted); }

/* Action button */
.ck-btn{
    border:0;
    background:linear-gradient(135deg, #4f46e5, #2563eb);
    color:#fff;
    padding:10px 14px;
    border-radius:999px;
    font-weight:900;
    font-size:13px;
    display:inline-flex;
    align-items:center;
    gap:8px;
    text-decoration:none;
    box-shadow:0 12px 24px rgba(37,99,235,.18);
    white-space:nowrap;
}
.ck-btn:hover{ opacity:.96; color:#fff; }

/* Pagination footer */
.ck-footer{
    padding:12px 14px;
    border-top:1px solid var(--border);
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    flex-wrap:wrap;
    background:#fff;
}
.ck-info{
    font-size:13px;
    color:var(--muted);
    font-weight:700;
}

/* Laravel pagination nicer */
.pagination{ margin:0; }
.page-link{
    border-radius:12px !important;
    margin:0 3px;
    border:1px solid #e5e7eb;
    color:#0f172a;
    font-weight:800;
    font-size:13px;
    padding:9px 12px;
}
.page-item.active .page-link{
    background:var(--orange);
    border-color:var(--orange);
    color:#fff;
}
.page-link:hover{
    background:#fff7ed;
    border-color:#fed7aa;
    color:#9a3412;
}

/* Empty */
.ck-empty{
    padding:46px 14px;
    text-align:center;
    color:var(--muted);
}
.ck-empty .emo{ font-size:30px; }
.ck-empty .t{ margin-top:10px; font-weight:900; color:#0f172a; }
.ck-empty .s{ margin-top:4px; font-size:13px; }

@media(max-width:768px){
    .ck-hero{ flex-direction:column; align-items:flex-start; }
    .ck-hero h2{ font-size:22px; }
}
</style>

<div class="ck-page">
    <div class="ck-stack">

        <!-- TOOLBAR (AUTO SEARCH) -->
        <div class="ck-toolbar">
            <form method="GET" action="{{ url()->current() }}" class="ck-search" id="searchForm">
                <i class="bi bi-search"></i>
                <input
                    type="text"
                    name="q"
                    id="qInput"
                    value="{{ request('q') }}"
                    placeholder="Search supplier, location, ID..."
                    autocomplete="off"
                >
            </form>

            @if(request('q'))
                <a href="{{ url()->current() }}" class="ck-clear">Clear</a>
            @endif
        </div>

        <!-- TABLE -->
        <div class="ck-card">
            <div class="table-responsive">
                <table class="ck-table">
                    <thead>
                        <tr>
                            <th style="width:90px;">Enquiry</th>
                            <th>Supplier</th>
                            <th>Delivery Location</th>
                            <th style="width:160px;">Date</th>
                            <th style="width:150px;">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($enquiries as $row)
                        <tr>
                            <td class="ck-id">#{{ $row->id }}</td>

                            <td>
                                <div class="ck-supplier">
                                    <div class="name">{{ $row->shop_name ?? 'Supplier' }}</div>
                                    <div class="sub">Supplier enquiry record</div>
                                </div>
                            </td>

                            <td>
                                <span class="ck-loc">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ $row->delivery_location ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="ck-date">
                                    <div class="d">{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</div>
                                    <div class="h">{{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</div>
                                </div>
                            </td>

                            <td>
                                <a href="{{ route('supplier.enquiry.show',$row->id) }}" class="ck-btn">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="ck-empty">
                                    <div class="emo">🔎</div>
                                    <div class="t">No enquiries found</div>
                                    <div class="s">Try another keyword or clear the search.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            @if(method_exists($enquiries,'links'))
                <div class="ck-footer">
                    <div class="ck-info">
                        Showing <b>{{ $enquiries->firstItem() ?? 0 }}</b> - <b>{{ $enquiries->lastItem() ?? 0 }}</b>
                        of <b>{{ $enquiries->total() }}</b>
                    </div>
                    <div>
                        {{ $enquiries->appends(request()->query())->links() }}
                    </div>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
(function(){
    const form  = document.getElementById('searchForm');
    const input = document.getElementById('qInput');
    if(!form || !input) return;

    let timer = null;

    input.addEventListener('input', function(){
        clearTimeout(timer);
        timer = setTimeout(() => form.submit(), 450);
    });

    input.addEventListener('keydown', function(e){
        if(e.key === 'Enter'){
            e.preventDefault();
            form.submit();
        }
    });

    // Keep cursor at end after reload
    window.addEventListener('load', () => {
        const v = input.value;
        input.focus();
        input.value = '';
        input.value = v;
    });
})();
</script>

@endsection
