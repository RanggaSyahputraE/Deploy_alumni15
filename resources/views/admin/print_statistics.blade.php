<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Alumni - SMPN 15 Pekanbaru</title>
    
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
        
        .stats-card {
            border: 2px solid #007bff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: #007bff;
        }
        
        .stats-label {
            font-size: 1.1rem;
            color: #6c757d;
            margin-top: 10px;
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
                    <h4 class="mb-1">LAPORAN STATISTIK ALUMNI</h4>
                    <p class="mb-0">Jl. Lembah Sari, Pekanbaru, Riau | Telp: 52304 </p>
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="section-title">
            <i class="fas fa-chart-bar"></i> RINGKASAN STATISTIK
        </div>
        
        <div class="row">
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">{{ $alumniByYear->sum('total') }}</div>
                    <div class="stats-label">Total Alumni</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">{{ $alumniByGender->where('gender', 'Laki-laki')->first()->total ?? 0 }}</div>
                    <div class="stats-label">Alumni Laki-laki</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">{{ $alumniByGender->where('gender', 'Perempuan')->first()->total ?? 0 }}</div>
                    <div class="stats-label">Alumni Perempuan</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card">
                    <div class="stats-number">{{ $alumniByYear->count() }}</div>
                    <div class="stats-label">Tahun Kelulusan Aktif</div>
                </div>
            </div>
        </div>

        <!-- Alumni by Year Table -->
        <div class="section-title">
            <i class="fas fa-table"></i> DATA ALUMNI BERDASARKAN TAHUN KELULUSAN
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
                @foreach($alumniByYear as $key => $data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->graduation_year }}</td>
                    <td>{{ $data->total }} orang</td>
                    <td>{{ number_format(($data->total / $alumniByYear->sum('total')) * 100, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="thead-light">
                <tr>
                    <th colspan="2">Total</th>
                    <th>{{ $alumniByYear->sum('total') }} orang</th>
                    <th>100%</th>
                </tr>
            </tfoot>
        </table>

        <!-- Alumni by Gender Table -->
        <div class="section-title">
            <i class="fas fa-table"></i> DATA ALUMNI BERDASARKAN JENIS KELAMIN
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
                @foreach($alumniByGender as $key => $data)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $data->gender ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $data->total }} orang</td>
                    <td>{{ number_format(($data->total / $alumniByGender->sum('total')) * 100, 1) }}%</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="thead-light">
                <tr>
                    <th colspan="2">Total</th>
                    <th>{{ $alumniByGender->sum('total') }} orang</th>
                    <th>100%</th>
                </tr>
            </tfoot>
        </table>

        <!-- Analysis -->
        <div class="section-title">
            <i class="fas fa-chart-line"></i> ANALISIS DATA
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <h6>Tahun dengan Alumni Terbanyak:</h6>
                @php
                    $maxYear = $alumniByYear->sortByDesc('total')->first();
                @endphp
                @if($maxYear)
                <p>Tahun <strong>{{ $maxYear->graduation_year }}</strong> dengan <strong>{{ $maxYear->total }}</strong> alumni ({{ number_format(($maxYear->total / $alumniByYear->sum('total')) * 100, 1) }}%)</p>
                @endif
            </div>
            <div class="col-md-6">
                <h6>Distribusi Gender:</h6>
                @php
                    $maleCount = $alumniByGender->where('gender', 'Laki-laki')->first()->total ?? 0;
                    $femaleCount = $alumniByGender->where('gender', 'Perempuan')->first()->total ?? 0;
                    $total = $maleCount + $femaleCount;
                @endphp
                @if($total > 0)
                <p>
                    Laki-laki: {{ number_format(($maleCount / $total) * 100, 1) }}% | 
                    Perempuan: {{ number_format(($femaleCount / $total) * 100, 1) }}%
                </p>
                @endif
            </div>
        </div>

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