@extends('layouts.customerapp')

@section('title','Quotation Details')

@section('content')

<div class="card-box">
    <h4 class="mb-3">Quotation Details</h4>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Rate</th>
                <th>Qty</th>
                <th>GST %</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp

            @foreach($quotationItems as $index => $item)
                @php $grandTotal += $item->total; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>₹ {{ number_format($item->rate,2) }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->gst_percent }}%</td>
                    <td>₹ {{ number_format($item->total,2) }}</td>
                    <td>
                        <span class="badge bg-warning">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-end">Grand Total</th>
                <th colspan="2">₹ {{ number_format($grandTotal,2) }}</th>
            </tr>
        </tfoot>
    </table>

    {{-- ACTION BUTTONS --}}
    @if($quotationItems[0]->status === 'pending')
        <form method="POST" action="{{ route('customer.quotation.action') }}">
            @csrf
            <input type="hidden" name="enquiry_id" value="{{ $enquiry->id }}">

            <div class="text-end mt-3">
                <button name="action" value="accepted"
                        class="btn btn-success px-4">
                    Accept Quotation
                </button>

                <button name="action" value="rejected"
                        class="btn btn-danger px-4">
                    Reject Quotation
                </button>
            </div>
        </form>
    @endif
</div>

@endsection
