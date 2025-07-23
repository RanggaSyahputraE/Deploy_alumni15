<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Alumni - {{ $alumni->full_name }} - SMPN 15 Pekanbaru</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            .page-break {
                page-break-after: always;
            }
        }
        
        .header-section {
            border-bottom: 3px solid #007bff;
            margin-bottom: 30px;
            padding-bottom: 20px;
        }
        
        .section-title {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            margin: 20px 0 10px 0;
            font-weight: 600;
        }
        
        .footer-print {
            margin-top: 50px;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        
        .profile-photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 3px solid #007bff;
        }
        
        .info-table td {
            padding: 8px 12px;
            border-bottom: 1px solid #dee2e6;
        }
        
        .info-table td:first-child {
            font-weight: 600;
            background-color: #f8f9fa;
            width: 30%;
        }
    </style>
</head>
<body>
    <!-- Print Button -->
    <div class="no-print mb-3">
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Print
        </button>
        <button onclick="window.close()" class="btn btn-secondary">
            <i class="fas fa-times"></i> Tutup
        </button>
    </div>

    <div class="container-fluid">
        <!-- Header -->
        <div class="header-section">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="{{ asset('images/logo_smpn15.png') }}" alt="Logo SMPN 15" style="height: 80px;">
                </div>
                <div class="col-md-10 text-center">
                    <h3 class="mb-1">SMP NEGERI 15 PEKANBARU</h3>
                    <h4 class="mb-1">DATA ALUMNI</h4>
                    <p class="mb-0">Jl.Lembah Sari No. 123, Pekanbaru, Riau | Telp: (0761) 123456</p>
                </div>
            </div>
        </div>

        <!-- Alumni Profile -->
        <div class="row">
            <div class="col-md-3 text-center">
                <img src="{{ $alumni->user->profile_photo_path ? asset('storage/' . $alumni->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                     alt="Profile" class="rounded profile-photo mb-3">
                <h5>{{ $alumni->full_name }}</h5>
                <p class="text-muted">Alumni {{ $alumni->graduation_year }}</p>
            </div>
            <div class="col-md-9">
                <!-- Personal Information -->
                <div class="section-title">
                    <i class="fas fa-user"></i> INFORMASI PRIBADI
                </div>
                
                <table class="table table-borderless info-table">
                    <tr>
                        <td>Nama Lengkap</td>
                        <td>{{ $alumni->full_name }}</td>
                    </tr>
                    <tr>
                        <td>Tempat Lahir</td>
                        <td>{{ $alumni->place_of_birth ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Lahir</td>
                        <td>{{ $alumni->date_of_birth ? $alumni->date_of_birth->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Kelamin</td>
                        <td>{{ $alumni->gender ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{{ $alumni->user->email }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Telepon</td>
                        <td>{{ $alumni->phone_number ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Tahun Kelulusan</td>
                        <td>{{ $alumni->graduation_year }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>{{ $alumni->address ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Education History -->
        @if($alumni->educations->isNotEmpty())
        <div class="section-title">
            <i class="fas fa-graduation-cap"></i> RIWAYAT PENDIDIKAN
        </div>
        
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Institusi</th>
                    <th width="20%">Jenjang</th>
                    <th width="25%">Jurusan</th>
                    <th width="15%">Tahun</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumni->educations as $key => $education)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $education->institution_name }}</td>
                    <td>{{ $education->degree ?? '-' }}</td>
                    <td>{{ $education->major ?? '-' }}</td>
                    <td>{{ $education->start_year }} - {{ $education->end_year ?? 'Sekarang' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Work History -->
        @if($alumni->works->isNotEmpty())
        <div class="section-title">
            <i class="fas fa-briefcase"></i> RIWAYAT PEKERJAAN
        </div>
        
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Perusahaan</th>
                    <th width="25%">Posisi</th>
                    <th width="20%">Periode</th>
                    <th width="10%">Status</th>
                    <th width="10%">Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumni->works as $key => $work)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $work->company_name }}</td>
                    <td>{{ $work->position ?? '-' }}</td>
                    <td>
                        {{ $work->start_date ? $work->start_date->format('M Y') : '-' }} - 
                        {{ $work->end_date ? $work->end_date->format('M Y') : 'Sekarang' }}
                    </td>
                    <td>
                        @if($work->is_current)
                            Aktif
                        @else
                            Selesai
                        @endif
                    </td>
                    <td>{{ Str::limit($work->description, 50) ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Social Media -->
        @if($alumni->social_media_facebook || $alumni->social_media_instagram || $alumni->social_media_linkedin)
        <div class="section-title">
            <i class="fas fa-share-alt"></i> MEDIA SOSIAL
        </div>
        
        <table class="table table-borderless info-table">
            @if($alumni->social_media_facebook)
            <tr>
                <td><i class="fab fa-facebook"></i> Facebook</td>
                <td>{{ $alumni->social_media_facebook }}</td>
            </tr>
            @endif
            @if($alumni->social_media_instagram)
            <tr>
                <td><i class="fab fa-instagram"></i> Instagram</td>
                <td>{{ $alumni->social_media_instagram }}</td>
            </tr>
            @endif
            @if($alumni->social_media_linkedin)
            <tr>
                <td><i class="fab fa-linkedin"></i> LinkedIn</td>
                <td>{{ $alumni->social_media_linkedin }}</td>
            </tr>
            @endif
        </table>
        @endif

        <!-- Footer -->
        <div class="footer-print">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-0"><strong>Dicetak pada:</strong> {{ now()->format('d F Y, H:i') }} WIB</p>
                    <p class="mb-0"><strong>Dicetak oleh:</strong> {{ Auth::user()->name }}</p>
                </div>
                <div class="col-md-6 text-right">
                    <p class="mb-0"><strong>Alumni15 - SMPN 15 Pekanbaru</strong></p>
                    <p class="mb-0">Sistem Informasi Alumni</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
</body>
</html>