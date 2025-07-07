<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Alumni Tahun {{ $year }} - SMPN 15 Pekanbaru</title>
    
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
            body {
                font-size: 10px;
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
            font-size: 10px;
            text-align: center;
            vertical-align: middle;
        }
        
        .alumni-table td {
            font-size: 9px;
            vertical-align: top;
            padding: 8px 4px;
        }
        
        .profile-photo-small {
            width: 25px;
            height: 25px;
            object-fit: cover;
        }
        
        .education-item, .work-item {
            margin-bottom: 5px;
            padding: 3px;
            background-color: #f8f9fa;
            border-radius: 3px;
            font-size: 8px;
        }
        
        .education-item strong, .work-item strong {
            color: #007bff;
        }
        
        .no-data {
            color: #6c757d;
            font-style: italic;
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
                    <h4 class="mb-1">LAPORAN ALUMNI TAHUN {{ $year }}</h4>
                    <p class="mb-0">Jl. Pendidikan No. 123, Pekanbaru, Riau | Telp: (0761) 123456</p>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="section-title">
            <i class="fas fa-chart-bar"></i> RINGKASAN LAPORAN
        </div>
        
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="text-primary">{{ $alumni->count() }}</h4>
                        <p class="mb-0">Total Alumni Tahun {{ $year }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="text-success">{{ $alumni->where('gender', 'Laki-laki')->count() }}</h4>
                        <p class="mb-0">Laki-laki</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h4 class="text-info">{{ $alumni->where('gender', 'Perempuan')->count() }}</h4>
                        <p class="mb-0">Perempuan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alumni Table -->
        <div class="section-title">
            <i class="fas fa-users"></i> DAFTAR ALUMNI TAHUN {{ $year }}
        </div>
        
        <table class="table table-bordered table-striped alumni-table">
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="5%">Foto</th>
                    <th width="12%">Data Pribadi</th>
                    <th width="10%">Kontak</th>
                    <th width="35%">Riwayat Pendidikan</th>
                    <th width="35%">Riwayat Pekerjaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($alumni as $key => $item)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td class="text-center">
                        <img src="{{ $item->user->profile_photo_path ? asset('storage/' . $item->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                             alt="Profile" class="rounded-circle profile-photo-small">
                    </td>
                    <td>
                        <strong>{{ $item->full_name }}</strong><br>
                        <small>{{ $item->gender ?? '-' }}</small><br>
                        <small>Lulus: {{ $item->graduation_year }}</small><br>
                        @if($item->place_of_birth || $item->date_of_birth)
                        <small>
                            {{ $item->place_of_birth ?? '' }}
                            @if($item->date_of_birth)
                                {{ $item->place_of_birth ? ', ' : '' }}{{ $item->date_of_birth->format('d/m/Y') }}
                            @endif
                        </small>
                        @endif
                    </td>
                    <td>
                        <small><strong>Email:</strong><br>{{ $item->user->email }}</small><br>
                        @if($item->phone_number)
                        <small><strong>HP:</strong><br>{{ $item->phone_number }}</small><br>
                        @endif
                        @if($item->address)
                        <small><strong>Alamat:</strong><br>{{ Str::limit($item->address, 50) }}</small>
                        @endif
                    </td>
                    <td>
                        @if($item->educations->isNotEmpty())
                            @foreach($item->educations as $education)
                            <div class="education-item">
                                <strong>{{ $education->institution_name }}</strong><br>
                                @if($education->degree)
                                    <small>{{ $education->degree }}</small>
                                    @if($education->major)
                                        <small> - {{ $education->major }}</small>
                                    @endif
                                    <br>
                                @endif
                                <small>{{ $education->start_year ?? '-' }} - {{ $education->end_year ?? 'Sekarang' }}</small>
                            </div>
                            @endforeach
                        @else
                            <span class="no-data">Belum ada data pendidikan</span>
                        @endif
                    </td>
                    <td>
                        @if($item->works->isNotEmpty())
                            @foreach($item->works as $work)
                            <div class="work-item">
                                <strong>{{ $work->company_name }}</strong><br>
                                @if($work->position)
                                    <small>{{ $work->position }}</small><br>
                                @endif
                                @if($work->description)
                                    <small>{{ Str::limit($work->description, 60) }}</small><br>
                                @endif
                                <small>
                                    {{ $work->start_date ? $work->start_date->format('m/Y') : '-' }} - 
                                    {{ $work->end_date ? $work->end_date->format('m/Y') : 'Sekarang' }}
                                    @if($work->is_current)
                                        <span class="badge badge-success badge-sm">Aktif</span>
                                    @endif
                                </small>
                            </div>
                            @endforeach
                        @else
                            <span class="no-data">Belum ada data pekerjaan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data alumni ditemukan.</td>
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