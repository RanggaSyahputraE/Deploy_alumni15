@extends('layouts.app')

@section('title', 'Kelola Lowongan Pekerjaan - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-briefcase"></i> Kelola Lowongan Pekerjaan</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('admin.job-vacancies.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Tambah Lowongan
            </a>
        </div>
    </div>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.job-vacancies.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari lowongan..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="status">
                        <option value="">Semua Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.job-vacancies.index') }}" class="btn btn-secondary">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Job Vacancies List -->
<div class="row">
    @forelse($jobVacancies as $job)
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="card-body d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0">{{ $job->title }}</h5>
                    @if($job->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-secondary">Tidak Aktif</span>
                    @endif
                </div>
                
                <h6 class="text-muted mb-2">{{ $job->company_name }}</h6>
                
                <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($job->description), 120) }}</p>
                
                <div class="mb-2">
                    <small class="text-muted">
                        <i class="fas fa-map-marker-alt"></i> {{ $job->location ?? 'Lokasi tidak disebutkan' }}<br>
                        <i class="fas fa-money-bill-wave"></i> {{ $job->salary_range ?? 'Gaji tidak disebutkan' }}<br>
                        <i class="fas fa-calendar"></i> Deadline: {{ $job->deadline ? $job->deadline->format('d M Y') : 'Tidak ada deadline' }}
                    </small>
                </div>
                
                <div class="mt-auto">
                    <small class="text-muted">
                        <i class="fas fa-user"></i> {{ $job->user->name }} | 
                        <i class="fas fa-clock"></i> {{ $job->created_at->format('d M Y') }}
                    </small>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.job-vacancies.show', $job->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.job-vacancies.edit', $job->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.job-vacancies.destroy', $job->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirmDelete('Apakah Anda yakin ingin menghapus lowongan ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                <h5>Belum Ada Lowongan Pekerjaan</h5>
                <p class="text-muted">Belum ada lowongan pekerjaan yang dipublikasikan.</p>
                <a href="{{ route('admin.job-vacancies.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Lowongan Pertama
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($jobVacancies->hasPages())
<div class="d-flex justify-content-center">
    {{ $jobVacancies->links() }}
</div>
@endif
@endsection