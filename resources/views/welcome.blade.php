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
                    @foreach ($chats as  $chat)
                    <tr>


                        <td class="px-4 py-3">
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-xs rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-2">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <div>
                                    <span class="fw-medium">
                                        {{ $chat?->agent?->name ?? 'System User #' . ($chat?->id ?? uniqid()) }}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3">
                            @if($chat->status == 'open')
                            <span
                                class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                <i class="fas fa-circle me-1"
                                    style="font-size: 0.5rem;"></i>Open
                            </span>
                            @else
                            <span
                                class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill">
                                <i class="fas fa-circle me-1"
                                    style="font-size: 0.5rem;"></i>Closed
                            </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-muted">
                            <i class="far fa-clock me-1"></i>{{ $chat->last_activity_at->diffForHumans() }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @if($chat->status == 'open')
                            <a href="{{ route('guest.chatBox', ['uuid' => $chat->uuid]) }}"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="far fa-eye me-1"></i>Show
                            </a>
                            @endif
                        </td>
                    </tr>

                    @endforeach

                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white py-3">
        <div class="d-flex justify-content-center">
            {{ $chats->links('pagination::bootstrap-5') }}
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
