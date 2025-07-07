@extends('layouts.app')

@section('title', 'Rekapitulasi Alumni - guru')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-chart-bar"></i> Rekapitulasi Data Alumni</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('guru.dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Alumni</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAlumni }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Tahun Kelulusan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $rekapitulasi->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Rata-rata per Tahun</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $rekapitulasi->count() > 0 ? round($totalAlumni / $rekapitulasi->count()) : 0 }}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calculator fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rekapitulasi Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-table"></i> Rekapitulasi Alumni Berdasarkan Tahun Kelulusan
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-dark">
                    <tr>
                        <th width="10%">No</th>
                        <th width="25%">Tahun Kelulusan</th>
                        <th width="20%">Jumlah Alumni</th>
                        <th width="20%">Persentase</th>
                        <th width="25%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapitulasi as $key => $item)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        <td class="text-center">
                            <span class="badge badge-primary badge-lg">{{ $item->graduation_year }}</span>
                        </td>
                        <td class="text-center">
                            <strong>{{ $item->total_alumni }}</strong> orang
                        </td>
                        <td class="text-center">
                            {{ $totalAlumni > 0 ? round(($item->total_alumni / $totalAlumni) * 100, 1) : 0 }}%
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('guru.rekapitulasi.detail', $item->graduation_year) }}" 
                                   class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('guru.rekapitulasi.print', $item->graduation_year) }}" 
                                   class="btn btn-sm btn-secondary" title="Print" target="_blank">
                                    <i class="fas fa-print"></i> Print
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data alumni ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
    .text-gray-800 {
        color: #5a5c69 !important;
    }
    .text-gray-300 {
        color: #dddfeb !important;
    }
    .badge-lg {
        font-size: 1rem;
        padding: 0.5rem 0.75rem;
    }
</style>
@endpush