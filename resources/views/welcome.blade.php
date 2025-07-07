<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni15 - Sistem Informasi Alumni SMPN 15 Pekanbaru</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .stats-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        .footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo_smpn15.png') }}" alt="Logo SMPN 15" height="30" class="d-inline-block align-top mr-2">
                Alumni15
            </a>
            
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                            <i class="fas fa-user-plus"></i> Daftar
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('register.alumni') }}">
                                <i class="fas fa-graduation-cap"></i> Alumni
                            </a>
                            <a class="dropdown-item" href="{{ route('register.guru') }}">
                                <i class="fas fa-chalkboard-teacher"></i> Guru
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 font-weight-bold mb-4">
                        Selamat Datang di Alumni15
                    </h1>
                    <p class="lead mb-4">
                        Sistem Informasi Alumni SMPN 15 Pekanbaru - Menghubungkan alumni, membangun jaringan, dan berbagi informasi untuk kemajuan bersama.
                    </p>
                    <div class="mb-4">
                        <a href="{{ route('register.alumni') }}" class="btn btn-light btn-lg mr-3">
                            <i class="fas fa-graduation-cap"></i> Daftar sebagai Alumni
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="{{ asset('images/illustration.jpg') }}" alt="Alumni Network" class="img-fluid rounded shadow-sm p-2 bg-white" style="border: 2px solid #eaeaea;">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center mb-5">
                    <h2 class="display-4">Fitur Unggulan</h2>
                    <p class="lead">Berbagai fitur yang memudahkan alumni dalam berinteraksi dan berbagi informasi</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Jaringan Alumni</h5>
                            <p class="card-text">Temukan dan terhubung dengan teman-teman alumni dari berbagai angkatan.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-newspaper fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title">Berita & Informasi</h5>
                            <p class="card-text">Dapatkan informasi terbaru dari sekolah dan kegiatan alumni.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-briefcase fa-3x text-warning"></i>
                            </div>
                            <h5 class="card-title">Lowongan Pekerjaan</h5>
                            <p class="card-text">Akses informasi lowongan pekerjaan dan peluang karir terbaru.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-user-edit fa-3x text-info"></i>
                            </div>
                            <h5 class="card-title">Profil Alumni</h5>
                            <p class="card-text">Kelola profil pribadi dan riwayat pendidikan serta pekerjaan.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-chart-bar fa-3x text-danger"></i>
                            </div>
                            <h5 class="card-title">Statistik Alumni</h5>
                            <p class="card-text">Lihat data statistik dan perkembangan alumni dari waktu ke waktu.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-search fa-3x text-secondary"></i>
                            </div>
                            <h5 class="card-title">Pencarian Alumni</h5>
                            <p class="card-text">Cari alumni berdasarkan nama, angkatan, atau kriteria lainnya.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <h2 class="display-4 text-primary font-weight-bold">500+</h2>
                            <p class="lead">Alumni Terdaftar</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <h2 class="display-4 text-success font-weight-bold">25+</h2>
                            <p class="lead">Angkatan</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <h2 class="display-4 text-warning font-weight-bold">50+</h2>
                            <p class="lead">Guru</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card border-0 bg-transparent">
                        <div class="card-body">
                            <h2 class="display-4 text-info font-weight-bold">100+</h2>
                            <p class="lead">Berita & Informasi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <img src="{{ asset('images/about-smpn15.jpg') }}" alt="SMPN 15 Pekanbaru" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h2 class="display-4 mb-4">Tentang SMPN 15 Pekanbaru</h2>
                    <p class="lead mb-4">
                        SMP Negeri 15 Pekanbaru adalah salah satu sekolah menengah pertama terbaik di Kota Pekanbaru yang telah menghasilkan banyak alumni berprestasi.
                    </p>
                    <p class="mb-4">
                        Sistem Informasi Alumni ini dikembangkan untuk memfasilitasi komunikasi dan networking antara alumni, guru, dan sekolah. Melalui platform ini, kami berharap dapat membangun jaringan alumni yang kuat dan saling mendukung.
                    </p>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Menghubungkan alumni dari berbagai angkatan</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Berbagi informasi dan peluang karir</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Membangun jaringan profesional yang kuat</li>
                        <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Mendukung perkembangan pendidikan</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

<!-- Section Lokasi dan Foto -->
<section id="lokasi-foto" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-5">Lokasi SMPN 15 Pekanbaru</h2>
        <div class="row align-items-center">
            <!-- Kolom Map -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="embed-responsive embed-responsive-4by3 rounded shadow-sm">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1994.809301448192!2d101.45882116741272!3d0.5732854036950985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d5acc1b4338127%3A0x4772b933b53ec6e3!2sSMP%20Negeri%2015%20Pekanbaru!5e0!3m2!1sid!2sid!4v1750369123255!5m2!1sid!2sid"
                        width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Kolom Foto -->
            <div class="col-md-6 text-center">
                <img src="{{ asset('images/lokasismp15.png') }}" alt="Gedung SMPN 15 Pekanbaru" class="img-fluid rounded shadow-sm">
                <p class="mt-3 text-muted">Gedung SMPN 15 Pekanbaru, tempat para alumni memulai jejak prestasi.</p>
            </div>
        </div>
    </div>
</section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5>Alumni15</h5>
                    <p>Sistem Informasi Alumni SMPN 15 Pekanbaru - Menghubungkan alumni untuk kemajuan bersama.</p>
                    <div class="social-links">
                        <a href="#" class="text-white mr-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-white mr-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white mr-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Kontak</h5>
                    <p><i class="fas fa-map-marker-alt mr-2"></i> Jl. Lembah Sari, Lembah Sari, Kec. Rumbai Timur, Kota Pekanbaru Prov. Riau</p>
                    <p><i class="fas fa-phone mr-2"></i> 52304</p>
                    <p><i class="fas fa-envelope mr-2"></i> info@smpn15.sch.id</p>
                </div>
                <div class="col-lg-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('login') }}" class="text-white">Login</a></li>
                        <li><a href="{{ route('register.alumni') }}" class="text-white">Daftar Alumni</a></li>
                        <li><a href="{{ route('register.guru') }}" class="text-white">Daftar Guru</a></li>
                    </ul>
                </div>
            </div>
            <hr class="bg-white">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>&copy; 2025 Alumni15 - SMPN 15 Pekanbaru. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        // Smooth scrolling for navigation links
        $(document).ready(function(){
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 70
                    }, 1000);
                }
            });
        });
    </script>
</body>
</html>