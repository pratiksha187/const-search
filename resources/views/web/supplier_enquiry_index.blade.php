@extends($layout)

@section('title','My Supplier Enquiries')

@section('content')

<div class="card-box">
    <h3 class="fw-bold mb-3">📋 Supplier Enquiries</h3>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Supplier</th>
                    <th>Delivery Location</th>
                    <th>Date</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($enquiries as $row)
                <tr>
                    <td>#{{ $row->id }}</td>
                    <td>{{ $row->shop_name }}</td>
                    <td>{{ $row->delivery_location }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->created_at)->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('supplier.enquiry.show',$row->id) }}"
                           class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">
                        No enquiries found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
