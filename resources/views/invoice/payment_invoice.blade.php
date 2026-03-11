<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body{font-family: DejaVu Sans; font-size:14px;}
.header{margin-bottom:20px;}
.title{font-size:22px;font-weight:bold;}
.table{width:100%;border-collapse:collapse;margin-top:20px;}
.table th,.table td{border:1px solid #ddd;padding:8px;}
.total{font-weight:bold;}
</style>
</head>

<body>

<div class="header">
<div class="title">ConstructKaro Invoice</div>
<p>Payment ID: {{ $payment->payment_id }}</p>
<p>Order ID: {{ $payment->order_id }}</p>
<p>Date: {{ $payment->created_at->format('d M Y') }}</p>
</div>

<table class="table">
<tr>
<th>Description</th>
<th>Amount</th>
</tr>

<tr>
<td>Plan: {{ ucfirst($payment->plan) }} Credits Pack</td>
<td>₹{{ number_format($payment->base_amount,2) }}</td>
</tr>

<tr>
<td>GST (18%)</td>
<td>₹{{ number_format($payment->gst_amount,2) }}</td>
</tr>

<tr class="total">
<td>Total</td>
<td>₹{{ number_format($payment->amount,2) }}</td>
</tr>

</table>

<p style="margin-top:30px;">
Credits Added: {{ $payment->credits_added ?? '-' }}
</p>

</body>
</html>