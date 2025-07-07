@extends('layouts.app')

@section('title', 'Kelola Guru - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-chalkboard-teacher"></i> Kelola Data Guru</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('admin.guru.create') }}" class="btn btn-sm btn-success">
                <i class="fas fa-plus"></i> Tambah Guru
            </a>
        </div>
    </div>
</div>

<!-- Search Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.guru.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Cari nama guru..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i> Cari
                    </button>
                    <a href="{{ route('admin.guru.index') }}" class="btn btn-secondary">
                        <i class="fas fa-refresh"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Guru Table -->
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
                        <th>NIP</th>
                        <th>Mata Pelajaran</th>
                        <th>Telepon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $key => $teacher)
                    <tr>
                        <td>{{ $teachers->firstItem() + $key }}</td>
                        <td>
                            <img src="{{ $teacher->user->profile_photo_path ? asset('storage/' . $teacher->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                                 alt="Profile" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        </td>
                        <td>{{ $teacher->full_name }}</td>
                        <td>{{ $teacher->user->email }}</td>
                        <td>{{ $teacher->nip ?? '-' }}</td>
                        <td>{{ $teacher->subject ?? '-' }}</td>
                        <td>{{ $teacher->phone_number ?? '-' }}</td>
                        <td>
                            @if($teacher->user->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-secondary">Tidak Aktif</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.guru.show', $teacher->id) }}" class="btn btn-sm btn-info" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.guru.edit', $teacher->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.guru.destroy', $teacher->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus" 
                                            onclick="return confirmDelete('Apakah Anda yakin ingin menghapus data guru ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada data guru ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $teachers->links() }}
        </div>
    </div>
</div>
@endsection