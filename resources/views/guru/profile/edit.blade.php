@extends('layouts.app')

@section('title', 'Edit Profil - Guru')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user-edit"></i> Edit Profil Guru</h1>
</div>

<div class="row">
    <div class="col-md-4">
        <!-- Profile Photo Card -->
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ Auth::user()->profile_photo_path ? asset('storage/' . Auth::user()->profile_photo_path) : asset('images/default_profile.png') }}" 
                     alt="Profile Photo" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" id="profile-preview">
                <h5>{{ Auth::user()->teacher->full_name ?? Auth::user()->name }}</h5>
                <p class="text-muted">{{ Auth::user()->teacher->subject ?? 'Guru SMPN 15' }}</p>
                
                <!-- Upload Photo Form -->
                <form action="{{ route('guru.profile.update') }}" method="POST" enctype="multipart/form-data" id="photo-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="photo">
                    
                    <div class="form-group">
                        <label for="profile_photo" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-camera"></i> Ganti Foto
                        </label>
                        <input type="file" class="d-none" id="profile_photo" name="profile_photo" accept="image/*">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <!-- Profile Information Form -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-user"></i> Informasi Profil</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('guru.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="profile">
                    
                    <!-- Data User -->
                    <h6 class="text-primary"><i class="fas fa-user"></i> Data Akun</h6>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><i class="fas fa-user"></i> Nama Pengguna <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Data Guru -->
                    <h6 class="text-success mt-4"><i class="fas fa-chalkboard-teacher"></i> Data Guru</h6>
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name"><i class="fas fa-id-card"></i> Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror" 
                                       id="full_name" name="full_name" value="{{ old('full_name', Auth::user()->teacher->full_name ?? '') }}" required>
                                @error('full_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nip"><i class="fas fa-id-badge"></i> NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" 
                                       id="nip" name="nip" value="{{ old('nip', Auth::user()->teacher->nip ?? '') }}">
                                @error('nip')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subject"><i class="fas fa-book"></i> Mata Pelajaran</label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                       id="subject" name="subject" value="{{ old('subject', Auth::user()->teacher->subject ?? '') }}">
                                @error('subject')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone_number"><i class="fas fa-phone"></i> Nomor Telepon</label>
                                <input type="text" class="form-control @error('phone_number') is-invalid @enderror" 
                                       id="phone_number" name="phone_number" value="{{ old('phone_number', Auth::user()->teacher->phone_number ?? '') }}">
                                @error('phone_number')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="address"><i class="fas fa-home"></i> Alamat</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address', Auth::user()->teacher->address ?? '') }}</textarea>
                        @error('address')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Change Password Form -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-lock"></i> Ganti Password</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('guru.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_type" value="password">
                    
                    <div class="form-group">
                        <label for="current_password"><i class="fas fa-key"></i> Password Saat Ini <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" name="current_password" required>
                        @error('current_password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock"></i> Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation"><i class="fas fa-lock"></i> Konfirmasi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-key"></i> Ganti Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview profile photo before upload
    document.getElementById('profile_photo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
                // Auto submit the form
                document.getElementById('photo-form').submit();
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush