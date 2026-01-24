@extends('layouts.suppliersapp')
@section('title', 'Quotes & Orders')

@section('content')
<style>
.qo-container{max-width:1200px;padding:32px}
.qo-title{font-size:30px;font-weight:700}
.qo-subtitle{color:#64748b;margin-bottom:32px}

/* Tabs */
.qo-tabs{display:flex;gap:32px;border-bottom:1px solid #e2e8f0;margin-bottom:32px}
.qo-tab{padding-bottom:12px;font-weight:600;color:#64748b;cursor:pointer}
.qo-tab.active{color:#2563eb;border-bottom:3px solid #2563eb}

/* Card */
.qo-card{
  background:#fff;
  border-radius:14px;
  padding:24px;
  box-shadow:0 6px 18px rgba(0,0,0,.08);
  margin-bottom:24px;
}
.qo-card-header{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-bottom:20px
}
.qo-card-header h3{font-size:18px;font-weight:700}
.qo-card-header p{color:#64748b;font-size:14px}

/* Status */
.status-pill{
  padding:6px 14px;
  font-size:13px;
  font-weight:600;
  border-radius:999px
}
.status-yellow{background:#fef3c7;color:#b45309}
.status-green{background:#dcfce7;color:#15803d}
.status-blue{background:#e0e7ff;color:#1d4ed8}

/* Info grid */
.qo-info{
  display:grid;
  grid-template-columns:repeat(4,1fr);
  gap:24px
}
.qo-info p:first-child{color:#64748b;font-size:13px}
.qo-info p:last-child{font-weight:700;font-size:15px}

/* Buttons */
.qo-actions{margin-top:20px;display:flex;gap:12px}
.btn-primary{
  background:#2563eb;color:#fff;
  padding:10px 18px;border-radius:8px;
  font-weight:600;border:none
}
.btn-outline{
  border:1.5px solid #cbd5e1;
  padding:10px 18px;border-radius:8px;
  font-weight:600;background:#fff
}

/* Tabs content */
.tab-panel{display:none}
.tab-panel.active{display:block}

@media(max-width:768px){
  .qo-info{grid-template-columns:repeat(2,1fr)}
}
</style>

<div class="qo-container">

  <div class="qo-title">Quotes & Orders</div>
  <div class="qo-subtitle">Track your quotations and orders</div>

  <!-- TABS -->
  <div class="qo-tabs">
    <div class="qo-tab active" data-tab="quotes">
      Quotes ({{ $quotes->count() }})
    </div>
    <div class="qo-tab" data-tab="orders">
      Orders ({{ $orders->count() }})
    </div>
  </div>

  <!-- ================= QUOTES ================= -->
  <div class="tab-panel active" data-content="quotes">

    @forelse($quotes as $quote)
    <div class="qo-card">

      <div class="qo-card-header">
        <div>
          <h3>Quote #CKQ-{{ $quote->id }}</h3>
          <p>{{ $quote->shop_name }} • {{ $quote->material_categories_name }}</p>
        </div>

        <span class="status-pill status-yellow">
          Awaiting Response
        </span>
      </div>

      <div class="qo-info">
        <div>
          <p>Quoted Amount</p>
          <p>₹{{ number_format($quote->price) }}</p>
        </div>
        <div>
          <p>Quantity</p>
          <p>{{ $quote->quantity }}</p>
        </div>
        <div>
          <p>Sent On</p>
          <p>{{ \Carbon\Carbon::parse($quote->created_at)->format('d M Y') }}</p>
        </div>
        <div>
          <p>Delivery Time</p>
          <p>{{ $quote->delivery_time }}</p>
        </div>
      </div>

    </div>
    @empty
      <p class="text-muted">No quotes sent yet.</p>
    @endforelse

  </div>

  <!-- ================= ORDERS ================= -->
  <div class="tab-panel" data-content="orders">

    @forelse($orders as $order)
    <div class="qo-card">

      <div class="qo-card-header">
        <div>
          <h3>Order #CKO-{{ $order->id }}</h3>
          <p>{{ $order->shop_name }} • {{ $order->material_categories_name }}</p>
        </div>

        <span class="status-pill status-blue">
          {{ ucfirst($order->status) }}
        </span>
      </div>

      <div class="qo-info">
        <div>
          <p>Order Value</p>
          <p style="color:#16a34a;">₹{{ number_format($order->price) }}</p>
        </div>
        <div>
          <p>Quantity</p>
          <p>{{ $order->quantity }}</p>
        </div>
        <div>
          <p>Order Date</p>
          <p>{{ \Carbon\Carbon::parse($order->updated_at)->format('d M Y') }}</p>
        </div>
        <div>
          <p>Delivery</p>
          <p>{{ $order->delivery_time }}</p>
        </div>
      </div>

      <div class="qo-actions">
        <button class="btn-primary">Update Status</button>
        <button class="btn-outline">View Details</button>
      </div>

    </div>
    @empty
      <p class="text-muted">No active orders.</p>
    @endforelse

  </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
  document.querySelectorAll('.qo-tab').forEach(tab=>{
    tab.addEventListener('click',function(){
      document.querySelectorAll('.qo-tab').forEach(t=>t.classList.remove('active'))
      document.querySelectorAll('.tab-panel').forEach(p=>p.classList.remove('active'))

      this.classList.add('active')
      document.querySelector(
        '.tab-panel[data-content="'+this.dataset.tab+'"]'
      ).classList.add('active')
    })
  })
})
</script>
@endsection
