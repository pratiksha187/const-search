@extends('layouts.adminapp')

@section('title','Add Post Agreement')

@section('content')

<div class="container mt-4">

    <div class="card shadow border-0 rounded-4 p-4">

        <h4 class="fw-bold mb-4">Add Agreement for Post</h4>

        {{-- POST INFO --}}
        <div class="mb-4 p-3 bg-light rounded">
            <strong>Customer:</strong> {{ $post->customer_name }} <br>
            <strong>Mobile:</strong> {{ $post->mobile }} <br>
            <strong>Post:</strong> {{ $post->title ?? '—' }}
        </div>

        <form method="POST"
              action="{{ route('admin.post.agreement.store', $post->id) }}"
              enctype="multipart/form-data">

            @csrf

           

            <div class="mb-3">
                <label class="form-label">Upload Agreement (PDF)</label>
                <input type="file"
                       name="agreement_file"
                       class="form-control"
                       accept="application/pdf"
                       required>
            </div>

            <div class="text-end">
                <button class="btn btn-primary">
                    Save Agreement
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
