@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="fw-bold mb-1">Dashboard</h2>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary p-3 rounded-circle me-3">
                        <i class="bi bi-people h4 mb-0"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Member</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalMembers) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="bg-success bg-opacity-10 text-success p-3 rounded-circle me-3">
                        <i class="bi bi-receipt h4 mb-0"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Transaksi</h6>
                        <h3 class="mb-0 fw-bold">{{ number_format($totalTransactions) }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="bg-warning bg-opacity-10 text-warning p-3 rounded-circle me-3">
                        <i class="bi bi-cash-coin h4 mb-0"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-1 small text-uppercase fw-bold">Total Nilai</h6>
                        <h3 class="mb-0 fw-bold">Rp {{ number_format($totalAmount, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4">Chart Transaksi (7 Hari Terakhir)</h5>
                <canvas id="transactionChart" height="120"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4">Performa Member</h5>

                <div class="mb-4">
                    <p class="text-muted small text-uppercase fw-bold mb-2">Transaksi Terbanyak</p>
                    @if ($topMember)
                        <div class="d-flex align-items-center p-3 bg-light rounded-3">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $topMember->name }}</h6>
                                <span class="badge bg-primary rounded-pill">{{ $topMember->transactions_count }}
                                    Transaksi</span>
                            </div>
                        </div>
                    @else
                        <p class="text-muted small">Belum ada data</p>
                    @endif
                </div>
                <div>
                    <p class="text-muted small text-uppercase fw-bold mb-2">Transaksi Terendah</p>
                    @if ($bottomMember)
                        <div class="d-flex align-items-center p-3 bg-light rounded-3">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $bottomMember->name }}</h6>
                                <span class="badge bg-secondary rounded-pill">{{ $bottomMember->transactions_count }}
                                    Transaksi</span>
                            </div>
                        </div>
                    @else
                        <p class="text-muted small">Belum ada data</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('transactionChart').getContext('2d');
            const labels = @json($chartData->pluck('date')->values());
            const totals = @json($chartData->pluck('total')->values());

         new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: totals,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options:{
                responsive: true,
                 plugins: {
                    legend: {
                        display: false
                    }
                },
            }
        });
    });
    </script>
@endpush

@endsection