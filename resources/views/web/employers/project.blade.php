@extends('layouts.employerapp')

@section('title', 'Project')

@section('page-title', 'Project')
@section('page-subtitle', 'High-level view of procurement activity')

@section('content')

<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h5 class="fw-bold mb-0">Projects</h5>
                    <small class="text-muted">
                        Every RFQ and PO is tagged to a project
                    </small>
                </div>

                <button type="button"
                        class="btn btn-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#projectModal">
                    <i class="bi bi-plus"></i> New Project
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Project</th>
                            <th>Type</th>
                            <th>Location</th>
                            <th>Budget</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>CK • Warehouse RCC Flooring</strong>
                                <div class="small text-muted">Proj-2001</div>
                            </td>
                            <td>Industrial</td>
                            <td>Pune</td>
                            <td>₹68,00,000</td>
                            <td>
                                <span class="badge bg-warning text-dark">Active</span>
                            </td>
                            <td class="text-end">
                                <button type="button"
                                        class="btn btn-outline-primary btn-sm">
                                    Open Procurement
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>CK • Residential Builder Purchase</strong>
                                <div class="small text-muted">Proj-2002</div>
                            </td>
                            <td>Builder</td>
                            <td>Thane</td>
                            <td>₹1,20,00,000</td>
                            <td>
                                <span class="badge bg-secondary">Planning</span>
                            </td>
                            <td class="text-end">
                                <button type="button"
                                        class="btn btn-outline-primary btn-sm">
                                    Open Procurement
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<!-- Project Modal -->
<div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold">Create Project (Demo)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-0">
                <form>

                    <!-- Project Name -->
                    <div class="mb-3">
                        <label class="form-label">Project Name</label>
                        <input type="text"
                               class="form-control"
                               placeholder="e.g., MIDC Shed Procurement">
                    </div>

                    <!-- Type -->
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select">
                            <option>Industrial</option>
                            <option>Residential</option>
                            <option>Builder</option>
                            <option>Infrastructure</option>
                        </select>
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <label class="form-label">Location</label>
                        <input type="text"
                               class="form-control"
                               placeholder="e.g., Pune">
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end gap-2">
                        <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit"
                                class="btn btn-primary">
                            Create
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

@endsection
