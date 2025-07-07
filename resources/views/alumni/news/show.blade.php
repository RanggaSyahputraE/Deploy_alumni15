@extends('layouts.app')

@section('title', $news->title . ' - Alumni')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-newspaper"></i> Detail Berita</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('alumni.news.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <article class="card">
            @if($news->image_path)
            <img src="{{ asset('storage/' . $news->image_path) }}" class="card-img-top" alt="{{ $news->title }}" style="height: 400px; object-fit: cover;">
            @endif
            <div class="card-body">
                <h1 class="card-title">{{ $news->title }}</h1>
                
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="fas fa-user"></i> Oleh: {{ $news->user->name }} | 
                        <i class="fas fa-calendar"></i> {{ $news->created_at->format('d F Y, H:i') }} WIB
                        @if($news->updated_at != $news->created_at)
                        | <i class="fas fa-edit"></i> Diperbarui: {{ $news->updated_at->format('d F Y, H:i') }} WIB
                        @endif
                    </small>
                </div>
                
                <div class="content">
                    {!! nl2br(e($news->content)) !!}
                </div>
            </div>
        </article>
    </div>
    
    <div class="col-lg-4">
        <!-- Author Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-user"></i> Penulis</h6>
            </div>
            <div class="card-body text-center">
                <img src="{{ $news->user->profile_photo_path ? asset('storage/' . $news->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                     alt="Profile" class="rounded-circle mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                <h6>{{ $news->user->name }}</h6>
                <p class="text-muted small">
                    @if($news->user->isAdmin())
                        Administrator
                    @elseif($news->user->isGuru())
                        Guru SMPN 15
                    @endif
                </p>
            </div>
        </div>

        <!-- Recent News -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="fas fa-clock"></i> Berita Terbaru</h6>
            </div>
            <div class="card-body">
                @php
                    $recentNews = \App\Models\News::where('id', '!=', $news->id)
                                                 ->orderBy('created_at', 'desc')
                                                 ->take(5)
                                                 ->get();
                @endphp
                
                @forelse($recentNews as $recent)
                <div class="media mb-3">
                    @if($recent->image_path)
                    <img src="{{ asset('storage/' . $recent->image_path) }}" class="mr-3" alt="{{ $recent->title }}" style="width: 60px; height: 60px; object-fit: cover;">
                    @else
                    <div class="mr-3 bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-newspaper text-muted"></i>
                    </div>
                    @endif
                    <div class="media-body">
                        <h6 class="mt-0 mb-1">
                            <a href="{{ route('alumni.news.show', $recent->id) }}" class="text-decoration-none">
                                {{ Str::limit($recent->title, 50) }}
                            </a>
                        </h6>
                        <small class="text-muted">{{ $recent->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @empty
                <p class="text-muted">Tidak ada berita lain.</p>
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
</style>
@endpush