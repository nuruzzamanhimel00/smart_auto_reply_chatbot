@extends('layout.app')

@section('content')

<!-- Previous Chats Table -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-history me-2 text-primary"></i>Previous Chats
            </h5>

        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>

                        <th class="px-4 py-3 fw-semibold">Agent Name</th>
                        <th class="px-4 py-3 fw-semibold">Status</th>
                        <th class="px-4 py-3 fw-semibold">Last Activity</th>
                        <th class="px-4 py-3 fw-semibold text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <span class="fw-medium">John Doe</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user-tie text-success"></i>
                                </div>
                                <span>Sarah Miller</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                <i class="fas fa-circle me-1"
                                    style="font-size: 0.5rem;"></i>Active
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted">
                            <i class="far fa-clock me-1"></i>2 minutes ago
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="far fa-eye me-1"></i>Show
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <span class="fw-medium">Emma Wilson</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user-tie text-success"></i>
                                </div>
                                <span>Michael Brown</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">
                                <i class="fas fa-circle me-1"
                                    style="font-size: 0.5rem;"></i>Pending
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted">
                            <i class="far fa-clock me-1"></i>15 minutes ago
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="far fa-eye me-1"></i>Show
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <span class="fw-medium">Robert Johnson</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user-tie text-success"></i>
                                </div>
                                <span>Sarah Miller</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">
                                <i class="fas fa-circle me-1"
                                    style="font-size: 0.5rem;"></i>Closed
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted">
                            <i class="far fa-clock me-1"></i>1 hour ago
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="far fa-eye me-1"></i>Show
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <span class="fw-medium">Lisa Anderson</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user-tie text-success"></i>
                                </div>
                                <span>Michael Brown</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                <i class="fas fa-circle me-1"
                                    style="font-size: 0.5rem;"></i>Active
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted">
                            <i class="far fa-clock me-1"></i>30 minutes ago
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="far fa-eye me-1"></i>Show
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <span class="fw-medium">David Martinez</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user-tie text-success"></i>
                                </div>
                                <span>Jennifer Lee</span>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="badge bg-warning-subtle text-warning px-3 py-2 rounded-pill">
                                <i class="fas fa-circle me-1"
                                    style="font-size: 0.5rem;"></i>Pending
                            </span>
                        </td>
                        <td class="px-4 py-3 text-muted">
                            <i class="far fa-clock me-1"></i>45 minutes ago
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="#"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="far fa-eye me-1"></i>Show
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        <div class="d-flex justify-content-between align-items-center">
            <span class="text-muted small">Showing 1 to 5 of 156 entries</span>
            <nav>
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@push('style')

@endpush

@push('script')
<script>
    // Auto-refresh table every 30 seconds (optional)
    // setInterval(function() {
    //     location.reload();
    // }, 30000);
</script>
@endpush
