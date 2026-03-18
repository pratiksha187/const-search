<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice - {{ $payment->payment_id }}</title>
    <style>
        @page {
            margin: 18px;
        }

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color:#111;
            margin:0;
            padding:0;
        }

        .invoice-wrap{
            border:1px solid #222;
            padding:0;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        .bordered td,
        .bordered th{
            border:1px solid #222;
        }

        .no-border{
            border:none !important;
        }

        .p-6{ padding:6px; }
        .p-8{ padding:8px; }
        .p-10{ padding:10px; }

        .text-center{ text-align:center; }
        .text-right{ text-align:right; }
        .text-left{ text-align:left; }
        .bold{ font-weight:700; }
        .semi-bold{ font-weight:600; }

        .company-name{
            font-size:22px;
            font-weight:800;
            color:#c85b5b;
            letter-spacing:.5px;
        }

        .company-sub{
            font-size:13px;
            font-weight:700;
            margin-top:4px;
        }

        .small{
            font-size:11px;
            line-height:1.45;
        }

        .xs{
            font-size:10px;
        }

        .label{
            font-weight:700;
            width:120px;
        }

        .heading-cell{
            background:#f2f2f2;
            font-weight:700;
        }

        .section-title{
            font-weight:700;
            font-size:12px;
            background:#f5f5f5;
        }

        .item-head th{
            background:#f2f2f2;
            font-size:11px;
            font-weight:700;
            padding:7px 6px;
        }

        .item-row td{
            padding:8px 6px;
            vertical-align:top;
        }

        .totals-table td{
            padding:6px 8px;
            font-size:11px;
        }

        .signature-box{
            height:90px;
            vertical-align:bottom;
        }

        .terms-box{
            min-height:100px;
            vertical-align:top;
        }

        .bank-box{
            min-height:75px;
            vertical-align:top;
        }

        .w-15{ width:15%; }
        .w-20{ width:20%; }
        .w-25{ width:25%; }
        .w-30{ width:30%; }
        .w-35{ width:35%; }
        .w-40{ width:40%; }
        .w-50{ width:50%; }
        .w-60{ width:60%; }
        .w-70{ width:70%; }

        .mt-4{ margin-top:4px; }
        .mt-6{ margin-top:6px; }
        .mt-8{ margin-top:8px; }

        .amount-words{
            min-height:42px;
            vertical-align:top;
            font-size:11px;
            font-weight:700;
        }

        .footer-note{
            text-align:center;
            font-size:10px;
            margin-top:6px;
        }
    </style>
</head>
<body>
@php
    $responseData = [];
    if (!empty($payment->response)) {
        $decoded = json_decode($payment->response, true);
        if (is_array($decoded)) {
            $responseData = $decoded;
        }
    }

    $invoiceNumber = $invoiceNo ?? ($payment->invoice_no ?? ('CK-INV-' . str_pad($payment->id, 5, '0', STR_PAD_LEFT)));
    $invoiceDate   = $payment->invoice_date
                        ? \Carbon\Carbon::parse($payment->invoice_date)->format('d/m/Y')
                        : ($payment->created_at ? $payment->created_at->format('d/m/Y') : date('d/m/Y'));

    $companyName    = 'Swarajya Construction Private Limited';
    $companyGST     = '27ABOCS3387C1Z0';
    $companyPAN     = 'ABOCS3387C';
    $companyAddress = 'Crescent Pearl B, B-G/1, Veena Nagar, Near St. Anthony Church, Katrang Road, Khopoli, Maharashtra - 410203';

    $buyerName    = $responseData['customer_name'] ?? 'ConstructKaro Vendor';
    $buyerAddress = $responseData['customer_address'] ?? 'Maharashtra, India';
    $buyerGST     = $responseData['customer_gstin'] ?? '-';
    $buyerState   = 'Maharashtra';
    $buyerStateCode = '27';

    $planLabel = ucfirst($payment->plan) . ' Credits Pack';
    $qty       = 1;
    $unitPrice = (float) $payment->base_amount;
    $subtotal  = (float) $payment->base_amount;
    $cgst      = round(((float) $payment->gst_amount) / 2, 2);
    $sgst      = round(((float) $payment->gst_amount) / 2, 2);
    $igst      = 0.00;
    $grandTotal = (float) $payment->amount;

    if (!function_exists('numberToWordsCustom')) {
        function numberToWordsCustom($number)
        {
            $formatter = new \NumberFormatter('en_IN', \NumberFormatter::SPELLOUT);
            return ucwords($formatter->format($number)) . ' Only';
        }
    }

    $amountInWords = 'Rupees ' . numberToWordsCustom(round($grandTotal));
@endphp

<div class="invoice-wrap">
    <table class="bordered">
        <tr>
            <td class="p-8 w-60" valign="top">
                <div class="company-name text-center">{{ $companyName }}</div>
                <div class="company-sub text-center">Construction Services & Credit Access</div>

                <div class="small mt-8">
                    <strong>Address:</strong> {{ $companyAddress }}<br>
                    <strong>Mobile:</strong> {{ $responseData['customer_contact'] ?? '-' }}
                </div>
            </td>

            <td class="w-40" valign="top" style="padding:0;">
                <table class="bordered">
                    <tr>
                        <td class="p-6 label">GSTIN</td>
                        <td class="p-6">{{ $companyGST }}</td>
                    </tr>
                    <tr>
                        <td class="p-6 label">PAN No.</td>
                        <td class="p-6">{{ $companyPAN }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="p-6 text-center bold">TAX INVOICE</td>
                    </tr>
                    <tr>
                        <td class="p-6 label">Invoice No.</td>
                        <td class="p-6">{{ $invoiceNumber }}</td>
                    </tr>
                    <tr>
                        <td class="p-6 label">Invoice Date</td>
                        <td class="p-6">{{ $invoiceDate }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="bordered">
        <tr>
            <td class="p-6 bold section-title" colspan="2">Buyer's Name & Address</td>
            <td class="p-6 bold section-title" colspan="2">Invoice Details</td>
        </tr>
        <tr>
            <td class="p-6 label">Name</td>
            <td class="p-6">{{ $buyerName }}</td>
            <td class="p-6 label">SAC CODE</td>
            <td class="p-6">9983</td>
        </tr>
        <tr>
            <td class="p-6 label">Address</td>
            <td class="p-6">{{ $buyerAddress }}</td>
            <td class="p-6 label">SERVICE</td>
            <td class="p-6">{{ $planLabel }}</td>
        </tr>
        <tr>
            <td class="p-6 label">GSTIN</td>
            <td class="p-6">{{ $buyerGST }}</td>
            <td class="p-6 label">MONTH</td>
            <td class="p-6">{{ $payment->created_at ? $payment->created_at->format('M-y') : date('M-y') }}</td>
        </tr>
        <tr>
            <td class="p-6 label">State</td>
            <td class="p-6">{{ $buyerState }}</td>
            <td class="p-6 label">Payment ID</td>
            <td class="p-6">{{ $payment->payment_id }}</td>
        </tr>
        <tr>
            <td class="p-6 label">State Code</td>
            <td class="p-6">{{ $buyerStateCode }}</td>
            <td class="p-6 label">Place of Supply</td>
            <td class="p-6">Maharashtra</td>
        </tr>
    </table>

    <table class="bordered">
        <thead class="item-head">
            <tr>
                <th style="width:8%;">SL. No.</th>
                <th style="width:42%;">Particulars</th>
                <th style="width:15%;">HSN / SAC</th>
                <th style="width:10%;">Qty</th>
                <th style="width:12%;">Rate</th>
                <th style="width:13%;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr class="item-row">
                <td class="text-center">1</td>
                <td>
                    {{ $planLabel }}<br>
                    <span class="small">
                        Payment Order ID: {{ $payment->order_id }}<br>
                        Payment Status: {{ ucfirst($payment->status ?? 'success') }}
                    </span>
                </td>
                <td class="text-center">9983</td>
                <td class="text-center">{{ $qty }}</td>
                <td class="text-right">{{ number_format($unitPrice, 2) }}</td>
                <td class="text-right">{{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <td style="height:130px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table class="bordered">
        <tr>
            <td class="p-8 amount-words w-60">
                Total Invoice Value In Words: {{ $amountInWords }}
            </td>
            <td class="w-40" style="padding:0;">
                <table class="bordered totals-table">
                    <tr>
                        <td class="bold">Total Amount Before Tax</td>
                        <td class="text-right bold">{{ number_format($subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Add: CGST 9%</td>
                        <td class="text-right">{{ number_format($cgst, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Add: SGST 9%</td>
                        <td class="text-right">{{ number_format($sgst, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Add: IGST 0%</td>
                        <td class="text-right">{{ number_format($igst, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="bold">Tax Amount : GST</td>
                        <td class="text-right bold">{{ number_format((float)$payment->gst_amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td class="bold">Total Amount After Tax</td>
                        <td class="text-right bold">{{ number_format($grandTotal, 2) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="bordered">
        <tr>
            <td class="p-8 terms-box w-60">
                <div class="bold">CERTIFICATE :</div>
                <div class="small">
                    Certified that the particulars given above are true & correct and the amount indicated in this invoice represents the price actually charged by us and that there is no flow of additional consideration either directly or indirectly from the buyer.
                </div>

                <div class="bold mt-8">Terms & Conditions :</div>
                <div class="small">
                    1) Payment once made towards credits / service access is non-refundable.<br>
                    2) Credits added to wallet are valid as per platform policy.<br>
                    3) This invoice is system generated against successful Razorpay payment.<br>
                    4) Subject to Khopoli Jurisdiction.
                </div>
            </td>

            <td class="p-8 signature-box w-40 text-center">
                <div class="bold">For {{ $companyName }}</div>
                <div style="height:45px;"></div>
                <div class="semi-bold">Authorised Signatory</div>
            </td>
        </tr>
    </table>

    <table class="bordered">
        <tr>
            <td class="p-8 bank-box w-60">
                <div class="bold">Bank Details :</div>
                <div class="small mt-4">
                    <strong>Bank Name :</strong> Bank of Baroda<br>
                    <strong>Bank Branch :</strong> Khopoli<br>
                    <strong>Bank A/c No. :</strong> 99870200000388<br>
                    <strong>Bank IFSC Code :</strong> BARB0DBKHOP
                </div>
            </td>
            <td class="p-8 bank-box w-40 text-center">
                <div class="semi-bold" style="margin-top:38px;">Receiver Signature</div>
            </td>
        </tr>
    </table>
</div>

<div class="footer-note">
    Subject to Khopoli Jurisdiction
</div>

</body>
</html>