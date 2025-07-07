@extends('layouts.app')

@section('title', 'Statistik Alumni - Guru')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-chart-bar"></i> Statistik Alumni</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-download"></i> Export
            </button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ route('guru.statistics.export', 'excel') }}">
                    <i class="fas fa-file-excel"></i> Excel
                </a>
                <a class="dropdown-item" href="{{ route('guru.statistics.export', 'pdf') }}">
                    <i class="fas fa-file-pdf"></i> PDF
                </a>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="printPage()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Alumni</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $alumniByYear->sum('total') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Alumni Laki-laki</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $alumniByGender->where('gender', 'Laki-laki')->first()->total ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-mars fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Alumni Perempuan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $alumniByGender->where('gender', 'Perempuan')->first()->total ?? 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-venus fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Tahun Aktif</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $alumniByYear->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
<div class="row">
    <!-- Alumni by Year Chart -->
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-line"></i> Alumni Berdasarkan Tahun Kelulusan
                </h6>
            </div>
            <div class="card-body">
                <canvas id="alumniByYearChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Alumni by Gender Chart -->
    <div class="col-lg-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-chart-pie"></i> Alumni Berdasarkan Jenis Kelamin
                </h6>
            </div>
            <div class="card-body">
                <canvas id="alumniByGenderChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Data Tables -->
<div class="row">
    <!-- Alumni by Year Table -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table"></i> Data Alumni per Tahun
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Tahun Kelulusan</th>
                                <th>Jumlah Alumni</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumniByYear as $data)
                            <tr>
                                <td>{{ $data->graduation_year }}</td>
                                <td>{{ $data->total }}</td>
                                <td>{{ number_format(($data->total / $alumniByYear->sum('total')) * 100, 1) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td>Total</td>
                                <td>{{ $alumniByYear->sum('total') }}</td>
                                <td>100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Alumni by Gender Table -->
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-table"></i> Data Alumni per Jenis Kelamin
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <th>Jumlah Alumni</th>
                                <th>Persentase</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumniByGender as $data)
                            <tr>
                                <td>{{ $data->gender ?? 'Tidak Diketahui' }}</td>
                                <td>{{ $data->total }}</td>
                                <td>{{ number_format(($data->total / $alumniByGender->sum('total')) * 100, 1) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td>Total</td>
                                <td>{{ $alumniByGender->sum('total') }}</td>
                                <td>100%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .border-left-primary {
        border-left: 0.25rem solid #4e73df !important;
    }
    .border-left-success {
        border-left: 0.25rem solid #1cc88a !important;
    }
    .border-left-info {
        border-left: 0.25rem solid #36b9cc !important;
    }
    .border-left-warning {
        border-left: 0.25rem solid #f6c23e !important;
    }
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Alumni by Year Chart
    const alumniByYearCtx = document.getElementById('alumniByYearChart').getContext('2d');
    const alumniByYearChart = new Chart(alumniByYearCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode($alumniByYear->pluck('graduation_year')) !!},
            datasets: [{
                label: 'Jumlah Alumni',
                data: {!! json_encode($alumniByYear->pluck('total')) !!},
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Alumni by Gender Chart
    const alumniByGenderCtx = document.getElementById('alumniByGenderChart').getContext('2d');
    const alumniByGenderChart = new Chart(alumniByGenderCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($alumniByGender->pluck('gender')) !!},
            datasets: [{
                data: {!! json_encode($alumniByGender->pluck('total')) !!},
                backgroundColor: [
                    '#4e73df',
                    '#e91e63',
                    '#36b9cc'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endpush