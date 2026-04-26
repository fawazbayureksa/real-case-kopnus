@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Approval Member History</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm profile-card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase small fw-bold">Tanggal</th>
                                    <th class="py-3 text-uppercase small fw-bold">Member</th>
                                    <th class="py-3 text-uppercase small fw-bold">Perubahan Status</th>
                                    <th class="py-3 text-uppercase small fw-bold">Oleh</th>
                                    <th class="py-3 text-uppercase small fw-bold">Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($histories as $history)
                                    <tr>
                                        <td class="ps-4 text-muted small">
                                            {{ $history->created_at->format('d M Y, H:i') }}
                                        </td>
                                        <td>
                                            <div class="fw-bold">{{ $history->member->name }}</div>
                                            <div class="text-muted small">{{ $history->member->member_number }}</div>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $history->old_status ? 'bg-success' : 'bg-danger' }} rounded-pill small">
                                                {{ $history->old_status ? 'ACTIVE' : 'INACTIVE' }}
                                            </span>
                                            <i class="bi bi-arrow-right mx-2 text-muted"></i>
                                            <span
                                                class="badge {{ $history->new_status ? 'bg-success' : 'bg-danger' }} rounded-pill small">
                                                {{ $history->new_status ? 'ACTIVE' : 'INACTIVE' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small fw-bold">{{ $history->user->name }}</div>
                                        </td>
                                        <td>
                                            <div class="small text-wrap" style="max-width: 250px;">{{ $history->note }}
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <p class="mb-0">Belum ada riwayat approval.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($histories->hasPages())
                    <div class="card-footer bg-white border-0 py-3">
                        {{ $histories->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
