<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $payment->payment_id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; color: #111; line-height: 1.4; }
        .header, .footer { text-align: center; }
        .company { font-weight: bold; font-size: 18px; }
        .details, .items, .totals { width: 100%; margin-top: 20px; border-collapse: collapse; }
        .details td { padding: 4px 0; }
        .items th, .items td { border: 1px solid #000; padding: 8px; text-align: left; }
        .totals td { padding: 4px 8px; }
        .right { text-align: right; }
        .bold { font-weight: bold; }
        .notes { margin-top: 20px; }
    </style>
</head>
<body>

<div class="header">
    <div class="company">SWARAJ CONSTRUCTION</div>
    <div>Address: Crescent Pearl B, B-G/1, Veena Nagar, Near St. Anthony Church, Katrang Road, Khopoli, Maharashtra – 410203</div>
    <div>GSTIN: 27ABOCS3387C1Z0</div>
    <hr>
</div>

<table class="details">
    <tr>
        <td>Invoice No: SC-INV-{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</td>
        <td>Invoice Date: {{ $payment->created_at->format('d M Y') }}</td>
    </tr>
    <tr>
        <td>Bill To: </td>
        <td>Customer Phone: {{ $payment->user_id ? $payment->user->phone ?? '' : '' }}</td>
    </tr>
</table>

<h4>Payment Details</h4>
<table class="details">
    <tr><td>Payment Gateway</td><td>Razorpay</td></tr>
    <tr><td>Payment Method</td><td>{{ $payment->response['method'] ?? 'UPI' }}</td></tr>
    <tr><td>Payment ID</td><td>{{ $payment->payment_id }}</td></tr>
    <tr><td>Order ID</td><td>{{ $payment->order_id }}</td></tr>
</table>

<h4>Item Details</h4>
<table class="items">
    <thead>
        <tr>
            <th>No</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Unit Price (₹)</th>
            <th>Amount (₹)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>{{ ucfirst($payment->plan) }} Credits Pack</td>
            <td>1</td>
            <td class="right">{{ number_format($payment->base_amount, 2) }}</td>
            <td class="right">{{ number_format($payment->base_amount, 2) }}</td>
        </tr>
    </tbody>
</table>

<table class="totals">
    <tr>
        <td class="right bold">Subtotal:</td>
        <td class="right">₹{{ number_format($payment->base_amount, 2) }}</td>
    </tr>
    <tr>
        <td class="right bold">GST (18%):</td>
        <td class="right">₹{{ number_format($payment->gst_amount, 2) }}</td>
    </tr>
    <tr>
        <td class="right bold">TOTAL AMOUNT PAID:</td>
        <td class="right">₹{{ number_format($payment->amount, 2) }}</td>
    </tr>
</table>

<div class="notes">
    <p>Notes: Plan – {{ ucfirst($payment->plan) }} | Platform – ConstructKaro</p>
    <p>Payment Status: PAID</p>
</div>

<div class="footer">
    <p>Authorized Signatory</p>
    <p>Swaraj Construction</p>
    <p>Thank you for your business!</p>
</div>

</body>
</html>