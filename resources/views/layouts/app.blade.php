<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Kopnus Dashboard') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700,800" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/custom.css'])
</head>

<body>
    <div id="app">
        <div id="wrapper">
            @auth
                <nav id="sidebar">
                    <div class="sidebar-header">
                        <h3 class="mb-0 fw-bold" style="color: var(--kopnus-orange);">KOPNUS<span
                                class="text-white">.</span></h3>
                    </div>
                    <ul class="list-unstyled components">
                        <li class="{{ Request::is('home') || Request::is('dashboard') ? 'active' : '' }}">
                            <a href="{{ url('/home') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                        </li>
                        @can('view members')
                        <li class="{{ Request::is('members') ? 'active' : '' }}">
                            <a href="{{ route('members.index') }}"><i class="bi bi-people"></i> Member</a>
                        </li>
                        @endcan
                        @can('view approvals')
                            <li>
                                <a href="#"><i class="bi bi-hourglass-split"></i> Approval</a>
                            </li>
                        @endcan
                    </ul>


                </nav>
            @endauth
            <div id="content" class="{{ Auth::check() ? '' : 'content-guest' }}">
                <nav class="navbar navbar-expand-lg navbar-dashboard sticky-top">
                    <div class="container-fluid">
                        @auth
                            <button type="button" id="sidebarCollapse" class="btn btn-light shadow-sm me-3">
                                <i class="bi bi-list"></i>
                            </button>
                        @endauth
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto align-items-center">
                                @guest
                                    @if (Route::has('login'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                        </li>
                                    @endif

                                    @if (Route::has('register'))
                                        <li class="nav-item">
                                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                        </li>
                                    @endif
                                @else
                                    <li class="nav-item dropdown">
                                        <a id="navbarDropdown"
                                            class="nav-link dropdown-toggle fw-bold d-flex align-items-center"
                                            href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                                            aria-expanded="false" v-pre>
                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2"
                                                style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                            {{ Auth::user()->name }}
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-3"
                                            aria-labelledby="navbarDropdown">
                                            <a href="{{ route('my-profile') }}" class="dropdown-item py-2" href="#">
                                                <i class="bi bi-person me-2"></i> Profil Saya
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                            </a>

                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </li>
                                @endguest
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="p-4 p-md-5">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarBtn = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('content');

            if (sidebarBtn) {
                sidebarBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    content.classList.toggle('active');
                });
            }
        });
    </script>
</body>

</html>
