<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Alumni15 - Sistem Informasi Alumni SMPN 15')</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        body {
            padding-top: 56px;
        }
        #sidebar {
            min-height: calc(100vh - 56px);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }
        .navbar-brand img {
            height: 30px;
        }
        .profile-img {
            width: 30px;
            height: 30px;
            object-fit: cover;
        }
        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 48px;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            color: #333;
        }
        .sidebar .nav-link.active {
            color: #007bff;
        }
        .sidebar .nav-link:hover {
            color: #007bff;
        }
        .card-stats {
            transition: transform 0.2s;
        }
        .card-stats:hover {
            transform: translateY(-2px);
        }
        .carousel-item img {
            height: 400px;
            object-fit: cover;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                font-size: 10pt;
            }
            .container {
                width: 100%;
                margin: 0;
                padding: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div id="app">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo_smpn15.png') }}" alt="Logo SMPN 15" class="d-inline-block align-top mr-2">
                Alumni15
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('register.alumni') }}">
                                    <i class="fas fa-graduation-cap"></i> Alumni
                                </a>
                                <a class="dropdown-item" href="{{ route('register.guru') }}">
                                    <i class="fas fa-chalkboard-teacher"></i> Guru
                                </a>
                            </div>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('images/default_profile.png') }}" 
                                     alt="Profile" class="rounded-circle profile-img">
                                <span class="ml-2">{{ Auth::user()->name }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->isAdmin())
                                    <a class="dropdown-item" href="{{ route('admin.profile.edit') }}">
                                        <i class="fas fa-user-edit"></i> Edit Profil
                                    </a>
                                @elseif(Auth::user()->isAlumni())
                                    <a class="dropdown-item" href="{{ route('alumni.profile.edit') }}">
                                        <i class="fas fa-user-edit"></i> Edit Profil
                                    </a>
                                @elseif(Auth::user()->isGuru())
                                    <a class="dropdown-item" href="{{ route('guru.profile.edit') }}">
                                        <i class="fas fa-user-edit"></i> Edit Profil
                                    </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                @auth
                    <!-- Sidebar -->
                    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                        <div class="sidebar-sticky pt-3">
                            <ul class="nav flex-column">
                                @if(Auth::user()->isAdmin())
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                            <i class="fas fa-tachometer-alt"></i> Dashboard Admin
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.alumni.*') ? 'active' : '' }}" href="{{ route('admin.alumni.index') }}">
                                            <i class="fas fa-users"></i> Data Alumni
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.guru.*') ? 'active' : '' }}" href="{{ route('admin.guru.index') }}">
                                            <i class="fas fa-chalkboard-teacher"></i> Kelola Guru
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">
                                            <i class="fas fa-newspaper"></i> Berita & Informasi
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.job-vacancies.*') ? 'active' : '' }}" href="{{ route('admin.job-vacancies.index') }}">
                                            <i class="fas fa-briefcase"></i> Kelola Lowongan
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('admin.statistics') ? 'active' : '' }}" href="{{ route('admin.statistics') }}">
                                            <i class="fas fa-chart-bar"></i> Statistik
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('admin.rekapitulasi.index') }}">
                                            <i class="fas fa-chart-bar"></i>
                                            <span>Rekapitulasi Alumni</span>
                                        </a>
                                    </li>
                                @elseif(Auth::user()->isAlumni())
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('alumni.dashboard') ? 'active' : '' }}" href="{{ route('alumni.dashboard') }}">
                                            <i class="fas fa-tachometer-alt"></i> Dashboard Alumni
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('alumni.profile.*') ? 'active' : '' }}" href="{{ route('alumni.profile.edit') }}">
                                            <i class="fas fa-user-edit"></i> Edit Profil
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('alumni.news.*') ? 'active' : '' }}" href="{{ route('alumni.news.index') }}">
                                            <i class="fas fa-newspaper"></i> Berita & Informasi
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('alumni.search') ? 'active' : '' }}" href="{{ route('alumni.search') }}">
                                            <i class="fas fa-search"></i> Cari Alumni
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('job_vacancies.*') ? 'active' : '' }}" href="{{ route('job_vacancies.index') }}">
                                            <i class="fas fa-briefcase"></i> Lowongan Pekerjaan
                                        </a>
                                    </li>
                                @elseif(Auth::user()->isGuru())
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('guru.dashboard') ? 'active' : '' }}" href="{{ route('guru.dashboard') }}">
                                            <i class="fas fa-tachometer-alt"></i> Dashboard Guru
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('guru.profile.*') ? 'active' : '' }}" href="{{ route('guru.profile.edit') }}">
                                            <i class="fas fa-user-edit"></i> Edit Profil
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('guru.alumni.*') ? 'active' : '' }}" href="{{ route('guru.alumni.index') }}">
                                            <i class="fas fa-users"></i> Data Alumni
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('news.*') ? 'active' : '' }}" href="{{ route('news.index') }}">
                                            <i class="fas fa-newspaper"></i> Berita & Informasi
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('guru.statistics') ? 'active' : '' }}" href="{{ route('guru.statistics') }}">
                                            <i class="fas fa-chart-bar"></i> Statistik
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('guru.rekapitulasi.index') }}">
                                            <i class="fas fa-chart-bar"></i>
                                            <span>Rekapitulasi Alumni</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ request()->routeIs('job_vacancies.*') ? 'active' : '' }}" href="{{ route('job_vacancies.index') }}">
                                            <i class="fas fa-briefcase"></i> Lowongan Pekerjaan
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </nav>
                @endauth

                <!-- Main Content -->
                <main class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                    <!-- Alert Messages -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> Terdapat kesalahan:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <!-- Page Content -->
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Confirm delete actions
        function confirmDelete(message = 'Apakah Anda yakin ingin menghapus data ini?') {
            return confirm(message);
        }

        // Print function
        function printPage() {
            window.print();
        }
    </script>
    
    @stack('scripts')
</body>
</html>