@extends('layouts.app')

@section('title', 'Pencarian Alumni')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-search"></i> Pencarian Alumni</h1>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('alumni.search') }}">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari nama alumni..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="gender">
                        <option value="">Semua Gender</option>
                        <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" name="graduation_year">
                        <option value="">Semua Tahun</option>
                        @for($year = date('Y'); $year >= 1990; $year--)
                            <option value="{{ $year }}" {{ request('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('alumni.search') }}" class="btn btn-secondary">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(request()->hasAny(['search', 'gender', 'graduation_year']))
<!-- Search Results -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <i class="fas fa-users"></i> Hasil Pencarian 
            @if($alumni->total() > 0)
                ({{ $alumni->total() }} alumni ditemukan)
            @endif
        </h5>
    </div>
    <div class="card-body">
        @if($alumni->count() > 0)
            <div class="row">
                @foreach($alumni as $item)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <img src="{{ $item->user->profile_photo_path ? asset('storage/' . $item->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                                 alt="Profile" class="rounded-circle mb-3" style="width: 80px; height: 80px; object-fit: cover;">
                            <h6 class="card-title">{{ $item->full_name }}</h6>
                            <p class="text-muted small">Alumni {{ $item->graduation_year }}</p>
                            @if($item->gender)
                                <span class="badge badge-{{ $item->gender == 'Laki-laki' ? 'primary' : 'pink' }} mb-2">{{ $item->gender }}</span>
                            @endif
                            
                            <!-- Contact Info (Limited for Alumni) -->
                            @if($item->phone_number)
                            <p class="small mb-1">
                                <i class="fas fa-phone text-success"></i> {{ $item->phone_number }}
                            </p>
                            @endif
                            
                            <!-- Social Media -->
                            @if($item->social_media_facebook || $item->social_media_instagram || $item->social_media_linkedin)
                            <div class="social-links mt-2">
                                @if($item->social_media_facebook)
                                    <a href="{{ $item->social_media_facebook }}" target="_blank" class="btn btn-sm btn-outline-primary mr-1">
                                        <i class="fab fa-facebook"></i>
                                    </a>
                                @endif
                                @if($item->social_media_instagram)
                                    <a href="{{ $item->social_media_instagram }}" target="_blank" class="btn btn-sm btn-outline-danger mr-1">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                                @if($item->social_media_linkedin)
                                    <a href="{{ $item->social_media_linkedin }}" target="_blank" class="btn btn-sm btn-outline-info">
                                        <i class="fab fa-linkedin"></i>
                                    </a>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent text-center">
                            <a href="{{ route('alumni.view.detail', $item->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-eye"></i> Lihat Profil
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $alumni->links() }}
            </div>
        @else
            <div class="text-center">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h5>Tidak Ada Alumni Ditemukan</h5>
                <p class="text-muted">Coba ubah kata kunci pencarian atau filter yang digunakan.</p>
            </div>
        @endif
    </div>
</div>
@else
<!-- Initial State -->
<div class="card">
    <div class="card-body text-center">
        <i class="fas fa-search fa-3x text-muted mb-3"></i>
        <h5>Cari Alumni SMPN 15</h5>
        <p class="text-muted">Gunakan form pencarian di atas untuk menemukan alumni berdasarkan nama, jenis kelamin, atau tahun kelulusan.</p>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
    .badge-pink {
        background-color: #e91e63;
        color: white;
    }
</style>
@endpush