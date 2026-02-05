@extends('layouts.suppliersapp')

@section('title','Send Quotation')

@section('content')

<style>
.card-box{
    background:#fff;
    border-radius:16px;
    padding:24px;
    box-shadow:0 10px 30px rgba(0,0,0,.08)
}
.label{
    font-weight:600;
    font-size:13px;
    color:#334155
}
.table th{
    font-size:12px;
    text-transform:uppercase;
    color:#64748b;
}
</style>

<div class="card-box">
    <h4 class="mb-3">Send Quotation</h4>

    <form method="POST" action="{{ route('supplier.quotation.send') }}">
        @csrf

        {{-- HEADER INFO --}}
        <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">

        <div class="row mb-4">
            <div class="col-md-3">
                <label class="label">Customer</label>
                <input class="form-control" value="{{ $user->name }}" readonly>
            </div>

            <div class="col-md-3">
                <label class="label">Email</label>
                <input class="form-control" value="{{ $user->email }}" readonly>
            </div>

            <div class="col-md-3">
                <label class="label">Mobile</label>
                <input class="form-control" value="{{ $user->mobile }}" readonly>
            </div>

            <div class="col-md-3">
                <label class="label">Required By</label>
                <input class="form-control"
                       value="{{ \Carbon\Carbon::parse($enquiry->required_by)->format('d M Y') }}"
                       readonly>
            </div>
        </div>

        {{-- ITEMS TABLE --}}
        <div class="mb-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Material Details</th>
                        <th width="100">Qty</th>
                        <th width="120">Rate (₹)</th>
                        <th width="100">GST %</th>
                        <th width="140">Total (₹)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            {{-- MATERIAL DETAILS --}}
                            <td>
                                <strong>{{ trim($item->category) }}</strong><br>
                                <small class="text-muted">
                                    {{ $item->product }}
                                    @if($item->spec)
                                        – {{ $item->spec }}
                                    @endif
                                </small>
                            </td>

                            {{-- QTY --}}
                            <td>
                                <input type="number"
                                       name="items[{{ $index }}][qty]"
                                       class="form-control form-control-sm qty"
                                       value="{{ $item->qty }}">
                            </td>

                            {{-- RATE --}}
                            <td>
                                <input type="number"
                                       name="items[{{ $index }}][price]"
                                       class="form-control form-control-sm price"
                                       value="{{ $item->price }}">
                            </td>

                            {{-- GST --}}
                            <td>
                                <input type="number"
                                       name="items[{{ $index }}][gst]"
                                       class="form-control form-control-sm gst"
                                       value="{{ $item->gst_percent }}">
                            </td>

                            {{-- TOTAL --}}
                            <!-- <td class="fw-bold">
                                ₹ {{ number_format($item->total, 2) }}
                            </td> -->
                            <td class="fw-bold row-total">
                                ₹ <span class="rowTotal">{{ number_format($item->total, 2) }}</span>
                            </td>

                            {{-- hidden id --}}
                            <input type="hidden"
                                   name="items[{{ $index }}][item_id]"
                                   value="{{ $item->id }}">
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No items found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <th colspan="5" class="text-end">Grand Total</th>
                        <th class="fw-bold">
                            ₹ <span id="grandTotal">0.00</span>
                        </th>
                    </tr>
                </tfoot>

            </table>
        </div>

        {{-- REMARKS --}}
        <div class="mb-3">
            <label class="label">Remarks</label>
            <textarea name="remarks"
                      class="form-control"
                      rows="3"
                      placeholder="Delivery terms, payment terms, validity, notes"></textarea>
        </div>

        {{-- SUBMIT --}}
        <div class="text-end">
            <button class="btn btn-primary px-4">
                Send Quotation
            </button>
        </div>
    </form>
</div>

<script>
function calculateTotals() {
    let grandTotal = 0;

    document.querySelectorAll('tbody tr').forEach(function (row) {

        let qty   = parseFloat(row.querySelector('.qty')?.value)   || 0;
        let price = parseFloat(row.querySelector('.price')?.value) || 0;
        let gst   = parseFloat(row.querySelector('.gst')?.value)   || 0;

        let amount = qty * price;
        let gstAmt = (amount * gst) / 100;
        let total  = amount + gstAmt;

        row.querySelector('.rowTotal').innerText = total.toFixed(2);

        grandTotal += total;
    });

    document.getElementById('grandTotal').innerText = grandTotal.toFixed(2);
}

// Trigger calculation on input change
document.addEventListener('input', function (e) {
    if (
        e.target.classList.contains('qty') ||
        e.target.classList.contains('price') ||
        e.target.classList.contains('gst')
    ) {
        calculateTotals();
    }
});

// Calculate once on page load
document.addEventListener('DOMContentLoaded', calculateTotals);
</script>

@endsection
