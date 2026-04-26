@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-0">Manajemen Anggota</h2>
            </div>
            @can('manage members')
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#createMemberModal">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Anggota
                    </button>
                    <button type="button" class="btn btn-outline-primary d-flex align-items-center" data-bs-toggle="modal"
                        data-bs-target="#uploadMemberModal">
                        <i class="bi bi-upload me-2"></i> Upload Data
                    </button>
                </div>
            @endcan
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

            {{-- Bulk Upload Result Section --}}
            @if ($recentUpload && Carbon\Carbon::parse($recentUpload->updated_at)->timestamp >= now()->addMinutes(15)->timestamp)
                <div class="card border-0 shadow-sm mb-4"
                    style="border-left: 5px solid {{ $recentUpload->status == 'completed' ? '#28a745' : ($recentUpload->status == 'processing' ? '#ffc107' : '#dc3545') }};">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1">Status Upload Terakhir: <span
                                        class="badge {{ $recentUpload->status == 'completed' ? 'bg-success' : ($recentUpload->status == 'processing' ? 'bg-warning text-dark' : 'bg-danger') }}">{{ strtoupper($recentUpload->status) }}</span>
                                </h6>
                                <p class="text-muted small mb-0">File: {{ $recentUpload->filename }} |
                                    {{ $recentUpload->updated_at->diffForHumans() }}</p>
                            </div>
                            @if ($recentUpload->status == 'completed' || $recentUpload->status == 'failed')
                                <div class="text-end">
                                    <div class="d-flex gap-4">
                                        <div class="text-center">
                                            <span
                                                class="d-block h5 mb-0 fw-bold">{{ $recentUpload->total_success + $recentUpload->total_failed }}</span>
                                            <span class="small text-muted">Total Data</span>
                                        </div>
                                        <div class="text-center">
                                            <span
                                                class="d-block h5 mb-0 fw-bold text-success">{{ $recentUpload->total_success }}</span>
                                            <span class="small text-muted">Berhasil</span>
                                        </div>
                                        <div class="text-center">
                                            <span
                                                class="d-block h5 mb-0 fw-bold text-danger">{{ $recentUpload->total_failed }}</span>
                                            <span class="small text-muted">Gagal</span>
                                        </div>
                                    </div>
                                    @if ($recentUpload->total_failed > 0)
                                        <a href="{{ route('members.export-errors', $recentUpload->id) }}"
                                            class="btn btn-sm btn-outline-danger rounded-pill mt-2 fw-bold">
                                            <i class="bi bi-download me-1"></i> Download File Error
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="card border-0 shadow-sm profile-card">
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-muted">
                                <tr>
                                    <th class="py-3 text-uppercase small fw-bold">Nomor Anggota</th>
                                    <th class="py-3 text-uppercase small fw-bold">Nama Lengkap</th>
                                    <th class="py-3 text-uppercase small fw-bold">Status</th>
                                    <th class="py-3 text-uppercase small fw-bold">Terdaftar Pada</th>
                                    <th class="py-3 text-uppercase small fw-bold text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($members as $member)
                                    <tr>
                                        <td>#{{ $member->member_number }}</td>
                                        <td class="fw-bold">{{ $member->name }}</td>
                                        <td>
                                            @if ($member->is_active)
                                                <span class="d-inline-flex align-items-center text-success small fw-bold">
                                                    Aktif
                                                </span>
                                            @else
                                                <span class="d-inline-flex align-items-center text-danger small fw-bold">
                                                    Tidak Aktif
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-muted small">{{ $member->created_at->format('d M Y, H:i') }}</td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                @if (!$member->is_active)
                                                    <button type="button" class="btn btn-sm btn-success px-3 rounded-pill" data-bs-toggle="modal" data-bs-target="#statusModal{{ $member->id }}">
                                                        Approval
                                                    </button>
                                                @endif
                                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus member ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger px-3 rounded-pill">Hapus</button>
                                                </form>
                                            </div>

                                            {{-- Status Update Modal --}}
                                            @if (!$member->is_active)
                                            <div class="modal fade" id="statusModal{{ $member->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow">
                                                        <div class="modal-header border-0 pb-0">
                                                            <h5 class="modal-title fw-bold">Konfirmasi Approval</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('members.update-status', $member->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body py-4 text-start">
                                                                <p class="mb-3">Tentukan tindakan untuk member: <strong>{{ $member->name }}</strong></p>
                                                                
                                                                <div class="mb-3">
                                                                    <label class="info-label">Pilih Status</label>
                                                                    <div class="d-flex gap-3 mt-2">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="status" id="approve{{ $member->id }}" value="1" checked>
                                                                            <label class="form-check-label text-success fw-bold" for="approve{{ $member->id }}">APPROVE (Aktifkan)</label>
                                                                        </div>
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio" name="status" id="reject{{ $member->id }}" value="0">
                                                                            <label class="form-check-label text-danger fw-bold" for="reject{{ $member->id }}">REJECT (Tetap Inaktif)</label>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="note{{ $member->id }}" class="info-label">Catatan (Wajib)</label>
                                                                    <textarea name="note" id="note{{ $member->id }}" class="form-control" rows="3" placeholder="Masukkan alasan atau catatan..." required></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                                                                <button type="button" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <div class="text-muted">
                                                <i class="bi bi-people mb-3 d-block"
                                                    style="font-size: 3rem; opacity: 0.3;"></i>
                                                <p class="mb-0">Belum ada data anggota.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($members->hasPages())
                    <div class="card-footer bg-white border-0 py-3">
                        {{ $members->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Upload Members Modal --}}
    @can('manage members')
        <div class="modal fade" id="uploadMemberModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Upload Data Anggota</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('members.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body py-4">
                            <div class="alert alert-info border-0 small mb-4">
                                <h6 class="fw-bold small mb-1"><i class="bi bi-info-circle me-1"></i> Ketentuan Upload:</h6>
                                <ul class="mb-0 ps-3">
                                    <li>Format file: <strong>Excel (.xlsx)</strong> atau <strong>CSV</strong>.</li>
                                    <li>Kolom wajib: <strong>no_anggota</strong>, <strong>name</strong>.</li>
                                    <li>Kolom opsional: <strong>is_active</strong> (default: false).</li>
                                    <li>Sistem akan melakukan <strong>update</strong> jika no_anggota sudah ada.</li>
                                </ul>
                            </div>
                            <div class="mb-3">
                                <label for="file" class="info-label">Pilih File</label>
                                <input type="file" class="form-control rounded-pill" id="file" name="file"
                                    accept=".csv,.xlsx,.xls" required>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                            <button type="button" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">Mulai Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Create Member Modal --}}
        <div class="modal fade" id="createMemberModal" tabindex="-1" aria-labelledby="createMemberModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="createMemberModalLabel">Tambah Anggota Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('members.store') }}" method="POST">
                        @csrf
                        <div class="modal-body py-4">
                            <div class="mb-3">
                                <label for="member_number" class="info-label">Nomor Anggota</label>
                                <input type="text" class="form-control rounded-pill" id="member_number"
                                    name="member_number" placeholder="Contoh: KOP-2024-001" required>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="info-label">Nama Lengkap</label>
                                <input type="text" class="form-control rounded-pill" id="name" name="name"
                                    placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="form-check form-switch mt-4">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                    name="is_active" checked>
                                <label class="form-check-label fw-bold" for="is_active">Aktifkan Anggota Segera</label>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0 pb-4 justify-content-center">
                            <button type="button" class="btn btn-light rounded-pill px-4 fw-bold shadow-sm"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-5 rounded-pill fw-bold">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan
@endsection
