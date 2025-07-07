@extends('layouts.app')

@section('title', 'Dashboard Alumni - Alumni15')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-graduation-cap"></i> Dashboard Alumni</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('alumni.profile.edit') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-user-edit"></i> Edit Profil
            </a>
        </div>
    </div>
</div>

<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card bg-primary text-white shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h4><i class="fas fa-hand-wave"></i> Selamat Datang, {{ $alumni->full_name ?? Auth::user()->name }}!</h4>
                        <p class="mb-0">Selamat datang di Sistem Informasi Alumni SMPN 15 Pekanbaru. Kelola profil Anda, cari teman alumni, dan dapatkan informasi terbaru dari sekolah.</p>
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

<!-- Profile Summary -->
@if($alumni)
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-user"></i> Profil Singkat</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama Lengkap:</strong></td>
                        <td>{{ $alumni->full_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tahun Kelulusan:</strong></td>
                        <td>{{ $alumni->graduation_year }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                    @if($alumni->phone_number)
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td>{{ $alumni->phone_number }}</td>
                    </tr>
                    @endif
                </table>
                <a href="{{ route('alumni.profile.edit') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-edit"></i> Lengkapi Profil
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-chart-pie"></i> Statistik Profil</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-primary">{{ $alumni->educations->count() }}</h4>
                        <small>Riwayat Pendidikan</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-success">{{ $alumni->works->count() }}</h4>
                        <small>Riwayat Pekerjaan</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-info">{{ $alumni->graduation_year }}</h4>
                        <small>Angkatan</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Latest News -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-newspaper"></i> Berita Terbaru</h5>
                <a href="{{ route('alumni.news.index') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-arrow-right"></i> Lihat Semua
                </a>
            </div>
            <div class="card-body">
                @if($latestNews->isNotEmpty())
                    <div class="row">
                        @foreach($latestNews->take(3) as $news)
                        <div class="col-md-4 mb-3">
                            <div class="card h-100">
                                @if($news->image_path)
                                    <img src="{{ asset('storage/' . $news->image_path) }}" class="card-img-top" alt="{{ $news->title }}" style="height: 150px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">{{ Str::limit($news->title, 50) }}</h6>
                                    <p class="card-text small">{{ Str::limit(strip_tags($news->content), 80) }}</p>
                                    <small class="text-muted">{{ $news->created_at->diffForHumans() }}</small>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('alumni.news.show', $news->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Baca
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada berita terbaru.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <h3><i class="fas fa-bolt"></i> Menu Cepat</h3>
        <div class="row">
            <div class="col-md-3 mb-3">
                <a href="{{ route('alumni.profile.edit') }}" class="btn btn-outline-primary btn-block">
                    <i class="fas fa-user-edit"></i><br>Edit Profil
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('alumni.search') }}" class="btn btn-outline-success btn-block">
                    <i class="fas fa-search"></i><br>Cari Alumni
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('alumni.news.index') }}" class="btn btn-outline-info btn-block">
                    <i class="fas fa-newspaper"></i><br>Baca Berita
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('job_vacancies.index') }}" class="btn btn-outline-warning btn-block">
                    <i class="fas fa-briefcase"></i><br>Lowongan Kerja
                </a>
            </div>
        </div>
    </div>
</div>
@endsection