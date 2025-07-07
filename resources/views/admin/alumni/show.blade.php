@extends('layouts.app')

@section('title', 'Detail Alumni - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user"></i> Detail Alumni: {{ $alumni->full_name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('admin.alumni.edit', $alumni->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.alumni.print', $alumni->id) }}" class="btn btn-sm btn-secondary" target="_blank">
                <i class="fas fa-print"></i> Print
            </a>
            <a href="{{ route('admin.alumni.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
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
        <!-- Personal Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user"></i> Informasi Pribadi</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Nama Lengkap:</strong></td>
                                <td>{{ $alumni->full_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tempat Lahir:</strong></td>
                                <td>{{ $alumni->place_of_birth ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal Lahir:</strong></td>
                                <td>{{ $alumni->date_of_birth ? $alumni->date_of_birth->format('d F Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Jenis Kelamin:</strong></td>
                                <td>{{ $alumni->gender ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $alumni->user->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon:</strong></td>
                                <td>{{ $alumni->phone_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tahun Kelulusan:</strong></td>
                                <td>{{ $alumni->graduation_year }}</td>
                            </tr>
                            <tr>
                                <td><strong>Alamat:</strong></td>
                                <td>{{ $alumni->address ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Education History -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-graduation-cap"></i> Riwayat Pendidikan</h5>
            </div>
            <div class="card-body">
                @if($alumni->educations->isNotEmpty())
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
                @else
                    <p class="text-muted">Belum ada data riwayat pendidikan.</p>
                @endif
            </div>
        </div>

        <!-- Work History -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-briefcase"></i> Riwayat Pekerjaan</h5>
            </div>
            <div class="card-body">
                @if($alumni->works->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Perusahaan</th>
                                    <th>Posisi</th>
                                    <th>Deskripsi</th>
                                    <th>Periode</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alumni->works as $work)
                                <tr>
                                    <td>{{ $work->company_name }}</td>
                                    <td>{{ $work->position ?? '-' }}</td>
                                    <td>{{ Str::limit($work->description, 50) ?? '-' }}</td>
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
                @else
                    <p class="text-muted">Belum ada data riwayat pekerjaan.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection