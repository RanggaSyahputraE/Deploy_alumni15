@extends('layouts.app')

@section('title', 'Kelola Alumni - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-users"></i> Kelola Data Alumni</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('admin.alumni.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Tambah Alumni
            </a>

            <button type="button" class="btn btn-sm btn-outline-secondary" onclick="printPage()">
                <i class="fas fa-print"></i> Print
            </button>
        </div>
    </div>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.alumni.index') }}">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="search" placeholder="Cari nama..." value="{{ request('search') }}">
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
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.alumni.index') }}" class="btn btn-secondary">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Alumni Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Tahun Lulus</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alumni as $key => $item)
                    <tr>
                        <td>{{ $alumni->firstItem() + $key }}</td>
                        <td>
                            <img src="{{ $item->user->profile_photo_path ? asset('storage/' . $item->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                                 alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        </td>
                        <td>{{ $item->full_name }}</td>
                        <td>{{ $item->user->email }}</td>
                        <td>
                            @if($item->gender == 'Laki-laki')
                                <span class="badge badge-primary">{{ $item->gender }}</span>
                            @elseif($item->gender == 'Perempuan')
                                <span class="badge badge-pink">{{ $item->gender }}</span>
                            @else
                                <span class="badge badge-secondary">-</span>
                            @endif
                        </td>
                        <td>{{ $item->graduation_year }}</td>
                        <td>{{ $item->phone_number ?? '-' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.alumni.show', $item->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.alumni.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.alumni.print', $item->id) }}" class="btn btn-sm btn-secondary" title="Print" target="_blank">
                                    <i class="fas fa-print"></i>
                                </a>
                                <form action="{{ route('admin.alumni.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus" 
                                            onclick="return confirmDelete('Apakah Anda yakin ingin menghapus data alumni ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data alumni ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $alumni->links() }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-pink {
        background-color: #e91e63;
        color: white;
    }
</style>
@endpush