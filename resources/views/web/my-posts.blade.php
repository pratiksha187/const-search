@extends('layouts.custapp')

@section('title', 'My Posts')

@section('content')

<style>
:root {
    --navy: #1c2c3e;
    --orange: #f25c05;
    --border: #e5e7eb;
}

/* PAGE WRAP */
.page-wrap {
    background: linear-gradient(180deg, #f6f8fc, #ffffff);
    padding: 30px 0 80px;
}



/* HEADER */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.page-title {
    font-size: 34px;
    font-weight: 800;
    color: var(--navy);
}

.page-subtitle {
    font-size: 14px;
    color: #6b7280;
}

/* ACTION BAR */
.action-bar {
    display: flex;
    gap: 10px;
    align-items: center;
}

.search-input {
    border-radius: 14px;
    border: 1px solid var(--border);
    padding: 10px 14px;
    font-size: 14px;
    width: 240px;
}

.search-input:focus {
    outline: none;
    border-color: var(--orange);
    box-shadow: 0 0 0 3px rgba(242,92,5,0.15);
}

/* ADD BUTTON */
.btn-add {
    background: linear-gradient(135deg, #ff9a3c, #f25c05);
    color: #fff;
    font-weight: 700;
    padding: 10px 18px;
    border-radius: 14px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 10px 25px rgba(242,92,5,0.35);
}

.btn-add:hover {
    color: #fff;
    transform: translateY(-1px);
}

/* COUNT BADGE */
.count-badge {
    background: #eef2ff;
    color: var(--navy);
    font-size: 13px;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 999px;
    display: inline-block;
    margin-bottom: 12px;
}

/* CARD */
.posts-card {
    background: #ffffff;
    border-radius: 22px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.08);
    border: 1px solid var(--border);
    padding: 24px;
}

/* TABLE */
.stylish-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 10px;
}

.stylish-table thead th {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #6b7280;
    padding: 10px;
}

.stylish-table tbody tr {
    background: #f9fafb;
    box-shadow: 0 6px 16px rgba(15,23,42,0.08);
    transition: 0.25s;
}

.stylish-table tbody tr:hover {
    background: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 14px 30px rgba(15,23,42,0.12);
}

.stylish-table td {
    padding: 14px 12px;
    font-size: 14px;
}

/* TYPE BADGE */
.type-pill {
    background: #e0ecff;
    color: #1d4ed8;
    padding: 4px 10px;
    font-size: 12px;
    border-radius: 999px;
    font-weight: 600;
}

/* ACTIONS */
.action-btn {
    border: none;
    background: #f1f5f9;
    padding: 6px 10px;
    border-radius: 10px;
    font-size: 13px;
}

.action-btn:hover {
    background: var(--orange);
    color: #fff;
}

.posted-date {
    font-size: 13px;
    color: #6b7280;
}

.page-container {
    max-width: 1576px;
    margin: auto;
}
</style>

<div class="page-wrap">
<div class="page-container">   <!-- ✅ SINGLE PARENT DIV -->

    <!-- HEADER -->
    <div class="page-header">
        <div>
            <div class="page-title">My Project Posts</div>
            <div class="page-subtitle">
                Track, manage and edit your construction requirements
            </div>
        </div>

        <div class="action-bar">
            <input type="text" id="searchInput" class="search-input" placeholder="Search posts...">
            <a href="{{ route('post') }}" class="btn-add">
                <i class="bi bi-plus-circle"></i> Add Post
            </a>
        </div>
    </div>

    @if($posts->count() == 0)
        <div class="alert alert-info">
            No posts found. <a href="{{ route('post') }}">Create your first project</a>
        </div>
    @else

        <span class="count-badge">
            Total Posts: {{ $posts->total() }}
        </span>

        <div class="posts-card">

            <div class="table-responsive">
                <table class="stylish-table" id="postsTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Project</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Budget</th>
                            <th>Contact</th>
                            <th>Posted</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($posts as $key => $post)
                        <tr>
                            <td>{{ $posts->firstItem() + $key }}</td>
                            <td><strong>{{ $post->title }}</strong></td>
                            <td><span class="type-pill">{{ $post->projecttype_name }}</span></td>
                            <td>{{ $post->city_name }}, {{ $post->region_name }}, {{ $post->state_name }}</td>
                            <td>{{ $post->budget_range }}</td>
                            <td>{{ $post->contact_name }}<br><small>{{ $post->mobile }}</small></td>
                            <td class="posted-date">{{ date('d M Y', strtotime($post->created_at)) }}</td>
                            <td>
                                <button class="action-btn"><i class="bi bi-eye"></i></button>
                                <button class="action-btn"><i class="bi bi-pencil"></i></button>
                                <button onclick="deletePost({{ $post->id }})" class="action-btn">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>

        </div>
    @endif

</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById("searchInput").addEventListener("keyup", function () {
    let value = this.value.toLowerCase();
    document.querySelectorAll("#postsTable tbody tr").forEach(row => {
        row.style.display = row.textContent.toLowerCase().includes(value) ? "" : "none";
    });
});

function deletePost(id) {
    Swal.fire({
        title: 'Delete this post?',
        text: 'This action cannot be undone',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#f25c05',
        confirmButtonText: 'Yes, Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = `/delete-post/${id}`;
        }
    });
}
</script>

@endsection
