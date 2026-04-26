@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="fw-bold">Profil Pengguna</h2>
        </div>
    </div>

    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-lg-4 mb-4">
            <div class="card profile-card text-center p-4">
                <div class="profile-avatar-circle">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <h4 class="fw-bold mb-1">{{ Auth::user()->name }}</h4>
                <p class="text-muted mb-3">Admin Kopnus</p>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="card profile-card p-4 mb-4">
                <h5 class="card-title-premium d-flex align-items-center">
                    <i class="bi bi-person-lines-fill me-2 text-primary"></i> Informasi Pribadi
                </h5>
                <div class="row">
                    <div class="col-md-6">
                        <p class="info-label">Nama Lengkap</p>
                        <p class="info-value">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Alamat Email</p>
                        <p class="info-value">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Nomor Telepon</p>
                        <p class="info-value">+62 8xxxxxx</p>
                    </div>
                    <div class="col-md-6">
                        <p class="info-label">Lokasi</p>
                        <p class="info-value">Indonesia</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
