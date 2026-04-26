<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Kopnus') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet" />

    <!-- Scripts / Styles -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/custom.css'])
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-white bg-opacity-75 shadow-sm"
        style="backdrop-filter: blur(15px);">
        <div class="container">
            <a class="navbar-brand" href="/">KOPNUS<span>.</span></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav ms-auto align-items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ url('/home') }}" class="btn btn-kopnus px-4">Dashboard</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}"
                                    class="nav-link fw-bold text-dark px-3 mt-lg-0 mt-2">Masuk</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="btn btn-kopnus px-4">Daftar Sekarang</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <div class="hero-section">
            <div class="glass-bg"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-5 mb-lg-0">
                        <h1 class="hero-title">Solusi Keuangan <span>Cerdas</span> Untuk Anda</h1>
                        <p class="hero-lead">Bergabunglah dengan Koperasi Nusantara dan nikmati layanan finansial modern
                            yang aman, transparan, dan mengedepankan kesejahteraan anggota.</p>
                        <div class="d-flex gap-3 flex-wrap">
                            @auth
                                <a href="{{ url('/dashboard') }}" class="btn btn-kopnus">Mulai Kelola Akun</a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-kopnus">Gabung Menjadi Anggota</a>
                                <a href="{{ route('login') }}"
                                    class="btn btn-outline-dark rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center">Lihat
                                    Layanan</a>
                            @endauth
                        </div>
                    </div>
                    <div class="col-lg-6 hero-image-wrapper">
                        <img src="{{ asset('images/hero_kopnus.png') }}" alt="Modern Finance Illustration"
                            class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <div class="container mb-5">
            <div class="stats-section">
                <div class="row text-center px-4">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="stat-item border-end border-secondary border-opacity-25">
                            <h3>20K<span>+</span></h3>
                            <p class="mb-0 text-white">Anggota Aktif</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4 mb-md-0">
                        <div class="stat-item border-end border-secondary border-opacity-25">
                            <h3>50<span>+</span></h3>
                            <p class="mb-0 text-white">Kantor Cabang</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-item">
                            <h3>1.2<span>T</span></h3>
                            <p class="mb-0 text-white">Aset Terkelola</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="py-5 mt-5">
            <div class="container">
                <div class="text-center mb-5 pb-3">
                    <h2 class="fw-bold h1">Layanan Unggulan Kami</h2>
                    <p class="text-muted mx-auto" style="max-width: 600px;">Kami menyediakan berbagai produk keuangan
                        yang dirancang khusus untuk membantu Anda mencapai tujuan finansial.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-piggy-bank"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Simpanan Berjangka</h4>
                            <p class="text-muted mb-4">Dapatkan imbal hasil kompetitif dengan pengelolaan dana yang
                                profesional dan amanah.</p>
                            <a href="#" class="btn btn-link p-0 text-decoration-none fw-bold"
                                style="color: var(--kopnus-orange)">Selengkapnya <i
                                    class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-rocket-takeoff"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Pinjaman Ekspres</h4>
                            <p class="text-muted mb-4">Solusi dana cepat untuk kebutuhan mendadak atau modal usaha
                                dengan proses yang sangat mudah.</p>
                            <a href="#" class="btn btn-link p-0 text-decoration-none fw-bold"
                                style="color: var(--kopnus-orange)">Selengkapnya <i
                                    class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-patch-check"></i>
                            </div>
                            <h4 class="fw-bold mb-3">Proteksi Diri</h4>
                            <p class="text-muted mb-4">Perlindungan asuransi jiwa esklusif bagi anggota untuk menjamin
                                masa depan keluarga tercinta.</p>
                            <a href="#" class="btn btn-link p-0 text-decoration-none fw-bold"
                                style="color: var(--kopnus-orange)">Selengkapnya <i
                                    class="bi bi-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="py-5 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <h5 class="fw-bold mb-0">KOPNUS<span>.</span></h5>
                    <p class="text-muted small mb-0">Solusi Keuangan Cerdas Untuk Indonesia</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <p class="text-muted small mb-0">&copy; {{ date('Y') }} Koperasi Nusantara. All rights
                        reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</body>

</html>
