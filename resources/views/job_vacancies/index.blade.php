@extends('layouts.app')

@section('title', 'Lowongan Pekerjaan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-briefcase"></i> Lowongan Pekerjaan</h1>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('job_vacancies.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" placeholder="Cari lowongan pekerjaan..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('job_vacancies.index') }}" class="btn btn-secondary">
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
                    @if($job->deadline && $job->deadline->isPast())
                        <span class="badge badge-danger">Berakhir</span>
                    @elseif($job->deadline && $job->deadline->diffInDays() <= 7)
                        <span class="badge badge-warning">Segera Berakhir</span>
                    @else
                        <span class="badge badge-success">Aktif</span>
                    @endif
                </div>
                
                <h6 class="text-muted mb-2">{{ $job->company_name }}</h6>
                
                <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($job->description), 120) }}</p>
                
                <div class="mb-2">
                    <small class="text-muted">
                        @if($job->location)
                        <i class="fas fa-map-marker-alt"></i> {{ $job->location }}<br>
                        @endif
                        @if($job->salary_range)
                        <i class="fas fa-money-bill-wave"></i> {{ $job->salary_range }}<br>
                        @endif
                        @if($job->deadline)
                        <i class="fas fa-calendar"></i> Deadline: {{ $job->deadline->format('d M Y') }}
                        @endif
                    </small>
                </div>
                
                <div class="mt-auto">
                    <small class="text-muted">
                        <i class="fas fa-clock"></i> {{ $job->created_at->diffForHumans() }}
                    </small>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('job_vacancies.show', $job->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
                @if($job->application_url)
                <a href="{{ $job->application_url }}" target="_blank" class="btn btn-success btn-sm">
                    <i class="fas fa-external-link-alt"></i> Lamar Sekarang
                </a>
                @endif
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                <h5>Belum Ada Lowongan Pekerjaan</h5>
                <p class="text-muted">Belum ada lowongan pekerjaan yang tersedia saat ini.</p>
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