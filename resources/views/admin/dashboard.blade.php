@extends('layouts.app')

@section('title', 'Dashboard Admin - Alumni15')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-tachometer-alt"></i> Dashboard Admin</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="printPage()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-info text-white shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4><i class="fas fa-hand-wave"></i> Selamat Datang, {{ $teacher->full_name ?? Auth::user()->name }}!</h4>
                        <p class="mb-0">Selamat datang di Sistem Informasi Alumni SMPN 15 Pekanbaru. Kelola data alumni, buat berita, dan pantau perkembangan alumni.</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('images/default_profile.png') }}" 
                             alt="Profile" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2 card-stats">
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
                <div class="mt-2">
                    <a href="{{ route('admin.alumni.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2 card-stats">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Guru</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalGuru }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <a href="{{ route('admin.guru.index') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-arrow-right"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2 card-stats">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Berita</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalBerita }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-newspaper fa-2x text-gray-300"></i>
                    </div>
                </div>
                <div class="mt-2">
                    <a href="{{ route('news.index') }}" class="btn btn-info btn-sm">
                        <i class="fas fa-arrow-right"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>


<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <h3><i class="fas fa-bolt"></i> Aksi Cepat</h3>
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.alumni.create') }}" class="btn btn-outline-primary btn-block">
                    <i class="fas fa-user-plus"></i><br>Tambah Alumni
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.guru.create') }}" class="btn btn-outline-success btn-block">
                    <i class="fas fa-chalkboard-teacher"></i><br>Tambah Guru
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('news.create') }}" class="btn btn-outline-info btn-block">
                    <i class="fas fa-plus"></i><br>Buat Berita
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.statistics') }}" class="btn btn-outline-warning btn-block">
                    <i class="fas fa-chart-bar"></i><br>Lihat Statistik
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('admin.rekapitulasi.index') }}" class="btn btn-outline-primary btn-block">
                    <i class="fas fa-chart-bar"></i><br>Rekapitulasi Alumni
                </a>
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
<script>
    $(document).ready(function(){
        $('.carousel').carousel({
            interval: 5000
        });
    });
</script>
@endpush