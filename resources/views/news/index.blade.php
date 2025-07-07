@extends('layouts.app')

@section('title', 'Berita & Informasi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-newspaper"></i> Berita & Informasi</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        @if(Auth::user()->isAdmin() || Auth::user()->isGuru())
        <div class="btn-group mr-2">
            <a href="{{ route('news.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Buat Berita
            </a>
        </div>
        @endif
    </div>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('news.index') }}">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="search" placeholder="Cari berita..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('news.index') }}" class="btn btn-secondary">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- News List -->
<div class="row">
    @forelse($news as $item)
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card h-100 shadow-sm">
            @if($item->image_path)
                <img src="{{ asset('storage/' . $item->image_path) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
            @endif
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $item->title }}</h5>
                <p class="card-text flex-grow-1">{{ Str::limit(strip_tags($item->content), 150) }}</p>
                <div class="mt-auto">
                    <small class="text-muted">
                        <i class="fas fa-user"></i> {{ $item->user->name }} | 
                        <i class="fas fa-calendar"></i> {{ $item->created_at->format('d M Y') }}
                    </small>
                </div>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('news.show', $item->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i> Baca Selengkapnya
                    </a>
                    @if((Auth::user()->isAdmin()) || (Auth::user()->isGuru() && Auth::id() === $item->user_id))
                    <div class="btn-group" role="group">
                        <a href="{{ route('news.edit', $item->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('news.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirmDelete('Apakah Anda yakin ingin menghapus berita ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h5>Belum Ada Berita</h5>
                <p class="text-muted">Belum ada berita yang dipublikasikan.</p>
                @if(Auth::user()->isAdmin() || Auth::user()->isGuru())
                <a href="{{ route('news.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Berita Pertama
                </a>
                @endif
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($news->hasPages())
<div class="d-flex justify-content-center">
    {{ $news->links() }}
</div>
@endif
@endsection