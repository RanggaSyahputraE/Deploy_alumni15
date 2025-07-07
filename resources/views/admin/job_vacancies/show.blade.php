@extends('layouts.app')

@section('title', 'Detail Lowongan Pekerjaan - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-briefcase"></i> Detail Lowongan Pekerjaan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('admin.job-vacancies.edit', $jobVacancy->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.job-vacancies.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h2 class="card-title">{{ $jobVacancy->title }}</h2>
                        <h5 class="text-muted">{{ $jobVacancy->company_name }}</h5>
                    </div>
                    @if($jobVacancy->is_active)
                        <span class="badge badge-success badge-lg">Aktif</span>
                    @else
                        <span class="badge badge-secondary badge-lg">Tidak Aktif</span>
                    @endif
                </div>
                
                <div class="row mb-3">
                    @if($jobVacancy->location)
                    <div class="col-md-6">
                        <p><i class="fas fa-map-marker-alt text-primary"></i> <strong>Lokasi:</strong> {{ $jobVacancy->location }}</p>
                    </div>
                    @endif
                    @if($jobVacancy->salary_range)
                    <div class="col-md-6">
                        <p><i class="fas fa-money-bill-wave text-success"></i> <strong>Gaji:</strong> {{ $jobVacancy->salary_range }}</p>
                    </div>
                    @endif
                </div>
                
                @if($jobVacancy->deadline)
                <div class="alert alert-info">
                    <i class="fas fa-calendar-alt"></i> <strong>Deadline Lamaran:</strong> {{ $jobVacancy->deadline->format('d F Y') }}
                    @if($jobVacancy->deadline->isPast())
                        <span class="badge badge-danger ml-2">Sudah Berakhir</span>
                    @else
                        <span class="badge badge-warning ml-2">{{ $jobVacancy->deadline->diffForHumans() }}</span>
                    @endif
                </div>
                @endif
                
                <h5><i class="fas fa-align-left"></i> Deskripsi Pekerjaan</h5>
                <div class="content mb-4">
                    {!! nl2br(e($jobVacancy->description)) !!}
                </div>
                
                @if($jobVacancy->requirements)
                <h5><i class="fas fa-list-ul"></i> Persyaratan</h5>
                <div class="content mb-4">
                    {!! nl2br(e($jobVacancy->requirements)) !!}
                </div>
                @endif
            </div>
            
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.job-vacancies.edit', $jobVacancy->id) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Lowongan
                    </a>
                    <form action="{{ route('admin.job-vacancies.destroy', $jobVacancy->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirmDelete('Apakah Anda yakin ingin menghapus lowongan ini?')">
                            <i class="fas fa-trash"></i> Hapus Lowongan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Contact Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-address-book"></i> Informasi Kontak</h6>
            </div>
            <div class="card-body">
                @if($jobVacancy->contact_email)
                <p class="mb-2">
                    <i class="fas fa-envelope text-primary"></i> 
                    <a href="mailto:{{ $jobVacancy->contact_email }}">{{ $jobVacancy->contact_email }}</a>
                </p>
                @endif
                
                @if($jobVacancy->contact_phone)
                <p class="mb-2">
                    <i class="fas fa-phone text-success"></i> 
                    <a href="tel:{{ $jobVacancy->contact_phone }}">{{ $jobVacancy->contact_phone }}</a>
                </p>
                @endif
                
                @if($jobVacancy->application_url)
                <p class="mb-0">
                    <i class="fas fa-link text-info"></i> 
                    <a href="{{ $jobVacancy->application_url }}" target="_blank">Link Lamaran</a>
                </p>
                @endif
                
                @if(!$jobVacancy->contact_email && !$jobVacancy->contact_phone && !$jobVacancy->application_url)
                <p class="text-muted">Tidak ada informasi kontak.</p>
                @endif
            </div>
        </div>

        <!-- Publisher Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-user"></i> Dipublikasikan Oleh</h6>
            </div>
            <div class="card-body text-center">
                <img src="{{ $jobVacancy->user->profile_photo_path ? asset('storage/' . $jobVacancy->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                     alt="Profile" class="rounded-circle mb-2" style="width: 60px; height: 60px; object-fit: cover;">
                <h6>{{ $jobVacancy->user->name }}</h6>
                <p class="text-muted small">
                    @if($jobVacancy->user->isAdmin())
                        Administrator
                    @elseif($jobVacancy->user->isGuru())
                        Guru SMPN 15
                    @endif
                </p>
                <small class="text-muted">
                    <i class="fas fa-calendar"></i> {{ $jobVacancy->created_at->format('d F Y, H:i') }} WIB
                    @if($jobVacancy->updated_at != $jobVacancy->created_at)
                    <br><i class="fas fa-edit"></i> Diperbarui: {{ $jobVacancy->updated_at->format('d F Y, H:i') }} WIB
                    @endif
                </small>
            </div>
        </div>

        <!-- Recent Job Vacancies -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-clock"></i> Lowongan Terbaru</h6>
            </div>
            <div class="card-body">
                @php
                    $recentJobs = \App\Models\JobVacancy::where('id', '!=', $jobVacancy->id)
                                                       ->where('is_active', true)
                                                       ->orderBy('created_at', 'desc')
                                                       ->take(3)
                                                       ->get();
                @endphp
                
                @forelse($recentJobs as $recent)
                <div class="mb-3">
                    <h6 class="mb-1">
                        <a href="{{ route('admin.job-vacancies.show', $recent->id) }}" class="text-decoration-none">
                            {{ Str::limit($recent->title, 40) }}
                        </a>
                    </h6>
                    <p class="text-muted small mb-1">{{ $recent->company_name }}</p>
                    <small class="text-muted">{{ $recent->created_at->diffForHumans() }}</small>
                </div>
                @if(!$loop->last)<hr>@endif
                @empty
                <p class="text-muted">Tidak ada lowongan lain.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .content {
        line-height: 1.8;
        font-size: 16px;
    }
    .content p {
        margin-bottom: 1rem;
    }
    .badge-lg {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
</style>
@endpush