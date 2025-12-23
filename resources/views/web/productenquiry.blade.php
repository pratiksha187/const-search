@extends('layouts.suppliersapp')

@section('title','Product Enquiries | ConstructKaro')

@section('content')

<style>
:root{
  --navy:#0f172a;
  --orange:#f25c05;
  --border:#e5e7eb;
  --bg:#f6f8fb;
  --card:#ffffff;
  --muted:#64748b;
}

/* Page */
.enquiry-page{
  max-width:1300px;
  margin:auto;
  padding:24px;
}

/* Card */
.enquiry-card{
  background:#fff;
  border:1px solid var(--border);
  border-radius:18px;
  padding:20px;
  margin-bottom:18px;
}

/* Header */
.enquiry-head{
  display:flex;
  justify-content:space-between;
  align-items:flex-start;
}

.enquiry-head h5{
  margin:0;
  font-weight:700;
}

.enquiry-head small{
  color:var(--muted);
}

/* Badges */
.badge-pill{
  padding:6px 14px;
  border-radius:999px;
  font-size:12px;
  font-weight:600;
}

.badge-cash{ background:#fff7ed; color:#9a3412; }
.badge-online{ background:#ecfeff; color:#155e75; }
.badge-credit{ background:#ecfdf5; color:#065f46; }

/* Body */
.enquiry-grid{
  display:grid;
  grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
  gap:14px;
  margin-top:16px;
}

.info-box{
  font-size:14px;
}

.info-box label{
  display:block;
  font-size:12px;
  color:var(--muted);
}

/* Footer */
.enquiry-footer{
  display:flex;
  justify-content:space-between;
  align-items:center;
  margin-top:18px;
  border-top:1px dashed var(--border);
  padding-top:14px;
}

.btn-view{
  background:var(--navy);
  color:#fff;
  padding:8px 18px;
  border-radius:12px;
  border:none;
  font-size:14px;
  font-weight:600;
}

.file-link{
  display:inline-block;
  margin-right:10px;
  font-size:13px;
}
</style>

<div class="enquiry-page">

  <h4 class="mb-4">📩 Product Enquiries</h4>

@forelse($enquiries as $enquiry)

@php
  $attachments = [];
  if (!empty($enquiry->attachments)) {
      $decoded = json_decode($enquiry->attachments, true);
      if (is_array($decoded)) {
          $attachments = $decoded;
      }
  }
@endphp

<div class="enquiry-card">

  {{-- HEADER --}}
  <div class="enquiry-head">
    <div>
      <h5>{{ $enquiry->category ?? 'General Enquiry' }}</h5>
      <small>
        Supplier ID: {{ $enquiry->supplier_id }}
        • {{ \Carbon\Carbon::parse($enquiry->created_at)->format('d M Y, h:i A') }}
      </small>
    </div>

    <span class="badge-pill 
      {{ $enquiry->payment_preference === 'credit' ? 'badge-credit' : 
         ($enquiry->payment_preference === 'online' ? 'badge-online' : 'badge-cash') }}">
      {{ ucfirst($enquiry->payment_preference) }}
    </span>
  </div>

  {{-- BODY --}}
  <div class="enquiry-grid">
    <div class="info-box">
      <label>Quantity</label>
      {{ $enquiry->quantity ?? '-' }}
    </div>

    <div class="info-box">
      <label>Delivery Location</label>
      {{ $enquiry->delivery_location ?? '-' }}
    </div>

    <div class="info-box">
      <label>Required By</label>
      {{ $enquiry->required_by ?? '-' }}
    </div>

    <div class="info-box">
      <label>Specs</label>
      {{ $enquiry->specs ?? '-' }}
    </div>
  </div>

  {{-- FOOTER --}}
  <div class="enquiry-footer">
    <div>
      @if(count($attachments))
        @foreach($attachments as $file)
          <a href="{{ asset('storage/'.$file) }}" target="_blank" class="file-link">
            📎 Attachment
          </a>
        @endforeach
      @else
        <span class="text-muted">No attachments</span>
      @endif
    </div>

    <button class="btn-view">View / Respond</button>
  </div>

</div>

@empty
<p class="text-muted">No enquiries found.</p>
@endforelse


</div>

@endsection
