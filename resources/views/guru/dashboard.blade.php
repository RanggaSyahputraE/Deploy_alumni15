@extends('layouts.app')

@section('title', 'Dashboard Guru - Alumni15')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-chalkboard-teacher"></i> Dashboard Guru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('guru.profile.edit') }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-user-edit"></i> Edit Profil
            </a>
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

<!-- Profile Summary -->
@if($teacher)
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-id-card"></i> Profil Guru</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>Nama Lengkap:</strong></td>
                        <td>{{ $teacher->full_name }}</td>
                    </tr>
                    @if($teacher->nip)
                    <tr>
                        <td><strong>NIP:</strong></td>
                        <td>{{ $teacher->nip }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ Auth::user()->email }}</td>
                    </tr>
                    @if($teacher->phone_number)
                    <tr>
                        <td><strong>Telepon:</strong></td>
                        <td>{{ $teacher->phone_number }}</td>
                    </tr>
                    @endif
                </table>
                <a href="{{ route('guru.profile.edit') }}" class="btn btn-info btn-sm">
                    <i class="fas fa-edit"></i> Edit Profil
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="fas fa-chart-bar"></i> Statistik Cepat</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <h4 class="text-primary">{{ \App\Models\Alumni::count() }}</h4>
                        <small>Total Alumni</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-success">{{ \App\Models\News::where('user_id', Auth::id())->count() }}</h4>
                        <small>Berita Saya</small>
                    </div>
                </div>
                <div class="mt-3">
                    <a href="{{ route('guru.statistics') }}" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-chart-line"></i> Lihat Statistik Lengkap
                    </a>
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
                <div>
                    <a href="{{ route('news.create') }}" class="btn btn-sm btn-success">
                        <i class="fas fa-plus"></i> Buat Berita
                    </a>
                    <a href="{{ route('news.index') }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-arrow-right"></i> Lihat Semua
                    </a>
                </div>
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
                                    <a href="{{ route('news.show', $news->id) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i> Baca
                                    </a>
                                    @if($news->user_id == Auth::id())
                                        <a href="{{ route('news.edit', $news->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    @endif
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
                <a href="{{ route('guru.alumni.index') }}" class="btn btn-outline-primary btn-block">
                    <i class="fas fa-users"></i><br>Data Alumni
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('news.create') }}" class="btn btn-outline-success btn-block">
                    <i class="fas fa-plus"></i><br>Buat Berita
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('guru.statistics') }}" class="btn btn-outline-info btn-block">
                    <i class="fas fa-chart-bar"></i><br>Statistik
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('guru.rekapitulasi.index') }}" class="btn btn-outline-primary btn-block">
                    <i class="fas fa-chart-bar"></i><br>Rekapitulasi Alumni
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