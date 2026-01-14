@extends('layouts.suppliersapp')
@section('title', 'Quotes & Orders')

@section('content')
<style>
/* Container */
.qo-container {
  max-width: 1200px;
  padding: 32px;
}

/* Heading */
.qo-title {
  font-size: 30px;
  font-weight: 700;
}
.qo-subtitle {
  color: #64748b;
  margin-bottom: 32px;
}

/* Tabs */
.qo-tabs {
  display: flex;
  gap: 32px;
  border-bottom: 1px solid #e2e8f0;
  margin-bottom: 32px;
}
.qo-tab {
  padding-bottom: 12px;
  font-weight: 600;
  color: #64748b;
  cursor: pointer;
}
.qo-tab.active {
  color: #2563eb;
  border-bottom: 3px solid #2563eb;
}

/* Card */
.qo-card {
  background: #fff;
  border-radius: 14px;
  padding: 28px;
  box-shadow: 0 6px 18px rgba(0,0,0,.08);
  margin-bottom: 24px;
}

/* Card Header */
.qo-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
}
.qo-card-header h3 {
  font-size: 20px;
  font-weight: 700;
}
.qo-card-header p {
  color: #64748b;
  font-size: 14px;
}

/* Status */
.status-pill {
  padding: 6px 14px;
  font-size: 13px;
  font-weight: 600;
  border-radius: 999px;
}
.status-yellow {
  background: #fef3c7;
  color: #b45309;
}
.status-blue {
  background: #e0e7ff;
  color: #1d4ed8;
}

/* Info Grid */
.qo-info {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 32px;
}
.qo-info p:first-child {
  color: #64748b;
  font-size: 14px;
}
.qo-info p:last-child {
  font-weight: 700;
  font-size: 16px;
}

/* Buttons */
.qo-actions {
  margin-top: 24px;
  display: flex;
  gap: 12px;
}
.btn-primary {
  background: #2563eb;
  color: #fff;
  padding: 10px 18px;
  border-radius: 8px;
  font-weight: 600;
  border: none;
}
.btn-outline {
  border: 1.5px solid #cbd5e1;
  padding: 10px 18px;
  border-radius: 8px;
  font-weight: 600;
  background: white;
}

/* Responsive */
@media(max-width: 768px){
  .qo-info {
    grid-template-columns: repeat(2,1fr);
  }
}
</style>

<div class="qo-container">

  <div class="qo-title">Quotes & Orders</div>
  <div class="qo-subtitle">Track your quotations and orders</div>

  <div class="qo-tabs">
    <div class="qo-tab active">Quotes (12)</div>
    <div class="qo-tab">Orders (6)</div>
  </div>

  <!-- QUOTE CARD -->
  <div class="qo-card">
    <div class="qo-card-header">
      <div>
        <h3>Quote #CKQ-1023</h3>
        <p>R.K. Infra Pvt Ltd • 80mm Paver Blocks</p>
      </div>
      <span class="status-pill status-yellow">Awaiting Response</span>
    </div>

    <div class="qo-info">
      <div>
        <p>Quoted Amount</p>
        <p>₹6.8L</p>
      </div>
      <div>
        <p>Quantity</p>
        <p>2,500 sq.m</p>
      </div>
      <div>
        <p>Sent On</p>
        <p>Jan 15, 2025</p>
      </div>
      <div>
        <p>Valid Until</p>
        <p>Jan 30, 2025</p>
      </div>
    </div>
  </div>

  <!-- ORDER CARD -->
  <div class="qo-card">
    <div class="qo-card-header">
      <div>
        <h3>Order #CKO-554</h3>
        <p>R.K. Infra Pvt Ltd • 60mm Paver Blocks</p>
      </div>
      <span class="status-pill status-blue">In Delivery</span>
    </div>

    <div class="qo-info">
      <div>
        <p>Order Value</p>
        <p style="color:#16a34a;">₹5.2L</p>
      </div>
      <div>
        <p>Quantity</p>
        <p>2,000 sq.m</p>
      </div>
      <div>
        <p>Order Date</p>
        <p>Jan 10, 2025</p>
      </div>
      <div>
        <p>Delivery</p>
        <p>Jan 20, 2025</p>
      </div>
    </div>

    <div class="qo-actions">
      <button class="btn-primary">Update Status</button>
      <button class="btn-outline">View Details</button>
    </div>
  </div>

</div>
@endsection
