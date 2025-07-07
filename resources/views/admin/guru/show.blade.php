@extends('layouts.app')

@section('title', 'Detail Guru - Admin')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-chalkboard-teacher"></i> Detail Guru: {{ $teacher->full_name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
            <a href="{{ route('admin.guru.edit', $teacher->id) }}" class="btn btn-sm btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.guru.index') }}" class="btn btn-sm btn-outline-secondary">
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
                <img src="{{ $teacher->user->profile_photo_path ? asset('storage/' . $teacher->user->profile_photo_path) : asset('images/default_profile.png') }}" 
                     alt="Profile" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="card-title">{{ $teacher->full_name }}</h5>
                <p class="text-muted">{{ $teacher->subject ?? 'Guru SMPN 15' }}</p>
                
                <div class="mt-3">
                    @if($teacher->user->is_active)
                        <span class="badge badge-success badge-lg">
                            <i class="fas fa-check-circle"></i> Status Aktif
                        </span>
                    @else
                        <span class="badge badge-secondary badge-lg">
                            <i class="fas fa-times-circle"></i> Tidak Aktif
                        </span>
                    @endif
                </div>
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
                                <td>{{ $teacher->full_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>NIP:</strong></td>
                                <td>{{ $teacher->nip ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Mata Pelajaran:</strong></td>
                                <td>{{ $teacher->subject ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Email:</strong></td>
                                <td>{{ $teacher->user->email }}</td>
                            </tr>
                            <tr>
                                <td><strong>Telepon:</strong></td>
                                <td>{{ $teacher->phone_number ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if($teacher->user->is_active)
                                        <span class="badge badge-success">Aktif</span>
                                    @else
                                        <span class="badge badge-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if($teacher->address)
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Alamat:</strong></td>
                                <td>{{ $teacher->address }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Account Information -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-cog"></i> Informasi Akun</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Username:</strong></td>
                                <td>{{ $teacher->user->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Terdaftar:</strong></td>
                                <td>{{ $teacher->user->created_at->format('d F Y, H:i') }} WIB</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Terakhir Update:</strong></td>
                                <td>{{ $teacher->updated_at->format('d F Y, H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <td><strong>Role:</strong></td>
                                <td><span class="badge badge-info">Guru</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .badge-lg {
        font-size: 0.9em;
        padding: 0.5em 0.75em;
    }
</style>
@endpush