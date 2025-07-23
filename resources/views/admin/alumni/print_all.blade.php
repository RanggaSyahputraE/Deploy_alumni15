<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Alumni - SMPN 15 Pekanbaru</title>
    
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
        
        .alumni-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            font-size: 12px;
        }
        
        .alumni-table td {
            font-size: 11px;
            vertical-align: middle;
        }
        
        .profile-photo-small {
            width: 30px;
            height: 30px;
            object-fit: cover;
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
                    <h4 class="mb-1">DAFTAR ALUMNI</h4>
                    <p class="mb-0">Jl. Lembah Sari No. 123, Pekanbaru, Riau | Telp: (0761) 123456</p>
                </div>
            </div>
        </div>

        <!-- Filter Info -->
        @if(request()->has('search') || request()->has('gender') || request()->has('graduation_year'))
        <div class="alert alert-info">
            <strong>Filter yang diterapkan:</strong>
            @if(request('search'))
                Pencarian: "{{ request('search') }}" |
            @endif
            @if(request('gender'))
                Jenis Kelamin: {{ request('gender') }} |
            @endif
            @if(request('graduation_year'))
                Tahun Kelulusan: {{ request('graduation_year') }}
            @endif
        </div>
        @endif

        <!-- Summary -->
        <div class="section-title">
            <i class="fas fa-chart-bar"></i> RINGKASAN DATA
        </div>
        
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="text-primary">{{ $alumni->count() }}</h4>
                        <p class="mb-0">Total Alumni</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="text-success">{{ $alumni->where('gender', 'Laki-laki')->count() }}</h4>
                        <p class="mb-0">Laki-laki</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="text-info">{{ $alumni->where('gender', 'Perempuan')->count() }}</h4>
                        <p class="mb-0">Perempuan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="text-warning">{{ $alumni->pluck('graduation_year')->unique()->count() }}</h4>
                        <p class="mb-0">Tahun Kelulusan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alumni Table -->
        <div class="section-title">
            <i class="fas fa-users"></i> DAFTAR ALUMNI
        </div>
        
        <table class="table table-bordered table-striped alumni-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="8%">Foto</th>
                    <th width="20%">Nama Lengkap</th>
                    <th width="18%">Email</th>
                    <th width="10%">Gender</th>
                    <th width="10%">Tahun Lulus</th>
                    <th width="15%">Telepon</th>
                    <th width="14%">Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumni as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="text-center">
                        <img src="{{ $item->user->profile_photo_path ? asset('storage/' . $item->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                             alt="Profile" class="rounded-circle profile-photo-small">
                    </td>
                    <td>{{ $item->full_name }}</td>
                    <td>{{ $item->user->email }}</td>
                    <td>{{ $item->gender ?? '-' }}</td>
                    <td>{{ $item->graduation_year }}</td>
                    <td>{{ $item->phone_number ?? '-' }}</td>
                    <td>{{ Str::limit($item->address, 30) ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data alumni ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

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