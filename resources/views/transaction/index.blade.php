@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Transaksi</h2>
            </div>
            <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                data-bs-target="#createTransactionModal">
                <i class="bi bi-plus-lg me-2"></i> Buat Transaksi
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger border-0 shadow-sm mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <div class="card border-0 shadow-sm profile-card">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="py-3 text-uppercase small fw-bold">Member</th>
                                    <th class="py-3 text-uppercase small fw-bold">Reference ID</th>
                                    <th class="py-3 text-uppercase small fw-bold">Amount</th>
                                    <th class="py-3 text-uppercase small fw-bold">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions as $transaction)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <span class="d-block fw-bold">{{ $transaction->member->name }}</span>
                                                    <span
                                                        class="text-muted small">{{ $transaction->member->member_number }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="py-1 rounded text-primary">#
                                                {{ $transaction->reference_id }}</span>
                                        </td>
                                        <td class="fw-bold">
                                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </td>
                                        <td class="text-muted small">
                                            {{ $transaction->created_at->format('d M Y, H:i') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-receipt mb-3 d-block"
                                                    style="font-size: 3rem; opacity: 0.3;"></i>
                                                <p class="mb-0">Belum ada data transaksi.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($transactions->hasPages())
                    <div class="card-footer bg-white border-0 py-3">
                        {{ $transactions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Create Transaction Modal --}}
    <div class="modal fade" id="createTransactionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Buat Transaksi Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body py-4">
                        <div class="mb-3">
                            <label for="member_id" class="info-label">Pilih Member (Active Only)</label>
                            <select name="member_id" id="member_id" class="form-select rounded-pill" required>
                                <option value="">-- Pilih Member --</option>
                                @foreach ($members as $member)
                                    <option value="{{ $member->id }}">{{ $member->name }}
                                        ({{ $member->member_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="reference_id" class="info-label">Reference ID</label>
                            <input type="text" name="reference_id" id="reference_id" class="form-control rounded-pill" required>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="info-label">Jumlah (Amount)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light rounded-pill-start border-end-0">Rp</span>
                                <input type="number" name="amount" id="amount" class="form-control rounded-pill-end"
                                    placeholder="0" min="1" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm"
                            data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">Proses Transaksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<style>
    .bg-soft-primary {
        background-color: rgba(13, 110, 253, 0.1);
    }

    .rounded-pill-start {
        border-top-left-radius: 50rem !important;
        border-bottom-left-radius: 50rem !important;
    }

    .rounded-pill-end {
        border-top-right-radius: 50rem !important;
        border-bottom-right-radius: 50rem !important;
    }
</style>
