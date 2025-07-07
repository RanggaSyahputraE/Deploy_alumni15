@extends('layouts.app')

@section('title', 'Profil Alumni - ' . $alumni->full_name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user"></i> Profil Alumni</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('alumni.search') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali ke Pencarian
        </a>
    </div>
</div>

<div class="row">
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ $alumni->user->profile_photo_path ? asset('storage/' . $alumni->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                     alt="Profile" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="card-title">{{ $alumni->full_name }}</h5>
                <p class="text-muted">Alumni {{ $alumni->graduation_year }}</p>
                
                @if($alumni->social_media_facebook || $alumni->social_media_instagram || $alumni->social_media_linkedin)
                <div class="social-links mt-3">
                    @if($alumni->social_media_facebook)
                        <a href="{{ $alumni->social_media_facebook }}" target="_blank" class="btn btn-sm btn-outline-primary mr-1">
                            <i class="fab fa-facebook"></i>
                        </a>
                    @endif
                    @if($alumni->social_media_instagram)
                        <a href="{{ $alumni->social_media_instagram }}" target="_blank" class="btn btn-sm btn-outline-danger mr-1">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                    @if($alumni->social_media_linkedin)
                        <a href="{{ $alumni->social_media_linkedin }}" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Detail Information -->
    <div class="col-md-8">
        <!-- Basic Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informasi Dasar</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nama Lengkap:</strong></td>
                                <td>{{ $alumni->full_name }}</td>
                            </tr>
                            @if($alumni->gender)
                            <tr>
                                <td><strong>Jenis Kelamin:</strong></td>
                                <td>{{ $alumni->gender }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>Tahun Kelulusan:</strong></td>
                                <td>{{ $alumni->graduation_year }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            @if($alumni->place_of_birth)
                            <tr>
                                <td><strong>Tempat Lahir:</strong></td>
                                <td>{{ $alumni->place_of_birth }}</td>
                            </tr>
                            @endif
                            @if($alumni->date_of_birth)
                            <tr>
                                <td><strong>Tanggal Lahir:</strong></td>
                                <td>{{ $alumni->date_of_birth->format('d F Y') }}</td>
                            </tr>
                            @endif
                            @if($alumni->phone_number)
                            <tr>
                                <td><strong>Telepon:</strong></td>
                                <td>{{ $alumni->phone_number }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
                
                @if($alumni->address)
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Alamat:</strong></td>
                                <td>{{ $alumni->address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Education History (Public View) -->
        @if($alumni->educations->isNotEmpty())
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> Riwayat Pendidikan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Institusi</th>
                                <th>Jenjang</th>
                                <th>Jurusan</th>
                                <th>Tahun</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumni->educations as $education)
                            <tr>
                                <td>{{ $education->institution_name }}</td>
                                <td>{{ $education->degree ?? '-' }}</td>
                                <td>{{ $education->major ?? '-' }}</td>
                                <td>{{ $education->start_year }} - {{ $education->end_year ?? 'Sekarang' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Work History (Public View) -->
        @if($alumni->works->isNotEmpty())
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-briefcase"></i> Riwayat Pekerjaan</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Perusahaan</th>
                                <th>Posisi</th>
                                <th>Periode</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($alumni->works as $work)
                            <tr>
                                <td>{{ $work->company_name }}</td>
                                <td>{{ $work->position ?? '-' }}</td>
                                <td>
                                    {{ $work->start_date ? $work->start_date->format('M Y') : '-' }} - 
                                    {{ $work->end_date ? $work->end_date->format('M Y') : 'Sekarang' }}
                                </td>
                                <td>
                                    @if($work->is_current)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection