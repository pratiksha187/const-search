@extends('layouts.adminapp')

@section('title','Post Agreement Management')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet"
      href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<style>
.page-wrapper{
    background:#f1f5f9;
    padding:40px 0;
}

.main-card{
    max-width:1200px;
    margin:auto;
    background:#ffffff;
    padding:30px;
    border-radius:18px;
    box-shadow:0 20px 50px rgba(15,23,42,.08);
}

.page-title{
    font-size:22px;
    font-weight:700;
    margin-bottom:25px;
    color:#0f172a;
}

.table thead{
    background:#f8fafc;
}

.table th{
    font-size:13px;
    text-transform:uppercase;
    color:#64748b;
}

.status-badge{
    font-size:12px;
    font-weight:600;
    padding:5px 12px;
    border-radius:20px;
}

.status-added{
    background:#dcfce7;
    color:#166534;
}

.status-not{
    background:#fee2e2;
    color:#991b1b;
}

.action-btn{
    padding:6px 12px;
    font-size:13px;
    border-radius:8px;
}
</style>

<div class="page-wrapper">

    <div class="main-card">

        <div class="page-title">
            Post Agreement Management
        </div>

        <div class="table-responsive">

            <table id="postAgreementTable"
                   class="table table-striped table-hover align-middle w-100">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Post Title</th>
                        <th>Agreement Status</th>
                        <th width="220">Action</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($posts as $index => $post)
                    <tr>

                        <td>{{ $index+1 }}</td>

                        <td>
                            <strong>{{ $post->customer_name }}</strong><br>
                            <small class="text-muted">
                                {{ $post->mobile }}
                            </small>
                        </td>

                        <td>{{ $post->title ?? '—' }}</td>

                        {{-- STATUS --}}
                        <td>
                            @if($post->ck_agreement_file)
                                <span class="status-badge status-added">
                                    Agreement Added
                                </span>
                            @else
                                <span class="status-badge status-not">
                                    Not Added
                                </span>
                            @endif
                        </td>

                        {{-- ACTIONS --}}
                        <td>

                            @if($post->ck_agreement_file)

                                {{-- View --}}
                                <a href="{{ asset('storage/'.$post->ck_agreement_file) }}"
                                   target="_blank"
                                   class="btn btn-success btn-sm action-btn">
                                    <i class="bi bi-eye"></i> View
                                </a>

                                {{-- Update --}}
                                <a href="{{ route('admin.post.agreement', $post->id) }}"
                                   class="btn btn-warning btn-sm action-btn">
                                    <i class="bi bi-pencil"></i> Update
                                </a>

                            @else

                                {{-- Add --}}
                                <a href="{{ route('admin.post.agreement', $post->id) }}"
                                   class="btn btn-primary btn-sm action-btn">
                                    <i class="bi bi-plus-circle"></i> Add Agreement
                                </a>

                            @endif

                        </td>

                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function(){

    $('#postAgreementTable').DataTable({
        pageLength: 10,
        lengthMenu: [10,25,50,100],
        responsive: true,
        ordering: true
    });

});
</script>

@endsection
