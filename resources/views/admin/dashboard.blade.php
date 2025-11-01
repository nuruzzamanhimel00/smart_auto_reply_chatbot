@extends('admin.layouts.app')


@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h2 class="fw-bold mb-0">
                <i class="bi bi-speedometer2 me-2"></i>Chat Management Dashboard
            </h2>
            <p class="text-muted">
                <i class="bi bi-eye me-1"></i>Monitor and manage all chat conversations
            </p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">
                                <i class="bi bi-chat-dots-fill me-1"></i>Total Chats
                            </p>
                            <h3 class="fw-bold mb-0">{{ number_format($stats['total_chats']) }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <i class="bi bi-chat-dots fs-4 text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">
                                <i class="bi bi-chat-left-text-fill me-1"></i>Open Chats
                            </p>
                            <h3 class="fw-bold mb-0">{{ number_format($stats['open_chats']) }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded">
                            <i class="bi bi-chat-left-text fs-4 text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">
                                <i class="bi bi-check-circle-fill me-1"></i>Assigned Chats
                            </p>
                            <h3 class="fw-bold mb-0">{{ number_format($stats['assigned_chats']) }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <i class="bi bi-check-circle fs-4 text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="text-muted mb-1 small">
                                <i class="bi bi-people-fill me-1"></i>Active Agents
                            </p>
                            <h3 class="fw-bold mb-0">{{ number_format($stats['active_agents']) }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <i class="bi bi-people fs-4 text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Chats Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom py-3">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-clock-history me-2"></i>Recent Conversations
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-4 py-3">
                                <i class="bi bi-person-circle me-1"></i>Guest
                            </th>
                            <th class="border-0 py-3">
                                <i class="bi bi-info-circle me-1"></i>Status
                            </th>
                            <th class="border-0 py-3">
                                <i class="bi bi-person-badge me-1"></i>Assigned Agent
                            </th>
                            <th class="border-0 py-3">
                                <i class="bi bi-chat-square-text me-1"></i>Latest Message
                            </th>
                            <th class="border-0 py-3">
                                <i class="bi bi-clock me-1"></i>Last Activity
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($chats as $chat)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <span class="fw-bold text-primary">{{ strtoupper(substr($chat->guest->name ?? 'G', 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-semibold">
                                            <i class="bi bi-person-fill text-muted me-1" style="font-size: 0.85rem;"></i>
                                            {{ $chat->guest->name ?? 'Guest' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3">
                                @if($chat->status === 'open')
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-unlock-fill me-1"></i>Open
                                    </span>
                                @else
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-lock-fill me-1"></i>Closed
                                    </span>
                                @endif
                            </td>
                            <td class="py-3">
                                @if($chat->agent)
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px;">
                                            <span class="small fw-bold text-success">{{ strtoupper(substr($chat->agent->name, 0, 1)) }}</span>
                                        </div>
                                        <span class="small">
                                            <i class="bi bi-person-check-fill text-success me-1" style="font-size: 0.75rem;"></i>
                                            {{ $chat->agent->first_name }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-muted small">
                                        <i class="bi bi-person-x me-1"></i>Unassigned
                                    </span>
                                @endif
                            </td>
                            <td class="py-3">
                                <div class="text-truncate" style="max-width: 250px;">
                                    @if($chat->latestMessage)
                                        <small class="text-muted">
                                            <i class="bi bi-chat-right-quote me-1"></i>
                                            {{ Str::limit($chat->latestMessage->content, 50) }}
                                        </small>
                                    @else
                                        <small class="text-muted fst-italic">
                                            <i class="bi bi-inbox me-1"></i>No messages yet
                                        </small>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3">
                                <small class="text-muted">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ $chat->last_activity_at->diffForHumans() }}
                                </small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-chat-dots fs-1 d-block mb-3"></i>
                                    <p><i class="bi bi-exclamation-circle me-1"></i>No chats found</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($chats->hasPages())
        <div class="card-footer bg-white border-top">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    <i class="bi bi-file-text me-1"></i>
                    Showing {{ $chats->firstItem() }} to {{ $chats->lastItem() }} of {{ $chats->total() }} results
                </div>
                <div>
                    {{ $chats->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    .table > :not(caption) > * > * {
        padding: 1rem 0.75rem;
    }
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
    }
    .table thead th i {
        opacity: 0.7;
    }
</style>
@endpush
