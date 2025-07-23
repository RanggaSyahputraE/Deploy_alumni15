<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Alumni - {{ $alumni->full_name }}</title>
    
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
        
        .profile-photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border: 3px solid #dee2e6;
        }
        
        .info-table th {
            background-color: #f8f9fa;
            width: 30%;
            font-weight: 600;
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
                <div class="col-md-8 text-center">
                    <h3 class="mb-1">SMP NEGERI 15 PEKANBARU</h3>
                    <h4 class="mb-1">SISTEM INFORMASI ALUMNI</h4>
                    <p class="mb-0">Jl. Lembah Sari  No. 123, Pekanbaru, Riau | Telp: (0761) 123456</p>
                </div>
                <div class="col-md-2 text-center">
                    <img src="{{ $alumni->user->profile_photo_path ? asset('storage/' . $alumni->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                         alt="Foto Alumni" class="rounded profile-photo">
                </div>
            </div>
        </div>

        <!-- Data Alumni -->
        <div class="section-title">
            <i class="fas fa-user"></i> DATA ALUMNI
        </div>
        
        <table class="table table-bordered info-table">
            <tr>
                <th>Nama Lengkap</th>
                <td>{{ $alumni->full_name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $alumni->user->email }}</td>
            </tr>
            <tr>
                <th>Tempat, Tanggal Lahir</th>
                <td>
                    {{ $alumni->place_of_birth ?? '-' }}
                    @if($alumni->date_of_birth)
                        , {{ $alumni->date_of_birth->format('d F Y') }}
                    @endif
                </td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $alumni->gender ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tahun Kelulusan</th>
                <td>{{ $alumni->graduation_year }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $alumni->address ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nomor Telepon</th>
                <td>{{ $alumni->phone_number ?? '-' }}</td>
            </tr>
        </table>

        <!-- Social Media -->
        @if($alumni->social_media_facebook || $alumni->social_media_instagram || $alumni->social_media_linkedin)
        <div class="section-title">
            <i class="fas fa-share-alt"></i> MEDIA SOSIAL
        </div>
        
        <table class="table table-bordered info-table">
            @if($alumni->social_media_facebook)
            <tr>
                <th>Facebook</th>
                <td>{{ $alumni->social_media_facebook }}</td>
            </tr>
            @endif
            @if($alumni->social_media_instagram)
            <tr>
                <th>Instagram</th>
                <td>{{ $alumni->social_media_instagram }}</td>
            </tr>
            @endif
            @if($alumni->social_media_linkedin)
            <tr>
                <th>LinkedIn</th>
                <td>{{ $alumni->social_media_linkedin }}</td>
            </tr>
            @endif
        </table>
        @endif

        <!-- Riwayat Pendidikan -->
        @if($alumni->educations->isNotEmpty())
        <div class="section-title">
            <i class="fas fa-graduation-cap"></i> RIWAYAT PENDIDIKAN
        </div>
        
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Institusi</th>
                    <th>Jenjang</th>
                    <th>Jurusan</th>
                    <th>Tahun Mulai</th>
                    <th>Tahun Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumni->educations as $key => $education)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $education->institution_name }}</td>
                    <td>{{ $education->degree ?? '-' }}</td>
                    <td>{{ $education->major ?? '-' }}</td>
                    <td>{{ $education->start_year ?? '-' }}</td>
                    <td>{{ $education->end_year ?? 'Sekarang' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

        <!-- Riwayat Pekerjaan -->
        @if($alumni->works->isNotEmpty())
        <div class="section-title">
            <i class="fas fa-briefcase"></i> RIWAYAT PEKERJAAN
        </div>
        
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Perusahaan</th>
                    <th>Posisi</th>
                    <th>Deskripsi</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($alumni->works as $key => $work)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $work->company_name }}</td>
                    <td>{{ $work->position ?? '-' }}</td>
                    <td>{{ $work->description ?? '-' }}</td>
                    <td>{{ $work->start_date ? $work->start_date->format('d/m/Y') : '-' }}</td>
                    <td>{{ $work->end_date ? $work->end_date->format('d/m/Y') : '-' }}</td>
                    <td>{{ $work->is_current ? 'Aktif' : 'Selesai' }}</td>
                </tr>
                @endforeach
            </tbody>
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
    
    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>