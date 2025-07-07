@extends('layouts.app')

@section('title', 'Kelola Slider - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-images"></i> Kelola Slider</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Tambah Slider
            </a>
        </div>
    </div>
</div>

<!-- Sliders Grid -->
<div class="row">
    @forelse($sliders as $slider)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 shadow-sm">
            <div class="position-relative">
                <img src="{{ asset('storage/' . $slider->image_path) }}" class="card-img-top" alt="{{ $slider->title }}" style="height: 200px; object-fit: cover;">
                <div class="position-absolute" style="top: 10px; right: 10px;">
                    @if($slider->is_active)
                        <span class="badge badge-success">Aktif</span>
                    @else
                        <span class="badge badge-secondary">Tidak Aktif</span>
                    @endif
                </div>
                <div class="position-absolute" style="top: 10px; left: 10px;">
                    <span class="badge badge-primary">Urutan: {{ $slider->order }}</span>
                </div>
            </div>
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $slider->title }}</h5>
                @if($slider->description)
                <p class="card-text flex-grow-1">{{ Str::limit($slider->description, 100) }}</p>
                @endif
                @if($slider->link_url)
                <p class="card-text">
                    <small class="text-muted">
                        <i class="fas fa-link"></i> {{ Str::limit($slider->link_url, 40) }}
                    </small>
                </p>
                @endif
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="fas fa-calendar"></i> {{ $slider->created_at->format('d M Y') }}
                    </small>
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="return confirmDelete('Apakah Anda yakin ingin menghapus slider ini?')">
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
                <i class="fas fa-images fa-3x text-muted mb-3"></i>
                <h5>Belum Ada Slider</h5>
                <p class="text-muted">Belum ada slider yang dibuat.</p>
                <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Slider Pertama
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($sliders->hasPages())
<div class="d-flex justify-content-center">
    {{ $sliders->links() }}
</div>
@endif
@endsection