<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Semua Alumni - SMPN 15 Pekanbaru</title>
    
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
        
        .alumni-table {
            font-size: 12px;
        }
        
        .alumni-table th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
            text-align: center;
            vertical-align: middle;
        }
        
        .alumni-table td {
            vertical-align: middle;
            padding: 8px 6px;
        }
        
        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }
        
        .summary-card {
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .summary-number {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }
        
        .summary-label {
            font-size: 1rem;
            color: #6c757d;
            margin-top: 5px;
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
                    <h4 class="mb-1">DATA SEMUA ALUMNI</h4>
                    <p class="mb-0">Jl. Pendidikan No. 123, Pekanbaru, Riau | Telp: (0761) 123456</p>
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="row">
            <div class="col-md-3">
                <div class="summary-card">
                    <div class="summary-number">{{ $alumni->count() }}</div>
                    <div class="summary-label">Total Alumni</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card">
                    <div class="summary-number">{{ $alumni->where('gender', 'Laki-laki')->count() }}</div>
                    <div class="summary-label">Alumni Laki-laki</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card">
                    <div class="summary-number">{{ $alumni->where('gender', 'Perempuan')->count() }}</div>
                    <div class="summary-label">Alumni Perempuan</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="summary-card">
                    <div class="summary-number">{{ $alumni->pluck('graduation_year')->unique()->count() }}</div>
                    <div class="summary-label">Tahun Kelulusan</div>
                </div>
            </div>
        </div>

        <!-- Filter Information -->
        @if(request()->hasAny(['search', 'gender', 'graduation_year']))
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

        <!-- Alumni Table -->
        <div class="section-title">
            <i class="fas fa-users"></i> DAFTAR ALUMNI
        </div>
        
        <table class="table table-bordered table-striped alumni-table">
            <thead>
                <tr>
                    <th width="4%">No</th>
                    <th width="8%">Foto</th>
                    <th width="20%">Nama Lengkap</th>
                    <th width="18%">Email</th>
                    <th width="8%">Gender</th>
                    <th width="8%">Tahun Lulus</th>
                    <th width="12%">Telepon</th>
                    <th width="22%">Alamat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumni as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">
                        <img src="{{ $item->user->profile_photo_path ? asset('storage/' . $item->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                             alt="Profile" class="profile-img">
                    </td>
                    <td>{{ $item->full_name }}</td>
                    <td>{{ $item->user->email }}</td>
                    <td class="text-center">
                        @if($item->gender == 'Laki-laki')
                            <span class="badge badge-primary">L</span>
                        @elseif($item->gender == 'Perempuan')
                            <span class="badge badge-pink">P</span>
                        @else
                            <span class="badge badge-secondary">-</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->graduation_year }}</td>
                    <td>{{ $item->phone_number ?? '-' }}</td>
                    <td>{{ Str::limit($item->address, 50) ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data alumni ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Alumni by Year Summary -->
        @if($alumni->isNotEmpty())
        <div class="section-title">
            <i class="fas fa-chart-bar"></i> RINGKASAN BERDASARKAN TAHUN KELULUSAN
        </div>
        
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th width="10%">No</th>
                    <th width="30%">Tahun Kelulusan</th>
                    <th width="30%">Jumlah Alumni</th>
                    <th width="30%">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $alumniByYear = $alumni->groupBy('graduation_year')->map(function($group) {
                        return $group->count();
                    })->sortKeys();
                    $totalAlumni = $alumni->count();
                @endphp
                
                @foreach($alumniByYear as $year => $count)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $year }}</td>
                    <td>{{ $count }} orang</td>
                    <td>{{ $totalAlumni > 0 ? number_format(($count / $totalAlumni) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="thead-light">
                <tr>
                    <th colspan="2">Total</th>
                    <th>{{ $totalAlumni }} orang</th>
                    <th>100%</th>
                </tr>
            </tfoot>
        </table>

        <!-- Alumni by Gender Summary -->
        <div class="section-title">
            <i class="fas fa-venus-mars"></i> RINGKASAN BERDASARKAN JENIS KELAMIN
        </div>
        
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th width="10%">No</th>
                    <th width="30%">Jenis Kelamin</th>
                    <th width="30%">Jumlah Alumni</th>
                    <th width="30%">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $alumniByGender = $alumni->groupBy('gender')->map(function($group) {
                        return $group->count();
                    });
                @endphp
                
                @foreach($alumniByGender as $gender => $count)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $gender ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $count }} orang</td>
                    <td>{{ $totalAlumni > 0 ? number_format(($count / $totalAlumni) * 100, 1) : 0 }}%</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="thead-light">
                <tr>
                    <th colspan="2">Total</th>
                    <th>{{ $totalAlumni }} orang</th>
                    <th>100%</th>
                </tr>
            </tfoot>
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