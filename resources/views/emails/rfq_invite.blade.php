<!doctype html>
<html>
<head><meta charset="utf-8"></head>
<body style="font-family:Arial,sans-serif;">
  <h3>New RFQ Invitation</h3>

  <p>Hello {{ $vendor->company_name ?? $vendor->name ?? 'Vendor' }},</p>

  <p>You have been invited to submit a bid for the following RFQ:</p>

  <ul>
    <li><b>RFQ No:</b> {{ $rfq->rfq_no ?? ('RFQ#'.$rfq->id) }}</li>
    <li><b>Title:</b> {{ $rfq->title }}</li>
    <li><b>Bid Deadline:</b> {{ $rfq->bid_deadline ?? '-' }}</li>
    <li><b>Payment Terms:</b> {{ $rfq->payment_terms ?? '-' }}</li>
  </ul>

  <p><b>BOQ file is attached</b> (if available).</p>

  <p>Regards,<br>ConstructKaro</p>
</body>
</html>